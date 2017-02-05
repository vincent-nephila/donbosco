@extends('app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <h3>Sheet A Generator</h3>
        <div class="col-md-1 col-sm-2 col-xs-2" style="padding-left: 0px;">for SY:</div>
        <?php 
        $sys= App\Status::distinct()->select('schoolyear')->get();
        $current = App\CtrRegistrationSchoolyear::first();
        ?>
        <div class="col-md-1 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <select id="schoolyear" name="schoolyear" class="form-control">
                @foreach($sys as $sy)
                <option value="{{$sy->schoolyear}}"
                        @if($sy->schoolyear == $current->schoolyear)
                        selected="selected"
                        @endif
                        >{{$sy->schoolyear}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-3" style="padding-left: 0px;"><label><input type="checkbox" id="setYear">&nbsp;&nbsp;&nbsp;Use year</label></div>
    </div>
</div>
<div class="container">
    <hr>
    <div class="col-md-6">
        <div class="form-group">
            <label for="level">Select Grade Level</label>
            <select id="level" onchange="getSection()" class="form-control">
                <option>Select Level</option>
                @foreach($levels as $level)
                    <option value="{{$level->level}}">{{$level->level}}</option>
                @endforeach
            </select>    
        </div>
        <div class="form-group">
            <div id="displaysection">
            </div>    
        </div>
        <div class="form-group">
            <div id="displayqtr" style="display:none">
                <label>Select Quarter Period</label>
                <select id ="qtr" class="form-control">
                    <option value="1" selected>First Quarter Period</option>
                    <option value="2">Second Quarter Period</option>
                    <option value="3">Third Quarter Period</option>
                    <option value="4">Fourth Quarter Period</option>
                </select>    
            </div>
            <div id="displaysemester" style="display:none">
                <label for ="semester">Select Semester</label>
                  <select id="semester" class="form form-control">
                      <option value='1' selected="selected">First Semester</option>
                      <option value='2'>Second Semester</option>
                  </select>
            </div>
            </div>
        <div class="form-group">
            <div id="displaybtn">
                <button class="btn btn-primary" onclick="goto()" style="visibility:hidden" id="link">Display Attendance</button>
            </div>
        </div>
        </div>    
    </div>    
</div>    
<script>
var sy;
function getSection(){    
    document.getElementById('displayqtr').style.display="none"
    document.getElementById('displayqtr').style.display="none"
 $.ajax({
            type: "GET", 
            url: "/getsection1/" + $('#level').val() , 
            success:function(data){
                $("#displaysection").html(data);
            }
});   
}

function setYear(){
    if(document.getElementById("setYear").checked == true){
        sy = $("#schoolyear").val();
    }else{
        $.ajax({
            async: false,
            type: "GET", 
            url: "/getyear/" + $('#level').val(), 
            success:function(data){
                sy = data;
            }
        });
    }
}

function showqtr(){
    if(document.getElementById('level').value == "Grade 11" || document.getElementById('level').value == "Grade 12"){
    document.getElementById('displaysemester').style.display="block"
    document.getElementById('link').style.visibility="visible"   
    }else{
    document.getElementById('displayqtr').style.display="block"
    document.getElementById('link').style.visibility="visible"   
    }
}
function goto(){
    
    var level = document.getElementById('level').value
    var section = document.getElementById('section').value
    if(document.getElementById('level').value == "Grade 11" || document.getElementById('level').value == "Grade 12"){
        var quarter = document.getElementById('semester').value
    }
    else{
        var quarter = document.getElementById('qtr').value
    }

    
    setYear()
    window.open("/sheetaconduct/" + sy + "/" + level + "/" + section +"/"+ quarter, '_blank');
}
</script>
@stop

