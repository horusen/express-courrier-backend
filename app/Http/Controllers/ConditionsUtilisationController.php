<?php

namespace App\Http\Controllers;

use App\ConditionsUtilisation;
use Illuminate\Http\Request;

class ConditionsUtilisationController extends Controller
{
    public ConditionsUtilisation $model;


    public function __construct(ConditionsUtilisation $model)
    {
        $this->model = $model;
    }

    public function show()
    {
        return $this->model::first();
    }


    public function update(Request $request)
    {
        $element = $this->model::first();
        $element->update($request->all());
        return $element->refresh();
    }
}
