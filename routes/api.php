<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Authorization\RoleController;
use App\Http\Controllers\ConditionsUtilisationController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\Ged\DossierController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\Messagerie\DiscussionController;
use App\Http\Controllers\Messagerie\ReactionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleUserController;
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
Route::put('conditions-utilisations', [ConditionsUtilisationController::class, 'update']);

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

    Route::middleware('ability:ADMIN:ADMIN,structure:ECRITURE')->group(function () {
        Route::get('structures/{structure}/roles', [RoleController::class, 'getByStructure']);
        Route::get('structures/{structure}/roles/all', [RoleController::class, 'getAllByStructure']);
        Route::get('roles/{role}/users', [InscriptionController::class, 'getByRole']);
        Route::post('users/roles', [RoleUserController::class, 'store']);

        Route::apiResource('roles', "Authorization\RoleController")->middleware(['ability:ADMIN:ADMIN,ADMIN:ADMIN']);

        Route::apiResource('scopes', "Authorization\ScopeController");


        Route::get('structures/{structure}/postes', [PosteController::class, 'getByStructure']);
        Route::get('structures/{structure}/fonctions', [FonctionController::class, 'getByStructure']);

        Route::apiResource('postes', 'Structure\PosteController');
        Route::apiResource('fonctions', 'Structure\FonctionController');
    });

    Route::get('courriers', [CourrierController::class, 'index']);
    Route::get('users/{user}/courriers', [CourrierController::class, 'getByUser']);
    Route::get('test', [TestController::class, 'sendCourrierEvent']);

    Route::get('notifications', [NotificationController::class, 'getByUser']);

    // Route::apiResource('affectation-structures', 'Structures\AffectationStructureController')->except(['index', 'show']);
    Route::apiResource('notifications', 'NotificationController')->except(['index', 'create']);

    /* ** *************************************  * **/
    /* ** SAT Ecriture permission Start * **/
    /* ** ************************************* * **/

    Route::customResource('dossiers', 'Ged\DossierController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
    Route::customResource('fichiers', 'Ged\FichierController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
    Route::customResource('fichier-types', 'Ged\FichierTypeController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
    Route::customResource('ged-conservations', 'Ged\GedConservationRuleController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
    Route::customResource('ged-elements', 'Ged\GedElementController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
    Route::customResource('ged-partages', 'Ged\GedPartageController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");


    Route::prefix('courrier')->group(function () {

        Route::post('courrier-entrants/analyses-datas', 'Courrier\CrCourrierEntrantController@getAnalyse');
        Route::post('courrier-sortants/analyses-datas', 'Courrier\CrCourrierSortantController@getAnalyse');


        Route::customResource('actions', 'Courrier\CrActionController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('affectation-courriers', 'Courrier\CrAffectationCourrierController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('ampiliations', 'Courrier\CrAmpiliationController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('clotures', 'Courrier\CrClotureController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('commentaires', 'Courrier\CrCommentaireController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('coordonnees', 'Courrier\CrCoordonneeController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('courriers', 'Courrier\CrCourrierController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('courrier-entrants', 'Courrier\CrCourrierEntrantController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('courrier-etapes', 'Courrier\CrCourrierEtapeController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('courrier-sortants', 'Courrier\CrCourrierSortantController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('destinataires', 'Courrier\CrDestinataireController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('etapes', 'Courrier\CrEtapeController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('dossiers', 'Courrier\CrDossierController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        // Route::customResource('fichiers', 'Courrier\CrFichierController',['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('mails', 'Courrier\CrMailController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('mail-tags', 'Courrier\CrMailTagController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('moyen-suivis', 'Courrier\CrMoyenSuiviController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('natures', 'Courrier\CrNatureController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('provenances', 'Courrier\CrProvenanceController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('reaffectations', 'Courrier\CrReaffectationController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('statuts', 'Courrier\CrStatutController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('structure-copies', 'Courrier\CrStructureCopieController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('suivis', 'Courrier\CrSuiviController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('taches', 'Courrier\CrTacheController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('traitements', 'Courrier\CrTraitementController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('types', 'Courrier\CrTypeController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('urgences', 'Courrier\CrUrgenceController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
    });

    Route::prefix('json-form')->group(function () {
        Route::customResource('controls', 'Courrier\CrFormFieldController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('validators', 'Courrier\CrFormFieldValidatorController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
    });

    Route::prefix('marche-public')->group(function () {
        Route::get('marches/table-fournisseurs', 'MarchePublic\MpMarcheController@getTableauxFournisseur');
        Route::get('marches/table-partenaires', 'MarchePublic\MpMarcheController@getTableauxPartenaire');
        Route::get('marches/analyses', 'MarchePublic\MpMarcheController@getMarcheAnalyse');
        Route::post('marches/analyses-datas', 'MarchePublic\MpMarcheController@getAnalyse');

        Route::post('marche-etapes/change-position', 'MarchePublic\MpMarcheEtapeController@changePosition')->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::post('type-procedure-etapes/change-position', 'MarchePublic\MpTypeProcedureEtapeController@changePosition')->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");

        Route::customResource('marches', 'MarchePublic\MpMarcheController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('etapes', 'MarchePublic\MpEtapeController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('marche-etapes', 'MarchePublic\MpMarcheEtapeController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('type-marches', 'MarchePublic\MpTypeMarcheController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('type-procedures', 'MarchePublic\MpTypeProcedureController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
        Route::customResource('type-procedure-etapes', 'MarchePublic\MpTypeProcedureEtapeController', ['except' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:ECRITURE");
    });

    /* ** *************************************  * **/
    /* ** SAT Ecriture permission END * **/
    /* ** ************************************* * **/

    /* ** *************************************  * **/
    /* ** SAT Lecture Only permission Start * **/
    /* ** ************************************* * **/

    Route::post('dossiers/checkpassword/{id}', 'Ged\DossierController@checkPassword')->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
    Route::post('fichiers/checkpassword/{id}', 'Ged\FichierController@checkPassword')->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");


    Route::customResource('dossiers', 'Ged\DossierController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
    Route::customResource('fichiers', 'Ged\FichierController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
    Route::customResource('fichier-types', 'Ged\FichierTypeController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
    Route::customResource('ged-conservations', 'Ged\GedConservationRuleController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
    Route::customResource('ged-elements', 'Ged\GedElementController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
    Route::customResource('ged-partages', 'Ged\GedPartageController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");


    Route::prefix('courrier')->group(function () {

        Route::get('mails/markasread/{CrMail}', 'Courrier\CrMailController@markasread')->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");

        Route::customResource('actions', 'Courrier\CrActionController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('affectation-courriers', 'Courrier\CrAffectationCourrierController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('ampiliations', 'Courrier\CrAmpiliationController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('clotures', 'Courrier\CrClotureController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('commentaires', 'Courrier\CrCommentaireController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('coordonnees', 'Courrier\CrCoordonneeController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('courriers', 'Courrier\CrCourrierController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('courrier-entrants', 'Courrier\CrCourrierEntrantController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('courrier-etapes', 'Courrier\CrCourrierEtapeController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('courrier-sortants', 'Courrier\CrCourrierSortantController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('destinataires', 'Courrier\CrDestinataireController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('etapes', 'Courrier\CrEtapeController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('dossiers', 'Courrier\CrDossierController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        // Route::customResource('fichiers', 'Courrier\CrFichierController',['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('mails', 'Courrier\CrMailController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('mail-tags', 'Courrier\CrMailTagController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('moyen-suivis', 'Courrier\CrMoyenSuiviController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('natures', 'Courrier\CrNatureController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('provenances', 'Courrier\CrProvenanceController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('reaffectations', 'Courrier\CrReaffectationController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('statuts', 'Courrier\CrStatutController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('structure-copies', 'Courrier\CrStructureCopieController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('suivis', 'Courrier\CrSuiviController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('taches', 'Courrier\CrTacheController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('traitements', 'Courrier\CrTraitementController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('types', 'Courrier\CrTypeController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('urgences', 'Courrier\CrUrgenceController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
    });

    Route::prefix('json-form')->group(function () {
        Route::customResource('controls', 'Courrier\CrFormFieldController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
        Route::customResource('validators', 'Courrier\CrFormFieldValidatorController', ['only' => ['getAll']])->Middleware("ability:ADMIN:ADMIN,courrier-entrant:LECTURE");
    });

    // no middleware for marche because outside people can see.
    Route::prefix('marche-public')->group(function () {
        Route::customResource('marches', 'MarchePublic\MpMarcheController', ['only' => ['getAll']]);
        Route::customResource('etapes', 'MarchePublic\MpEtapeController', ['only' => ['getAll']]);
        Route::customResource('marche-etapes', 'MarchePublic\MpMarcheEtapeController', ['only' => ['getAll']]);
        Route::customResource('type-marches', 'MarchePublic\MpTypeMarcheController', ['only' => ['getAll']]);
        Route::customResource('type-procedures', 'MarchePublic\MpTypeProcedureController', ['only' => ['getAll']]);
        Route::customResource('type-procedure-etapes', 'MarchePublic\MpTypeProcedureEtapeController', ['only' => ['getAll']]);
    });

    /* ** *************************************  * **/
    /* ** SAT Lecture Only permission END * **/
    /* ** ************************************* * **/

    Route::get('employes/{id}', [EmployeController::class, 'show']);
    Route::middleware('ability:ADMIN:ADMIN,structure:ECRITURE')->group(function () {
        Route::put('employes/{employe}/validate', [EmployeController::class, 'validateEmploye']);
        Route::put('employes/{employe}', [EmployeController::class, 'update']);
        Route::post('employes', [EmployeController::class, 'store']);
    });

    Route::get('structures/{structure}/employes', [EmployeController::class, 'getByStructure']);
    Route::get('structures/{structure}/responsables', [EmployeController::class, 'getResponsablesByStructure']);


    Route::put('users/password', [InscriptionController::class, 'updatePassword']);
    Route::post('users', [InscriptionController::class, 'store']);



    Route::get('structures/types/all', [TypeStructureController::class, 'all']);

    // Route::get('structures/all', [StructureController::class, 'all']);
    Route::get('users/{user}/structures', [StructureController::class, 'getByUser']);
    Route::get('users/{user}/structuresWdossiers', [StructureController::class, 'getByUserWDossier']);
    Route::get('structures/autres', [StructureController::class, 'getAutresStructures']);
    Route::get('structures/{structure}/oldest', [StructureController::class, 'getOldestAncestor']);
    Route::apiResource('structures', 'Structure\StructureController')->except(['store', 'udpated', 'delete']);
    Route::apiResource('structures', 'Structure\StructureController')->only(['store', 'udpated', 'delete'])->middleware('ability:ADMIN:ADMIN,structure:ECRITURE');
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
    Route::get('discussions/{discussion}/fichiers', [ReactionController::class, 'getFichierByDiscussion']);
    Route::get('discussions/{discussion}', [DiscussionController::class, 'show']);

    // Messagerie

    // Discussion
    Route::get('structures/{structure}/discussions', [DiscussionController::class, 'getByStructure']);
    Route::get('discussions', [DiscussionController::class, 'getByUser']);
    Route::post('discussions', [DiscussionController::class, 'store']);
    Route::delete('discussions/{discussion}', [DiscussionController::class, 'delete']);
    Route::delete('discussions/{discussion}/structures/{structure}', [DiscussionController::class, 'delete']);

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





    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::customResource('users', 'UserController');

    Route::put('password/users', [InscriptionController::class, 'updatePassword']);

    // User show
    Route::get('users/{id}', [InscriptionController::class, 'show']);

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
});
