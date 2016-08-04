@extends('app')
@section('content')
        <style type="text/css">
            .form-control {
                background: none!important;
                border: none!important;
                border-bottom: 1px solid!important;
                box-shadow: none!important;
                border-radius: 0px!important;
                padding-bottom: 0px!important;
            }
            button[type='button']{
                width: 100%;
            }
            td{
                border: none!important;
            }
            .collapse{
                border: 1px solid;
                border-top: none;
            }
            .error{
                border: 2px solid #cf2020;
                text-align: center;
            }
            button[type="button"]{
                border-bottom-right-radius: 0px;
                border-bottom-left-radius: 0px;
            }
        </style>

<div class="container">
    @if(count($errors)>0)
    <div class="error">
        @foreach($errors->all() as $error)
         <li>{{$error}}</li>
        @endforeach        
    </div>
    @endif

    
     @if($student != NULL)
     <form method="POST" action="{{url('studentinfokto12/'.$student->idno)}}">
     @else
     <form method="POST" action="{{url('studentinfokto12')}}">
     @endif
    {!! csrf_field() !!}
    <input type="hidden" name="idno" id="idno"
             @if($student != NULL)
             value="{{$student->idno}}"
             @endif
             /> 
    
 <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo"><strong>STUDENT DATA</strong></button>
  <div id="demo" class="collapse">
  

            
  <table class="table">
    <tbody>
      <tr>
      <td colspan="2">
      <label>STUDENT NAME: (Please fill up with the complete name as it appears in the birth certificate)</label>            
      
      <div class="row_form">
      <div class="col-sm-3">     
      <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter your Family Name" 
             @if($student != NULL)
             value="{{$student->lastname}}"
             @endif
             />
             <p style="text-align: center">(PRINT) FAMILY NAME</p>
      </div>
      <div class="col-sm-3">    
      <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter your First Name" 
             @if($student != NULL)
             value="{{$student->firstname}}"
             @endif
             />
             <p style="text-align: center">(PRINT) GIVEN NAME</p>
      </div>
      <div class="col-sm-3">
      <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Enter your Middle Name" 
             @if($student != NULL)
             value="{{$student->middlename}}"
             @endif             
             />
             <p style="text-align: center">(PRINT) MIDDLE NAME</p>
      </div>
      <div class="col-sm-3">
      <input type="text" class="form-control" name="extensionname" id="extensionname" placeholder="Enter extension name" 
             @if($student != NULL)
             value="{{$student->extensionname}}"
             @endif             
             />
             <p style="text-align: center">(PRINT) EXTENSION NAME</p>
      </div>
      </div>
      
      <!-- <div class="form-group">
      <div class="col-sm-3">    
      <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter your First Name" />
      </div>
      </div> 
      
      <div class="form-group">
      <div class="col-sm-3">
      <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Enter your Middle Name" />
      </div>
      </div> 
      
      <div class="form-group"> 
      <div class="col-sm-3">  	
      <input type="text" class="form-control" name="extensioname" id="extensioname" placeholder="Enter extension name" /> 
      </div> 
      </div>   -->
      
      </td>
      </tr>
      <tr>
      <td>
      <div class="col-md-6 form-inline" style="padding-left: 20px;padding-right: 0px;">      
      <div class="form-group date col-md-8">
        <label>DATE OF BIRTH:</label>
        <input type="text" name="birthDate" id="birthDate" class="form-control datepicker" style="width: 55%;" placeholder="Date of Birth" 
               @if($studentInfo != NULL)
               value="{{$studentInfo->birthDate}}"
               @endif             
               />
      </div>
      <div class="form-group col-md-4">  	
        <label for="age">AGE:</label>
        <input type="text" class="form-control" name="age" id="age" placeholder="Enter your age" style="width: 78%;">
      </div>        
    <div class="form-group col-md-12 ">
    <label>PLACE OF BIRTH:</label>
    <input type="text" class="form-control" name="birthPlace" id="birthPlace" style="width: 78%;" placeholder="Place of Birth"
             @if($studentInfo != NULL)
             value="{{$studentInfo->birthPlace}}"
             @endif           
           >
    </div>          
      </div>          

        <div class="col-md-6 form-inline" style="padding-left:50px;padding-right: 0px;" >
    <div class="form-group col-md-5"> 
    <label>GENDER:</label>
    <input type="text" class="form-control" name="gender" id="gender" style="width: 56%;" placeholder="Enter Gender"
             @if($student != NULL)
             value="{{$student->gender}}"
             @endif           
           >
    </div>
      <div class="form-group col-md-7">
      <label>CIVIL STATUS </label> 
      <select class="form-control" name="status" id="status" style="width: 56%;">
        <option value="SINGLE">SINGLE</option>
        <option value="MARRIED">MARRIED</option>
      </select>
    </div>            
    <div class="form-group col-md-12">
    <label>RELIGION:</label>
    <input type="text" class="form-control" name="religion" id="religion" style="width: 79.5%;" placeholder="Enter Religion"
             @if($studentInfo != NULL)
             value="{{$studentInfo->religion}}"
             @endif           
           >
    </div>    
        </div>

    </td>    

      
      </tr>   
      <tr>
          <td>
    <div class="col-md-6 form-inline" style="padding-left:20px;padding-right: 0px;">
    <div class="form-group col-md-12">
    <label>NATIONALITY:</label>
    <input type="text" class="form-control" name="citizenship" style="width:81%" id="citizenship" placeholder="Enter Nationality"
             @if($studentInfo != NULL)
             value="{{$studentInfo->citizenship}}"
             @endif           
           >
    </div>
    </div>
              <div class="col-md-6 form-inline" style="padding-left:50px;padding-right: 0px;">
    <div class="form-group col-md-12">
    <label>ACR Number:</label>
    <input type="text" class="form-control" name="acr" id="acr" style="width:75%" placeholder="Enter ACR"
             @if($studentInfo != NULL)
             value="{{$studentInfo->acr}}"
             @endif             
           >
    </div>         
    <div class="form-group col-md-12" style="padding-left: 10%">
    <label>Visa Type:</label>
    <input type="text" class="form-control" name="visaType" id="visaType" placeholder="Enter Type of Visa"
             @if($studentInfo != NULL)
             value="{{$studentInfo->visaType}}"
             @endif             
           >
    </div>                            
              </div>
          </td>
      </tr>
    <tr>
    <td>
        <div class="col-md-6 form-inline" style="padding-left:20px;padding-right: 0px;">
            <b4><b>City Address</b></b4>
                <div class="form-group col-md-12">
                <label>HOUSE NO. / STREET:</label>
                <input type="text" class="form-control" name="address1" id="address1" style="width:73%" placeholder="Enter House No. / Street"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address1}}"
                         @endif             
                       >
                </div>            
                <div class="form-group col-md-12">
                <label>VIL. / SUBDIV. / BRGY.:</label>
                <input type="text" class="form-control" name="address2" id="address2" style="width:72%" placeholder="Enter Vil. / Subdiv. / Brgy."
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address2}}"
                         @endif             
                       >
                </div>
                <div class="form-group col-md-5" style="padding-right: 0px;">
                <label>DISTRICT:</label>
                <input type="text" class="form-control" name="address5" id="address5" style="width:60%" placeholder="Enter District"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address5}}"
                         @endif             
                       >
                </div>
                <div class="form-group col-md-7" style="padding-left: 0px">
                <label>CITY/ MUNICIPALITY:</label>
                <input type="text" class="form-control" name="address3" id="address3" style="width: 54%;" placeholder="Enter city municipality"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address3}}"
                         @endif             
                       >
                </div>
                <div class="form-group col-md-7">
                <label>REGION:</label>
                <input type="text" class="form-control" name="address4" id="address4" placeholder="Enter region"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address4}}"
                         @endif            
                       >
                </div>
                <div class="form-group col-md-5">
                <label>ZIPCODE:</label>
                <input type="text" class="form-control" name="zipcode" id="zipcode" style="width:67%" placeholder="Enter zipcode"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->zipcode}}"
                         @endif            
                       >
                </div>
            
        </div>
        <div class="col-md-6 form-inline" style="padding-left:50px;padding-right: 0px;">
                <b4><b>Provincial Address</b></b4>
                <div class="form-group col-md-12">
                <label>HOUSE NO. / STREET:</label>
                <input type="text" class="form-control" name="address6" id="address6" style="width: 65%;" placeholder="Enter House No. / Street"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address6}}"
                         @endif            
                       >
                </div>
                <div class="form-group col-md-12">
                <label>VIL. / SUBDIV. / BRGY.:</label>
                <input type="text" class="form-control" name="address7" id="address7" style="width: 64%;" placeholder="Enter Vil. / Subdiv. / Brgy."
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address7}}"
                         @endif            
                       >
                </div>
               
                <div class="form-group col-md-12">
                <label>CITY/ MUNICIPALITY:</label>
                <input type="text" class="form-control" name="address8" id="address8" style="width: 65%;" placeholder="Enter city municipality"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address8}}"
                         @endif            
                       >
                </div>
                <div class="form-group col-md-12">
                <label>PROVINCE:</label>
                <input type="text" class="form-control" name="address9" id="address9" style="width: 78%;" placeholder="Enter province"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->address9}}"
                         @endif            
                       >
                </div>
        </div>
    </td>    
    </tr>    
    <tr>
    <td>
    
    <tr>
        <td>
            <div class="col-md-6 form-inline" style="padding-left:20px;padding-right: 0px;">
    <div class="form-group col-md-12">
    <label>E-MAIL ADDRESS :</label>
    <input type="text" class="form-control" name="email" id="email" style="width: 77%;" placeholder="Enter e-mail"
             @if($student != NULL)
             value="{{$student->email}}"
             @endif            
           >
    </div>
    <div class="form-group col-md-6">
    <label>LANDLINE NO. :</label>
    <input type="text" class="form-control" name="phone1" id="phone1" style="width:58.5%" placeholder="Enter landline number"
             @if($studentInfo != NULL)
             value="{{$studentInfo->phone1}}"
             @endif            
           >
    </div>    
    <div class="form-group col-md-6">
    <label>MOBILE NO. :</label>
    <input type="text" class="form-control" name="phone2" style="width:65%" id="phone2" placeholder="Enter mobile number"
             @if($studentInfo != NULL)
             value="{{$studentInfo->phone2}}"
             @endif            
           >
    </div>                
            </div>
            <div class="col-md-6 form-inline" style="padding-left:50px;padding-right: 0px;">
    <div class="form-group col-md-12">
    <label>SCHOOL LAST ATTENDED:</label>
    <input type="text" class="form-control" name="lastattended" style="width: 59%;" id="lastattended" placeholder="Enter school last attended"
             @if($studentInfo != NULL)
             value="{{$studentInfo->lastattended}}"
             @endif            
           >
    </div>
    
    <div class="form-group col-md-6">
    <label>GRADE / YEAR:</label>
    <input type="text" class="form-control" style="width: 56.5%;" name="lastlevel" id="lastlevel" placeholder="Enter grade year"
             @if($studentInfo != NULL)
             value="{{$studentInfo->lastlevel}}"
             @endif            
           >
    </div>
    
    <div class="form-group col-md-6" style="padding-left: 0px;">
    <label>SCHOOL YEAR:</label>
    <input type="text" class="form-control" style="width: 47%;" name="lastyear" id="lastyear" placeholder="Enter school year"
             @if($studentInfo != NULL)
             value="{{$studentInfo->lastyear}}"
             @endif            
           >
    </div>    
                
            </div>            
        </td>    
    </tr>
    <tr>
    <td>
    <div class="col-md-6" style="padding-left:20px;padding-right: 0px;">
        <label>NO. OF CHILDREN (INCLUDING THIS STUDENT):</label>    
    <div class="form-group">
    
    
    <div class="col-md-offset-2 col-md-4">
    <input type="text" class="form-control" name="countboys" id="noofstudentboys" placeholder="Enter No. Boys"
             @if($studentInfo != NULL)
             value="{{$studentInfo->countboys}}"
             @endif                       
           >
           <p style="text-align: center">boys</p>
    </div> 
    <div class="col-md-4">
    <input type="text" class="form-control" name="countgirls" id="noofstudentgirls" placeholder="Enter No. Girls"
             @if($studentInfo != NULL)
             value="{{$studentInfo->countgirls}}"
             @endif                       
           >
           <p style="text-align: center">girls</p>
    </div>   
    
    </div>
    </div>
        <div class="col-md-6 form-inline" style="padding-left:50px;padding-right: 0px;">
    <div class="form-group col-md-12">
    <label>LRN:</label>
    <input type="text" class="form-control" style="width: 86%;" name="lrn"  id="lrn" placeholder="Enter LRN No."
             @if($studentInfo != NULL)
             value="{{$studentInfo->lrn}}"
             @endif
           >
    </div>
    
    <div class="form-group col-md-5">
    <label>ESC Gurantee:</label>
    <input type="checkbox" class="form-control" value="1" name="esc" id="esc">
        
        
    </div>
    
    <div class="form-group col-md-7">
    <label>ESC ID No:</label>
    <input type="text" class="form-control" name="escNo" id="escNo" style="width:62%" placeholder="Enter ESC No."
             @if($studentInfo != NULL)
             value="{{$studentInfo->escNo}}"
             @endif                       
           >
    </div>                
        </div>
    </td>    
    </tr>
      
    </tbody>
  </table>


