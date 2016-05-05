@extends('appaccounting')
@section('content')

<div class="container">
    <h5>Credit</h5>
    <table class="table table-striped">
        <tr><td>Account Name</td><td>Amount</td></tr>
        <?php $totalcredit=0;?>
        @foreach($credits as $credit)
        <?php $totalcredit = $totalcredit + $credit->amount;?>
        <tr><td>{{$credit->receipt_details}}</td><td align="right">{{number_format($credit->amount,2)}}</td></tr>
        @endforeach
        <tr><td><b>Total Credit</b></td><td align="right"><b>{{number_format($totalcredit,2)}}</b></td></tr>
     </table>   
</div>
<div class="container">
<h5>Debit</h5>
    <table class="table table-striped">
    <tr><td>Partcular</td><td align="right">Amount</td></tr>
    <?php $totaldebits=0;?>    
    @if(count($debitcashchecks)>0)
    @foreach($debitcashchecks as $debitcashcheck)
    <?php $totaldebits = $totaldebits + $debitcashcheck->totalamount;?>
    <tr><td>{{$debitcashcheck->depositto}}</td><td align="right">{{number_format($debitcashcheck->totalamount,2)}}</td></tr>
    @endforeach    
    @endif
    @if(count($debitdebitmemos)>0)
    @foreach($debitdebitmemos as $debitmemo)
    <?php $totaldebits = $totaldebits + $debitmemo->totalamount;?>
    <tr><td>{{$debitmemo->acctcode}}</td><td align="right">{{number_format($debitmemo->totalamount,2)}}</td></tr>
    @endforeach    
    @endif
    @if(count($debitdiscounts)>0)
    @foreach($debitdiscounts as $debitdiscount)
    <?php $totaldebits = $totaldebits + $debitdiscount->totalamount;?>
    <tr><td>Discount</td><td align="right">{{number_format($debitdiscount->totalamount,2)}}</td></tr>
    @endforeach    
    @endif
    @if(count($debitreservations)>0)
    @foreach($debitreservations as $debitreservation)
    <?php $totaldebits = $totaldebits + $debitreservation->totalamount;?>
    <tr><td>Reservation</td><td align="right">{{number_format($debitreservation->totalamount,2)}}</td></tr>
    @endforeach    
    @endif
   <tr><td>Total</td><td align="right">{{number_format($totaldebits,2)}}</td></tr> 
</table>
</div>

@stop

