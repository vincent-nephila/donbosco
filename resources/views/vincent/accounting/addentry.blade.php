@extends('appaccounting')
@section('content')
<style>
    .form-control{
        border-radius: 0px;
        margin-bottom: 2px;
        margin-top: 2px;
    }
</style>
  <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet">
  <script src="{{asset('/js/jquery-ui.js')}}"></script>
  <script>
        $( function() {
    var coa = [<?php echo '"'.implode('","', $coa).'"' ?>];
    $( ".coa" ).autocomplete({
      source: coa
    });
    
    var subsidy = [<?php echo '"'.implode('","', $subsidy).'"' ?>];
    $( ".sub" ).autocomplete({
      source: subsidy
    });    
  } );
  
  </script>
<div class="container-fluid">
    <div style="margin-left:auto;margin-right: auto;width:80%">
        <form id="form" onsubmit="return sub();" method="POST" action="{{url('/addentry')}}" >
            {!! csrf_field() !!} 
            <div class="col-md-6" style="border-right: 1px solid">
                    <table width="100%">
                        <thead style="text-align: center;">
                        <tr>
                            <td colspan="3"><b>Debit</b></td>
                        </tr>
                        <tr style="visibility: hidden">
                            <td>General Account</td>
                            <td>Subsidies</td>
                            <td>Amount</td>
                        </tr>
                    </thead>
                    <tbody class="controls">
                        <tr>
                            <td colspan="3" style="vertical-align: top;"><input type="text" class="form-control coa" id="debitcoa" name="debitcoa" style="width: 50%;"></td>
                        </tr>
                        <tr class="entry">
                            <td>
                                    <div><button id="b1" class="btn btn-success btn-add" type="button">+</button></div>                          
                            </td>
                            <td>
                                <input type="text" class="form-control sub" name="debit[subsidy][]">
                            </td>
                            <td >
                                <input type="text" class="form-control debitamount" name="debit[amount][]" style="width:80%;float:right;" onkeyup="addDebit()" placeholder="Amount">
                            </td>
                        </tr>
                    </tbody>  
                    <tbody>
                        <tr>
                            <td>Total Amount</td><td></td><td><input type="text" class="form-control" name="debittotal" id="debittotal" style="width:80%;float:right;text-align: right" disabled="true"></td>
                        </tr>
                    </tbody>                
                </table>            
            </div>
            <div class="col-md-6">

                <table width="100%">
                        <thead style="text-align: center;">
                        <tr>
                            <td colspan="3"><b>Credit</b></td>
                        </tr>
                        <tr style="visibility: hidden">
                            <td>General Account</td>
                            <td>Subsidies</td>
                            <td>Amount</td>
                        </tr>
                    </thead>
                    <tbody class="controls">
                        <tr>
                            <td colspan="3" style="vertical-align: top;"><input type="text" class="form-control coa" name="creditcoa" style="width: 50%;"></td>
                        </tr>
                        <tr class="entry">
                            <td>
                                    <div><button class="btn btn-success btn-add" type="button">+</button></div>                          
                            </td>
                            <td>
                                <input type="text" class="form-control sub" name="credit[subsidy][]">
                            </td>
                            <td >
                                <input type="text" class="form-control creditamount" name="credit[amount][]" style="width:80%;float:right;text-align: right;" onkeyup="addCredit()" placeholder="Amount">
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Total Amount</td><td></td><td><input type="text" class="form-control" name="credittotal" id="credittotal" style="width:80%;float:right;text-align: right;" disabled="true"></td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-success">
            </div>
        </form>
    </div>

</div>  

<script type="text/javascript">

    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();
        
        var controlForm = $(this).closest('.controls'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
        var subsidy = [<?php echo '"'.implode('","', $subsidy).'"' ?>];
    $( ".sub" ).autocomplete({
      source: subsidy
    });    
    }).on('click', '.btn-remove', function(e)
    {
		$(this).parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});
        
    function addDebit(){
        var debit = 0;
        $('.debitamount').each(function() {
            if(($(this).val()).length == 0){
               debit = debit + 0
            }else{
            debit = debit + parseInt($(this).val());
            }
        })
        $('#debittotal').val(debit)
    }
    
    function addCredit(){
        var credit = 0;
        $('.creditamount').each(function() {
            if(($(this).val()).length == 0){
               credit = credit + 0
           }else{
           credit = credit + parseFloat($(this).val());}
        })
        $('#credittotal').val(credit)
    }    
    
    function sub(){
        if($('#debittotal').val() != $('#credittotal').val()){
            return false;
        }else{
            return true;
        }
    }
    
var start=0;
var clicked = 0;
$(document).on('keypress',function(e) {
    if(e.keyCode == 13) {
        elapsed = new Date().getTime();
        if(elapsed-start<=1000){
           document.getElementById("form").submit();
           clicked = 1
        }
        else{
            event.preventDefault();
        }
        start=elapsed;
        if (clicked > 0){
            start = 0;
            clicked = 0;
        }
        return false;
    }
});    
</script>
@stop
