<?php

use App\Models\Ged\FichierType;
use Illuminate\Database\Seeder;

class FichierTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FichierType::create([
            'libelle' => 'audio',
            'icon' => 'fad fa-file-music tx-warning',
            'extension' => 'mp3',
            'inscription_id' => 1
        ]);

        FichierType::create([
            'libelle' => 'document',
            'icon' => 'fad fa-file-word tx-facebook',
            'extension' => 'doc, docx, dot',
            'inscription_id' => 1
        ]);

        FichierType::create([
            'libelle' => 'pdf',
            'icon' => 'fad fa-file-pdf tx-danger',
            'extension' => 'pdf',
            'inscription_id' => 1
        ]);

        FichierType::create([
            'libelle' => 'excel',
            'icon' => 'fad fa-file-excel tx-success',
            'extension' => 'xls, xlt',
            'inscription_id' => 1
        ]);

        FichierType::create([
            'libelle' => 'archive',
            'icon' => 'fad fa-file-archive tx-yeto2',
            'extension' => 'rar, zip',
            'inscription_id' => 1
        ]);

        FichierType::create([
            'libelle' => 'video',
            'icon' => 'fad fa-file-video tx-youtube',
            'extension' => 'mp4',
            'inscription_id' => 1
        ]);

        FichierType::create([
            'libelle' => 'image',
            'icon' => 'fad fa-image tx-teal',
            'extension' => 'png, jpg, jpeg',
            'inscription_id' => 1
        ]);
    }
}
