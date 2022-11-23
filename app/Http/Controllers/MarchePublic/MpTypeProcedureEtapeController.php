<?php

namespace App\Http\Controllers\MarchePublic;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\MarchePublic\MpTypeProcedureEtape;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MpTypeProcedureEtapeController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = MpTypeProcedureEtape::query();
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

        $item = MpTypeProcedureEtape::create([
            'inscription_id' => Auth::id(),
            'libelle' => $request->libelle,
            'description' => $request->description,
            'position' => $request->position,
            'type_procedure_id' => $request->type_procedure_id,
        ]);

        return response()
        ->json($item);
    }

    public function update(Request $request, $id)
    {

        $item = MpTypeProcedureEtape::findOrFail($id);

        $data = $request->all();

        $item->fill($data)->save();

        return response()
        ->json($item);
    }

    public function changePosition(Request $request)
    {

        if($request->exists('type_procedures'))
        {
            $data = json_decode($request->type_procedures);
            if(is_array($data)){
                foreach($data as $element) {
                    MpTypeProcedureEtape::where('id',$element->id)->update([
                        "position" => $element->position
                    ]);
                }
            }
        }

        return response()
        ->json(['msg' => 'mis  a jour effectué']);
    }

    public function destroy($id)
    {
        $item = MpTypeProcedureEtape::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function restore($id)
    {
        $restoreDataId = MpTypeProcedureEtape::withTrashed()->findOrFail($id);
        if($restoreDataId && $restoreDataId->trashed()){
           $restoreDataId->restore();
        }
        return response()
        ->json($restoreDataId);
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = MpTypeProcedureEtape::find($item_id);
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
        $item = MpTypeProcedureEtape::find($item_id);
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

            $item = MpTypeProcedureEtape::find($item_id);

            foreach($request->affectation as $key=>$value)
            {
                $pivotData = array_fill(0, count($value), ['inscription_id'=> Auth::id()]);
                $syncData  = array_combine($value, $pivotData);
                $item->{$key}()->sync([]);
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

    public function getAffectation(MpTypeProcedureEtape $MpTypeProcedureEtape)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
