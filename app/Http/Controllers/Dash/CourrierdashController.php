<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courrier\CrCourrier;
use App\Models\Courrier\CrCourrierEntrant;
use App\Models\Courrier\CrCourrierInterne;
use App\Models\Courrier\CrCourrierSortant;
use App\Models\Courrier\CrFichier; 
use App\Models\Dash\Structure; 
use App\Models\Courrier\CrNature; 
use App\Models\Courrier\CrType; 
use App\Models\Courrier\CrStatut; 
use Illuminate\Support\Facades\DB;
use App\Models\Courrier\CrCoordonnee;

class CourrierdashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function getsum()
    {
        $total=CrCourrier::count();
        $entrant=CrCourrierEntrant::count();
        $sortant=CrCourrierSortant::count();
        $interne=CrCourrierInterne::count();
        $lastentrant=CrCourrierEntrant::with('cr_courrier.structure.type_structure')
        ->Orderby('id','desc')->limit(5)->get();
        $lastsortant=CrCourrierSortant::with('cr_courrier.structure.type_structure')
        ->Orderby('id','desc')->limit(5)->get();
        $lastinterne=CrCourrierInterne::with('cr_courrier.structure.type_structure')
        ->Orderby('id','desc')->limit(5)->get();
        $fichier=CrFichier::count();
        $traite=CrCourrier::where('statut_id','=',1)->count();
        $nontraite=CrCourrier::where('statut_id','=',2)->count();
        $entraitement=CrCourrier::where('statut_id','=',3)->count();
        $structure=Structure::with('cr_courriers')->get();

        return response()->json([
            'total'=>$total,
            'entrant'=>$entrant,
            'sortant'=>$sortant,
            'interne'=>$interne,
            'lastentrant'=>$lastentrant,
            'lastsortant'=>$lastsortant,
            'lastinterne'=>$lastinterne,
            'fichier'=>$fichier,
            'traite'=>$traite,
            'nontraite'=>$nontraite,
            'entraitement'=>$entraitement,
            'structure'=>$structure
        ]);

    }
    //Il serait possible d'optimiser les methodes
    //    public function getnature($model,$relation) 
    // {
    //    return $model::with('cr_courriers')
    //     ->whereHas('cr_courriers',function($query) use ($relation){
    //         $query->has($relation);
    //      })->get();
    // }
    //Structure courrier
    public function getstruct($relation) 
    {
        return Structure::with(['cr_courriers'=>function($query) use($relation){
            $query->has($relation);
            $query->with($relation);
        }])
       ->has('cr_courriers.'.$relation)->get();
    
    }
    //Nature Courrier
    public function getnature($relation) 
    {
        return CrNature::with(['cr_courriers'=>function($query) use($relation){
            $query->has($relation);
            $query->with($relation);
        }])
       ->has('cr_courriers.'.$relation)->get();
    }
    //Type
    public function gettype($relation) 
    {
        return CrType::with(['cr_courriers'=>function($query) use($relation){
            $query->has($relation);
            $query->with($relation);
        }])
       ->has('cr_courriers.'.$relation)->get();
    }
    //Statut
    public function getstatut($relation) 
    {
        return CrStatut::with(['cr_courriers'=>function($query) use($relation){
            $query->has($relation);
            $query->with($relation);
        }])
       ->has('cr_courriers.'.$relation)->get();

    }
    //All structure
    public function getallstruct()
    {
        return Structure::with('type_structure','cr_courriers')->get();
    }
    //Courrier by structure, nature, type,statut
    public function courrierbystruct($id)
    {
        $statut=CrStatut::with('cr_courriers')
        ->whereHas('cr_courriers',function($query) use ($id){
            $query->where('structure_id','=',$id);
        })->get();
        $nature=CrNature::with('cr_courriers')
        ->whereHas('cr_courriers',function($query) use ($id){
            $query->where('structure_id','=',$id);
        })->get();
        $type=CrType::with('cr_courriers')
        ->whereHas('cr_courriers',function($query) use ($id){
            $query->where('structure_id','=',$id);
        })->get();

        return response()->json([
            'statut'=>$statut,
            'nature'=>$nature,
            'type'=>$type
        ]);

    }
    //Diffent courriers:entrant,sortant,interne
    public function diffcr()
    {
        $entrant=CrCourrierEntrant::get();
        $sortant=CrCourrierSortant::get();
        $interne=CrCourrierInterne::get();
    
        return response()->json([
            'entrant'=>$entrant,
            'sortant'=>$sortant,
            'interne'=>$interne
        ]);
    }
    //Different courriers: entrant,sortant,interne par mois
    public function diffcrbymonth($month)
    {
        $entrant=CrCourrierEntrant::whereMonth('created_at',$month)->get();
        $sortant=CrCourrierSortant::whereMonth('created_at',$month)->get();
        $interne=CrCourrierInterne::whereMonth('created_at',$month)->get();
    
        return response()->json([
            'entrant'=>$entrant,
            'sortant'=>$sortant,
            'interne'=>$interne
        ]);
    }

    //Get timing reponse courrier
    public function timing()
    {
        return CrCourrierSortant::with('cr_courrier.structure','cr_courrier_entrant.cr_coordonnee')
        ->Orderby('id','desc')->get();
    }
    //Expediteur with courrier
    public function expediteurcr()
    {
        return CrCoordonnee::withCount('cr_courrier_entrants')->get();
    }



}
