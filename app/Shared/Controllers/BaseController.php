<?php

namespace App\Shared\Controllers;

use App\ApiRequest\ApiRequest;
use App\Http\Controllers\Controller;
use App\Services\BaseService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $validation;
    protected $service;
    protected $apiRequest;



    public function __construct(array $validation, BaseService $service, ApiRequest $apiRequest = null)
    {
        $this->validation = $validation;
        $this->service = $service;
        $this->apiRequest = $apiRequest;
    }


    public function index()
    {
        return $this->service->list($this->apiRequest);
    }



    public function store(Request $request)
    {
        $request->validate($this->validation);
        return $this->service->store($request->all());
    }


    public function update(Request $request, int $id)
    {
        $request->validate($this->validation);
        return $this->service->update($id, $request->all());
    }



    public function show(int $id)
    {
        return $this->service->show($id);
    }


    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public static  function static_many_to_many_update($new_array, $old_array, $affectation_model, $model_field, $foreign_field, $model_id, $inscription)
    {
        foreach ($old_array  as $item) {
            if (!in_array($item, $new_array)) {
                $element = $affectation_model::where($model_field, $model_id)->where($foreign_field, $item)->first();
                if ($element) {
                    $element->delete();
                }
            }
        }

        foreach ($new_array as $item) {
            if (!in_array($item, $old_array)) {
                $affectation = $affectation_model::create([
                    $model_field => $model_id,
                    $foreign_field => $item,
                    'inscription' => $inscription
                ]);
            }
        }
    }




    protected function many_to_many_update($new_array, $old_array, $affectation_model, $model_field, $foreign_field, $model_id, $inscription)
    {
        foreach ($old_array  as $item) {
            if (!in_array($item, $new_array)) {
                $element = $affectation_model::where($model_field, $model_id)->where($foreign_field, $item)->first();
                if ($element) {
                    $element->delete();
                }
            }
        }

        foreach ($new_array as $item) {
            if (!in_array($item, $old_array)) {
                $affectation = $affectation_model::create([
                    $model_field => $model_id,
                    $foreign_field => $item,
                    'inscription' => $inscription
                ]);
            }
        }
    }

    protected function many_to_many_add($array, $affectation_model, $model_field, $foreign_field, $model_id, $inscription)
    {
        foreach ($array as $item) {
            $affectation = $affectation_model::create([
                $model_field => $model_id,
                $foreign_field => $item,
                'inscription' => $inscription
            ]);
        }
    }


    protected function idExtractor($array)
    {
        $ids = [];
        foreach ($array as $item) {
            array_push($ids, $item->id);
        }

        return $ids;
    }


    protected function responseError($error_message, $status_code)
    {
        return response()->json(['message' => $error_message], $status_code);
    }


    protected function responseSuccess()
    {
        return response()->json(null, 200);
    }


    // protected function search(Request $request)
    // {
    //     $this->validate($request, [
    //         'word' => 'required',
    //         'fields' => 'required|array'
    //     ]);



    //     if (isset($request->word)) {
    //         return $this->model::latest()->get();
    //     }

    //     $elements =  $this->model::whereNull('deleted_at');
    //     foreach ($request->fields as $field) {
    //         $elements = $elements->where($field, 'like', '%' . $request->word . '%');
    //     }

    //     return $elements->get();
    // }
}
