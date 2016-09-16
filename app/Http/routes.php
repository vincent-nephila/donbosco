<?php
    Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'MainController@index');
    //Registrar module
    Route::get('studentlist','Registrar\StudentlistController@studentlist');
    Route::get('enrollmentstat','Registrar\EnrollmentstatController@enrollmentstat');
    Route::get('registrar/assessment','Registrar\AssessmentController@index');
    Route::get('registrar/show', 'Registrar\AssessmentController@show');
    Route::get('registrar/evaluate/{id}','Registrar\AssessmentController@evaluate');
    Route::get('registrar/edit/{id}','Registrar\AssessmentController@edit');
    Route::post('registrar/editname','Registrar\AssessmentController@editname');
    Route::post('registrar/assessment','Registrar\AssessmentController@assess');
    Route::get('studentregister', 'MainController@getid');
    Route::post('studentregister', 'MainController@addstudent');
    Route::get('sectionk','Registrar\SectionController@sectionk');
    Route::get('printsection/{level}/{section}/{strand}', 'Registrar\SectionController@printsection1');
    Route::get('printsection/{level}/{section}', 'Registrar\SectionController@printsection');
    Route::get('printinfo','Registrar\StudentlistController@printinfo');
     Route::get('studentinfokto12/{idno}','Registrar\Studentinfokto12Controller@studentinfokto12edit');
    Route::post('studentinfokto12/{idno}','Registrar\Studentinfokto12Controller@updateInfo');
    Route::get('studentinfokto12/{idno}/delete','Registrar\Studentinfokto12Controller@deleteStudent');
    Route::get('studentinfokto12/{idno}/print','Registrar\Studentinfokto12Controller@printInfo');    
    Route::get('studentinfokto12','Registrar\Studentinfokto12Controller@studentinfokto12');
    Route::post('studentinfokto12','Registrar\Studentinfokto12Controller@saveInfo');
    Route::get('importGrade', 'ExportController@importGrade');
    Route::post('importConduct', 'ExportController@importExcelConduct');
    Route::post('importAttendance', 'ExportController@importExcelAttendance');
    Route::post('importGrade', 'ExportController@importExcelGrade');
    Route::post('importCompetence', 'ExportController@importExcelCompetence');
    
     Route::get('/seegrade/{idno}','Registrar\GradeController@seegrade');
     Route::get('printreportcard','Registrar\GradeController@printreportcard');
     //Vincent Registrar
     Route::get('/printsheetA/{level}/{section}/{subject}', 'Vincent\ReportController@printSheetAElem');
     Route::get('conduct', 'Vincent\ReportController@conduct');
     Route::get('sheetaconduct/{level}/{section}/{quarter}', 'Vincent\ReportController@printSheetAConduct');
     Route::get('sheetaAttendance/{level}/{section}/{quarter}', 'Vincent\ReportController@printSheetaAttendance');
     Route::get('attendance', 'Vincent\ReportController@attendance');
     Route::get('/sheetb', 'Vincent\ReportController@sheetB');
    
