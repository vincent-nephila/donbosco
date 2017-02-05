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
            <div id="displayqtr" style="visibility:hidden">
                <label>Select Quarter Period</label>
                <select id ="qtr" class="form-control">
                    <option value="1" selected>First Quarter Period</option>
                    <option value="2">Second Quarter Period</option>
                    <option value="3">Third Quarter Period</option>
                    <option value="4">Fourth Quarter Period</option>
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

function getSection(){
 $.ajax({
            type: "GET", 
            url: "/getsection1/" + $('#level').val() , 
            success:function(data){
                $("#displaysection").html(data);
            }
});   
}

function showqtr(){
    document.getElementById('displayqtr').style.visibility="visible"
    document.getElementById('link').style.visibility="visible"
    }
function goto(){
    var level = document.getElementById('level').value
    var section = document.getElementById('section').value
    var quarter = document.getElementById('qtr').value
    setYear();
    window.open("/sheetaAttendance/" + sy + "/" + level + "/" + section +"/"+ quarter, '_blank');
    
}
</script>
@stop

