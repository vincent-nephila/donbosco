@extends('appaccounting')
@section('content')
<style type="text/css">
    body{
        font-size: 10pt;
    }
    #header{
        display: none;
    }
    thead{
        display: table-header-group;
    }
    .breakpage{
        page-break-after: always;
        page-break-inside:avoid;
    }
    .breakable{
        page-break-inside:auto;
    }
    #receipt tr{
        display:block; 
        border-bottom: 1px solid;
        border-top: 1px solid;
    }
    
    .receipt{
        width:60px;
    }
    .name{
        width:150px;
    }
    .dcc{
        width:100px;
    }
    .ddiscount{
        width:80px;
    }
    .dreserve{
        width:80px;
    }
    .elearn{
        width:80px;
    }
    .misc{
        width:80px;
    }    
    .book{
        width:80px;
    }
    .dept{
        width:100px;
    }
    .reg{
        width:90px;
    }
    .tuition{
        width:80px;
    }
    .reserv{
        width:80px;
        
    }
    .others{
        width:80px;
    }
    .stat{
        width:80px;
        
    }
</style>
<style media="print">
    #header{
        display: block;
    }
    .btn,.text-muted{
        display: none;
    }
</style>
<div class="container-fluid">
    <div class="col-md-12" id="header"><h3>Don Bosco Technical School</h3></div>
    <span id="page1">
    <div class="col-md-12">
    <h4>Cash Receipt</h4>
    <h5>
        <dl class="dl-horizontal">
            <div>Forwrded Balance:&nbsp;&nbsp;&nbsp;
                <b>
                    {{number_format($forwardbal,2)}}
                </b>
                </div>
            </dl></h5>
    <p>As of {{$transactiondate}}</p>
    <table width="100%" id="receipt" style="border:none;">
        <thead>
        <tr><td class="receipt">Receipt Number</td>
            <td class="name">Name</td>
            <td class="dcc">Debit <br> Cash/Check</td>
            <td class="ddiscount">Debit <br>Discount</td>
            <td class="dreserve">Debit <br> Reservation</td>
            <td class="elearn">E-learning</td>
            <td class="misc">Misc</td>
            <td class="book">Books</td>
            <td class="dept">Department <br> Facilities</td>
            <td class="reg">Registration</td>
            <td class="tuition">Tuition</td>
            <td class="reserv">Reservation</td>
            <td class="others">Others</td>
            <td class="stat">Status</td>
            </tr>
        </thead>
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
            $index =count($allcollections)-1;
            $lastreceipt= $allcollections[$index][0];
            
            $tempcashtotal=0;
            $tempdiscount=0;
            $tempdebitreservation = 0;
            $tempelearning=0;
            $tempmisc=0;
            $tempbooks=0;
            $tempdepartmentfacilities = 0;       
            $tempregistration = 0;
            $temptuition = 0;
            $tempcreditreservation = 0;
            $tempother=0;
            
            $rows = 1;
            $firstpagerows = 1;
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
            
            
            $tempcashtotal = $tempcashtotal + $allcollection[2];
            $tempdebitreservation = $tempdebitreservation + $allcollection[3];
            $tempelearning = $tempelearning +$allcollection[4];
            $tempmisc = $tempmisc + $allcollection[5];
            $tempbooks = $tempbooks + $allcollection[6];
            $tempdepartmentfacilities = $tempdepartmentfacilities + $allcollection[7];
            $tempregistration = $tempregistration + $allcollection[8];
            $temptuition=$temptuition + $allcollection[9];
            $tempcreditreservation = $tempcreditreservation + $allcollection[10];
            $tempother=$tempother+$allcollection[11];
            $tempdiscount=$tempdiscount + $allcollection[13];            
            }
            ?>
            <tr><td class="receipt">{{$allcollection[0]}}</td>
            <td class="name">{{$allcollection[1]}}</td>
            <td class="dcc" align="right">{{number_format($allcollection[2],2)}}</td>
            <td class="ddiscount" align="right">{{number_format($allcollection[13],2)}}</td>
            <td class="dreserve" align="right">{{number_format($allcollection[3],2)}}</td>
            <td class="elearn" align="right">{{number_format($allcollection[4],2)}}</td>
            <td class="misc" align="right">{{number_format($allcollection[5],2)}}</td>
            <td class="book" align="right">{{number_format($allcollection[6],2)}}</td>
            <td class="dept" align="right">{{number_format($allcollection[7],2)}}</td>
            <td class="reg" align="right">{{number_format($allcollection[8],2)}}</td>
            <td class="tuition" align="right">{{number_format($allcollection[9],2)}}</td>
            <td class="reserv" align="right">{{number_format($allcollection[10],2)}}</td>
            <td class="others" align="right">{{number_format($allcollection[11],2)}}</td>
            <td class="stat" align="right">@if($allcollection[12]=="0")
                Ok  
                @else
                Cancelled
                @endif
                </td>
                </tr>
                
            @if($rows == 18 | $allcollection[0] == $lastreceipt | $firstpagerows == 10)
            <tr 
                @if($rows == 18 |$firstpagerows == 10)
                class="breakpage"
                @endif><td colspan="2" width="210px">Total</td>
            <td align="right" class="dcc">{{number_format($tempcashtotal,2)}}</td>
            <td align="right" class="ddiscount">{{number_format($tempdiscount,2)}}</td>
            <td align="right" class="dreserve">{{number_format($tempdebitreservation,2)}}</td>
            <td align="right" class="elearn">{{number_format($tempelearning,2)}}</td>
            <td align="right" class="misc">{{number_format($tempmisc,2)}}</td>
            <td align="right" class="book">{{number_format($tempbooks,2)}}</td>
            <td align="right" class="dept">{{number_format($tempdepartmentfacilities,2)}}</td>
            <td align="right" class="reg">{{number_format($tempregistration,2)}}</td>
            <td align="right" class="tuition">{{number_format($temptuition,2)}}</td>
            <td align="right" class="reserv">{{number_format($tempcreditreservation,2)}}</td>
            <td align="right" class="others">{{number_format($tempother,2)}}</td>
            <td class="stat">
                </td>
            <td></td>
                </tr>
                
               <?php
            $tempcashtotal=0;
            $tempdiscount=0;
            $tempdebitreservation = 0;
            $tempelearning=0;
            $tempmisc=0;
            $tempbooks=0;
            $tempdepartmentfacilities = 0;       
            $tempregistration = 0;
            $temptuition = 0;
            $tempcreditreservation = 0;
            $tempother=0;
               $rows = 0; ?>
            @endif
            <?php $rows++;
            
            $firstpagerows++;?>
            
            
             @endforeach   
             <tr style="border-bottom: none;border-top: none;"><td colspan="14"><br></td></tr>
                <tr style="border-bottom: none;border-top: none;"><td colspan="2" width="210px">Total</td>
            
            <td align="right" class="dcc">{{number_format($cashtotal,2)}}</td>
            <td align="right" class="ddiscount">{{number_format($discount,2)}}</td>
            <td align="right" class="dreserve">{{number_format($debitreservation,2)}}</td>
            <td align="right" class="elearn">{{number_format($elearning,2)}}</td>
            <td align="right" class="misc">{{number_format($misc,2)}}</td>
            <td align="right" class="book">{{number_format($books,2)}}</td>
            <td align="right" class="dept">{{number_format($departmentfacilities,2)}}</td>
            <td align="right" class="reg">{{number_format($registration,2)}}</td>
            <td align="right" class="tuition">{{number_format($tuition,2)}}</td>
            <td align="right" class="reserv">{{number_format($creditreservation,2)}}</td>
            <td align="right" class="others">{{number_format($other,2)}}</td>
            <td class="stat">
                </td>
            </tr>
            @endif
            </table>
            <br>
            <br>
            <div>Current Balance:&nbsp;&nbsp;<b>{{number_format($cashtotal+$forwardbal,2)}}</div>
            <br>
            <br>
            <br>
            <button class="btn btn-danger" onclick="changepage()">Next Page</button>
    </div>
    </span>
    <span id="page2">
    <div class="col-md-6" style="page-break-after: always">
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
                <tr><td>{{$othersummary->acctcode}}</td><td align="right">{{number_format($othersummary->amount,2)}}</td></tr>
                @endforeach
                <tr><td>Total</td><td align="right">{{number_format($totalsummary,2)}}</td></tr>
                @endif
        </table>        
    </div>  
        <div class="col-md-12">
        <button class="btn btn-danger" onclick="prevpage()">Previous Page</button>
        </div>
    </span>
    <br>
    <script>
        $("#page2").hide();
        
        function changepage(){
            $("#page2").fadeIn();
            $("#page1").fadeOut();
        }
        function prevpage(){
            $("#page1").fadeIn();
            $("#page2").fadeOut();
        }
    </script>
</div>    
@stop
