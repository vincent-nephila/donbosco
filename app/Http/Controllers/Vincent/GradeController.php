<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use PDF;

class GradeController extends Controller
{
    //
    
    public function __construct()
	{
		$this->middleware('auth');
	}

    
    public function viewGrades($idno){
        $student = DB::Select("SELECT *  from users left join statuses on users.idno = statuses.idno left join student_infos on users.idno=student_infos.idno where users.idno =  $idno");
        $matchfield = ["level"=>$student[0]->level,"section"=>$student[0]->section];
        
        $teacher = \App\CtrSection::where($matchfield)->first();

        $match = ["idno"=>$idno,"subjecttype"=>0,"schoolyear"=>2016];
        $academic = \App\Grade::where($match)->orderBy("sortto","ASC")->get();
        

        $match2 = ["idno"=>$idno,"subjecttype"=>3,"schoolyear"=>2016];
        $conduct = \App\Grade::where($match2)->orderBy("sortto","ASC")->get();
        
        $match3 = ["idno"=>$idno,"subjecttype"=>2,"schoolyear"=>2016];
        $attendance = \App\Grade::where($match3)->orderBy("sortto","ASC")->get();        
        
        return view('registrar.gradecard',compact('student','teacher','academic','academicSubjects','conduct','attendance','idno'));
        //return count($conduct) ."-". $conduct;

    }
    
    function reset(){
        $no_student=0;
                    $students = \App\Status::whereIn('status',array(2,3))->where('strand','ABM')->get();
        foreach($students as $student){
            $subjects = \App\CtrSubjects::where('level',$student->level)->where('semester',2)->where('strand','ABM')->get();
                    foreach($subjects as $subject){
                            $newgrade = new \App\Grade;
                            $newgrade->idno = $student->idno;
                            $newgrade->semester = $subject->semester;
                            $newgrade->department = $student->department;
                            $newgrade->level = $student->level;
                            $newgrade->subjecttype = $subject->subjecttype;
                            $newgrade->subjectcode = $subject->subjectcode;
                            $newgrade->subjectname = $subject->subjectname;
                            $newgrade->points = $subject->points;
                            $newgrade->weighted = $subject->weighted;
                            $newgrade->sortto = $subject->sortto;
                            $newgrade->schoolyear = $student->schoolyear;
                            $newgrade->save();
                    }
                    $no_student =$no_student +1;
                    echo "NO Of Student: ".$no_student;
        }
        /*
        $students = \App\Status::where('status',2)->where('department','Kindergarten')->get();
        foreach($students as $student){
            $subjects = \App\CtrCompetence::where('quarter',2)->get();
                    foreach($subjects as $subject){
                            $newgrade = new \App\Competency;
                            $newgrade->idno = $student->idno;
                            $newgrade->subject = $subject->subject;
                            $newgrade->section = $subject->section;
                            $newgrade->competencycode = $subject->competencycode;
                            $newgrade->description = $subject->description;
                            $newgrade->sortto = $subject->sortto;
                            $newgrade->quarter = $subject->quarter;
                            $newgrade->competencycode=$subject->competencycode;
                            $newgrade->schoolyear = $student->schoolyear;
                            $newgrade->save();
                    }
                    
        }        
        
        $students = \App\Grade::distinct()->select('idno')->get();
        foreach($students as $student){
            $subjects = \App\CtrSubjects::where('subjecttype',2)->where('level','Grade 11')->where('strand','ABM')->get();
                    foreach($subjects as $subject){
                            $newgrade = new \App\Attendance;
                            $newgrade->idno = $student->idno;
                            $newgrade->attendancetype = $subject->subjectcode;
                            $newgrade->sortto = $subject->sortto;
                            $newgrade->schoolyear = 2016;
                            $newgrade->save();
                    }
                    
        } */       
    }
    
    function studentGrade($idno){
        $schoolyears = \App\Grade::where('idno',$idno)->groupBy('schoolyear')->get();
        $collection = array();
        
        foreach($schoolyears as $schoolyear){
            $subjects = \App\Grade::where('schoolyear',$schoolyear->schoolyear)->where('idno',$idno)->orderBy('sortto','ASC')->get();
            
            $collection[] = $subjects;
        } 
        
        return $collection;
        
    }

    function overallRank(){
        $levels = DB::Select("Select level from ctr_levels");
        
        return view('vincent.registrar.overallRanking',compact('levels'));
    }
    
    function elemTor($idno){
        $papersize = array(0,0,360,360);    
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper($papersize);
        $pdf->loadView("vincent.registrar.studenttor");
        return $pdf->stream();
    }

}
