<?php

namespace App\Shared\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $model;
    protected $validation;
    protected $modelQuery;
    protected $inscription = 1;


    protected $baseURL = 'http://localhost:8000/';
    protected $omittedFieldOnTableStructure = [];
    protected $defaultOmittedFieldOnTableStructure = ['id', 'created_at', 'updated_at', 'deleted_at', 'inscription'];

    public function __construct(string $model, $validation)
    {
        $this->model = $model;
        $this->validation = $validation;
        $this->modelQuery = $model::query();
    }



    public function isValid(Request $request)
    {
        return $this->validate($request, $this->validation);
    }






    // public function download($file)
    // {
    //     $file = Fichier::find($file);
    //     $contentType = null;

    //     if (preg_match(ExtensionFichier::getImageRegex(), $file->extension()->get()->first()->libelle)) {
    //         $contentType = 'image/' . $file->extension()->get()->first()->libelle;
    //     } elseif (preg_match(ExtensionFichier::getDocumentRegex(), $file->extension()->get()->first()->libelle)) {
    //         $contentType = 'application/' . $file->extension()->get()->first()->libelle;
    //     }
    //     $headers = [
    //         'Content-Type' => $contentType
    //     ];
    //     $fileDownload = str_replace($this->baseURL, public_path() . '/', $file->path);
    //     return response()->download($fileDownload, $file->name, $headers, 'inline');
    // }









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
