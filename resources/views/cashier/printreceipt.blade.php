
</head>
<style>
@page { margin: 0px; }
body { margin: 0px; }
</style>
    
<div style="margin-left: 20px ;font-size: 10pt; width: 311">
       
       
           <table width="311" cellpadding = "0" cellspacing = "0" border = "0">
           <tr><td colspan="2" height="85"  valign="top"></td></tr>
           <tr><td><div style="margin-left: 110px">{{$student->idno}} - {{$student->lastname}}, {{$student->firstname}} {{$student->extensionname}} {{$student->midddlename}}</div></td><td height="20" valign="top"></td></tr>
           @if(isset($status->level))
           <tr><td><div style="margin-left: 100px">{{$status->level}} {{$status->strand}} {{$status->section}}</div></td><td>{{$tdate->transactiondate}}</td></tr>
           @else
           <tr><td><div style="margin-left: 100px"></div></td><td>{{$tdate->transactiondate}}</td></tr>
           @endif
           <tr><td colspan="2" height="28"></td></tr>
            
           <tr><td colspan="2" height="215"  valign="top" style="padding-left:20px">
           <table width="280" cellpadding = "0" cellspacing = "0" border="0">        
           @foreach($credits as $credit)
           <tr><td>{{$credit->receipt_details}}</td><td align="right">{{number_format($credit->amount,2)}}</td></tr>
           @endforeach
           
           @if(count($debit_discount)>0)
            <tr><td>Less Discount</td><td align="right">({{number_format($debit_discount->amount,2)}})</td></tr>
           @endif
           
            @if(count($debit_reservation)>0)
            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Less Reservation</td><td align="right">({{number_format($debit_reservation->amount,2)}})</td></tr>
           @endif
            
            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td><td align="right"><b>{{number_format($debit_cash->amount + $debit_cash->checkamount,2)}}</b></td></tr>
          
           
           </table>
               </td></tr>
           @if(isset($status->status))
                @if($status->status=='2')
                <tr><td colspan="2" style="padding-left:20px">Status : Enrolled</td></tr>
                @endif
                @endif
                       </table>
                 
           <table width = "100%" border="0"> 
           
            <tr><td colspan="2"><span style="margin-left: 70px">{{$debit_cash->bank_branch}}</span></td></tr>
            <tr><td><span style="margin-left: 80px">{{$debit_cash->check_number}} - {{$debit_cash->checkamount}}</span></td><td align="right">{{$posted->firstname}} {{$posted->lastname}}</td></tr>
            
           
              
            </table>
            
     
    </div>    
 

