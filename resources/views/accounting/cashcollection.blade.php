@extends('appaccounting')
@section('content')
<div class="container">
    <h3>Don Bosco Technical Institute, Inc.</h3>
    <p>Collection report as of {{$transactiondate}}</p>
    <h5>Computed Receipt</h5>
    <table class="table table-striped">
        <tr><td>Posted By</td><td>Bank Account</td><td align="center">Cash Amount</td><td align="center">Check Amount</td><td align="center">Total</td></tr>
        <?php $totalamount = 0; $totalcheckamount="0";?>
        @foreach($computedreceipts as $computedreceipt)
        <?php $totalamount = $totalamount + $computedreceipt->amount;
        $totalcheckamount = $totalcheckamount + $computedreceipt->checkamount;?>
        <tr><td>{{$computedreceipt->postedby}}</td><td>{{$computedreceipt->depositto}}</td><td align="right">{{number_format($computedreceipt->amount,2)}}</td><td align="right">{{number_format($computedreceipt->checkamount,2)}}</td>
            <td align="right">{{number_format($computedreceipt->amount + $computedreceipt->checkamount,2)}}</td></tr>
        @endforeach
        <tr><td colspan="2">Total</td><td align="right">{{number_format($totalamount,2)}}</td><td align="right">{{number_format($totalcheckamount,2)}}</td>
            <td align="right">{{number_format($totalamount + $totalcheckamount,2)}}</td></tr>
    </table>
    <h5>Actual Deposit</h5>
    <table class="table table-striped">
    <tr><td>Posted By</td><td align="center">China Bank</td><td align="center">BPI 1</td><td align="center">BPI 2</td><td align="center">Total Deposit</td><td align="center">Variance</td></tr>
    <?php $totalcb=0;$totalbpi1=0;$totalbpi2=0;$totalvariance=0;?>
    @foreach($actualcashs as $actualcash)
    <?php 
    $totalcb=$totalcb+$actualcash->cbccash+$actualcash->cbccheck;
    $totalbpi1 = $totalbpi1+$actualcash->bpi1cash+$actualcash->bpi1check;
    $totalbpi2=$totalbpi2+$actualcash->bpi2cash+$actualcash->bpi2check;
    $totalvariance=$totalvariance+$actualcash->variance;
    ?>
    <tr><td>{{$actualcash->postedby}}</td><td align="right">{{number_format($actualcash->cbccash + $actualcash->cbccheck,2)}}</td>
        <td align="right">{{number_format($actualcash->bpi1cash + $actualcash->bpi1check,2)}}</td>
        <td align="right">{{number_format($actualcash->bpi2cash + $actualcash->bpi2check,2)}}</td>
    <td align="right">{{number_format($actualcash->cbccash + $actualcash->cbccheck+$actualcash->bpi1cash + $actualcash->bpi1check+$actualcash->bpi2cash + $actualcash->bpi2check,2)}}</td>
    <td align="right">{{number_format($actualcash->variance,2)}}</td></tr>
    @endforeach
    <tr><td>Total</td><td align="right">{{number_format($totalcb,2)}}</td><td align="right">{{number_format($totalbpi1,2)}}</td><td align="right">{{number_format($totalbpi2,2)}}</td><td align="right">{{number_format($totalcb+$totalbpi1+$totalbpi2,2)}}</td>
        <td align="right">{{number_format($totalvariance,2)}}</td></tr>
    </table>
    <h5>Encashment</h5>
    <table class="table table-striped"><tr><td>Posted By</td><td>Bank</td><td>Amount</td></tr>
        <?php $totalencash = 0;?>
        @foreach($encashments as $encashment)
        <tr><td>{{$encashment->postedby}}</td><td>{{$encashment->whattype}}</td><td align="right">{{$encashment->amount}}</td></tr>
        <?php $totalencash = $totalencash + $encashment->amount;?>
        @endforeach
        <tr><td colspan="2">Total</td><td align="right">{{number_format($totalencash,2)}}</td></tr>
    </table>    
    <h5>Difference</h5>
    <table><tr><td>Total Computed Receipt</td><td>{{number_format($totalamount + $totalcheckamount,2)}}</td></tr>
        </table>
</div>
@stop

