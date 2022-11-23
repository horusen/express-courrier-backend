<?php

namespace App\Http\Controllers\Courrier;

use App\Events\CourrierTranfererEvent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as myBuilder;
use App\Http\Shared\Optimus\Bruno\EloquentBuilderTrait;
use App\Http\Shared\Optimus\Bruno\LaravelController;
use App\Models\Courrier\CrReaffectation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class CrReaffectationController extends LaravelController
{
    use EloquentBuilderTrait;

    public function getAll(Request $request)
    {

        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        $query = CrReaffectation::query();
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

        $item = CrReaffectation::create([
            'inscription_id' => Auth::id(),
            'libelle' => $request->libelle,
            'courrier_id' => $request->courrier_id,
            'confirmation' => $request->confirmation,
            'annulation' => $request->annulation,
            'structure_id' => $request->structure_id,
            'suivi_par' => $request->suivi_par,
        ]);

        $item->load(['cr_courrier', 'suivi_par_inscription']);

        $link ="";
        if($item->cr_courrier->cr_courrier_entrants()->count()) {
            $link = 'courrier/entrant/'.$item->cr_courrier->cr_courrier_entrants()->first()->id;
        } else if($item->cr_courrier->cr_courrier_sortants()->count()) {
            $link = 'courrier/sortant/'.$item->cr_courrier->cr_courrier_sortants()->first()->id;
        }

        Notification::create([
            'message' => 'Le courrier <b>'.$item->cr_courrier->libelle.'</b> a est en cours de transfert vers '.$item->suivi_par_inscription->prenom.' '.$item->suivi_par_inscription->nom,
            'element' => 'courrier transferer',
            'element_id' => $item->cr_courrier->id,
            'inscription' => Auth::id(),
            'user' => $request->suivi_par,
            'link' => $link,
        ]);


        return response()
        ->json($item->load([
            'inscription',
        'suivi_par_inscription',
        'structure'
        ]));
    }

    public function update(Request $request, $id)
    {

        $item = CrReaffectation::findOrFail($id);

        $data = $request->all();

        $item->fill($data)->save();

$item->load(['cr_courrier', 'suivi_par_inscription']);

        $link ="";
        if($item->cr_courrier->cr_courrier_entrants()->count()) {
            $link = 'courrier/entrant/'.$item->cr_courrier->cr_courrier_entrants()->first()->id;
        } else if($item->cr_courrier->cr_courrier_sortants()->count()) {
            $link = 'courrier/sortant/'.$item->cr_courrier->cr_courrier_sortants()->first()->id;
        }

        $message = '';
        
        if($item->confirmation) {
           $message = 'Le courrier <b>'.$item->cr_courrier->libelle.'</b>  a été tranféré à '.$item->suivi_par_inscription->prenom.' '.$item->suivi_par_inscription->nom;
        } else {
           $message = 'Le transfet du courrier <b>'.$item->cr_courrier->libelle.'</b>  à '.$item->suivi_par_inscription->prenom.' '.$item->suivi_par_inscription->nom.' a été annuler';
        }

        Notification::create([
            'message' => $message,
            'element' => 'courrier transferer',
            'element_id' => $item->cr_courrier->id,
            'inscription' => Auth::id(),
            'user' => $request->suivi_par,
            'link' => $link,
        ]);


        return response()
        ->json($item->load([
            'inscription',
        'suivi_par_inscription',
        'structure'
        ]));

    }

    public function destroy($id)
    {
        $item = CrReaffectation::findOrFail($id);

        $item->delete();

        return response()
        ->json(['msg' => 'Suppression effectué']);
    }

    public function restore($id)
    {
        $restoreDataId = CrReaffectation::withTrashed()->findOrFail($id);
        if($restoreDataId && $restoreDataId->trashed()){
           $restoreDataId->restore();
        }
        return response()
        ->json($restoreDataId->load([
            'inscription',
        'suivi_par_inscription',
        'structure'
        ]));
    }

    public function attachAffectation(Request $request)
    {

        $item_id = $request->id;
        $relation_name = $request->relation_name;
        $relation_id = $request->relation_id;
        $item = CrReaffectation::find($item_id);
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
        $item = CrReaffectation::find($item_id);
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

            $item = CrReaffectation::find($item_id);

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

    public function getAffectation(CrReaffectation $CrReaffectation)
    {

        return response()
        ->json(['data' => 'need to update it']);
    }
}
