<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
define('AWS_CLOUD',env('AWS_CLOUDFRONT'));
Route::get('/', function () {
    return view('auth.login');
});
Route::get('registration','UserController@create');
Route::post('registration','UserController@store');
Route::get('login','UserController@login');
Route::get('/logout','UserController@logout');	
Route::resource('/order','OrderController');
Route::get('orders/{id?}','OrderController@orders');
Route::get('/update-order-status/{order_id}/{user_id}/{order_Status}','OrderController@update_order_status');
Route::post('/update-order-status','OrderController@update_order_status1');
Auth::routes();
Route::post('/dologin','UserController@dologin');
 
  Route::get('cron-job','UserController@cron_job');
// For paytm android api
Route::post('paytm-payment-checksum','OrderController@paytm_payment_checksum');
Route::post('verify-checksum','OrderController@verify_checksum');
Route::post('paytm-callback','OrderController@paytmCallback');
Route::post('/order-details-save','OrderController@order_details_save');
Route::post('/forget-password','UserController@forget_password');

Route::get('demo',function(){
	broadcast(new WebsocketDemoEvent('some data'));
	return view('welcome');
});

Broadcast::routes(['middleware' => 'auth:admin']);


 Route::get('/firebase-get-data','FirebaseController@getData');
 // For route authentication group
 Route::group(['middleware' => ['auth']], function () {
 Route::get('/dashboard','DashboardController@index');	
   Route::get('match-code','UserController@match_code');
 // Lottery
 Route::resource('lottery','LotteryController');		
 Route::get('count-lottery-ticket','LotteryController@count_lottery_ticket');		
 //Route::get('/count-lottery-ticket','LotteryController@index');		

 Route::get('show-winner-name','LotteryController@show_winner_name');		
 Route::get('show-winner-number','LotteryController@show_winner_number');		
 Route::resource('voucher-Generate','VoucherGenerateController');		
 Route::get('invoice/{id}','VoucherGenerateController@invoice_voucher');		
 Route::resource('lottery-Content','LotteryContentController');		
 Route::resource('addlotteryticket','AddLotteryTicketController');	
 Route::resource('voucher','VoucherController');	
 Route::resource('commission','CommissionController');	
 Route::resource('withdraw','WithdrawController');	
 Route::get('approve-withdraw-request/{id}','WithdrawController@approve_withdraw_request');	
 
 Route::resource('/users','UserController');
 Route::resource('pastwinner','PastWinnerController');
 Route::resource('sociallink','SocialLinkController');

 
 Route::get('/phpfirebase_sdk','FirebaseController@index');

 
 Route::get('orders/{id?}','OrderController@orders');	
 Route::resource('code','CodeController');	
 Route::resource('user','UserController');	
 Route::get('send-mail','UserController@send_mail');	
 Route::get('agent','UserController@agent');	
 Route::get('user-history/{id}','UserController@user_history');
 Route::get('agent-history/{id}','UserController@agent_history');
 Route::get('agent-code-listing/{date}/{id}','UserController@agent_code_listing');
 
 // Content page
  Route::resource('content','ContentController');	
  Route::resource('home','HomeController');	
  Route::resource('about','AboutController');	
  Route::resource('faq','FaqsController');	 
  Route::resource('contact','ContactController');
  Route::resource('privacy','PrivacyController');
  Route::resource('termandcondition','TermAndConditionController');
  // match code
 
  
  Route::get('agent-transaction','TransactionController@agent_transaction');
  Route::get('agent-transaction-pdf/{search}/{from}/{to}','TransactionController@agent_transaction_pdf');


 
 Route::resource('/category','CategoryController');
 Route::POST('/update-order','CategoryController@update_order');
 Route::resource('/studymaterial','StudymaterialController');
 Route::resource('/examtest','ExamTestController');
 Route::get('/gettest_list','ExamtestController@gettest_list');
 Route::get('/exam_import','ExamtestController@exam_import');
 Route::get('/export','ExamTestController@export');
 Route::post('/exam-serious-import', 'ExamTestController@exam_serious_import');
 Route::get('/deletetest_list','ExamtestController@deletetest_list');
 Route::get('/edittest_list','ExamtestController@edittest_list');
 Route::resource('/subcategory','SubcategoryController');
 Route::POST('/update-order-subcategory','SubcategoryController@update_order_subcategory');
 
 
 Route::resource('/banner','BannerController');
 Route::get('/ajax','StudymaterialController@ajax');
 Route::get('profile','UserController@profile');
 Route::post('update-profile','UserController@update_profile');
 Route::post('update-status','UserController@update_status');	
 Route::post('save-study-views','StudymaterialController@save_study_views');
 Route::get('get-views/{id}','StudymaterialController@get_views');
 Route::get('get-isdeleted','StudymaterialController@get_isdeleted');
 Route::post('updateis-deleted','StudymaterialController@updateis_deleted');
 Route::get('get-user','StudymaterialController@get_user');
 Route::post('updateuser-store','StudymaterialController@updateuser_store');
 
  Route::resource('admission','AdmissionController');
  Route::resource('innercategory','InnercategoryController');
  Route::POST('update-order-innercategory','InnercategoryController@update_order_innercategory');
  Route::resource('setting','SettingController');
  //for change password
  Route::get('/changepassword','UserController@showchangepasswordform');
  Route::post('change-password','UserController@changepassword');
////////////////FOR ADD NEW TEACHERS
Route::get('admin','AdminController@index');
Route::get('admin/create','AdminController@create');
Route::post('admin/store','AdminController@store');
Route::get('admin/{id}/edit','AdminController@edit');
Route::post('admin/update/{id}','AdminController@update');
Route::post('admin/{id}','AdminController@destroy');
Route::get('admin/{id}','AdminController@show');
////////////////FOR GLOBAL SETTING
Route::resource('globalsetting','GlobalsettingController');
////////////////FOR Teacher Incentive SETTING
Route::resource('teacherincentivesetting','TeacherincentivesettingController');
//////////////FOR DISCUSS SECTION
Route::get('discuss','DiscussController@index');
 Route::post('update-discuss-status','DiscussController@store');
////////////////FOR PLAN 
Route::resource('plan','PlanController');
Route::post('update-incentive','PlanController@update_incentive');
////////////////FOR TEACHER Incentive 
Route::resource('teacherincentive','TeacherincentiveController');
	//////////////////////////////////////
////////////////FOR Subinnercategory 
Route::resource('subinnnercategory','SubinnnercategoryController');
////////////////FOR STATEMENT 
Route::resource('transaction','TransactionController');
Route::get('/statement-pdf/{search}/{from}/{to}','TransactionController@statement_pdf');



////////////////For PaymentController
Route::resource('payment','PaymentController');
Route::get('payment/print-voucher/{id}','PaymentController@print_voucher');
Route::get('payment/pdf-view/{id?}','PaymentController@pdf_view');
// Notification Send
Route::get('notification','UserController@notification_show');
Route::post('send-notification-users','UserController@send_notification_users');

Route::get("test-mail","UserController@test_mail");
Route::get('test', function () {
      Mail::to('trilok@b2infosoft.com')->send(new TestAmazonSes("It works!"));
});
});
//fullcalendersend_notification_users

Route::get('/fullcalendareventmaster','EventController@index');
Route::get('/fullcalendareventmaster/create','EventController@create');
Route::post('/fullcalendareventmaster/store','EventController@store');
Route::post('/fullcalendareventmaster/update','EventController@update');
Route::post('/fullcalendareventmaster/delete','EventController@destroy');
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    return 'success';
});
Route::get('qr-code/{qr}','QrCodeController@index');