</div>
<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo4"><strong>PARENTS DATA</strong></button>
 <div id="demo4" class="collapse">
  
            
  <table class="table">
    <tbody>
    
    <tr>       
    <td> 
    
    <div class="col-md-6 form-inline" style="padding-left:20px;padding-right: 0px;">
    <h5><b>FATHER</b></h5>
        <div class="form-group col-md-12">
    <label>NAME:</label>
    <input type="text" class="form-control" name="fname" id="fname" style="width:91%" placeholder="Enter name "
             @if($studentInfo != NULL)
             value="{{$studentInfo->fname}}"
             @endif                       
           >
    </div>
    
        <div class="form-group col-md-12">
      <label>ARE YOU A DBTI-MAKATI ALUMNUS? </label> 
      <select style = "width: 130px" class="form-control" name="falumnus" id="falumnus">
        <option value="1">YES</option>
        <option value="0">NO</option>
      </select>
    </div>
    
        <div class="form-group col-md-offset-2 col-md-10">
    <label>YEAR GRADUATED:</label>
    <input type="text" class="form-control" name="fyeargraduated" style="width:35%" id="fyeargraduated" placeholder="Enter year"
             @if($studentInfo != NULL)
             value="{{$studentInfo->fyeargraduated}}"
             @endif                       
           />
    </div>
      
        <div class="form-group col-md-7 date">
      <label>DATE OF BIRTH:</label>          
      <input type="text" name="fbirthdate" style="width: 58%;" id="fbirthdate" class="form-control datepicker" placeholder="Date of Birth"/
             @if($studentInfo != NULL)
             value="{{$studentInfo->fbirthdate}}"
             @endif                         
             >
      </div>
    
        <div class="form-group col-md-5">
      <label>CIVIL STATUS </label> 
      <select class="form-control" name="fstatus" id="fstatus" style="width: 55%;">
        <option value="SINGLE">SINGLE</option>
        <option value="MARRIED">MARRIED</option>
        <option value="DIVORCED">DIVORCED</option>
        <option value="DECEASED">DECEASED</option>
        <option value="WWIDOWED">WIDOWED</option>
        <option value="ANNULLED">ANNULLED</option>
        <option value="SEPARATED">SEPARATED</option>
      </select>
    </div>    
    </div>
    <div class="col-md-6 form-inline" style="padding-left: 50px;padding-right: 0px;">
