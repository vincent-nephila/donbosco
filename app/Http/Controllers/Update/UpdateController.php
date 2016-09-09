<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateController extends Controller
{
    function updatehsconduct(){
        $hsgrades = DB::Select("select * from grade1 where SY_EFFECTIVE = '2016'");
        foreach($hsgrades as $hsgrade){
            $newconduct = new \App\ConductRepo;
            $newconduct->OSR = $hsgrade->obedience;
            $newconduct->DPT = $hsgrade->deportment;
            $newconduct->PTY =$hsgrade->piety;
            $newconduct->DI = $hsgrade->diligence;
            $newconduct->PG = $hsgrade->positive;
            $newconduct->SIS = $hsgrade->sociability;
            $newconduct->qtrperiod = $hsgrade->QTR;
            $newconduct->schoolyear = $hsgrade->SY_EFFECTIVE;
            $newconduct->idno=$hsgrade->SCODE;
            $newconduct->save();
            $this->updateconduct($hsgrade->SCODE, 'OSR', $hsgrade->obedience, $hsgrade->QTR, '2016');
            $this->updateconduct($hsgrade->SCODE, 'DPT', $hsgrade->deportment, $hsgrade->QTR, '2016');
            $this->updateconduct($hsgrade->SCODE, 'PTY', $hsgrade->piety, $hsgrade->QTR, '2016');
            $this->updateconduct($hsgrade->SCODE, 'DI', $hsgrade->diligence, $hsgrade->QTR, '2016');
            $this->updateconduct($hsgrade->SCODE, 'PG', $hsgrade->positive, $hsgrade->QTR, '2016');
            $this->updateconduct($hsgrade->SCODE, 'SIS', $hsgrade->sociability, $hsgrade->QTR, '2016');
        }
    }
   
    public function updateconduct($idno,$ctype,$cvalue,$qtrperiod,$schoolyear){
          if(strlen($idno)==5){
            $idno = "0".$idno;
        }   
          if(!is_null($cvalue) || $cvalue!=""){  
            switch($qtrperiod){
            case 1:
                $qtrname = "first_grading";
                break;
            case 2:
                $qtrname="second_grading";
                break;
            case 3:
                $qtrname="third_grading";
                break;
            case 4:
                $qtrname="fourth_grading";
        }
        
        $cupate = \App\Grade::where('idno',$idno)->where('subjectcode',$ctype)->where('schoolyear',$schoolyear)->first();
        if(count($cupate)>0){
        $cupate->$qtrname=$cvalue;
        $cupate->update();
        }
          }
        }
        
        public function updatehsgrade(){
            $grades = DB::Select("select * from grade2");
            foreach($grades as $grade){
             $this->updatehs($grade->SCODE, $grade->SUBJ_CODE, $grade->GRADE_PASS1, $grade->QTR);
            }
        }
        
        public function updatehs($idno, $subjectcode, $grade,$qtrperiod){
            switch($qtrperiod){
            case 1:
                $qtrname = "first_grading";
                break;
            case 2:
                $qtrname="second_grading";
                break;
            case 3:
                $qtrname="third_grading";
                break;
            case 4:
                $qtrname="fourth_grading";
                
        }
        $newgrade = \App\Grade::where('idno',$idno)->where('subjectcode',$subjectcode)->first();
        if(count($newgrade)>0){
        $newgrade->$qtrname=$grade;
        $newgrade->update();
        }
        $loadgrade = new \App\SubjectRepo;
        $loadgrade->idno=$idno;
        $loadgrade->subjectcode=$subjectcode;
        $loadgrade->grade=$grade;
        $loadgrade->qtrperiod=$qtrperiod;
        $loadgrade->schoolyear='2016';
        $loadgrade->save();
        }
        function checkno(){
            $idnos=DB::Select("select * from grade2");
            return view('checkno',compact('idnos'));
        }
        
}
