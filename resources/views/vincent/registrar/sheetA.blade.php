@extends("app")
@section("content")

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
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="form form-group">
                <label for ="level">Select Level</label>
                <select name="level" id="level" class="form form-control">
                    <option>--Select--</option>
                    @foreach($levels as $level)
                        <option value="{{$level->level}}">{{$level->level}}</option>
                    @endforeach
                </select>
             </div>
        </div>
        <div id="sectioncontrol" class="col-md-4 form form-group">
        </div>
        <div id="subjlist" class="col-md-4 form form-group">
        </div>
    </div>
    <div class="col-md-12">
        <div id="stranddisplay" class="col-md-4 form form-group">
        </div>
        <div class="col-md-4 form form-group">
            <div id="displaysemester">
                <label for ="semester">Select Semester</label>
                  <select id="semester" class="form form-control">
                      <option value='1' selected="selected">First Semester</option>
                      <option value='2'>Second Semester</option>
                  </select>
            </div>
        </div>
        <div class="col-md-4" style="margin-top: 25px;float: right">
            <a href="#" onclick = "generatesheet()" id="btncard" class="btn btn-warning" style="visibility:hidden">Display Cards</a>
        </div>
    </div>
</div>

<script>
 var strn;
 var strand;
 var sem;
 var sy;
 $("#displaysemester").hide();
    
$('#level').change(function(){
if($('#level').val() == "Grade 9" || $('#level').val() == "Grade 10" || $('#level').val() == "Grade 11" ){
     $("#studentlist").html("");
     $("#sectioncontrol").html("");
     $("#sectionlist").html("")
     $("#subjlist").html("");
     getstrand()
        }else{
     $("#subjlist").html("");
     $("#stranddisplay").html("");
     $("#displaysemester").hide()
     //getstudentlist("");
     getsection("");
 }
 
});

function generatesheet(){
    var level = document.getElementById('level').value
    var section = document.getElementById('section').value
    var subject = document.getElementById('subject').value
    if(document.getElementById('strand')){
    strand = document.getElementById('strand').value
    }
    
    if(subject.indexOf("/") > 0){
        subject = subject.replace("/",":");
    }
    
    setYear();
    
    if(strn != null){
        window.open("/printsheetA/" +sy+"/"+ level + "/" + strn + "/" + section +"/"+ subject + "/"+ document.getElementById('semester').value, '_blank');
    }
    else{
        window.open("/printsheetA/" +sy+"/"+ level + "/" + section +"/"+ subject, '_blank');
    }
    
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

function getstrand(){
    $.ajax({
            type: "GET", 
            url: "/getstrand/" + $('#level').val() , 
            success:function(data){
                $("#stranddisplay").html(data);
            }
});
}

function showbtn(){
    document.getElementById('btncard').style.visibility='visible'
}

function getstrandall(strand){
    //getstudentlist(strand);
    var level = document.getElementById('level').value
    if(level == "Grade 11" || level == "Grade 12"){
        $("#displaysemester").css("display","block");
    }
    
    getsection(strand);
    
    strn = strand;
}


function getsection(strand){
    
    var array = {};
    array['strand'] = strand;
       $.ajax({
            type: "GET",
            data: array,
            url: "/getsectioncon/" + $('#level').val() , 
            success:function(data){
                $("#sectioncontrol").html(data);
            }
});

}
$("#semester").change(function(){
    $("#subjlist").html("");
    genSubj();
});
function genSubj(){
    setYear();
    var array = {};
    array['sy'] = sy;
    array['strand'] = strn;
    array['sem'] = document.getElementById('semester').value;
    
    $("#subjlist").html("");
        $.ajax({
            type: "GET",
            data: array,
            url: "/getsubjects/" + $('#level').val() , 
            success:function(data){
               $("#subjlist").html(data);
            }
});

}
</script>


@stop