<h5><b>MOTHER</b></h5>
    
        <div class="form-group col-md-12">
    <label>NAME:</label>
    <input type="text" class="form-control" name="mname" style="width:90%" id="mname" placeholder="Enter name "
             @if($studentInfo != NULL)
             value="{{$studentInfo->mname}}"
             @endif                       
           >
    </div>
<br>
<br>
<br>
<br>
<br>
        <div class="form-group col-md-7 date">
      <label>DATE OF BIRTH:</label>          
      <input type="text" name="mbirthdate" style="width: 55%;" id="mbirthdate" class="form-control datepicker" placeholder="Date of Birth"/
             @if($studentInfo != NULL)
             value="{{$studentInfo->mbirthdate}}"
             @endif                         
             >
      </div>
    
        <div class="form-group col-md-5">
      <label>CIVIL STATUS </label> 
      <select class="form-control" name="mstatus" id="mstatus" style="width: 52%;">
        <option value="SINGLE">SINGLE</option>
        <option value="MARRIED">MARRIED</option>
        <option value="DIVORCED">DIVORCED</option>
        <option value="DECEASED">DECEASED</option>
        <option value="WIDOWED">WIDOWED</option>
        <option value="ANNULED">ANNULLED</option>
        <option value="SEPARATED">SEPARATED</option>
      </select>
    </div>
    </div>
    </td>
    </tr>
    <tr>
        <td>
            <div class="col-md-6 form-inline" style="padding-left: 20px;padding-right: 0px;">
                <div class="form-group col-md-6">
                <label>RELIGION :</label>
                <input type="text" class="form-control" name="freligion" style="width:70%" id="freligion" placeholder="Enter Religion"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->freligion}}"
                         @endif
                       >
                </div>

                <div class="form-group col-md-6">
                <label>NATIONALITY:</label>
                <input type="text" class="form-control" name="fnationality" style="width:60%" id="fnationality" placeholder="Enter Nationality"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->fnationality}}"
                         @endif
                       >
                </div>
                
                <div class="col-md-12">
                <label>MOBILE NO. :</label>
                <input type="text" class="form-control" style="width:83%" name="fmobile" id="fmobile" placeholder="Enter Mobile No"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->fmobile}}"
                         @endif
                       >
                </div>                
            </div>
            <div class="col-md-6 form-inline" style="padding-left: 50px;padding-right: 0px;">
                <div class="form-group col-md-6">
                <label>RELIGION :</label>
                <input type="text" class="form-control" name="mreligion" id="mreligion" style="width:68.9%" placeholder="Enter Religion"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->mreligion}}"
                         @endif
                       >
                </div>

                <div class="form-group col-md-6">
                <label>NATIONALITY:</label>
                <input type="text" class="form-control" name="mnationality" id="mnationality" style="width:59.5%" placeholder="Enter Nationality"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->mnationality}}"
                         @endif
                       >
                </div>
                <div class="col-md-12">
                <label>MOBILE NO. :</label>
                <input type="text" class="form-control" name="mmobile" style="width:82.5%" id="mmobile" placeholder="Enter Mobile No"
                         @if($studentInfo != NULL)
                         value="{{$studentInfo->mmobile}}"
                         @endif
                       >
                </div>                                
            </div>            
        </td>
    </tr>
    <tr>
        <td>
    <div class="col-md-6"  style="padding-left: 35px;padding-right: 0px;">
    <label>WHAT COURSE DID YOU TAKE-UP IN COLLEGE?</label>
    <input type="text" class="form-control" name="fcourse" id="fcourse" placeholder="Enter year"
             @if($studentInfo != NULL)
             value="{{$studentInfo->fcourse}}"
             @endif                                  
           >
    </div>
    <div class="col-md-6"  style="padding-left: 65px;padding-right: 0px;">
    <label>WHAT COURSE DID YOU TAKE-UP IN COLLEGE?</label>
    <input type="text" class="form-control" name="mcourse" id="mcourse" placeholder="Enter year"
             @if($studentInfo != NULL)
             value="{{$studentInfo->mcourse}}"
             @endif                                  
           >
    </div>            
    </td>    
    </tr>
    
    <tr>     
    <td>      
        <div class="col-md-6 form-inline " style="padding-left: 20px;padding-right: 0px;">
            <h5><b>Occupation</b></h5>
            <div class="form-group col-md-12">
              <label>ARE YOU SELF-EMPLOYED? </label> 
              <select style = "width: 80px" class="form-control" name="fselfemployed" id="fselfemployed">
                  <option value="1">YES</option>
                  <option value="0">NO</option>
              </select>
            </div>
            <div class="form-group col-md-12">
            <label>FULL-TIME:</label>
            <input type="text" class="form-control" style="width: 85.5%;" name="fFulljob" id="fFulljob" placeholder="Enter full time "
                     @if($studentInfo != NULL)
                     value="{{$studentInfo->fFulljob}}"
                     @endif                                             
                   >
            </div>            
            <div class="form-group col-md-12">
            <label>PART-TIME:</label>
            <input type="text" class="form-control" name="fPartjob" style="width: 85.5%;" id="fPartjob" placeholder="Enter part time "
                     @if($studentInfo != NULL)
                     value="{{$studentInfo->fPartjob}}"
                     @endif
                   >
            </div>
            <label class="col-md-12">POSITION: (MAIN SOURCE OF INCOME) </label> 
          <div class="col-md-12">      
          <select class="form-control" name="fposition" id="fposition">
            <option value="TOP MANAGEMENT">TOP MANAGEMENT</option>
            <option value="MIDDLE MANAGEMENT">MIDDLE MANAGEMENT</option>
            <option value="SUPERVISORY">SUPERVISORY</option>
            <option value="RANK & FILE">RANK & FILE</option>
          </select>
        </div>
        <div class="col-md-12">
        <label>MONTHLY INCOME: </label>
        <input type="text" class="form-control" name="fincome" id="fincome" style="width: 75.5%;" placeholder="Enter course in college"
                 @if($studentInfo != NULL)
                 value="{{$studentInfo->fincome}}"
                 @endif                                             
               >
        </div>
        <div class="col-md-12">
        <label>COMPANY NAME: </label>
        <input type="text" class="form-control" name="fcompany" id="fcompany" style="width: 77.8%;" placeholder="Enter company name"
                 @if($studentInfo != NULL)
                 value="{{$studentInfo->fcompany}}"
                 @endif                                             
               >
        </div>
        <label class="col-md-12">COMPANY ADDRESS: </label>
    <div class="col-md-12">
    <input typ  e="text" class="form-control" name="fComAdd" id="fComAdd" style="width:100%" placeholder="Enter company address"
             @if($studentInfo != NULL)
             value="{{$studentInfo->fComAdd}}"
             @endif                                             
           >
    </div>
    <div class="col-md-12">
    <label>OFFICE TEL. NO.: </label>
    <input type="text" class="form-control" name="fOfficePhone" id="fOfficePhone" style="width:79.4%;" placeholder="Enter office tel. no."
             @if($studentInfo != NULL)
             value="{{$studentInfo->fOfficePhone}}"
             @endif                                             
           >
    </div>
    <div class="col-md-12">
    <label>OFFICE FAX NO.: </label>
    <input type="text" class="form-control" name="ffax" id="ffax" style="width: 79.4%;" placeholder="Enter office fax no."
             @if($studentInfo != NULL)
             value="{{$studentInfo->ffax}}"
             @endif                                             
           >
    </div>
    <div class="col-md-12">
    <label>EMAIL ADDRESS: </label>
    <input type="text" class="form-control" name="femail" id="femail" style="width: 78.5%;" placeholder="Enter email"
             @if($studentInfo != NULL)
             value="{{$studentInfo->femail}}"
             @endif                                             
           >
    </div>
        </div>

        
        <div class="col-md-6 form-inline" style="padding-left: 50px;padding-right: 0px;" >
            <h5><b>Occupation</b></h5>
            <div class="form-group col-md-12">
              <label>ARE YOU SELF-EMPLOYED? </label> 
              <select style = "width: 80px" class="form-control" name="mselfemployed" id="mselfemployed">
                  <option value="1">YES</option>
                  <option value="0">NO</option>
              </select>
            </div>
            <div class="form-group col-md-12">
            <label>FULL-TIME:</label>
            <input type="text" class="form-control" name="mFulljob" id="mFulljob" style="width: 84.8%;" placeholder="Enter full time "
                     @if($studentInfo != NULL)
                     value="{{$studentInfo->mFulljob}}"
                     @endif                                             
                   >
            </div>            
            <div class="form-group col-md-12">
            <label>PART-TIME:</label>
            <input type="text" class="form-control" name="mPartjob" id="mPartjob" style="width: 84.8%;" placeholder="Enter part time "
                     @if($studentInfo != NULL)
                     value="{{$studentInfo->mPartjob}}"
                     @endif
                   >
            </div>
            <label class="col-md-12">POSITION: (MAIN SOURCE OF INCOME) </label> 
          <div class="col-md-12">      
          <select class="form-control" name="mposition" id="mposition">
            <option value="TOP MANAGEMENT">TOP MANAGEMENT</option>
            <option value="MIDDLE MANAGEMENT">MIDDLE MANAGEMENT</option>
            <option value="SUPERVISORY">SUPERVISORY</option>
            <option value="RANK & FILE">RANK & FILE</option>
          </select>
        </div>
        <div class="col-md-12">
        <label>MONTHLY INCOME: </label>
        <input type="text" class="form-control" name="mincome" id="mincome" style="width: 74.4%;" placeholder="Enter course in college"
                 @if($studentInfo != NULL)
                 value="{{$studentInfo->mincome}}"
                 @endif                                             
               >
        </div>
        <div class="col-md-12">
        <label>COMPANY NAME: </label>
        <input type="text" class="form-control" name="mcompany" id="mcompany" style="width: 76.5%;" placeholder="Enter company name"
                 @if($studentInfo != NULL)
                 value="{{$studentInfo->mcompany}}"
                 @endif                                             
               >
        </div>
        <label class="col-md-12">COMPANY ADDRESS: </label>
    <div class="col-md-12">
    <input typ  e="text" class="form-control" name="mComAdd" id="mComAdd" style="width: 100%;" placeholder="Enter company address"
             @if($studentInfo != NULL)
             value="{{$studentInfo->mComAdd}}"
             @endif                                             
           >
    </div>
    <div class="col-md-12">
    <label>OFFICE TEL. NO.: </label>
    <input type="text" class="form-control" name="mOfficePhone" id="mOfficePhone" style="width: 78.1%;" placeholder="Enter office tel. no."
             @if($studentInfo != NULL)
             value="{{$studentInfo->mOfficePhone}}"
             @endif                                             
           >
    </div>
    <div class="col-md-12">
    <label>OFFICE FAX NO.: </label>
    <input type="text" class="form-control" name="mfax" id="mfax" style="width: 78.3%;" placeholder="Enter office fax no."
             @if($studentInfo != NULL)
             value="{{$studentInfo->mfax}}"
             @endif                                             
           >
    </div>
    <div class="col-md-12">
    <label>EMAIL ADDRESS: </label>
    <input type="text" class="form-control" name="memail" id="memail" style="width: 77.3%;" placeholder="Enter email"
             @if($studentInfo != NULL)
             value="{{$studentInfo->memail}}"
             @endif                                             
           >
    </div>
        </div>        
    </td>    
    </tr>
    
  </tbody>
  </table>


