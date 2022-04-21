<?php

namespace App\Http\Controllers\Evenement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evenement\Sharedevenement;
use Illuminate\Support\Facades\Auth;

class SharedevenementController extends Controller
{
    private $auth;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sharedevenement::with('evenement','receveur','inscription')
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
            'value'=> 'required|int',
            'receveur'=> 'required'
        ]);

        foreach( $request->get('receveur') as $obj){
            $reg = new  Sharedevenement([
                'receveur'=> (int)$obj,
                'evenement'=>  $request->get('value')
            ]);
            if(count($this->verify((int)$obj, $request->get('value')))==0){
                $reg->inscription=Auth::id();
                $reg->save();
            }

        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function verify($rec,$res){
        return Sharedevenement::where('receveur','=',$rec)
        ->where('evenement','=',$res)
        ->get();
    }
}
