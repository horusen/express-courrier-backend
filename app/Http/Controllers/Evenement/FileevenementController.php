<?php

namespace App\Http\Controllers\Evenement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evenement\Fileevenement;
use Illuminate\Support\Facades\Auth;

class FileevenementController extends Controller
{
    private $auth;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Fileevenement::with('evenement','inscription')
        ->Orderby('id','DESC')
        ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'evenement'=> 'required|int',
            'nbfichier'=> 'required'
        ]);
        $reg = new  Fileevenement([
            'evenement'=>  $request->get('evenement'),
            'nom_fichier'=>  $request->get('nom_fichier')
        ]);
        if($request->has('nbfichier') && $request->nbfichier > 0){
            for($i = 0; $i < $request->nbfichier; $i++) {
                 $reg = new  Fileevenement([
                    'nom_fichier'=>  $request->file('fichier'.$i)->getClientOriginalName(),
                    'evenement'=>  $request->get('evenement')
                ]);
                $chemin= $request->file('fichier'.$i)->store('/public/evenement');
                $var=str_replace('public/evenement/','',$chemin);
                $reg->fichier=$var;
                $reg->inscription=Auth::id();
                $reg->save();
            }


        }


        return Fileevenement::where('evenement','=',$request->get('evenement'))->get();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Fileevenement = Fileevenement::findOrFail($id);
        $Fileevenement->update($request->all());
        return $Fileevenement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Fileevenement = Fileevenement::findOrFail($id);
        $Fileevenement->delete();

        return $Fileevenement;
    }
    public function filebyevent($id)
    {
        return Fileevenement::where('evenement',$id)->Orderby('id','DESC')->get();
    }


}