</div>    


<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo5"><strong>RESIDENCE AND TRANSPORTATION DATA</strong></button>
 <div id="demo5" class="collapse">
  
            
  <table class="table">
    <tbody>
    
    <tr>       
    <td> 
        
    <div class="col-md-4">
      <label>RESIDENCE TYPE : </label> 
      <select style = "width: 140px"class="form-control" name="residence" id="residence">
        <option value="HOUSE">HOUSE</option>
        <option value="APARTMENT">APARTMENT</option>
        <option value="CONDOMINIUM">CONDOMINIUM</option>
        <option value="TOWNHOUSE">TOWNHOUSE</option>
      </select> 
    </div>
        
        <div class="col-md-4">
      <label>OWNERSHIP OF RESIDENCE: </label> 
      <select style = "width: 190px"class="form-control" name="ownership" id="ownership">
        <option value="OWN">OWN</option>
        <option value="RENTED">RENTED</option>
        <option value="WITH PARENTS">LIVING WITH PARENTS</option>
      </select>
    </div>
        
        <div class="col-md-4">
      <label>NUMBER OF HOUSEHOLD HELPER(S) </label> 
      <input type="text" style = "width: 115px"class="form-control" name="numHouseHelp" id="numHouseHelp" placeholder="Enter number"
             @if($studentInfo != NULL)
             value="{{$studentInfo->numHouseHelp}}"
             @endif             
             >
    </div>
    </td>
    </tr>
        
    <tr>
    <td>    
    <div class="col-md-4">
      <label>MEANS OF TRANSPORTATION : </label> 
      <select style = "width: 140px"class="form-control" name="transportation" id="transportation">
        <option value="COMMUTE">COMMUTE</option>
        <option value="SCHOOL BUS">SCHOOL BUS</option>
        <option value="OWN">OWN VEHICLE</option>
      </select>
    </div>

    <div class="col-md-4" id="carcount">
      <label>HOW MANY? </label> 
      <input type="text" style = "width: 115px"class="form-control" name="carcount" placeholder="Enter number"
             @if($studentInfo != NULL)
             value="{{$studentInfo->carcount}}"
             @endif             
             >
    </div>        
        
        <div class="col-md-4">
      <label>DO YOU HAVE A COMPUTER AT HOME? </label> 
      <select style = "width: 80px" class="form-control" name="haveComputer" id="haveComputer">
        <option value="1">YES</option>
        <option value="0">NO</option>
      </select>
    </div>
        
    </td>
    </tr>
        
    <tr>       
    <td>         
        <div class="col-md-5">
      <label>DO YOU HAVE AN INTERNET CONNECTION AT HOME? </label> 
      <select style = "width: 80px" class="form-control" name="haveInternet" id="haveInternet">
        <option value="1">YES</option>
        <option value="0">NO</option>
      </select>
    </div> 
        
        
      <div class="col-md-5">
      <label>     IF YES, WHAT TYPE OF INTERNET CONNECTION? </label> 
      <select style = "width: 110px" class="form-control" name="internetType" id="internetType">
        <option value="DSL">DSL</option>
        <option value="WIRELESS">WIRELESS</option>
        <option value="DIAL-UP">DIAL-UP</option>
        <option value="OTHERS">OTHERS</option>        
      </select>
    </div>
        
    </td>    
    </tr>    
    
    
  </tbody>
  </table>


