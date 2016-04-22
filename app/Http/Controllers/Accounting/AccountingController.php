<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountingController extends Controller
{
 
    public function __construct()
	{
		$this->middleware('auth');
	}
//
    
    function view($idno){
       if(\Auth::user()->accesslevel==env('USER_ACCOUNTING')){
       $student = \App\User::where('idno',$idno)->first();
       $status = \App\Status::where('idno',$idno)->first();  
       $reservation = 0;
       $totalprevious = 0;
       $ledgers = null;
       $dues = null;
       $penalty = 0;
       $totalmain = 0;
      
       //Get other added collection
       $matchfields = ["idno"=>$idno, "categoryswitch"=>env("OTHER_FEE")];
       $othercollections = \App\Ledger::where($matchfields)->get();
       //get previous balance
       $previousbalances = DB::Select("select schoolyear, sum(amount)- sum(plandiscount)- sum(otherdiscount)
               - sum(debitmemo) - sum(payment) as amount from ledgers where idno = '$idno' 
               and categoryswitch >= '"  .env('PREVIOUS_MISCELLANEOUS_FEE') ."' group by schoolyear");
       if(count($previousbalances)>0){ 
       foreach($previousbalances as $prev){
            $totalprevious = $totalprevious + $prev->amount;
       }}
       //get reservation
       if(isset($status->status)){
           //if($status->status == "1"){
           $reservations = DB::Select("select amount as amount from advance_payments where idno = '$idno' and status = '0'");
           if(count($reservations)>0){
               foreach($reservations as $reserve)
               {
                   $reservation = $reservation + $reserve->amount;
               }
       }}
           
       //get current account
          if(isset($status->department)){
                $currentperiod = \App\ctrSchoolYear::where('department',$status->department)->first();  
                $ledgers = DB::Select("select sum(amount) as amount, sum(plandiscount) as plandiscount, sum(otherdiscount) as otherdiscount,
                sum(payment) as payment, sum(debitmemo) as debitmemo, receipt_details, schoolyear, period, categoryswitch from ledgers where
                idno = '$idno' and categoryswitch <= '10' group by receipt_details, schoolyear, period, categoryswitch order by categoryswitch");
               
                if(count($ledgers)>0){
                    foreach($ledgers as $ledger){
                        if($ledger->categoryswitch <= '6'){
                        $totalmain=$totalmain+$ledger->amount - $ledger->plandiscount -$ledger->otherdiscount - $ledger->debitmemo - $ledger->payment;
                        }
                        
                        }
                }
                
                $dues = DB::Select("select sum(amount) - sum(plandiscount) - sum(otherdiscount)
                - sum(payment)- sum(debitmemo) as balance, sum(plandiscount) + sum(otherdiscount) as discount, duedate, duetype from ledgers where
                idno = '$idno' and categoryswitch <= '6' group by duedate, duetype");
          
                /*foreach($dues as $due){
                if(((strtotime(date('Y-m-d'))/(60*60*24)) - strtotime($due->duedate)/(60*60*24)) > 1){
                   $penalty = $penalty + ($due->balance * 0.05);
                }
               }
       
           if($penalty > 0 && $penalty < 250){
               $penalty = 250;
           }*/
                
                $matchfields=["idno"=>$idno,"categoryswitch"=>env('PENALTY_CHARGE')];
                $penalties = \App\Ledger::where($matchfields)->get();
                if(count($penalties)>0){
                    foreach($penalties as $pen){
                        $penalty= $penalty + $pen->amount - $pen->debitmemo - $pen->otherdiscount - $pen->payment;
                    }
                }
           
        } 
           
           //history of payments
           $debits = DB::SELECT("select * from dedits where idno = '" . $idno . "' and "
                   . "paymenttype <= '2' order by transactiondate");
           //debit description
           $debitdms = DB::SELECT("select * from dedits where idno = '" . $idno . "' and "
                   . "paymenttype = '3' order by transactiondate");
           
          $debitdescriptions = DB::Select("select * from ctr_debitaccounts");
           return view('accounting.studentledger',  compact('debitdms','debits','penalty','totalmain','totalprevious','previousbalances','othercollections','student','status','ledgers','reservation','dues','debitdescriptions'));

       }   
       
   }
   
   function debitcredit(Request $request){
       $account=null;
       $discount = 0;
       $refno = $this->getRefno();
       
       if($request->totaldue > '0'){
           $totaldue = $request->totaldue;        
                $accounts = DB::SELECT("select * from ledgers where idno = '".$request->idno."' and categoryswitch <= '6' "
                     . " and (amount - payment - debitmemo - plandiscount - otherdiscount) > 0 order By duedate, categorySwitch");    
                    foreach($accounts as $account){
                        $balance = $account->amount - $account->payment - $account->plandiscount - $account->otherdiscount - $account->debitmemo;
                        if($balance < $totaldue){
                            $discount = $discount + $account->plandiscount + $account->otherdiscount;
                            $updatepay = \App\Ledger::where('id',$account->id)->first();
                            $updatepay->debitmemo = $updatepay->debitmemo + $balance;
                            $updatepay->save();
                            $totaldue = $totaldue - $balance;
                            $credit = new  \App\Credit;
                            $credit->idno = $request->idno;
                            $credit->transactiondate = Carbon::now();
                            $credit->referenceid = $account->id;
                            $credit->refno = $refno;
                            $credit->categoryswitch = $account->categoryswitch;
                            $credit->acctcode = $account->acctcode;
                            $credit->description = $account->description;
                            $credit->receipt_details = $account->receipt_details;
                            $credit->duedate=$account->duedate;
                            $credit->amount=$account->amount-$account->payment-$account->debitmemo;
                            $credit->schoolyear=$account->schoolyear;
                            $credit->period=$account->period;
                            $credit->postedby=\Auth::user()->idno;
                            $credit->save();
                            //$this->credit($request->idno, $account->id, $refno, $account->amount-$account->payment-$account->debitmemo);
                            } else {
                                
                            $updatepay = \App\Ledger::where('id',$account->id)->first();
                            $updatepay->debitmemo = $updatepay->debitmemo + $totaldue;
                            $updatepay->save();
                            $credit = new \App\Credit;
                            $credit->idno = $request->idno;
                            $credit->transactiondate = Carbon::now();
                            $credit->referenceid = $account->id;
                            $credit->refno = $refno;
                            $credit->categoryswitch = $account->categoryswitch;
                            $credit->acctcode = $account->acctcode;
                            $credit->description = $account->description;
                            $credit->receipt_details = $account->receipt_details;
                            $credit->duedate=$account->duedate;
                            if($balance == $totaldue){
                            $discount = $discount + $account->plandiscount + $account->otherdiscount;
                            $credit->amount=$account->amount-$account->payment-$account->debitmemo;
                                } else {
                            $credit->amount=$totaldue;
                                }       
                            $credit->schoolyear=$account->schoolyear;
                            $credit->period=$account->period;
                            $credit->postedby=\Auth::user()->idno;
                            $credit->save();
                            
                            //$this->credit($request->idno, $account->id, $refno, $totaldue + $account->plandiscount + $account->otherdiscount);
                            $totaldue = 0;
                            break;
                          }
                    }
                $this->changestatatus($request->idno, $request->reservation);
                if($request->reservation > 0){
                $this->debit_reservation_discount($request->idno,env('DEBIT_RESERVATION') , $request->reservation);
                $this->consumereservation($request->idno);
                }
       } 
       
             if($request->previous > 0 ){
             $previous = $request->previous;
             $updateprevious = DB::SELECT("select * from ledgers where idno = '".$request->idno."' and categoryswitch >= '11' "
                     . " and amount - payment - debitmemo - plandiscount - otherdiscount > 0 order By categoryswitch");
             foreach($updateprevious as $up){
                 $balance = $up->amount - $up->payment - $up->plandiscount - $up->otherdiscount - $up->debitmemo;
                 if($balance < $previous ){
                     $discount1 = $discount1 + $up->plandiscount + $up->otherdiscount;
                     $updatepay = \App\Ledger::where('id',$up->id)->first();
                     $updatepay->debitmemo = $updatepay->debitmemo + $balance;
                     $updatepay->save();
                     $previous = $previous - $balance;
                     $credit = new  \App\Credit;
                     $credit->idno = $request->idno;
                     $credit->transactiondate = Carbon::now();
                     $credit->referenceid = $up->id;
                     $credit->refno = $refno;
                     $credit->categoryswitch = $up->categoryswitch;
                     $credit->acctcode = $up->acctcode;
                     $credit->description = $up->description;
                     $credit->receipt_details = $up->receipt_details;
                     $credit->duedate=$up->duedate;
                     $credit->amount=$up->amount-$up->payment-$up->debitmemo;
                     $credit->schoolyear=$up->schoolyear;
                     $credit->period=$up->period;
                     $credit->postedby=\Auth::user()->idno;
                     $credit->save();
                     
                    // $this->credit($request->idno, $up->id, $refno,  $up->amount - $up->payment - $up->debitmemo);
                 } else {
                            $updatepay = \App\Ledger::where('id',$up->id)->first();
                            $updatepay->debitmemo = $updatepay->debitmemo + $previous;
                            $updatepay->save();
                            $credit = new \App\Credit;
                            $credit->idno = $request->idno;
                            $credit->transactiondate = Carbon::now();
                            $credit->referenceid = $up->id;
                            $credit->refno = $refno;
                            $credit->categoryswitch = $up->categoryswitch;
                            $credit->acctcode = $up->acctcode;
                            $credit->description = $up->description;
                            $credit->receipt_details = $up->receipt_details;
                            $credit->duedate=$up->duedate;
                            if($balance == $totaldue){
                            $discount = $discount + $up->plandiscount + $up->otherdiscount;
                            $credit->amount=$up->amount-$up->payment-$up->debitmemo;
                                } else {
                            $credit->amount=$totaldue;
                                }       
                            $credit->schoolyear=$up->schoolyear;
                            $credit->period=$up->period;
                            $credit->postedby=\Auth::user()->idno;
                            $credit->save();
                            //$this->credit($request->idno, $up->id, $refno, $previous);
                            $previous = 0;
                            break;
                       }
                 
                 
             }   
            }
            /*
            if(isset($request->other)){
                foreach($request->other as $key=>$value){
                    $updateother = \App\Ledger::find($key);
                    $updateother->debitmemo = $updateother->debitmemo + $value;
                    $updateother->save();
                    $this->credit($updateother->idno, $updateother->id, $refno, $orno, $value);
                }
            }
            */
              if($request->penalty > 0){
           $penalty = $request->penalty;
            $updatepenalties = DB::SELECT("select * from ledgers where idno = '".$request->idno."' and categoryswitch = '". env('PENALTY_CHARGE'). "' "
                     . " and amount - payment - debitmemo - plandiscount - otherdiscount > 0");
           foreach($updatepenalties as $pen){
               $balance = $pen->amount - $pen->payment = $pen->plandiscount - $pen-> otherdiscount - $pen->debitmemo;
               
               if($balance < $penalty ){
                     $updatepay = \App\Ledger::where('id',$pen->id)->first();
                     $updatepay->debitmemo = $updatepay->debitmemo + $balance;
                     $updatepay->save();
                     $penalty = $penalty - $balance;
                     $credit = new  \App\Credit;
                            $credit->idno = $request->idno;
                            $credit->transactiondate = Carbon::now();
                            $credit->referenceid = $pen->id;
                            $credit->refno = $refno;
                            $credit->categoryswitch = $pen->categoryswitch;
                            $credit->acctcode = $pen->acctcode;
                            $credit->description = $pen->description;
                            $credit->duedate=$pen->duedate;
                            $credit->receipt_details = $pen->receipt_details;
                            $credit->amount=$pen->amount-$pen->payment-$pen->debitmemo;
                            $credit->schoolyear=$pen->schoolyear;
                            $credit->period=$pen->period;
                            $credit->postedby=\Auth::user()->idno;
                     
                     
                     
                     //$this->credit($request->idno, $pen->id, $refno, $orno, $pen->amount);
                 } else {
                            $updatepay = \App\Ledger::where('id',$pen->id)->first();
                            $updatepay->debitmemo = $updatepay->debitmemo + $penalty;
                            $updatepay->save();
                             $credit = new \App\Credit;
                            $credit->idno = $request->idno;
                            $credit->transactiondate = Carbon::now();
                            $credit->referenceid = $pen->id;
                            $credit->refno = $refno;
                            $credit->categoryswitch = $pen->categoryswitch;
                            $credit->acctcode = $pen->acctcode;
                            $credit->description = $pen->description;
                            $credit->receipt_details = $pen->receipt_details;
                            $credit->duedate=$pen->duedate;
                            
                            $credit->amount=$totaldue;
                                   
                            $credit->schoolyear=$pen->schoolyear;
                            $credit->period=$pen->period;
                            $credit->postedby=\Auth::user()->idno;
                            $credit->save();
                      //      $this->credit($request->idno, $pen->id, $refno, $orno, $penalty);
                            $penalty = 0;
                            break;
                       }
           }
            
           
          
           
       }
        $student= \App\User::where('idno', $request->idno)->first();
        $debitaccount = new \App\Dedit;
        $debitaccount->idno = $request->idno;
        $debitaccount->transactiondate=Carbon::now();
        $debitaccount->refno=$this->getRefno();
        $debitaccount->receiptno = $this->getRefno();
        $debitaccount->paymenttype = "3";
        $debitaccount->acctcode=$request->debitdescription;
        $debitaccount->receivefrom = $student->lastname . ", " . $student->firstname . " " . $student->extensionname . " " .$student->middlename;
        $debitaccount->amount = $request->totaldue + $request->penalty + $request->previous;    
        $debitaccount->postedby=\Auth::user()->idno;
        $debitaccount->save();
        $this->reset_or(); 
          
                return redirect(url('/viewdm',array($refno,$request->idno)));    
    //   return $request;
   }
    
   function reset_or(){
        $resetor = \App\User::where('idno', \Auth::user()->idno)->first();
        $resetor->reference_number = $resetor->reference_number + 1;
        $resetor->save();
    }
    
     function getRefno(){
         $newref= \Auth::user()->id . \Auth::user()->reference_number;
         return $newref;
    }
    
   
   function changestatatus($idno, $reservation){
   $status = \App\Status::where('idno',$idno)->first();    
       if(count($status)> 0 ){
           if($status->status == "1"){
               if($reservation == "0"){
               $this->addreservation($idno);
               }
               $status->status='2';
               $status->date_enrolled=Carbon::now();
               $status->save();
           }
       }
   }
    
   function debit_reservation_discount($idno,$debittype,$amount){
        $student = \App\User::where('idno',$idno)->first();
        $debitaccount = new \App\Dedit;
        $debitaccount->idno = $idno;
        $debitaccount->transactiondate=Carbon::now();
        $debitaccount->refno=$this->getRefno();
        $debitaccount->receiptno = $this->getRefno();
        $debitaccount->acctcode = "Reservation";
        $debitaccount->paymenttype = $debittype;
        $debitaccount->receivefrom = $student->lastname . ", " . $student->firstname . " " . $student->extensionname . " " .$student->middlename;
        $debitaccount->amount = $amount;    
        $debitaccount->postedby=\Auth::user()->idno;
        $debitaccount->save();
        
    }
    
     function consumereservation($idno){
        $crs= \App\AdvancePayment::where('idno',$idno)->get();
        foreach($crs as $cr){
            $cr->status = "1";
            $cr->postedby = \Auth::user()->idno;
            $cr->save();
        }
    }
    
    function addreservation($idno){
      $status=  \App\Status::where('idno',$idno)->first();
      $addcredit = new \App\Credit;
      $addcredit->idno = $idno;
      $addcredit->transactiondate = Carbon::now();
      $addcredit->refno = $this->getRefno();
      $addcredit->receiptno = $this->getRefno();
      $addcredit->categoryswitch = "9";
      $addcredit->acctcode = "Reservation";
      $addcredit->description = "Reservation";
      $addcredit->receipt_details = "Reservation";
      $addcredit->amount = "1000.00";
      if(isset($status->schoolyear)){
      $addcredit->schoolyear=$status->schoolyear;
      }
      $addcredit->postedby=\Auth::user()->idno;
      $addcredit->save();
      
      $adddebit = new \App\Dedit;
      $adddebit->idno = $idno;
      $adddebit->transactiondate = Carbon::now();
      $adddebit->paymenttype = '5';
      $adddebit->amount = "1000.00";
      $adddebit->acctcode="Reservation";
      $adddebit->refno = $this->getRefno();
      $adddebit->receiptno = $this->getRefno();
      $adddebit->postedby = \Auth::user()->idno;
      if(isset($status->schoolyear)){
      $adddebit->schoolyear = $status->schoolyear;
      }
      $adddebit->save();
      
      $addreservation = new \App\AdvancePayment;
      $addreservation->idno = $idno;
      $addreservation->amount = "1000.00";
      $addreservation->refno = $this->getRefno();
      $addreservation->transactiondate=Carbon::now();
      $addreservation->postedby=\Auth::user()->idno;
      $addreservation->status = "1";
      $addreservation->save();
      
  }
  
  function viewdm($refno, $idno){
       $student = \App\User::where('idno',$idno)->first();
       $status= \App\Status::where('idno',$idno)->first();
       $debits = \App\Dedit::where('refno',$refno)->get();
       $debit_discount = \App\Dedit::where('refno',$refno)->where('paymenttype','4')->first();
       $debit_dm = \App\Dedit::where('refno',$refno)->where('paymenttype','3')->first();
       $credits = DB::Select("select sum(amount) as amount, receipt_details, transactiondate from credits "
               . "where refno = '$refno' group by receipt_details, transactiondate");
       $tdate = \App\Dedit::where('refno',$refno)->first();
       $posted = \App\User::where('idno',$tdate->postedby)->first();
       return view("accounting.viewdm",compact('posted','tdate','student','debits','credits','status','debit_discount','debit_dm'));
       
  }
  
  function printdmcm($refno, $idno){
       $student = \App\User::where('idno',$idno)->first();
       $status= \App\Status::where('idno',$idno)->first();
       $debits = \App\Dedit::where('refno',$refno)->get();
       $debit_discount = \App\Dedit::where('refno',$refno)->where('paymenttype','4')->first();
       $debit_dm = \App\Dedit::where('refno',$refno)->where('paymenttype','3')->first();
       $credits = DB::Select("select sum(amount) as amount, receipt_details, transactiondate from credits "
               . "where refno = '$refno' group by receipt_details, transactiondate");
       $tdate = \App\Dedit::where('refno',$refno)->first();
       $posted = \App\User::where('idno',$tdate->postedby)->first();
       $pdf = \App::make('dompdf.wrapper');
      // $pdf->setPaper([0, 0, 336, 440], 'portrait');
       $pdf->loadView("print.printdmcm",compact('posted','tdate','student','debits','credits','status','debit_discount','debit_reservation','debit_cash','debit_dm'));
       return $pdf->stream();
  
}
}
