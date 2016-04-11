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
    Route::get('registrar/assessment','Registrar\AssessmentController@index');
    Route::get('registrar/show', 'Registrar\AssessmentController@show');
    Route::get('registrar/evaluate/{id}','Registrar\AssessmentController@evaluate');
    Route::get('registrar/edit/{id}','Registrar\AssessmentController@edit');
    Route::post('registrar/editname','Registrar\AssessmentController@editname');
    Route::post('registrar/assessment','Registrar\AssessmentController@assess');
    Route::get('studentregister', 'MainController@getid');
    Route::post('studentregister', 'MainController@addstudent');
    //cashier module
    Route::get('cashier/{idno}','Cashier\CashierController@view');
    Route::post('payment','Cashier\CashierController@payment');
    Route::get('/setreceipt/{id}','Cashier\CashierController@setreceipt');
    Route::post('/setreceipt','Cashier\CashierController@setOR');
    Route::get('/viewreceipt/{refno}/{idno}','Cashier\CashierController@viewreceipt');
    Route::get('/otherpayment/{idno}','Cashier\CashierController@otherpayment');
    Route::post('/othercollection','Cashier\CashierController@othercollection');
    Route::get('collectionreport','Cashier\CashierController@collectionreport');
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
    Route::get('actualcashcheck','Cashier\CashierController@actualcashcheck');
    Route::get('printencashment/{idno}','Cashier\CashierController@printencashment');
   
});


//Ajax route

    Route::get('/getid/{varid}','AjaxController@getid');
    Route::get('/getlevel/{vardepartment}','AjaxController@getlevel');
    Route::get('/gettrack/{vardepartment}','AjaxController@gettrack');
    Route::get('/getplan/{varlevelcourse}/{vardepartment}','AjaxController@getplan');
    Route::get('/gettrackplan','AjaxController@gettrackplan');
    Route::get('/getdiscount','AjaxController@getdiscount');
    Route::get('/getsearch/{varsearch}','AjaxController@getsearch');
    Route::get('/getsearchcashier/{varsearch}','AjaxController@getsearchcashier');
    Route::get('/compute','AjaxController@compute');
    Route::get('/getpaymenttype/{ptype}','AjaxController@getpaymenttype');
    Route::get('/getparticular/{group}/{particular}','AjaxController@getparticular');
    Route::get('/getprevious/{idno}/{schoolyear}','AjaxController@getprevious');
    

    
    