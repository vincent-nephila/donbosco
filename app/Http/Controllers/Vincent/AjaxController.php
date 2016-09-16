<?php

namespace App\Http\Controllers\Vincent;

use Illuminate\Support\Facades\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;
class AjaxController extends Controller
{
    //
        public function getid($varid){
        if(Request::ajax()){
        $user = \App\User::find($varid);
        $refno = $user->reference_number;
        $varrefno = strval($refno);
        $user->reference_number = $refno + 1;
        $user->update(); 
        
        $sy = \App\RegistrarSchoolyear::first(); 
            for($i=strlen($varrefno); $i< 3 ;$i++){
                $varrefno = "0" . $varrefno;    
            }
            
            $value = substr($sy->schoolyear,2,2) . $user->idref . $varrefno;
            $intval = 0;
            
            for($y=1; $y<= strlen($value); $y++){
                $sub = substr($value,$y);
                $intval = $intval + intval($sub);
            }
              //$intval = $intval%9;
              $varrefno = $value . strval($intval%9); 
            
         // return $user->idref;  
        return $varrefno;
        }else{
        return "Invalid Request";    
        }
    }
    
    
    function showgrades(){
        
        $section = Input::get('section');
        $level = Input::get('level');
        $strand = Input::get('strand');

        
        
        $students = DB::Select("Select statuses.idno,class_no,gender,lastname,firstname,middlename,extensionname from users left join statuses on users.idno = statuses.idno where statuses.status IN (2,3) and statuses.level = '$level' and statuses.section = '$section' AND statuses.strand = '$strand' order by class_no ASC");
        //$students = DB::Select("Select statuses.idno,gender,lastname,firstname,middlename,extensionname from users left join statuses on users.idno = statuses.idno where statuses.status= 2 and statuses.level = 'Grade 10' and statuses.section = 'Saint Callisto Caravario' AND statuses.strand = 'Industrial Drafting Technology' order by gender DESC,lastname ASC,firstname ASC");
        if(Input::get('department') != 'Senior High School'){
            $strand = '';
        }
        $subjects = \App\CtrSubjects::where('level',Input::get('level'))->where('strand',$strand)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
        $schoolyear = \App\CtrRefSchoolyear::first();
        $count = 1;
        $sy = $schoolyear->schoolyear;
        $data = "";
        
        $data = $data."<table border='1' cellpadding='1' cellspacing='2' width='100%'>";
        $data = $data."<tr>";
        $data = $data."<td style='width:30px;text-align:center;'>CN</td>";
        $data = $data."<td style='width:310px;text-align:center;'>Student Name</td>";
        
            foreach($subjects as $subj){
                if($subj->subjecttype == 0){
                    $data = $data."<td style='width:50px;text-align:center;'>".$subj->subjectcode."</td>";
                }
            }
            
            foreach($subjects as $subj){
                if($subj->subjecttype == 5 | $subj->subjecttype == 6){
                    $data = $data."<td style='width:50px;text-align:center;'>".$subj->subjectcode."</td>";
                }
            }
            
            $data = $data."<td style='width:80px;font-weight: bold;text-align:center;'>ACAD GEN AVE</td>";
            $data = $data."<td style='width:80px;font-weight: bold;text-align:center;'><button class='btn btn-default' onclick=\"setAcadRank('".$section."','".$level."',".Input::get('quarter').")\" >RANKING</button></td>";
            foreach($subjects as $subj){
                if($subj->subjecttype == 1){
                    $data = $data."<td style='width:50px;text-align:center;'>".$subj->subjectcode."</td>";
                    }
            }
            if(Input::get('department') == 'Junior High School'){
            $data = $data."<td style='width:50px;font-weight: bold;text-align:center;'>TWA</td>";
            $data = $data."<td style='width:80px;font-weight: bold;text-align:center;'><button class='btn btn-default' onclick=\"setTechRank()\" >TECH RANKING</button></td>";
            }
            
            $data = $data."<td style='width:50px;font-weight: bold;text-align:center;'>GMRC</td>";
            
            foreach($subjects as $subj){
                if($subj->subjecttype == 2){
                $data = $data."<td style='width:50px;text-align:center;'>".$subj->subjectcode."</td>";
                }
            }
            $data = $data."</tr>";

            
            foreach($students as $student){
            $data = $data."<tr>";
            $data = $data."<td style='text-align:center;'>".$student->class_no."</td>";
            $data = $data."<td style='font-size: 9pt;padding-left:5px;'>".$student->lastname.", ".$student->firstname." ".$student->middlename." ".$student->extensionname."</td>";
            
  
            switch (Input::get('quarter')){
                    case 1;
                        $grades = \App\Grade::select('subjecttype','first_grading as grade') ->where('idno',$student->idno)->where('schoolyear',$sy)->where('isdisplaycard',1)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
                        $ranking = \App\Ranking::select('acad_1 as acad','tech_1 as tech')->where('idno',$student->idno)->where('schoolyear',$sy)->first();
                    break;
                    case 2;
                        $grades = \App\Grade::select('subjecttype','second_grading as grade')->where('idno',$student->idno)->where('schoolyear',$sy)->where('isdisplaycard',1)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
                        $ranking = \App\Ranking::select('acad_2 as acad','tech_2 as tech')->where('idno',$student->idno)->where('schoolyear',$sy)->first();
                    break;                
                    case 3;
                        $grades = \App\Grade::select('subjecttype','third_grading as grade') ->where('idno',$student->idno)->where('schoolyear',$sy)->where('isdisplaycard',1)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
                        $ranking = \App\Ranking::select('acad_3 as acad','tech_3 as tech')->where('idno',$student->idno)->where('schoolyear',$sy)->first();
                    break;
                    case 4;
                        $grades = \App\Grade::select('subjecttype','fourth_grading as grade')->where('idno',$student->idno)->where('schoolyear',$sy)->where('isdisplaycard',1)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
                        $ranking = \App\Ranking::select('acad_4 as acad','tech_4 as tech')->where('idno',$student->idno)->where('schoolyear',$sy)->first();
                    break;                
                }
                if($grades->isEmpty()){}
                else{
                foreach($grades as $grade){
                    if($grade->subjecttype == 0){
                        if(Input::get('level') == 'Grade 11' || Input::get('department') == 'Junior High School'){
                        $data = $data."<td style='text-align:center;'>".round($grade->grade,0)."</td>";
                        }else{
                            $data = $data."<td style='text-align:center;'>".number_format(round($grade->grade,2),2)."</td>";
                            
                        }
                        
                    }
                }
                if($subjects[0]->subjecttype == 0){
                    if(Input::get('level') == 'Grade 11' || Input::get('department') == 'Junior High School'){
                        $data = $data."<td style='text-align:center;font-weight: bold;'>".round($this->calcGrade(0,(int)Input::get('quarter'),$student->idno,$sy),0)."</td>";
                    }else{
                        $data = $data."<td style='text-align:center;font-weight: bold;'>".number_format(round($this->calcGrade(0,(int)Input::get('quarter'),$student->idno,$sy),2),2)."</td>";
                    }
                }
                foreach($grades as $grade){
                    if($grade->subjecttype == 5 || $grade->subjecttype == 6){
                        $data = $data."<td style='text-align:center;'>".round($grade->grade,0)."</td>";
                        
                    }
                }
                
                if(Input::get('department') == 'Senior High School'){
                    $data = $data."<td style='text-align:center;font-weight: bold;'>".round($this->calcSeniorGrade((int)Input::get('quarter'),$student->idno,$sy),0)."</td>";
                }                                
                
                if(is_null($ranking)|| $ranking->acad == 0){
        
                    $data = $data."<td style='text-align:center;'>No rank set</td>";
                    //$data = $data."<td style='text-align:center;'> </td>";
                }else{
                    $data = $data."<td style='text-align:center;'>".$ranking->acad."</td>";
                    //$data = $data."<td style='text-align:center;'> </td>";
                }

                
                


                
                foreach($grades as $grade){
                if($grade->subjecttype == 1){
                $data = $data."<td style='text-align:center;'>".round($grade->grade,0)."</td>";
                }
                }
                if(Input::get('department') == 'Junior High School'){
                $data = $data."<td style='text-align:center;font-weight: bold;'>".round($this->calcGrade(1,(int)Input::get('quarter'),$student->idno,$sy),0)."</td>";
                //$data = $data."<td style='text-align:center;font-weight: bold;'>".(int)Input::get('quarter')."</td>";
                if(is_null($ranking)|| $ranking->tech == 0){
        
                    $data = $data."<td style='text-align:center;'>No rank set</td>";
                    //$data = $data."<td style='text-align:center;'> </td>";
                }else{
                    $data = $data."<td style='text-align:center;'>".$ranking->tech."</td>";
                    //$data = $data."<td style='text-align:center;'> </td>";
                }                
               }
                
                $conduct = 0;
                foreach($grades as $grade){
                    if($grade->subjecttype == 3){
                    $conduct = $conduct+$grade->grade;
                    }
                }
                if(Input::get('department') == 'Senior High School' ||Input::get('department') == 'Junio High School'){
                    $data = $data."<td style='text-align:center;font-weight: bold;'>".round($conduct,0)."</td>";
                }else{
                    $data = $data."<td style='text-align:center;font-weight: bold;'>".number_format(round($conduct,2),2)."</td>";
                    
                }
                
                foreach($grades as $grade){
                if($grade->subjecttype == 2){
                $data = $data."<td style='text-align:center;'>".number_format($grade->grade,1)."</td>";
                }
                }
            }
            $data = $data."<tr>";
                $count++;
            
            }
        $data = $data."</table>";
        
        return $data;
        //return $strand." ".$level." "$section.;
        
    }
    
