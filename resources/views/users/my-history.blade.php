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
                                <h3>My History</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>My History</li>
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
				<div  align="right"><h3 style="float:left;" class="mgbt-md-15 mgtp-10 font-semibold" >My History</h3>
		</div> 
				  <form class="form-horizontal" method="get" action="{{url()->current()}}">
                    <div class="col-md-12">
                      <div class="form-group form-show-validation row">
					  @if (Auth::user())
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
							@endif
						<div class="col-lg-2">
						<input type="text" id="from_date" name="from"  value="{{date('m/d/Y',strtotime($from_date))}}" class="form-control dd" placeholder="From Date" required >
						</div>
						<div class="col-lg-2">
						<input type="text" id="to_date" name="to"  value="{{date('m/d/Y',strtotime($to_date))}}"  class="form-control dd" placeholder="To Date" required >
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
		<div class="deposite-content">
        <div class="diposite-box">
        <div class="deposite-table">
			<table >
			 <tr>
                 <th>Sr No.</th>
                  <th>Date</th>
                  <th>Lottery Name</th>
                  <th>Ticket No.</th>
                  <th>Selected No.</th>
                  <th>Price</th>
                  <th  style="width: 195px;">Draw Date & Time</th>
                  <th style="width: 143px;">Winning Status</th>                            
             </tr>
               
                
				@php $i=1; @endphp
				@foreach($lotterys as $data)
				  <tr>
					<td>{{$i}}</td>
					<td>{{date("d-m-Y",strtotime($data->today_date))}}</td>
					<td>{{$data->lottery_name}}</td>
					<td>
					@if(strlen((string)$data->id) == 1)
					00000{{$data->id}}
					@elseif(strlen((string)$data->id) == 2)
					0000{{$data->id}}
					@elseif(strlen((string)$data->id) == 3)
					000{{$data->id}}
					@elseif(strlen((string)$data->id) == 4)
					00{{$data->id}}
					@elseif(strlen((string)$data->id) == 5)
					0{{$data->id}}
					@else
					{{$data->id}}
				@endif
					</td>
					<td>
					@if($data->lottery_draw_no)
					@php $lottery_array = explode(",",$data->lottery_draw_no); @endphp
                       
					@else
						@php $lottery_array =array(); @endphp
					@endif
					@if($data->lottery_no)
					@php $lottery_array_new = explode(",",$data->lottery_no); @endphp
                        <ul class="self-number">
							@foreach($lottery_array_new as $lottery_new)
                             <li><a href="#" @if(!in_array($lottery_new,$lottery_array)) style="background:grey;" @endif >{{$lottery_new}}</a></li>
							@endforeach
							@if($data->power_ball_no)
                        
							<li><a href="#" style="background:blue;">{{$data->power_ball_no}}</a></li>
                    
							@endif	
                        </ul>
					@endif	
					
					</td>
					<td>{{$data->lottery_price}}</td>
					<td>{{$data->draw_date_time}}</td>
					<td>
						@if($data->lottery_status ==1)
						<p class="text-success"> Winner</p> 
					  @elseif($data->lottery_status ==2) 
						<p class="text-danger">Not Winning Ticket</p> 
					  @else 
						  <p class="text-warning" style="color:#ffc107;">Pending</p> 
					@endif
					</td>
				  </tr>
				  @php $i++; @endphp
				  @endforeach
                
              </table>					
		</div>
		</div>
		</div>
		</div>
                   
                        {{ $lotterys->appends(request()->query())->links() }}

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