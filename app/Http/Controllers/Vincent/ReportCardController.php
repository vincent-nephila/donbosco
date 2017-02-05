<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Vincent\MainController;
use DB;

class ReportCardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    function reportcardElem($level,$section,$qtrsem=null){
        $schoolyear = MainController::getyear($level);

        $students = DB::Select("SELECT birthDate,class_no,department,users.idno,users.lastname, users.firstname,users.middlename,users.extensionname,student_infos.lrn,gender,birthDate from users left join statuses on users.idno = statuses.idno left join student_infos on users.idno=student_infos.idno where statuses.status IN (2,3) AND level LIKE '$level' AND section LIKE '$section' ORDER BY statuses.class_no ASC");

        $matchfield = ["level"=>$level,"section"=>$section];
        $teacher = \App\CtrSection::where($matchfield)->first();
                

            if($qtrsem != null){
                return $this->viewSectionKinder($level, $section, $qtrsem,$students,$schoolyear,$teacher);
            }else{
                return $this->viewSectionGrade($level, $section,$students,$schoolyear,$teacher);
            }
        
        
    }

    function reportcardHS($level,$shop,$section,$qtrsem=null){
        $schoolyear = MainController::getyear($level);
        $students = DB::Select("SELECT statuses.department,gender,class_no,strand,users.idno,users.lastname, users.firstname,users.middlename,users.extensionname,student_infos.lrn,gender,birthDate from users left join statuses on users.idno = statuses.idno left join student_infos on users.idno=student_infos.idno where statuses.status IN (2,3) AND level LIKE '$level' AND section LIKE '$section' AND strand LIKE '$shop' ORDER BY statuses.class_no ASC");

        $matchfield = ["level"=>$level,"section"=>$section];
        $teacher = \App\CtrSection::where($matchfield)->first();
                if($level == "Kindergarten"){
                    return $this->reportcardElem($level,$section,$qtrsem);
                }

            if($qtrsem != null){
                return $this->viewSectionGrade11to12($level, $shop, $section, $qtrsem,$students,$schoolyear,$teacher);
            }else{
                return $this->viewSectionGrade9to10($level, $shop, $section,$students,$schoolyear,$teacher);
            }
        
    }
    
    function viewSectionKinder($level,$section,$quarter,$students,$schoolyear,$teacher){
        $collection = array();
        
        foreach($students as $student){
            $match = ["idno"=>$student->idno,"subjecttype"=>0,"schoolyear"=>$schoolyear,"isdisplaycard"=>1];
            $academic = \App\Grade::where($match)->orderBy("sortto","ASC")->get();


            $match2 = ["idno"=>$student->idno,"subjecttype"=>3,"schoolyear"=>$schoolyear];
            $conduct = \App\Grade::where($match2)->orderBy("sortto","ASC")->get();


            $match3 = ["idno"=>$student->idno,"schoolyear"=>$schoolyear];
            $attendance = \App\Attendance::where($match3)->orderBy("sortto","ASC")->get();

            $match4 = ["idno"=>$student->idno,"subjecttype"=>1,"schoolyear"=>$schoolyear];
            $technical = \App\Grade::where($match4)->orderBy("sortto","ASC")->get();

            $match5 = ["idno"=>$student->idno,"quarter"=>$quarter,"schoolyear"=>$schoolyear];
            $competence = \App\Competency::where($match5)->orderBy("sortto","ASC")->get();

            $age_year = date_diff(date_create($student->birthDate), date_create('today'))->y;
            $age_month = date_diff(date_create($student->birthDate), date_create('today'))->m;

            if($age_month == 1){
                $age= $age_year." years ".$age_month." month";
            }else{
                $age= $age_year." years ".$age_month." months";
            }

            $student->age = $age;

            $collection[] = array('info'=>$student,'aca'=>$academic,'con'=>$conduct,'att'=>$attendance,'tech'=>$technical,'comp'=>$competence);
        }
                
        return view('registrar.sectiongradeKinder2',compact('collection','students','level','section','teacher','quarter','schoolyear'));
        //return $collection;
                
    }
    
    function viewSectionGrade($level,$section,$students,$schoolyear,$teacher){        
        $collection = array();
        
        foreach($students as $student){
                    $match = ["idno"=>$student->idno,"subjecttype"=>0,"schoolyear"=>$schoolyear,"isdisplaycard"=>1];
                    $academic = \App\Grade::where($match)->orderBy("sortto","ASC")->get();


                    $match2 = ["idno"=>$student->idno,"subjecttype"=>3,"schoolyear"=>$schoolyear];
                    $conduct = \App\Grade::where($match2)->orderBy("sortto","ASC")->get();

                    $match3 = ["idno"=>$student->idno,"schoolyear"=>$schoolyear];
                    $attendance = \App\Attendance::where($match3)->orderBy("sortto","ASC")->get();

                    $match4 = ["idno"=>$student->idno,"subjecttype"=>1,"schoolyear"=>$schoolyear];
                    $technical = \App\Grade::where($match4)->orderBy("sortto","ASC")->get();

                    $age_year = date_diff(date_create($student->birthDate), date_create('today'))->y;
                    $age_month = date_diff(date_create($student->birthDate), date_create('today'))->m;
                    $age= $age_year.".".$age_month;
                    $student->age = $age;                    
                    
                    $collection[] = array('info'=>$student,'aca'=>$academic,'con'=>$conduct,'att'=>$attendance,'tech'=>$technical);
                }           
                
        if($students[0]->department =="Elementary"){            
            return view('registrar.sectiongradereportduplex',compact('collection','students','level','section','teacher','schoolyear'));
        }else{
            //return view('registrar.sectiongrade7to8',compact('collection','students','level','section','teacher','schoolyear'));
            return view('registrar.sectiongrade7to8duplex',compact('collection','students','level','section','teacher','schoolyear'));
        }
                
    }    
    
    function viewSectionGrade9to10($level,$shop,$section,$students,$schoolyear,$teacher){
        $collection = array();
        foreach($students as $student){
                $match = ["idno"=>$student->idno,"subjecttype"=>0,"schoolyear"=>$schoolyear,"isdisplaycard"=>1];
                $academic = \App\Grade::where($match)->orderBy("sortto","ASC")->get();

                $match2 = ["idno"=>$student->idno,"subjecttype"=>3,"schoolyear"=>$schoolyear];
                $conduct = \App\Grade::where($match2)->orderBy("sortto","ASC")->get();

                $match3 = ["idno"=>$student->idno,"schoolyear"=>$schoolyear];
                $attendance = \App\Attendance::where($match3)->orderBy("sortto","ASC")->get();

                $match4 = ["idno"=>$student->idno,"subjecttype"=>1,"schoolyear"=>$schoolyear];
                $technical = \App\Grade::where($match4)->orderBy("sortto","ASC")->get();

                $match5 = ["idno"=>$student->idno,"subjecttype"=>5,"schoolyear"=>$schoolyear];
                $core = \App\Grade::where($match5)->orderBy("sortto","ASC")->get();

                $match6 = ["idno"=>$student->idno,"subjecttype"=>6,"schoolyear"=>$schoolyear];
                $special = \App\Grade::where($match6)->orderBy("sortto","ASC")->get();

                $age_year = date_diff(date_create($student->birthDate), date_create('today'))->y;
                $age_month = date_diff(date_create($student->birthDate), date_create('today'))->m;
                $age= $age_year.".".$age_month;
                $student->age = $age;
                $collection[] = array('info'=>$student,'aca'=>$academic,'con'=>$conduct,'att'=>$attendance,'tech'=>$technical,'core'=>$core,'spec'=>$special);
            }

        return view('registrar.sectiongrade9to10duplex',compact('collection','students','level','section','teacher','schoolyear','shop'));
    }
    
    function viewSectionGrade11to12($level,$shop,$section,$sem,$students,$schoolyear,$teacher){
        $collection = array();        
        
        foreach($students as $student){
                    $match = ["idno"=>$student->idno,"subjecttype"=>0,"schoolyear"=>$schoolyear,"isdisplaycard"=>1];
                    $academic = \App\Grade::where($match)->orderBy("sortto","ASC")->get();

                    $match2 = ["idno"=>$student->idno,"subjecttype"=>3,"schoolyear"=>$schoolyear];
                    $conduct = \App\Grade::where($match2)->orderBy("sortto","ASC")->get();

                    if($student->department == "Senior High School"){
                    $match3 = ["idno"=>$student->idno,"schoolyear"=>$schoolyear];
                    $attendance = \App\Attendance::where($match3)->orderBy("sortto","ASC")->get();
                    }else{
                    $match3 = ["idno"=>$student->idno,"subjecttype"=>2,"schoolyear"=>$schoolyear];
                    $attendance = \App\Grade::where($match3)->orderBy("sortto","ASC")->get();
                    }
                    
                    $match4 = ["idno"=>$student->idno,"subjecttype"=>1,"schoolyear"=>$schoolyear];
                    $technical = \App\Grade::where($match4)->orderBy("sortto","ASC")->get();
                    
                    $match5 = ["idno"=>$student->idno,"subjecttype"=>5,"schoolyear"=>$schoolyear,"semester"=>$sem];
                    $core = \App\Grade::where($match5)->orderBy("sortto","ASC")->get();
                    
                    $match6 = ["idno"=>$student->idno,"subjecttype"=>6,"schoolyear"=>$schoolyear,"semester"=>$sem];
                    $special = \App\Grade::where($match6)->orderBy("sortto","ASC")->get();
                    
                    $age_year = date_diff(date_create($student->birthDate), date_create('today'))->y;
                    $age_month = date_diff(date_create($student->birthDate), date_create('today'))->m;
                    $age= $age_year.".".$age_month;
                    $student->age = $age;
                    $collection[] = array('info'=>$student,'aca'=>$academic,'con'=>$conduct,'att'=>$attendance,'tech'=>$technical,'core'=>$core,'spec'=>$special);
                    //$collection[] = array('info'=>$student);
                }
            
        return view('registrar.sectiongrade11',compact('collection','students','level','section','teacher','schoolyear','sem'));
    } 
}
