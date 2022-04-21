<?php

namespace App\Traits;

use App\Models\Messagerie\ExtensionFichier;
use App\Shared\Models\Fichier\Fichier;
use Exception;
use Illuminate\Support\Facades\Auth;

trait FileHandlerTrait
{
    protected $baseURL = 'http://localhost:8000/';

    public function storeFile($file, $path)
    {
        if (preg_match(ExtensionFichier::getRegex(), $file->getClientOriginalExtension())) {
            return $this->_storeFile($file, $path);
        } else {
            throw new Exception("Le format du fichier est incorrect", 500);
        }
    }

    public function storeAudioFile($file, $path)
    {
        if (preg_match(ExtensionFichier::getAudioRegex(), $file->getClientOriginalExtension())) {
            return $this->_storeFile($file, $path);
        } else {
            throw new Exception("Le format du fichier est incorrect", 500);
        }
    }

    public function storeImageFile($file, $path)
    {
        if (preg_match(ExtensionFichier::getImageRegex(), $file->getClientOriginalExtension())) {
            return $this->_storeFile($file, $path);
        } else {
            throw new Exception("Le format du fichier est incorrect", 500);
        }
    }


    public function storeVideoFile($file, $path)
    {
        if (preg_match(ExtensionFichier::getVideoRegex(), $file->getClientOriginalExtension())) {
            return $this->_storeFile($file, $path);
        } else {
            throw new Exception("Le format du fichier est incorrect", 500);
        }
    }


    public function storeDocumentFile($file, $path)
    {
        if (preg_match(ExtensionFichier::getDocumentRegex(), $file->getClientOriginalExtension())) {
            return $this->_storeFile($file, $path);
        } else {
            throw new Exception("Le format du fichier est incorrect", 500);
        }
    }

    private function _storeFile($file, $path)
    {

        // Create a unique name for the file
        $file_new_name = time() . str_replace(' ', '_', $file->getClientOriginalName());

        // Create a path for the file
        $pathToFile =  'uploads' . '/' . $path . '/' . $file->getClientOriginalExtension();

        // Move the renamed file in the new path
        $file->move($pathToFile, $file_new_name);

        // Get the id of the file extension in the database
        $idExtension = ExtensionFichier::where('libelle', $file->getClientOriginalExtension())->first()->id;

        // Create a new file in database
        $newFile = Fichier::create([
            'name' => $file->getClientOriginalName(),
            'extension' => $idExtension,
            // 'size' => $file->getSize(),
            'path' => $this->baseURL . $pathToFile . '/' . $file_new_name,
            'inscription' => Auth::id()
        ]);

        return $newFile;
    }
};
