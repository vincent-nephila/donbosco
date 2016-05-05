@extends('appcashier')
@section('content')
<div class='container_fluid'>
    <div class="col-md-2">
        </div>
    <div class="col-md-8">
    <h5>Collection Summary as of {{date( 'M d, Y',strtotime($transactiondate))}}</h5>    
    <form method="POST" action="{{url('postactual')}}">
    {!! csrf_field() !!}   
    <input type="hidden" name="action1" value="{{$action}}">
    <input type="hidden" name="transactiondate" value="{{$transactiondate}}">
    <input type="hidden" name="totalissued" value="{{$totalissued}}">
    <table class="table table-striped">
        <?php
       
        $acbccash = 0;
        $acbccheck = 0;
        $abpi1cash = 0;
        $abpi1check = 0;
        $abpi2cash=0;
        $abpi2check=0;
        $variance = 0;
        $txtbutton="Submit Actual Collection";
        if(count($actual)>0){
        $acbccash = $actual->cbccash;
        $acbccheck = $actual->cbccheck;
        $abpi1cash = $actual->bpi1cash;
        $abpi1check = $actual->bpi1check;
        $abpi2cash=$actual->bpi2cash;
        $abpi2check=$actual->bpi2check;
        $variance = $actual->variance;
        $txtbutton="Update Actual Collection";
        }
        
        ?>
        
    <tr><td>Payment Type</td><td>Amount</td><td>Encashment</td><td>Actual</td><td>Difference</td></tr>    
    <tr><td colspan="5" style="color:red;background-color: #ccc">China Bank</td></tr>
    <tr><td>Cash</td><td align="right">{{number_format($cbcash,2)}}</td><td align="right">{{number_format($encashcbc,2)}}</td><td><input type="text" name="actualcbccash" id="actutalcbccash" class="form" style="text-align:right" value="{{$acbccash}}"></td><td>{{number_format(($cbcash- $encashcbc - $acbccash),2)}}</td></tr>
    <tr><td>Check</td><td align="right">{{number_format($cbcheck,2)}}</td><td></td><td><input type="text" name="actualcbccheck" id="actutalcbccheck" class="form" style="text-align:right" value="<?php echo $acbccheck; ?>"></td><td>{{number_format(($cbcheck - $acbccheck),2)}}</td></tr>
    <tr><td colspan="5" style="color:red;background-color: #ccc">BPI 1</td></tr>
    <tr><td>Cash</td><td align="right">{{number_format($bpi1cash,2)}}</td><td align="right">{{number_format($encashbpi1,2)}}</td><td><input type="text" name="actualbpi1cash" id="actutalbpi1cash" class="form" style="text-align:right" value="<?php echo $abpi1cash; ?>"></td><td>{{number_format(($bpi1cash- $encashbpi1 - $abpi1cash),2)}}</td></tr>
    <tr><td>Check</td><td align="right">{{number_format($bpi1check,2)}}</td><td></td><td><input type="text" name="actualbpi1check" id="actutalbpi1check" class="form" style="text-align:right" value="<?php echo $abpi1check; ?>"></td><td>{{number_format(($bpi1check - $abpi1check),2)}}</td></tr>
    <tr><td colspan="5" style="color:red;background-color: #ccc">BPI 2</td></tr>
    <tr><td>Cash</td><td align="right">{{number_format($bpi2cash,2)}}</td><td align="right">{{number_format($encashbpi2,2)}}</td><td><input type="text" name="actualbpi2cash" id="actutalbpi2cash" class="form" style="text-align:right" value="<?php echo $abpi2cash; ?>"></td><td>{{number_format(($bpi2cash- $encashbpi2 - $abpi2cash),2)}}</td></tr>
    <tr><td>Check</td><td align="right">{{number_format($bpi2check,2)}}</td><td></td><td><input type="text" name="actualbpi2check" id="actutalbpi2check" class="form" style="text-align:right" value="<?php echo $abpi2check; ?>"></td><td>{{number_format(($bpi2check - $abpi2check),2)}}</td></tr>
    <tr><td>Check</td><td align="right"></td><td></td><td><a href="{{url('printactualcash',$transactiondate)}}" class="btn btn-primary">Print Actual Deposit</a></td><td><input type="submit" name="submit"  class="btn btn-primary" value="{{$txtbutton}}" ></td></tr>
    </table>
    </form>
    <!--
   
    <h5>Encashment Summary</h5>
    <table class="table table-striped">
        <tr><td>Withdraw From</td><td>Amount</td></tr>
         <?php $etotal=0;
        ?>
        @if(count($encashments)>0)
       
            @foreach($encashments as $encashment)
                <tr><td>{{$encashment->withdrawfrom}}</td><td>{{$encashment->amount}}</td></tr>
                <?php $etotal = $etotal + $encashment->amount;
                ?>
            @endforeach
        @endif
        <tr><td>Total</td><td><?php echo number_format($etotal,2); ?></td></tr>
    </table>    
    </div>
    -->
</div>

@stop
