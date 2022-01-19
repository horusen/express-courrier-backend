<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ConditionsUtilisationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\Structure\EmployeController;
use App\Http\Controllers\Structure\FonctionController;
use App\Http\Controllers\Structure\PosteController;
use App\Http\Controllers\Structure\StructureController;
use App\Http\Controllers\Structure\TypeStructureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('users/{id}', [InscriptionController::class, 'show']);
Route::get('test', [InscriptionController::class, 'test']);


Route::get('conditions-utilisations', [ConditionsUtilisationController::class, 'show']);

Route::put('users/{id}', [InscriptionController::class, 'update']);

Route::post('auth/login', [AuthenticationController::class, 'login']);

// TODO: Changer le verb en PUT
Route::post('auth/register/{id}', [AuthenticationController::class, 'register']);
Route::get('auth/me', [AuthenticationController::class, 'me'])->middleware('auth:sanctum');


Route::get('register/check', 'VerificationController@check')->name('register.check');
Route::get('register/update', 'VerificationController@update')->name('register.update');
Route::get('email/verify', 'VerificationController@verify')->name('email.verify');
Route::get('user/{user}/email/resend', 'VerificationController@resend')->name('email.resend');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthenticationController::class, 'logout']);

    Route::get('postes/all', [PosteController::class, 'all']);
    Route::get('fonctions/all', [FonctionController::class, 'all']);


    Route::apiResource('affectation-structures', 'Structures\AffectationStructureController')->except(['index', 'show']);

    Route::post('employes', [EmployeController::class, 'store']);
    Route::put('employes/{employe}/validate', [EmployeController::class, 'validateEmploye']);
    Route::get('structures/{structure}/employes', [EmployeController::class, 'getByStructure']);
    Route::get('structures/{structure}/responsables', [EmployeController::class, 'getResponsablesByStructure']);


    Route::post('users', [InscriptionController::class, 'store']);



    Route::get('structures/types/all', [TypeStructureController::class, 'all']);

    Route::get('structures/all', [StructureController::class, 'all']);
    Route::get('structures/autres', [StructureController::class, 'getAutresStructures']);
    Route::get('structures/{structure}/oldest', [StructureController::class, 'getOldestAncestor']);
    Route::apiResource('structures', 'Structure\StructureController');
    Route::get('structures/{structure}/sous-structures', [StructureController::class, 'getSousStructures']);
    Route::get('structures/{structure}/sous-structures/all', [StructureController::class, 'getAllSousStructures']);



    Route::get('structures/{structure}/structure-et-sous-structures', [StructureController::class, 'getStructureEtSousStructures']);
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
