@extends('appaccounting')
@section('content')

<div class="container-fluid">
    <div class="col-md-12">
    <h5>Cash Receipt</h5>
    <p>As of {{$transactiondate}}</p>
    <table class="table table-striped">
        <tr><td>Receipt Number</td>
            <td>Name</td>
            <td>Debit <br> Cash/Check</td>
            <td>Debit <br>Discount</td>
            <td>Debit <br> Reservation</td>
            <td>E-learning</td>
            <td>Misc</td>
            <td>Books</td>
            <td>Department <br> Facilities</td>
            <td>Registration</td>
            <td>Tuition</td>
            <td>Reservation</td>
            <td>Others</td>
            <td>Status</td>
            </tr>
            @if(count($allcollections)>0)
            <?php 
            $cashtotal=0;
            $discount=0;
            $debitreservation = 0;
            $elearning=0;
            $misc=0;
            $books=0;
            $departmentfacilities = 0;       
            $registration = 0;
            $tuition = 0;
            $creditreservation = 0;
            $other=0;
            ?>
            @foreach($allcollections as $allcollection)
            <?php
            if($allcollection[12]=="0"){
            $cashtotal = $cashtotal + $allcollection[2];
            $debitreservation = $debitreservation + $allcollection[3];
            $elearning = $elearning +$allcollection[4];
            $misc = $misc + $allcollection[5];
            $books = $books + $allcollection[6];
            $departmentfacilities = $departmentfacilities + $allcollection[7];
            $registration = $registration + $allcollection[8];
            $tuition=$tuition + $allcollection[9];
            $creditreservation = $creditreservation + $allcollection[10];
            $other=$other+$allcollection[11];
            $discount=$discount + $allcollection[13];
            }
            ?>
            <tr><td>{{$allcollection[0]}}</td>
            <td>{{$allcollection[1]}}</td>
            <td align="right">{{number_format($allcollection[2],2)}}</td>
            <td align="right">{{number_format($allcollection[13],2)}}</td>
            <td align="right">{{number_format($allcollection[3],2)}}</td>
            <td align="right">{{number_format($allcollection[4],2)}}</td>
            <td align="right">{{number_format($allcollection[5],2)}}</td>
            <td align="right">{{number_format($allcollection[6],2)}}</td>
            <td align="right">{{number_format($allcollection[7],2)}}</td>
            <td align="right">{{number_format($allcollection[8],2)}}</td>
            <td align="right">{{number_format($allcollection[9],2)}}</td>
            <td align="right">{{number_format($allcollection[10],2)}}</td>
            <td align="right">{{number_format($allcollection[11],2)}}</td>
            <td>@if($allcollection[12]=="0")
                Ok {{$allcollection[2]+$allcollection[3]+$allcollection[13]-$allcollection[4]-$allcollection[5]-$allcollection[6]-$allcollection[7]-$allcollection[8]-$allcollection[9]-$allcollection[10]-$allcollection[11]}} 
                @else
                Cancelled
                @endif
                </td>
                </tr>
             @endforeach   
                <tr><td colspan="2">Total</td>
            
            <td align="right">{{number_format($cashtotal,2)}}</td>
            <td align="right">{{number_format($discount,2)}}</td>
            <td align="right">{{number_format($debitreservation,2)}}</td>
            <td align="right">{{number_format($elearning,2)}}</td>
            <td align="right">{{number_format($misc,2)}}</td>
            <td align="right">{{number_format($books,2)}}</td>
            <td align="right">{{number_format($departmentfacilities,2)}}</td>
            <td align="right">{{number_format($registration,2)}}</td>
            <td align="right">{{number_format($tuition,2)}}</td>
            <td align="right">{{number_format($creditreservation,2)}}</td>
            <td align="right">{{number_format($other,2)}}</td>
            <td>
                </td>
            </tr>
            @endif
            </table>
    </div>
    <div class="col-md-6">
    <h5>Other Accounts</h5>
    <table class="table table-striped">
        <tr><td>Receipt No</td><td><Name><td>Description</td><td>Amount</td><td>Status</td></tr>
        @if(count($otheraccounts) > 0 )
        <?php $othertotal = 0;?>
        @foreach($otheraccounts as $otheraccount)
        <?php
        if($otheraccount->isreverse == '0'){
          $othertotal = $othertotal + $otheraccount->amount;  
        }
        ?>
        <tr><td>{{$otheraccount->receiptno}}</td>
            <td>{{$otheraccount->lastname}}, {{$otheraccount->firstname}}</td>
            <td>{{$otheraccount->receipt_details}}</td>
            <td align="right">{{number_format($otheraccount->amount,2)}}</td>
            <td>@if($otheraccount->isreverse == "0")
                Ok
                @else
                Cancelled
                @endif
            </td>
            </tr>    
        @endforeach
        <tr><td colspan="3">Total</td><td align="right">{{number_format($othertotal,2)}}</td><td></td></tr>
        @endif
    </table>    
    </div>
    <div class="col-md-6">
        <h5>Other Account Summary</h5>
        <table class="table table-striped">
            <tr><td>Account Details</td><td>Amount</td>
                @if(count($othersummaries)>0)
                <?php
                $totalsummary=0.00;
                ?>
                @foreach($othersummaries as $othersummary)
                <?php
                $totalsummary = $totalsummary + $othersummary->amount;
                ?>
                <tr><td>{{$othersummary->receipt_details}}</td><td align="right">{{number_format($othersummary->amount,2)}}</td></tr>
                @endforeach
                <tr><td>Total</td><td align="right">{{number_format($totalsummary,2)}}</td></tr>
                @endif
        </table>        
    </div>    
</div>    
@stop
