<table border='1' cellpadding='1' cellspacing='2' width='100%'>
    <?php 
        use App\Http\Controllers\Vincent\AjaxController;
        
        $schoolyear = App\ctrSchoolYear::where('department',$department)->first();
    
        if($department == 'Senior High School' && ($quarters == 1 ||$quarters == 2)){
            $subjects = App\Grade::where('level',$level)->where('strand',$strand)->whereIn('semester',array(1,0))->where('schoolyear',$sy)->where('isdisplaycard',1)->groupBy('subjectcode')->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
        }
        elseif($department == 'Senior High School' && ($quarters == 3 ||$quarters == 4)){
            $subjects = App\Grade::where('level',$level)->where('strand',$strand)->whereIn('semester',array(2,0))->where('schoolyear',$sy)->where('isdisplaycard',1)->groupBy('subjectcode')->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
        }else{
            $subjects = App\Grade::where('level',$level)->groupBy('subjectcode')->where('isdisplaycard',1)->where('schoolyear',$sy)->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->get();
        }
    ?>
    <tr>
        <thead>
            <td style='width:50px;text-align:center;'>CN</td>
            <td style='width:400px;text-align:center;'>Student Name</td>
            @foreach($subjects as $subject)
                @if($subject->subjecttype == 0)
                    <td style='width:50px;text-align:center;'>{{$subject->subjectcode}}</td>
                @endif
                
                @if($subject->subjecttype == 5 | $subject->subjecttype == 6)
                    <td style='width:50px;text-align:center;'>{{$subject->subjectcode}}</td>
                @endif
            @endforeach
            
            <td style='width:80px;font-weight: bold;text-align:center;'>ACAD GEN AVE</td>
            <td style='width:50px;font-weight: bold;text-align:center;'>
                @if($schoolyear->schoolyear == $sy)
                <button class='btn btn-default' onclick="setAcadRank('{{$section}}','{{$level}}',{{$quarters}})">RANK</button>
                @else
                RANK
                @endif
            </td>
            
            @foreach($subjects as $subject)
                @if($subject->subjecttype == 1)
                    <td style='width:50px;text-align:center;'>{{$subject->subjectcode}}</td>
                @endif
            @endforeach
            
            @if($department == 'Junior High School')
            <td style='width:50px;font-weight: bold;text-align:center;'>TWA</td>
            <td style='width:50px;font-weight: bold;text-align:center;'>
                @if($schoolyear->schoolyear == $sy)
                <button class='btn btn-default' onclick="setTechRank()" >TECH<br>RANK</button></td>
                @else
                TECH<br>RANK
                @endif
            @endif
            
            <td style='width:50px;font-weight: bold;text-align:center;'>GMRC</td>
            <td style='width:50px;text-align:center;'>DAYP</td>
            <td style='width:50px;text-align:center;'>DAYA</td>
            <td style='width:50px;text-align:center;'>DAYT</td>
        </thead>
    </tr>
    @foreach($students as $student)
    <tr>
        <td style='text-align: center'>{{$student->class_no}}</td>
        <td>{{$student->lastname}}, {{$student->firstname}} {{$student->middlename}}
            @if($student->status == 3)
            <span style='float:right;color:red'>DROPPED</span>
            @endif
        </td>
    <?php 
    switch($quarters){
        case 1;
            $grades = App\Grade::select('subjecttype','first_grading as grade') ->where('idno',$student->idno)->where('schoolyear',$sy)->where('isdisplaycard',1)->whereIn('semester',array(1,0))->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->where('schoolyear',$sy)->get();
            $ranking = App\Ranking::select('acad_1 as acad','tech_1 as tech')->where('idno',$student->idno)->where('schoolyear',$sy)->first();
        break;
        case 2;
            $grades = App\Grade::select('subjecttype','second_grading as grade') ->where('idno',$student->idno)->where('schoolyear',$sy)->where('isdisplaycard',1)->whereIn('semester',array(1,0))->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->where('schoolyear',$sy)->get();
            $ranking = App\Ranking::select('acad_2 as acad','tech_2 as tech')->where('idno',$student->idno)->where('schoolyear',$sy)->first();
        break;
        case 3;
            $grades = App\Grade::select('subjecttype','third_grading as grade') ->where('idno',$student->idno)->where('schoolyear',$sy)->where('isdisplaycard',1)->whereIn('semester',array(2,0))->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->where('schoolyear',$sy)->get();
            $ranking = App\Ranking::select('acad_3 as acad','tech_3 as tech')->where('idno',$student->idno)->where('schoolyear',$sy)->first();
        break;
        case 4;
            $grades = App\Grade::select('subjecttype','fourth_grading as grade') ->where('idno',$student->idno)->where('schoolyear',$sy)->where('isdisplaycard',1)->whereIn('semester',array(2,0))->orderBy('subjecttype','ASC')->orderBy('sortto','ASC')->where('schoolyear',$sy)->get();
            $ranking = App\Ranking::select('acad_4 as acad','tech_4 as tech')->where('idno',$student->idno)->where('schoolyear',$sy)->first();
        break;
    }
    $acadfinal = 0;
    $count = 0;
    ?>
    @if($grades->count() > 0)
        @foreach($grades as $grade)
            @if($grade->subjecttype == 0)
                <td style='text-align:center;'>@if($grade->grade != 0){{round($grade->grade,0)}}@endif</td>
                <?php 
                $acadfinal = $acadfinal+$grade->grade;
                $count++;
                ?>
            @elseif($grade->subjecttype == 5 || $grade->subjecttype == 6)
                <td style='text-align:center;'>@if($grade->grade != 0){{round($grade->grade,0)}}@endif</td>
                <?php 
                $acadfinal = $acadfinal+$grade->grade;
                $count++;
                ?>
            @endif
        @endforeach
    @else
        @foreach($subjects as $subj)
        <td style='text-align:center;'></td>
        @endforeach
    @endif
    
    <td style='text-align:center;font-weight: bold;'>
    @if($acadfinal > 0)
        @if($department == 'Junior High School')
        {{round($acadfinal/$count,0)}}
        @else
        {{round($acadfinal/$count,2)}}
        @endif
    @endif
    </td>
    
    <td style='text-align:center;'>
    @if(is_null($ranking)|| $ranking->acad == 0)
        No rank set
    @else
        {{$ranking->acad}}
    @endif
    </td>
    
    @if($grades->count() > 0)
        @foreach($grades as $grade)
            @if($grade->subjecttype == 1)
                <td style='text-align:center;'>@if($grade->grade != 0){{round($grade->grade,0)}}@endif</td>
            @endif
        @endforeach
    @else
        @foreach($subjects as $subj)
        <td style='text-align:center;'></td>
        @endforeach
    @endif
    

    
    @if($department == 'Junior High School')
    <?php 
    $tech = AjaxController::calcGrade(1,$quarters,$student->idno,$sy);
    ?>
    <td style='text-align:center;font-weight: bold;'>{{round($tech,0)}}</td>
    <td style='text-align:center;'>
        @if(is_null($ranking)|| $ranking->tech == 0)
            No rank set
        @else
        {{$ranking->tech}}
            @endif
    </td>
    @endif
    
    <?php
    $conduct = 0;
    foreach($grades as $grade){
        if($grade->subjecttype == 3){
        $conduct = $conduct+$grade->grade;
        }
    }
    ?>
    <td style='text-align:center;font-weight: bold;'>{{round($conduct,0)}}</td>
    <?php 
    $attend = AjaxController::getAttendance($level,$quarters,$student->idno,$sy);
    ?>
    <td style='text-align:center;font-weight: bold;'>{{number_format($attend[1],1)}}</td>
    <td style='text-align:center;font-weight: bold;'>{{number_format($attend[2],1)}}</td>
    <td style='text-align:center;font-weight: bold;'>{{number_format($attend[0],1)}}</td>
    </tr>
    @endforeach
</table>