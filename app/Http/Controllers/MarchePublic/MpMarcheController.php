<?php

namespace App\Http\Controllers\MarchePublic;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\MarchePublic\MpMarche;
use App\Models\MarchePublic\MpMarcheEtape;
use App\Models\MarchePublic\MpTypeProcedure;
use App\Models\MarchePublic\MpTypeProcedureEtape;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MpMarcheController extends LaravelController
{
    use EloquentBuilderTrait;

    /* Start Analyse Function */

    public function getAnalyse(Request $request)
    {
        $parsedData = array();
        foreach ($request->all() as $param) {
            // Parse the resource options given by GET parameters
            $resourceOptions = $this->parseArrayOptions($param['query']);

            $query = MpMarche::query();
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

    public function sortGrpAnneeNbmarche(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw('year(created_at) libelle, year(created_at) grouped_column, count(*) data')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }
    public function sortGrpAnneeBudget(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw('year(created_at) libelle, year(created_at) grouped_column, COALESCE(sum(mp_marche.cout),0) data')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpAnneeNbfournisseur(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw('year(mp_marche.created_at) libelle, year(mp_marche.created_at) grouped_column,  COUNT( distinct coordonnee) data')
                ->join('mp_affectation_marche_fournisseur','mp_affectation_marche_fournisseur.marche', '=', 'mp_marche.id')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpAnneeNbpartenaire(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw('year(mp_marche.created_at) libelle, year(mp_marche.created_at) grouped_column,  COUNT( distinct coordonnee) data')
                ->join('mp_affectation_marche_partenaire','mp_affectation_marche_partenaire.marche', '=', 'mp_marche.id')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpMoisNbmarche(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("CONCAT(month(created_at),'/',year(created_at)) libelle, CONCAT(month(created_at),'/',year(created_at)) grouped_column, count(*) data")
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }
    public function sortGrpMoisBudget(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("CONCAT(month(created_at),'/',year(created_at)) libelle, CONCAT(month(created_at),'/',year(created_at)) grouped_column, COALESCE(sum(mp_marche.cout),0) data")
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpMoisNbfournisseur(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("CONCAT(month(created_at),'/',year(created_at)) libelle, CONCAT(month(created_at),'/',year(created_at)) grouped_column,  COUNT( distinct coordonnee) data")
                ->join('mp_affectation_marche_fournisseur','mp_affectation_marche_fournisseur.marche', '=', 'mp_marche.id')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpMoisNbpartenaire(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("CONCAT(month(created_at),'/',year(created_at)) libelle, CONCAT(month(created_at),'/',year(created_at)) grouped_column,  COUNT( distinct coordonnee) data")
                ->join('mp_affectation_marche_partenaire','mp_affectation_marche_partenaire.marche', '=', 'mp_marche.id')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }



    public function sortGrpTypeNbmarche(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("mp_type_marche.libelle libelle, mp_type_marche.libelle grouped_column, count(*) data")
            ->join('mp_type_marche', 'mp_type_marche.id', '=', 'mp_marche.type_marche_id')
            ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }
    public function sortGrpTypeBudget(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("mp_type_marche.libelle libelle, mp_type_marche.libelle grouped_column, COALESCE(sum(mp_marche.cout),0) data")
            ->join('mp_type_marche', 'mp_type_marche.id', '=', 'mp_marche.type_marche_id')

            ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpTypeNbfournisseur(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("mp_type_marche.libelle libelle, mp_type_marche.libelle grouped_column,  COUNT( distinct coordonnee) data")
            ->join('mp_type_marche', 'mp_type_marche.id', '=', 'mp_marche.type_marche_id')

            ->join('mp_affectation_marche_fournisseur','mp_affectation_marche_fournisseur.marche', '=', 'mp_marche.id')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpTypeNbpartenaire(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("mp_type_marche.libelle libelle, mp_type_marche.libelle grouped_column,  COUNT( distinct coordonnee) data")
            ->join('mp_type_marche', 'mp_type_marche.id', '=', 'mp_marche.type_marche_id')

            ->join('mp_affectation_marche_partenaire','mp_affectation_marche_partenaire.marche', '=', 'mp_marche.id')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

     public function sortGrpProcedureNbmarche(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("mp_type_procedure.libelle libelle, mp_type_procedure.libelle grouped_column, count(*) data")
            ->join('mp_type_procedure', 'mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')
            ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }
    public function sortGrpProcedureBudget(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("mp_type_procedure.libelle libelle, mp_type_procedure.libelle grouped_column, COALESCE(sum(mp_marche.cout),0) data")
            ->join('mp_type_procedure', 'mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')

            ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpProcedureNbfournisseur(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("mp_type_procedure.libelle libelle, mp_type_procedure.libelle grouped_column,  COUNT( distinct coordonnee) data")
            ->join('mp_type_procedure', 'mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')

            ->join('mp_affectation_marche_fournisseur','mp_affectation_marche_fournisseur.marche', '=', 'mp_marche.id')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    public function sortGrpProcedureNbpartenaire(myBuilder $query,  $value) {
        if ($value) {
            $query->selectRaw("mp_type_procedure.libelle libelle, mp_type_procedure.libelle grouped_column,  COUNT( distinct coordonnee) data")
            ->join('mp_type_procedure', 'mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')

            ->join('mp_affectation_marche_partenaire','mp_affectation_marche_partenaire.marche', '=', 'mp_marche.id')
                ->groupBy('grouped_column')
                ->orderBy('grouped_column', 'asc');
            }
    }

    /* End Analyse Function */

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = MpMarche::query();
        $this->applyResourceOptions($query, $resourceOptions);

        if (isset($request->paginate)) {
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
            $query->where('inscription_id', Auth::id());
        }
    }


    public function filterSearchString(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $query->orWhere('libelle', 'like', "%" . $value . "%");
        }
    }

    public function filterServiceContractantsId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
            $query->whereIn('service_contractant_id',$ids);
        }
    }

    public function filterTypeProceduresId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
            $query->whereIn('type_procedure_id',$ids);
        }
    }

    public function filterTypeMarchesId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if ($value) {
            $ids = explode(",", $value);
            $query->whereIn('type_marche_id',$ids);
        }
    }

    public function filterFournisseursId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('fournisseurs', function($query) use ($value) {
                $query->where('cr_coordonnee.id', $value);
            });
        }
    }

    public function filterPartenaireId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('partenaires', function($query) use ($value) {
                $query->where('cr_coordonnee.id', $value);
            });
        }
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            $item = MpMarche::create([
                'inscription_id' => Auth::id(),
                'libelle' => $request->libelle,
                'service_contractant_id' => $request->service_contractant_id,
                'type_procedure_id' => $request->type_procedure_id,
                'type_marche_id' => $request->type_marche_id,
                'cout' => $request->cout,
                'fournisseur_id' => $request->fournisseur_id,
                'source_financement' => $request->source_financement,
                'date_fermeture' => $request->date_fermeture,
                'date_execution' => $request->date_execution,
            ]);

            $typeProcedure = MpTypeProcedure::where('id', $request->type_procedure_id)->first();

            $procedureParent = $typeProcedure->mp_type_procedure()->first();
            if($procedureParent) {
                $list2 = $procedureParent->mp_type_procedure_etapes()->get();
                $list2->each(function ($etape) use ($item) {
                    MpMarcheEtape::create([
                    'inscription_id' => Auth::id(),
                    'libelle' => $etape->libelle,
                    'description' => $etape->description,
                    'position' => $etape->position,
                    'marche_id' =>$item->id]);
                });
            }


            $list1 = $typeProcedure->mp_type_procedure_etapes()->get();
            $list1->each(function ($etape) use ($item) {
                MpMarcheEtape::create([
                'inscription_id' => Auth::id(),
                'libelle' => $etape->libelle,
                'description' => $etape->description,
                'position' => $etape->position,
                'marche_id' =>$item->id]);
            });

            DB::commit();
        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }

        return response()
            ->json($item->load(['mp_type_marche', 'partenaires',  'fournisseurs','structure', 'mp_type_procedure.mp_type_procedure', 'mp_marche_etapes.fichiers']));
    }

    public function update(Request $request, $id)
    {

        $item = MpMarche::findOrFail($id);

        $data = $request->all();

        $item->fill($data)->save();

        return response()
            ->json($item->load(['mp_type_marche', 'partenaires',  'fournisseurs','structure', 'mp_type_procedure.mp_type_procedure', 'mp_marche_etapes.fichiers']));
    }

    public function destroy($id)
    {
        $item = MpMarche::findOrFail($id);

        $item->delete();

        return response()
            ->json(['msg' => 'Suppression effectué']);
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = MpMarche::find($item_id);
        $item->{$relation_name}()->syncWithoutDetaching([$relation_id => ['inscription_id' => Auth::id()]]);

        return response()->json([
            'message' => 'Element affecter'
        ]);
    }

    public function detachAffectation(Request $request)
    {
        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = MpMarche::find($item_id);
        $item->{$relation_name}()->detach($relation_id);

        return response()->json([
            'message' => 'Element Désaffecter'
        ]);
    }

    public function setAffectation(Request $request)
    {
        $item_id = $request->id;
        $attached = [];
        $detached = [];
        $result = null;

        DB::beginTransaction();

        try {

            $item = MpMarche::find($item_id);

            foreach($request->affectation as $key=>$value)
            {
                $pivotData = array_fill(0, count($value), ['inscription_id'=> 1]);
                $syncData  = array_combine($value, $pivotData);
                $result = $item->{$key}()->sync($syncData);
                $detached = $result['detached'];
                $attached = $result['attached'];
            }

            DB::commit();
        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }

        return response()->json([
            'message' => 'Affectation mis à jour',
            'attached' => $attached,
            'detached' => $detached,
            'result' => $result
        ]);
    }

    public function getAffectation(MpMarche $MpMarche)
    {

        return response()
            ->json(['data' => 'need to update it']);
    }

    public function getTableauxPartenaire()
    {
        // $nombre = DB::table('mp_marche')->count();
        // $prix = DB::table('mp_marche')->sum('cout');
        // $chart_type_marche =  DB::table('mp_marche')
        // ->selectRaw('
        //     round(((count(mp_marche.id)/('.$nombre .'))*100),2) as pourcentage_marche,
        //     round(((COALESCE(sum(mp_marche.cout),0)/('.$prix .'))*100),2) as pourcentage_cout,
        //     mp_type_marche.libelle as type_marche
        // ')
        // ->join('mp_type_marche','mp_type_marche.id', '=', 'mp_marche.type_marche_id')
        // ->groupBy('mp_type_marche.id')->get();

        // $chart_procedure_marche =  DB::table('mp_marche')
        // ->selectRaw('
        //     round(((count(mp_marche.id)/('.$nombre .'))*100),2) as pourcentage_marche,
        //     round(((COALESCE(sum(mp_marche.cout),0)/('.$prix .'))*100),2) as pourcentage_cout,
        //     mp_type_procedure.libelle as type_marche
        // ')
        // ->join('mp_type_procedure','mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')
        // ->groupBy('mp_type_procedure.id')->get();


         $type = DB::table('cr_coordonnee')
        ->selectRaw('cr_coordonnee.id as id, cr_coordonnee.libelle as libelle, mp_type_marche.libelle as type_marche,count(mp_marche.id) as marche_count, COALESCE(sum(mp_marche.cout),0) as cout')
        ->join('mp_affectation_marche_partenaire','mp_affectation_marche_partenaire.coordonnee', '=', 'cr_coordonnee.id')
        ->join('mp_marche','mp_affectation_marche_partenaire.marche', '=', 'mp_marche.id')
        ->join('mp_type_marche','mp_type_marche.id', '=', 'mp_marche.type_marche_id')
        // ->leftjoin('mp_type_procedure','mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')
        ->groupBy('cr_coordonnee.id', 'mp_type_marche.libelle')->orderBy('cr_coordonnee.libelle')->orderBy('mp_type_marche.libelle')->get();

        $procedure = DB::table('cr_coordonnee')
        ->selectRaw('cr_coordonnee.id as id, cr_coordonnee.libelle as libelle, mp_type_procedure.libelle as type_marche,count(mp_marche.id) as marche_count, COALESCE(sum(mp_marche.cout),0) as cout')
        ->join('mp_affectation_marche_partenaire','mp_affectation_marche_partenaire.coordonnee', '=', 'cr_coordonnee.id')
        ->join('mp_marche','mp_affectation_marche_partenaire.marche', '=', 'mp_marche.id')
        // ->leftjoin('mp_type_marche','mp_type_marche.id', '=', 'mp_marche.type_marche_id')
        ->join('mp_type_procedure','mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')
        ->groupBy('cr_coordonnee.id', 'mp_type_procedure.libelle')->orderBy('cr_coordonnee.libelle')->orderBy('mp_type_procedure.libelle')->get();

        return response()
            ->json([
                // 'chart_type_marche' => $chart_type_marche,
                // 'chart_procedure_marche' => $chart_procedure_marche,
                'type' => $type,
                'procedure' => $procedure
            ]);
    }

    public function getMarcheAnalyse() {
        $nombre = DB::table('mp_marche')->count();
        $prix = DB::table('mp_marche')->sum('cout');
        $chart_type_marche =  DB::table('mp_marche')
        ->selectRaw('
            round(((count(mp_marche.id)/('.$nombre .'))*100),2) as pourcentage_marche,
            round(((COALESCE(sum(mp_marche.cout),0)/('.$prix .'))*100),2) as pourcentage_cout,
            mp_type_marche.libelle as type_marche
        ')
        ->join('mp_type_marche','mp_type_marche.id', '=', 'mp_marche.type_marche_id')
        ->groupBy('mp_type_marche.id')->get();

        $chart_procedure_marche =  DB::table('mp_marche')
        ->selectRaw('
            round(((count(mp_marche.id)/('.$nombre .'))*100),2) as pourcentage_marche,
            round(((COALESCE(sum(mp_marche.cout),0)/('.$prix .'))*100),2) as pourcentage_cout,
            mp_type_procedure.libelle as type_marche
        ')
        ->join('mp_type_procedure','mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')
        ->groupBy('mp_type_procedure.id')->get();
    $histogramme_count = DB::table('mp_marche')->selectRaw("
        count(id) AS data,
        DATE_FORMAT(created_at, '%Y-%m') AS new_date
    ")
    ->groupBy('new_date')
    ->get();

    $histogramme_prix = DB::table('mp_marche')->selectRaw("
        COALESCE(sum(mp_marche.cout),0) AS data,
        DATE_FORMAT(created_at, '%Y-%m') AS new_date
    ")
    ->groupBy('new_date')
    ->get();

    return response()
            ->json([
                'chart_type_marche' => $chart_type_marche,
                'chart_procedure_marche' => $chart_procedure_marche,
                'histogramme_prix' => $histogramme_prix,
                'histogramme_count' => $histogramme_count
            ]);
    }
    public function getTableauxFournisseur()
    {
        // $nombre = DB::table('mp_marche')->count();
        // $prix = DB::table('mp_marche')->sum('cout');
        // $chart_type_marche =  DB::table('mp_marche')
        // ->selectRaw('
        //     round(((count(mp_marche.id)/('.$nombre .'))*100),2) as pourcentage_marche,
        //     round(((COALESCE(sum(mp_marche.cout),0)/('.$prix .'))*100),2) as pourcentage_cout,
        //     mp_type_marche.libelle as type_marche
        // ')
        // ->join('mp_type_marche','mp_type_marche.id', '=', 'mp_marche.type_marche_id')
        // ->groupBy('mp_type_marche.id')->get();

        // $chart_procedure_marche =  DB::table('mp_marche')
        // ->selectRaw('
        //     round(((count(mp_marche.id)/('.$nombre .'))*100),2) as pourcentage_marche,
        //     round(((COALESCE(sum(mp_marche.cout),0)/('.$prix .'))*100),2) as pourcentage_cout,
        //     mp_type_procedure.libelle as type_marche
        // ')
        // ->join('mp_type_procedure','mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')
        // ->groupBy('mp_type_procedure.id')->get();

         $type = DB::table('cr_coordonnee')
        ->selectRaw('cr_coordonnee.id as id, cr_coordonnee.libelle as libelle, mp_type_marche.libelle as type_marche, count(mp_marche.id) as marche_count, COALESCE(sum(mp_marche.cout),0) as cout')
        ->join('mp_affectation_marche_fournisseur','mp_affectation_marche_fournisseur.coordonnee', '=', 'cr_coordonnee.id')
        ->join('mp_marche','mp_affectation_marche_fournisseur.marche', '=', 'mp_marche.id')
        ->join('mp_type_marche','mp_type_marche.id', '=', 'mp_marche.type_marche_id')
        // ->leftjoin('mp_type_procedure','mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')
        ->groupBy('cr_coordonnee.id', 'mp_type_marche.libelle')->orderBy('cr_coordonnee.libelle')->orderBy('mp_type_marche.libelle')->get();

        $procedure = DB::table('cr_coordonnee')
        ->selectRaw('cr_coordonnee.id as id, cr_coordonnee.libelle as libelle, mp_type_procedure.libelle as type_marche,count(mp_marche.id) as marche_count, COALESCE(sum(mp_marche.cout),0) as cout')
        ->join('mp_affectation_marche_fournisseur','mp_affectation_marche_fournisseur.coordonnee', '=', 'cr_coordonnee.id')
        ->join('mp_marche','mp_affectation_marche_fournisseur.marche', '=', 'mp_marche.id')
        // ->leftjoin('mp_type_marche','mp_type_marche.id', '=', 'mp_marche.type_marche_id')
        ->join('mp_type_procedure','mp_type_procedure.id', '=', 'mp_marche.type_procedure_id')
        ->groupBy('cr_coordonnee.id', 'mp_type_procedure.libelle')->orderBy('cr_coordonnee.libelle')->orderBy('mp_type_procedure.libelle')->get();

        return response()
            ->json([
                // 'chart_type_marche' => $chart_type_marche,
                // 'chart_procedure_marche' => $chart_procedure_marche,
                'type' => $type,
                'procedure' => $procedure
            ]);
    }
}
