<?php

namespace App\Http\Controllers\Courrier;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrCourrier;
use App\Models\Courrier\CrCourrierEntrant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $query->where('inscription_id', Auth::id());
        }
    }


    public function filterSearchString(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->orWhere('libelle', 'like', "%" .$value . "%");
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $courrier = CrCourrier::create([
                'inscription_id' => Auth::id(),
                'libelle' => $request->objet,
                'objet' => $request->objet,
                'date_redaction' => $request->date_redaction,
                'commentaire' => $request->commentaire,
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
                'expediteur_id' => $request->expediteur_id,
                'responsable_id' => $request->responsable_id
            ]);

            DB::commit();
        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }

        return response()
        ->json($item);
    }

    public function update(Request $request, $id)
    {

        $item = CrCourrierEntrant::findOrFail($id);

        $data = $request->all();
        $item->fill($data)->save();
        $item->cr_courrier->fill($data)->save();

        return response()
        ->json($item);
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
