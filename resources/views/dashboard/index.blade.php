@extends('layouts.admin')
@section('title','Dashboard')
@section('content')

<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					@if(session('message'))
         <p class="alert alert-success">{{session('message')}}</p>
         @endif
					<div class="row">
						<div class="col-md-4">
							<div class="card card-dark bg-primary-gradient">
								<div class="card-body pb-0">
									<div class="h1 fw-bold float-right"></div>
									<h2 class="mb-2">{{$users_count}}</h2>
									<p><a style="color:#fff;" href="{{url('user')}}">Users</a><p>
									<div class="pull-in sparkline-fix chart-as-background">
										
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-dark bg-warning-gradient">
								<div class="card-body pb-0">
									<div class="h1 fw-bold float-right"></div>
									<h2 class="mb-2">{{$lottery_count}}</h2>
									<p><a style="color:#fff;" href="{{url('lottery')}}">Lottery</a><p>
									<div class="pull-in sparkline-fix chart-as-background">
										
									</div>
								</div>
							</div>
						</div>
						
						
					</div>
					<div class="row">
						<div class="col-md-6">
						<div class="col-md-12">
						
						<label><b>Lottery</b></label>
						<a class="pull-right" data-toggle="tooltip" title="View All" href="{{url('lottery')}}">View All</a>
						
						</div>
							<div class="table-responsive">
										<table width="100%" id="lottery_list" class="display table table-striped table-hover lottery_list" style="width:500px;" >

										<thead>
										<tr>
										<th>SrNo</th>
										<th>Lottery Name</th>
										<th>Image</th>
										<th>Created</th>
										<th>Status</th>
										</tr>
										</thead>

										<tbody>
										<tr>
										@php $i=1; @endphp
											@foreach($lotterys as $lottery)
												   <td>{{$i}}</td>
												   <td>{{$lottery->name}}</td>
												   <td ><a target="_blank" href="{{url('public/images/'.$lottery->image)}}"><img src="{{url('public/images/'.$lottery->image)}}" width="50"></a></td>
												   <td >{{date('d-m-y',strtotime($lottery->created_at))}}</td>
												   <td>{{$lottery->status}}</td>
												  
											</tr>
											 </form> 
										 <?php $i++; ?>
														@endforeach

										<?php 
										// echo count($data11);
										// echo "<pre>";
										// print_r($data11);
										?>

										</tbody>
										</table>
									</div>	
						</div>
						<div class="col-md-6">
						<div class="col-md-12">
						
						<label><b>Users</b></label>
						<a class="pull-right" data-toggle="tooltip" title="View User" href="{{url('user')}}">View All</a>
						
						</div>
							<div class="table-responsive">
										<table width="100%" id="" class="display table table-striped table-hover lottery_list" style="width:500px;" >

										<thead>
										<tr>
										<th>SrNo</th>
										<th>Name</th>
										<th>Email</th>
										<th>Mobile No</th>
									
										<th>status</th>
										</tr>
										</thead>

										<tbody>
										<tr>
										@php $i=1; @endphp
										@foreach($users as $user)
												   <td>{{$i}}</td>
												   <td>{{ucfirst($user->name)}}</td>
												   <td>{{$user->email}}</td>
												   <td>{{$user->mobile_no}}</td>
												 
												   <td>@if($user->status==1) <span class="test-success">Active</span> @else <span class="test-danger">InActive</span>@endif</td>
												  
											</tr>
											 </form> 
										 <?php $i++; ?>
										@endforeach

										<?php 
										// echo count($data11);
										// echo "<pre>";
										// print_r($data11);
										?>

										</tbody>
										</table>
							</div>	
						</div>
						
					</div>
					<div class="row">
						
						
						
					</div>
					
					
					
					
				</div>
			</div>
			
		</div>
		<!-------------------Modal Start----------------->	
			  <div class="container"> 
                        
                        <!-- Trigger the modal with a button --> 
                        
<!-- Modal -->
<div class="modal fade" id="view_modal" role="dialog">
<div class="modal-dialog modal-lg"> 
                            
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title">Product Plans Details</h4>
	<button type="button" class="close" data-dismiss="modal">×</button>
	
	</div>
    <div class="modal-body view_body">
       
    </div>
   <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>

</div>
                          </div>
                                </div>
</div>
	<!-------------------Modal End----------------->
		
		      
		    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <script>

        //var socket = io.connect('http://127.0.0.1:8890');
	
</script>
	<script>
		$(document).ready(function(){
			 $('.lottery_list').DataTable({
	'paging'      : false,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : true
 
  });
		});

	</script>
		
@endsection