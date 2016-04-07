<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CashierController extends Controller
{
      public function __construct()
	{
		$this->middleware('auth');
	}
        
   function view($idno){
       if(\Auth::user()->accesslevel==env('USER_CASHIER') || \Auth::user()->accesslevel == env('USER_CASHIER_HEAD')){
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
           if($status->status == "1"){
           $reservations = DB::Select("select amount as amount from advance_payments where idno = '$idno' and status = '0'");
           if(count($reservations)>0){
               foreach($reservations as $reserve)
               {
                   $reservation = $reservation + $reserve->amount;
               }
       }}}
           
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
        
           return view('cashier.studentledger',  compact('debits','penalty','totalmain','totalprevious','previousbalances','othercollections','student','status','ledgers','reservation','dues'));

       }   
       
   }
   
  

    function setStatus($idno){
        $newstatus = \App\User::where('idno',$idno)->first();
        if($newstatus->status < '2'){
            $newstatus->status = '2';
            $newstatus->update();
        }
        
        return true;
    }
    
    function getRefno(){
         $newref= \Auth::user()->id . \Auth::user()->reference_number;
         return $newref;
    }
    
    function getOR(){
        //$user = \App\User::where('idno', Auth::user()->idno )->first();
        $receiptno = \Auth::user()->receiptno;
        return $receiptno;
       
    }
    
    function setreceipt($id){
       //return  $id = Auth::user()->id;
       $receiptno = \Auth::user()->receiptno;
       return view('cashier.setreceipt',compact('id','receiptno'));
    }
    
    function setOR(Request $request){
     $receiptno = \App\User::where('id', \Auth::user()->id)->first();
     $receiptno->receiptno = $request->receiptno;
     $receiptno->save();
     return redirect('/');
    }
    
     function payment(Request $request){
            $account=null;
            $orno = $this->getOR();
            $refno = $this->getRefno();
            $discount = 0;
            
            if($request->totaldue > 0 ){
            $totaldue = $request->totaldue;       
            //$accounts = \App\Ledger::where('idno',$request->idno)->where('categoryswitch','<=','6')->orderBy('categoryswitch')->get();
            $accounts = DB::SELECT("select * from ledgers where idno = '".$request->idno."' and categoryswitch <= '6' "
                     . " and (amount - payment - debitmemo - plandiscount - otherdiscount) > 0 order By categoryswitch");    
                    foreach($accounts as $account){
                    $discount = $discount + $account->plandiscount + $account->otherdiscount;
                    $balance = $account->amount - $account->payment - $account->plandiscount - $account->otherdiscount - $account->debitmemo;
                        
                        if($balance < $totaldue){
                            $updatepay = \App\Ledger::where('id',$account->id)->first();
                            $updatepay->payment = $updatepay->payment + $balance;
                            $updatepay->save();
                            $totaldue = $totaldue - $balance;
                            $this->credit($request->idno, $account->id, $refno, $orno, $account->amount-$account->payment);
                        } else {
                            $updatepay = \App\Ledger::where('id',$account->id)->first();
                            $updatepay->payment = $updatepay->payment + $totaldue;
                            $updatepay->save();
                            $this->credit($request->idno, $account->id, $refno, $orno, $totaldue + $account->plandiscount + $account->otherdiscount);
                            $totaldue = 0;
                            break;
                        }
                    
                }
             
            }
            
            
            if($request->previous > 0 ){
             $previous = $request->previous;
             $updateprevious = DB::SELECT("select * from ledgers where idno = '".$request->idno."' and categoryswitch >= '11' "
                     . " and amount - payment - debitmemo - plandiscount - otherdiscount > 0 order By categoryswitch");
             foreach($updateprevious as $up){
                 $balance = $up->amount - $up->payment - $up->plandiscount - $up->otherdiscount - $up->debitmemo;
                 if($balance < $previous ){
                     $updatepay = \App\Ledger::where('id',$up->id)->first();
                     $updatepay->payment = $updatepay->payment + $balance;
                     $updatepay->save();
                     $previous = $previous - $balance;
                     $this->credit($request->idno, $up->id, $refno, $orno, $up->amount);
                 } else {
                            $updatepay = \App\Ledger::where('id',$up->id)->first();
                            $updatepay->payment = $updatepay->payment + $previous;
                            $updatepay->save();
                            $this->credit($request->idno, $up->id, $refno, $orno, $previous);
                            $previous = 0;
                            break;
                       }
                 
                 
             }   
            }
            
            if(isset($request->other)){
                foreach($request->other as $key=>$value){
                    $updateother = \App\Ledger::find($key);
                    $updateother->payment = $updateother->payment + $value;
                    $updateother->save();
                    $this->credit($updateother->idno, $updateother->id, $refno, $orno, $value);
                }
            }
            
       if($request->penalty > 0){
           $penalty = $request->penalty;
            $updatepenalties = DB::SELECT("select * from ledgers where idno = '".$request->idno."' and categoryswitch = '". env('PENALTY_CHARGE'). "' "
                     . " and amount - payment - debitmemo - plandiscount - otherdiscount > 0");
           foreach($updatepenalties as $pen){
               $balance = $pen->amount - $pen->payment = $pen->plandiscount - $pen-> otherdiscount - $pen->debitmemo;
               
               if($balance < $penalty ){
                     $updatepay = \App\Ledger::where('id',$pen->id)->first();
                     $updatepay->payment = $updatepay->payment + $balance;
                     $updatepay->save();
                     $penalty = $penalty - $balance;
                     $this->credit($request->idno, $pen->id, $refno, $orno, $pen->amount);
                 } else {
                            $updatepay = \App\Ledger::where('id',$pen->id)->first();
                            $updatepay->payment = $updatepay->payment + $penalty;
                            $updatepay->save();
                            $this->credit($request->idno, $pen->id, $refno, $orno, $penalty);
                            $penalty = 0;
                            break;
                       }
           }
            
            /*
            $currentperiod = \App\ctrSchoolYear::first();
            $penalty = new \App\Credit;
            $penalty->idno = $request->idno;
            $penalty->refno = $refno;
            $penalty->receiptno = $orno;
            $penalty->categoryswitch = env("PENALTY_CHARGE");
            $penalty->acctcode="Penalty";
            $penalty->description="Penalty";
            $penalty->receipt_details = "Penalty";
            $penalty->amount=$request->penalty;
            $penalty->schoolyear = $currentperiod->schoolyear;
            $penalty->save(); 
            }     
          */
           
       }
            $bank_branch = "";
            $check_number = "";
            
            //if($request->receivecheck > "0"){
            $bank_branch=$request->bank_branch; 
            $check_number = $request->check_number;
            $iscbc = 0;
                if($request->iscbc =="cbc"){
                    $iscbc = 1;
                }
            $depositto = $request->depositto;    
            $this->debit($request->idno,env('DEBIT_CHECK') , $bank_branch, $check_number,$request->receivecash, $request->receivecheck, $iscbc,$depositto);
            //}
            
            
           //if($request->receivecash > "0){
            //$this->debit($request->idno,env('DEBIT_CASH') , $bank_branch, $check_number, $request->receiveamount, '0');
            //}
                    
            if($discount > 0 ){
              $this->debit_reservation_discount($request->idno,env('DEBIT_DISCOUNT') , $discount);
            }      
         
            if($request->reservation > 0){
                $this->debit_reservation_discount($request->idno,env('DEBIT_RESERVATION') , $request->reservation);
                $this->consumereservation($request->idno);
                
            }
            
            
            $this->changestatatus($request->idno);
            
            $this->reset_or();
          
          
           return redirect(url('/viewreceipt',array($refno,$request->idno)));
          
           
            
            //return view("cashier.payment", compact('previous','idno','reservation','totaldue','totalother','totalprevious','totalpenalty'));
   }
   
   function changestatatus($idno){
   $status = \App\Status::where('idno',$idno)->first();    
       if(count($status)> 0 ){
           if($status->status == "1"){
               $status->status='2';
               $status->save();
           }
       }
   }
   
    function reset_or(){
        $resetor = \App\User::where('idno', \Auth::user()->idno)->first();
        $resetor->receiptno = $resetor->receiptno + 1;
        $resetor->reference_number = $resetor->reference_number + 1;
        $resetor->save();
    }
    
    function consumereservation($idno){
        $crs= \App\AdvancePayment::where('idno',$idno)->get();
        foreach($crs as $cr){
            $cr->status = "1";
            $cr->postedby = \Auth::user()->idno;
            $cr->save();
        }
    }
   
    function debit($idno, $paymenttype, $bank_branch, $check_number,$cashamount,$checkamount,$iscbc,$depositto){
        $student= \App\User::where('idno', $idno)->first();
        $debitaccount = new \App\Dedit;
        $debitaccount->idno = $idno;
        $debitaccount->transactiondate=Carbon::now();
        $debitaccount->refno=$this->getRefno();
        $debitaccount->receiptno = $this->getOR();
        $debitaccount->paymenttype = $paymenttype;
        $debitaccount->bank_branch = $bank_branch;
        $debitaccount->check_number = $check_number;
        $debitaccount->receivefrom = $student->lastname . ", " . $student->firstname . " " . $student->extensionname . " " .$student->middlename;
        $debitaccount->iscbc = $iscbc;
        $debitaccount->depositto = $depositto;
        $debitaccount->checkamount = $checkamount;
        $debitaccount->amount = $cashamount;    
        $debitaccount->postedby=\Auth::user()->idno;
        $debitaccount->save();
        
    }
   
    function debit_reservation_discount($idno,$debittype,$amount){
        $student = \App\User::where('idno',$idno)->first();
        $debitaccount = new \App\Dedit;
        $debitaccount->idno = $idno;
        $debitaccount->transactiondate=Carbon::now();
        $debitaccount->refno=$this->getRefno();
        $debitaccount->receiptno = $this->getOR();
        $debitaccount->paymenttype = $debittype;
        $debitaccount->receivefrom = $student->lastname . ", " . $student->firstname . " " . $student->extensionname . " " .$student->middlename;
        $debitaccount->amount = $amount;    
        $debitaccount->postedby=\Auth::user()->idno;
        $debitaccount->save();
        
    }
  
   function credit($idno, $idledger, $refno, $receiptno, $amount){
       $ledger = \App\Ledger::find($idledger);
       $newcredit = new \App\Credit;
       $newcredit->idno=$idno;
       $newcredit->transactiondate = Carbon::now();
       $newcredit->referenceid = $idledger;
       $newcredit->refno = $refno;
       $newcredit->receiptno=$receiptno;
       $newcredit->categoryswitch = $ledger->categoryswitch;
       $newcredit->acctcode = $ledger->acctcode;
       $newcredit->description = $ledger->description;
       $newcredit->receipt_details = $ledger->receipt_details;
       $newcredit->duedate=$ledger->duedate;
       $newcredit->amount=$amount;
       $newcredit->schoolyear=$ledger->schoolyear;
       $newcredit->period=$ledger->period;
       $newcredit->postedby=\Auth::user()->idno;
       $newcredit->save();
       
   } 
   
   function viewreceipt($refno, $idno){
       $student = \App\User::where('idno',$idno)->first();
       $status= \App\Status::where('idno',$idno)->first();
       $debits = \App\Dedit::where('refno',$refno)->get();
       $debit_discount = \App\Dedit::where('refno',$refno)->where('paymenttype','4')->first();
       $debit_reservation = \App\Dedit::where('refno',$refno)->where('paymenttype','5')->first();
       $debit_cash = \App\Dedit::where('refno',$refno)->where('paymenttype','1')->first();
       $debit_dm = \App\Dedit::where('refno',$refno)->where('paymenttype','3')->first();
       $credits = DB::Select("select sum(amount) as amount, receipt_details, transactiondate from credits "
               . "where refno = '$refno' group by receipt_details, transactiondate");
       $tdate = \App\Dedit::where('refno',$refno)->first();
       $posted = \App\User::where('idno',$tdate->postedby)->first();
       return view("cashier.viewreceipt",compact('posted','tdate','student','debits','credits','status','debit_discount','debit_reservation','debit_cash','debit_dm'));
       
   }
   
   
    function printreceipt($refno, $idno){
       $student = \App\User::where('idno',$idno)->first();
       $status= \App\Status::where('idno',$idno)->first();
       $debits = \App\Dedit::where('refno',$refno)->get();
       $debit_discount = \App\Dedit::where('refno',$refno)->where('paymenttype','4')->first();
       $debit_reservation = \App\Dedit::where('refno',$refno)->where('paymenttype','5')->first();
       $debit_cash = \App\Dedit::where('refno',$refno)->where('paymenttype','1')->first();
       $debit_check = \App\Dedit::where('refno',$refno)->where('paymenttype','2')->first();
       $debit_dm = \App\Dedit::where('refno',$refno)->where('paymenttype','3')->first();
       $credits = DB::Select("select sum(amount) as amount, receipt_details, transactiondate from credits "
               . "where refno = '$refno' group by receipt_details, transactiondate");
       $tdate = \App\Dedit::where('refno',$refno)->first();
       $posted = \App\User::where('idno',$tdate->postedby)->first();
       $pdf = \App::make('dompdf.wrapper');
       $pdf->setPaper([0, 0, 378, 450], 'portray');
       $pdf->loadView("cashier.printreceipt",compact('posted','tdate','student','debits','credits','status','debit_discount','debit_reservation','debit_cash','debit_dm'));
       return $pdf->stream();
        
    
}

