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
        $quarters = \App\CtrQuarter::first();
        
        $hsgrades = DB::connection('dbtiprod')->Select("select * from grade1 where SY_EFFECTIVE = '2016' and QTR = $quarters->qtrperiod");
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
            $sy = \App\ctrSchoolYear::first();
            $quarters = \App\CtrQuarter::first();
            $grades = DB::connection('dbti2prod')->Select("select * from grade where SY_EFFECTIVE = $sy->schoolyear and QTR = $quarters->qtrperiod");
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
        $check = \App\Status::where('idno',$idno)->where('department','Junior High School')->first();
        if(count($check) != 0 && $subjectcode =='MAPEH'){
        $newgrade = \App\Grade::where('idno',$idno)->where('subjectcode',$subjectcode)->first();
        
        if(count($newgrade)>0){
        $newgrade->$qtrname=$grade;
        $newgrade->update();
        }
        $loadgrade = new \App\SubjectRepos;
        $loadgrade->idno=$idno;
        $loadgrade->subjectcode=$subjectcode;
        $loadgrade->grade=$grade;
        $loadgrade->qtrperiod=$qtrperiod;
        $loadgrade->schoolyear='2016';
        $loadgrade->save();
        }
        }
        function checkno(){
            $idnos=DB::Select("select * from grade2");
            return view('checkno',compact('idnos'));
        }
        public function updatehsattendance(){
            $dayahs = DB::Select("Select * from grade2 where SUBJ_CODE = 'DAYA'");
            foreach($dayahs as $daya){
                $updayp = \App\Grade::where('idno',$daya->SCODE)->where('subjectcode','DAYP')->first();
               if(count($updayp)>0){
                $updayp->first_grading = 48 - $daya->GRADE_PASS1;
                $updayp->update();
               }
            }
        }
        
        function updateacctcode(){
            $updatedbs = DB::Select("select * from crsmodification");
            foreach($updatedbs as $updatedb){
                $updatecrs = \App\Credit::where('receipt_details',$updatedb->receipt_details)->get();
                foreach($updatecrs as $updatecr){
                    $crs = \App\Credit::find($updatecr->id);
                    $crs->acctcode = $updatedb->acctcode;
                    $crs->update();
                }
                
            }
            return "Done";
        }
        
        function updatecashdiscount(){
            $cashdiscounts = \App\Dedit::where('paymenttype','4')->get();
            if(count($cashdiscounts)>0){
                foreach($cashdiscounts as $cashdiscount){
                    $discountname = \App\Discount::where('idno',$cashdiscount->idno)->first();
                    $dname="Plan Discount";
                     if(count($discountname)>0){
                     $dname = $discountname->description;
                    }
                    $cashdiscount->acctcode = $dname;
                    $cashdiscount->update();
                }
                return "done updating";
            }
        }
        function prevgrade(){
            $sy = "2012";
            $students = DB::connection('dbti2test')->select("select distinct scode from grade where SY_EFFECTIVE = '$sy' LIMIT 800,800");
            foreach($students as $student){
                $this->migrategrade($student->scode,$sy);
            }
            //$this->migrategrade("021067",$sy);
        }
        function migrategrade($scode,$sy){
                
                do{
                    if(strlen($scode) < 6){
                        $scode = "0".$scode;
                    }
                }while(strlen($scode) < 6);
            $hsgrades = DB::connection('dbti2test')->select("select * from grade "
                    . "join (SELECT DISTINCT sy_effective, gr_yr,scode FROM  `grade_report`) gr on gr.scode = grade.scode and gr.sy_effective = grade.sy_effective "
                    . "join subject on subject.SUBJ_CODE = grade.SUBJ_CODE "
                    . "where grade.SY_EFFECTIVE = '$sy' "
                    . "and grade.SCODE =".$scode." "
                    . "AND grade.SUBJ_CODE NOT IN ('DAYT','DAYA','GMRC') group by grade.SCODE,grade.SUBJ_CODE,grade.QTR,grade.SY_EFFECTIVE,grade.GRADE_PASS1");

            foreach($hsgrades as $grade){
                
                $check = $this->check($scode,$grade->SUBJ_CODE,$sy);
                echo $check;
                if(empty($check)){
                    $record = new \App\Grade();
                    $record->idno = $scode;
                    $record->level = $this->changegrade($grade->gr_yr);
                    $record->subjectcode = $grade->SUBJ_CODE;
                    $record->subjecttype = $this->settype($grade->SUBJ_CODE);
                    if($grade->QTR == 1){
                        $record->first_grading = $grade->GRADE_PASS1;
                    }else if($grade->QTR == 2){
                        $record->second_grading = $grade->GRADE_PASS1;
                    }else if($grade->QTR == 3){
                        $record->third_grading = $grade->GRADE_PASS1;
                    }else if($grade->QTR == 4){
                        $record->fourth_grading = $grade->GRADE_PASS1;
                    }  
                    $record->schoolyear = $sy;
                    $record->save();
                }else{
                    $record = \App\Grade::where('idno',$scode)->where('subjectcode',$grade->SUBJ_CODE)->where('schoolyear',$grade->SY_EFFECTIVE)->first();
                    if($grade->QTR == 1){
                        $record->first_grading = $grade->GRADE_PASS1;
                    }else if($grade->QTR == 2){
                        $record->second_grading = $grade->GRADE_PASS1;
                    }else if($grade->QTR == 3){
                        $record->third_grading = $grade->GRADE_PASS1;
                    }else if($grade->QTR == 4){
                        $record->fourth_grading = $grade->GRADE_PASS1;
                    }        
                    $record->save();
                }
                
                
                    
            }
            return 'me';
        }
        
        function settype($subjcode){
            $acad = array("ALGEB","CAT","ENGL","FIL","H&PE","MATH","MUS","RHGP","SC","SS","TRIGO","VE","ART","CL","COM1","HEK","PE","WORK","COM2","STAT","SIB","WRIT");
            $tech  = array('AT/MT','CT','ET/ELX','IDT','SHOP','TECH','CADD','DRAF');
            $att = array("DAYP","DAYT","DAYA");
            
            if(in_array($subjcode,$acad)){
                return 0;
            }
            if(in_array($subjcode,$tech)){
                return 1;
            }
            if($subjcode == "GMRC"){
                return 3;
            }
            if(in_array($subjcode,$att)){
                return 2;
            }            
        }
        
        function check($scode,$subj,$sy){
            $result = \App\Grade::where('idno',$scode)->where('subjectcode',$subj)->where('schoolyear',$sy)->first();
            
            return $result;
        }
        
        function changegrade($level){
            if($level == 'I'){
                $newlevel = "Grade 1";
            }
            else if($level == 'II'){
                $newlevel = "Grade 2";
            }
            else if($level == 'III'){
                $newlevel = "Grade 3";
            }
            else if($level == 'IV'){
                $newlevel = "Grade 4";
            }
            else if($level == 'V'){
                $newlevel = "Grade 5";
            }
            else if($level == 'VI'){
                $newlevel = "Grade 6";
            }
            else if($level == 1){
                $newlevel = "Grade 7";
            }            
            else if($level == 2){
                $newlevel = "Grade 8";
            }            
            else if($level == 3){
                $newlevel = "Grade 9";
            }            
            else if($level == 4){
                $newlevel = "Grade 10";
            }            
            
            return $newlevel;
        }
}
