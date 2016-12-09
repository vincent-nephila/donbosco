<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class JournalController extends \App\Http\Controllers\Cashier\CashierController
{

    function addEntry(){
        $coa = \App\ChartOfAccount::pluck('account')->toArray();
        $subsidy = \App\Subsidies::pluck('subsidy')->toArray();
        //return $subsidy;
        return view("vincent.accounting.addentry",compact('coa','subsidy'));
    }
    
    function saveEntry(Request $request){
        $refno = $this->getRefno();        
        $this->reset_ref();
        $debit = \App\ChartOfAccount::where('account',$request->debitcoa)->first();
        if(empty($debit)){
            $debitacct = $this->addAccount($request->debitcoa);
        }else{
            $debitacct = $debit->id;
        }
        
        $credit = \App\ChartOfAccount::where('account',$request->creditcoa)->first();
        if(empty($credit)){
            $creditacct = $this->addAccount($request->creditcoa);
        }else{
            $creditacct = $credit->id;
        }
        $index = 0;
        foreach($request->input('debit.subsidy') as $inputs){
           
            $subsidy = \App\Subsidies::where('subsidy',$inputs)->first();
            if(empty($subsidy)){
                $subsidy = $this->addSubsidy($inputs);
            }else{
                $subsidy = $subsidy->id;
            }            
            
            $newaccounting = new \App\Accounting;
            $newaccounting->refno = $refno;
            $newaccounting->transactiondate=Carbon::now();
            $newaccounting->accountcode = $debitacct;
            $newaccounting->subsidiary = $subsidy;
            $newaccounting->debit = $request->input('debit.amount.'.$index);
            $newaccounting->posted_by = \Auth::user()->idno;
            $newaccounting->cr_db_indic = 1;
            $newaccounting->save();
            $index ++;
        }
        $index =0;
        foreach($request->input('credit.subsidy') as $inputs){
           
            $subsidy = \App\Subsidies::where('subsidy',$inputs)->first();
            if(empty($subsidy)){
                $subsidy = $this->addSubsidy($inputs);
            }else{
                $subsidy = $subsidy->id;
            }            
            
            $newaccounting = new \App\Accounting;
            $newaccounting->refno = $refno;
            $newaccounting->transactiondate=Carbon::now();
            $newaccounting->accountcode = $debitacct;
            $newaccounting->subsidiary = $subsidy;
            $newaccounting->credit = $request->input('credit.amount.'.$index);
            $newaccounting->posted_by = \Auth::user()->idno;
            $newaccounting->cr_db_indic = 0;
            $newaccounting->save();
            $index ++;
        }        
        
        return $refno;
    }
    
    function addAccount($account){
        $coa = new \App\ChartOfAccount();
        $coa->account = $account;
        $coa->created_by = \Auth::user()->idno;
        $coa->save();
        
        return $coa->id;
    }
    
    function addSubsidy($account){
        $subsidy = new \App\Subsidies();
        $subsidy->subsidy = $account;
        $subsidy->created_by = \Auth::user()->idno;
        $subsidy->save();
        
        return $subsidy->id;
    }    
    
    
    function reset_ref(){
        $resetor = \App\User::where('idno', \Auth::user()->idno)->first();
        $resetor->reference_number = $resetor->reference_number + 1;
        $resetor->save();
    }    
}
