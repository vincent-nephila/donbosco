<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class TvetController extends Controller
{
    function adjustLedger($idno){
        $schoolyear = \App\CtrRefSchoolyear::first();
        $ledgers = DB::Select("select amount,sponsor,subsidy,lastname,firstname,middlename,extensionname,tvet_subsidies.batch,course "
                . "from ledgers "
                . "join users on users.idno = ledgers.idno "
                . "join tvet_subsidies on ledgers.idno = tvet_subsidies.idno "
                . "and ledgers.period = tvet_subsidies.batch "
                . "where users.idno = '$idno' "
                . "and ledgers.schoolyear = '$schoolyear->schoolyear'");
        $records = \App\TvetRecordChange::where('batch',$ledgers[0]->batch)->where('idno',$idno)->get();
        return view('vincent.tvet.TVETLedger',compact('ledgers','idno','records'));
        
    }
}
