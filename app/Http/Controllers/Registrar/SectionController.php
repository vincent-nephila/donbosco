<?php

namespace App\Http\Controllers\Registrar;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SectionController extends Controller
{
    //
     public function __construct()
	{
		$this->middleware('auth');
	}
        
     function sectionk(){
         $levels = \App\CtrLevel::all();
         //return $levels;
         return view('registrar.sectionkpage',compact('levels'));
     }   
    
}
