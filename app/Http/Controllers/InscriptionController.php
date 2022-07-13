<?php

namespace App\Http\Controllers;

use App\Models\Structure\Inscription;
use App\Services\InscriptionService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends BaseController
{


    public function __construct(InscriptionService $service)
    {
        parent::__construct([], $service);
    }


    // TODO add image thumbnail to load image faster
    // public function store(Request $request)
    // {
    //     $this->service->validate($request);

    //     return $this->service->store($request);
    // }






    public function getByRole($role)
    {
        return $this->service->getByRole($role);
    }


    public function show(int $id)
    {
        return Inscription::findOrFail($id);
    }



    // TODO delete image on update
    public function update(Request $request, int $id)
    {
        $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required',
            'telephone' => 'required',
            'identifiant' => 'required',
            'sexe' => 'required|in:HOMME,FEMME',
            'email' => 'required|email',
            'photo' => 'sometimes|image',
            'password' => 'required|min:6|confirmed'
        ]);


        $inscription = Inscription::findOrFail($id);

        $inscription->update($request->except('photo'));


        // TOFO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $imagePath = $file->storeAs('inscription/' . $inscription->email . '/photo', $file->getClientOriginalName(), 'public');
            $inscription->update(['photo' => $imagePath]);
        }

        // $inscription->sendEmailVerificationNotification();


        return $inscription;
    }


    public function updatePassword(Request $request)
    {

        $this->validate($request, [
            'ancien_mdp' => 'required',
            'nouveau_mdp' => 'required|confirmed:confirmation_nouveau_mdp'
        ]);

        $user = Inscription::find(Auth::id());

        if (password_verify($request->ancien_mdp, $user->password)) {
            $user->update(['password' => $request->nouveau_mdp]);
            return $user;
        }

        return response()->json(['message' => 'Erreur mot de passe'], 422);
    }
}
