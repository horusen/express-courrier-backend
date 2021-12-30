<?php

namespace App\Http\Controllers\Ged;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Ged\Fichier;
use App\Models\Ged\FichierType;
use App\Models\Ged\GedElement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FichierController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = Fichier::query();
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

    public function filterIsInInsFolder(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('dossiers', function($query) use ($value){
                $query->where('dossier.inscription_id', 1 );
             });
        }
    }

    public function filterDossierId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('dossiers', function($query) use ($value){
                $query->where('dossier.id', $value);
             });
        }
    }

    public function filterUserFavoris(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.ged_favoris', function($query) {
                $query->where('ged_favoris.inscription_id', 1);
             });
        }
    }

    public function filterSharedByUser(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.partage_a_personnes', function($query) {
                $query->where('ged_partage.inscription_id', 1);
             });
        }
    }

    public function filterSharedToUser(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_element.partage_a_personnes', function($query) {
                $query->where('ged_partage.personne', 1);
             });
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $path = $request->file('fichier')->store('document/'.date('Y').'/'.date('F'));
        // $nameonly=preg_replace('/\..+$/', '', $request->file('fichier')->getClientOriginalName());
        $n = strrpos($path,".");
        $extension = ($n===false) ? "" : substr($path,$n+1);
        $file = FichierType::where('extension','like', '%'.$extension.'%')->first();

        $item = Fichier::create([
            'inscription_id' => 1,
            'libelle' => $request->libelle,
            'type' => $file->id,
            'fichier' => $path,
        ]);

        $element = new GedElement();
        $item->ged_element()->save($element);

        return response()
        ->json($item);

    }

    public function multistore(Request $request)
    {
        DB::beginTransaction();

        try {
            if($request->fichier_count) {
                for($i =0; $i<$request->fichier_count; $i++) {
                    if($request->hasFile('fichier'.$i))
                    {
                        $path = $request->file('fichier'.$i)->store('document/'.date('Y').'/'.date('F'));
                        // $nameonly=preg_replace('/\..+$/', '', $request->file('fichier'.$i)->getClientOriginalName());
                        $n = strrpos($path,".");
                        $extension = ($n===false) ? "" : substr($path,$n+1);
                        $file = FichierType::where('extension','like', '%'.$extension.'%')->first();
                        $fichier = Fichier::create([
                            'inscription' => 1,
                            'libelle' => $request->libelle,
                            'type' => $file->id,
                            'fichier' => $path,
                        ]);
                        $element = new GedElement();
                        $fichier->ged_element()->save($element);

                        $relation_name = $request->relation_name;
                        $relation_id = $request->relation_id;
                        $fichier->{$relation_name}()->syncWithoutDetaching([$relation_id => ['inscription'=> 1]]);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function update(Request $request, $id)
    {

        $item = Fichier::findOrFail($id);

        $data = $request->all();

        $item->fill($data)->save();

        return response()
        ->json($item);
    }

    public function destroy($id)
    {
        $item = Fichier::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function checkPassword(Request $request, $id) {
        $item = Fichier::findOrFail($id)->makeVisible(['password']);
        if(Hash::check($request->password, $item->ged_element->password)) {
            $item->bloquer = 0;
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
        $item = Fichier::find($item_id);
        $item->{$relation_name}()->syncWithoutDetaching([$relation_id => ['inscription'=> 1]]);

        return response()->json([
            'message' => 'Element affecter'
        ]);
    }

    public function detachAffectation(Request $request)
    {
        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = Fichier::find($item_id);
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
        $item = Fichier::find($id);

        $result = null;

        foreach($affectation as $key=>$value)
        {
            $pivotData = array_fill(0, count($value), ['inscription'=> 1]);
            $syncData  = array_combine($value, $pivotData);
            $result = $item->{$key}()->sync($syncData);
        }

        return $result;
    }
    public function getAffectation(Fichier $Fichier)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
