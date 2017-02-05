@extends('app')
@section('content')
<style>
    #btnTrigger{
        display: none;
    }
</style>
<style>
    #btnTrigger{
        display:none;
    }
    
</style>
<button type="button" class="btn btn-info btn-lg" id='btnTrigger' data-toggle="modal" data-target="#myModal">Open Modal</button>
    
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Restricted Action</h4>
        </div>
        <div class="modal-body">
          <p>Re-setting student ranks outside the current school year is not allowed.</p>
        </div>
      </div>
    </div>
  </div>
<div class='col-md-12'>
    <span id="quarters">
        <a class="btn btn-default quarter btn-primary" id="1st" onclick="changequarter(1)">1st Quarter</a><a class="btn btn-default quarter" id="2nd" onclick="changequarter(2)">2nd Quarter</a><a class="btn btn-default quarter" id="3rd" onclick="changequarter(3)">3rd Quarter</a><a class="btn btn-default quarter" id="4th" onclick="changequarter(4)">4th Quarter</a>
        <span style="margin-left: 20px">
            for SY:
            <?php 
            $sys= App\Status::distinct()->select('schoolyear')->get();
            $current = App\CtrRegistrationSchoolyear::first();
            ?>
            <select id="schoolyear" name="schoolyear" class="form-control" style="display: inline-block;width: 8%;" onchange='updateYear()'>
                @foreach($sys as $sy)
                <option value="{{$sy->schoolyear}}"
                        @if($sy->schoolyear == $current->schoolyear)
                        selected="selected"
                        @endif
                        >{{$sy->schoolyear}}</option>
                @endforeach
            </select>
            <label><input type="checkbox" id="setYear" onclick="updateYear()">&nbsp;&nbsp;&nbsp;Use year</label>
        </span>
    </span>
    
    <select id='level' class='form-control'  onchange="viewlist(this.value)">
        <option value="null">-- Select Level --</option>
        @foreach($levels as $level)
        <option value='{{$level->level}}'>{{$level->level}}</option>
        @endforeach
    </select>
    <div id="strands" style="visibility: hidden">
        <select id='level' class='form-control'  onchange="setStrand(this.value)">
            <option value="null">-- Select Strand --</option>
            <option value="ABM">ABM</option>
            <option value="STEM">STEM</option>

        </select>
    </div>    
    <div id="rerank" style="visibility: hidden">
        <button onclick = "setRank()">Set Ranking</button>
    </div>
    <div class="col-md-12" id="main_content">
        
    </div>
    <div id="blocker" style="position:fixed;top:0px;left:0px;width:100%;height:100%;background-color: rgba(181, 181, 181, 0.46);vertical-align: middle;text-align:center;line-height: 100%;display: none">
        
    </div>

</div>
<script>
    var level = "";
    var strand = "";
    var qtr = 1;
    var qtrstring = "FIRST";
    var sy;
    
    $("#quarters").on("click", "a.quarter", function(){
            $(this).siblings().removeClass('btn-primary');
            $(this).addClass('btn-primary');
            $(this).blur();
        });

    function changequarter(setQuarter){
        qtr=setQuarter;
        viewlist(document.getElementById('level').value);
    }
    
    function updateYear(){
        viewranking(level)
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

    function viewlist(lvl){
        document.getElementById('rerank').style.visibility='hidden';
        document.getElementById('strands').style.visibility='hidden';
        level = lvl;
        
        if(lvl == "Grade 11" | lvl == "Grade 12"){
            document.getElementById('strands').style.visibility='visible';
        }else{
            if(lvl != "null"){
                 document.getElementById('rerank').style.visibility='visible'    
             }            
            viewranking(lvl);
        }
    }
    
    function setStrand(strnd){
        if(strnd != "null"){
             document.getElementById('rerank').style.visibility='visible'    
         }
        strand = strnd;
        viewranking(level);
        
    }
    
    function viewranking(lvl){
        setYear();
        var arrays ={} ;
        arrays['strand'] = strand;
        arrays['quarter'] = qtr;
        arrays['sy'] = sy;
        $('#main_content').css('text-align','center').css('padding-top','200px');
        $('#main_content').html("<i class='fa fa-spinner fa-spin fa-3x fa-fw fa-5x'></i><span style='position:relative;left:-5em;top:30px;' class='sr-only'>Loading...</span>"); 
        
         $.ajax({
             type:"GET",
             url:"showallrank/"+lvl,
             data:arrays,
             success:function(data){
                if(lvl != "null"){
                    $('#main_content').css('text-align','initial').css('padding-top','0px');
                    $('#main_content').html(data);
                }
             }
             
         });
    }
    
    function setRank(){
        document.getElementById('blocker').style.display='block';
        var arrays ={} ;
        arrays['level'] = level;
        arrays['quarter'] = qtr;
        arrays['strand'] = strand;
        arrays['sy'] = sy;

            $.ajax({
                type: "GET", 
                url: "/setallrank",
                data : arrays,
                success:function(data){
                    document.getElementById('blocker').style.display='none';
                    if(data == 1){
                        $('#btnTrigger').click();
                    }else{
                    
                    viewranking(level);   
                    
                    }
                    }
                }); 
    }    
</script>
@stop