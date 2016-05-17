@extends('appcashier')
@section('content')
<div class="container">
@if(count($batches)==0)
<h5> No cut-off has been made...</h5>
<?php $totalactual=0;?>
@else
<h5>Cut-off Details</h5>
<table class="table table-striped">
    <tr><td></td><td colspan="3" align="center">China Bank</td><td colspan="3" align="center">BPI 1</td><td colspan="3" align="center">BPI 2</td><td>Variance</td><td></td></tr>
    <tr align="right"><td>Batch</td><td>Cash</td><td>Check</td><td>Encashment</td><td>Cash</td><td>Check</td><td>Encashment</td><td>Cash</td><td>Check</td><td>Encashment</td><td>Variance</td><td></tr>
    <?php 
    $totalactual = 0;
    ?>
    @foreach($batches as $batch)
    <?php $totalactual = $totalactual + $batch->cbccash + $batch->bpi1cash + $batch->bpi2cash;
          $totalactual = $totalactual + $batch->cbccheck + $batch->bpi1check + $batch->bpi2check;
          $totalactual = $totalactual + $batch->encashcbc + $batch->encashbpi1 + $batch->encashbpi2;
          $totalactual = $totalactual + $batch->variance;
    ?>
        <tr><td>{{$batch->batch}}</td>
        <td align="right">{{number_format($batch->cbccash,2)}}</td><td align="right">{{number_format($batch->cbccheck,2)}}</td><td align="right">{{number_format($batch->encashcbc,2)}}</td>
        <td align="right">{{number_format($batch->bpi1cash,2)}}</td><td align="right">{{number_format($batch->bpi1check,2)}}</td><td align="right">{{number_format($batch->encashbpi1,2)}}</td>
        <td align="right">{{number_format($batch->bpi2cash,2)}}</td><td align="right">{{number_format($batch->bpi2check,2)}}</td><td align="right">{{number_format($batch->encashbpi2,2)}}</td>
        <td align="right">{{number_format($batch->variance,2)}}</td><td align="right"><a href="{{url('actualcashcheck',array($batch->batch,$transactiondate))}}">View</a></td></tr>
    @endforeach
</table>
@endif
@if(count($encashments)==0)
<h5>No Encashment</h5>
@else
<table class="table table-striped">
    <tr><td>Bank</td><Amount></td></tr>
    @foreach($encashments as $encashment)
    <tr><td>{{$encashment->whattype}}</td><td align="right">{{number_format($encashment->amount,2)}}</td></tr>
    @endforeach
</table>
@endif

@if(count($debits)==0)
<h3> No more transactions to cut-off</h3>
@else
<h5>Remaining Transactions to cut-off</h5>
<table class="table table-striped"><tr><td>Bank</td><td>Cash</td><td>Check</td><td>Total</td></tr>
 @foreach($debits as $debit)
 <tr><td>{{$debit->depositto}}</td><td align="right">{{number_format($debit->amount,2)}}</td><td align="right">{{number_format($debit->checkamount,2)}}</td><td align="right">{{number_format($debit->checkamount + $debit->amount,2)}}</td></tr>
 @endforeach
 </table>
<a href="{{url('cutoff',$transactiondate)}}" class="btn btn-primary form-control">Cut-off Now</a>
@endif

<h5>Computed receipt vs. Actual Deposit</h5>
<table class="table table-responsive">
    <tr><td>Computed Receipt</td><td align="right">{{number_format($totaldebit,2)}}</td></tr>
    <tr><td>Actual Deposit</td><td align="right">{{number_format($totalactual ,2)}}</td></tr>
    <tr><td>Difference</td><td align="right">{{number_format($totaldebit - $totalactual ,2)}}</td></tr>
</table>    

</div>
@stop
