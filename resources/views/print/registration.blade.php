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
    font-size: 9pt;
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
    height: 20px;
}

.notice{
    font-size: 8pt;
    padding:5px;
    border: 1px solid #000;
    text-indent: 10px;
    margin-top: 5px;
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
<img src = "{{ asset('/images/logo.png') }}" alt="Don Bosco Technical School" />
<h5 align="center">REGISTRATION/ASSESSMENT FORM</h5>
<table width='80%'>
<tr><td>Student Id</td><td> : </td><td>{{$user->idno}}</td></tr>
<tr><td>Name</td><td> : </td><td>{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</td></tr>
@if($status->department != "TVET")
    <tr><td>Level</td><td> : </td><td>{{$status->level}}</td></tr>
    @if($status->level == 'Grade 9' || $status->level == 'Grade 10')
    <tr><td>Specialization</td><td> : </td><td>{{$status->strand}}</td></tr>
    @endif
    @if($status->department=="Senior High School")
    <tr><td>Track</td><td> : </td><td>{{$status->track}}</td></tr>
    <tr><td>Strand</td><td> : </td><td>{{$status->strand}}</td></tr>
    @endif
@else
    <tr><td>Course</td><td> : </td><td>{{$status->course}}</td></tr>
@endif
</table>

<div class="body">  
   
   <div class="heading">Breakdown of Fees</div>
    <table> 
    <thead>
        <tr><th>Description</th><th>Amount</th></tr>
    </thead>    
    <tbody>
        <?php $totalamount=0; $totalplandiscount=0; $totalotherdiscount=0; ?>
        @foreach($breakdownfees as $breakdownfee)
        <tr><td>{{$breakdownfee->receipt_details}}</td><td align="right">{{number_format($breakdownfee->amount,2)}}</td></tr>
        <?php $totalamount = $totalamount + $breakdownfee->amount;
              $totalplandiscount = $totalplandiscount + $breakdownfee->plandiscount;
              $totalotherdiscount = $totalotherdiscount + $breakdownfee->otherdiscount;
              if(isset($reservation->amount)){
                  $reserve = $reservation->amount;
              }else{$reserve=0;}
              ?>
        @endforeach
        <tr><td>Sub Total</td><td align="right">{{number_format($totalamount,2)}}</td></tr>
        <tr><td>&nbsp;&nbsp;Less : Plan Discount</td><td align="right">({{number_format( $totalplandiscount,2)}})</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;Other Discount</td><td align="right">({{number_format( $totalotherdiscount,2)}})</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;Reservation</td><td align="right">({{number_format( $reserve,2)}})</td></tr>
        </tbody>
        <tfoot>
        <tr ><td class='footer'>Total</td><td class='footer' align="right">{{number_format($totalamount-$totalplandiscount-$totalotherdiscount-$reserve,2)}}</td></tr>
        </tfoot>
    </table>
      
     <div class="heading">Schedule of Payment</div>
     <table><thead><tr><th>Due Date</th><th>Amount</th></tr></thead>
         <tbody>
         @foreach($dues as $due)
         <tr>
         @if($due->duetype == '0')
         <td>
         Upon Enrollment
          </td><td align="right"><strong>{{number_format($due->amount - $due->plandiscount - $reserve - $due->otherdiscount,2)}}</strong></td></tr>
         @else
           <td>
         {{$due->duedate}}
        
          </td><td align="right">{{number_format($due->amount - $due->plandiscount  - $due->otherdiscount,2)}}</td></tr>
         @endif
            
         @endforeach
         </tbody>
     </table>    

      
</div>
<div class="notice">
    In accordance with the financial policies of the school as set out in the Student Dairy, the failure to meet the financial
    obligation to the school within the specified period may result in the withholding of transfer credentials, deprivation of any quarterly or final
    examinations, refusal of re-admission, dropping from the rolls and availment of other applicable remedies.
    <br><br>
    <i style="font-weight: bold">Failure to pay on the due date will be subjected to a penalty of 5% of the amount due or a minimum of P250.00 per month.</i>
</div>    