//cashier module
    Route::get('cashier/{idno}','Cashier\CashierController@view');
    Route::post('payment','Cashier\CashierController@payment');
    Route::get('/setreceipt/{id}','Cashier\CashierController@setreceipt');
    Route::post('/setreceipt','Cashier\CashierController@setOR');
    Route::get('/viewreceipt/{refno}/{idno}','Cashier\CashierController@viewreceipt');
    Route::get('/otherpayment/{idno}','Cashier\CashierController@otherpayment');
    Route::post('/othercollection','Cashier\CashierController@othercollection');
    Route::get('collectionreport/{transactiondate}','Cashier\CashierController@collectionreport');
    Route::get('cancell/{refno}/{idno}','Cashier\CashierController@cancell');
    Route::get('restore/{refno}/{idno}','Cashier\CashierController@restore');
    Route::get('encashment','Cashier\CashierController@encashment');
    Route::post('encashment','Cashier\CashierController@postencashment');
    Route::get('encashmentreport','Cashier\CashierController@encashmentreport');
    Route::get('viewencashmentdetail/{refno}', 'Cashier\CashierController@viewencashmentdetail');
    Route::get('reverseencashment/{refno}', 'Cashier\CashierController@reverseencashment');
    Route::get('printregistration/{idno}','Registrar\AssessmentController@printregistration');
    Route::get('/printreceipt/{refno}/{idno}','Cashier\CashierController@printreceipt');
    Route::get('previous/{idno}','Cashier\CashierController@previous');
    Route::get('actualcashcheck/{batch}/{transactiondate}','Cashier\CashierController@actualcashcheck');
    Route::get('printencashment/{idno}','Cashier\CashierController@printencashment');
    Route::get('printcollection/{idno}/{transactiondate}','Cashier\CashierController@printcollection');
    Route::get('nonstudent','Cashier\CashierController@nonstudent');
    Route::post('nonstudent','Cashier\CashierController@postnonstudent');
    Route::get('checklist','Cashier\CashierController@checklist');
    Route::post('postactual','Cashier\CashierController@postactual');
    Route::get('printactualcash/{transactiondate}','Cashier\CashierController@printactualcash');
    Route::get('actualdeposit/{trasactiondate}', 'Cashier\CashierController@actualdeposit');
    Route::get('cutoff/{transactiondate}','Cashier\CashierController@cutoff');
    Route::get('printactualdeposit/{transactiondate}', 'Cashier\CashierController@printactualdeposit');
    Route::get('addtoaccount/{studentid}','Cashier\CashierController@addtoaccount');
    Route::post('addtoaccount','Cashier\CashierController@posttoaccount');
    Route::get('addtoaccountdelete/{id}','Cashier\CashierController@addtoaccountdelete');
     
    //accounting module
    Route::get('accounting/{idno}','Accounting\AccountingController@view');
    Route::post('debitcredit','Accounting\AccountingController@debitcredit');
    Route::get('viewdm/{refno}/{idno}','Accounting\AccountingController@viewdm');
    Route::get('printdmcm/{refno}/{idno}','Accounting\AccountingController@printdmcm');
    Route::get('dmcmreport/{transationdate}','Accounting\AccountingController@dmcmreport');
    Route::get('dmcmallreport/{transactiondate}','Accounting\AccountingController@dmcmallreport');
    Route::get('collectionreport/{datefrom}/{dateto}','Accounting\AccountingController@collectionreport');
    Route::get('printdmcmreport/{idno}/{transactiondate}','Accounting\AccountingController@printdmcmreport');
    Route::get('summarymain','Accounting\AccountingController@summarymain');
    Route::get('maincollection/{transactiondate}','Accounting\AccountingController@maincollection');
    Route::get('studentledger/{level}','Accounting\AccountingController@studentledger');
    Route::get('cashcollection/{transactiondate}','Accounting\AccountingController@cashcollection');
    Route::get('overallcollection/{transactiondate}','Accounting\AccountingController@overallcollection');
    Route::get('printactualoverall/{transactiondate}','Accounting\AccountingController@printactualoverall');
    Route::get('cashreceipts/{transactiondate}','Accounting\AccountingController@cashreceipts');
    Route::get('statementofaccount','Accounting\AccountingController@statementofaccount');
    Route::get('printsoa/{idno}/{tradate}','Accounting\AccountingController@printsoa');
    Route::get('/getsoasummary/{level}/{strand}/{section}/{trandate}/{plan}/{amtover}','Accounting\AccountingController@getsoasummary');
    Route::get('/printsoasummary/{level}/{strand}/{section}/{trandate}/{plan}/{amtover}','Accounting\AccountingController@printsoasummary');
    Route::get('penalties','Accounting\AccountingController@penalties');
    Route::post('postpenalties','Accounting\AccountingController@postpenalties');
    Route::get('subsidiary','Accounting\AccountingController@subsidiary');
    Route::post('subsidiary','Accounting\AccountingController@postsubsidiary');
    //update module
    //Elective submitted by registrar on STEM
    //Route::get('updateelective','Registrar\AssessmentController@updateelective');
    //Update grades of students
    //Route::get('updategrades','Registrar\AssessmentController@updategrades');
    //Route::get('updatemapeh','Registrar\AssessmentController@updatemapeh');
    //Route::get('updatehsconduct','Update\UpdateController@updatehsconduct');
    //Route::get('updatehsgrade','Update\UpdateController@updatehsgrade');
    //Route::get('checkno','Update\UpdateController@checkno');
    Route::get('updatehsattendance','Update\UpdateController@updatehsattendance');
    //Registrar Vincent
    Route::get('/reportcards/{level}/{section}/{side}','Vincent\GradeController@viewSectionGrade');    
    Route::get('/reportcard/{level}/{section}/{quarter}/{side}','Vincent\GradeController@viewSectionKinder');    
    Route::get('/reportcards/{level}/{shop}/{section}/{side}','Vincent\GradeController@viewSectionGrade9to10');    
    Route::get('/resetgrades','Vincent\GradeController@reset');  
    Route::get('/studentgrade/{idno}','Vincent\GradeController@studentGrade'); 
    Route::get('sheetA','Vincent\ReportController@sheetA'); 
    
});

