<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\Structure\EmployeController;
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

Route::get('users/test', [InscriptionController::class, 'testNotification']);
Route::post('auth/login', [AuthenticationController::class, 'login']);
Route::get('auth/me', [AuthenticationController::class, 'me'])->middleware('auth:sanctum');


Route::get('email/verify', 'VerificationController@verify')->name('email.verify');
Route::get('user/{user}/email/resend', 'VerificationController@resend')->name('email.resend');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthenticationController::class, 'logout']);




    Route::apiResource('affectation-structures', 'Structures\AffectationStructureController')->except(['index', 'show']);

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
