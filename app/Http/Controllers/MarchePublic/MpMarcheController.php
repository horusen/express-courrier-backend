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
                'type' => $type,
                'procedure' => $procedure
            ]);
    }

    public function getTableauxFournisseur()
    {

         $type = DB::table('cr_coordonnee')
        ->selectRaw('cr_coordonnee.id as id, cr_coordonnee.libelle as libelle, mp_type_marche.libelle as type_marche,count(mp_marche.id) as marche_count, COALESCE(sum(mp_marche.cout),0) as cout')
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
                'type' => $type,
                'procedure' => $procedure
            ]);
    }
}
