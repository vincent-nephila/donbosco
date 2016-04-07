@extends('appcashier')

@section('content')
<div class="container">
    <div class="col-md-3">
    </div>    
    <div class="col-md-6">
       
       <h4 align="center"> DON BOSCO TECHNICAL INSTITUTE of MAKATI, INC</h4>
       <p align='center'>Chino Roces Avenue, City of Makati <br />
           Tel No. 892-01-01 to 10<br />
           TIN 000-450-347-000 NAN VAT</p>
       <h3 align="center">OFFICIAL RECEIPT</h3>
       <table class = "table table-responsive">
           <tr><td>Received From : {{$student->lastname}}, {{$student->firstname}} {{$student->extensionname}} {{$student->midddlename}}</td><td></td></tr>
         
           @if(isset($status->level))
           <tr><td>Grade/Sec : {{$status->level}} {{$status->strand}} {{$status->section}}</td><td>Date : {{$tdate->transactiondate}}</td></tr>
           @endif
           <tr><td colspan="2"   valign="top">
           <table width="100%">        
           @foreach($credits as $credit)
           <tr><td>{{$credit->receipt_details}}</td><td align="right">{{number_format($credit->amount,2)}}</td></tr>
           @endforeach
           @if(count($debit_discount)>0)
            <tr><td>Less Discount</td><td align="right">({{number_format($debit_discount->amount,2)}})</td></tr>
           @endif
            @if(count($debit_reservation)>0)
            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Less Reservation</td><td align="right">({{number_format($debit_reservation->amount,2)}})</td></tr>
           @endif
           
            @if(count($debit_cash)>0)
            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td><td align="right"><b>{{number_format($debit_cash->amount + $debit_cash->checkamount ,2)}}</b></td></tr>
           @endif
           
           </table>
           </td></tr> 
           
            <tr><td colspan="2">Bank : {{$debit_cash->bank_branch}}</td></tr>
            <tr><td colspan="2">Check No : {{$debit_cash->check_number}}</td></tr>
            <tr><td colspan="2">Check Amount : {{$debit_cash->checkamount}}</td></tr>
           
            <tr><td colspan="2"><hr /></td></tr>
            <tr><td colspan="2"><span style="font-size: 18pt;font-weight: bold; color: red">NO. {{$tdate->receiptno}}</span></td></tr>
            <tr><td></td><td>Received By</td></tr>
            <tr><td></td><td><b>{{$posted->firstname}} {{$posted->lastname}}</b></td></tr>
            <tr><td></td><td>&nbsp;&nbsp;&nbsp;Cashier</td></tr>
       </table>
             <a href="{{url('/cashier',$student->idno)}}" class="btn btn-primary">See Ledger</a>
             <a href="{{url('/printreceipt',array($tdate->refno,$student->idno))}}" class="btn btn-primary">Print Receipt</a>
             @if($tdate->transactiondate == date('Y-m-d') && Auth::user()->idno == $posted->idno)
                @if($tdate->isreverse == '0')
                <a href="{{url('/cancell',array($tdate->refno,$student->idno))}}" class="btn btn-danger pull-right" onclick="return confirm('Are you sure?')">Cancel</a>
                @else
                <a href="{{url('/restore',array($tdate->refno,$student->idno))}}" class="btn btn-danger pull-right" onclick="return confirm('Are you sure?')">Restore</a>
                @endif
              @endif
    </div>    
    </div>

</div>
@stop
