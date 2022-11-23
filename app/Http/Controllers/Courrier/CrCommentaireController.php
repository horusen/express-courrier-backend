<?php

namespace App\Http\Controllers\Courrier;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrCommentaire;
use App\Models\Ged\Fichier;
use App\Models\Ged\FichierType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrCommentaireController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = CrCommentaire::query();
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
            $query->where('libelle_commentaire', 'like', "%" .$value . "%");
        }
    }

    public function filterNoParent(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if($value) {
            $query->whereDoesntHave('cr_commentaire');
        }
    }

    public function filterHasFile(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->whereHas('fichiers');
        }
    }

    public function filterParentGedId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('ged_elements', function($query) use ($value){
                $query->where('ged_element.id', $value );
             });
        }
    }

    public function filterParentCourrierId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('cr_courriers', function($query) use ($value){
                $query->where('cr_courrier.id', $value );
             });
        }
    }

    public function filterParentTacheId(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('cr_taches', function($query) use ($value){
                $query->where('cr_tache.id', $value );
             });
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $item = CrCommentaire::create([
                'inscription' => Auth::id(),
                'libelle_commentaire' => $request->libelle_commentaire,
                'contenu' => $request->contenu,
                'commentaire' => $request->commentaire,
            ]);

            if($request->fichier_count) {
                for($i =0; $i<$request->fichier_count; $i++) {
                    if($request->hasFile('fichier'.$i))
                    {
                        $path = $request->file('fichier'.$i)->store('document/'.date('Y').'/'.date('F'));
                        $nameonly=preg_replace('/\..+$/', '', $request->file('fichier'.$i)->getClientOriginalName());
                        $n = strrpos($path,".");
                        $extension = ($n===false) ? "" : substr($path,$n+1);
                        $file = FichierType::where('extension','like', '%'.$extension.'%')->first();

                        $fichier = Fichier::create([
                            'inscription_id' => Auth::id(),
                            'libelle' => $nameonly,
                            'type_id' => $file->id,
                            'fichier' => $path,
                        ]);

                        $fichier->cr_commentaires()->attach([$item->id => ['inscription_id'=> Auth::id()]]);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }

        return response()
        ->json($item->load(['fichiers']));
    }

    public function update(Request $request, $id)
    {

        $item = CrCommentaire::findOrFail($id);

        $data = $request->all();

        $item->fill($data)->save();

        return response()
        ->json($item->load(['fichiers']));
    }

    public function destroy($id)
    {
        $item = CrCommentaire::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function restore($id)
    {
        $restoreDataId = CrCommentaire::withTrashed()->findOrFail($id);
        if($restoreDataId && $restoreDataId->trashed()){
           $restoreDataId->restore();
        }
        return response()
        ->json($restoreDataId->load(['fichiers']));
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = CrCommentaire::find($item_id);
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
        $item = CrCommentaire::find($item_id);
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

            $item = CrCommentaire::find($item_id);

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

    public function getAffectation(CrCommentaire $CrCommentaire)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
