<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\Structure\EmployeController;
use App\Http\Controllers\Structure\StructureController;
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

Route::post('auth/login', [AuthenticationController::class, 'login']);
Route::get('auth/me', [AuthenticationController::class, 'me'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthenticationController::class, 'logout']);


    Route::apiResource('structures', 'Structure\StructureController');
    Route::get('structures/{structure}/sous-structures', [StructureController::class, 'getSousStructures']);

    Route::apiResource('affectation-structures', 'Structures\AffectationStructureController')->except(['index', 'show']);

    Route::get('structures/{structure}/employes', [EmployeController::class, 'getByStructure']);
    Route::get('structures/{structure}/responsables', [EmployeController::class, 'getResponsablesByStructure']);


    Route::post('users', [InscriptionController::class, 'store']);
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