function otherpayment($idno){
    $student =  \App\User::where('idno',$idno)->first();
    $status = \App\Status::where('idno',$idno)->first();
    $advances = \App\AdvancePayment::where("idno",$idno)->where("status",0)->get();
    $advance=0;
    if(count($advances)>0){    
        foreach($advances as $adv){
           $advance=$advance+$adv->amount;
        }
    }
    $accounttypes = DB::Select("select distinct accounttype from ctr_other_payments");
    
    return view('cashier.otherpayment',compact('student','status','accounttypes','advance'));
}

    function othercollection(Request $request){
        $or = $this->getOR();
        $refno = $this->getRefno();
        $student=  \App\User::where('idno',$request->idno)->first();
        if($request->reservation > 0 ){
            $newreservation = new \App\AdvancePayment;
            $newreservation->idno = $request->idno;
            $newreservation->transactiondate = Carbon::now();
            $newreservation->refno = $refno;
            $newreservation->amount = $request->reservation;
            $newreservation->postedby = \Auth::user()->idno;
            $newreservation->save();
            $creditreservation = new \App\Credit;
            $creditreservation->idno = $request->idno;
            $creditreservation->transactiondate = Carbon::now();
            $creditreservation->refno = $refno;
            $creditreservation->receiptno = $or;
            $creditreservation->categoryswitch = '9';
            $creditreservation->acctcode="Reservation";
            $creditreservation->description="Reservation";
            $creditreservation->receipt_details = "Reservation";
            $creditreservation->amount = $request->reservation;
            $creditreservation->postedby = \Auth::user()->idno;
            $creditreservation->save();     
        }
        
        if($request->amount1 > 0){
            $creditreservation = new \App\Credit;
            $creditreservation->idno = $request->idno;
            $creditreservation->transactiondate = Carbon::now();
            $creditreservation->refno = $refno;
            $creditreservation->receiptno = $or;
            $creditreservation->categoryswitch = '9';
            $creditreservation->acctcode=$request->groupaccount1;
            $creditreservation->description=$request->particular1;
            $creditreservation->receipt_details = $request->particular1;
            $creditreservation->amount = $request->amount1;
            $creditreservation->postedby = \Auth::user()->idno;
            $creditreservation->save(); 
            
        }
        
           if($request->amount2 > 0){
            $creditreservation = new \App\Credit;
            $creditreservation->idno = $request->idno;
            $creditreservation->transactiondate = Carbon::now();
            $creditreservation->refno = $refno;
            $creditreservation->receiptno = $or;
            $creditreservation->categoryswitch = '9';
            $creditreservation->acctcode=$request->groupaccount2;
            $creditreservation->description=$request->particular2;
            $creditreservation->receipt_details = $request->particular2;
            $creditreservation->amount = $request->amount2;
            $creditreservation->postedby = \Auth::user()->idno;
            $creditreservation->save(); 
            
        }
        
         if($request->amount3 > 0){
            $creditreservation = new \App\Credit;
            $creditreservation->idno = $request->idno;
            $creditreservation->transactiondate = Carbon::now();
            $creditreservation->refno = $refno;
            $creditreservation->receiptno = $or;
            $creditreservation->categoryswitch = '9';
            $creditreservation->acctcode=$request->groupaccount3;
            $creditreservation->description=$request->particular3;
            $creditreservation->receipt_details = $request->particular3;
            $creditreservation->amount = $request->amount3;
            $creditreservation->postedby = \Auth::user()->idno;
            $creditreservation->save(); 
            
        }
         if($request->amount4 > 0){
            $creditreservation = new \App\Credit;
            $creditreservation->idno = $request->idno;
            $creditreservation->transactiondate = Carbon::now();
            $creditreservation->refno = $refno;
            $creditreservation->receiptno = $or;
            $creditreservation->categoryswitch = '9';
            $creditreservation->acctcode=$request->groupaccount4;
            $creditreservation->description=$request->particular4;
            $creditreservation->receipt_details = $request->particular4;
            $creditreservation->amount = $request->amount4;
            $creditreservation->postedby = \Auth::user()->idno;
            $creditreservation->save(); 
            
        }
        
        //debit
        $iscbc = 0;
         if($request->iscbc =="cbc"){
                    $iscbc = 1;
                }
        $debit = new \App\Dedit;
        $debit->idno = $request->idno;
        $debit->transactiondate = Carbon::now();
        $debit->refno = $refno;
        $debit->receiptno = $or;
        $debit->paymenttype= "1";
        $debit->bank_branch=$request->bank_branch;
        $debit->check_number=$request->check_number;
        $debit->iscbc=$iscbc;
        $debit->amount = $request->cash;
        $debit->checkamount=$request->check;
        $debit->receivefrom=$student->lastname . ", " . $student->firstname . " " . $student->extensionname . " " .$student->middlename;
        $debit->depositto=$request->depositto;
        $debit->postedby= \Auth::user()->idno;
        $debit->save();
        
        $this->reset_or();
        
        return redirect(url('/viewreceipt',array($refno,$request->idno)));
    }
    
    function collectionreport(){
        $matchfields = ['postedby'=>\Auth::user()->idno, 'transactiondate'=>date('Y-m-d')];
        //$collections = \App\Dedit::where($matchfields)->get();
        $collections = DB::Select("select sum(dedits.amount) as amount, sum(dedits.checkamount) as checkamount, users.idno, users.lastname, users.firstname,"
                . " dedits.transactiondate, dedits.isreverse, dedits.receiptno, dedits.refno from users, dedits where users.idno = dedits.idno and"
                . " dedits.postedby = '".\Auth::user()->idno."' and dedits.transactiondate = '" 
                . date('Y-m-d') . "' and dedits.paymenttype = '1' group by users.idno, dedits.transactiondate, users.lastname, users.firstname, dedits.isreverse,dedits.receiptno,dedits.refno" );
        //$collections = \App\User::where('postedby',\Auth::user()->idno)->first()->dedits->where('transactiondate',date('Y-m-d'))->get();
        return view('cashier.collectionreport', compact('collections'));
    }
    function cancell($refno,$idno){
        
        $credits = \App\Credit::where('refno',$refno)->get();
        foreach($credits as $credit){
        $ledger = \App\Ledger::find($credit->referenceid);
        $ledger->payment = $ledger->payment - $credit->amount + $ledger->plandiscount + $ledger->otherdiscount;
        $ledger->save();
        }
        
        \App\Credit::where('refno',$refno)->update(['isreverse'=>'1','reversedate'=>  Carbon::now(), 'reverseby'=> \Auth::user()->idno]);
        \App\Dedit::where('refno',$refno)->update(['isreverse'=>'1']);
        
        return redirect(url('cashier',$idno));
    }
    
    function restore($refno,$idno){
        
        $credits = \App\Credit::where('refno',$refno)->get();
        foreach($credits as $credit){
        $ledger = \App\Ledger::find($credit->referenceid);
        $ledger->payment = $ledger->payment + $credit->amount - $ledger->plandiscount - $ledger->otherdiscount;
        $ledger->save();
        }
        
        \App\Credit::where('refno',$refno)->update(['isreverse'=>'0','reversedate'=>  '0000-00-00', 'reverseby'=> '']);
        \App\Dedit::where('refno',$refno)->update(['isreverse'=>'0']);
        
        return redirect(url('cashier',$idno));
    }
    
    function postencashment(Request $request){
        $refno = $this->getRefno();
        $encashment = new \App\Encashment;
        $encashment->transactiondate= Carbon::now();
        $encashment->refno = $refno;
        $encashment->payee = $request->payee;
        $encashment->whattype = $request->whattype;
        //$encashment->depositto = $request->depositto;
        $encashment->withdrawfrom =$request->withdrawfrom;
        $encashment->bank_branch=$request->bank_branch;
        $encashment->check_number=$request->check_number;
        $encashment->amount=$request->amount;
        $encashment->postedby = \Auth::user()->idno;
        $encashment->save();
        
        $resetor = \App\User::where('idno', \Auth::user()->idno)->first();
        $resetor->reference_number = $resetor->reference_number + 1;
        $resetor->save();
        
        return redirect(url('viewencashmentdetail',$encashment->refno));
        
        //return view('cashier.viewencashment',compact('encashment'));
        
    }
    
    function viewencashmentdetail($refno){
        $encashment = \App\Encashment::where('refno',$refno)->first();
        return view('cashier.viewencashment',compact('encashment'));
    }
    
    function encashment(){
        
        return view('cashier.encashment');
    }
    
    function encashmentreport(){
        $matchfields=['postedby'=>\Auth::user()->idno, 'transactiondate' => date('Y-m-d')];
        $encashmentreports = \App\Encashment::where($matchfields)->get();
        return view('cashier.viewencashmentreport',compact('encashmentreports'));
    }
    
    }