@extends('appcashier')
@section('content')

<div class="container">
<h5> Encashment </h5>
<table class="table table-striped"><tr><td>Payee</td><td>On-us</td><td>Bank</td><td>Check Number</td><td>Amount</td><td>Remarks</td><td></td></tr>
@foreach($encashmentreports as $encashmentreport)
<tr><td>{{$encashmentreport->payee}}</td>
    <td>{{$encashmentreport->whattype}}</td>
    <td>{{$encashmentreport->bank_branch}}</td>
    <td>{{$encashmentreport->check_number}}</td>
    <td>{{$encashmentreport->amount}}</td>
    <td>
    @if($encashmentreport->isreverse =="0")
    Ok
    @else
    Cancelled
    @endif
    </td>
    <td>
        view
    </td>
@endforeach
</table>
</div>

@stop
