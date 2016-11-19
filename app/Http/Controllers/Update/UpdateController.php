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
}
