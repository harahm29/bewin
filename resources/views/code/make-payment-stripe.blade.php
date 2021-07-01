@extends('layouts.admin')
@section('title','PayPal')
@section('content')
<style>
 .content {
                margin-top: 200px;
              
                text-align: center;
            }
			
			body{margin-top:20px;
background:#eee;
}

/* WRAPPERS */
#wrapper {
  width: 100%;
  overflow-x: hidden;
}
.wrapper {
  padding: 0 20px;
}
.wrapper-content {
  padding: 20px 10px 40px;
}
#page-wrapper {
  padding: 0 15px;
  min-height: 568px;
  position: relative !important;
}
@media (min-width: 768px) {
  #page-wrapper {
    position: inherit;
    margin: 0 0 0 240px;
    min-height: 2002px;
  }
}

/* Payments */
.payment-card {
  background: #ffffff;
  padding: 20px;
  margin-bottom: 25px;
  border: 1px solid #e7eaec;
}
.payment-icon-big {
  font-size: 60px;
  color: #d1dade;
}
.payments-method.panel-group .panel + .panel {
  margin-top: -1px;
}
.payments-method .panel-heading {
  padding: 15px;
}
.payments-method .panel {
  border-radius: 0;
}
.payments-method .panel-heading h5 {
  margin-bottom: 5px;
}
.payments-method .panel-heading i {
  font-size: 26px;
}

.payment-icon-big {
    font-size: 60px !important;
    color: #d1dade;
}

.form-control,
.single-line {
  background-color: #FFFFFF;
  background-image: none;
  border: 1px solid #e5e6e7;
  border-radius: 1px;
  color: inherit;
  display: block;
  padding: 6px 12px;
  transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
  width: 100%;
  font-size: 14px;
}
.text-navy {
    color: #1ab394;
}
.text-success {
    color: #1c84c6;
}
.text-warning {
    color: #f8ac59;
}
.ibox {
  clear: both;
  margin-bottom: 25px;
  margin-top: 0;
  padding: 0;
}
.ibox.collapsed .ibox-content {
  display: none;
}
.ibox.collapsed .fa.fa-chevron-up:before {
  content: "\f078";
}
.ibox.collapsed .fa.fa-chevron-down:before {
  content: "\f077";
}
.ibox:after,
.ibox:before {
  display: table;
}
.ibox-title {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  background-color: #ffffff;
  border-color: #e7eaec;
  border-image: none;
  border-style: solid solid none;
  border-width: 3px 0 0;
  color: inherit;
  margin-bottom: 0;
  padding: 14px 15px 7px;
  min-height: 48px;
}
.ibox-content {
  background-color: #ffffff;
  color: inherit;
  padding: 15px 20px 20px 20px;
  border-color: #e7eaec;
  border-image: none;
  border-style: solid solid none;
  border-width: 1px 0;
}
.ibox-footer {
  color: inherit;
  border-top: 1px solid #e7eaec;
  font-size: 90%;
  background: #ffffff;
  padding: 10px 15px;
}
.text-danger {
    color: #ed5565;
}
</style>
<div class="flex-center position-ref full-height">
  
            <div class="content">
                 
             <!--   <table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/in/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/in/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png" border="0" alt="PayPal Logo"></a></td></tr></table> 
  
                <a href="{{ url('payment') }}" class="btn btn-success">Pay $10 from Paypal</a>
  -->
            </div>
</div>



<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
<div class="wrapper wrapper-content animated fadeInRight">
   
    <div class="row">

        <div class="col-lg-12">

            <div class="ibox">
                <div class="ibox-title">
                    <div class="box-header" align="right"> <span align="left" style="float:left;">Payment method </span>
									<a  align="right" href="{{url()->previous()}}" class="btn btn-primary btn-sm" data-toggle="tooltip"  ><b><i class="fas fa-backspace" aria-hidden="true"></i> Back</b></a>

									</div> 
                </div>
                <div class="ibox-content">

                    <div class="panel-group payments-method" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-right">
                                    <i class="fa fa-cc-stripe text-success"></i>
                                </div>
                                
                            </div>
                            <div id="collapseOne" class="">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-10">
										 
											@if(Auth::user()->type=='user' && session("code_type")=='agent_code')
                                             <strong>Code:</strong> {{session('code') ?? ""}} <br>
										    @endif
                                            <strong>Total Price:</strong>: <span class="text-navy">${{$price ?? ""}}</span>
                                            <br>  <br>

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
							<input type="hidden" name="amount" id="amount" value="{{$price ?? ""}}" />
							<input type="hidden" name="type" id="type" value="agent" />
							<div class="row">
								<div class="col-xs-6">
									<button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now $({{$price ?? ""}})</button>
								</div>
								<div class="col-xs-6">
									
									<button class="btn btn-danger btn-lg btn-block" type="reset">Cancel </button>
								</div>
							</div>
							  
						</form>
                                        </div>
                                    </div>
                                     </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
 <br/>
 <br/>
<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
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