</div>
<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo6 "><strong>SIBLING DATA</strong></button>
<div class="collapse" id="demo6">
  <table class="table">
      <thead>
      <th class="col-sm-2">Name of student according to age (eldest to youngest)</th>
      <th class="col-sm-2">Birthday</th>
      <th class="col-sm-2">Gender</th>
      <th class="col-sm-2">Civil Status</th>
      <th class="col-sm-1">Working</th>
      <th class="col-sm-1">Studying</th>
      <th class="col-sm-2">Where</th>
      </thead>
    <tbody>
<?php 
$numberofrow = 10;
for($counter = 1;$counter<=$numberofrow;$counter++){ ?>


    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling<?php echo $counter;?>" placeholder="Enter name" 
             @if($sibling != NULL)
             value="{{$sibling[$counter-1]->name}}"
             @endif                
               >
    </td>
    <td> 
        <input type="text" name="siblingbday<?php echo $counter;?>" class="form-control datepicker" 
             @if($sibling != NULL)
             value="{{$sibling[$counter-1]->birthdate}}"
             @endif                
               />
    </td>
    <td> 
      <select class="form-control" name="siblinggender<?php echo $counter;?>" id="siblinggender<?php echo $counter;?>">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="siblingstatus<?php echo $counter;?>" id="siblingstatus<?php echo $counter;?>">
        <option value="SINGLE">SINGLE</option>
        <option value="MARRIED">MARRIED</option>
        <option value="DIVORCED">DIVORCED</option>
        <option value="DECEASED">DECEASED</option>
        <option value="WIDOWED">WIDOWED</option>
        <option value="ANNULLED">ANNULLED</option>
        <option value="SEPARATED">SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="working<?php echo $counter;?>" id="working<?php echo $counter;?>">

    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="studying<?php echo $counter;?>" id="studying<?php echo $counter;?>">

    </td>
    <td> 
        <input type="text" class="form-control" name="where<?php echo $counter;?>"
             @if($sibling != NULL)
             value="{{$sibling[$counter-1]->where}}"
             @endif                
               >
    </td>    
    </tr>
    <?php } ?>
