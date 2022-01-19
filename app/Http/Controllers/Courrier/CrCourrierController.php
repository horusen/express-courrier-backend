<?php

namespace App\Http\Controllers\Courrier;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrCourrier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrCourrierController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = CrCourrier::query();
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
            $query->where('inscription_id', 1);
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

        $item = CrCourrier::create([
            'inscription_id' => 1,
            'libelle' => $request->libelle,
            'objet' => $request->objet,
            'date_redaction' => $request->date_redaction,
            'commentaire' => $request->commentaire,
            'valider' => $request->valider,
            'numero_facture' => $request->numero_facture,
            'devise' => $request->devise,
            'montant' => $request->montant,
            'type_id' => $request->type_id,
            'nature_id' => $request->nature_id,
            'structure_id' => $request->structure_id,
            'suivi_par' => $request->suivi_par,
        ]);

        return response()
        ->json($item);
    }

    public function update(Request $request, $id)
    {

        $item = CrCourrier::findOrFail($id);

        $data = $request->all();

        $item->fill($data)->save();

        return response()
        ->json($item);
    }

    public function destroy($id)
    {
        $item = CrCourrier::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = CrCourrier::find($item_id);
        $item->{$relation_name}()->syncWithoutDetaching([$relation_id => ['inscription_id'=> 1]]);

        return response()->json([
            'message' => 'Element affecter'
        ]);
    }

    public function detachAffectation(Request $request)
    {
        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = CrCourrier::find($item_id);
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

            $item = CrCourrier::find($item_id);

            foreach($request->affectation as $key=>$value)
            {
                $pivotData = array_fill(0, count($value), ['inscription_id'=> 1]);
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

    public function getAffectation(CrCourrier $CrCourrier)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
