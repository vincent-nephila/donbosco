@extends("app")
@section("content")

<div class="container">
    <div class="col-md-12">
        <h3>Report Card Printing</h3>
    </div>    
    <div class="col-md-6">
        
        <div class="form form-group">
            <label for ="level">Select Level</label>
            <select name="level" id="level" class="form form-control">
                <option>--Select--</option>
                @foreach($levels as $level)
                    <option value="{{$level->level}}">{{$level->level}}</option>
                @endforeach
            </select>
         </div> 
        
      <div id="stranddisplay">
      </div>    
      <div id="studentlist">
      </div>    
        <div id="quarters" class="form form-group" style="display:none">
            <label for ="quarter">Select Quarter</label>
            <select name="quarter" id="quarter" class="form form-control" onchange="kbutton()">
                <option>--Select--</option>
                <option value="1">1st Quarter</option>
                <option value="2">2nd Quarter</option>
                <option value="3">3rd Quarter</option>
                <option value="4">4th Quarter</option>
            </select>
         </div>
        
        <div id="semester" class="form form-group" style="visibility:hidden">
            <label for ="sem">Select Semester</label>
            <select name="sem" id="sem" class="form form-control" onchange="kbutton()">
                <option>--Select--</option>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>

            </select>
         </div>         

    </div> 
    <div class="col-md-6">
        <div class="form form-group">
            <div id="sectioncontrol">
            </div>
            <div id="sectionlist" class="col-md-3">
                
            </div>
            <div class="col-md-3">
                <a href="#" onclick = "displaycards()" id="btncard" class="btn btn-warning" style="display:none">Display Cards</a>
            </div>    
        </div>    
    </div>    
</div>

<script>
    
$('#level').change(function(){
        document.getElementById('quarters').style.display='none'
        document.getElementById('semester').style.visibility='hidden'
    
if($('#level').val() == "Grade 9" || $('#level').val() == "Grade 10" || $('#level').val() == "Grade 11" ){
     $("#studentlist").html("");
     $("#sectioncontrol").html("");
     $("#sectionlist").html("")
     getstrand()
        }else{
     $("#stranddisplay").html("");
     //getstudentlist("");
     getsection("");
 }
});
function displaycards(){
    var level = document.getElementById('level').value
    var section = document.getElementById('section').value
    var quarter = document.getElementById('quarter').value    
    var sem = document.getElementById('sem').value    
    var strand
    if(document.getElementById('strand')){
    strand = document.getElementById('strand').value
    }
    if(level == "Grade 9" | level == "Grade 10"){
     window.open("/reportcards/" + level + "/" + strand + "/" + section +"/back",'_blank'); 
     document.location = "/reportcards/" + level + "/" + strand + "/" + section +"/front";
     
    }else if(level == "Grade 11" | level == "Grade 12"){
        window.open("/reportcards/" + level + "/" + strand + "/" + section +"/"+sem+"/back",'_blank'); 
        document.location = "/reportcards/" + level + "/" + strand + "/" + section +"/"+sem+"/front";        
    }else if(level == "Kindergarten"){
        window.open("/reportcard/" + level + "/"+ section +"/"+quarter+"/back",'_blank');
        document.location = "/reportcard/" + level + "/" + section +"/"+quarter+"/front"
    }else{
        window.open("/reportcards/" + level + "/" + section + "/back",'_blank');
            document.location = "/reportcards/" + level + "/" + section +"/front"
        
    }
}
function getstrandall(strand){
    //getstudentlist(strand);

        

    getsection(strand);
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
function kbutton(){
    document.getElementById('btncard').style.display='block'
}
function callsection(){
    getsectionlist()
}
/*
function getstudentlist(strand){
    var array={};
    array['strand'] = strand;
        $.ajax({
            type: "GET", 
            data: array,
            url: "/getstudentlist/" + $('#level').val() , 
            success:function(data){
                $("#studentlist").html(data);
            }
            
});
       
}
*/
function getsection(strand){
    var array = {};
    array['strand'] = strand;
       $.ajax({
            type: "GET",
            data: array,
            url: "/getsectioncon/" + $('#level').val() , 
            success:function(data){
                $("#sectioncontrol").html(data);
                getsectionlist();
            }
});

}


function getsectionlist(){
  /*      strand= "";
        if($("#strand").length){
            strand = $("#strand").val();
        }
        var array={};
        array['strand']=strand;
         $.ajax({
            type: "GET", 
            data: array,
            url: "/getsectionlist/" + $('#level').val() + "/" + $('#section').val() , 
            success:function(data){
                $("#sectionlist").html(data);
            }
});*/
        var level = document.getElementById('level').value

        if(level == "Grade 11" || level == "Grade 12"){
            document.getElementById('semester').style.visibility='visible'
        }    
        
        if(level == "Kindergarten"){
            document.getElementById('quarters').style.display='block'
        }
        else{
        document.getElementById('btncard').style.display='block'
    }
}
/*
function setsection(id){
    strand="";
    if($("#strand").length>0){
        strand=$("#strand").val();
    }
    //alert($("#strand").val());
    $.ajax({
            type: "GET", 
            url: "/setsection/" + id + "/" + $('#section').val() , 
            success:function(data){
                if(data == "true"){
                    getstudentlist(strand);
                    getsectionlist();
                }
                
            }
});
}

function rmsection(id){
    strand="";
    if($("#strand")){
        strand =$("#strand").val();
    }
      $.ajax({
            type: "GET", 
            url: "/rmsection/" + id  , 
            success:function(data){
                if(data == "true"){
                    getstudentlist(strand);
                    getsectionlist();
                }
                
            }
});
}

function updateadviser(value, id){
    $.ajax({
       type: "GET",
       url: "/updateadviser/" + id + "/" + value,
       success:function(data){
           
       }
    });
}*/
</script>
@stop