<!--    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling2" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling2bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling2gender" id="sibling2gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling2civilstatus" id="sibling2civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling2working" id="sibling2working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling2studying" id="sibling2studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling2workingstudyingwhere">
    </td>    
    </tr>
    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling3" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling3bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling3gender" id="sibling3gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling3civilstatus" id="sibling3civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling3working" id="sibling3working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling3studying" id="sibling3studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling3workingstudyingwhere">
    </td>    
    </tr> 
    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling4" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling4bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling4gender" id="sibling4gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling4civilstatus" id="sibling4civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling4working" id="sibling4working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling4studying" id="sibling4studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling4workingstudyingwhere">
    </td>    
    </tr>
    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling5" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling5bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling5gender" id="sibling5gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling5civilstatus" id="sibling5civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling5working" id="sibling5working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling5studying" id="sibling5studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling5workingstudyingwhere">
    </td>    
    </tr>
    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling6" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling6bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling6gender" id="sibling6gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling6civilstatus" id="sibling6civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling6working" id="sibling6working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling6studying" id="sibling6studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling6workingstudyingwhere">
    </td>    
    </tr>
    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling7" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling7bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling7gender" id="sibling7gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling7civilstatus" id="sibling7civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling7working" id="sibling7working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling7studying" id="sibling7studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling7workingstudyingwhere">
    </td>    
    </tr>
    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling8" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling8bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling8gender" id="sibling8gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling8civilstatus" id="sibling8civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling8working" id="sibling8working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling8studying" id="sibling8studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling8workingstudyingwhere">
    </td>    
    </tr>
    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling9" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling9bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling9gender" id="sibling9gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling9civilstatus" id="sibling9civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling9working" id="sibling9working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling9studying" id="sibling9studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling9workingstudyingwhere">
    </td>    
    </tr>
    <tr>       
    <td> 
        <input type="text" class="form-control" name="sibling10" placeholder="Enter name ">
    </td>
    <td> 
        <input type="text" name="sibling10bday" class="form-control" />
    </td>
    <td> 
      <select class="form-control" name="sibling10gender" id="sibling10gender">
        <option>MALE</option>
        <option>FEMALE</option>
      </select>
    </td>
    <td>
      <select class="form-control" name="sibling10civilstatus" id="sibling10civilstatus">
        <option>SINGLE</option>
        <option>MARRIED</option>
        <option>DIVORCED</option>
        <option>DECEASED</option>
        <option>WIDOWED</option>
        <option>ANNULLED</option>
        <option>SEPARATED</option>
      </select>        
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling10working" id="sibling10working">
    </td>
    <td>
        <input type="checkbox" class="form-control" value="1" name="sibling10studying" id="sibling10studying">
    </td>
    <td> 
        <input type="text" class="form-control" name="sibling10workingstudyingwhere">
    </td>    
    </tr>-->    
  </tbody>
  </table>    
