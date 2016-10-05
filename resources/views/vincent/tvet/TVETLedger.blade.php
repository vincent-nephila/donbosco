@extends('app')
@section('content') 
<style type='text/css'>
    .form-control{
     text-align: center;
     border:none;
    }
</style>
<div class='container' onunload="save()">
    <div class='col-md-3'>
        
        <div><b><h4>{{$ledgers[0]->lastname}}, {{$ledgers[0]->firstname}} {{$ledgers[0]->middlename}} {{$ledgers[0]->extensionname}}</h4></b></div>
        <div>Course : {{$ledgers[0]->course}}</div>
        <div>Batch  : {{$ledgers[0]->batch}}</div>
        
    </div>
    <div class='col-md-9'>
        <table width='100%' cellpadding='10' cellspacing='10' border='1' style='text-align: center'>
            <thead style='text-align: center'><td>Total</td><td>Sponsor's Contribution</td><td>Subsidized</td><td>Trainee Contribution</td></thead>
        @foreach($ledgers as $ledger)
        <tr>
            <td>
            <div id="full">{{number_format($ledger->amount+$ledger->sponsor+$ledger->subsidy,2)}}</div>    
            </td>
            <td>
                <input class='form-control' type='text' onkeyup="changeSponsor(this.value,{{$idno}},{{$ledger->batch}})" id="sponsor" value ="{{$ledger->sponsor}}">
            </td>            
            <td>
                <input class='form-control' type='text' onkeyup="changeSubsidy(this.value,{{$idno}},{{$ledger->batch}})" id ="subsidy" value ="{{$ledger->subsidy}}">
                
            </td>
            <td style='text-align: center'>
                <input class='form-control' type='text' onkeyup="changeTotal(this.value,{{$idno}},{{$ledger->batch}})" id="total" value ="{{$ledger->amount}}">
            </td>            
       
        </tr>
        @endforeach
        </table>
        <hr>
        <div>Change Logs</div>
        
        <table width="100%" border="1" style='text-align: center'>
            <thead style='text-align: center'><td>Log Date</td><td>Total</td><td>Sponsor's Contribution</td><td>Subsidized</td><td>Trainee Contribution</td></thead>
            @foreach($records as $record)
            <tr>
                <td>{{$record->logdate}}</td><td>{{number_format($record->trainees+$record->sponsor+$record->subsidy,2)}}</td><td>{{$record->sponsor}}</td><td>{{$record->subsidy}}</td><td>{{$record->trainees}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
<script type='text/javascript'>
    var total = 0;
    
    $(window).on('beforeunload', function(){
        var trainee = $("#total").val();
        var subsidy = $("#subsidy").val();
        var sponsor = $("#sponsor").val();
        
        if(trainee != parseInt({{$ledger->amount}}) | subsidy != parseInt({{$ledger->subsidy}}) | sponsor != parseInt({{$ledger->sponsor}})){
        var arrays ={};
        arrays['students'] = {{$idno}};
        arrays['batch'] = {{$ledger->batch}};
        arrays['trainee'] = trainee;
        arrays['sponsor'] = sponsor;
        arrays['subsidy'] = subsidy;
        
        $.ajax({
            type: "GET", 
            url: "/saveLog",
            data:arrays,
            success:function(data){
                return data;
            }
        });    
    }
    
    });   
    
    function compute(){
        
        
        var amount  = parseFloat($("#total").val());
        var sponsor  = parseFloat($("#sponsor").val());
        var subsidy  = parseFloat($("#subsidy").val());
        
        
        total = amount+sponsor+subsidy;
        
        $('#full').html(total.toFixed(2));  
    } 

    function changeTotal(total,idno,batch){
        compute();
        var arrays ={};
        arrays['students'] = idno;
        arrays['batch'] = batch;
        
        $.ajax({
            type: "GET", 
            url: "/changeTotal/" +  total,
            data:arrays,
            success:function(data){}            
        });
        
    }
    

    
    function changeSponsor(total,idno,batch){
        compute();
        var arrays ={};
        arrays['students'] = idno;
        arrays['batch'] = batch;
        
        $.ajax({
            type: "GET", 
            url: "/changeSponsor/" +  total,
            data:arrays,
            success:function(data){}            
        });
        
        
    } 

    function changeSubsidy(total,idno,batch){
        
        var arrays ={};
        arrays['students'] = idno;
        arrays['batch'] = batch;
        
        $.ajax({
            type: "GET", 
            url: "/changeSubsidy/" +  total,
            data:arrays,
            success:function(data){}            
        });
        
        compute();
    }
    
    
</script>

@stop