    function showgradestvet(){
        
        $course = Input::get('course');

        $students = DB::Select("Select statuses.idno,gender,lastname,firstname,middlename,extensionname from users left join statuses on users.idno = statuses.idno where statuses.status= 2 AND statuses.course LIKE '$course' order by gender DESC,lastname ASC,firstname ASC");

        $subjects = \App\CtrSubjects::where('course',$course)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
        $count = 1;
        $schoolyear = \App\CtrRefSchoolyear::first();
        $sy = $schoolyear->schoolyear;
        $data = "";
        
        $data = $data."<table border='1' cellpadding='1' cellspacing='2'>";
        $data = $data."<tr>";
        $data = $data."<td style='width:30px;text-align:center;'>CN</td>";
        $data = $data."<td style='width:310px;text-align:center;'>Student Name</td>";
        
            foreach($subjects as $subj){
                if($subj->subjecttype == 0){
                    $data = $data."<td style='width:50px;text-align:center;'>".$subj->subjectcode."</td>";
                }
            }

            $data = $data."<td style='width:80px;font-weight: bold;text-align:center;'>ACAD GEN AVE</td>";
            
            foreach($subjects as $subj){
                if($subj->subjecttype == 1){
                    $data = $data."<td style='width:50px;text-align:center;'>".$subj->subjectcode."</td>";
                    }
            }

            $data = $data."<td style='width:50px;font-weight: bold;text-align:center;'>TWA</td>";

            
            $data = $data."<td style='width:50px;font-weight: bold;text-align:center;'>GMRC</td>";
            
            foreach($subjects as $subj){
                if($subj->subjecttype == 2){
                $data = $data."<td style='width:50px;text-align:center;'>".$subj->subjectcode."</td>";
                }
            }
            $data = $data."</tr>";

            
            foreach($students as $student){
            $data = $data."<tr>";
            $data = $data."<td style='text-align:center;'>".$count."</td>";
            $data = $data."<td style='font-size: 9pt'>".$student->lastname.", ".$student->firstname." ".$student->middlename." ".$student->extensionname."</td>";

            
            switch (Input::get('quarter')){
                    case 1;
                        $grades = \App\Grade::select('subjecttype','first_grading as grade') ->where('idno',$student->idno)->where('schoolyear',$sy)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
                    break;
                    case 2;
                        $grades = \App\Grade::select('subjecttype','second_grading as grade')->where('idno',$student->idno)->where('schoolyear',$sy)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
                    break;                
                    case 3;
                        $grades = \App\Grade::select('subjecttype','third_grading as grade') ->where('idno',$student->idno)->where('schoolyear',$sy)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
                    break;
                    case 4;
                        $grades = \App\Grade::select('subjecttype','fourth_grading as grade')->where('idno',$student->idno)->where('schoolyear',$sy)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
                    break;                
                }
                
                foreach($grades as $grade){
                    if($grade->subjecttype == 0){
                        $data = $data."<td style='text-align:center;'>".round($grade->grade,0)."</td>";
                        
                    }
                }
                if($subjects[0]->subjecttype == 0){
                $data = $data."<td style='text-align:center;font-weight: bold;'>".$this->calcGrade(0,(int)Input::get('quarter'),$student->idno,$sy)."</td>";
                }

            $data = $data."<tr>";
                $count++;
            
            }
        $data = $data."</table>";
        
        return $data;
        //return $strand." ".$level." "$section.;
        
    }    
    