//Ajax route
   Route::get('/myDeposit','AjaxController@myDeposit');
    Route::get('/getid/{varid}','AjaxController@getid');
    Route::get('/getlevel/{vardepartment}','AjaxController@getlevel');
    Route::get('/gettrack/{vardepartment}','AjaxController@gettrack');
    Route::get('/getplan/{varlevelcourse}/{vardepartment}','AjaxController@getplan');
    Route::get('/gettrackplan','AjaxController@gettrackplan');
    Route::get('/getdiscount','AjaxController@getdiscount');
    Route::get('/getsearch/{varsearch}','AjaxController@getsearch');
    Route::get('/getsearchcashier/{varsearch}','AjaxController@getsearchcashier');
    Route::get('/getsearchaccounting/{varsearch}','AjaxController@getsearchaccounting');
    Route::get('/compute','AjaxController@compute');
    Route::get('/getpaymenttype/{ptype}','AjaxController@getpaymenttype');
    Route::get('/getparticular/{group}/{particular}','AjaxController@getparticular');
    Route::get('/getprevious/{idno}/{schoolyear}','AjaxController@getprevious');
    Route::get('/studentlist/{level}','AjaxController@studentlist');
    Route::get('/strand/{strand}/{level}','AjaxController@strand');
    Route::get('/removeslip/{refid}','AjaxController@removeslip');
    Route::get('/getstudentlist/{level}','AjaxController@getstudentlist');
    Route::get('/getsection/{level}','AjaxController@getsection');
    Route::get('/getsection1/{level}','AjaxController@getsection1');
    Route::get('/getsectionlist/{level}/{section}','AjaxController@getsectionlist');
    Route::get('/setsection/{id}/{section}','AjaxController@setsection');
    Route::get('/rmsection/{id}','AjaxController@rmsection');
    Route::get('/getstrand/{level}','AjaxController@getstrand');
    Route::get('/updateadviser/{id}/{value}','AjaxController@updateadviser');
    Route::get('/getsectionstrand/{level}/{strand}','AjaxController@getsectionstrand');
    Route::get('/displaygrade','AjaxController@displaygrade');
   // Route::get('/getsoasummary/{level}/{strand}/{section}/{trandate}','AjaxController@getsoasummary');
   
    //Ajax Route Sheryl
   
    //AJAX Vincent
    Route::get('/showgrades', 'Vincent\AjaxController@showgrades');
    Route::get('/showgradestvet', 'Vincent\AjaxController@showgradestvet');
    Route::get('/setacadrank', 'Vincent\AjaxController@setRankingAcad');
    Route::get('/settechrank', 'Vincent\AjaxController@setRankingTech');
    Route::get('/getsection1/{level}','Vincent\AjaxController@getsection1');
    Route::get('/getstrand/{level}','Vincent\AjaxController@getstrand');
    Route::get('/getadviser','Vincent\AjaxController@getadviser');
    Route::get('/getsection/{level}','Vincent\AjaxController@getsection');
    Route::get('/getsubjects/{level}','Vincent\AjaxController@getsubjects');
    Route::get('/getdays','Vincent\AjaxController@getdos');
    Route::get('/getlist/{level}/{section}','AjaxController@studentContact');


  
