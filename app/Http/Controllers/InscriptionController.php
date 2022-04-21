<?php

namespace App\Http\Controllers;

use App\Models\Structure\Inscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Swift_TransportException;

class InscriptionController extends Controller
{




    // TODO add image thumbnail to load image faster
    public function store(Request $request)
    {
        $this->service->validate($request);

        return $this->service->store($request);
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
}
