<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index(){
        return view('slot');
    }

    public function sloter(){
        return view('sloter');
    }

}
