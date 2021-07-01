@extends('layouts.admin')
@section('title','Lottery')
@section('content')
 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>Transaction</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Transaction</li>
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
					
				</div>
                 <div class="row">
                    <div class="lottery-content">
                       
                       
		<div class="table-responsive">
			<table id="firsttab" class="table table-bordered table-striped">
                <thead bgcolor="#A9A9A9">
                <tr>
                  <th>Plan</th>
                  <th>Value</th>
                  <th>No of voucher</th>
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>
				 
		   @foreach($vouchers as $data)
              <tr>
				<td>{{$data->name}}</td>
				<td>{{$data->amount}}</td>
				<td> <input type="text" class="form-control" name="voucher_no" id="voucher_no" value="{{old('voucher_no')}}" ></td>
				<td></td>
			  </tr>
			@endforeach	 
				
                 <tfoot>

			
				
				<tr>
					<th colspan="4" style="text-align: right;">Total</th>
					<th style="border-top: 2px solid #000;">&#8377; {{str_replace("-","",number_format(($total_dr),2))}}</th>
					<th style="border-top: 2px solid #000;">&#8377; {{str_replace("-","",number_format(($total_cr),2))  }}</th>
				</tr>
					
				
				</tfoot>
                </tbody>
              </table>	
										</table>
									</div>
                   
                      

                    </div>
                </div>
            </div>
        </div>
		
	<input type="hidden" name="user_id" id="user_id" value="@if(Auth::check()){{Auth::user()->id}}@else 0 @endif" />
	
        <!-- End Number area -->	
		
		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		<script>
		function submit()
		{
			$("form").submit();
		}
		$(function() {
	
			var d = new Date();
			var y = d.getFullYear();
			var m = d.getMonth();
			@if($from=='')
			var month_first_date = new Date(y,m,1);
			@else
			var month_first_date = "{{$from}}";	
			@endif

			  $("#from_date").datepicker({ 
					autoclose: true, 
					format: 'yyyy-mm-01',
					todayHighlight: true
			  }).datepicker('update', new Date());

		});
		 //todate
		$(function() {
		  $("#to_date").datepicker({ 
				autoclose: true, 
				format: 'yyyy-mm-dd',
				todayHighlight: true
		  }).datepicker('update', new Date());
		});
		
		$(document).ready(function(){
			$(".dd").change(function(){
				submit();
			})
		})
		</script>
		
@endsection	