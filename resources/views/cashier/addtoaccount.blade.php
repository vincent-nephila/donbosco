@extends('appcashier')
@section('content')

<div class="container">
    
    
    <div class="col-md-6">
        <table class="table table-striped">
            <tr><td>Student No</td><td>{{$studentid}}</td></tr>
             <tr><td>Name</td><td>{{$studentdetails->lastname}}, {{$studentdetails->firstname}}</td></tr>
        </table>    
    <form method="POST" action="{{url('addtoaccount')}}">
        {!! csrf_field() !!} 
        <div class="form-group">
            <label>Account name</label>
            <input type="hidden" name='idno' value="{{$studentid}}">
            <select name="accttype" class="form form-control">
                @foreach($accounts as $account)
                <option = "{{$account->accountname}}">{{$account->accountname}}</option>
                @endforeach
            </select>    
        </div>
        <div class="form-group">
            <input type="text" class="form form-control" name="amount" onkeypress ="validate(event)" style="text-align: right">
        </div>    
         <div class="form-group">
            <input type="submit" class="form form-control btn btn-primary" name="submit" value="Add to account">
        </div> 
    </form>    
        <div class="form-group">
            <a href="{{url('cashier',$studentid)}}" class="btn btn-primary">Back To ledger</a>
        </div>    
        </div>
        <div class="col-md-6">
            <h5>Balance for Other Collections</h5>
            @if(count($ledgers)>0)
            <table class="table table-striped">
                <tr><td>Description</td><td>Amount</td><td></td></tr>
                @foreach($ledgers as $ledger)
                <tr><td>{{$ledger->receipt_details}}</td><td align="right">{{number_format($ledger->amount,2)}}</td><td><a href="{{url('addtoaccountdelete',$ledger->id)}}" >Delete</a></td></tr>
                @endforeach
            </table>    
            @endif
         </div>      
</div>
@stop

<script src="{{url('/js/nephilajs/cashier.js')}}"></script>  