</div>

<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo7 "><strong>CONTACT PERSON IN CASE OF EMERGENCY</strong></button>
<div class="collapse" id="demo7">
    <table class="table">
        <tbody>
            <tr>
                <td>
                    <div class="form-group">
                    <div class="col-md-4">
                    <label>NAME:</label>
                    <input type="text" class="form-control" name="guardianname" id="guardianname" placeholder="Name"
             @if($studentInfo != NULL)
             value="{{$studentInfo->guardianname}}"
             @endif
                           >
                    </div>
                    <div class="col-md-4">
                    <label>CELL NO:</label>
                    <input type="text" class="form-control" name="guardianmobile" id="guardianmobile" placeholder="Contact No."
             @if($studentInfo != NULL)
             value="{{$studentInfo->guardianmobile}}"
             @endif                           
                           >
                    </div>    
                    <div class="col-md-4">
                    <label>RELATIONSHIP:</label>
                    <input type="text" class="form-control" name="guardianrelationship" id="guardianrelationship" placeholder="Relationship"
             @if($studentInfo != NULL)
             value="{{$studentInfo->guardianrelationship}}"
             @endif                           
                           >
                    </div>                        
                    </div>                        
                </td>
            </tr>
        </tbody>
    </table>

</div>
<button type="submit" class="btn btn-primary">Save</button>
 @if($student != NULL)
    <a href="#" id="delete" class="btn btn-primary">Delete</a>
    <a href="{{url('studentinfokto12/'.$student->idno.'/print')}}" id="print" class="btn btn-primary">Print</a>
    <a href="{{url('studentinfokto12')}}" id="print" class="btn btn-primary">Create New</a>
 @endif
    </form>
    
<script>


    $( '#transportation' ).change(function() {
        if ($(this).val() == "OWN"){
            $("#carcount").show();
        }
        else{
            $("#carcount").hide();
        }
    });
    $( "#birthDate" ).change(function() {
        getAge();
    });
    $( ".datepicker" ).click(function() {
        getAge();
    });    
    $( "#age" ).focus(function() {
        getAge();
    });    

function getAge(){
    var bdate = document.getElementById("birthDate").value;
    var date1 = new Date(bdate);
    var date2 = new Date();
    var timeDiff = Math.abs(date2.getYear() - date1.getYear());
    if(date2.getMonth() < date1.getMonth()){
        timeDiff = timeDiff-1;
    }

    document.getElementById("age").value = timeDiff;    
}
@if($student == NULL)
    @if(Auth::guest())
        var varid = 4;
    @else
        var varid = (Auth::User()->id);
    @endif
    
    $.ajax({
     type: "GET", 
     url: "/getid/" + varid , 
     success:function(data){  
        document.getElementById('idno').value = data
     }       
    });
@endif

@if($student != NULL )
    @if($studentInfo->transportation == "OWN")
            $("#carcount").show();
    @else
            $("#carcount").hide();
    @endif
    
    @if($studentInfo->esc == 1)
        document.getElementById("esc").checked = true;
    @endif    
    
    @if($sibling != NULL)    
        <?php $rows = 10;
        for($counter = 1;$counter<=$numberofrow;$counter++){ ?>    
            document.getElementById("siblinggender<?php echo $counter;?>").value = "{{$sibling[$counter-1]->gender== NULL ? 'MALE' : $sibling[$counter-1]->gender}}";
            document.getElementById("siblingstatus<?php echo $counter;?>").value = "{{$sibling[$counter-1]->status== NULL ? 'S' : $sibling[$counter-1]->status}}";                
            @if($sibling[$counter-1]->working == 1)
                document.getElementById("working<?php echo $counter;?>").checked = true;
            @endif 
            @if($sibling[$counter-1]->studying == 1)
                document.getElementById("studying<?php echo $counter;?>").checked = true;
            @endif                 
        <?php } ?>
    @endif

    var date1 = new Date("{{$studentInfo->birthDate}}");
    var date2 = new Date();
    var timeDiff = Math.abs(date2.getYear() - date1.getYear());
    if(date2.getMonth() < date1.getMonth()){
        timeDiff = timeDiff-1;
    }

    document.getElementById("age").value = timeDiff;
    document.getElementById("status").value = "{{ $studentInfo->status == NULL ? 'S' : $studentInfo->status }}"; 
    
    document.getElementById("fselfemployed").value = "{{$studentInfo->fselfemployed== NULL ? '0' : $studentInfo->fselfemployed}}";
    document.getElementById("falumnus").value = "{{$studentInfo->falumnus== NULL ? '0' : $studentInfo->falumnus}}";    
    document.getElementById("fstatus").value = "{{$studentInfo->fstatus== NULL ? 'S' : $studentInfo->fstatus}}";
    document.getElementById("fposition").value = "{{$studentInfo->fposition== NULL ? 'T' : $studentInfo->fposition}}";

    document.getElementById("mselfemployed").value = "{{$studentInfo->mselfemployed == NULL ? '0' : $studentInfo->mselfemployed}}";
    document.getElementById("mstatus").value = "{{$studentInfo->mstatus== NULL ? 'S' : $studentInfo->mstatus}}";
    document.getElementById("mposition").value = "{{$studentInfo->mposition== NULL ? 'T' : $studentInfo->mposition}}";
    
    document.getElementById("residence").value = "{{$studentInfo->residence== NULL ? 'HOUSE' : $studentInfo->residence}}";
    document.getElementById("ownership").value = "{{$studentInfo->ownership== NULL ? 'OWN' : $studentInfo->ownership}}";    
    document.getElementById("transportation").value = "{{$studentInfo->transportation== NULL ? 'COMMUTE' : $studentInfo->transportation}}";
    document.getElementById("haveComputer").value = "{{$studentInfo->haveComputer== NULL ? '0' : $studentInfo->haveComputer}}";    
    document.getElementById("haveInternet").value = "{{$studentInfo->haveInternet== NULL ? '0' : $studentInfo->haveInternet}}";    
    document.getElementById("internetType").value = "{{$studentInfo->internetType== NULL ? 'DSL' : $studentInfo->internetType}}";    

    $( "#delete" ).click(function() {
        var r = confirm("Are you sure you want to delete this student's information");
        if (r === true) {
           var url="{{url('studentinfokto12/'.$student->idno.'/delete')}}";
           $(location).attr('href',url);
        }      
    });    

