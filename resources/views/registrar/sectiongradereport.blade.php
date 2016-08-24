
<html>
    <head>
        <style type='text/css'>
            
           table tr td{
            font-size:11pt;
            padding-left: 10px;
           }
           
           body{
            font-family: calibri;
            margin-left: auto;    
            }
        </style>    
        
        <style type="text/css" media="print">
                       body{
                font-family: calibri;
                margin-left: auto;
                margin-right: none;
            }
        </style>
        <link href="{{ asset('/css/print.css') }}" rel="stylesheet">
    </head>
    <body style="width:16.6cm">
        @foreach($collection as $info)
        <table class="parent" width="100%" style="padding:10px;margin-left: auto;margin-right: auto;margin-top: .8cm;margin-bottom: .8cm;">
            <thead>
            <tr>
                <td style="padding-left: 0px;">
                    <table class="head" width="100%" border="0" cellpadding="0" cellspacing="0" align="right">

                    <tr>
                        <td rowspan="4" style="text-align: right;padding-left: 0px;" class="logo" width="55px">
                            <img src="{{asset('images/logo.png')}}"  style="display: inline-block;width:70px">
                        </td>
                        <td style="padding-left: 0px;">
                            <span style="font-size:11pt; font-weight: bold">Don Bosco Technical Institute of Makati, Inc. </span>
                        </td>
                    </tr>
                    <tr><td style="font-size:9pt;padding-left: 0px;">Chino Roces Ave., Makati City </td></tr>
                    <tr><td style="font-size:9pt;padding-left: 0px;">PAASCU Accredited</td></tr>
                    <tr><td style="font-size:9pt;padding-left: 0px;">School Year {{$schoolyear->schoolyear}} - {{intval($schoolyear->schoolyear)+1}}</td></tr>
                    <tr><td style="font-size:4pt;padding-left: 0px;">&nbsp; </td></tr>
                    <tr><td><span style="font-size:5px"></td></tr>
                    <tr>
                        <td colspan="2">
                    <div style="text-align: center;font-size:9pt;"><b>STUDENT PROGRESS REPORT CARD</b></div>
                    <div style="text-align: center;font-size:9pt;"><b>GRADE SCHOOL DEPARTMENT</b></div>

                        </td>
                    </tr>
                    <tr><td style="font-size:3px"><br></td></tr>
                    </table>
                </td>
            </tr>
            </thead>
            <tr>
                <td style="padding-left: 0px;">
                    <table class="head" width="100%" border = '0' cellpacing="0" cellpadding = "0">
                        <tr>
                            <td width="12%" style="font-size:10pt;padding-left: 0px;">
                                <b>Name:</b>
                            </td>
                            <td width="53%" style="font-size:10pt;padding-left: 0px;">
                                {{$info['info']->lastname}}, {{$info['info']->firstname}} {{$info['info']->middlename}} {{$info['info']->extensionname}}
                            </td>
                            <td width="12%" style="font-size:10pt;padding-left: 0px;">
                                <b>Student No:</b>
                            </td>
                            <td width="23%" style="font-size:10pt;padding-left: 0px;">
                                {{$info['info']->idno}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:10pt;padding-left: 0px;">
                                <b>Gr. and Sec:</b>
                            </td>
                            <td style="font-size:10pt;padding-left: 0px;">
                                {{$level}} - {{$section}}
                            </td>
                            <td style="font-size:10pt;padding-left: 0px;">
                                <b>Class No:</b>
                            </td>
                            <td style="font-size:10pt;padding-left: 0px;">
                                {{$info['info']->class_no}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:10pt;padding-left: 0px;">
                                <b>Adviser:</b>
                            </td>
                            <td style="font-size:10pt;padding-left: 0px;">
                                @if($teacher != null)
                                {{$teacher->adviser}}
                                @endif
                            </td>
                            <td style="font-size:10pt;padding-left: 0px;"  >
                                <b>LRN:</b>
                            </td>
                            <td style="font-size:10pt;padding-left: 0px;">
                                {{$info['info']->lrn}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 0px;">
                @if(sizeOf($info['aca'])!= 0)
                <table border = '1' cellspacing="0" cellpadding = "0" width="100%" class="reports">
                    <tr style="font-weight: bold;text-align:center;">
                        <td width="35%" style="padding: 15px 0 15px 0;">SUBJECTS</td>
                        <td width="10%">1</td>
                        <td width="10%">2</td>
                        <td width="10%">3</td>
                        <td width="10%">4</td>
                        <td width="12%">FINAL RATING</td>
                        <td width="13%">REMARKS</td>
                    </tr>
                    {{--*/$first=0/*--}}
                    {{--*/$second=0/*--}}
                    {{--*/$third=0/*--}}
                    {{--*/$fourth=0/*--}}
                    {{--*/$final=0/*--}}
                    {{--*/$count=0/*--}}
                    @foreach($info['aca'] as $key=>$academics)
                    <tr style="text-align: center;font-size: 8pt;">
                        <td style="text-align: left">
                            {{ucwords(strtolower($academics->subjectname))}}
                        </td>
                        <td>
                            {{round($academics->first_grading,2)}}
                            {{--*/$first = $first + round($academics->first_grading,2)/*--}}
                        </td>
                        <td>
                            {{round($academics->second_grading,2)}}
                            {{--*/$second = $second + round($academics->second_grading,2)/*--}}
                        </td >
                        <td>
                            {{round($academics->third_grading,2)}}
                            {{--*/$third = $third + round($academics->third_grading,2)/*--}}
                        </td>
                        <td>
                            {{round($academics->fourth_grading,2)}}
                            {{--*/$fourth = $fourth + round($academics->fourth_grading,2)/*--}}
                        </td>
                        <td>
                            {{round($academics->final_grade,2)}}
                            {{--*/$final = $final + round($academics->final_grade,2)/*--}}
                        </td>
                        <td>
                            {{$academics->remarks}}
                            {{--*/$count ++/*--}}
                        </td>                         
                    </tr>
                    @endforeach
                    <tr style="text-align: center">
                        <td style="text-align: right;">
                            <b>GENERAL AVERAGE</b>
                        </td>
                        <td>
                            {{round($first/$count,2)}}
                        </td>
                        <td>{{round($second/$count,2)}}
                        </td>
                        <td>
                            {{round($third/$count,2)}}
                        </td>
                        <td>
                            {{round($fourth/$count,2)}}
                        </td>
                        <td>
                            {{round($final/$count,2)}}
                        </td>

                        <td>
                        @if((round($final/$count,2)) != 0)
                        {{round($final/$count,2) >= 75 ? "Passed":"Failed"}}
                        @endif
                        </td>
                        
                    </tr>
                </table>
                @endif                    
                </td>
            </tr>
            <tr><td style="padding-left: 0px;"><span style="height:10pt"></td></tr>
            <tr>
                <td style="padding-left: 0px;">
                    <table border = '1' cellspacing="0" cellpadding = "0" width="100%" style="text-align: center;font-size: 12px;">
                        <tr style="font-weight:bold;">
                            <td width="36%" class="descriptors">
                                DESCRIPTOR
                            </td>
                            <td width="32%" class="scale">
                                GRADING SCALE
                            </td>            
                            <td width="32%" class="remarks">
                                REMARKS
                            </td>                        
                        </tr>
                        <tr>
                            <td>Outstanding</td><td>90 - 100</td><td>Passed</td>
                        </tr>
                        <tr>
                            <td>Very Satisfactory</td><td>85 - 89</td><td>Passed</td>
                        </tr>
                        <tr>
                            <td>Satisfactory</td><td>80 - 84</td><td>Passed</td>
                        </tr>
                        <tr>
                            <td>Fairly Satisfactory</td><td>75 - 79</td><td>Passed</td>
                        </tr>
                        <tr>
                            <td>Did Not Meet Expectations</td><td>Below 75</td><td>Failed</td>
                        </tr>
                    </table>                    
                </td>
            </tr>
            <tr>
                <td style="padding-left: 0px;">
                    <table border = '1' cellspacing="0" cellpadding = "0" width="100%" style="text-align: center;font-size: 12px;">
                    <tr>
                        <td style="font-weight: bold">
                            CHRISTIAN LIVING DESCRIPTORS
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="50%" style="font-weight: bold">
                            LEVEL OF "FRIENDSHIP WITH JESUS"
                        </td>
                        <td style="font-weight: bold">
                            GRADING SCALE
                        </td>
                    </tr>
                    <tr>
                        <td>Best Friend of Jesus</td>
                        <td>95 - 100</td>
                    </tr>
                    <tr>
                        <td>Loyal Friend of Jesus</td>
                        <td>89 - 94</td>
                    </tr>     
                    <tr>
                        <td>Trustworthy Friend of Jesus</td>
                        <td>83 - 88</td>
                    </tr>
                    <tr>
                        <td>Good Friend of Jesus</td>
                        <td>77 - 82</td>
                    </tr>     
                    <tr>
                        <td>Common Friend of Jesus</td>
                        <td>76 and Below</td>
                    </tr>                    
                </table>
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        @endforeach
        
        







        @foreach($collection as $info)
        <h1>&nbsp;</h1>
        <table class="parent" width="100%" style="padding:10px;margin-left: auto;margin-right: auto;margin-top: .8cm;margin-bottom: .8cm;">
        <tr>
            <td colspan="2" style="padding-left: 0px;">
                <table border = '1' cellspacing="0" cellpadding = "0" width="100%" style="text-align: center;font-size: 11pt;">
                    <tr>
                        <td width="30%">CONDUCT CRITERIA</td>
                        <td width="10%">Points</td>
                        <td width="10%">1</td>
                        <td width="10%">2</td>
                        <td width="10%">3</td>
                        <td width="10%">4</td>
                        <td width="20%" rowspan="{{count($info['con'])}}"></td>
                    </tr>
                        {{--*/$first=0/*--}}
                        {{--*/$second=0/*--}}
                        {{--*/$third=0/*--}}
                        {{--*/$fourth=0/*--}}
                        {{--*/$counter = 0/*--}}
                        {{--*/$length = count($info['con'])/*--}}
                        @foreach($info['con'] as $key=>$conducts)
                        {{--*/$counter ++/*--}}                    
                    <tr>
                        <td style="text-align: left">{{$conducts->subjectname}}</td>
                        <td>{{$conducts->points}}</td>
                        <td>
                            {{round($conducts->first_grading,2)}}
                            {{--*/$first = $first + round($conducts->first_grading,2)/*--}}
                        </td>
                        <td>
                            {{round($conducts->second_grading,2)}}
                            {{--*/$second = $second + round($conducts->second_grading,2)/*--}}
                        </td>
                        <td>
                            {{round($conducts->third_grading,2)}}
                            {{--*/$third = $third + round($conducts->third_grading,2)/*--}}
                        </td>
                        <td>
                            {{round($conducts->fourth_grading,2)}}
                            {{--*/$fourth = $fourth + round($conducts->fourth_grading,2)/*--}}
                        </td>
                        @if($length == $counter)
                        <td>FINAL GRADE</td>
                        @endif
                        

                    </tr>
                        @endforeach                    
                        <tr>
                            <td>CONDUCT GRADE</td>
                            <td>100</td>
                            <td>{{$first}}</td>
                            <td> {{$second}}</td>
                            <td>{{$third}}</td>
                            <td>{{$fourth}}</td>
                            <td>{{round(($first+$second+$third+$fourth)/4,2)}}</td>
                            
                        </tr>
                </table>
                <br>
                <table border="1" cellspacing="0" cellpading="0" style="font-size:12px;text-align: center" width="100%">
                    <tr>
                        <td width="40%"><b>ATTENDANCE</b></td>
                        <td width="10%"><b>1</b></td>
                        <td width="10%"><b>2</b></td>
                        <td width="10%"><b>3</b></td>
                        <td width="10%"><b>4</b></td>
                        <td width="20%"><b>TOTAL</b></td>
                    </tr>
                    <tr>
                        <td>
                            Days of School
                        </td>
                        {{--*/$first=0/*--}}
                        {{--*/$second=0/*--}}
                        {{--*/$third=0/*--}}
                        {{--*/$fourth=0/*--}}
                            @foreach($info['att'] as $key=>$attend)
                                {{--*/$first = $first + $attend->first_grading/*--}}
                                {{--*/$second = $second + $attend->second_grading/*--}}
                                {{--*/$third = $third + $attend->third_grading/*--}}
                                {{--*/$fourth = $fourth + $attend->fourth_grading/*--}}
                            @endforeach
                        <td>

                            {{$first}}
                        </td>
                        <td>
                            {{$second}}
                        </td>
                        <td>
                            {{$third}}
                        </td>                                                    
                        <td>
                            {{$fourth}}
                        </td>
                        <td>
                            {{$first+$second+$third+$fourth}}
                        </td>                                                   
                    </tr>
                    @foreach($info['att'] as $key=>$attend)
                    <tr>
                        <td>
                            {{$attend->subjectname}}
                        </td>
                        <td>
                            {{round($attend->first_grading,0)}}
                        </td>
                        <td>
                            {{round($attend->second_grading,0)}}
                        </td>
                        <td>
                            {{round($attend->third_grading,0)}}
                        </td>
                        <td>
                            {{round($attend->fourth_grading,0)}}
                        </td>
                        <td>
                            {{round($attend->first_grading,0)+round($attend->second_grading,0)+round($attend->third_grading,0)+round($attend->fourth_grading,0)}}
                        </td>                                                    
                    </tr>
                    @endforeach
                </table>
                <br>
                <table width="100%">
                    <tr>
                        <td class="print-size"  width="49%">
                            <b>Certificate of eligibility for promotion</b>
                        </td>
                        <td class="print-size" >
                            <b>Cancellation of Eligibility to Transfer</b>
                        </td>                                                    
                    </tr>
                    <tr>
                        <td class="print-size" >
                            The student is eligible for transfer and
                        </td>
                        <td class="print-size" >
                            Admitted in:____________________________
                        </td>                                                    
                    </tr>
                    <tr>
                        <td class="print-size" >Admission to:___________________________</td>
                        <td class="print-size" >Grade:_________   Date:__________________</td>                                                    
                    </tr>
                    <tr>
                        <td class="print-size" >Date of Issue:__________________________</td>
                        <td></td>                                                    
                    </tr>
                    <tr>
                        <td colspan="2"><br><br><br></td>                                                    
                    </tr>
                                                                    <tr style="text-align: center">
                        <td class="print-size">________________________________</td>
                        <td class="print-size">________________________________</td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="print-size" >
                           @if($teacher != null)
                            {{$teacher->adviser}}
                           @endif
                        </td>
                        <td class="print-size" >Principal Name</td>
                    </tr>
                    <tr style="text-align: center">
                        <td class="print-size" ><b>Class Adviser</b></td>
                        <td class="print-size" ><b>Grade School - Principal</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td style="text-align: right;padding-left: 0px">{{$info['info']->idno}}</td></tr>
    </table>
    <br>

</td>
</tr>
</table>
                
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
</tr>            
        </table>
    <div class="page-break"></div>
    @endforeach
        
        
    </body>
</html>