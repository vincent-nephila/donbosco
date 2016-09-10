
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
                <td style="padding-left: 0px">
                    <table class="head" width="100%" border="0" cellpadding="0" cellspacing="0" align="right">

                    <tr>
                        <td rowspan="4" style="text-align: right;padding-left: 0px;width: 35%" class="logo" width="55px">
                            <img src="{{asset('images/logo.png')}}"  style="display: inline-block;width:70px">
                        </td>
                        <td style="padding-left: 0px;">
                            <span style="font-size:11pt; font-weight: bold">DON BOSCO TECHNICAL INSTITUTE</span>
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
                            <td width="13%" style="font-size:10pt;padding-left: 0px;">
                                <b>Name:</b>
                            </td>
                            <td width="53%" style="font-size:10pt;padding-left: 0px;"><b>
                                {{$info['info']->lastname}}, {{$info['info']->firstname}} {{$info['info']->middlename}} {{$info['info']->extensionname}}
                                </b>
                            </td>
                            <td width="13%" style="font-size:10pt;padding-left: 0px;">
                                <b>Student No:</b>
                            </td>
                            <td width="23%" style="font-size:10pt;padding-left: 0px;">
                                <b>{{$info['info']->idno}}</b>
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
                            {{$academics->subjectname}}
                        </td>
                        <td @if(round($academics->first_grading,2) <= 74)
                             style="color:red"
                            @endif
                            >
                            @if(round($academics->first_grading,2) == 0)
                            @else
                                {{round($academics->first_grading,2)}}
                            @endif
                            {{--*/$first = $first + round($academics->first_grading,2)/*--}}
                        </td>
                        <td @if(round($academics->second_grading,2) <= 74)
                             style="color:red"
                            @endif
                            >
                            @if(round($academics->second_grading,2) == 0)
                            @else
                                {{round($academics->second_grading,2)}}
                            @endif
                            {{--*/$second = $second + round($academics->second_grading,2)/*--}}
                        </td >
                        <td @if(round($academics->third_grading,2) <= 74)
                             style="color:red"
                            @endif
                            >
                            @if(round($academics->third_grading,2) == 0)
                            @else
                                {{round($academics->third_grading,2)}}
                            @endif
                            {{--*/$third = $third + round($academics->third_grading,2)/*--}}
                        </td>
                        <td @if(round($academics->third_grading,2) <= 74)
                             style="color:red"
                            @endif
                            >
                            @if(round($academics->third_grading,2) == 0)
                            @else
                                {{round($academics->fourth_grading,2)}}
                            @endif
                            {{--*/$fourth = $fourth + round($academics->fourth_grading,2)/*--}}
                        </td>
                        <td>
                            @if(!round($academics->final_grade,2) == 0)
                            
                            {{round($academics->final_grade,2)}}
                            @endif
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
                            <b>GENERAL AVERAGE&nbsp;&nbsp;&nbsp;</b>
                        </td>
                        <td @if(round($first/$count,2) <= 74)
                             style="color:red"
                            @endif
                            ><b>
                            @if(round($first/$count,2) == 0)
                            @else
                            {{round($first/$count,2)}}
                            @endif</b>
                        </td>
                        <td @if(round($second/$count,2) <= 74)
                             style="color:red"
                            @endif
                            ><b>
                            @if(round($second/$count,2) == 0)
                            @else
                            {{round($second/$count,2)}}
                            @endif</b>
                        </td>
                        <td @if(round($third/$count,2) <= 74)
                             style="color:red"
                            @endif
                            ><b>
                            @if(round($third/$count,2) == 0)
                            @else
                            {{round($third/$count,2)}}
                            @endif</b>
                        </td>
                        <td @if(round($fourth/$count,2) <= 74)
                             style="color:red"
                            @endif
                            ><b>
                            @if(round($fourth/$count,2) == 0)
                            @else
                            {{round($fourth/$count,2)}}
                            @endif</b>
                        </td>
                        <td>
                            @if(!round($fourth/$count,2) == 0)
                            {{round($final/$count,2)}}
                            @endif
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
                    <table border = '1' cellspacing="0" cellpadding = "0" width="100%" style="text-align: center;font-size: 12px;background-color: rgba(201, 201, 201, 0.79);">
                        <tr style="font-weight:bold;">
                            <td width="36%" class="descriptors">
                                DESCRIPTORS
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
                    <table border = '1' cellspacing="0" cellpadding = "0" width="100%" style="text-align: center;font-size: 12px;background-color: rgba(201, 201, 201, 0.79);">
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
                        <td width="30%"><b>CONDUCT CRITERIA</b></td>
                        <td width="10%"><b>Points</b></td>
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
                        <td><b>{{$conducts->points}}</b></td>
                        <td>
                            @if(!round($conducts->first_grading,2)==0)
                            {{round($conducts->first_grading,2)}}
                            @endif
                            {{--*/$first = $first + round($conducts->first_grading,2)/*--}}
                        </td>
                        <td>
                            @if(!round($conducts->second_grading,2)==0)
                            {{round($conducts->second_grading,2)}}
                            @endif
                            {{--*/$second = $second + round($conducts->second_grading,2)/*--}}
                        </td>
                        <td>
                            @if(!round($conducts->third_grading,2)==0)
                            {{round($conducts->third_grading,2)}}
                            @endif
                            {{--*/$third = $third + round($conducts->third_grading,2)/*--}}
                        </td>
                        <td>
                            @if(!round($conducts->fourth_grading,2)==0)
                            {{round($conducts->fourth_grading,2)}}
                            @endif
                            {{--*/$fourth = $fourth + round($conducts->fourth_grading,2)/*--}}
                        </td>
                        @if($length == $counter)
                        <td><b>FINAL GRADE</b></td>
                        @endif
                        

                    </tr>
                        @endforeach                    
                        <tr>
                            <td><b>CONDUCT GRADE</b></td>
                            <td><b>100</b></td>
                            <td><b>@if(!$first == 0){{$first}}@endif</b></td>
                            <td><b>@if(!$second == 0){{$second}}@endif</b></td>
                            <td><b>@if(!$third == 0){{$third}}@endif</b></td>
                            <td><b>@if(!$fourth == 0){{$fourth}}@endif</b></td>
                            
                            <td><b>
                                @if(!$fourth == 0)
                                {{round(($first+$second+$third+$fourth)/4,2)}}
                            @endif</b></td>
                            
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
                                @if($attend->subjectcode != "DAYT")
                                    {{--*/$first = $first + $attend->first_grading/*--}}
                                    {{--*/$second = $second + $attend->second_grading/*--}}
                                    {{--*/$third = $third + $attend->third_grading/*--}}
                                    {{--*/$fourth = $fourth + $attend->fourth_grading/*--}}
                                @endif
                            @endforeach
                        <td>
                            @if($first != 0)
                            {{$first}}
                            @endif
                        </td>
                        <td>
                            @if($second != 0)                            
                            {{$second}}
                            @endif
                        </td>
                        <td>
                            @if($third != 0)                            
                            {{$third}}
                            @endif
                        </td>                                                    
                        <td>
                            @if($fourth != 0)                            
                            {{$fourth}}
                            @endif
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
                            @if($first != 0)
                            {{round($attend->first_grading,1)}}
                            @endif
                        </td>
                        <td>
                            @if($second != 0)
                            {{round($attend->second_grading,1)}}
                            @endif
                        </td>
                        <td>
                            @if($third != 0)
                            {{round($attend->third_grading,1)}}
                            @endif
                        </td>
                        <td>
                            @if($fourth != 0)
                            {{round($attend->fourth_grading,1)}}
                            @endif
                        </td>
                        <td>
                            {{round($attend->first_grading,1)+round($attend->second_grading,1)+round($attend->third_grading,1)+round($attend->fourth_grading,1)}}
                        </td>                                                    
                    </tr>
                    @endforeach
                </table>
                <br>
                <table width="100%">
                    <tr>
                        <td class="print-size"  width="49%">
                            <b>Certificate of Eligibility for Promotion</b>
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
                        <td class="print-size" >admission to:___________________________</td>
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
                        <td class="print-size" >Mrs. Ma.Dolores F. Bayocboc</td>
                    </tr>
                    <tr style="text-align: center">
                        <td class="print-size" ><b>Class Adviser</b></td>
                        <td class="print-size" ><b>Grade School - Principal</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td style="text-align: right;padding-left: 0px"><b>{{$info['info']->idno}}</b></td></tr>
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