@endif


</script>    
</div>








<!-- <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo1"><strong>STEP 2:</strong>Educational Record</button>
 <div id="demo1" class="collapse">
    
    <div class="form-group">
    <div class="col-xs-4">
    <label>COLLEGE SCHOOLING AT:</label>
    <input type="text" class="form-control" name="collegesch" id="collegsch" placeholder="Enter info here">
    </div>
    </div>
        
    <div class="form-group">
    <div class="col-xs-4">
    <label>YEAR ATTENDED:</label>
    <input type="text" class="form-control" name="yrattended" id="yrattended" placeholder="Enter year attended">
    </div>
    </div>    
    
    <div class="form-group">
    <div class="col-xs-4">
    <label>COURSE:</label>
    <input type="text" class="form-control" name="course" id="collegecourse" placeholder="Enter course">
    </div>
    </div>
    
    <div class="form-group">
    <div class="col-xs-6">
    <label>HIGHSCHOOL:</label>
    <input type="text" class="form-control" name="hs" id="hs" placeholder="Enter info here">
    </div>
    </div>
        
    <div class="form-group">
    <div class="col-xs-6">
    <label>YEAR GRADUATED:</label>
    <input type="text" class="form-control" name="yrgradhs" id="yrgradhs" placeholder="Enter year graduated">
    </div>
    </div>    
 
    <div class="form-group">
    <div class="col-xs-6">
    <label>ELEMENTARY:</label>
    <input type="text" class="form-control" name="elem" id="elem" placeholder="Enter info here">
    </div>
    </div>
        
    <div class="form-group">
    <div class="col-xs-6">
    <label>YEAR GRADUATED:</label>
    <input type="text" class="form-control" name="yrgradelem" id="yrgradelem" placeholder="Enter year graduated">
    </div>
    </div>    
</div> 
      
       
<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo2"><strong>STEP 3:</strong>Select Course/s</button>
 <div id="demo2" class="collapse">
    <label>DEGREE COURSES:</label> 
    <div class="checkbox">
      <label><input type="checkbox" name="beed" value="1">BS Elementary Education</label>
    </div>
     <div class="checkbox">
      <label><strong>BS Secondary Education</strong></label> <br> 
      <label><input type="checkbox" name="english" value="1">Major in English</label>
    </div>
    <div class="checkbox">
      <label><input type="checkbox" name="mapeh" value="1">Major in MAPEH</label>
    </div>
    <div class="checkbox">
      <label><input type="checkbox" name="math" value="1">Major in Mathematics</label>
    </div>
    <div class="checkbox">
      <label><input type="checkbox" name="social" value="1">Major in Social Studies</label>
    </div>
    <div class="checkbox">
    <label><input type="checkbox" name="accountancy" value="1">BS Accountancy</label>
    </div>
     <div class="checkbox">
      <label><input type="checkbox" name="accountingtech" value="1">BS Accounting Technology</label>
    </div>
    <div class="checkbox">
      <label><input type="checkbox" name="realestate" value="1">BS Real Estate Management</label>
    </div>
    <div class="checkbox">
    <label><strong>BS Business Administration</strong></label> <br> 
    <label><input type="checkbox" name="hrdm" value="1">Major in Human Resource Development Management</label>
    </div>
    <div class="checkbox">
    <label><input type="checkbox" name="bf" value="1">Major in Banking and Finance</label>
    </div>
    <label>TESDA COURSES:</label>
    <div class="checkbox">
    <label><input type="checkbox" name="hrm" value="1">Diploma in Hotel and Restaurant Management</label>
    </div>
    <div class="checkbox">
    <label><input type="checkbox" name="it" value="1">Diploma in Information Technology</label>
    </div>
</div>

 <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo3"><strong>STEP 4:</strong>Requirements Submitted</button>
 <div id="demo3" class="collapse">
      Please check the requirements submitted to the Registrar.<br>
    <label>Incoming First Year</label>     
    <div class="checkbox">
      <label><input type="checkbox" name="reporcard" value="1">Report Card</label>
    </div>
     <div class="checkbox">
      <label><input type="checkbox" name="form137" value="1">Form 137</label>
    </div>
    <div class="checkbox">
      <label><input type="checkbox" name="nso" value="1">NSO Birth Certificate</label>
    </div>
    <div class="checkbox">
      <label><input type="checkbox" name="goodmoral" value="1">Certification of Good Moral Character</label>
    </div>
    <div class="checkbox">
    <label><input type="checkbox" name="picture" value="1">2 x 2 Picture</label>
    </div>
    <label>Transferees</label>    
    <div class="checkbox">
    <label><input type="checkbox" name="hdismissal" value="1">Certification of Honorable Dismissal</label>
    </div>
    <div class="checkbox">
    <label><input type="checkbox" name="grades" value="1">Certification of Grades</label>
    </div>
    <div class="checkbox">
    <label><input type="checkbox" name="goodmoraltrans" value="1">Certification of Good Moral Character</label>
    </div>
    <div class="checkbox">
    <label><input type="checkbox" name="nsotrans" value="1">NSO Birth Certificate </label>
    </div>
    <div class="checkbox">
    <label><input type="checkbox" name="picturetrans" value="1">2x2 Picture</label>
    </div>   
<button type="submit" class="btn btn-info">Submit</button> 
</div>
   
</div>

-->

@endsection