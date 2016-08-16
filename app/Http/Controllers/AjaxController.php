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
            
            $value = substr($sy->schoolyear,2,2) . $user->idref . $varrefno;
            $intval = 0;
            
            for($y=1; $y<= strlen($value); $y++){
                $sub = substr($value,$y);
                $intval = $intval + intval($sub);
            }
              //$intval = $intval%9;
              $varrefno = $value . strval($intval%9); 
            
         // return $user->idref;  
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
                         
                    if($vardepartment == "TVET"){
                        $plans = DB::Select("select distinct plan from ctr_payment_schedules where  course = '$varlevelcourse'");
                        $value = "<div class=\"col-md-12\">Plan</div><div class=\"col-md-12\"><select name = \"plan\" id=\"plan\" class=\"form-control\" onchange = \"getdiscount()\"><option>Select Plan</option>";
                         foreach($plans as $plan){
                            $value = $value . "<option value=\"" . $plan->plan ."\">" .$plan->plan . "</option>"; 
                            }
                            $value = $value . "</select></div>";
                    return $value;
                        
                    }else{     
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
            <tr><th>Student Number</th><th>Student Name</th><th>Gender</th><th>Assessment</th><th>Student Info</th><th>Student Grade</th></tr>        
            </thead><tbody>";
                    foreach($searches as $search){
                        $value = $value . "<tr><td>" .$search->idno . "</td><td>". $search->lastname . ", " .
                                $search->firstname . " " . $search->middlename . " " . $search->extensionname .
                                "</td><td>" . $search->gender . "</td><td><a href = '/registrar/evaluate/".$search->idno."'>Assess</a></td><td><a href = '/studentinfokto12/".$search->idno."'>Viewn Info</a></td><td><a href = '/seegrade/".$search->idno."'>View Grades</a></td>";
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
                
                function getsearchaccounting($varsearch){
                    if(Request::ajax()){
                    $searches = DB::Select("Select * From users where accesslevel = '0' AND (lastname like '$varsearch%' OR
                           firstname like '$varsearch%' OR idno = '$varsearch') Order by lastname, firstname");
                    $value = "<table class=\"table table-striped\"><thead>
            <tr><th>Student Number</th><th>Student Name</th><th>Gender</th><th>View</th></tr>        
            </thead><tbody>";
                    foreach($searches as $search){
                        $value = $value . "<tr><td>" .$search->idno . "</td><td>". $search->lastname . ", " .
                                $search->firstname . " " . $search->middlename . " " . $search->extensionname .
                                "</td><td>" . $search->gender . "</td><td><a href = '/accounting/".$search->idno."'>view</a>";
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
                     $schedules = DB::Select("select sum(amount) as amount, sum(discount) as discount, receipt_details, plan, level   from ctr_payment_schedules
                             where  course = '$course' and plan = '$plan' Group by receipt_details, plan, level ");

                }
                elseif($department == "Senior High School"){
                    $schedules = DB::Select("select sum(amount) as amount, sum(discount) as discount, receipt_details, plan, level   from ctr_payment_schedules
                             where strand = '$strand' and level = '$level' and plan = '$plan' Group by receipt_details, plan, level ");
                }
                else{
                    //$matchfields= ['level' => $level,'plan' => $plan];
                   
                    
                    if($level=='Grade 9' || $level=='Grade 10'){
                      $schedules = DB::Select("select sum(amount) as amount, sum(discount) as discount, receipt_details, plan, level   from ctr_payment_schedules
                             where strand = '$strand' and level = '$level' and plan = '$plan' Group by receipt_details, plan, level ");
                    //$   
                    }else{
                    $schedules = DB::Select("select sum(amount) as amount, sum(discount) as discount, receipt_details, plan, level  from ctr_payment_schedules
                             where level = '$level' and plan = '$plan' Group by receipt_details, plan, level");
                    //$schedules = \App\CtrPaymentSchedule::where($matchfields)->get();
                    }  }
                     $total=0;
                    $discount = 0;
                    $otherdiscount = 0;
                    
                    $request = "<table class = \"table table-bordered\"><tr><td>Description</td><td>Amount</td><tr>";
                    foreach($schedules as $schedule){
                    if(stristr($schedule->receipt_details, "Tuition")){
                    $otherdiscount = $otherdiscount + (($schedule->amount-$schedule->discount) * $otherdiscountrate);     
                    } 
                    $discount = $discount + $schedule->discount;
                    $total = $total + $schedule->amount; 
                    
                    $request = $request ."<tr><td>". $schedule->receipt_details."</td><td align=\"right\">" . number_format($schedule->amount,2)."</td></tr>";    
                    }
                    $request = $request . "<tr><td> Sub Total</td><td align=\"right\"><strong style=\"color:black\">". number_format($total,2)."</strong></td></tr>";
                    $request = $request . "<tr><td> Less: Plan Discount</td><td align=\"right\"><strong style=\"color:red\">(". number_format($discount,2).")</strong></td></tr>";
                    $request = $request . "<tr><td>Other Discount: $otherdiscountname</td><td align=\"right\"><strong style=\"color:red\">(". number_format($otherdiscount,2).")</strong></td></tr>";
                    $request = $request . "<tr><td>Advance Payment</td><td align=\"right\"><strong style=\"color:red\">(". number_format($advance,2).")</strong></td></tr>";
                    $request = $request . "<tr><td> Total</td><td align=\"right\"><strong style=\"color:black\">". number_format($total-$discount-$otherdiscount-$advance,2)."</strong></td></tr>";
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
            
            function getprevious($idno, $schoolyear){
                if(Request::ajax()){
             
                $ledgers = DB::Select("select sum(amount) as amount, sum(plandiscount) as plandiscount,  sum(otherdiscount) as otherdiscount, "
                        . "sum(debitmemo) as debitmemo, sum(payment) as payment, receipt_details from ledgers  where schoolyear = '".$schoolyear."' and "
                        . "idno = '".$idno."' group by receipt_details"); 
                //$matchfields=['idno'=>$idno, 'schoolyear'=>$schoolyear, 'paymenttype'=>'1'];
                //$debits = DB::Select("select dedits.*  from dedits, credits where dedits.refno = credits.refno and "
                //        . " credits.schoolyear = '". $schoolyear ."' and dedits.paymenttype = '1'");
               
                
                $data="";
                $data = $data . "<h5>Account Details</h5>";
                $data = $data . "<table class=\"table table-striped\">";
                $data = $data . "<tr><td>Description</td><td align=\"right\">Amount</td><td align=\"right\">Discount</td><td align=\"right\">DM</td><td align=\"right\">Payment</td><td align=\"right\">Balance</td></tr>";
                $totalamount = 0;
                $totaldiscount = 0;
                $totaldebitmemo = 0;
                $totalpayment = 0;
                
                if(count($ledgers) > 0){
                foreach($ledgers as $ledger){
              
                $totalamount = $totalamount + $ledger->amount;
                $totaldiscount = $totaldiscount + $ledger->plandiscount + $ledger->otherdiscount;
                $totaldebitmemo = $totaldebitmemo + $ledger->debitmemo;
                $totalpayment = $totalpayment + $ledger->payment;
               
                 $data = $data . "<tr><td>". $ledger->receipt_details ."</td><td align=\"right\">". number_format($ledger->amount,2). "</td><td align=\"right\">". number_format($ledger->plandiscount+$ledger->otherdiscount,2)."</td>";
                 $data = $data .  "<td align=\"right\">".number_format($ledger->debitmemo,2)."</td><td align=\"right\" style=\"color:red\">".number_format($ledger->payment,2)."</td>";
                 $data = $data . "<td align=\"right\">" .number_format($ledger->amount-$ledger->debitmemo-$ledger->plandiscount-$ledger->otherdiscount-$ledger->payment,2). "</td></tr>";
                }}
                 $data = $data . "<tr><td>Total</td><td align=\"right\">". number_format($totalamount,2)."</td>";
                 $data = $data . "<td align=\"right\">".number_format($totaldiscount,2)."</td>"; 
                 $data = $data . "<td align=\"right\">".number_format($totaldebitmemo,2)."</td>";
                 $data = $data . "<td align=\"right\" style=\"color:red\">".number_format($totalpayment,2)."</td>";
                 $data = $data . "<td align=\"right\"><strong>". number_format($totalamount-$totaldiscount-$totaldebitmemo-$totalpayment,2)."</strong></td></tr>";
                 $data = $data . "</table>";
                 
                 $data = $data . "<h5>Payment History<h5>"; 
                 $data = $data . "<table class=\"table table-striped\"><tr><td>Date</td><td>Ref Number</td><td>OR Number</td><td align=\"right\">Amount</td><td>Payment Type</td><td>Details</td><td>Status</td></tr>";
               
                 $credits = DB::Select("select distinct refno from credits where idno = '". $idno."' and schoolyear = '". $schoolyear ."'");
                    foreach($credits as $credit){
                         $debits = DB::Select("select * from dedits where refno = '" . $credit->refno ."'");   
                            if(count($debits)>0){
                            foreach($debits as $debit){
                                $data = $data . "<tr><td>" . $debit->transactiondate ."</td><td>" . $debit->refno ."</td><td>" . $debit->receiptno . "</td><td align=\"right\">".number_format($debit->amount + $debit->checkamount,2)."</td><td>";
                                     if($debit->paymenttype=='1'){
                                        $data = $data . "Cash/Check";
                                    }
                                    elseif($debit->paymenttype=='3'){
                                        $data = $data ."DEBIT MEMO";
                                    }
                                    $data = $data . "</td><td><a href='".url('/viewreceipt',array($debit->refno,$idno))."'>View</a></td>";
                                    $data = $data ."<td>";
                                    if($debit->isreverse=="0"){
                                    $data = $data . "Ok";
                                    }else{
                                    $data = $data . "Cancelled";
                                    }  
                                    $data = $data . "</td>";
                  
                                    $data = $data ."</tr>";
                            } }}
                                        $data = $data ."</table>";
                         
                         
                         
                         
                 return $data;
                }
            }
    

            function studentlist($level){
        if(Request::ajax()){
         if($level == "Grade 9" || $level=="Grade 10" || $level=="Grade 11" || $level=="Grade 12"){
         $strands = DB::Select("select distinct strand from ctr_payment_schedules where level = '$level'");
         $data = "<div class=\"form form-group\">";
        
         $data=$data. "<Select name =\"strand\" id=\"strand\" class=\"form form-control\" onchange=\"strand(this.value)\" >";
          $data=$data. "<option>Select Strand/Shop</option>";
         foreach($strands as $strand){
          $data = $data . "<option value=\"". $strand->strand . "\">" . $strand->strand . "</option>";       
               }
         $data = $data . "</select></div>"; 
          return $data;
         }  else{
         
        $lists = DB::Select("select users.idno, users.lastname, users.firstname, users.extensionname, users.middlename, "
                 . "statuses.level, statuses.strand, student_infos.fname, student_infos.fmobile, student_infos.mname, student_infos.mmobile from users, statuses, student_infos  where users.idno = statuses.idno "
                 . "and statuses.level = '". $level. "'  and statuses.status='2' and statuses.idno = student_infos.idno order by users.lastname, users.firstname");
         $data = "<h3>$level</h3><table class=\"table table-stripped\"><tr><td>Id No</td><td>Name</td><td>Father</td><td>Contact No</td><td>Mother</td><td>Contact No.</td></tr>";
         foreach($lists as $list){
         $data = $data . "<tr><td>".$list->idno . "</td><td>". $list->lastname.", ".$list->firstname. " " . $list->middlename . " </td><td>".$list->fname."</td>"
                 . "<td>".$list->fmobile."</td><td>".$list->mname."</td><td>".$list->mmobile."</td></tr>";
         
         }
         $data = $data . "</table>"; 
           return $data;  
         }
          
        }
        
    }
    
    function strand($strand, $level){
        if(Request::ajax()){
        
        $lists = DB::Select("select users.idno, users.lastname, users.firstname, users.extensionname, users.middlename, "
                 . "statuses.level, statuses.strand from users, statuses where users.idno = statuses.idno "
                 . "and statuses.level = '". $level. "' and statuses.strand='". $strand ."' order by users.lastname, users.firstname");
         $data = "<h3>$level</h3><table class=\"table table-stripped\"><tr><td>Student Id</td><td>Name</td></tr>";
         foreach($lists as $list){
         $data = $data . "<tr><td>".$list->idno . "</td><td>". $list->lastname.", ".$list->firstname. " " . $list->middlename . " </td></tr>";
         
         }
         $data = $data . "</table>"; 
           return $data;  
         
         //return $strand; 
        } 
        
    }

     function myDeposit(){
        if(Request::ajax()){  
            $idno = Input::get('idno');
            $bank = Input::get('bank');
            $deposittype = Input::get('deposittype');
            $amount = Input::get('amount');
            $transactiondate=Input::get('transactiondate');
            
            
            $deposit_slip = new \App\DepositSlip;
            $deposit_slip->transactiondate = $transactiondate;
            $deposit_slip->bank=$bank;
            $deposit_slip->deposittype=$deposittype;
            $deposit_slip->postedby=$idno;
            $deposit_slip->amount = $amount;
            $deposit_slip->save();
            return "true";
        }    
     }
        function removeslip($refid){
        if(Request::ajax()){
            \App\DepositSlip::where('id',$refid)->delete();
            
             return "true";
        }
        }
        
        function getstudentlist($level){
            if(Request::ajax()){
                   
                   
                    $studentnames = DB::Select("select statuses.id, statuses.idno, users.lastname, "
                        . "users.firstname, users.middlename, statuses.section  from statuses, users where statuses.idno = "
                        . "users.idno and statuses.level = '$level' and statuses.strand = '" . Input::get("strand") ."'  and statuses.status = '2' order by users.lastname, users.firstname, users.middlename");
               
                
                $data = "";
                $data = $data . "<table class=\"table table-stripped\"><tr><td>ID No</td><td>Name</td><td>Section</td></tr>";
                    foreach($studentnames as $studentname){
                        $data = $data . "<tr><td>".$studentname->idno."</td><td><span style=\"cursor:pointer\"onclick=\"setsection('" . $studentname->id . "')\">".$studentname->lastname . ", " . $studentname->firstname . " " .$studentname->middlename . "</span></td><td>" . $studentname->section . "</td></tr>"; 
                    }
                $data = $data."</table>";
                
                return $data;
            }
        }
        
        function getsection($level){
            if(Request::ajax()){
                $strand = Input::get("strand");
                $sections = DB::Select("select  * from ctr_sections where level = '$level' and strand = '$strand'");
                   $data = "";
                   $data = $data . "<div class=\"col-md-6\"><label for=\"section\">Select Section</label><select id=\"section\" onchange=\"callsection()\" class=\"form form-control\">";
                 $data = $data . "<option>--Select--</option>";
                   foreach($sections as $section){
                      $data = $data . "<option value= '". $section->section ."'>" .$section->section . "</option>";  
                    }
                   $data = $data."</select></div>";
                return $data;   
                //return "roy";
            }
        }
        
        function getsection1($level){
            if(Request::ajax()){
              if($level=="Grade 9" || $level=="Grade 10" || $level=="Grade 11" || $level=="Grade 12"){
                  $strands = DB::Select("select distinct strand from ctr_sections where level = '$level'");
                  $data="";
                  $data = $data . "<label for=\"strand\">Select Strand/Shop</label><select id=\"strand\"  onchange=\"getsectiontrack(this.value)\" name=\"strand\" class=\"form form-control\">";
                  $data = $data . "<option>--Select--</option>";
                  foreach($strands as $strand){
                      $data = $data . "<option value= '". $strand->strand ."'>" .$strand->strand . "</option>";  
                    }
                   $data = $data."</select>";
              }  else {
                $sections = DB::Select("select  * from ctr_sections where level = '$level'");
                   $data = "";
                   $data = $data . "<label for=\"section\">Select Section</label><select id=\"section\"  class=\"form form-control\">";
                   $data = $data . "<option>--Select--</option>"; 
                   foreach($sections as $section){
                      $data = $data . "<option value= '". $section->section ."'>" .$section->section . "</option>";  
                    }
                   $data = $data."</select>";
              }
                return $data;   
                //return "roy";
            }
        }
        
        function getsectionstrand($level,$strand){
            if(Request::ajax()){
             
                $sections = DB::Select("select  * from ctr_sections where level = '$level' and strand='$strand'");
                   $data = "";
                   $data = $data . "<label for=\"section\">Select Section</label><select id=\"section\"  class=\"form form-control\">";
                    foreach($sections as $section){
                      $data = $data . "<option value= '". $section->section ."'>" .$section->section . "</option>";  
                    }
                   $data = $data."</select>";
              
                return $data;   
                //return "roy";
            }
        }
        
        function getsectionlist($level,$section){
            if(Request::ajax()){
                 $ad = \App\CtrSection::where('level',$level)->where('section',$section)->where('strand',Input::get('strand'))->first();
                 $adviser = $ad->adviser;
                $studentnames = DB::Select("select statuses.id, statuses.idno, users.lastname, "
                        . "users.firstname, users.middlename, statuses.section from statuses, users where statuses.idno = "
                        . "users.idno and statuses.level = '$level'  AND statuses.section = '$section' and strand = '" . Input::get("strand") . "' order by users.gender, users.lastname, users.firstname, users.middlename");
                $cn=1;
                $data = "<div class=\"col-md-6\"><label for=\"adviser\">Adviser</label><input type=\"text\" id=\"adviser\" class=\"form form-control\" value=\"" . $adviser . "\" onkeyup = \"updateadviser(this.value,'" . $ad->id . "')\"></div>";
                $data = $data . "<table class=\"table table-stripped\"><tr><td>ID No</td><td>CN</td><td>Name</td><td>Section</td></tr>";
                    foreach($studentnames as $studentname){
                        $data = $data . "<tr><td>".$studentname->idno."</td><td>" . $cn++ . "</td><td><span style=\"cursor:pointer\" onclick=\"rmsection('" . $studentname->id . "')\">".$studentname->lastname . ", " . $studentname->firstname . " " .$studentname->middlename . "</span></td><td>" . $studentname->section . "</td></tr>"; 
                    }
                $data = $data."</table>";
                $data = $data . "<a href = \"". url('/printsection', array($level,$section,Input::get('strand')))."\" class =\"btn btn-primary\"> Print Section</a>";
                return $data;
                
            }
        }
        
        function setsection($id, $section){
            if(Request::ajax()){
            $updatesection = \App\Status::find($id);
            $updatesection->section = $section;
            $updatesection->update();
            return "true";
            }
        }

        function rmsection($id){
            if(Request::ajax()){
            $updatesection = \App\Status::find($id);
            $updatesection->section = "";
            $updatesection->update();
            return "true";
            }
        }
        
        function getstrand($level){
            if(Request::ajax()){
                $strands = DB::Select("select distinct strand from ctr_sections where level = '$level'");
                $data = "<div class=\"form form-group\"><label for=\"strand\">Select Shop/Strand</label>";
                $data=$data. "<Select name =\"strand\" id=\"strand\" class=\"form form-control\" onchange=\"getstrandall(this.value)\" >";
                $data=$data. "<option>--Select--</option>";
                    foreach($strands as $strand){
                        $data = $data . "<option value=\"". $strand->strand . "\">" . $strand->strand . "</option>";       
                    }
                $data = $data . "</select></div>"; 
                return $data;
            }
        }
        
        function updateadviser($id, $value){
            $adviser = \App\CtrSection::find($id);
            $adviser->adviser = $value;
            $adviser->update();
            
            return true;
        }
        
        function getsoasummary($level,$strand,$section,$trandate){
       if($strand=="none"){
           $soasummary = DB::Select("select statuses.idno, users.lastname, users.firstname, users.middlename, "
                . " sum(ledgers.amount) - sum(ledgers.payment) - sum(ledgers.debitmemo) - sum(ledgers.plandiscount) - sum(ledgers.otherdiscount) as amount "
                . " from users, statuses, ledgers where users.idno = statuses.idno and users.idno = ledgers.idno and "
                . " statuses.level = '$level' and statuses.section='$section' and ledgers.duedate <= '$trandate' "
                . " group by statuses.idno, users.lastname, users.firstname, users.middlename order by users.lastname, users.firstname");    

       }   else{  
        $soasummary = DB::Select("select statuses.idno, users.lastname, users.firstname, users.middlename, "
                . " sum(ledgers.amount) - sum(ledgers.payment) - sum(ledgers.debitmemo) - sum(ledgers.plandiscount) - sum(ledgers.otherdiscount) as amount "
                . " from users, statuses, ledgers where users.idno = statuses.idno and users.idno = ledgers.idno and "
                . " statuses.level = '$level' and statuses.strand='$strand' and statuses.section='$section' and ledgers.duedate <= '$trandate' "
                . " group by statuses.idno, users.lastname, users.firstname, users.middlename order by users.lastname, users.firstname");    
       }
        $data = "";
        $data = $data . "<table class = \"table table-stripped\"><tr><td>Student No</td><td>Name</td><td>Balance</td><td></td></tr>";
        foreach($soasummary as $soa){
        if($soa->amount > 0){    
        $data = $data . "<tr><td>" . $soa->idno . "</td><td>"
                . $soa->lastname . ", "
                . $soa->firstname . " " . $soa->middlename. "</td>"
                . "<td align=\"right\">" . number_format($soa->amount,2) . "</td>"
                . "<td><a href=\"/printsoa/". $soa->idno. "/".$trandate ."\">Print</a></td></tr>";
        }}
        $data = $data."</table>";
        return $data;
           // return $level.$strand.$section.$trandate;
        }
        
        function displaygrade(){
            $grades = \App\Grade::where('idno',Input::get('idno'))->where('schoolyear',Input::get('sy'))->get();
            $data = "<h1>Hello</h1>";
            $data = "<table class=\"table table-stripped\"><tr><td>Subject</td><td>1</td><td>2</td><td>3</td><td>4</td><td>Final</td><td>Remarks</td></tr>";
            foreach($grades as $grade){
            $data = $data . "<tr><td>".$grade->subjectname."</td><td>".$grade->first_grading."</td><td>" . $grade->second_grading . ""
                    . "</td><td>" . $grade->third_grading . "</td><td>" . $grade->fourth_grading . "</td><td>" . $grade->finalgrade 
                    . "</td><td>". $grade->remarks . "</td><td></tr>";    
            }
            $data = $data . "</table>";
            
            return $data;
        }
        
            }
