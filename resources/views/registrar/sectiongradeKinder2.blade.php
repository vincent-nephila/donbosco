<html>
    <head>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <style type='text/css'>
            @if($quarter != 4)
           .padded tr td{
               padding-top: 7px;
               padding-bottom: 7px;
           }
           @endif
            @if($quarter == 4)
           .padded tr td{
               padding-top: 2px;
               padding-bottom: 2px;
           }
           @endif           

           table tr td{font-size:10pt;}
           body{
                font-family: calibri;
                margin-left: auto;
                width:11in;
                    margin:0px;
            }

            td{vertical-align:top}
        </style>    
        <style type="text/css" media="print">
                       body{
                font-family: calibri;
                margin-left: none;
                margin-right: none;
                
            }
        </style>
                <link href="{{ asset('/css/print.css') }}" rel="stylesheet">
               
    </head>
    <body style="margin:0px;">
        @foreach($collection as $info)        
        <table style="margin-top: 55px;margin-bottom:30px;margin-left: .5cm;margin-right:.5cm">
            <tr>
                <td style="width:8.33cm" id="init_{{$info['info']->idno}}">
                    @if(sizeOf($info['aca'])!= 0)
                    <table class="padded" border = '1' cellspacing="0" cellpadding = "0" width="100%" class="reports" style="margin-top: auto;margin-bottom: auto;">
                        <tr><td colspan="6" align="center">QUARTERLY GRADES</td></tr>
                        <tr style="font-weight: bold;text-align:center;">
                            <td width="35%" style="padding: 15px 0 15px 0;">LEARNING AREAS</td>
                            <td width="10%">1st</td>
                            <td width="10%">2nd</td>
                            <td width="10%">3rd</td>
                            <td width="10%">4th</td>
                            <td width="12%">FINAL RATING</td>
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
                                {{--*/$count ++/*--}}

                        </tr>
                        @endforeach
                        <tr style="text-align: center">
                            <td style="text-align: right;">
                                <b>ACADEMIC AVERAGE</b>
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
                        </tr>
                    </table>
                    @endif
                    <br>
                    <table class="padded" border = '1' cellspacing="0" cellpadding = "0" width="100%" style="text-align: center;font-size: 12px;margin-top: auto;margin-bottom: auto;">
                        <tr><td colspan="3"><b>ACADEMIC DESCRIPTORS</b></td></tr>
                        <tr style="font-weight:bold;">
                            <td width="36%" class="descriptors">
                                DESCRIPTOR
                            </td>
                            <td width="32%" class="scale">
                                GRADING SCALE
                            </td>            
                            <td width="32%" class="remarks">
                                NUMERIC EQUIVALENT
                            </td>                        
                        </tr>
                        <tr>
                            <td>Outstanding</td><td>O</td><td>90 - 100</td>
                        </tr>
                        <tr>
                            <td>Very Satisfactory</td><td>VS</td><td>85 - 89</td>
                        </tr>
                        <tr>
                            <td>Satisfactory</td><td>S</td><td>80 - 84</td>
                        </tr>
                        <tr>
                            <td>Fairly Satisfactory</td><td>FS</td><td>75 - 79</td>
                        </tr>
                        <tr>
                            <td>Did Not Meet Expectations</td><td>DNME</td><td>Below 75</td>
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
                </td>
                <td style="width:1cm"></td>
                <td style="width:8.33cm" id="com1_{{$info['info']->idno}}">
                    <div id="con_{{$info['info']->idno}}">        
                    <table class="padded" border = '1' cellspacing="0" cellpadding = "0" width="100%" style="text-align: center;font-size: 11pt;margin-top: auto;margin-bottom: auto;">
                        <tr>
                            <td width="30%">CONDUCT CRITERIA</td>
                            <td width="9%">Points</td>
                            <td width="9%">1</td>
                            <td width="9%">2</td>
                            <td width="9%">3</td>
                            <td width="9%">4</td>
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
                        </tr>
                            @endforeach                    
                            <tr>
                                <td>CONDUCT GRADE</td>
                                <td>100</td>
                                <td>{{$first}}</td>
                                <td> {{$second}}</td>
                                <td>{{$third}}</td>
                                <td>{{$fourth}}</td>
                            </tr>
                            <tr>
                                <td>FINAL GRADE</td>
                                <td colspan="5">{{round(($first+$second+$third+$fourth)/4,2)}}</td>
                            </tr>
                    </table>
                        <br>
                    </div>
                    
                    <table class="padded" border = '1' cellspacing="0" cellpadding = "0" width="100%" style="text-align: center;font-size: 12px;">
                        <tr><td colspan="3"><b>CONDUCT DESCRIPTORS</b></td></tr>
                            <tr style="font-weight:bold;@if($quarter == 4)height: 48px;@endif">
                                <td width="36%" class="descriptors">
                                    DESCRIPTOR
                                </td>
                                <td width="32%" class="scale">
                                    GRADING SCALE
                                </td>            
                                <td width="32%" class="remarks">
                                    NUMERIC EQUIVALENCE
                                </td>                        
                            </tr>
                            <tr>
                                <td>Excellent</td><td>E</td><td>96 - 100</td>
                            </tr>
                            <tr>
                                <td>Very Good</td><td>VG</td><td>91 - 95</td>
                            </tr>
                            <tr>
                                <td>Good</td><td>G</td><td>86 - 90</td>
                            </tr>
                            <tr>
                                <td>Fair</td><td>Fair</td><td>80 - 85</td>
                            </tr>
                            <tr>
                                <td @if($quarter != 4)
                                    style="padding-top: 15px;padding-bottom: 15px"
                                    @endif>Failed</td><td>Failed</td><td>75 and Below</td>
                            </tr>
                        </table>
                    <br>
                </td>
                <td style="width:1cm"></td>
                <td style="width:8.33cm" id="com2_{{$info['info']->idno}}">
                    <div id="eng_{{$info['info']->idno}}">
                    <table border="1" width="100%" cellpadding="0" cellspacing="0">
                        <tr style="text-align: center"><td colspan="2" style="padding: 2px;"><b>ENGLISH</b></td></tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->subject == "English")
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                    <br>
                    </div>
                    <div id="art_{{$info['info']->idno}}">
                    <table border="1" cellspacing="0" cellpadding="0" width="100%">
                        <tr style="text-align: center"><td colspan="2"><b>ART EDUCATION</b></td></tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->subject == "Art Education")
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                        
                    <br>
                    </div>
                    <div  id="chr_{{$info['info']->idno}}">
                    <table border="1" width="100%" cellpadding="0" cellspacing="0">
                        <tr style="text-align: center"><td colspan="2"><b>CHRISTIAN LIVING</b></td></tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->subject == "Christian Living")
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>  
                    <br>
                    </div>                    
                    <div id="phy_{{$info['info']->idno}}">
                    <table border="1" cellspacing="0" cellpadding="0" width="100%">
                        <tr style="text-align: center"><td colspan="2"><b>PHYSICAL EDUCATION</b></td></tr>
                            @foreach($info['comp'] as $key=>$comp)
                            @if($comp->subject == "Physical Education")
                            <tr>
                                <td width="80%">{{$comp->description}}</td>
                                <td>{{$comp->value}}</td>
                            </tr>
                            @endif
                            @endforeach
                    </table>
                    <br>
                    </div>
                    <div id="fil_{{$info['info']->idno}}">
                    <table border="1" width="100%" cellpadding="0" cellspacing="0">
                        <tr style="text-align: center;"><td colspan="2" style="padding: 2px;"><b>FILIPINO</b></td></tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->subject == "Filipino")
                        <tr>
                            <td width="80%">{!!nl2br($comp->description)!!}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                        <br>
                    </div>
                    <div  id="math_{{$info['info']->idno}}">
                        @if($quarter == 4)
                    <table border="1" width="100%" cellpadding="0" cellspacing="0">
                        <tr style="text-align:center"><td colspan="2"><b>MATHEMATICS</b></td></tr>
                        <tr>
                            <td>
                                I.Measurement<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A.Time
                            </td>
                            <td></td>
                        </tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->section == "1A")                        
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                        
                        <tr>
                            <td>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B. Days and Months
                            </td>
                            <td></td>
                        </tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->section == "1B")                        
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                        
                        <tr>
                            <td>
                                II.Measurement<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A.Division
                            </td>
                            <td></td>
                        </tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->section == "2A")                        
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                        
                        <tr>
                            <td>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B.Fraction
                            </td>
                            <td></td>
                        </tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->section == "2B")                        
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach  
                        
                        <tr>
                            <td>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C. Statistics
                            </td>
                            <td></td>
                        </tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->section == "2C")                        
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach                
                        
                        
                    </table>
                        @else
                    <table border="1" width="100%" cellpadding="0" cellspacing="0">
                        <tr style="text-align:center"><td colspan="2"><b>MATHEMATICS</b></td></tr>
                        @foreach($info['comp'] as $key=>$comp)
                        @if($comp->subject == "Mathematics")
                        <tr>
                            <td width="80%">{{$comp->description}}</td>
                            <td>{{$comp->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                        @endif
                    <br>
                    </div>
                </td>
            </tr>
        </table>

        <div class="page-break"></div>
        @endforeach
        
        @foreach($collection as $info)
        <table style="margin-top: 55px;margin-bottom:30px;margin-left: .5cm;margin-right:.5cm" align="center">
                    <tr>
                        <td style="width:8.33cm" id="com3_{{$info['info']->idno}}">
                            <div id="cert_{{$info['info']->idno}}">
                                <table width="100%">
                            <tr>
                                <td class="print-size"  width="49%" style="font-size: 11pt">
                                    <b>Certificate of eligibility for promotion</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="print-size" >
                                    The student is eligible for transfer and
                                </td>              
                            </tr>
                            <tr>
                                <td class="print-size" ><b>Grade:</b>___________________________</td>
                            </tr>
                            <tr>
                                <td class="print-size" ><b>Date of Issue:</b>__________________________</td>
                            </tr>
                            <tr>
                                <td colspan="2"><br><br></td>                                                    
                            </tr>
                            <tr style="text-align: center">
                                <td class="print-size">________________________________</td>
                            </tr>
                            <tr style="text-align: center;">
                                <td class="print-size" >
                                   @if($teacher != null)
                                    {{$teacher->adviser}}
                                   @endif
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                <td class="print-size" ><b>Class Adviser</b></td>
                            </tr>
                            </table>
                                <br>
                                <table width="100%">
                                    <tr>
                                        <td class="print-size" style="font-size: 11pt">
                                            <b>Cancellation of Eligibility to Transfer</b>
                                        </td>  
                                    </tr>
                                    <tr>
                                        <td class="print-size" >
                                            Admitted in:____________________________
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td class="print-size" >Grade:_________   Date:__________________</td>
                                    </tr>
                                    <tr><td><br><br></td></tr>
                                    <tr>
                                        <td class="print-size" style="text-align: center">________________________________</td>                                        
                                    </tr>
                                    <tr>
                                        <td class="print-size" style="text-align: center">Mrs. Ma. Dolores F. Bayocboc</td>
                                    </tr>
                                    <tr>
                                        <td class="print-size" style="text-align: center">Grade  School Principal</td>
                                    </tr>                                    
                                </table>
                            </div>
                        </td>
                        <td style="width:1cm"></td>
                        <td style="width:8.33cm" id="com4_{{$info['info']->idno}}"></td>
                        <td style="width:1cm"></td>
                        <td style="width:8.33cm" id="front_{{$info['info']->idno}}" style="padding-left: 20px;padding-right: 20px">
                            <div style="text-align: center;">
                                <span style="font-size: 12pt;"><b>DON BOSCO TECHNICAL INSTITUTE</b></span><br>
                                <span style="font-size: 10pt;">Chino Roces Ave., Brgy Pio del Pillar</span><br>
                                <span style="font-size: 10pt;">Makati City</span>
                                <div>
                                <img src="{{asset('images/logo.png')}}"  style="display: inline-block;width:200px;padding-top: 70px;padding-bottom: 70px">
                                <br>
                                
                                <br>
                                <span style="font-size: 10pt;font-weight: bold;text-align: center">GRADE SCHOOL DEPARTMENT</span><br>
                                <span style="font-size: 10pt;font-weight: bold;text-align: center">{{$schoolyear->schoolyear}} - {{intval($schoolyear->schoolyear)+1}}</span>
                                </div><br>
                                <div style="font-size: 10pt;font-weight: bold">DEVELOPMENTAL CHECKLIST</div>
                                <div style="font-size: 10pt;font-weight: bold">
                                    @if($quarter == 1)
                                    FIRST QUARTER
                                    @elseif($quarter == 2)
                                    SECOND QUARTER
                                    @elseif($quarter == 3)
                                    THIRD QUARTER
                                    @else
                                    FOURTH QUARTER
                                    @endif
                                </div>
                                <br>
                            </div>
                            <div class="parent" style="border: 1px solid; padding: 20px 10px 50px;border-radius: 40px;">
                                <div style="text-align:center;font-size: 12pt;"><b>KINDERGARTEN</b></div>
                                <br>
                            <div><span width="10%"><b>Name:</b></span>{{$info['info']->lastname}}, {{$info['info']->firstname}} {{$info['info']->middlename}} {{$info['info']->extensionname}}</div>
                            <div><span width="10%"><b>Age:</b></span>{{$info['info']->age}}</div>
                            <div><span width="10%"><b>Section:</b></span>{{$section}}</div>
                            <div><span width="10%"><b>Adviser:</b></span>{{$teacher->adviser}}</div>
                            </div>
                        </td>
                    </tr>

        </table>
        <script>
            @if($quarter == 1)
            $("#fil_{{$info['info']->idno}}").appendTo("#com1_{{$info['info']->idno}}");
            $("#eng_{{$info['info']->idno}}").appendTo("#com3_{{$info['info']->idno}}");
            $("#cert_{{$info['info']->idno}}").appendTo("#com4_{{$info['info']->idno}}");
            @endif
            @if($quarter == 2)
            $("#fil_{{$info['info']->idno}}").prependTo("#com2_{{$info['info']->idno}}");
            $("#chr_{{$info['info']->idno}}").prependTo("#com3_{{$info['info']->idno}}");
            $("#cert_{{$info['info']->idno}}").appendTo("#com4_{{$info['info']->idno}}");
            //$("#art_{{$info['info']->idno}}").prependTo("#com4_{{$info['info']->idno}}");
            $("#eng_{{$info['info']->idno}}").prependTo("#com3_{{$info['info']->idno}}");
            $("#phy_{{$info['info']->idno}}").appendTo("#com1_{{$info['info']->idno}}");
            @endif  
            @if($quarter == 3)
            $("#phy_{{$info['info']->idno}}").appendTo("#com1_{{$info['info']->idno}}");
            $("#chr_{{$info['info']->idno}}").prependTo("#com3_{{$info['info']->idno}}");
            $("#eng_{{$info['info']->idno}}").prependTo("#com3_{{$info['info']->idno}}");
            $("#cert_{{$info['info']->idno}}").appendTo("#com4_{{$info['info']->idno}}");
            @endif
            @if($quarter == 4)
               
               $("#math_{{$info['info']->idno}}").prependTo("#com3_{{$info['info']->idno}}"); 
               $("#phy_{{$info['info']->idno}}").prependTo("#com3_{{$info['info']->idno}}"); 
               //$("#fil_{{$info['info']->idno}}").appendTo("#com3_{{$info['info']->idno}}");
               $("#eng_{{$info['info']->idno}}").appendTo("#com1_{{$info['info']->idno}}"); 
               //$("#chr_{{$info['info']->idno}}").appendTo("#com3_{{$info['info']->idno}}"); 
               $("#con_{{$info['info']->idno}}").appendTo("#init_{{$info['info']->idno}}"); 
               $("#art_{{$info['info']->idno}}").appendTo("#com1_{{$info['info']->idno}}"); 
               $("#cert_{{$info['info']->idno}}").appendTo("#com4_{{$info['info']->idno}}"); 
               
            @endif
        </script>
        <div class="page-break"></div>        
        @endforeach
    </body>
</html>