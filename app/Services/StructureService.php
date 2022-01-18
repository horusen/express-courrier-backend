<?php

namespace App\Services;

use App\Exceptions\ActionNotAllowedException;
use App\Filters\Structure\StructureFilter as StructureStructureFilter;
use App\Filters\StructureFilter;
use App\Models\Structure\Structure;
use App\Traits\Structure\AdminTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StructureService
{
    use AdminTrait;


    public function all(StructureStructureFilter $filter)
    {
        return Structure::filter($filter)->paginate(5);
    }

    public function store($data)
    {
        // On verifie si le user connécté a les droits pour cree
        if (!$this->isSuperAdmin(Auth::id()) || !(Arr::has($data, 'parent_id') && $this->isAdmin(Auth::id(), $data['parent_id']))) {
            throw new ActionNotAllowedException();
        }


        $structure = Structure::create($data + ['inscription' => Auth::id()]);

        if (Arr::has($data, 'image')) {
            $file = $data['image'];
            $structure->update(['image' => $file->storeAs('structure/' . $structure->id . '/image', $file->getClientOriginalName(), 'public')]);
        }

        return $structure;
    }


    // private function isAdmin
}
