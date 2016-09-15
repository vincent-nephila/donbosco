@extends("app")
@section("content")

<div class="container">
    <div class="col-md-12">
        <h3>Sheet A Generator</h3>
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
    </div> 
    <div class="col-md-6">
        <div class="form form-group">
            <div id="sectioncontrol">
            </div>
            
            <div id="subjlist">
                
            </div>
    
        </div>    
    </div>   
            <div class="col-md-12">
                <a href="#" onclick = "generatesheet()" id="btncard" class="btn btn-warning" style="visibility:hidden">Display Cards</a>
            </div>    
</div>

<script>
 var strn = "";
    
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
     //getstudentlist("");
     getsection("");
 }
 
});

function generatesheet(){
    var level = document.getElementById('level').value
    var section = document.getElementById('section').value
    var strand
    var subject = document.getElementById('subject').value
    if(document.getElementById('strand')){
    strand = document.getElementById('strand').value
    }
    document.location = "/printsheetA/" + level + "/" + section +"/"+ subject
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
    getsection(strand);
    strn = strand;
    alert(strn);
}


function getsection(strand){
    
    var array = {};
    array['strand'] = strand;
       $.ajax({
            type: "GET",
            data: array,
            url: "/getsection/" + $('#level').val() , 
            success:function(data){
                $("#sectioncontrol").html(data);
            }
});

}

function genSubj(){
    var array = {};
    array['strand'] = strn;
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

