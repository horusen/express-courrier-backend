<?php

namespace App\Http\Controllers\Evenement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evenement\Evenement;
use Illuminate\Support\Facades\Auth;

class EvenementController extends Controller
{
    private $auth;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Evenement::with('participants.participant','inscription')->Orderby('id','DESC')->get();
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
            'libelle'=> 'required|string',
            'date'=> 'required|date',
            'objet'=> 'required|string',
            'description'=> 'required|string',
            'lieu'=> 'required|string',
            'heure_debut'=> 'required|string',
            'heure_fin'=> 'required|string',
            'type'=> 'required|string'
        ]);
        $reg = new  Evenement([
            'description'=> $request->get('description'),
            'libelle'=>  $request->get('libelle'),
            'date'=>  $request->get('date'),
            'objet'=>  $request->get('objet'),
            'lieu'=>  $request->get('lieu'),
            'heure_debut'=>  $request->get('heure_debut'),
            'heure_fin'=>  $request->get('heure_fin'),
            'type'=>  $request->get('type')
        ]);
        $reg->inscription=Auth::id();
        $reg->save();

        return $reg->load('participants.participant','inscription');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return Evenement::with('participants.participant','files','inscription')->where('id',$id)->first();
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
        $Evenement = Evenement::findOrFail($id);
        $Evenement->update($request->all());
        return $Evenement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Evenement = Evenement::findOrFail($id);
        $Evenement->delete();
        return $Evenement;
    }
     public function eventbyobjet($id)
    {
      return Evenement::with('participants.participant','files','inscription')
      ->where('objet',$id)->Orderby('id','desc')->get();
    }
}
