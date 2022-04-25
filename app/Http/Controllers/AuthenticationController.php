<?php

namespace App\Http\Controllers;

use App\Models\Structure\Inscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    private function validateLoginRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:inscription,email',
            'password' => 'required'
        ]);
    }


    public function register(int $id, Request $request)
    {
        $request->validate(['conditions_utilisations' => 'required|accepted']);
        $user =  (new InscriptionController())->update($request, $id);
        $user->markEmailAsVerified();
        return $this->login($request);
    }

    public function login(Request $request)
    {
        $this->validateLoginRequest($request);
        $user = Inscription::where('email', $request->email)->first();
        if (password_verify($request->password, $user->password)) {
            // return response()->json(['message' => 'Erreur de connexionation'], 200);
            $token = $user->createToken('authToken');



            return response()->json([
                'access_token' => $token->plainTextToken,
                'user' => array_merge($user->toArray(), ['affectation_structure' => $user->affectation_structure()->with('structure:id,libelle,image,type', 'poste:id,libelle', 'fonction:id,libelle')->get()->first()->toArray()]),
                'structures' => $user->estDansStructures()->without('type', 'parent')->pluck('structures.id'),
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json(['message' => 'Erreur de connexion'], 401);
    }


    public function logout()
    {
        Auth::user()->tokens()->delete();;
        return null;
    }

    // public function

    public function me()
    {
        return Auth::user();
    }
}
