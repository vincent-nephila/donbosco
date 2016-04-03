<?php

namespace App\Http\Controllers\Registrar;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    
     
    public function __construct()
	{
		$this->middleware('auth');
	}
        
    
    //
    public function show(){ 
        return view('registrar.assessment');
    }
    
    public function evaluate($id){
        $balance = "";
        $reservation = 0;
        $currentschoolyear = "";
        $mydiscount="";
        $ledgers="";
        $student = \App\User::where('idno',$id)->first();
        $status = \App\Status::where('idno',$id)->first();
        if(count($status) > 0){
        $currentschoolyear = \App\ctrSchoolYear::where('department', $status->department)->first();
        $matchfields=["idno"=>$id, "schoolyear" =>$currentschoolyear->schoolyear, "period" => $currentschoolyear->period ];
        $mydiscount=  \App\Discount::where($matchfields)->first();
        $ledgers =  DB::Select("select sum(amount) as amount, sum(plandiscount) as plandiscount,  sum(otherdiscount) as otherdiscount,receipt_details,  duedate  from ledgers
                             where idno = '$id' and schoolyear = '".$currentschoolyear->schoolyear."'  and period = '". $currentschoolyear->period."' Group by receipt_details,  duedate");
              }
        
        $programs = DB::Select("select distinct department from ctr_levels");
        $k_levels = \App\CtrLevel::where('department','Kindergarten')->get();
        $elem_levels = \App\CtrLevel::where('department','Elementary')->get();
        $jhs_levels = \App\CtrLevel::where('department','Junior High School')->get();
        $shs_levels = \App\CtrLevel::where('department','Senior High School')->get();
        $k11_tracks = \App\CtrTrack::where('level', 'Grade 11')->get();
        $k12_tracks = \App\CtrTrack::where('level', 'Grade 12')->get();
        $courses = DB::Select("select distinct coursecode from ctr_tvet_subjects");
        $balances = DB::Select("select sum(amount) as amount, sum(plandiscount) as plandiscount, sum(otherdiscount) as otherdiscount, sum(debitmemo) as debitmemo, sum(payment) as payment from ledgers where idno = ?",array($id));
        if(count($balances) > 0 ){
            foreach($balances as $ledger){    
            $balance = $balance + $ledger->amount - $ledger->payment-$ledger->plandiscount-$ledger->debitmemo-$ledger->otherdiscount;
            }
        }
        $fields=['idno'=>$id, 'status'=>'0']; 
        $reservations = \App\AdvancePayment::where($fields)->get();
        if(count($reservations)> 0 ){
            foreach ($reservations as $res){
            $reservation = $reservation + $res->amount;
            }
        }
        
        return view('registrar.oldstudent', compact('reservation','student','status','balance','programs','k_levels','elem_levels','shs_levels','jhs_levels','k11_tracks','k12_tracks','courses','currentschoolyear','mydiscount','ledgers'));
    
      
        
    }
    
function assess(Request $request){
    $schoolperiod = \App\ctrSchoolYear::where("department",$request->department)->first();
    if(isset($request->strand)){
        $strand = $request->strand;
    } else{
        $strand="";
    }   
    
    if(isset($request->course)){
        $course = $request->course;
    }else{
        $course="";
    }
    
    $action = $request->action;
    
    switch($action){
    case "add":
       
              if($this->addLedger($request->id,$request->level,$request->plan,$request->discount,$request->department,$strand,$course)){  
                $status = new \App\Status;
                $status->idno=$request->id;
                $status->date_registered=Carbon::now();
                $status->status = "1";
                $status->department = $request->department;
                if($request->level == 'Grade 9' || $request->level == 'Grade 10' || $request->level == 'Grade 11' || $request->level == 'Grade 12'){
                $status->strand = $request->strand;
                 }
                 if($request->department == "TVET"){
                 $status->course = $course;
                 }
                 else{  
                  $status->level = $request->level;
                 }                 
                $status->plan=$request->plan;
                $status->schoolyear= $schoolperiod->schoolyear;
                $status->period=$schoolperiod->period;
                $status->save();
              }   
        return redirect('registrar/evaluate/'. $request->id);
        break;
        
        case "addnew":
        $newstudent = new \App\User;
        $newstudent->idno = $request->idno;
        $newstudent->lastname = $request->lastname;
        $newstudent->firstname = $request->firstname;
        $newstudent->middlename=$request->middlename;
        $newstudent->extensionname=$request->extensionname;
        $newstudent->gender=$request->gender;
        $newstudent->password = bcrypt($request->idno);
        $newstudent->save();
        
        if($this->addLedger($request->idno,$request->level,$request->plan,$request->discount,$request->department, $strand,$course)){  
                $status = new \App\Status;
                $status->idno=$request->idno;
                $status->date_registered=Carbon::now();
                $status->status = "1";
                $status->department = $request->department;
                    if($request->level == 'Grade 9' || $request->level == 'Grade 10' || $request->level == 'Grade 11' || $request->level == 'Grade 12'){
                        $status->strand = $request->strand;
                    }
                    
                 if($request->department == "TVET"){
                 $status->course = $course;
                 }
                 else{  
                  $status->level = $request->level;
                 }
                    
                $status->plan=$request->plan;
                $status->schoolyear= $schoolperiod->schoolyear;
                $status->isnew = "1";
                $status->period=$schoolperiod->period;
                $status->save();
              }
        return redirect('registrar/evaluate/'. $request->idno);
        break;
    
    case "reassessed";
       
      
        $matchfields=["idno"=>$request->id, "schoolyear"=>$schoolperiod->schoolyear, "period" => $schoolperiod->period];
        $deletestudents = \App\Ledger::where($matchfields)->get();
        foreach($deletestudents as $deletestudent){
            $deletestudent->delete();
        }
        
        $deletegrades = \App\Grade::where($matchfields)->get();
        foreach($deletegrades as $deletegrate){
            $deletegrate->delete();
        }
        
        $deletediscounts = \App\Discount::where($matchfields)->get();
        foreach ($deletediscounts as $deletediscount){
            $deletediscount->delete();
        }
        $changestatus =  \App\Status::where('idno',$request->id)->first();
        $changestatus->status = "0";
        $changestatus->strand = "";
        $changestatus->course="";
        $changestatus->track="";
        $changestatus->level="";
        $changestatus->update();
        
        return redirect('registrar/evaluate/'. $request->id);
        
        
        //return $request->department;
        break;
        case "update";
         if($request->department == "Kindergarten" || $request->department =="Elementary" || $request->department == "Junior High School" || $request->department == "Senior High School"){
              if($this->addLedger($request->id,$request->level,$request->plan,$request->discount,$request->department,$strand,$course)){  
                $status = \App\Status::where('idno',$request->id)->first();
                $status->date_registered=Carbon::now();
                $status->status = "1";
                $status->department = $request->department;
               
                 if($request->level == 'Grade 9' || $request->level == 'Grade 10' || $request->level == 'Grade 11' || $request->level == 'Grade 12'){
                $status->strand = $request->strand;
                }
                
                  if($request->department == "TVET"){
                 $status->course = $course;
                 }
                 else{  
                  $status->level = $request->level;
                 }
                $status->plan=$request->plan;
                $status->schoolyear= $schoolperiod->schoolyear;
                $status->period=$schoolperiod->period;
                $status->update();
              }   
            }
            return redirect('registrar/evaluate/'. $request->id);
        break;    
    
    }
                
        
    
    
}
      
    

    function addLedger($id, $level, $plan, $discount,$department,$strand, $course){
                $schoolperiod = \App\ctrSchoolYear::where("department",$department)->first();
                $discounts = \App\CtrDiscount::where('discountcode',$discount)->first();   
                
                 if($department == "TVET"){
                   $matchfields = ["department"=>"TVET", "course", $course];  
                 } else{ 
                    if($level == "Grade 9" || $level == "Grade 10" || $level == "Grade 11" || $level == "Grade 12"){
                    $matchfields=['level'=>$level, 'plan' =>$plan, 'strand'=>$strand];
                        } else {
                            $matchfields=['level'=>$level, 'plan' =>$plan];
                 }}
                
                    $ledgers = \App\CtrPaymentSchedule::where($matchfields)->get();
                    foreach($ledgers as $ledger){
                        $newledger = new \App\Ledger;
                        $newledger->idno = $id;
                        $newledger->transactiondate = Carbon::now();
                        $newledger->department = $ledger->department;
                        $newledger->level = $ledger->level;
                        $newledger->course = $ledger->course;
                        $newledger->track = $ledger->track;
                        $newledger->strand= $ledger->strand;
                        $newledger->categoryswitch = $ledger->categoryswitch;
                        $newledger->acctcode = $ledger->acctcode;
                        $newledger->description = $ledger->description;
                        $newledger->receipt_details = $ledger->receipt_details;
                        $newledger->amount = $ledger->amount;
                            if($ledger->categoryswitch == env('TUITION_FEE')){
                                if(isset($discounts->discountcode)){    
                //if(count($discounts)> 0){
                                    $totaldiscount = (($ledger->amount-$ledger->discount) * ($discounts->tuitionfee/100));    
                                    $newledger->otherdiscount = $totaldiscount;
                                    $newledger->discountcode = $discounts->discountcode;
                                   }
                
                             }
                        $newledger->plandiscount = $ledger->discount;
                        $newledger->schoolyear = $schoolperiod->schoolyear;
                        $newledger->duetype = $ledger->duetype;
                        $newledger->period = $schoolperiod->period;
                        $newledger->duedate = $ledger->duedate;
                        $newledger->postedby = \Auth::user()->id;
                        $newledger->save();
                
                        if(isset($discounts->discountcode)){
                            if($discounts->discountcode !="None" && $ledger->categoryswitch == env('TUITION_FEE')){
                                $studentdiscount = new \App\Discount;
                                $studentdiscount->transactiondate = Carbon::now();
                                $studentdiscount->idno = $id;
                                $studentdiscount->refid = $newledger->id;
                                $studentdiscount->plan=$plan;
                                $studentdiscount->discountcode = $discounts->discountcode;
                                $studentdiscount->description =$discounts->description;
                                $studentdiscount->tuitionfee = $discounts->tuitionfee;
                                $studentdiscount->registrationfee=$discounts->registrationfee;
                                $studentdiscount->miscellaneousfee=$discounts->miscellaneousfee;
                                $studentdiscount->elearningfee=$discounts->elearningfee;
                                $studentdiscount->departmentfee=$discounts->departmentfee;
                                $studentdiscount->bookfee=$discounts->bookfee;
                                $studentdiscount->amount=$totaldiscount;
                                $studentdiscount->duedate = $newledger->duedate;
                                $studentdiscount->schoolyear=$schoolperiod->schoolyear;
                                $studentdiscount->period=$schoolperiod->period;
                                $studentdiscount->save(); 
                            }           
                    
                        }
                    }
                if($department == "Kindergarten" || $department == "Elementary" || $department == "Junior High School"){ 
                $newsubjects = \App\CtrSubjects::where('level',$level)->get();
                foreach($newsubjects as $newsubject){
                    $newgrade = new \App\Grade;
                    $newgrade->idno = $id;
                    $newgrade->level = $level;
                    $newgrade->subjectcode=$newsubject->subjectcode;
                    $newgrade->subjectname=$newsubject->subjectname;
                    $newgrade->schoolyear=$schoolperiod->schoolyear;
                    $newgrade->period=$schoolperiod->period;
                    $newgrade->save();
                }
                    
                } elseif($department == "Senior High School"){
                    $matsubject = ["level"=>$level, "strand"=>$strand];
                    $newsubjects = \App\CtrSubjects::where($matsubject)->get();
                    foreach($newsubjects as $newsubject){
                    $newgrade = new \App\Grade;
                    $newgrade->idno = $id;
                    $newgrade->level = $level;
                    $newgrade->strand=$newsubject->strand;
                    $newgrade->subjectcode=$newsubject->subjectcode;
                    $newgrade->subjectname=$newsubject->subjectname;
                    $newgrade->schoolyear=$schoolperiod->schoolyear;
                    $newgrade->period=$schoolperiod->period;
                    $newgrade->save();
                }
                
                    } elseif($department == "TVET"){
                      
                    $newsubjects = \App\CtrSubjects::where('course',$course)->get();
                    foreach($newsubjects as $newsubject){
                    $newgrade = new \App\Grade;
                    $newgrade->idno = $id;
                    $newgrade->course = $level;
                    $newgrade->strand=$newsubject->strand;
                    $newgrade->subjectcode=$newsubject->subjectcode;
                    $newgrade->subjectname=$newsubject->subjectname;
                    $newgrade->schoolyear=$schoolperiod->schoolyear;
                    $newgrade->period=$schoolperiod->period;
                    $newgrade->save();
                }
                }   
                 return true;
    }

    function printregistration($idno){
        $status = \App\Status::where('idno',$idno)->first();
        $user = \App\User::where('idno',$idno)->first();
        $matchfiels=['idno'=>$idno, 'schoolyear'=>$status->schoolyear, 'period'=>$status->period];
        $ledgers = \App\Ledger::where($matchfiels)->get();
        $breakdownfees = DB::Select("select idno, sum(amount) as amount, sum(plandiscount) as plandiscount, sum(otherdiscount) as otherdiscount,categoryswitch, receipt_details from ledgers
                where idno = '$idno' and schoolyear = '". $status->schoolyear ."' and period = '".$status->period."'group by idno, categoryswitch, receipt_details");
        
        $dues = DB::Select("select idno, sum(amount) as amount, sum(plandiscount) as plandiscount, sum(otherdiscount) as otherdiscount, "
                . "duetype, duedate from ledgers where idno = '$idno' and schoolyear = '". $status->schoolyear ."' and period = '".$status->period."' "
                . " group by idno, duetype, duedate order by duedate");
        $matchfields=['idno'=>$idno, 'status'=>'0'];
        $reservation = \App\AdvancePayment::where($matchfields)->first();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('print.registration',compact('dues','status','user','ledgers','breakdownfees','reservation'));
        return $pdf->stream();
        
    }
    
    public function edit($id){
        
        $student = \App\User::where('idno',$id)->first();
        return view('registrar.editname', compact('student'));
        
    }
    
    public function editname(Request $request){
        $updatename = \App\User::where('idno',$request->idno)->first();
        $updatename->lastname = $request->lastname;
        $updatename->firstname = $request->firstname;
        $updatename->middlename=$request->middlename;
        $updatename->extensionname=$request->extensionname;
        $updatename->gender=$request->gender;
        $updatename->update();
        
        return redirect(url('/registrar/evaluate',$request->idno));
        
    }
   
}
