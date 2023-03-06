<?php

namespace App\Http\Controllers\Courrier;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrCoordonnee;
use App\Models\Courrier\CrCourrier;
use App\Models\Courrier\CrCourrierEntrant;
use App\Models\Courrier\CrCourrierEtape;
use App\Models\Structure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CrCourrierEntrantController extends LaravelController
{
    use EloquentBuilderTrait;

    /* Start Analyse Function */

    public function getAnalyse(Request $request)
    {
        $parsedData = array();
        foreach ($request->all() as $param) {
            // Parse the resource options given by GET parameters
            $resourceOptions = $this->parseArrayOptions($param['query']);

            $query = CrCourrierEntrant::query();
            $this->applyResourceOptions($query, $resourceOptions);

            $items = $query->get();
            array_push($parsedData ,
                array("libelle" => $param['libelle'], "couleur" => $param['couleur'], "type" => $param['type'], "data" => $items)
            );
        }
        // return response()
        // ->json($parsedData);
        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

    public function sortGrpValeurNbcourrier(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw('"Nombre de courriers" as libelle,  count(*) data');
            }
    }

    public function sortGrpAnneeNbcourrier(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw('year(date_arrive) libelle, year(date_arrive) grouped_column, count(*) data')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpMoisNbcourrier(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("CONCAT(month(date_arrive),'/',year(date_arrive)) libelle, CONCAT(month(date_arrive),'/',year(date_arrive)) grouped_column, count(*) data")
                ->groupBy('grouped_column')
                ->orderBy('date_arrive', 'asc');
            }
    }


    public function sortGrpTypeNbcourrier(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("cr_type.libelle libelle, cr_type.libelle grouped_column, count(*) data")
            ->join('cr_courrier', 'cr_courrier.id', '=', 'cr_courrier_entrant.courrier_id')
            ->join('cr_type', 'cr_type.id', '=', 'cr_courrier.type_id')
            ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpNatureNbcourrier(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("cr_nature.libelle libelle, cr_nature.libelle grouped_column, count(*) data")
            ->join('cr_courrier', 'cr_courrier.id', '=', 'cr_courrier_entrant.courrier_id')
            ->join('cr_nature', 'cr_nature.id', '=', 'cr_courrier.nature_id')
            ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpUrgenceNbcourrier(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("cr_urgence.libelle libelle, cr_urgence.libelle grouped_column, count(*) data")
            ->join('cr_courrier', 'cr_courrier.id', '=', 'cr_courrier_entrant.courrier_id')
            ->join('cr_urgence', 'cr_urgence.id', '=', 'cr_courrier.urgence_id')
            ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpStatutNbcourrier(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("cr_statut.libelle libelle, cr_statut.libelle grouped_column, count(*) data")
            ->join('cr_courrier', 'cr_courrier.id', '=', 'cr_courrier_entrant.courrier_id')
            ->join('cr_statut', 'cr_statut.id', '=', 'cr_courrier.statut_id')
            ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }
    
     public function filterAnnee(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereRaw('year(date_arrive) = ?', $value);
        }
    }
    
     public function filterAnnees(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $args = explode(",", $value);
            $additional = array();
            $args = array_filter(
                $args, function($element) use (&$additional) {
                    if(strpos($element,'~') !== false) {
                        $rangedElement = explode("~", $element);
                        foreach(range($rangedElement[0], $rangedElement[array_key_last($rangedElement)]) as $number) {
                            $additional[] = $number;
                        }
                        return false;
                    }
                    return true;
                }
             );
             $args = array_unique(array_merge($args,$additional));
             $placeholders = implode(",", array_fill(0, count($args), '?'));
             $query->whereRaw("year(date_arrive) IN (".$placeholders.")", $args);
        }
    }
    
    public function filterMois(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereRaw('month(date_arrive) = ?', $value);
        }
    }
    
    public function filterMultipleMois(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $args = explode(",", $value);
            $placeholders = implode(",", array_fill(0, count($args), '?'));
            $query->whereRaw("month(date_arrive) IN (".$placeholders.")", $args);
        }
    }

    /* End Analyse Function */

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = CrCourrierEntrant::query();
        $this->applyResourceOptions($query, $resourceOptions);

        if(isset($request->paginate)) {
            $items = $query->paginate($request->paginate);
            $parsedData = $items;

        } else {
            $items = $query->get();
            // Parse the data using Optimus\Architect
            $parsedData = $this->parseData($items, $resourceOptions, 'data');
        }

        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

    public function filterIsIns(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            // $query->where('inscription_id', Auth::id());
        }
    }

    public function filterIsIns2(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        $count = Structure::where('id',1)->whereHas('_employes', function($query2) {
            $query2->where('inscription.id',  Auth::id());
        })->count();

        if ($value && !$count) {
            $query->where('inscription_id', Auth::id());
            $query->orWhere(function($query) {
                $query->whereHas('cr_courrier.structure._employes', function($query)  {
                    $query->where('inscription.id',Auth::id());
                });
            });
            $query->orWhere(function($query) {
                $query->whereHas('cr_courrier.cr_reaffected_inscriptions', function($query){
                    $query->where('inscription.id',Auth::id());
                    $query->where('confirmation', '=', 1);
                });
            });
        }
    }

    public function filterIsAffected(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier.cr_reaffectations');
        }
    }

    public function filterIsNotAffected(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->doesntHave('cr_courrier.cr_reaffectations');
        }
    }


    public function filterSearchString(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where(DB::raw('lower(cr_courrier.numero)'), 'like', "%" .Str::lower($value). "%");
                $query->orWhere(DB::raw('lower(cr_courrier.libelle)'), 'like', "%" .Str::lower($value). "%");
                $query->orWhere(DB::raw('lower(cr_courrier.objet)'), 'like', "%" .Str::lower($value). "%");
            });
        }
    }

    public function filterSuiviParId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where('suivi_par', $value);
            });
        }
    }
    
     public function filterSuiviParsId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
             $query->whereHas('cr_courrier', function($query) use ($ids) {
                $query->whereIn('suivi_par', $ids);
            });
        }
    }

    public function filterDossierId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where('dossier_id', $value);
            });
        }
    }
    
    public function filterDossiersId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
             $query->whereHas('cr_courrier', function($query) use ($ids) {
                $query->whereIn('dossier_id', $ids);
            });
        }
    }

    public function filterStructureId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where('structure_id', $value);
            });
        }
    }
    
     public function filterStructuresId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
             $query->whereHas('cr_courrier', function($query) use ($ids) {
                $query->whereIn('structure_id', $ids);
            });
        }
    }

    public function filterTypeId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where('type_id', $value);
            });
        }
    }
    
    public function filterTypesId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
             $query->whereHas('cr_courrier', function($query) use ($ids) {
                $query->whereIn('type_id', $ids);
            });
        }
    }


    public function filterUrgenceId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where('urgence_id', $value);
            });
        }
    }
    
     public function filterUrgencesId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
             $query->whereHas('cr_courrier', function($query) use ($ids) {
                $query->whereIn('urgence_id', $ids);
            });
        }
    }


    public function filterNatureId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where('nature_id', $value);
            });
        }
    }
    
    public function filterNaturesId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
             $query->whereHas('cr_courrier', function($query) use ($ids) {
                $query->whereIn('nature_id', $ids);
            });
        }
    }

    public function filterIsClosed(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) {
                $query->whereNotNull('cloture_id');
            });
        } else {
            $query->whereHas('cr_courrier', function($query) {
                $query->whereNull('cloture_id');
            });
        }
    }

    public function filterExterne(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_provenance', function($query) {
                $query->where('cr_provenance.externe',1);
            });
        } else {
            $query->whereHas('cr_provenance', function($query) {
                $query->where('cr_provenance.externe',0);
            });
        }
    }

    public function filterExpediteurInterneId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHasMorph('expediteur', [Structure::class], function($query) use ($value){
                $query->where('structures.id', $value );
            });
        }
    }
    
    public function filterExpediteurInternesId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $ids = explode(",", $value);
            $query->whereHasMorph('expediteur', [Structure::class], function($query) use ($ids){
                $query->whereIn('structures.id', $ids );
            });
        }
    }


    public function filterExpediteurExterneId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHasMorph('expediteur', [CrCoordonnee::class], function($query) use ($value){
                $query->where('cr_coordonnee.id', $value );
            });
        }
    }
    
    public function filterExpediteurExternesId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $ids = explode(",", $value);
            $query->whereHasMorph('expediteur', [CrCoordonnee::class], function($query) use ($ids){
                $query->whereIn('cr_coordonnee.id', $ids );
            });
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $courrier = CrCourrier::create([
                'inscription_id' => Auth::id(),
                'libelle' => $this->generateUniqueToken(),
                'objet' => $request->objet,
                'date_redaction' => $request->date_redaction,
                'commentaire' => $request->commentaire,
                'date_cloture' => $request->date_cloture,
                'numero' => $request->numero,
                'date_limit' => $request->date_limit,
                'valider' => $request->valider,
                'type_id' => $request->type_id,
                'urgence_id' => $request->urgence_id,
                'statut_id' => 1,
                'nature_id' => $request->nature_id,
                'structure_id' => $request->structure_id,
                'suivi_par' => $request->suivi_par,
                'dossier_id' => $request->dossier_id
            ]);

            $item = CrCourrierEntrant::create([
                'inscription_id' => Auth::id(),
                'date_arrive' => $request->date_arrive,
                'courrier_id' => $courrier->id,
                'provenance' => $request->provenance,
                'expediteur_type' => $request->expediteur_type,
                'expediteur_id' => $request->expediteur_id,
                'responsable_id' => $request->responsable_id
            ]);

            if($request->exists('etapes'))
            {
                $json = utf8_encode($request->etapes);
                $data = json_decode($json);
                if(is_array($data)){
                    foreach($data as $element) {
                        CrCourrierEtape::create([
                            'inscription_id' => Auth::id(),
                            'libelle' => $element->libelle,
                            'description' => $element->description,
                            'duree' => $element->duree,
                            'etape' => $element->etape,
                            'responsable_id' => $element->responsable_id,
                            'structure_id' => $element->structure_id,
                            'courrier_id' => $courrier->id
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }

        return response()
        ->json($item->load([
            'cr_provenance',
            'cr_courrier',
        ]));
    }

    public function getToken($length, $prefix){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";

        mt_srand();

        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
        }

        $token = $prefix. $token . substr(strftime("%Y", time()),2);
        return $token;
    }

    public function generateUniqueToken()
    {
        do {
           $code = $this->getToken(6, 'CE');
        } while (CrCourrier::where("libelle", "=", $code)->first());

        return $code;
    }

    public function update(Request $request, $id)
    {

        $item = CrCourrierEntrant::findOrFail($id);

        $data = $request->all();
        $item->fill($data)->save();
        $item->cr_courrier->fill($data)->save();

        return response()
        ->json($item->load([
            'cr_provenance',
            'cr_courrier',
        ]));
    }

    public function destroy($id)
    {
        $item = CrCourrierEntrant::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function restore($id)
    {
        $restoreDataId = CrCourrierEntrant::withTrashed()->findOrFail($id);
        if($restoreDataId && $restoreDataId->trashed()){
           $restoreDataId->restore();
        }
        return response()
        ->json($restoreDataId->load([
            'cr_provenance',
            'cr_courrier',
        ]));
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = CrCourrierEntrant::find($item_id);
        $item->{$relation_name}()->syncWithoutDetaching([$relation_id => ['inscription_id'=> Auth::id()]]);

        return response()->json([
            'message' => 'Element affecter'
        ]);
    }

    public function detachAffectation(Request $request)
    {
        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = CrCourrierEntrant::find($item_id);
        $item->{$relation_name}()->detach($relation_id);

        return response()->json([
            'message' => 'Element Désaffecter'
        ]);
    }


    public function setAffectation(Request $request)
    {
        $item_id = $request->id;
        $result = null;
        DB::beginTransaction();

        try {

            $item = CrCourrierEntrant::find($item_id);

            foreach($request->affectation as $key=>$value)
            {
                $pivotData = array_fill(0, count($value), ['inscription_id'=> Auth::id()]);
                $syncData  = array_combine($value, $pivotData);
                $result = $item->{$key}()->sync($syncData);
            }

            DB::commit();
        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }

        return response()->json([
            'message' => 'Affectation mis à jour',
            'result'=>$result
        ]);
    }

    public function getAffectation(CrCourrierEntrant $CrCourrierEntrant)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
