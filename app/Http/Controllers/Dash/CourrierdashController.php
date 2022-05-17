<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courrier\CrCourrier;
use App\Models\Dash\CrCourrierEntrant;
use App\Models\Dash\CrCourrierSortant;
use App\Models\Courrier\CrFichier;
use App\Models\Dash\Structure;
use App\Models\Dash\CrNature;
use App\Models\Dash\CrType;
use App\Models\Dash\CrStatut;
use Illuminate\Support\Facades\DB;
use App\Models\Dash\CrCoordonnee;

class CourrierdashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getsum()
    {
        DB::table('cr_courrier')->whereNull('cloture_id')->count();
        $total=DB::table('cr_courrier')->count();
        $entrant=DB::table('cr_courrier_entrant')->join('cr_provenance', 'cr_courrier_entrant.provenance', '=', 'cr_provenance.id')->where('cr_provenance.externe',1)->count();
        $sortant=DB::table('cr_courrier_sortant')->count();
        $interne=DB::table('cr_courrier_entrant')->join('cr_provenance', 'cr_courrier_entrant.provenance', '=', 'cr_provenance.id')->where('cr_provenance.externe',0)->count();
        $lastentrant=DB::table('cr_courrier_entrant')
        ->select('cr_courrier.libelle as libelle', 'cr_courrier_entrant.created_at as created_at', 'structures.cigle as cigle','structures.libelle as structure', 'cr_courrier_entrant.id as id', 'type_structures.libelle as type_structure')
        ->leftjoin('cr_provenance', 'cr_courrier_entrant.provenance', '=', 'cr_provenance.id')
        ->leftjoin('cr_courrier','cr_courrier_entrant.courrier_id', '=', 'cr_courrier.id')
        ->leftjoin('structures','structures.id', '=', 'cr_courrier.structure_id')
        ->leftjoin('type_structures','structures.type', '=', 'type_structures.id')
        ->where('cr_provenance.externe',1)
        ->Orderby('cr_courrier_entrant.id','desc')->limit(5)->get();
        $lastsortant=DB::table('cr_courrier_sortant')
        ->select('cr_courrier.libelle as libelle', 'cr_courrier_sortant.created_at as created_at','structures.cigle as cigle','structures.libelle as structure', 'cr_courrier_sortant.id as id', 'type_structures.libelle as type_structure')
        ->leftjoin('cr_courrier','cr_courrier_sortant.courrier_id', '=', 'cr_courrier.id')
        ->leftjoin('structures','structures.id', '=', 'cr_courrier.structure_id')
        ->leftjoin('type_structures','structures.type', '=', 'type_structures.id')
        ->Orderby('cr_courrier_sortant.id','desc')->limit(5)->get();
        $lastinterne=DB::table('cr_courrier_entrant')
        ->select('cr_courrier.libelle as libelle', 'cr_courrier_entrant.created_at as created_at', 'structures.cigle as cigle','structures.libelle as structure', 'cr_courrier_entrant.id as id', 'type_structures.libelle as type_structure')
        ->leftjoin('cr_provenance', 'cr_courrier_entrant.provenance', '=', 'cr_provenance.id')
        ->leftjoin('cr_courrier','cr_courrier_entrant.courrier_id', '=', 'cr_courrier.id')
        ->leftjoin('structures','structures.id', '=', 'cr_courrier.structure_id')
        ->leftjoin('type_structures','structures.type', '=', 'type_structures.id')
        ->where('cr_provenance.externe',0)
        ->Orderby('cr_courrier_entrant.id','desc')->limit(5)->get();
        $fichier=DB::table('fichier')->count();
        $traite=DB::table('cr_courrier')->whereNotNull('cloture_id')->count();
        $nontraite=DB::table('cr_courrier')->whereNull('cloture_id')->count();
        $entraitement=DB::table('cr_courrier')->whereNull('cloture_id')->count();
        $structure=DB::table('structures')->get();

        $structure->map(function($item)  {
            $cr =  DB::table('cr_courrier')->where('structure_id', $item->id)->get();
            $item->cr_courriers = $cr;
        });

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
            if($relation =='cr_courrier_entrants') {
                $query->whereHas('cr_courrier_entrants.cr_provenance', function ($query) {
                    $query->where('cr_provenance.externe',1);
                });
            }
            if($relation =='cr_courrier_internes') {
                $query->whereHas('cr_courrier_entrants.cr_provenance', function ($query) {
                    $query->where('cr_provenance.externe',0);
                });
            }
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
        $entrant=CrCourrierEntrant::whereHas('cr_provenance', function ($query) {
            $query->where('cr_provenance.externe',1);
        })->get();
        $sortant=CrCourrierSortant::get();
        $interne=CrCourrierEntrant::whereHas('cr_provenance', function ($query) {
            $query->where('cr_provenance.externe',0);
        })->get();

        return response()->json([
            'entrant'=>$entrant,
            'sortant'=>$sortant,
            'interne'=>$interne
        ]);
    }
    //Different courriers: entrant,sortant,interne par mois
    public function diffcrbymonth($month)
    {
        $entrant=CrCourrierEntrant::whereHas('cr_provenance', function ($query) {
            $query->where('cr_provenance.externe',1);
        })->whereMonth('created_at',$month)->get();
        $sortant=CrCourrierSortant::whereMonth('created_at',$month)->get();
        $interne=CrCourrierEntrant::whereHas('cr_provenance', function ($query) {
            $query->where('cr_provenance.externe',0);
        })->whereMonth('created_at',$month)->get();

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
        ->whereHas('cr_courrier.structure')->whereHas('cr_courrier_entrant.cr_coordonnee')->Orderby('id','desc')->get();
    }

    //Expediteur with courrier
    public function expediteurcr()
    {
        return CrCoordonnee::withCount('cr_courrier_entrants')->get();
    }



}
