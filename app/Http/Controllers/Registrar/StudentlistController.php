<?php

namespace App\Http\Controllers\Registrar;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class StudentlistController extends Controller
{
    
public function studentlist()
{ 
$lists=DB::Select("SELECT DISTINCT level from statuses ORDER BY level");
        
    return view('registrar/studentlist', compact('lists'));
  
    
   
}

}