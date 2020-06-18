<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index(){
        return view('slot');
    }

    public function result(Request $request){
        // DB::table('results')->insert([
        //     ['slot' => $request->res1 . ' ' . $request->res2 . ' ' . $request->res3],
        // ]);
    }

}
