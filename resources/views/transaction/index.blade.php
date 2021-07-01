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
                       
                <div class="row">
				  <form class="form-horizontal" method="get" action="{{url()->current()}}">
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
                  <th>Amount</th>
                  <th>Discount</th>
                  <th>Discount %</th>
                  <th>Total Amount</th>
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
					   <th colspan="7" style="text-align: right;">Opening Balance</th>
					  <th style="color:red">{{ $outstanding_cr  }}</th>
				</tr>
				@endif
               @php $i=1; 
			   $total_dr=$outstadingdr;
			   $total_cr=$outstadingcr;
			   $total_discount=0;
			   $total_discount_per=0;
			   $total_amount=0;
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
				<td>{{$data->cr}}</td>
				<td>{{$data->discount}}</td>
				<td>{{$data->discount_per}}</td>
				<td>{{$data->total}}</td>
				</tr>
				 
				 @php $i++; 
				 $total_dr += $data->dr;
				 $total_cr += $data->cr;
				 $total_discount += $data->discount;
				 $total_discount_per += $data->discount_per;
				 $total_amount += $data->total;
				
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
				<th colspan="2" style="text-align: right;">
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
					<th colspan="2" style="text-align: right;">Total</th>
					<th style="border-top: 2px solid #000;">$ {{str_replace("-","",number_format(($total_cr),2))  }}</th>
					<th  style="text-align: right;border-top: 2px solid #000;">$ {{str_replace("-","",number_format(($total_discount),2))  }}</th>
					<th  style="text-align: right;border-top: 2px solid #000;">$ {{str_replace("-","",number_format(($total_discount_per),2))  }}</th>
					<th  style="text-align: right;border-top: 2px solid #000;">$ {{str_replace("-","",number_format(($total_amount),2))  }}</th>
				</tr>
					
				
				</tfoot>
                </tbody>
              </table>	
										</table>
		</div>
                   
                        {{ $transactions->appends(request()->query())->links() }}

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
		
		$(document).ready(function(){
			$(".dd").change(function(){
				submit();
			})
		})
		</script>
		
@endsection	