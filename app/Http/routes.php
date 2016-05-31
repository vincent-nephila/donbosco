<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/






/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
  


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
    //accounting module
    Route::get('accounting/{idno}','Accounting\AccountingController@view');
    Route::post('debitcredit','Accounting\AccountingController@debitcredit');
    Route::get('viewdm/{refno}/{idno}','Accounting\AccountingController@viewdm');
    Route::get('printdmcm/{refno}/{idno}','Accounting\AccountingController@printdmcm');
    Route::get('dmcmreport/{transationdate}','Accounting\AccountingController@dmcmreport');
    Route::get('collectionreport/{datefrom}/{dateto}','Accounting\AccountingController@collectionreport');
    Route::get('printdmcmreport/{idno}/{transactiondate}','Accounting\AccountingController@printdmcmreport');
    Route::get('summarymain','Accounting\AccountingController@summarymain');
    Route::get('maincollection/{transactiondate}','Accounting\AccountingController@maincollection');
    Route::get('studentledger/{level}','Accounting\AccountingController@studentledger');
    Route::get('cashcollection/{transactiondate}','Accounting\AccountingController@cashcollection');
    Route::get('overallcollection/{transactiondate}','Accounting\AccountingController@overallcollection');
    Route::get('printactualoverall/{transactiondate}','Accounting\AccountingController@printactualoverall');
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
    Route::get('/getsectionlist/{level}/{section}','AjaxController@getsectionlist');
    Route::get('/setsection/{id}/{section}','AjaxController@setsection');
    Route::get('/rmsection/{id}','AjaxController@rmsection');
    Route::get('/getstrand/{level}','AjaxController@getstrand');
    Route::get('/updateadviser/{id}/{value}','AjaxController@updateadviser');
    
    //Ajax Route Sheryl
   
    