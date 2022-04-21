<?php

namespace App\Http\Controllers\Muridee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Muridee\Muridee;
use Illuminate\Support\Facades\Auth;

class MurideeController extends Controller
{
    private $auth;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Muridee::with('likes','inscription')->Orderby('id','DESC')->get();
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
            'anonymat'=> 'required|string',
            'description'=> 'required|string'
        ]);
        $reg = new  Muridee([
            'description'=> $request->get('description'),
            'libelle'=>  $request->get('libelle'),
            'anonymat'=>  $request->get('anonymat')
        ]);
        $reg->inscription=Auth::id();
        $reg->save();

        return $reg->load('likes','inscription');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return Muridee::with('inscription','likes')->where('id',$id)->first();
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
        $Muridee = Muridee::findOrFail($id);
        $Muridee->update($request->all());
        return $Muridee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Muridee = Muridee::findOrFail($id);
        $Muridee->delete();
        return $Muridee;
    }
}
