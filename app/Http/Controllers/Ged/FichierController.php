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
            $query->where('inscription_id', Auth::id());
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
                $query->where('dossier.inscription_id', Auth::id() );
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

    public function filterCourrierId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('courriers', function($query) use ($value){
                $query->where('cr_courrier.id', $value);
             });
        }
    }

    public function filterMarcheId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('mp_marche_etapes', function($query) use ($value){
                $query->where('mp_marche_etape.id', $value);
             });
        }
    }

    public function filterTypeId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('fichier_type', function($query) use ($value){
                $query->where('fichier_type.id', $value);
             });
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

    public function filterUserAsAccess(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->orWhereHas('ged_element.ged_element_personnes', function($query) {
                $query->where('ged_element_personne.personne', Auth::id());
             });
             $query->orWhereHas('dossiers.ged_element.ged_element_personnes', function($query) use ($value){
                $query->where('ged_element_personne.personne', Auth::id());
             });
             $query->orWhereHas('ged_element.structures._employes', function($query) use ($value) {
                $query->where('inscription.id', Auth::id());
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
        DB::beginTransaction();

        try {
            $path = $request->file('fichier')->store('document/'.date('Y').'/'.date('F'));
            // $nameonly=preg_replace('/\..+$/', '', $request->file('fichier')->getClientOriginalName());
            $n = strrpos($path,".");
            $extension = ($n===false) ? "" : substr($path,$n+1);
            $file = FichierType::where('extension','like', '%'.$extension.'%')->orWhere('extension','other')->first();
            $item = Fichier::create([
                'inscription_id' => Auth::id(),
                'libelle' => $request->libelle,
                'type_id' => $file->id,
                'fichier' => $path,
            ]);

            $element = new GedElement();
            $item->ged_element()->save($element);
            $relation_name = $request->relation_name;
            $relation_id = $request->relation_id;
            $item->{$relation_name}()->syncWithoutDetaching([$relation_id => ['inscription_id'=> Auth::id()]]);
        DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

        return response()
        ->json($item->load(['fichier_type', 'inscription', 'ged_element']));

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
                        $extension = ($n===false) ? "" : substr($path,$n+Auth::id());
                        $file = FichierType::where('extension','like', '%'.$extension.'%')->orWhere('extension','other')->first();
                        $fichier = Fichier::create([
                            'inscription' => Auth::id(),
                            'libelle' => $request->libelle,
                            'type' => $file->id,
                            'fichier' => $path,
                        ]);
                        $element = new GedElement();
                        $fichier->ged_element()->save($element);

                        $relation_name = $request->relation_name;
                        $relation_id = $request->relation_id;
                        $fichier->{$relation_name}()->syncWithoutDetaching([$relation_id => ['inscription_id'=> Auth::id()]]);
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
        ->json($item->load(['fichier_type', 'inscription', 'ged_element']));
    }

    public function destroy($id)
    {
        $item = Fichier::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function restore($id)
    {
        $restoreDataId = Fichier::withTrashed()->findOrFail($id);
        if($restoreDataId && $restoreDataId->trashed()){
           $restoreDataId->restore();
        }
        return response()
        ->json($restoreDataId->load(['fichier_type', 'inscription', 'ged_element']));
    }

    public function checkPassword(Request $request, $id) {
        $item = Fichier::findOrFail($id)->makeVisible(['password']);
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
        $item = Fichier::find($item_id);
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
            $pivotData = array_fill(0, count($value), ['inscription_id'=> Auth::id()]);
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
