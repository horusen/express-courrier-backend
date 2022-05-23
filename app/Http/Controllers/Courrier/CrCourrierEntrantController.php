<?php

namespace App\Http\Controllers\Courrier;

use App\Events\CourrierTraiterEvent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrCoordonnee;
use App\Models\Courrier\CrCourrier;
use App\Models\Courrier\CrCourrierEntrant;
use App\Models\Courrier\CrCourrierEtape;
use App\Models\Structure;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CrCourrierEntrantController extends LaravelController
{
    use EloquentBuilderTrait;

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
                $query->where(DB::raw('lower(cr_courrier.libelle)'), 'like', "%" .Str::lower($value). "%");
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

    public function filterStructureId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where('structure_id', $value);
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

    public function filterUrgenceId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('cr_courrier', function($query) use ($value) {
                $query->where('urgence_id', $value);
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

    public function filterExpediteurExterneId(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHasMorph('expediteur', [CrCoordonnee::class], function($query) use ($value){
                $query->where('cr_coordonnee.id', $value );
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
                'date_limit' => $request->date_limit,
                'valider' => $request->valider,
                'type_id' => $request->type_id,
                'urgence_id' => $request->urgence_id,
                'statut_id' => 1,
                'nature_id' => $request->nature_id,
                'structure_id' => $request->structure_id,
                'suivi_par' => $request->suivi_par,
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

        DB::beginTransaction();

        try {

            $item = CrCourrierEntrant::find($item_id);

            foreach($request->affectation as $key=>$value)
            {
                $pivotData = array_fill(0, count($value), ['inscription_id'=> Auth::id()]);
                $syncData  = array_combine($value, $pivotData);
                $item->{$key}()->sync($syncData);
            }

            DB::commit();
        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }

        return response()->json([
            'message' => 'Affectation mis à jour'
        ]);
    }

    public function getAffectation(CrCourrierEntrant $CrCourrierEntrant)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
