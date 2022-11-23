<?php

namespace App\Http\Controllers\Courrier;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrMail;
use App\Models\Ged\Fichier;
use App\Models\Ged\FichierType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrMailController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = CrMail::query();
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
            $query->where('inscription', Auth::id());
        }
    }


    public function filterSearchString(myBuilder $query, $method, $clauseOperator, $value)
    {
        if($value) {
            $query->orWhere('libelle', 'like', "%" .$value . "%");
        }
    }

    public function filterInboxIns(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('destinataire_personnes', function($query) use ($value){
                $query->where('inscription.id',  Auth::id() );
            });
        }
    }

    public function filterImportantIns(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('favoris', function($query) use ($value){
                $query->where('inscription.id',  Auth::id() );
            });
        }
    }

    public function filterEnvoyeIns(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('inscription_personne', function($query) use ($value){
                $query->where('inscription.id',  Auth::id() );
            });
        }
    }

    public function filterInboxRespIns(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereHas('destinataire_personnes', function($query) use ($value){
                $query->where('inscription.id',  Auth::id() );
            });
            $query->orWhere('cr_mail.inscription',  Auth::id() );
        }
    }

    public function filterHasNotRead(myBuilder $query, $method, $clauseOperator, $value, $in)
    {
        if($value) {
            $query->whereDoesntHave('vues', function ($query) use ($value) {
                $query->where('id_inscription', Auth::id());
            });
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $item = CrMail::create([
                'inscription' => Auth::id(),
                'libelle' => $request->libelle,
                'contenu' => $request->contenu,
                'mail' => $request->mail,
                'draft' => $request->draft,
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

                        $fichier->cr_mails()->attach([$item->id => ['inscription_id'=> Auth::id()]]);
                    }
                }
            }

            if($request->exists('destinataire_personnes'))
            {
                $json = utf8_encode($request->destinataire_personnes);
                $destinataire_personnes = json_decode($json);
                if(!is_array($destinataire_personnes))
                {
                    $destinataire_personnes = explode(',', $destinataire_personnes);
                }
                $pivotData = array_fill(0, count($destinataire_personnes), ['inscription_id'=> 1]);
                $attachData  = array_combine($destinataire_personnes, $pivotData);
                $item->destinataire_personnes()->attach($attachData);
            }

            if($request->exists('destinataire_structures'))
            {
                $json = utf8_encode($request->destinataire_structures);
                $destinataire_structures = json_decode($json);
                if(!is_array($destinataire_structures))
                {
                    $destinataire_structures = explode(',', $destinataire_structures);
                }
                $pivotData = array_fill(0, count($destinataire_structures), ['inscription_id'=> 1]);
                $attachData  = array_combine($destinataire_structures, $pivotData);
                $item->destinataire_structures()->attach($attachData);
            }


            DB::commit();
        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }

        return response()
        ->json($item->load(['destinataire_personnes',
        'destinataire_structures',
        'fichiers',
        'tags']));
    }

    public function update(Request $request, $id)
    {

        $item = CrMail::findOrFail($id);

        $data = $request->all();

        $item->fill($data)->save();

        return response()
        ->json($item->load(['destinataire_personnes',
        'destinataire_structures',
        'fichiers',
        'tags']));
    }

    public function destroy($id)
    {
        $item = CrMail::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function restore($id)
    {
        $restoreDataId = CrMail::withTrashed()->findOrFail($id);
        if($restoreDataId && $restoreDataId->trashed()){
           $restoreDataId->restore();
        }
        return response()
        ->json($restoreDataId->load(['destinataire_personnes',
        'destinataire_structures',
        'fichiers',
        'tags']));
    }

    public function markasread($id)
    {
        $item = CrMail::findOrFail($id);

        $item->vues()->syncWithoutDetaching(Auth::id());
        if($item->child()->count()) {
            foreach($item->child as $message) {
                $message->vues()->syncWithoutDetaching(Auth::id());
            }
        }
        return response()
        ->json(true);
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = CrMail::find($item_id);
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
        $item = CrMail::find($item_id);
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

            $item = CrMail::find($item_id);

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

    public function getAffectation($id)
    {
        $item = CrMail::findOrFail($id);

        $data['tags'] = $item->tags()->where('cr_mail_tag.inscription_id',Auth::id())->get();
        return response()
        ->json(['data' => $data]);
    }
}
