<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    //
	public function search(){
		return view('search_tool');
	}

	public function login(){
	    return view('login');
    }
}
