<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    //
    public function getid($varid){
        if(Request::ajax()){
        $user = \App\User::find($varid);
        $refno = $user->reference_number;
        $varrefno = strval($refno);
        $user->reference_number = $refno + 1;
        $user->update(); 
        $sy = \App\ctrSchoolYear::first();
            for($i=strlen($varrefno); $i< 3 ;$i++){
                $varrefno = "0" . $varrefno;    
            }
            
            $value = substr($sy->schoolyear,2,2) . $user->id . $varrefno;
            $intval = 0;
            
            for($y=1; $y<= strlen($value); $y++){
                $sub = substr($value,$y);
                $intval = $intval + intval($sub);
            }
              $intval = $intval%11;
              $varrefno = $value . strval($intval%11); 
            
            
        return $varrefno;
        }else{
        return "Invalid Request";    
        }
    }
    
    public function getlevel($vardepartment){
         if(Request::ajax()){
           if($vardepartment == "TVET") {
           $value = "<div class=\"col-md-12\">Course</div><div class=\"col-md-12\"><select name = \"course\" id=\"course\" class=\"form-control\" onchange = \"getplan(this.value)\"><option>Select Course</option>";
            $courses = DB::Select("select distinct course from ctr_subjects where department = 'TVET'");
           foreach($courses as $course){
            $value = $value . "<option value=\"" . $course->course ."\">" .$course->course . "</option>"; 
           }
           $value = $value . "</select></div>";
           
           return $value;
               
           }else{           
           $value = "<div class=\"col-md-12\">Level</div><div class=\"col-md-12\"><select name = \"level\" id=\"level\" class=\"form-control\" onchange = \"getplan(this.value)\"><option>Select Level</option>";
           $levels = \App\CtrLevel::where('department', $vardepartment )->get(); 
           foreach($levels as $level){
           $value = $value . "<option value=\"" . $level->level ."\">" .$level->level . "</option>"; 
           }
           $value = $value . "</select></div>";
           
           return $value;
           }
           
           }
           }
           
           function getplan($varlevelcourse, $vardepartment){
                if(Request::ajax()){
                   if($vardepartment == "Senior High School"){
                        $strands = DB::Select("select distinct strand from ctr_payment_schedules where level ='$varlevelcourse'");
              
                         $value = "<div class=\"col-md-12\">Specialization</div><div class=\"col-md-12\"><select name = \"strand\" id=\"strand\" class=\"form-control\" onchange = \"gettrackplan(this.value)\"><option>Select Track</option>";
                         foreach($strands as $strand){
                            $value = $value . "<option value=\"" . $strand->strand ."\">" .$strand->strand . "</option>"; 
                            }
                            $value = $value . "</select></div>";
                    return $value;
                }else{
                    if($varlevelcourse == "Grade 9" || $varlevelcourse == "Grade 10"){
                        //$strands = \App\CtrTrack::where('level',$varlevelcourse)->get();
                        $strands = DB::Select("select distinct strand from ctr_payment_schedules where level ='$varlevelcourse'");
                          $value = "<div class=\"col-md-12\">Specialization</div><div class=\"col-md-12\"><select name = \"strand\" id=\"strand\" class=\"form-control\" onchange = \"gettrackplan(this.value)\"><option>Select Track</option>";
                         foreach($strands as $strand){
                            $value = $value . "<option value=\"" . $strand->strand ."\">" .$strand->strand . "</option>"; 
                            }
                            $value = $value . "</select></div>";
                    return $value;
                    }
                     else{
                    $plans = DB::Select("select distinct plan from ctr_payment_schedules where level = '$varlevelcourse'");
                     $value = "<div class=\"col-md-12\">Plan</div><div class=\"col-md-12\"><select name = \"plan\" id=\"plan\" class=\"form-control\" onchange = \"getdiscount()\"><option>Select Plan</option>";
                         foreach($plans as $plan){
                            $value = $value . "<option value=\"" . $plan->plan ."\">" .$plan->plan . "</option>"; 
                            }
                            $value = $value . "</select></div>";
                    return $value;
                     }
                }
                }
                
               
           }
         
      
            function gettrackplan(){
                  if(Request::ajax()){
                 
                   $plans = DB::Select("select distinct plan from ctr_payment_schedules where level = '".Input::get("level")."' and strand ='". Input::get("strand"). "'");
                     $value = "<div class=\"col-md-12\">Plan</div><div class=\"col-md-12\"><select name = \"plan\" id=\"plan\" class=\"form-control\" onchange = \"getdiscount()\"><option>Select Plan</option>";
                         foreach($plans as $plan){
                            $value = $value . "<option value=\"" . $plan->plan ."\">" .$plan->plan . "</option>"; 
                            }
                            $value = $value . "</select></div>";
                    return $value;
                
                      
                  }  
            }
            
            function getdiscount(){
                if(Request::ajax()){
                 $discounts = \App\CtrDiscount::orderby('discountcode')->get();
                    $value = "<div class=\"col-md-12\">Discount</div><div class=\"col-md-12\"><select name = \"discount\" id=\"discount\" class=\"form-control\" onchange = \"compute()\">"
                            . "<option value=\"\">Select Discount</option> <option value=\"none\">None</option>";
                         foreach($discounts as $discount){
                            $value = $value . "<option value=\"" . $discount->discountcode ."\">" .$discount->description . "</option>"; 
                            }
                            $value = $value . "</select></div>";
                  
                     return $value;
                    
                }
            }
                function getsearch($varsearch){
                    if(Request::ajax()){
                    $searches = DB::Select("Select * From users where accesslevel = '0' AND (lastname like '$varsearch%' OR
                           firstname like '$varsearch%' OR idno = '$varsearch') Order by lastname, firstname");
                    $value = "<table class=\"table table-striped\"><thead>
            <tr><th>Student Number</th><th>Student Name</th><th>Gender</th><th>View</th></tr>        
            </thead><tbody>";
                    foreach($searches as $search){
                        $value = $value . "<tr><td>" .$search->idno . "</td><td>". $search->lastname . ", " .
                                $search->firstname . " " . $search->middlename . " " . $search->extensionname .
                                "</td><td>" . $search->gender . "</td><td><a href = '/registrar/evaluate/".$search->idno."'>view</a>";
                    }
                      
                    $value = $value . "</tbody>
            </table>"; 
                        
                    return $value; 
                    }
                }
                
                 function getsearchcashier($varsearch){
                    if(Request::ajax()){
                    $searches = DB::Select("Select * From users where accesslevel = '0' AND (lastname like '$varsearch%' OR
                           firstname like '$varsearch%' OR idno = '$varsearch') Order by lastname, firstname");
                    $value = "<table class=\"table table-striped\"><thead>
            <tr><th>Student Number</th><th>Student Name</th><th>Gender</th><th>View</th></tr>        
            </thead><tbody>";
                    foreach($searches as $search){
                        $value = $value . "<tr><td>" .$search->idno . "</td><td>". $search->lastname . ", " .
                                $search->firstname . " " . $search->middlename . " " . $search->extensionname .
                                "</td><td>" . $search->gender . "</td><td><a href = '/cashier/".$search->idno."'>view</a>";
                    }
                      
                    $value = $value . "</tbody>
            </table>"; 
                        
                    return $value; 
                    }
                }
                
                function compute(){
                $otherdiscountname = "None";
                $otherdiscountrate = 0;
                $advance = 0;
                
                $otherdiscounts=  \App\CtrDiscount::where('discountcode', Input::get('discount'))->first();
                if(!is_null($otherdiscounts)){
                $otherdiscountname = $otherdiscounts->description;
                $otherdiscountrate = ($otherdiscounts->tuitionfee/100);
                }
                
                $department = Input::get("department");
                $level = Input::get("level");
                $strand = Input::get("strand");
                $course = Input::get("course");
                $plan = Input::get("plan");
                $id =Input::get('id');
                
                $currentpreiod = \App\ctrSchoolYear::where("department", $department)->first();
                $advances = DB::Select("select * from advance_payments where idno='$id' and status = '0'");
                    foreach($advances as $adv){
                        $advance = $advance + $adv->amount;
                    }
             
                
                if($department == "TVET"){
                    
                }
                elseif($department == "Senior High School"){
                    $schedules = DB::Select("select sum(amount) as amount, sum(discount) as discount, receipt_details, plan, level, duedate  from ctr_payment_schedules
                             where strand = '$strand' and level = '$level' and plan = '$plan' Group by receipt_details, plan, level, duedate");
                }
                else{
                    //$matchfields= ['level' => $level,'plan' => $plan];
                   
                    
                    if($level=='Grade 9' || $level=='Grade 10'){
                      $schedules = DB::Select("select sum(amount) as amount, sum(discount) as discount, receipt_details, plan, level, duedate  from ctr_payment_schedules
                             where strand = '$strand' and level = '$level' and plan = '$plan' Group by receipt_details, plan, level, duedate");
                    //$   
                    }else{
                    $schedules = DB::Select("select sum(amount) as amount, sum(discount) as discount, receipt_details, plan, level, duedate  from ctr_payment_schedules
                             where level = '$level' and plan = '$plan' Group by receipt_details, plan, level, duedate");
                    //$schedules = \App\CtrPaymentSchedule::where($matchfields)->get();
                    }  }
                     $total=0;
                    $discount = 0;
                    $otherdiscount = 0;
                    
                    $request = "<table class = \"table table-bordered\"><tr><td>Description</td><td>Due Date</td><td>Amount</td><tr>";
                    foreach($schedules as $schedule){
                    if(stristr($schedule->receipt_details, "Tuition")){
                    $otherdiscount = $otherdiscount + (($schedule->amount-$schedule->discount) * $otherdiscountrate);     
                    } 
                    $discount = $discount + $schedule->discount;
                    $total = $total + $schedule->amount; 
                    
                    $request = $request ."<tr><td>". $schedule->receipt_details."</td><td>".$schedule->duedate."</td><td align=\"right\">" . number_format($schedule->amount,2)."</td></tr>";    
                    }
                    $request = $request . "<tr><td colspan = \"2\"> Sub Total</td><td align=\"right\"><strong style=\"color:black\">". number_format($total,2)."</strong></td></tr>";
                    $request = $request . "<tr><td colspan = \"2\"> Less: Plan Discount</td><td align=\"right\"><strong style=\"color:red\">(". number_format($discount,2).")</strong></td></tr>";
                    $request = $request . "<tr><td colspan = \"2\">Other Discount: $otherdiscountname</td><td align=\"right\"><strong style=\"color:red\">(". number_format($otherdiscount,2).")</strong></td></tr>";
                    $request = $request . "<tr><td colspan = \"2\">Advance Payment</td><td align=\"right\"><strong style=\"color:red\">(". number_format($advance,2).")</strong></td></tr>";
                    $request = $request . "<tr><td colspan = \"2\"> Total</td><td align=\"right\"><strong style=\"color:black\">". number_format($total-$discount-$otherdiscount-$advance,2)."</strong></td></tr>";
                    $request = $request . "</table><div class=\"col-md-12\"><input id=\"submit_button\" type=\"submit\" value=\"Process Assessment\" class=\"form-control btn btn-warning\">";
                  
                
                
                 return $request;
                  
                }
            
            function getpaymenttype($ptype){
                if(Request::ajax()){
                $data="";
                    if($ptype == "1"){
                //$data = "<table class=\"table table-responsive\"  style=\"background-color: #C6C6FF\"><tr><td>Amount Received</td><td>
                 //       <input style =\"text-align: right\" type=\"text\" name=\"receive\" onkeypress=\"validate(event)\" class=\"form form-control\">
                 //       </td></tr></table>";
                      $data="";  
                } else {
                    $data = "<table class=\"table table-responsive\"  style=\"background-color: #C6C6FF\"><tr><td>Check Number</td><td>
                        <input  type=\"text\" name=\"check_number\" id=\"check_number\" onkeydown = \"nosubmit(event,'bank_branch')\" class=\"form form-control\">
                        </td></tr>";
                    $data = $data . "<tr><td>Bank/Branch</td><td>
                        <input type=\"text\" name=\"bank_branch\"  id=\"bank_branch\"  onkeydown = \"nosubmit(event,'receive')\"  class=\"form form-control\">
                        </td></tr>";
                   /* $data = $data . "<tr><td>Amount</td><td>
                        <input style =\"text-align: right\" type=\"text\" name=\"amount\" onkeypress=\"validate(event)\" class=\"form form-control\">
                        </td></tr></table>";*/
                }
                
                return $data;
            }}
            
            function getparticular($group, $particular){
                if(Request::ajax()){
                $particulars = \App\CtrOtherPayment::where("accounttype",$group)->get();
                $data = "
                        <select class=\"form-control\" name=\"".$particular."\">";
                    foreach($particulars as $part){
                    $data = $data . "<option value = '" . $part->particular . "'>" . $part->particular. "</option>";  
                    }
             
               $data = $data."</select>";
                return $data;    
                }
            
            }
    
}
