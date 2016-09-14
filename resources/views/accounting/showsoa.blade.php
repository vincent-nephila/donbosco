@extends('appcashier')
@section('content')
<style>
    @media print{
        a {visibility: hidden}
    }
</style>
<div class="container">
    <h5> Statement of Account</h5>
    <table class="table table-stripped">
                <tr><td>Grade/Level : {{$level}}</td><td>Section : {{$section}}</td><td>
            @if($strand != "none")
            Strand/Shop : {{$strand}}
            @endif
            </td> </tr>
   </table>             
    <table class="table table-stripped"><tr><td>Student No</td><td>Name</td><td>Plan</td><td>Balance</td><td></td></tr>
       @foreach($soasummary as $soa)
       @if($soa->amount > 0)
       <tr><td>{{$soa->idno}}</td><td>{{$soa->lastname}}, {{$soa->firstname}} {{$soa->middlename}}</td>
           <td>{{$soa->plan}}</td><td align="right">{{number_format($soa->amount,2)}}</td><td align="center">
               <a href="{{url('printsoa', array($soa->idno,$trandate))}}" >Print</a>
           </td></tr>
       @endif
       @endforeach
 </table>       
    <div class="col-md-6">
        <a href="{{url('printsoasummary',array($level,$strand,$section,$trandate,$plan,$amtover))}}" class="btn btn-primary">Print Summary</a>
    </div>    
</div>
@stop
