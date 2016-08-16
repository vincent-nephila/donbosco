<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class GradeController extends Controller
{
    //

    
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
                    $students = \App\Status::where('status',2)->where('department','!=','TVET')->where('level','!=','Grade 11')->where('id','1356')->get();
        foreach($students as $student){
            $subjects = \App\CtrSubjects::where('level',$student->level)->get();
                    foreach($subjects as $subject){
                            $newgrade = new \App\Grade;
                            $newgrade->idno = $student->idno;
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
        
        
        
    }
    
    function viewSectionGrade($level,$section){
        $schoolyear = \App\CtrRefSchoolyear::first();
        $collection = array();
        //$student = \App\Status::where('level',$level)->where('section',$section)->where('status',2)->get();
        $students = DB::Select("SELECT *  from users left join statuses on users.idno = statuses.idno left join student_infos on users.idno=student_infos.idno where level LIKE '$level' AND section LIKE '$section'");
        $matchfield = ["level"=>$level,"section"=>$section];
        
        $teacher = \App\CtrSection::where($matchfield)->first();        
        
                foreach($students as $student){
                    $match = ["idno"=>$student->idno,"subjecttype"=>0,"schoolyear"=>$schoolyear->schoolyear];
                    $academic = \App\Grade::where($match)->orderBy("sortto","ASC")->get();


                    $match2 = ["idno"=>$student->idno,"subjecttype"=>3,"schoolyear"=>$schoolyear->schoolyear];
                    $conduct = \App\Grade::where($match2)->orderBy("sortto","ASC")->get();

                    $match3 = ["idno"=>$student->idno,"subjecttype"=>2,"schoolyear"=>$schoolyear->schoolyear];
                    $attendance = \App\Grade::where($match3)->orderBy("sortto","ASC")->get();
                    
                    $collection[] = array('info'=>$student,'aca'=>$academic,'con'=>$conduct,'att'=>$attendance);
                }
                
                //return $collection;
                return view('registrar.sectiongradereport',compact('collection','students','level','section','teacher'));
    }
    
    function studentGrade($idno){
        $schoolyears = \App\Grade::where('idno',$idno)->groupBy('schoolyear')->get();
        //return view('registrar.gradeImport',compact('sectiongrade'));
         $collection = array();
        foreach($schoolyears as $schoolyear){
            $subjects = \App\Grade::where('schoolyear',$schoolyear->schoolyear)->where('idno',$idno)->orderBy('sortto','ASC')->get();
            
            $collection[] = $subjects;
        } 
        
        //return view('registrar.gradeImport',compact('collection'));
        return $collection;
        
    }


}
