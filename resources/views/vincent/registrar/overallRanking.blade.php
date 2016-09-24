@extends('app')
@section('content')
<div class='col-md-12'>
    
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

</div>
<script>
    var level = ""
    var strand = ""
    
    function viewlist(lvl){
        $('#main_content').html("");
        document.getElementById('rerank').style.visibility='hidden';
        document.getElementById('strands').style.visibility='hidden';
        level = lvl
        
        if(lvl != "null"){
             document.getElementById('rerank').style.visibility='visible'    
         }
         
        if(lvl == "Grade 11" | lvl == "Grade 12"){
            document.getElementById('strands').style.visibility='visible';
        }else{
            
            viewranking(lvl);
        }
    }
    
    function setStrand(strnd){
        if(strnd != "null"){
             document.getElementById('rerank').style.visibility='visible'    
         }
        strand = strnd;
        viewranking(level)
        
    }
    
    function viewranking(lvl){
        var arrays ={} ;
        arrays['strand'] = strand;
        arrays['quarter'] = 1;

         $.ajax({
             type:"GET",
             url:"showallrank/"+lvl,
             data:arrays,
             success:function(data){
                if(lvl != "null"){
                 $('#main_content').html(data);
                }
             }
             
         });

    }
    
    function setRank(){

        var arrays ={} ;
        arrays['level'] = level;
        arrays['quarter'] = 1;
        arrays['strand'] = strand;


            $.ajax({
                type: "GET", 
                url: "/setallrank",
                data : arrays,
                success:function(data){
                    alert(data)
                    viewranking(level)
                    }
                }); 
    }    
</script>
@stop