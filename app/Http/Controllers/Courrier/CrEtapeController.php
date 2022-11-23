<?php

namespace App\Http\Controllers\Courrier;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrEtape;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrEtapeController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = CrEtape::query();
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

    public function filterParentCrTypeId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('cr_types', function($query) use ($value){
                $query->where('cr_type.id', $value );
             });
             request()->request->add(['type_id' => $value]);
        }
    }

    public function sortOrderlyWay(myBuilder $query, $value)
    {
        $type_id = request()->exists('type_id') ? request()->type_id : null;
        if ($value) {
            $query->leftjoin('cr_affectation_etape_type_courrier', function ($join) use ($type_id) {
                $join->on('cr_affectation_etape_type_courrier.etape', '=', 'cr_etape.id');
                if($type_id) {
                   $join->where('cr_affectation_etape_type_courrier.type', '=', $type_id);
                };
            })
            ->orderBy('cr_affectation_etape_type_courrier.id_pivot');
        }
    }


    public function store(Request $request)
    {

        $data = $request->all();

        if($request->exists('responsable_id'))
        {
            $data['structure_id']=null;
        } else if ($request->exists('structure_id'))
        {
            $data['responsable_id']=null;
        }

        $item = CrEtape::create([
            'inscription_id' => Auth::id(),
            'libelle' => $request->libelle,
            'description' => $request->description,
            'duree' => $request->duree,
            'etape' => $request->etape,
            'responsable_id' => $data['responsable_id'],
            'structure_id' => $data['structure_id'],
        ]);

        return response()
        ->json($item->load(['responsable', 'structure']));
    }

    public function update(Request $request, $id)
    {

        $item = CrEtape::findOrFail($id);

        $data = $request->all();

        if($request->exists('responsable_id'))
        {
            $data['structure_id']=null;
        } else if ($request->exists('structure_id'))
        {
            $data['responsable_id']=null;
        }

        $item->fill($data)->save();

        return response()
        ->json($item->load(['responsable', 'structure']));
    }

    public function destroy($id)
    {
        $item = CrEtape::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function restore($id)
    {
        $restoreDataId = CrEtape::withTrashed()->findOrFail($id);
        if($restoreDataId && $restoreDataId->trashed()){
           $restoreDataId->restore();
        }
        return response()
        ->json($restoreDataId->load(['responsable', 'structure']));
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = CrEtape::find($item_id);
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
        $item = CrEtape::find($item_id);
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

            $item = CrEtape::find($item_id);

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

    public function getAffectation(CrEtape $CrEtape)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
