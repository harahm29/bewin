@extends('layouts.admin')
@section('title','Transaction')
@section('content')
<style>
.cus_box_info
{
	background-color: #24313C; padding: 10px; margin: 10px;
}

.cus_body_box
{
	background-color: #1C2331; padding: 10px; margin: 10px;color:white; 
}

.cus_head_box
{
	height: 40px; padding-top:10px; margin-top: 0px; background-color:#1AB188;
}

.detail_cus  { padding-top: 7px; margin-top: 7px; }
.box_footer_cus  { background-color: #1AB188; padding-top: 7px; margin-top: 7px; }


.status_checkbox{
visibility: hidden;
}

/* SLIDE THREE */
.slideparam {
width: 80px;
height: 26px;
background: #333;
margin: 2px auto;

-webkit-border-radius: 50px;
-moz-border-radius: 50px;
border-radius: 50px;
position: relative;

-webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
-moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);

}

.slideparam:after {
content: 'OFF';
font: 12px/26px Arial, sans-serif;
color: #7a121d;
position: absolute;
right: 10px;
z-index: 0;
font-weight: bold;
text-shadow: 1px 1px 0px rgba(255,255,255,.15);
}

.slideparam:before {
content: 'ON';
font: 12px/26px Arial, sans-serif;
color: #00bf00;
position: absolute;
left: 10px;
z-index: 0;
font-weight: bold;
}

.slideparam label {
display: block;
width: 34px;
height: 20px;
cursor: pointer;
-webkit-border-radius: 50px;
-moz-border-radius: 50px;
border-radius: 50px;
 
-webkit-transition: all .4s ease;
-moz-transition: all .4s ease;
-o-transition: all .4s ease;
-ms-transition: all .4s ease;
transition: all .4s ease;
position: absolute;
top: 3px;
left: 3px;
z-index: 1;

-webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
-moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
background: #fff;


filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
}

.slideparam input[type=checkbox]:checked + label {
left: 43px;
}


 .slideparam input[type=checkbox]:checked + label:after {
   background: #27ae60;
}
 
.slideparam label:after {
   content:'';
   width: 10px;
   height: 10px;
   position: absolute;
   top: 5px;
   left: 12px;
   background: red;
   border-radius: 50%;
   box-shadow: inset 0px 1px 1px black, 0px 1px 0px rgba(255, 255, 255, 0.9);
 }

</style>
	<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">User Transaction</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url()->current()}}">Transaction</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">List</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center pull-right">
									
										
									</div>
								</div>
								<div class="card-body">
								@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
									
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
					
								<select id="name" class="form-control" name="name" onchange="submit();" placeholder="Enter Teacher Name"  >

								<option value="">-Select User-</option>
								@foreach($teachers as $teacher)
								<option value="{{$teacher->id}}" {{$teacher->id == $name ? 'selected':''}}>{{$teacher->first_name}} {{$teacher->last_name}}</option>
								@endforeach
									</select>
						</div>
						@else
						<div class="col-lg-2">
						<h3 style="color: red;">{{Auth::user()->name}}</h3>	
						</div>
							@endif
							@if(isset($_REQUEST['from']))
							   @php $from = date("d-m-Y",strtotime($_REQUEST['from'])); @endphp
						   @else
							   @php
							   $month=date('m');
							   if($month<4){
									$from = date('01-04-Y',strtotime('-1 year'));
							   }else{
									$from = date('01-04-Y');
							   } @endphp
						   @endif
						   @if(isset($_REQUEST['to']))
							   @php $to = date("d-m-Y",strtotime($_REQUEST['to'])); @endphp
						   @else
							   @php $to = date('d-m-Y'); @endphp
						   @endif
						<div class="col-lg-2">
						<input type="text" id="from_date" name="from" value="{{$from}}" class="form-control" placeholder="From Date" required >
						</div>
						<div class="col-lg-2">
						<input type="text" id="to_date" name="to" value="{{$to}}"  class="form-control" placeholder="To Date" required >
						</div>
						<div class="col-lg-2">
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
                  <th>Type</th>
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
				<td>{{ucwords(str_replace("_"," ",$data->form_name))}}</td>
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
					<th colspan="4" style="text-align: right;">
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
						  <a target="_blank" href="{{url('statement-pdf/'.$search.'/'.$from.'/'.$to)}}" class="btn btn-primary view_pdf btn-sm"><i class="far fa-file-pdf"></i> View Pdf</a>
					  @endif
					</th>
					   <th  style="text-align: right;">Closing</th>
					   <th style="color:green;font-size:18px;">@if($closing_cr_view)$ @endif {{ $closing_cr_view  }}</th>
					  <th style="color:red;font-size:18px;">@if($closing_dr_view)$ @endif {{$closing_dr_view }}</th>
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
				</div>
			</div>
			
		</div>	
			
		<script>

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
</script>
	
@endsection	