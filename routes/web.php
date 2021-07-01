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




Route::get('/', 'UserController@login');

Route::get('registration','UserController@create');
Route::post('registration','UserController@store');
 Route::get('my-history','UserController@my_history');
Route::get('/logout','UserController@logout');	
Route::resource('/order','OrderController');
Route::get('orders/{id?}','OrderController@orders');
Route::get('/update-order-status/{order_id}/{user_id}/{order_Status}','OrderController@update_order_status');
Route::post('/update-order-status','OrderController@update_order_status1');
Auth::routes();
Route::post('dologin','UserController@dologin');
Route::get('about','DashboardController@about');
Route::get('contacts','DashboardController@contact');
Route::get('faqs','DashboardController@faqs');
Route::get('privacy','DashboardController@privacy');
Route::get('term-and-condition','DashboardController@term_and_condition');
Route::get('past-winners','DashboardController@past_winners');
Route::get('register-success','UserController@register_success');
 
 

// For paytm android api
Route::post('paytm-payment-checksum','OrderController@paytm_payment_checksum');
Route::post('verify-checksum','OrderController@verify_checksum');
Route::post('paytm-callback','OrderController@paytmCallback');
Route::post('/order-details-save','OrderController@order_details_save');
Route::get('forget-password','UserController@forget_password_show');
Route::post('forget-password','UserController@forget_password');


Route::get('stripe', 'StripePaymentController@index');
Route::post('stripe', 'StripePaymentController@stripePost');

Broadcast::routes(['middleware' => 'auth:admin']);


 
  // Lottery
  //Route::resource('lottery','LotteryController');
 Route::resource('lottery','LotteryController');	
 Route::get('lottery','LotteryController@lottery2');	
 Route::get('lottery2','LotteryController@lottery2');	
 Route::get('lottery-detail','LotteryController@lottery_detail');	
 Route::get('lottery1','LotteryController@lottery1');	
 Route::get('lottery-signin','LotteryController@lottery_signin');	
 Route::get('signin','UserController@signin');	
 Route::get('signup/{referrer?}','UserController@signup');	
 Route::post('signup','UserController@store');	

 
 Route::get('paypal-view', 'PayPalController@view');

 Route::get('verify/{email}/{token}','UserController@verifyUser');
 
 // For route authentication group
 Route::group(['middleware' => ['auth']], function () {
 Route::get('/dashboard','DashboardController@demo');	
 Route::get('profile','UserController@profile');
 Route::get('add-money','UserController@add_money');
 Route::post('user-money','UserController@user_money');
 Route::post('update-profile','UserController@update_profile');
// Paypal interation route
 Route::resource('paypal','PayPalController');

 Route::get('payment', 'PayPalController@payment')->name('payment');
 Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
 Route::get('payment/success', 'PayPalController@success')->name('payment.success');
 Route::get('payment/cancel', 'PayPalController@cancel')->name('payment.cancel');
 Route::get('success', 'PayPalController@success_show');
 
 // lottery summary lottery-summary'
 Route::get('lottery-summary/{id}', 'PayPalController@lottery_summary');
 
 Route::resource('code','CodeController');
 Route::get('code-purchase','CodeController@code_purchase');
 Route::post('code-purchase','CodeController@code_purchase_post');
 Route::get('code-payment','CodeController@code_payment');
 Route::get('code-success','CodeController@code_success');
 Route::get('code-cancel','CodeController@code_cancel');
 
 Route::get('agent-history','CodeController@agent_history');
 Route::get('agent-code-listing/{date}','CodeController@agent_code_listing');
 

 
 // User code purchase
 Route::get('user-code-purchase','CodeController@user_code_purchase');	
 Route::post('user-code-purchase','CodeController@user_code_purchase');	
 Route::post('check-code','CodeController@check_code');	
 Route::get('my-banking','CodeController@my_banking');	

 Route::post('withdraw-fund','CodeController@withdraw_fund');		
 Route::post('wiretransfer-fund','CodeController@wiretransfer_fund');		
 
 // User paypal id add-class/
 Route::resource('userpaypal','UserPaypalController');
 Route::get('withdraw-request/{type}','WithdrawController@withdraw_request');
 



 
 Route::get('orders/{id?}','OrderController@orders');	
 Route::resource('user','UserController');	

 Route::resource('/contact','ContactController');
 Route::resource('/users','UserController');
 
 
  //for change password
  Route::get('change-password','UserController@showchangepasswordform');
  Route::post('change-password','UserController@changepassword');

////////////////FOR STATEMENT 
Route::resource('transaction','TransactionController');
Route::get('/statement-pdf/{search}/{from}/{to}','TransactionController@statement_pdf');




// Notification Send
Route::get('notification','UserController@notification_show');
Route::post('send-notification-users','UserController@send_notification_users');

Route::get("test-mail","UserController@test_mail");
Route::get('test', function () {
      Mail::to('trilok@b2infosoft.com')->send(new TestAmazonSes("It works!"));
});
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    return 'success';
});

