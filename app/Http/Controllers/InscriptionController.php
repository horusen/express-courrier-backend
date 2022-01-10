<?php

namespace App\Http\Controllers;

use App\Models\Structure\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
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
            'email' => 'required|email|unique',
            'photo' => 'sometimes|image',
        ]);


        $inscription = Inscription::create($request->except('photo'));


        // TOFO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $imagePath = $file->storeAs('inscription/' . $inscription->email . '/photo', $file->getClientOriginalName(), 'public');
            $inscription->update(['photo' => $imagePath]);
        }


        return $inscription;
    }
}
