<?php

use App\Models\Courrier\CrCourrier;
use App\Models\Messagerie\Discussion;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    // return (int) $user->id === (int) $id;
    return true;
});

Broadcast::channel('test', function ($user) {
    return true;
});


Broadcast::channel('discussion-{discussion}-channel', function ($user, $discussion) {
    $autorisation = Discussion::where('id', $discussion)->where(function ($q) use ($user, $discussion) {
        $q->whereCorrespondant($user->id);
        // ->orWhereHas('correspondance_personne_structure.structure.autorisations', function ($q) use ($user) {
        //     $q->where('personne_id', $user->id)->where('ecrire_messagerie', true);
        // });
    })->first();
    return isset($autorisation);
});


Broadcast::channel('courrier-{courrier}-channel', function ($user, CrCourrier $courrier) {
    $courrier = CrCourrier::where('suivi_par', $user->id)->orWhereHas('cr_reaffectations', function ($q) use ($user) {
        $q->where('suivi_par', $user->id);
    })->find($courrier->id);

    return isset($courrier);
});


Broadcast::channel('inbox', function ($user) {
    return isset($user);
});


Broadcast::channel('online', function ($user) {
    if (isset($user)) {
        return ['id' => $user->id, 'nom_complet' => $user->nom_complet];
    }
    return [];
});
