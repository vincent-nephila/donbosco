<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class MainController extends Controller
{
    static function getyear($level){
        if($level == "Kindergarten"){
            $department = "Kindergarten";
        }elseif($level == "Grade 1" || $level == "Grade 2" || $level == "Grade 3" || $level == "Grade 4" || $level == "Grade 5" || $level == "Grade 6"){
            $department = "Elementary";
        }elseif($level == "Grade 7" || $level == "Grade 8" || $level == "Grade 9" || $level == "Grade 10"){
            $department = "Junior High School";
        }elseif($level == "Grade 11" || $level == "Grade 12"){
            $department = "Senior High School";
        }else{
            $department = "TVET";
        }

        $sy = \App\ctrSchoolYear::where('department',$department)->first();

        return $sy->schoolyear;
    }
    
    
    
}
