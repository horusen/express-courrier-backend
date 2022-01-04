<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('dossiers/checkpassword/{id}', 'Ged\DossierController@checkPassword');
Route::post('fichiers/checkpassword/{id}', 'Ged\FichierController@checkPassword');

Route::customResource('dossiers', 'Ged\DossierController');
Route::customResource('fichiers', 'Ged\FichierController');
Route::customResource('fichier-types', 'Ged\FichierTypeController');
Route::customResource('ged-conservations', 'Ged\GedConservationRuleController');
Route::customResource('ged-elements', 'Ged\GedElementController');
Route::customResource('ged-partages', 'Ged\GedPartageController');

Route::prefix('courrier')->group(function() {
    Route::customResource('actions', 'Courrier\CrActionController');
    Route::customResource('ampiliations', 'Courrier\CrAmpiliationController');
    Route::customResource('coordonnees', 'Courrier\CrCoordonneeController');
    Route::customResource('courriers', 'Courrier\CrCourrierController');
    Route::customResource('courrier-entrants', 'Courrier\CrCourrierEntrantController');
    Route::customResource('courrier-internes', 'Courrier\CrCourrierInterneController');
    Route::customResource('destinataires', 'Courrier\CrDestinataireController');
    Route::customResource('fichiers', 'Courrier\CrFichierController');
    Route::customResource('moyen-suivis', 'Courrier\CrMoyenSuiviController');
    Route::customResource('natures', 'Courrier\CrNatureController');
    Route::customResource('reaffectations', 'Courrier\CrReaffectationController');
    Route::customResource('structure-copies', 'Courrier\CrStructureCopieController');
    Route::customResource('suivis', 'Courrier\CrSuiviController');
    Route::customResource('traitements', 'Courrier\CrTraitementController');
    Route::customResource('types', 'Courrier\CrTypeController');
    Route::customResource('urgences', 'Courrier\CrUrgenceController');
});
