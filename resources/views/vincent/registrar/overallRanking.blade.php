@extends('app')
@section('content')
<div class='col-md-12'>
    
    <select id='level' class='form-control'  onchange="viewranking(this.value)">
        <option>-- Select Level --</option>
        @foreach($levels as $level)
        <option value='{{$level->level}}'>{{$level->level}}</option>
        @endforeach
    </select>
    <div class="col-md-12" id="main_content">
        
    </div>

</div>
<script>
    function viewranking(level){
         $.ajax({
             type:"GET",
             url:"showallrank/"+level,
             success:function(data){
                 
                 $('#main_content').html(data);
             }
             
         });
    }
</script>
@stop