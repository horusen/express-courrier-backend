<?php

namespace App\Http\Controllers\Tableauobjectif;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tableauobjectif\Tableauobjectif;
use Illuminate\Support\Facades\Auth;

class TableauobjectifController extends Controller
{
    private $auth;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tableauobjectif::with('inscription')->Orderby('id','DESC')->get();
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
            'objet'=> 'required|string',
            'description'=> 'required|string',
            'couleur'=> 'required|string'
        ]);
        $reg = new  Tableauobjectif([
            'description'=> $request->get('description'),
            'libelle'=>  $request->get('libelle'),
            'objet'=>  $request->get('objet'),
            'couleur'=>  $request->get('couleur')
        ]);
        $reg->inscription=Auth::id();
        $reg->save();

        return $reg;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return Tableauobjectif::with('inscription')->where('id',$id)->first();
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
        $Tableauobjectif = Tableauobjectif::findOrFail($id);
        $Tableauobjectif->update($request->all());
        return $Tableauobjectif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Tableauobjectif = Tableauobjectif::findOrFail($id);
        $Tableauobjectif->delete();
        return $Tableauobjectif;
    }
     public function tabbyobjet($id)
    {
      return Tableauobjectif::with('inscription')
      ->where('objet',$id)->Orderby('id','desc')->get();
    }
}
