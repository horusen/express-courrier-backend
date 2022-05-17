<?php

namespace App\Http\Controllers\Courrier;

use App\Events\CourrierTraiterEvent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrCourrier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

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

        $item = CrCourrier::create([
            'inscription_id' => Auth::id(),
            'libelle' => $request->libelle,
            'objet' => $request->objet,
            'date_redaction' => $request->date_redaction,
            'date_cloture' => $request->date_cloture,
            'commentaire' => $request->commentaire,
            'valider' => $request->valider,
            'numero_facture' => $request->numero_facture,
            'devise' => $request->devise,
            'montant' => $request->montant,
            'type_id' => $request->type_id,
            'nature_id' => $request->nature_id,
            'structure_id' => $request->structure_id,
            'suivi_par' => $request->suivi_par,
            'date_limit' => $request->date_limit,
        ]);

        return response()
        ->json($item->load([
            'cr_statut',
        'cr_type',
        'cr_nature',
        'cr_urgence',
        'cr_cloture',
        'cr_courrier_etapes',
        'structure_copie_traitements',
        'structure_copie_informations',
        ]));
    }

    public function update(Request $request, $id)
    {

        $item = CrCourrier::findOrFail($id);

        $data = $request->all();

        if($request->reopenCourrier) {
            $data['cloture_id'] = null;
            $data['date_cloture']  = null;
            $data['message_cloture'] = null;
        }

        $item->fill($data)->save();

        if($request->exists('cloture_id')) {

            $link ="";
            if($item->cr_courrier_entrants()->count()) {
                $link = 'courrier/entrant/'.$item->cr_courrier_entrants()->first()->id;
            } else if($item->cr_courrier_sortants()->count()) {
                $link = 'courrier/sortant/'.$item->cr_courrier_sortants()->first()->id;
            }
            Notification::create([
                'message' => 'Le traitement du courrier <b>'.$item->libelle.'</b> est terminé',
                'element' => 'courrier traiter',
                'element_id' => $item->id,
                'inscription' => Auth::id(),
                'user' => Auth::id(),
                'link' => $link,
            ]);

            $inscriptions = $item->cr_reaffected_inscriptions()->where('inscription','!=', Auth::id())->get();
            $inscriptions->unique()->each(function($inscript) use ($item,$link)  {
                Notification::create([
                    'message' => 'Le traitement du courrier <b>'.$item->libelle.'</b> est terminé',
                    'element' => 'courrier traiter',
                    'element_id' => $item->id,
                    'inscription' => Auth::id(),
                    'user' => $inscript->id,
                    'link' => $link,
                ]);
            });

            broadcast(new CourrierTraiterEvent($item))->toOthers();
        }

        return response()
        ->json($item->load([
            'cr_statut',
        'cr_type',
        'cr_nature',
        'cr_urgence',
        'cr_cloture',
        'cr_courrier_etapes',
        'structure_copie_traitements',
        'structure_copie_informations',
        ]));
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

    public function getAffectation(CrCourrier $CrCourrier)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
