<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta author="Roy Plomantes">
        <meta poweredby = "Nephila Web Technology, Inc">
       
        
 <style>
    .body table, th  , .body td{
    border: 1px solid black;
    font-size: 10pt;
}

td{
    padding-right: 10px;
    padding-left: 10px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th {
    height: 15px;
}

.notice{
    font-size: 10pt;
    padding:5px;
    border: 1px solid #000;
    text-indent: 10px;
    margin-top: 5px;
}
.footer{
  padding-top:10px;
    
}
.heading{
    padding-top: 10px;
    font-size: 10pt;
    font-weight: bold;
}
        </style>
	<!-- Fonts -->
	
        </head>
<body> 
    <table border = '0' cellpacing="0" cellpadding = "0" width="100%" align="center">
        <tr><td rowspan="3" width="50">
        <img src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/images/logo.png" width="60">
        </td><td width="70%"><span style="font-size:12pt; font-weight: bold">Don Bosco Technical Institute of Makati, Inc. </span></td><td align="right"><span style="font-size:14pt; font-style:italic; font-weight: bold;">STATEMENT OF ACCOUNT</span></td></tr>
        <tr><td style="font-size:10pt;">Chino Roces Ave., Makati City </td><td align="right">Date : {{date('M d, Y')}}</td></tr>
        <tr><td style="font-size:10pt;">Tel No : 892-01-01</td><td align="right">Plan : {{$statuses->plan}}</td></tr>
    </table>
    
    
<table><tr><td width="70%" valign="top">
            <table style="font-size:10pt">
       <tr><td width="30%">Student No :</td><td>{{$users->idno}}</td></tr>  
       <tr><td>Name :</td><td>{{$users->lastname}}, {{$users->firstname}} {{$users->middlename}}</td></tr>
       @if(count($statuses)>0)
       <tr><td>Level/Section :</td><td> {{$statuses->level}} - {{$statuses->section}}</td></tr>
      
           @if($statuses->level == "Grade 9" || $statuses->level == "Grade 10" || $statuses->level == "Grade 11" || $statuses->level == "Grade 12" )
            <tr><td>
           Strand/Shop : <td>{{$statuses->strand}}</td>
            </td> </tr>         
           @endif
       
       @endif
    </table>
            
    <span style="font-size: 9pt;font-weight: bold"><u>ACCOUNT DETAILS</u></span>     
   <table style="font-size: 8pt;"><tr><td>Account Description</td><td>Amount</td><td>Less: Discount</td><td>Payment</td><td>DM</td><td>Balance</td></tr>
       <?php
       $totamount = 0; $totdiscount=0; $totdm=0; $totpayment=0;
       ?>
       @foreach($balances as $balance)
       <?php
       $totamount = $totamount + $balance->amount;
       $totdiscount = $totdiscount + $balance->discount;
       $totdm = $totdm + $balance->debitmemo;
       $totpayment = $totpayment+$balance->payment;
       ?>
       @if($balance->categoryswitch <= 6)
       <tr><td>{{$balance->receipt_details}}</td><td align="right">{{number_format($balance->amount,2)}}</td>
           <td align="right">{{number_format($balance->discount,2)}}</td><td align="right">{{number_format($balance->payment,2)}}</td>
           <td align="right">{{number_format($balance->debitmemo,2)}}</td><td align="right">{{number_format($balance->amount-$balance->discount-$balance->payment-$balance->debitmemo,2)}}</td></tr>
       @endif
       @endforeach
       <tr style="font-weight:bold"><td>Total</td><td align="right">{{number_format($totamount,2)}}</td>
           <td align="right">{{number_format($totdiscount,2)}}</td><td align="right">{{number_format($totpayment,2)}}</td>
           <td align="right">{{number_format($totdm,2)}}</td><td align="right">{{number_format($totamount-$totdiscount-$totpayment-$totdm,2)}}</td></tr>
       
  </table>     
   
        
</td><td valign="top">
    <h5></h5>
    <table style="font-size:8pt;border:thin" border="1" cellpadding="1" cellspacing='0'>
    <tr><td>Total Amount</td><td align="right">{{number_format($totamount + $otherbalance,2)}}</tr>
    <tr><td>Less : Discount</td><td align="right">({{number_format($totdiscount,2)}})</tr>
    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Debit Memo</td><td align="right">({{number_format($totdm,2)}})</tr>
    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment</td><td align="right">({{number_format($totpayment,2)}})</tr>
    <tr><td>Total Balance</td><td align="right">{{number_format($totamount-$totdiscount-$totdm-$totpayment,2)}}</tr>
    <tr style="font-size:9pt;font-weight:bold"><td>Due Date</td><td align="right">{{date('M d, Y',strtotime($trandate))}}</tr>
    <tr style="font-size:9pt;font-weight:bold"><td>Total Due</td><td align="right">{{number_format($totaldue,2)}}</tr>
    </table>
    <br>
  
 @if(count($schedules)>0)
 <span style="font-size:8pt;font-style: italic">Installment Schedule</span>
 <table style="font-size: 8pt;"><tr><td>For the month of</td><td align="center">Due Amount</td>
      @foreach($schedules as $schedule)
      @if($schedule->amount-$schedule->discount-$schedule->debitmemo-$schedule->payment > 0)
      <tr><td>@if(date('M',strtotime($schedule->duedate))=="Apr")
              Upon Enrollment
              @else
              {{date('M  Y',strtotime($schedule->duedate))}}
              @endif
          </td><td align="right">{{number_format($schedule->amount-$schedule->discount-$schedule->debitmemo-$schedule->payment,2)}}</td></tr>
      @endif
      @endforeach
 </table>
 @endif
 @if(count($others)>0)
        <span style="font-size:8pt;font-style: italic">Other Payment</span>
        <table style="font-size:8pt;width: 100%"><tr><td>Description</td><td align="center">Due Amount</td></tr>
                <?php
                $to=0;
                ?>
        @foreach($others as $other)
        <?php
        $to = $to + $other->balance;
        ?>
        <tr><td>{{$other->receipt_details}}</td><td align="right">{{number_format($other->balance,2)}}</td></tr>
        @endforeach
        <tr><td>Total</td><td align="right"><?php echo number_format($to,2);?></td></tr>
        </table>
 @endif
</td>
</table>
    <table><tr><td width="70%">
    <p style="font-size: 8pt;"><b>Reminder:</b><br>Please disregard this statement if payment has been made. Last day of payment is <b>{{date('M d, Y',strtotime($trandate))}}</b>. Payments made after due date is subject 
        to penalty of 5% or P250.00 whichever is higher. ADMINISTRATION</P>
    </td>
    <td><img src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/images/frbocsignature.png" height="80" style="position:absolute;margin-left:20"><br><br>
        <p align="center; font-size:9pt;">Fr. Manuel H. Nicholas, SDB<br>
            Administrator</p>
    </tr>
    </table>
</body>
</html>
