<?php

namespace App\Http\Controllers;

use App\Models\Structure\Inscription;
use Exception;
use Illuminate\Http\Request;
use Swift_TransportException;

class InscriptionController extends Controller
{

    public function test(Request $request)
    {
        // return ['url' => url()->full()];
    }


    // TODO add image thumbnail to load image faster
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required',
            'telephone' => 'required',
            'identifiant' => 'required',
            'sexe' => 'required|in:HOMME,FEMME',
            'email' => 'required|email|unique:inscription,email',
            'photo' => 'sometimes|image',
        ]);


        $inscription = Inscription::create($request->except('photo'));


        // TOFO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $imagePath = $file->storeAs('inscription/' . $inscription->email . '/photo', $file->getClientOriginalName(), 'public');
            $inscription->update(['photo' => $imagePath]);
        }

        try {
            $inscription->sendEmailVerificationNotification();
        } catch (Exception $e) {
            $inscription->forceDelete();
            throw new Swift_TransportException($e);
        }


        return $inscription;
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
