@extends('app')
@section('content')
	<div class="container">
<!--
		<a href="{{ URL::to('downloadExcel/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>

		<a href="{{ URL::to('downloadExcel/xlsx') }}"><button class="btn btn-success">Download Excel xlsx</button></a>

		<a href="{{ URL::to('downloadExcel/csv') }}"><button class="btn btn-success">Download CSV</button></a>
-->

<?php


?>
<div class="col-md-3">
		<form action="{{ URL::to('importGrade') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!} 
                        <div class="form form-group">
			<input type="file" name="import_file" class="form"/>
                        </div>
                        <div class="form form-group">
			<button class="btn btn-primary">Import Grade</button>
                        </div>    
		</form>
    
                <form action="{{ URL::to('importConduct') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!} 
                        <div class="form form-group">
			<input type="file" name="import_file1" class="form"/>
                        </div>
                        <div class="form form-group">
			<button class="btn btn-primary">Import Conduct</button>
                        </div>    
		</form>
    
                <form action="{{ URL::to('importAttendance') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!} 
                        <div class="form form-group">
			<input type="file" name="import_file2" class="form"/>
                        </div>
                        <div class="form form-group">
			<button class="btn btn-primary">Import Attendance</button>
                        </div>    
		</form>
</div>

<div class="col-md-3">
    <h5>Grades</h5>
     <ul>
    <?php
    $levels = \App\CtrLevel::orderBy('id')->get();
   
    foreach($levels as $level){
        echo "<li>" . $level->level . myFunction($level->level,1) ."</li>";
    }
    ?>
    </ul>
</div> 
<div class="col-md-3">
    <h5>Conduct</h5>
     <ul>
    <?php
    $levels = \App\CtrLevel::orderBy('id')->get();
   
    foreach($levels as $level){
        echo "<li>" . $level->level . myFunction($level->level,2) ."</li>";
    }
    ?>
    </ul>
</div>
<div class="col-md-3">
    <h5>Attendance</h5>
     <ul>
    <?php
    $levels = \App\CtrLevel::orderBy('id')->get();
   
    foreach($levels as $level){
        echo "<li>" . $level->level . myFunction($level->level,3) ."</li>";
    }
    ?>
    </ul>
</div>
	</div>


<?php
function myFunction($level,$subjecttype){
$data = "<ul>"; 
$sections=  DB::Select("select distinct section from statuses where level='$level' and status = '2' ");
foreach($sections as $section){
    if($section->section == ""){}else{
    $data = $data. "<li>" . $section->section . getSubject($level,$section->section,$subjecttype)."</li>";
}}

$data = $data."</ul>";

return $data;    
}

function getSubject($level,$section,$subjecttype){
  if($subjecttype=='1'){  
    if($level == 'Grade 11'){
     $subjects = DB::Select("select distinct subjectcode, subjectname from ctr_subjects where level='$level' and subjecttype <= '6' and subjecttype > 4  order by subjecttype, sortto");
    }
    else{
    $subjects = DB::Select("select distinct subjectcode, subjectname from ctr_subjects where level='$level' and subjecttype <= '1'  order by subjecttype, sortto");
  }}
  elseif($subjecttype=='2'){
     $subjects = DB::Select("select distinct subjectcode, subjectname from ctr_subjects where level='$level' and subjecttype = '3'  order by subjecttype, sortto");
  }
  elseif($subjecttype=='3'){
     $subjects = DB::Select("select distinct subjectcode, subjectname from ctr_subjects where level='$level' and subjecttype = '2'  order by subjecttype, sortto"); 
  }
    $data = "<ul>";
foreach($subjects as $subject){
    $mycount = getCount($level, $subject->subjectcode, $section,$subjecttype);
    $data = $data. "<li";
    if($mycount > 0 ){
        $data=$data . " style=\"color:red\" ";
    }
        $data=$data. ">" . $subject->subjectcode . " - " .$subject->subjectname." - $mycount </li>";
}
$data = $data."</ul>";

return $data; 
}

function getCount($level, $subjectcode, $section,$subjecttype){
  if($subjecttype=='1'){  
  $count = DB::Select("select idno from subject_repos where level = '$level' and subjectcode = '$subjectcode' and section = '$section'");  
  }
  elseif($subjecttype=='2'||$subjecttype=='3'){
  $count = DB::Select("Select idno from conduct_repos where level = '$level' and section = '$section'");
  }
  return count($count);
}

?>

@stop
