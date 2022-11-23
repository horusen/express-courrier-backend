<?php

namespace App\Http\Controllers\Ged;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Ged\Dossier;
use App\Models\Ged\GedElement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DossierController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = Dossier::query();
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
            $query->doesnthave('ged_element.structures');
        }
    }


    public function filterSearchString(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->orWhere('libelle', 'like', "%" .$value . "%");
        }
    }

    public function filterNoParent(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->doesntHave('dossier');
        }
    }

    public function filterUserFavoris(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.ged_favoris', function($query) {
                $query->where('ged_favori.inscription_id', Auth::id());
             });
        }
    }

    public function filterStructures(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.structures', function($query) use ($value) {
                $query->where('structures.id', $value);
             });
        }
    }


    public function filterBelongToStructureId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.structures', function($query) use ($value) {
                $query->where('ged_element_structure.structure', $value);
             });
        }
    }

    public function filterBelongToUser(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.ged_element_personnes', function($query) {
                $query->where('ged_element_personne.personne', Auth::id());
             });
        }
    }

    public function filterSharedByUser(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.partage_a_personnes', function($query) {
                $query->where('ged_partage.inscription_id', Auth::id());
             });
        }
    }

    public function filterSharedToUser(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.partage_a_personnes', function($query) {
                $query->where('ged_partage.personne', Auth::id());
             });
        }
    }

    public function filterCacher(myBuilder $query, $method, $clauseOperator, $value)
{
    if ($value && $value !='') {
        $query->whereHas('ged_element', function($query) {
            $query->where('ged_element.cacher', 1);
        });
    } else {
        $query->whereHas('ged_element', function($query) {
            $query->where('ged_element.cacher', '!=', 1);
        });
    }
}

    public function store(Request $request)
    {

        $item = Dossier::create([
            'inscription_id' => Auth::id(),
            'libelle' => $request->libelle,
            'description' => $request->description,
            'conservation_id' => $request->conservation_id,
            'dossier_id' => $request->dossier_id,
            'couleur' => $request->couleur
        ]);

        $element = new GedElement();
        $item->ged_element()->save($element);

        return response()
        ->json($item->load('ged_element'));
    }

    public function update(Request $request, $id)
    {
        $item = Dossier::findOrFail($id);

        if($request->has('dossier_id')) {
            if(!$request->dossier_id) {
                $request->merge(['dossier_id' => null]);
            } else if(str_contains(strval($request->dossier_id), 'structure')) {
              $idStructure =  str_replace('structure', '', $request->dossier_id);
              $item->ged_element()->first()->structures()->sync([$idStructure => ['inscription_id'=> Auth::id()]]);
              $request->merge(['dossier_id' => null]);
            } else {
                $parent = Dossier::findOrFail($request->dossier_id);
                if ($parent->ged_element()->first()->structures()->count()) {
                    $idStructure = $parent->ged_element()->first()->structures()->take(1)->first()->id;
                    $item->ged_element()->first()->structures()->sync([$idStructure => ['inscription_id'=> Auth::id()]]);
                } else {
                    $item->ged_element()->first()->structures()->sync([]);
                };
            }
        }

        $data = $request->all();
        $item->fill($data)->save();

        return response()
        ->json($item->load('ged_element'));
    }

    public function destroy($id)
    {
        $item = Dossier::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function restore($id)
    {
        $restoreDataId = Dossier::withTrashed()->findOrFail($id);
        if($restoreDataId && $restoreDataId->trashed()){
           $restoreDataId->restore();
        }
        return response()
        ->json($restoreDataId->load('ged_element'));
    }

    public function checkPassword(Request $request, $id) {
        $item = Dossier::findOrFail($id)->makeVisible(['password']);
        if(Hash::check($request->password, $item->ged_element->password)) {
            $item->bloquer = 0;
            $item->ged_element->bloquer = 0;

            return response()
            ->json($item);
        }

        return response()
            ->json(false);
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = Dossier::find($item_id);
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
        $item = Dossier::find($item_id);
        $item->{$relation_name}()->detach($relation_id);

        return response()->json([
            'message' => 'Element Désaffecter'
        ]);
    }


    public function setAffectation(Request $request)
    {
        $item_id = $request->id;
        DB::beginTransaction();
        $result = array();


        try {
            if(is_array($item_id)) {
                foreach($item_id as $id) {
                    $result[$id] = $this->doSetAffectation($id, $request->affectation);
                }
            } else {
                $result[$item_id] = $this->doSetAffectation($item_id, $request->affectation);
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

    public function doSetAffectation($id, $affectation) {
        $item = Dossier::find($id);

        $result = null;

        foreach($affectation as $key=>$value)
        {
            $pivotData = array_fill(0, count($value), ['inscription_id'=> Auth::id()]);
            $syncData  = array_combine($value, $pivotData);
            $result = $item->{$key}()->sync($syncData);
        }

        return $result;
    }


    public function getAffectation(Dossier $Dossier)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
