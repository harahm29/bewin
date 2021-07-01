<!-- Start Lottery area -->
@if(Auth::check() && Auth::user()->type=='agent')
@else
<div class="ticket-area bg-color area-padding-2" style="padding: 10px 0px 70px;">
            <div class="container">
                <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline text-center">
							<h3>Jackpot Lottery</h3>
							<p>Dummy text is also used to demonstrate the appearance of different typefaces and layouts</p>
						</div>
					</div>
				</div>
                 <div class="row">
                    <div class="ticket-content lettery-carousel">
					
					
					
					
					@foreach($lotterys as $lottery)
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- fun_text  -->
                            <div class="single-ticket">
                              
                                <div class="ticket-image">
                                    <span class="win-price"></span>
                                    <span class="win-money"></span>
                                    <img src="{{url('admin/public/images/'.$lottery->image)}}" alt="">
                                </div>
                                <div class="ticket-text">
								@php 
								$draw_days_array = explode(",",$lottery->draw_days);
								$current_time = date("h a");
								$timeSlotStart = DB::table("time_slots")->where(['id'=>$lottery->start_lottery_time])->first();
								$start_time = $timeSlotStart->name;
								$timeSlot = DB::table("time_slots")->where(['id'=>$lottery->end_lottery_time])->first();
								$end_time = $timeSlot->name;
								 $lottery_date = get_lottery($draw_days_array,$start_time,$end_time);
									
								$time1 = DateTime::createFromFormat('H a', $current_time);
									// print_r($time1);
									// exit;
									$time2 = DateTime::createFromFormat('H a', $start_time);
									$time3 = DateTime::createFromFormat('H a', $end_time);
									
									$day_status = 0;
									$weekNo_day = date('Y-m-d H:s:i');
									 $today_lottery_day = date('l', strtotime($weekNo_day));
									if(in_array($today_lottery_day,$draw_days_array)){
											
											$day_status = 1;
											
										
									}
									if($day_status==1 && ($time1 >= $time3) && ($time1 <= $time2))
									{
									    $time_status = 1;
									}
									else
										$time_status = 0;
									
									
									

									
									
								@endphp
								 <h4 class="ticket-name">{{$lottery->name}} </h4>
                                    <span class="draw">@if($lottery->status ==0) Already Completed {{$lottery->expire_date}} @else Next Draw: {{$lottery_date}} {{$lottery->draw_timing}}<br>Last Purchase: {{$end_time}}@endif</span>
								
                                   
								   @if($time_status==1)
                                    <a  class="ticket-btn btn-danger stop_lottery" style="background:red;" href="#" data-toggle="tooltip" title="Lottery Has Stop Now It Will be Open At {{$start_time}}">Stopped Now</a> 
								    @elseif($lottery->status == 0)	
									Completed
									
									@else
								     <a  class="ticket-btn " href="{{url('lottery/'.$lottery->id)}}">Play Now </a>
								@endif
									<br>
									
                                </div>
                            </div>
                        </div>
					@endforeach
                  
					
                    </div>
                </div>
            </div>
        </div>
		  @endif
        <!-- End Lottery area -->