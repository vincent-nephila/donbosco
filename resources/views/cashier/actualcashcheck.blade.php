@extends('appcashier')
@section('content')
<div class='container'>
    <div class="col-md-2">
        </div>
    <div class="col-md-8">
    <h5>Collection Summary as of {{date( 'M d, Y',strtotime($transactiondate))}}</h5>    
    <table class="table table-striped">
        <tr><td>Deposit Bank</td><td  align="right" colspan="2" >Check Amount </td><td  align="right">Cash Amount</td><td  align="right">Total</td></tr>
    <?php
    $cashtotal = 0; $check1total=0; 
    ?>
    @if(count($chinabank)>0)
    @foreach($chinabank as $cb)
    <tr><td>China Bank</td><td align="right">{{$cb->checkamount}}</td><td><input type="text" name = "cbccheck" class="form form-control"></td><td  align="right">{{$cb->amount}}</td><td  align="right">{{$cb->amount+$cb->checkamount}}</td></tr>
    <?php
    $cashtotal=$cashtotal + $cb->amount;
    $check1total=$check1total + $cb->checkamount;        
    ?>
    @endforeach
    @else
    <tr><td>China Bank</td><td>0.00</td><td>0.00</td><td>0.00</td></tr>
    @endif
    @if(count($bpi1)>0)
    @foreach($bpi1 as $cb)
    <tr><td>BPI 1</td><td  align="right">{{$cb->checkamount}}</td><td  align="right">{{$cb->amount}}</td><td><input type="text" name = "bpi1check" class="form form-control"></td><td  align="right">{{$cb->amount+$cb->checkamount}}</td></tr>
    <?php
    $cashtotal=$cashtotal + $cb->amount;
    $check1total=$check1total + $cb->checkamount;        
    ?>
    @endforeach
    @else
    <tr><td>BPI 1</td><td>0.00</td><td>0.00</td><td>0.00</td></tr>
    @endif
    @if(count($bpi1)>0)
    @foreach($bpi2 as $cb)
    <tr><td>BPI 2</td><td  align="right">{{$cb->checkamount}}</td><td  align="right">{{$cb->amount}}</td><td><input type="text" name = "bpi2check" class="form form-control"></td><td  align="right">{{$cb->amount+$cb->checkamount}}</td></tr>
    <?php
    $cashtotal=$cashtotal + $cb->amount;
    $check1total=$check1total + $cb->checkamount;        
    ?>
    @endforeach
    @else
    <tr><td>BPI 2</td><td>0.00</td><td>0.00</td><td>0.00</td></tr>
    @endif
    <tr><td>Total</td><td align="right"><?php echo number_format($check1total,2);?></td><td align="right"><?php echo number_format($cashtotal,2);?></td><td align="right"><?php echo number_format($cashtotal+$check1total,2);?></td></tr>
    </table>
    </div>
    <div class="col-md-2">
      </div> 
    <div class="col-md-2">
     </div>
    <div class="col-md-6">
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
    <div class="col-md-8">
        </div>
</div>

@stop
