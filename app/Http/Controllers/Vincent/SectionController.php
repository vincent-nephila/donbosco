<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    function sectionTvet(){
        $levels = \App\CtrSchoolYear::where('department','TVET');
        return view('registrar.sectionkpage',compact('levels'));        
    }
}
