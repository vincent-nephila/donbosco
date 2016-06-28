@extends('appaccounting')
@section('content')
<div class="container">
    <h5> Statement of Account</h5>
    <table class="table table-stripped">
                <tr><td>Grade/Level : {{$level}}</td><td>Section : {{$section}}</td><td>
            @if($strand != "none")
            Strand/Shop : {{$strand}}
            @endif
            </td>    
 <table class = "table table-stripped"><tr><td>Student No</td><td>Name</td><td>Balance</td><td></td></tr>
       @foreach($soasummary as $soa)
       @if($soa->amount > 0)
       <tr><td>{{$soa->idno}}</td><td>{{$soa->lastname}}, {{$soa->firstname}} {{$soa->middlename}}</td>
           <td align="right">{{number_format($soa->amount,2)}}</td><td>
               <a href="{{url('printsoa', array($soa->idno,$trandate))}}" >Print</a>
           </td></tr>
       @endif
       @endforeach
 </table>       
 </table>       
</div>
@stop
