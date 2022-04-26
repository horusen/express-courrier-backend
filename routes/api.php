<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ConditionsUtilisationController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\Ged\DossierController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\Messagerie\DiscussionController;
use App\Http\Controllers\Messagerie\ReactionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Structure\EmployeController;
use App\Http\Controllers\Structure\FonctionController;
use App\Http\Controllers\Structure\PosteController;
use App\Http\Controllers\Structure\StructureController;
use App\Http\Controllers\Structure\TypeStructureController;
use App\Http\Controllers\TestController;
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
Route::get('structures/all', [StructureController::class, 'all']);


Route::get('conditions-utilisations', [ConditionsUtilisationController::class, 'show']);

// Route::put('users/{id}', [InscriptionController::class, 'update']);

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

    Route::get('courriers', [CourrierController::class, 'index']);
    Route::get('users/{user}/courriers', [CourrierController::class, 'getByUser']);
    Route::get('test', [TestController::class, 'sendCourrierEvent']);

    Route::get('notifications', [NotificationController::class, 'getByUser']);


    Route::apiResource('affectation-structures', 'Structures\AffectationStructureController')->except(['index', 'show']);
    Route::apiResource('notifications', 'NotificationController')->except(['index', 'create']);
    Route::post('dossiers/checkpassword/{id}', 'Ged\DossierController@checkPassword');
    Route::post('fichiers/checkpassword/{id}', 'Ged\FichierController@checkPassword');

    Route::customResource('dossiers', 'Ged\DossierController');
    Route::customResource('fichiers', 'Ged\FichierController');
    Route::customResource('fichier-types', 'Ged\FichierTypeController');
    Route::customResource('ged-conservations', 'Ged\GedConservationRuleController');
    Route::customResource('ged-elements', 'Ged\GedElementController');
    Route::customResource('ged-partages', 'Ged\GedPartageController');

    Route::prefix('courrier')->group(function () {
        Route::customResource('actions', 'Courrier\CrActionController');
        Route::customResource('affectation-courriers', 'Courrier\CrAffectationCourrierController');
        Route::customResource('ampiliations', 'Courrier\CrAmpiliationController');
        Route::customResource('clotures', 'Courrier\CrClotureController');
        Route::customResource('commentaires', 'Courrier\CrCommentaireController');
        Route::customResource('coordonnees', 'Courrier\CrCoordonneeController');
        Route::customResource('courriers', 'Courrier\CrCourrierController');
        Route::customResource('courrier-entrants', 'Courrier\CrCourrierEntrantController');
        Route::customResource('courrier-etapes', 'Courrier\CrCourrierEtapeController');
        Route::customResource('courrier-internes', 'Courrier\CrCourrierInterneController');
        Route::customResource('destinataires', 'Courrier\CrDestinataireController');
        Route::customResource('etapes', 'Courrier\CrEtapeController');
        Route::customResource('fichiers', 'Courrier\CrFichierController');
        Route::customResource('moyen-suivis', 'Courrier\CrMoyenSuiviController');
        Route::customResource('natures', 'Courrier\CrNatureController');
        Route::customResource('provenances', 'Courrier\CrProvenanceController');
        Route::customResource('reaffectations', 'Courrier\CrReaffectationController');
        Route::customResource('statuts', 'Courrier\CrStatutController');
        Route::customResource('structure-copies', 'Courrier\CrStructureCopieController');
        Route::customResource('suivis', 'Courrier\CrSuiviController');
        Route::customResource('taches', 'Courrier\CrTacheController');
        Route::customResource('traitements', 'Courrier\CrTraitementController');
        Route::customResource('types', 'Courrier\CrTypeController');
        Route::customResource('urgences', 'Courrier\CrUrgenceController');
    });

    Route::prefix('json-form')->group(function () {
        Route::customResource('controls', 'Courrier\CrFormFieldController');
        Route::customResource('validators', 'Courrier\CrFormFieldValidatorController');
    });

    Route::get('employes/{id}', [EmployeController::class, 'show']);
    Route::put('employes/{employe}/validate', [EmployeController::class, 'validateEmploye']);
    Route::put('employes/{employe}', [EmployeController::class, 'update']);
    Route::post('employes', [EmployeController::class, 'store']);
    Route::get('structures/{structure}/employes', [EmployeController::class, 'getByStructure']);
    Route::get('structures/{structure}/responsables', [EmployeController::class, 'getResponsablesByStructure']);


    Route::put('users/password', [InscriptionController::class, 'updatePassword']);
    Route::post('users', [InscriptionController::class, 'store']);



    Route::get('structures/types/all', [TypeStructureController::class, 'all']);

    // Route::get('structures/all', [StructureController::class, 'all']);
    Route::get('structures/autres', [StructureController::class, 'getAutresStructures']);
    Route::get('structures/{structure}/oldest', [StructureController::class, 'getOldestAncestor']);
    Route::apiResource('structures', 'Structure\StructureController');
    Route::get('structures/{structure}/sous-structures', [StructureController::class, 'getSousStructures']);
    Route::get('structures/{structure}/sous-structures/all', [StructureController::class, 'getAllSousStructures']);



    Route::get('structures/{structure}/structure-et-sous-structures', [StructureController::class, 'getStructureEtSousStructures']);

    Route::get('dossiers', [DossierController::class, 'getAll']);


    Route::post('discussions/check', [DiscussionController::class, 'check']);
    Route::get('discussions/all', [DiscussionController::class, 'all']);
    Route::post('reactions', [ReactionController::class, 'store']);
    Route::delete('reactions/{reaction}', [ReactionController::class, 'delete']);
    Route::delete('reactions/{reaction}/structure/{structure}', [ReactionController::class, 'delete']);
    Route::get('discussions/{discussion}/reactions', [ReactionController::class, 'getByDiscussion']);
    Route::get('discussions/{discussion}', [DiscussionController::class, 'show']);

    // Messagerie

    // Discussion
    Route::get('structures/{structure}/discussions', [DiscussionController::class, 'getByStructure']);
    Route::get('discussions', [DiscussionController::class, 'getByUser']);
    Route::post('discussions', [DiscussionController::class, 'store']);
    Route::delete('discussions/{discussion}', [DiscussionController::class, 'delete']);
    Route::delete('discussions/{discussion}/structures/{structure}', [DiscussionController::class, 'delete']);

    Route::customResource('dossiers', 'Ged\DossierController');
    Route::customResource('users', 'UserController');
    Route::customResource('fichiers', 'Ged\FichierController');
    Route::customResource('fichier-types', 'Ged\FichierTypeController');
    Route::customResource('ged-conservations', 'Ged\GedConservationRuleController');
    Route::customResource('ged-elements', 'Ged\GedElementController');
    Route::customResource('ged-partages', 'Ged\GedPartageController');

    Route::prefix('courrier')->group(function () {
        Route::customResource('actions', 'Courrier\CrActionController');
        Route::customResource('ampiliations', 'Courrier\CrAmpiliationController');
        Route::customResource('coordonnees', 'Courrier\CrCoordonneeController');
        Route::customResource('courriers', 'Courrier\CrCourrierController');
        Route::customResource('courrier-entrants', 'Courrier\CrCourrierEntrantController');
        Route::customResource('courrier-internes', 'Courrier\CrCourrierInterneController');
        Route::customResource('courrier-sortants', 'Courrier\CrCourrierSortantController');
        Route::customResource('destinataires', 'Courrier\CrDestinataireController');
        Route::customResource('etapes', 'Courrier\CrEtapeController');
        Route::customResource('fichiers', 'Courrier\CrFichierController');
        Route::customResource('moyen-suivis', 'Courrier\CrMoyenSuiviController');
        Route::customResource('natures', 'Courrier\CrNatureController');
        Route::customResource('reaffectations', 'Courrier\CrReaffectationController');
        Route::customResource('statuts', 'Courrier\CrStatutController');
        Route::customResource('structure-copies', 'Courrier\CrStructureCopieController');
        Route::customResource('suivis', 'Courrier\CrSuiviController');
        Route::customResource('traitements', 'Courrier\CrTraitementController');
        Route::customResource('types', 'Courrier\CrTypeController');
        Route::customResource('urgences', 'Courrier\CrUrgenceController');
    });

    //Evenement
    Route::resource('evenement', 'Evenement\EvenementController');
    Route::get('eventbyobjet/{id}', 'Evenement\EvenementController@eventbyobjet');
    Route::resource('fichierevent', 'Evenement\FileevenementController');
    Route::get('filebyevent/{id}', 'Evenement\FileevenementController@filebyevent');
    Route::resource('commentevent', 'Evenement\CommentevenementController');
    Route::get('commentbyevent/{id}', 'Evenement\CommentevenementController@commentbyevenement');
    Route::resource('participevent', 'Evenement\ParticipevenementController');
    Route::resource('sharedevent', 'Evenement\SharedevenementController');
    Route::get('getAlluserLikename/{name}', 'Evenement\UsereventController@getAlluserLikename');
    //Tableau d'objectif
    Route::resource('tabobjectif', 'Tableauobjectif\TableauobjectifController');
    Route::get('tabobjectbyobjet/{id}', 'Tableauobjectif\TableauobjectifController@tabbyobjet');
    Route::resource('sharedtabobj', 'Tableauobjectif\SharedtabobjectifController');
    Route::resource('commenttabobj', 'Tableauobjectif\CommenttabobjectifController');
    Route::get('commentbytabobj/{id}', 'Tableauobjectif\CommenttabobjectifController@commentbyobjectif');

    //Mur d'idée
    Route::resource('muridee', 'Muridee\MurideeController');
    Route::resource('commentmuridee', 'Muridee\CommentmurideeController');
    Route::get('commentbymuridee/{id}', 'Muridee\CommentmurideeController@commentbymur');
    Route::resource('sharedmuridee', 'Muridee\SharedmurideeController');
    Route::resource('likemuridee', 'Muridee\LikemurideeController');



    //Dashboard
    Route::get('sumaccueildash', 'Dash\CourrierdashController@getsum');
    Route::get('structdash/{rela}', 'Dash\CourrierdashController@getstruct');
    Route::get('natudash/{rela}', 'Dash\CourrierdashController@getnature');
    Route::get('typedash/{rela}', 'Dash\CourrierdashController@gettype');
    Route::get('statutdash/{rela}', 'Dash\CourrierdashController@getstatut');
    Route::get('allstructdash', 'Dash\CourrierdashController@getallstruct');
    Route::get('crbystructdash/{id}', 'Dash\CourrierdashController@courrierbystruct');
    Route::get('diffcrdash', 'Dash\CourrierdashController@diffcr');
    Route::get('diffcrbymonthdash/{id}', 'Dash\CourrierdashController@diffcrbymonth');
    Route::get('timingdash', 'Dash\CourrierdashController@timing');
    Route::get('expediteurdash', 'Dash\CourrierdashController@expediteurcr');

    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::customResource('users', 'UserController');

    Route::put('password/users', [InscriptionController::class, 'updatePassword']);

    // User show
    Route::get('users/{id}', [InscriptionController::class, 'show']);
});
