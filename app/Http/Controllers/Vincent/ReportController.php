<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }     
    
    function sheetA(){
        if(Auth::User()->accesslevel != env('USER_REGISTRAR')){
            return redirect('/');
        }
        $levels = \App\CtrLevel::get();
        return view('vincent.registrar.sheetA', compact('levels'));
    }

    function printDate(){
        $print=new Carbon();
        $print::setToStringFormat('F j, Y g:i:s a');
        $print::today(); 
        
        return "".$print."";
    }    
    
    function printSheetAElem($level,$section,$subject){
        if(Auth::User()->accesslevel != env('USER_REGISTRAR')){
            return redirect('/');
        }        
        $today = date("F d, Y");
        
        $print =      $this->printDate();  

        
        $schoolyear = \App\CtrRefSchoolyear::first();
        $quarter = '1';
        //$level = 'Grade 1';
        //$section = 'Blessed Michael Rua';
        $strand = '';
        
        if($subject == "All"){
            $subjects = \App\CtrSubjects::where('level',$level)->whereIn('subjecttype',array(0,1))->get();

            if($level == "Grade 11"){
                $subjects = \App\CtrSubjects::where('level',$level)->whereIn('subjecttype',array(5,6))->get();
            }            
        }else{
            $subjects = \App\CtrSubjects::where('subjectcode',$subject)->where('level',$level)->whereIn('subjecttype',array(0,1))->get();

            if($level == "Grade 11"){
                $subjects = \App\CtrSubjects::where('subjectcode',$subject)->where('level',$level)->whereIn('subjecttype',array(5,6))->get();
            }              
        }

        //$students = DB::Select("Select lastname,firstname,middlename, extensionname from users join statuses on statuses.idno=users.idno where statuses.status = 2 and schoolyear ='$schoolyear' and level='$level' and section = '$section' and strand='$strand' order by lastname ASC,firstname asc ");
        
        $students = DB::Select("SELECT statuses.idno as idno,class_no,lastname, firstname, middlename, extensionname,statuses.status as stat FROM users JOIN statuses ON statuses.idno = users.idno WHERE statuses.status IN(2,3) AND schoolyear = '$schoolyear->schoolyear' AND level ='$level'  AND section = '$section' ORDER BY class_no ASC");
        
        
        
        return view('vincent.registrar.sheetAprint',compact('students','subjects','today','print','schoolyear','level','section','quarter'));
        //return $schoolyear;
        
    }    
    
    function conduct(){
     if(Auth::User()->accesslevel != env('USER_REGISTRAR')){
        return redirect('/');
     }

       $levels = DB::Select("Select level from ctr_levels");  

     
     return view('vincent.registrar.conduct',compact('levels'));
 }
 
    function printSheetAConduct($level,$section,$quarter){
        $today = date("F d, Y");
        
        $print = $this->printDate();  
             
        $schoolyear = \App\CtrRefSchoolyear::first();
        $students = DB::Select("SELECT total,statuses.idno as idno,class_no,lastname, firstname, middlename, extensionname,statuses.status as stat FROM users left join (SELECT idno,sum(first_grading) as total FROM `grades` where subjecttype=3 and schoolyear = '$schoolyear->schoolyear' GROUP BY idno)conduct on conduct.idno = users.idno JOIN statuses ON statuses.idno = users.idno WHERE statuses.status IN (2,3) AND schoolyear = '$schoolyear->schoolyear' AND level ='$level'  AND section = '$section' ORDER BY class_no ASC");
        $adviser = DB::table('ctr_sections')->where('level',$level)->where('section',$section)->first();
        
        return view('vincent.registrar.sheetAConduct',compact('students','today','print','schoolyear','level','section','quarter','adviser'));
        
    }
    
    function printSheetaAttendance($level,$section,$quarter){
        $today = date("F d, Y");
        
        $print =      $this->printDate();  
             
        $schoolyear = \App\CtrRefSchoolyear::first();
        $subjects = DB::select("Select distinct subjectname as subjectname from ctr_subjects where level='$level' AND subjecttype = 2 order by sortto ASC");
        
        $students = DB::Select("SELECT statuses.idno as idno,class_no,lastname, firstname, middlename, extensionname,statuses.status as stat FROM users JOIN statuses ON statuses.idno = users.idno WHERE statuses.status IN (2,3) AND schoolyear = '$schoolyear->schoolyear' AND level ='$level'  AND section = '$section' ORDER BY class_no ASC");
        $adviser = DB::table('ctr_sections')->where('level',$level)->where('section',$section)->first();
        
        return view('vincent.registrar.sheetaAttendance',compact('students','today','print','schoolyear','level','section','quarter','adviser','subjects'));
        
    }    
    
    function attendance(){
     if(\Auth::user()->accesslevel==env('USER_HS_PRINCIPAL')|| \Auth::user()->accesslevel==env('USER_HS_ASST_PRINCIPAL')){
       $levels = DB::Select("Select level from ctr_levels where department = 'Junior High School' OR department='Senior High School'");  
     }else{
       $levels = DB::Select("Select level from ctr_levels where department = 'Elementary' OR department='Kindergarten'");
     }
     
     return view('vincent.registrar.attendance',compact('levels'));
 }    
 
    function sheetB(){
        $today = date("F d, Y");
        
        $print =      $this->printDate();  

        
        $schoolyear = \App\CtrRefSchoolyear::first();

       $levels = DB::Select("Select distinct level,department from ctr_levels order by id asc");
       $tvet = DB::Select("SELECT distinct course as courses FROM `ctr_subjects` WHERE `department` LIKE 'TVET'");
       return view('vincent.registrar.sheetB',compact('levels','tvet','today','print','schoolyear')) ;
            
    }
 
 
}
