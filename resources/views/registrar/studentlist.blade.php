@extends('app')

@section('content')

<div class="container">
  <h3>STUDENT CONTACT</h3>
 
  <div class="form-group">
  <label for="sel1">Select level:</label>
  <select class="form-control" id="level" name="level" onchange = "displaystudent(this.value)">
  @foreach($lists as $list)    
    <option value="{{$list->level}}">{{$list->level}}</option>
  @endforeach  
  </select>
</div>
  <div id="forstrand"> 
  </div>
  <div id = "fordisplay">
  </div>    
</div>


<script>
function displaystudent(level){
   
 $.ajax({
     type: "GET",
     url:"studentlist/" + level,
     success:function(data){
          
         $('#forstrand').html("");
         $('#fordisplay').html("");
         if(level == "Grade 9" || level == "Grade 10" || level=="Grade 11" || level == "Grade 12"){
          $('#forstrand').html(data);   
         } else{
          $('#fordisplay').html(data);   
         }
     }
     
 });  
    
}

function strand(strand){
    //alert(document.getElementById('level').value);
    $('#fordisplay').html("");
    $.ajax({
    type: "GET",
     url:"strand/" + strand + "/" + document.getElementById('level').value,
     success:function(data){
         
         $('#fordisplay').html(data);   
         
     }
     
 });  
}
</script>

@endsection