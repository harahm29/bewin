@extends('layouts.admin')
@section('title','Code Purchase')
@section('content')
<style>
.error{
	color:red;
}
</style>
<style>
* {box-sizing: border-box}



/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 30%;
  min-height: 600px;
}

/* Style the buttons inside the tab */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
  border: 1px solid #ccc;
  width: 70%;
  border-left: none;
  min-height: 600px;
}
</style>
 <style type="text/css">
        .panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>My Banking</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>My Banking</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Header -->
  <!-- Start Number area -->
  <div class="lottery-area area-padding-2">
            <div class="container">
                 <div class="row">
				 @if(session('message'))
					<p class="alert alert-success">{{session('message')}}</p>
				 @endif
				@if(session('error_message'))
					<p class="alert alert-danger">{{session('error_message')}}</p>
				 @endif
					
				</div>
				
				
				

				
				
				
				
                 <div class="row">
                    <div class="lottery-content">
                      	<h3>My Banking </h3>
						
											
											
					  <ul class="nav nav-tabs">
						<li @if(!isset($_REQUEST['from']) && !isset($_REQUEST['withdraw'])) class="active" @endif><a data-toggle="tab" href="#home">Deposite Money</a></li>
						<li @if(isset($_REQUEST['withdraw'])) class="active" @endif><a data-toggle="tab" href="#menu2" id="withdraw_money">Withdraw Money</a></li>
						<li @if(isset($_REQUEST['from'])) class="active" @endif ><a data-toggle="tab" href="#menu3" id="transaction">Transaction</a></li>
						
					  </ul>

					  <div class="tab-content">
						<div id="home" class="tab-pane fade in @if(!isset($_REQUEST['from']) && !isset($_REQUEST['withdraw'])) active @endif">
							<div class="tab">
							  <button class="tablinks" onclick="openCity(event, 'paypal')" id="defaultOpen">Paypal</button>
							  <button class="tablinks" onclick="openCity(event, 'credit_card')">Credit Card</button>
							  <button class="tablinks" onclick="openCity(event, 'agent_code')">Agent Code</button>
							</div>

							<div id="paypal" class="tabcontent">
							<br>
							<br>
								<form method="post" action="{{url('code-purchase')}}" id="exampleValidation" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									<div class="card-body">
										<div class="card-body">
										<div class="form-group form-show-validation row">
										<div class="col-lg-1">
									</div>
											<label for="amount" class="col-lg-3 ">Deposite Amount <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control" id="amount" name="amount" placeholder="Amount" value="@if(session('lottery_id')){{session('balance')}}@else {{old('amount')}}@endif" required />
											<div class="text-danger">{{$errors->first('amount')}}</div>							
											</div>
										</div>		
										</div>
									</div>
									<div class="card-action">
									<div class="col-lg-2">
									</div>
										<button type="submit" class="btn btn-success">Make Payment</button>
										<a href="{{url()->current()}}"  class="btn btn-danger">Cancel</a>
									</div>
									<input type="hidden" name="type"  value="paypal" />
									</form>
							</div>

							<div id="credit_card" class="tabcontent">
							<div class="row display-tr" >
								<h3 class="panel-title display-td" >Payment Details</h3>
								<div class="display-td" >                            
									<img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
								</div>
							</div> 
							<form 
								role="form" 
								action="{{ url('stripe') }}" 
								method="post" 
								class="require-validation"
								data-cc-on-file="false"
								data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
								id="payment-form">
							@csrf
	  
							<div class='form-row row'>
								<div class='col-xs-12 form-group required'>
									<label class='control-label'>Deposite Amount</label> 
									<input  type="text" class="form-control" id="amount" name="amount" placeholder="Amount" value="@if(session('lottery_id')){{session('balance')}}@else {{old('amount')}}@endif "  />
											<div class="text-danger">{{$errors->first('amount')}}</div>	
								</div>
							</div>
							<div class='form-row row'>
								<div class='col-xs-12 form-group required'>
									<label class='control-label'>Name on Card</label> <input
										class='form-control' size='4' type='text' name="name">
										<div class="text-danger">{{$errors->first('name')}}</div>	
								</div>
							</div>
	  
							<div class='form-row row'>
								<div class='col-xs-12 form-group card required'>
									<label class='control-label'>Card Number</label> <input
										autocomplete='off' class='form-control card-number' size='20'
										type='text' name="card_number">
										<div class="text-danger">{{$errors->first('card_number')}}</div>	
								</div>
							</div>
	  
							<div class='form-row row'>
								<div class='col-xs-12 col-md-4 form-group cvc required'>
									<label class='control-label'>CVC</label> <input autocomplete='off'
										class='form-control card-cvc' placeholder='ex. 311' size='4'
										type='text' name="cvv">
										<div class="text-danger">{{$errors->first('cvv')}}</div>	
								</div>
								<div class='col-xs-12 col-md-4 form-group expiration required'>
									<label class='control-label'>Expiration Month</label> <input
										class='form-control card-expiry-month' placeholder='MM' size='2'
										type='text' name="exp_month">
										<div class="text-danger">{{$errors->first('exp_month')}}</div>	
								</div>
								<div class='col-xs-12 col-md-4 form-group expiration required'>
									<label class='control-label'>Expiration Year</label> <input
										class='form-control card-expiry-year' placeholder='YYYY' size='4'
										type='text' name="exp_year">
										<div class="text-danger">{{$errors->first('exp_year')}}</div>	
								</div>
							</div>
	  
							<div class='form-row row'>
								<div class='col-md-12 error form-group hide'>
									<div class='alert-danger alert'>Please correct the errors and try
										again.</div>
								</div>
							</div>
							<input type="hidden" name="price" id="price" value="" />
							<div class="row">
								<div class="col-xs-6">
									<button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now </button>
								</div>
								<div class="col-xs-6">
									
									<a href="{{url()->current()}}" class="btn btn-danger btn-lg btn-block" type="reset">Cancel </a>
								</div>
							</div>
							  
						</form>
							</div>

							<div id="agent_code" class="tabcontent">
							<br>
							<br>
								<form method="post" action="{{url('code-purchase')}}" id="codeValidation" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									<div class="card-body">
										<div class="card-body">
										<div class="form-group form-show-validation row">
										<div class="col-lg-1">
										</div>
											<label for="code" class="col-lg-3 ">Enter Code <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text"  class="form-control code " name="code" id="code" value="{{old('code')}}" required />
											<div class="text-danger">{{$errors->first('code')}}</div>							
											</div>
										</div>	
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="value" class="col-lg-3 "> Code Value <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control" class="form-control" name="value" id="value" value="{{old('value')}}" readonly  />
											<div class="text-danger">{{$errors->first('value')}}</div>							
											</div>
										</div>
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="status" class="col-lg-3 "> Code Status <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control" class="form-control" name="status" id="status" value="{{old('status')}}" readonly  />
											<div class="text-danger">{{$errors->first('status')}}</div>							
											</div>
										</div>		
										</div>
									</div>
									<div class="card-action">
									<div class="col-lg-2">
									</div>
										<button type="submit" class="btn btn-success submit_btn" disabled >Submit</button>
										<a href="{{url()->current()}}" class="btn btn-danger">Cancel</a>
									</div>
									<input type="hidden" name="type"  value="code" />
									</form>
							
								
							</div>
						</div>
						<div id="menu2" class="tab-pane fade @if(isset($_REQUEST['withdraw'])) active in @endif"> 
						  <div class="tab">
							  <button class="tablinks @if(isset($_REQUEST['withdraw'])) active @endif" onclick="openCity(event, 'withdraw_paypal')" id="withdraw_defaultOpen">Paypal</button>
							  <button class="tablinks" onclick="openCity(event, 'withdraw_credit_card')">Wire Transfer</button>
							 
							</div>

							<div id="withdraw_paypal" class="tabcontent @if(isset($_REQUEST['withdraw'])) active @endif" @if(isset($_REQUEST['withdraw'])) style="display:block !important;" @endif>
							<br>
							<br>
								<form method="post" action="{{url('withdraw-fund')}}" id="withdraw_paypal_form" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									
									
										<div class="card-body">
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="amount" class="col-lg-3 "> </label>
											<div class="col-lg-6 pull-right" align="right">
											<button class="btn btn-warning btn-sm view" id="withdraw_request" href="{{url('withdraw-request/paypal')}}"><i class="fas fa-info-circle"></i> Withdraw Requests</button>							
											<button class="btn btn-primary btn-sm" id="add_paypal_id"><i class="fas fa-plus"></i>Add Paypal Id</button>							
											</div>
										</div>
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="amount" class="col-lg-3 ">Paypal Id <span class="required-label">*</span></label>
											<div class="col-lg-4">
											@php $i=1; @endphp
											@foreach($paypal_ids as $paypal)
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" name="paypal_id" id="customRadio{{$paypal->id}}" value="{{$paypal->paypal_id}}" @if($i==1) checked @endif>
												<label class="custom-control-label" for="customRadio{{$paypal->id}}">{{$paypal->paypal_id}}</label>
											</div>
											@php $i++; @endphp
											@endforeach
											<div class="text-danger">{{$errors->first('paypal_id')}}</div>							
											</div>
										</div>
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="amount" class="col-lg-3 ">Available Fund <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control" id="fund" name="fund" placeholder="Fund" value="${{$wallet}}" readonly />
											<input  type="hidden" class="form-control" id="wallet" name="wallet" placeholder="wallet" value="{{$wallet}}" readonly />
											<div class="text-danger">{{$errors->first('fund')}}</div>							
											</div>
										</div>
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="amount" class="col-lg-3 ">Withdraw Amount <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control numeric_feild" id="withdraw_amount" name="withdraw_amount" placeholder="Withdraw Amount" value="{{old('withdraw_amount')}}" required />
											<div class="text-danger">{{$errors->first('withdraw_amount')}}</div>							
											</div>
										</div>		
										</div>
									
									<div class="card-action">
									<div class="col-lg-2">
									</div>
										<button type="submit" class="btn btn-success withdraw_submit">Submit</button>
										<a href="{{url()->full()}}"  class="btn btn-danger">Cancel</a>
									</div>
									<input type="hidden" name="type"  value="paypal" />
									</form>
							</div>

							<div id="withdraw_credit_card" class="tabcontent">
							<br>
							<form method="post" action="{{url('wiretransfer-fund')}}" id="wiretransfer_paypal_form" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									
									
										<div class="card-body">
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="amount" class="col-lg-5 "> </label>
											<div class="col-lg-6 pull-right" align="right">
											<button class="btn btn-warning btn-sm view" id="withdraw_request" href="{{url('withdraw-request/wiretransfer')}}"><i class="fas fa-info-circle"></i> Withdraw Requests</button>							
																	
											</div>
										</div>
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="fund" class="col-lg-5 ">Available Fund <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control" id="fund" name="fund" placeholder="Fund" value="${{$wallet}}" readonly />
											<input  type="hidden" class="form-control" id="wallet_wiretransfer" name="wallet_wiretransfer" placeholder="wallet" value="{{$wallet}}" readonly />
											<div class="text-danger">{{$errors->first('fund')}}</div>							
											</div>
										</div>
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="withdraw_amount_wiretransfer" class="col-lg-5 ">Withdraw Amount <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control numeric_feild" id="withdraw_amount_wiretransfer" name="withdraw_amount_wiretransfer" placeholder="Withdraw Amount" value="{{old('withdraw_amount_wiretransfer')}}" required />
											<div class="text-danger">{{$errors->first('withdraw_amount_wiretransfer')}}</div>							
											</div>
										</div>
										
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="account_holder_name" class="col-lg-5 ">Account Holder Name <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control " id="account_holder_name" name="account_holder_name" placeholder="Account Holder Name" value="{{old('account_holder_name')}}" required />
											<div class="text-danger">{{$errors->first('account_holder_name')}}</div>
											</div>
										</div>		
										
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="account_no" class="col-lg-5 ">Account No <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control numeric_feild" id="account_no" name="account_no" placeholder="Account No" value="{{old('account_no')}}" required />
											<div class="text-danger">{{$errors->first('account_no')}}</div>
											</div>
										</div>	
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="phone_no" class="col-lg-5 ">Account Holder Phone No <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control numeric_feild" id="phone_no" name="phone_no" placeholder="Account Holder Phone No" value="{{old('phone_no')}}" required />
											<div class="text-danger">{{$errors->first('phone_no')}}</div>
											</div>
										</div>		
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="bank_name" class="col-lg-5 ">Account Holder Bank Name <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control " id="bank_name" name="bank_name" placeholder="Account Holder Bank Name" value="{{old('bank_name')}}" required />
											<div class="text-danger">{{$errors->first('bank_name')}}</div>
											</div>
										</div>		
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="branch_name" class="col-lg-5 ">Account Holder Branch Name <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control " id="branch_name" name="branch_name" placeholder="Account Holder Branch Name" value="{{old('branch_name')}}" required />
											<div class="text-danger">{{$errors->first('branch_name')}}</div>
											</div>
										</div>		
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="swift_code" class="col-lg-5 ">Account Holder Swift Code/IBAN <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control " id="swift_code" name="swift_code" placeholder="Account Holder Swift Code/IBAN" value="{{old('swift_code')}}" required />
											<div class="text-danger">{{$errors->first('swift_code')}}</div>
											</div>
										</div>		
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="branch_address" class="col-lg-5 ">Account Holder Branch Address <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="text" class="form-control " id="branch_address" name="branch_address" placeholder="Account Holder Branch Address" value="{{old('branch_address')}}" required />
											<div class="text-danger">{{$errors->first('branch_address')}}</div>
											</div>
										</div>		
										
										
										
										
										</div>
									
									<div class="card-action">
									<div class="col-lg-2">
									</div>
										<button type="submit" class="btn btn-success withdraw_submit">Submit</button>
										<a href="{{url()->full()}}"  class="btn btn-danger">Cancel</a>
									</div>
									<input type="hidden" name="type"  value="wire-transfer" />
									</form>
							</div>

							
						</div>
						<div id="menu3" class="tab-pane fade @if(isset($_REQUEST['from'])) active in @endif">
						<br>
						<br>
						<div class="row">
							  <form class="form-horizontal" method="get" id="transaction_form" action="{{url()->current()}}">
								<div class="col-md-12">
								  <div class="form-group form-show-validation row">
								  @if(Auth::user()->type=='admin')
								   <div class="col-lg-3">
										 @if(isset($_REQUEST['name']))
											 @php  $name =  $_REQUEST['name']; @endphp
										 @else
											  @php  $name = ''; @endphp
										 @endif
								
											<select id="name" class="form-control dd" name="name"  placeholder="Enter Teacher Name"  >

											<option value="">-Select User-</option>
											@foreach($teachers as $teacher)
											<option value="{{$teacher->id}}" {{$teacher->id == $name ? 'selected':''}}>{{$teacher->name}}</option>
											@endforeach
												</select>
									</div>
									@else
									<div class="col-lg-2">
									<h3 style="color: red;">{{Auth::user()->name}}</h3>	
									</div>
										@endif
										@if(isset($_REQUEST['from']))
							   @php $from = date("m/d/Y",strtotime($_REQUEST['from'])); @endphp
						   @else
							   @php $from = date('m/01/Y'); @endphp
						   @endif
						   @if(isset($_REQUEST['to']))
							   @php $to = date("m/d/Y",strtotime($_REQUEST['to'])); @endphp
						   @else
							   @php $to = date('m/d/Y'); @endphp
						   @endif
									<div class="col-lg-2">
									<input type="text" id="from_date" name="from"  value="{{$from}}" class="form-control dd" placeholder="From Date" required >
									</div>
									<div class="col-lg-2">
									<input type="text" id="to_date" name="to"  value="{{$to}}"  class="form-control dd" placeholder="To Date" required >
									</div>
									<div class="col-lg-1">
									  <button type="submit" class="btn btn-success"><i class="fas fa-search" aria-hidden="true"></i> Search</button>
									 </div>
									 <div class="col-lg-2">
									<a href="{{url()->current()}}">
								 <button type="button" class="btn btn-info"><i class="fas fa-sync-alt"></i> Reset</button> </a>
									 </div>
								&nbsp;
								 
								   </div>
								   
								  
						  </div>
						 </form>
        
              
						</div>
						<div class="table-responsive">
							<table id="firsttab" class="table table-bordered table-striped">
								<thead bgcolor="#A9A9A9">
								<tr>
								  <th>Sr No.</th>
								  <th>Date</th>
								  <th>Description</th>
								  <th>Order No.</th>
								  <th>Debit</th>
								  <th>Credit</th>
								</tr>
								</thead>
								<tbody>
								@if($old_date_data > 0)
								@php
								$outstanding_dr =str_replace("-","",number_format($old_date_data,2));
											$outstanding_cr = "";
											$outstadingdr = $old_date_data; 
											$outstadingcr = 0;
											@endphp
									@else
											@php	$outstanding_dr = "";
											$outstanding_cr = str_replace("-","",number_format($old_date_data,2)); 
											$outstadingcr = $old_date_data;
											$outstadingdr = 0;
											@endphp
								@endif		
								 
								@if($outstanding_dr!='' || $outstanding_cr!='' && $outstanding_dr>0 || $outstanding_cr>0)
								<tr>
									   <th colspan="5" style="text-align: right;">Opening Balance</th>
									   <th style="color:green">{{ $outstanding_dr }}</th>
									  <th style="color:red">{{ $outstanding_cr  }}</th>
								</tr>
								@endif
							   @php $i=1; 
							   $total_dr=$outstadingdr;
							   $total_cr=$outstadingcr;
							   @endphp
							   @foreach($transactions as $data)
							   @if($data->dr!=0.00)
								   @php $dr = number_format($data->dr,2); @endphp
							   @else
								   @php $dr = ''; @endphp
							   @endif
							   @if($data->cr!=0.00)
								   @php $cr = number_format($data->cr,2); @endphp
							   @else
								   @php $cr = ''; @endphp
							   @endif
							   @if($data->description == "Opening Balance")
							   
							  @php  $data->rel_id = ""; @endphp
								@endif 
						   
							  <tr>
								<td>{{$i}}</td>
								<td>{{$data->transaction_date}}</td>
								<td>{{$data->description}}</td>
								<td>{{$data->order_id}}</td>
								<td>{{$data->dr}}</td>
								<td>{{$data->cr}}</td>
								</tr>
								 
								 @php $i++; 
								 $total_dr += $data->dr;
								 $total_cr += $data->cr;
								
								 @endphp
								 @endforeach
								 <tfoot>

								@php $diff =  ($total_dr - $total_cr); @endphp
								@if(($diff) < 0)
									 @php  
										  $closing_dr_view = str_replace("-"," ",number_format($diff,2));
										  $closing_dr = str_replace("-"," ",$diff);
										  $closing_cr_view = '';
										  $closing_cr =0;
										 
								 @endphp
									 @else 
									 @php  
									 $closing_dr_view = '';
									 $closing_cr_view = str_replace("-"," ",number_format($diff,2));
									 $closing_cr = str_replace("-"," ",$diff);
									 $closing_dr=0;
								 @endphp
								@endif
								
								<tr>
									<th colspan="4" style="text-align: right;">Total</th>
									<th style="border-top: 2px solid #000;">$ {{str_replace("-","",number_format(($total_dr),2))}}</th>
									<th style="border-top: 2px solid #000;">$ {{str_replace("-","",number_format(($total_cr),2))  }}</th>
								</tr>
									
								<tr>
									<th colspan="3" style="text-align: right;">
									@if(isset($_REQUEST['name']))
									@php  $search = $_REQUEST['name']; @endphp
								   @else
									@php  $search = ''; @endphp
								   @endif
								   @if(Auth::user()->type=='admin')
									   @if(!empty($from))
									<a target="_blank" href="{{url('statement-pdf/'.$search.'/'.$from.'/'.$to)}}" class="btn btn-primary view_pdf"><i class="far fa-file-pdf"></i> View Pdf</a>
									  @endif
									  @else
										  @php  $search = Auth::user()->id; @endphp
										    <a target="_blank" href="{{url('statement-pdf/'.$search.'/'.date('Y-m-d',strtotime($from)).'/'.date('Y-m-d',strtotime($to)))}}" class="btn btn-primary view_pdf btn-sm"><i class="far fa-file-pdf"></i> View Pdf</a>
									  @endif
									</th>
									   <th  style="text-align: right;">Closing</th>
									   <th style="color:green;font-size:18px;">@if($closing_cr_view)$ @endif {{ $closing_cr_view  }}</th>
									  <th style="color:red;font-size:18px;">@if($closing_dr_view)$ @endif {{$closing_dr_view }}</th>
								</tr>
								</tfoot>
								</tbody>
							  </table>					
						</div>
						   {{ $transactions->appends(request()->query())->links() }}
						</div>
					  </div>
					
						
						
						
						
					  
                       
		
                   
                      

                    </div>
                </div>
            </div>
        </div>
		
	<!-------------------Modal Start----------------->	
			<div class="container"> 
				<div class="modal fade" id="paypal_id_modal" role="dialog">
					<div class="modal-dialog modal-lg">		
					<!-- Modal content-->
					<div class="modal-content">
							<div class="modal-header bg-success" style="color:#fff;">
						 <h4 class="modal-title"><i class="fas fa-plus"></i> Add Paypal Id</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						   
						</div>
							<div class="modal-body view_body" align="center">
							   <form method="post" action="{{url('userpaypal')}}" id="paypal_id_form" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									<div class="card-body">
										<div class="card-body">
										
										<div class="form-group form-show-validation row">
											<div class="col-lg-1">
											</div>
											<label for="amount" class="col-lg-3 ">Paypal Id <span class="required-label">*</span></label>
											<div class="col-lg-4">
											<input  type="email" class="form-control" id="paypal_id1" name="paypal_id" placeholder="Paypal Id" value="{{old('paypal_id')}}" required />
											<div class="text-danger error paypal_id_error">{{$errors->first('paypal_id')}}</div>							
											</div>
										</div>		
										</div>
									</div>
									<div class="card-action">
									
										<button type="submit" class="btn btn-success paypal_id_submit">Submit</button>
										
									</div>
									<input type="hidden" name="type"  value="paypal" />
									</form>
							</div>
						   <div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>

					</div>
					</div>
				</div>
			</div>
	<!-------------------Modal End----------------->
	<!-------------------Modal Start----------------->	
			<div class="container"> 
				<div class="modal fade" id="view_modal" role="dialog">
					<div class="modal-dialog modal-lg">		
					<!-- Modal content-->
					<div class="modal-content">
							<div class="modal-header bg-success" style="color:#fff;">
						 <h4 class="modal-title"><i class="fas fa-info-circle"></i> Withdraw Requests</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						   
						</div>
							<div class="modal-body view_body" align="center">
							 
							</div>
						   <div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>

					</div>
					</div>
				</div>
			</div>
	<!-------------------Modal End----------------->

	
        <!-- End Number area -->	
		<input type="hidden" id="url" name="url" value="{{ url('userpaypal') }}" />
		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
		<script>
		
		
		 
		
		$(document).ready(function(){
			$("#add_paypal_id").click(function(e){
				e.preventDefault();
				$("#paypal_id_modal").modal('show');
			});
			$('.paypal_id_submit').click(function(e) {  
	 // e.preventDefault();
	console.log("check");
    	// validate and process form here  
		$('#paypal_id_form').validate({
			rules: {
                paypal_id1: {          
                    required: true,   //required boolean: true/false    
                }, 
				
            },
			
			// JQuery's awesome submit handler.
			 submitHandler: function(form) 
			 {
				// alert('check');
			//$(".paypal_id_error").html("");
				// Create variables from the form
				var paypal_id = $('#paypal_id1').val();
			    var url = $("#url").val();
				//alert("teacher_id "+teacher_id);
				// Create variables that will be sent in a URL string to mail.php
				var dataString = {paypal_id:paypal_id};
				e.preventDefault();
				// The AJAX
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({  
				  type: 'POST',
				  url: url,
				  data: dataString,
				  dataType: "json",
				  success:function(data) {
					  console.log("status"+data.status);
					if(data.status==1)
					{
						location.href = "{{url()->current()}}"+"?withdraw";
					}
					else if(data.status==0)
					{
						$(".paypal_id_error").html(data.message);
					}
				}
				
			});
		}
	});
});
			
			$("#withdraw_money").click(function(){
				$("#withdraw_defaultOpen").addClass("active");
				$("#withdraw_paypal").addClass("active").css("display","block");
			});
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				amount: {
					required: true
				},
					
			},
			
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		}); 
		$("#codeValidation").validate({
			validClass: "success",
			rules: {
				code: {
					required: true
				},
					
			},
			
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
		function myfloatval(myString)
		{
			console.log("myString >> "+myString);
			myString = myString.toString().replace(/[^a-z0-9.\s]/gi, '').replace(/[_\s]/g, '-');
			console.log("myString >> "+myString);
			return parseFloat(myString);
		}
		$.validator.addMethod("greaterThan",
			function (value, element, param) {
				  var $otherElement = $(param);
				  return parseInt(value, 10) > parseInt($otherElement.val(), 10);
			});
			$.validator.addMethod("lessThan",
			function (value, element, param) {
				  var $otherElement = $(param);
				  return parseInt(value, 10) < parseInt($otherElement.val(), 10);
			});
		$("#withdraw_paypal_form").validate({
			validClass: "success",
			rules: {
				paypal_id: {
					required: true
				},
				withdraw_amount: {
					required: true,
					lessThan:"#wallet"
				},
					
			},
			messages: { 
            "withdraw_amount": "Withdraw amount is less than fund amount.",
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
		$("#wiretransfer_paypal_form").validate({
			validClass: "success",
			rules: {
				paypal_id: {
					required: true
				},
				withdraw_amount_wiretransfer: {
					required: true,
					lessThan:"#wallet_wiretransfer"
				},
					
			},
			messages: { 
            "withdraw_amount_wiretransfer": "Withdraw amount is less than fund amount.",
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
			$(".code").on("keyup change",function(){
				
				var code = ($(this).val());
				$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
				});
				$.ajax({
					url:"{{url('check-code')}}",
					type:"post",
					data:{code:code},
					dataType:"json",
					success:function(data)
					{
						console.log(JSON.stringify(data));

						if(data.status==1)
						{
							$("#value").val(data.value);
							$("#status").val("Available");
							$("#code_valid").val("$"+data.value);
							$(".submit_btn").prop("disabled",false);
							$(".error").text("");
						}
						if(data.status==2)
						{
							$("#value").val(data.value);
							$("#status").val("Used");
							$("#code_valid").val("$"+data.value);
						}
						if(data.status==3)
						{
							$("#value").val(data.value);
							$("#status").val("Expired");
							$("#code_valid").val("$"+data.value);
						}
						if(data.status==0)
						{
							$("#value").val(data.value);
							$("#status").val("Invalid");
							$("#code_valid").val("$"+data.value);
						}
					}
					
				})
			});
			
			$(".reset").click(function(){
				href = $(this).attr('href');
				location.href = href;
				
			})
		})
		</script>
		<script>
		function submit()
		{
			$("#transaction_form").submit();
		}
		$(function() {
	
			

			  $("#from_date").datepicker({ 
					autoclose: true, 
					todayHighlight: true
			  });

		});
		 //todate
		$(function() {
		  $("#to_date").datepicker({ 
				autoclose: true, 
				todayHighlight: true
		  });
		});
		
		
		</script>
		<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
   
    var $form         = $(".require-validation");
   
    $('form.require-validation').bind('submit', function(e) {
        var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
  
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
   
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
  
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
               
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
   
});
</script>
@endsection	