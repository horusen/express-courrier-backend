<?php

namespace App\Http\Controllers\Muridee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Muridee\Likemuridee;
use Illuminate\Support\Facades\Auth;

class LikemurideeController extends Controller
{
    private $auth;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
         return Likemuridee::with('mur_idee','inscription')
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
           'mur_idee'=> 'required|int'
        ]);

        $reg = new  Likemuridee([
            'mur_idee'=>  $request->get('mur_idee')
        ]);
        if(count($this->verify(Auth::id(), $request->get('mur_idee')))==0){
            $reg->inscription=Auth::id();
            $reg->save();
            return response()->json(['value'=>'SUCCESS','data'=>$reg]);
        }
        else{
            return response()->json(['value'=>'ERROR']);
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
        return Likemuridee::where('inscription','=',$rec)
        ->where('mur_idee','=',$res)
        ->get();
    }
}
