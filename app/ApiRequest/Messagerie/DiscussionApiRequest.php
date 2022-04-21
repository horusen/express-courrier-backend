<?php

namespace App\ApiRequest\Messagerie;

use App\ApiRequest\ApiRequest;
use Illuminate\Database\Eloquent\Builder;

class DiscussionApiRequest extends ApiRequest
{

    public function search($builder, $keyword)
    {
        return $builder->whereHas('correspondance_personne', function ($q) use ($keyword) {
            $q->whereHas('user1', function ($q) use ($keyword) {
                $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
            })->orWhereHas('user2', function ($q) use ($keyword) {
                $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
            });
        })->orWhereHas('correspondance_personne_structure', function ($q) use ($keyword) {
            $q->whereHas('user', function ($q) use ($keyword) {
                $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
            })->orWhereHas('structure', function ($q) use ($keyword) {
                $q->where('libelle', 'like', '%' . $keyword . '%');
            });
        });
    }
}
