<?php


namespace App\Services\Authorization;

use App\Models\Authorization\Authorisation;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class AuthorisationService extends BaseService
{

    public function __construct(Authorisation $model)
    {
        parent::__construct($model);
    }

    // public function getAuthorisationsByRole($roles)
    // {
    //     $authorisations = [];
    //     foreach ($roles as $role) {
    //         $_authorisations = $this->model::where('role', $role->id)->get();
    //         foreach ($_authorisations as $authorisation) {
    //             array_push($authorisations, $authorisation);
    //         }
    //     }

    //     return $authorisations;
    // }


    public function getByRole($role)
    {
        return $this->model::where('role', $role)->get()->each->append(['scope_name', 'structure']);
    }


    public function deleteByRole($role)
    {
        $authorisations  = $this->model::where('role', $role)->get();
        foreach ($authorisations as $authorisation) {
            $authorisation->delete();
        }

        return null;
    }

    // public function getStringifiedAuthorizationsByRole($role)
    // {
    //     $authorisations = $this->getByRole
    //     return $this->stringifyAuthorisations($authorisations);
    // }



    public function stringifyAuthorisations($authorisations)
    {
        $stringyfiedAuthorisations = [];
        foreach ($authorisations as $authorisation) {
            $stringyfiedAuthorisation = $this->stringifyAuthorisation($authorisation);

            if (isset($stringyfiedAuthorisation))
                array_push($stringyfiedAuthorisations, $stringyfiedAuthorisation);
        }

        return $stringyfiedAuthorisations;
    }



    private function stringifyAuthorisation($authorisation)
    {
        if ($authorisation->authorisation == 'ADMIN') return preg_replace('~[^\pL\d]+~u', '-', $authorisation->scope()->get()->first()->libelle) . ':ADMIN';
        else if ($authorisation->authorisation == 'ECRITURE') return preg_replace('~[^\pL\d]+~u', '-', $authorisation->scope()->get()->first()->libelle) . ':ECRITURE';
        else if ($authorisation->authorisation == 'LECTURE') return preg_replace('~[^\pL\d]+~u', '-', $authorisation->scope()->get()->first()->libelle) . ':LECTURE';
        else return null;
    }
}
