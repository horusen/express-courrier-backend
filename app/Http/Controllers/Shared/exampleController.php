<?php

namespace App\Http\Shared;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Structure\Fonction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExempleController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = Fonction::query();
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

    public function select2(Request $request)
    {
        $q = "%" .$request->search . "%";
        $item = Fonction::where('libelle_but', 'like',$q)->get(['id_but as id','libelle_but as text']);
        return response()
        ->json(['items' => $item]);
    }

    public function filterIsIns(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->where('inscription', Auth::id());
        }
    }

    public function filterParentJournal(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('journals', function($query) use ($value){
                $query->where('id_masque_journal', $value );
             });
        }
    }

    public function filterParentChaine(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('chaines', function($query) use ($value){
                $query->where('id_masque_chaine', $value );
             });
        }
    }

    public function filterSearchString(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->orWhere('libelle_but', 'like', "%" .$value . "%");
        }
    }

    public function store(Request $request)
    {

        $item = Fonction::create([
            'inscription' => Auth::id(),
            'libelle_but' => $request->libelle_but,
        ]);

        if($request->exists('parent'))
        {

            $parent = $request->parent;

            $pivotData = array_fill(0, 1, ['inscription'=> 1]);
            $syncData  = array_combine([$parent['id']], $pivotData);
            $item->{$parent['type']}()->sync($syncData);
        }

        return response()
        ->json($item);
    }

    public function update(Request $request, $id)
    {

        $item = Fonction::findOrFail($id);

        $data = $request->all();

        $item->fill($data)->save();

        if($request->exists('parent'))
        {
            $parent = $request->parent;
            $pivotData = array_fill(0, 1, ['inscription'=> 1]);
            $syncData  = array_combine([$parent->id], $pivotData);
            $item->{$parent->type}()->sync($syncData);
        }

        return response()
        ->json($item);
    }

    public function destroy($id)
    {
        $item = Fonction::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = Fonction::find($item_id);
        $item->{$relation_name}()->syncWithoutDetaching([$relation_id => ['inscription'=> Auth::id()]]);

        return response()->json([
            'message' => 'Element affecter'
        ]);
    }

    public function detachAffectation(Request $request)
    {
        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = Fonction::find($item_id);
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

            $item = Fonction::find($item_id);

            foreach($request->affectation as $key=>$value)
            {
                $pivotData = array_fill(0, count($value), ['inscription'=> 1]);
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

    public function getAffectation(Fonction $exemple)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
