<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function test(){
        return '[{"id":30708,"title":"Reikalingas Automehanikas","url":"reikalingas-automehanikas","highlight":0,"stars":1,"price":"500.00","images":[]}]';
    }
}