    public function calcGrade($type,$quarter,$idno,$sy){
            switch ($quarter){
                    case 1;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( first_grading ) / count( idno ) , 2 ) AS average FROM `grades` WHERE subjecttype =$type AND idno = '$idno' AND schoolyear = '$sy' AND isdisplaycard = 1 GROUP BY idno");
                    break;
                    case 2;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( second_grading ) / count( idno ) , 2 ) AS average FROM `grades` WHERE subjecttype =$type AND idno = '$idno' AND schoolyear = '$sy' AND isdisplaycard = 1 GROUP BY idno");
                    break;                
                    case 3;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( third_grading ) / count( idno ) , 2 ) AS average FROM `grades` WHERE subjecttype =$type AND idno = '$idno' AND schoolyear = '$sy' AND isdisplaycard = 1 GROUP BY idno");
                    break;
                    case 4;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( fourth_grading ) / count( idno ) , 2 ) AS average FROM `grades` WHERE subjecttype =$type AND idno = '$idno' AND schoolyear = '$sy' AND isdisplaycard = 1 GROUP BY idno");
                    break;
                }     
                if($averages[0]->weighted == 0){
                    $result = $averages[0]->average;
                }else{
                    $result = $this->calcWeighted($quarter,$idno,$sy);
                    //$result = 0;
                }                
        return $result;
        
    }
    
    public function calcWeighted($quarter,$idno,$sy){
            switch ($quarter){
                    case 1;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( first_grading *(weighted/100))  , 2 ) AS average FROM `grades` WHERE subjecttype =1 AND idno = '$idno' AND schoolyear = '$sy' AND isdisplaycard = 1 GROUP BY idno");
                    break;
                    case 2;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( second_grading *(weighted/100))  , 2 ) AS average FROM `grades` WHERE subjecttype =1 AND idno = '$idno' AND schoolyear = '$sy' AND isdisplaycard = 1 GROUP BY idno");
                    break;                
                    case 3;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( third_grading *(weighted/100))  , 2 ) AS average FROM `grades` WHERE subjecttype =1 AND idno = '$idno' AND schoolyear = '$sy' AND isdisplaycard = 1 GROUP BY idno");
                    break;
                    case 4;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( fourth_grading *(weighted/100))  , 2 ) AS average FROM `grades` WHERE subjecttype =1 AND idno = '$idno' AND schoolyear = '$sy' AND isdisplaycard = 1 GROUP BY idno");
                    break;                
                }    
                /*$result = $averages[0]->average;
                if($averages[0]->average == 0){
                    $result = 0;
                }*/
        //$averages = DB::Select("SELECT weighted,ROUND( SUM( first_grading *(weighted/100))  , 0 ) AS average FROM `grades` WHERE subjecttype =1 AND idno = '$idno' AND schoolyear = '$sy' GROUP BY idno");
        $result = $averages[0]->average;
        return $result;
        
    }    
    
    public function calcSeniorGrade($quarter,$idno,$sy){
            switch ($quarter){
                    case 1;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( first_grading ) / count( idno ) , 0 ) AS average FROM `grades` WHERE subjecttype IN(5,6) AND idno = '$idno' AND schoolyear = '$sy' GROUP BY idno");
                    break;
                    case 2;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( second_grading ) / count( idno ) , 0 ) AS average FROM `grades` WHERE subjecttype IN(5,6) AND idno = '$idno' AND schoolyear = '$sy' GROUP BY idno");
                    break;                
                    case 3;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( third_grading ) / count( idno ) , 0 ) AS average FROM `grades` WHERE subjecttype IN(5,6) AND idno = '$idno' AND schoolyear = '$sy' GROUP BY idno");
                    break;
                    case 4;
                        $averages = DB::Select("SELECT weighted,ROUND( SUM( fourth_grading ) / count( idno ) , 0 ) AS average FROM `grades` WHERE subjecttype IN(5,6) AND idno = '$idno' AND schoolyear = '$sy' GROUP BY idno");
                    break;
                }     
                if($averages[0]->weighted == 0){
                    $result = $averages[0]->average;
                }else{
                    $result = $this->calcWeighted($quarter,$idno,$sy);
                    //$result = 0;
                }                
        return $result;
        
    }
    
    function setRankingAcad(){
        $section = Input::get('section');
        $level = Input::get('level');
        $quarter = Input::get('quarter');
        
        $schoolyear = \App\CtrRefSchoolyear::first();
        
        switch ($quarter){
            case 1;
                
                $averages = DB::Select("SELECT grades.idno,ROUND( SUM( first_grading ) / count( grades.idno ) ,2) AS average FROM `grades` left join statuses on statuses.idno = grades.idno WHERE subjecttype =0 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear->schoolyear' AND isdisplaycard = 1 GROUP BY idno ORDER BY `average` DESC");
            break;
            case 2;
                $averages = DB::Select("SELECT grades.idno,ROUND( SUM( second_grading ) / count( grades.idno ) ,2) AS average FROM `grades` left join statuses on statuses.idno = grades.idno WHERE subjecttype =0 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear->schoolyear' AND isdisplaycard = 1 GROUP BY idno ORDER BY `average` DESC");
            break;                
           case 3;
                $averages = DB::Select("SELECT grades.idno,ROUND( SUM( third_grading ) / count( grades.idno ) ,2) AS average FROM `grades` left join statuses on statuses.idno = grades.idno WHERE subjecttype =0 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear->schoolyear' AND isdisplaycard = 1 GROUP BY idno ORDER BY `average` DESC");
            break;
            case 4;
                $averages = DB::Select("SELECT grades.idno,ROUND( SUM( fourth_grading ) / count( grades.idno ) ,2) AS average FROM `grades` left join statuses on statuses.idno = grades.idno WHERE subjecttype =0 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear->schoolyear' AND isdisplaycard = 1 GROUP BY idno ORDER BY `average` DESC");
           break; 
        }
        $ranking = 0;
        $comparison = 0;
        
        $nextrank = 1;
        foreach($averages as $average){
            
            
            $check = \App\Ranking::where('idno',$average->idno)->where('schoolyear',$schoolyear->schoolyear)->get();
            
            if($comparison != $average->average){
                $ranking = $nextrank;
                
                $comparison = $average->average;
            }
            elseif($average->average == 0){
                $ranking = 0;
            } 
            
            
            
            if ($check->isEmpty()) { 
                $rank = new \App\Ranking();
            }else{
                $rank = \App\Ranking::where('idno',$average->idno)->where('schoolyear',$schoolyear->schoolyear)->first();
            }
            
            if($check->isEmpty()){
                $rank->idno = $average->idno;
            }
                switch ($quarter){
                  case 1;
                        $rank->acad_1 = $ranking;
                break;
                    case 2;
                        $rank->acad_2 = $ranking;
                    break;                
                   case 3;
                        $rank->acad_3 = $ranking;
                    break;
                    case 4;
                        $rank->acad_4 = $ranking;
                   break;            
               
                }
            $rank->schoolyear =   $schoolyear->schoolyear;  
            $rank->save();
            $nextrank++;
        }
        
        return $level;
    }
    
        function setRankingTech(){
        $section = Input::get('section');
        $level = Input::get('level');
        $quarter = Input::get('quarter');
        $strand = Input::get('strand');
        
        
        
        $schoolyear = \App\CtrRefSchoolyear::first();
        
        switch ($quarter){
            case 1;
                //$averages = DB::Select("SELECT idno,weighted, ROUND( SUM( first_grading ) / count( idno ) , 0 ) AS average FROM `grades` WHERE subjecttype =0 AND level = '$level' AND section LIKE '$section' AND schoolyear = '$schoolyear->schoolyear' GROUP BY idno ORDER BY `average` DESC");
                $averages = DB::Select("SELECT grades.idno,weighted, ROUND( SUM( first_grading ) / count( grades.idno ) , 2 ) AS average FROM `grades` left join statuses on statuses.idno = grades.idno WHERE subjecttype =1 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear->schoolyear' AND statuses.strand = '$strand' GROUP BY idno ORDER BY `average` DESC");
            break;
            case 2;
                $averages = DB::Select("SELECT grades.idno,weighted, ROUND( SUM( second_grading ) / count( grades.idno ) , 2 ) AS average FROM `grades` left join statuses on statuses.idno = grades.idno WHERE subjecttype =1 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear->schoolyear' AND statuses.strand = '$strand' GROUP BY idno ORDER BY `average` DESC");
            break;                
           case 3;
                $averages = DB::Select("SELECT grades.idno,weighted, ROUND( SUM( third_grading ) / count( grades.idno ) , 2 ) AS average FROM `grades` left join statuses on statuses.idno = grades.idno WHERE subjecttype =1 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear->schoolyear' AND statuses.strand = '$strand' GROUP BY idno ORDER BY `average` DESC");
            break;
            case 4;
                $averages = DB::Select("SELECT grades.idno,weighted, ROUND( SUM( fourth_grading ) / count( grades.idno ) , 2 ) AS average FROM `grades` left join statuses on statuses.idno = grades.idno WHERE subjecttype =1 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear->schoolyear' AND statuses.strand = '$strand' GROUP BY idno ORDER BY `average` DESC");
           break;                
        }
                if($averages[0]->weighted != 0){
                    $averages = $this->weightedRank($quarter,$schoolyear->schoolyear,$strand,$level,$section);
                }
                
        $ranking = 0;
        $comparison = 0;
        $nextrank = 1;
        foreach($averages as $average){
            $check = \App\Ranking::where('idno',$average->idno)->where('schoolyear',$schoolyear->schoolyear)->get();
                
            if($comparison != $average->average){
                $ranking=$nextrank;
                //$ranking++;
                $comparison = $average->average;
            }
            elseif($average->average == 0){
                $ranking = 0;
            } 
            
            
            
            if ($check->isEmpty()) { 
                $rank = new \App\Ranking();
            }else{
                $rank = \App\Ranking::where('idno',$average->idno)->where('schoolyear',$schoolyear->schoolyear)->first();
            }
            
            if($check->isEmpty()){
                $rank->idno = $average->idno;
            }
                switch ($quarter){
                  case 1;
                        $rank->tech_1 = $ranking;
                break;
                    case 2;
                        $rank->tech_2 = $ranking;
                    break;                
                   case 3;
                        $rank->tech_3 = $ranking;
                    break;
                    case 4;
                        $rank->tech_4 = $ranking;
                   break;            
                   
                }
            $rank->schoolyear =   $schoolyear->schoolyear;  
            $rank->save();
            $nextrank++;
        }
        
        return $level;
    }
    
        public function weightedRank($quarter,$schoolyear,$strand,$level,$section){
            switch ($quarter){
                    case 1;
                        $averages = DB::Select("SELECT grades.idno,weighted,ROUND( SUM( first_grading *(weighted/100))  , 0 ) AS average FROM `grades` join statuses on statuses.idno = grades.idno WHERE  subjecttype =1 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear' AND statuses.strand = '$strand' GROUP BY idno ORDER BY `average` DESC");
                    break;
                    case 2;
                        $averages = DB::Select("SELECT grades.idno,weighted,ROUND( SUM( second_grading *(weighted/100))  , 0 ) AS average FROM `grades` join statuses on statuses.idno = grades.idno WHERE subjecttype =1 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear' AND statuses.strand = '$strand' GROUP BY idno ORDER BY `average` DESC");
                    break;                
                    case 3;
                        $averages = DB::Select("SELECT grades.idno,weighted,ROUND( SUM( third_grading *(weighted/100))  , 0 ) AS average FROM `grades` join statuses on statuses.idno = grades.idno WHERE subjecttype =1 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear' AND statuses.strand = '$strand' GROUP BY idno ORDER BY `average` DESC");
                    break;
                    case 4;
                        $averages = DB::Select("SELECT grades.idno,weighted,ROUND( SUM( fourth_grading *(weighted/100))  , 0 ) AS average FROM `grades` join statuses on statuses.idno = grades.idno WHERE subjecttype =1 AND grades.level = '$level' AND statuses.section LIKE '$section' AND grades.schoolyear = '$schoolyear' AND statuses.strand = '$strand' GROUP BY idno ORDER BY `average` DESC");
                    break;                
                }    


        return $averages;
        
    }    
    
    function getstrand($level){
        if(Request::ajax()){
            $strands = DB::Select("select distinct strand from ctr_sections where level = '$level'");
            
            $data = "<div class=\"form form-group\"><label for=\"strand\">Select Shop/Strand</label>";
            $data=$data. "<Select name =\"strand\" id=\"strand\" class=\"form form-control\" onchange=\"getstrandall(this.value)\" >";
            $data=$data. "<option>--Select--</option>";
                foreach($strands as $strand){
                    $data = $data . "<option value=\"". $strand->strand . "\">" . $strand->strand . "</option>";       
                }
            $data = $data . "</select></div>"; 
            return $data;
        //    return data;
        }
    }  
    
    function getsection($level){
        if(Request::ajax()){
            $strand = Input::get("strand");
                $sections = DB::Select("select  distinct section from statuses where level = '$level' and strand = '$strand'");

               $data = "";
               $data = $data . "<div class=\"col-md-6\"><label for=\"section\">Select Section</label><select id=\"section\" onchange=\"genSubj()\" class=\"form form-control\">";
             $data = $data . "<option>--Select--</option>";
               foreach($sections as $section){
                  $data = $data . "<option value= '". $section->section ."'>" .$section->section . "</option>";  
                }
               $data = $data."</select></div>";
            return $data;   
            //return $level;
        }
    }  
    function getsubjects($level){
        if(Request::ajax()){
            $strand = Input::get("strand");

                $subjects = DB::Select("select  distinct subjectname as subject,subjectcode from grades where level = '$level' and strand = '$strand' and section != ''  and subjecttype IN (0,1,5,6) ORDER BY subjecttype asc, sortto asc");

            
               $data = "";
               $data = $data . "<div class=\"col-md-6\"><label for=\"section\">Select Subject</label><select id=\"subject\" onchange=\"showbtn()\" class=\"form form-control\">";
             $data = $data . "<option>--Select--</option>";
             $data = $data . "<option value= 'All'>All</option>";  
               foreach($subjects as $subject){
                  $data = $data . "<option value= '". $subject->subjectcode ."'>" .$subject->subject . "</option>";  
                }
                
               $data = $data."</select></div>";
            return $data;   
            //return $level;
        }
    }      
    function getsection1($level){
        if(Request::ajax()){  
          $sections = DB::Select("select  distinct section from ctr_sections where level = '$level'");
               $data = "";
               $data = $data . "<label for=\"section\">Select Section</label><select id=\"section\" onchange=\"showqtr()\" class=\"form form-control\">";
             $data = $data . "<option>--Select--</option>";
               foreach($sections as $section){
                  $data = $data . "<option value= '". $section->section ."'>" .$section->section . "</option>";  
                }
               $data = $data."</select>";
            return $data;   
            //return $level;
        }
    }
    
    function getadviser(){
        $lvl = Input::get('level');
        $sec = Input::get('section');
        
        $dept=Input::get('department');
        //$strand = '';
        if( is_null(Input::get('strand'))){
            $adviser = \App\CtrSection::where('level',$lvl)->where('section',$sec)->first();
        }else{
            $adviser = \App\CtrSection::where('level',$lvl)->where('strand',Input::get('strand'))->where('section',$sec)->first();
        }        
        
        
        
        if(isset($adviser->adviser)){
        $data = $adviser->adviser;
        }
        else{
            $data = "NONE";
        }
        return $data;
    }
    
    function getdos(){
        $qtr = Input::get('quarter');
        switch ($qtr){
            case 1;
                //$averages = DB::Select("SELECT idno,weighted, ROUND( SUM( first_grading ) / count( idno ) , 0 ) AS average FROM `grades` WHERE subjecttype =0 AND level = '$level' AND section LIKE '$section' AND schoolyear = '$schoolyear->schoolyear' GROUP BY idno ORDER BY `average` DESC");
                $averages = DB::Select("SELECT sum(first_grading) as grade FROM `grades` where subjectcode IN ('DAYP','DAYA') group by idno ORDER BY grade  DESC");
            break;
            case 2;
                $averages = DB::Select("SELECT sum(second_grading) as grade FROM `grades` where subjectcode IN ('DAYP','DAYA') group by idno ORDER BY grade  DESC");
            break;                
           case 3;
                $averages = DB::Select("SELECT sum(third_grading) as grade FROM `grades` where subjectcode IN ('DAYP','DAYA') group by idno ORDER BY grade  DESC");
            break;
            case 4;
                $averages = DB::Select("SELECT sum(fourth_grading) as grade FROM `grades` where subjectcode IN ('DAYP','DAYA') group by idno ORDER BY grade  DESC");
           break;                
        }
        
        $data = number_format($averages[0]->grade,1);
        
        return $data;
    }
        
}
