

<!-- Start Slider Area -->
		<div class="intro-area intro-home">
            <div class="bg-wrapper" style="height: 710px; background-color: #ccc;">
            	<img src="{{url('admin/public/images/'.$home->banner_image)}}" alt="" style="display: block;">
            </div>
			<div class="intro-content" style="top:45% !important">
			@php 
				 function get_lottery_details($id)
				{
					return $lottery = DB::table('lotteries')->select('lotteries.*',DB::raw("time_slots.name as draw_timing"),DB::raw("(select ts.name  from time_slots as ts where ts.id=lotteries.end_lottery_time) as end_time"))
					->leftjoin("time_slots",function($join){
						$join->on("time_slots.id","=","lotteries.draw_timing");
					})
					->where(['lotteries.is_deleted'=>0,'lotteries.id'=>$id])
					->first();
					
				}
					function get_day_slider($draw_days_array,$d,$s_time,$end_time_lottery)
					{
						
						for($h=0;$h<count($draw_days_array);$h++)
						{
							
							if($d <= $draw_days_array[$h] && $s_time <= $end_time_lottery)
							{
								return $draw_days_array[$h];
								break;
							}
							elseif($d <= $draw_days_array[$h] && $s_time > $end_time_lottery)
							{
								
								if($h <= (count($draw_days_array) - 1))
								{
									
								    if($h == $d)
									{
										return $draw_days_array[$h+1];
									}
									
									return $draw_days_array[$h];
									break;
								}
								else if($h == (count($draw_days_array) - 1))
								{
									return $draw_days_array[0];
									break;
								}
								else
								{
									return $draw_days_array[$h+1];
									break;
								}
								
							}
						}
					}
					@endphp	
			@foreach($winners as $winner)
			@php 
			$lottery = get_lottery_details($winner->lottery_id);
								$draw_days_array = explode(",",$lottery->draw_days);
								 
									 $today = strtolower(date("D"));
									 $today_date = (date("w"));
									// echo "<br>today_date >> ".$today_date;exit;
									 $count = count($draw_days_array);
									//echo "<br>count >> ".$count;
									
								    
									if(array_search($today,$draw_days_array))
									 {
										 $day_status = 1;
									 }
									 else
										 $day_status = 0;
									
								 	$current_time = date("h a");
									$timeSlotStart = DB::table("time_slots")->where(['id'=>$lottery->start_lottery_time])->first();
									$start_time = $timeSlotStart->name;
									$timeSlot = DB::table("time_slots")->where(['id'=>$lottery->end_lottery_time])->first();
								  	$end_time = $timeSlot->name;
									$time1 = DateTime::createFromFormat('H a', $current_time);
									// print_r($time1);
									// exit;
									$time2 = DateTime::createFromFormat('H a', $start_time);
									$time3 = DateTime::createFromFormat('H a', $end_time);
									if($day_status==1 && ($time1 >= $time3) && ($time1 <= $time2))
									{
									    $time_status = 1;
									}
									else
										$time_status = 0;
									
									
									$s_time = $time1;
									$end_time_lottery = $time3;

									$new_day = get_day_slider($draw_days_array,$today_date,$s_time,$end_time_lottery);
									$weekdays = ["sun","mon","tue","wed","thu","fri","sat"];
									 $day = $weekdays[$new_day];

									
									
								@endphp
				<div class="slider-content">
					<div class="container">
						<div class="row col-md-12">
							<div class="col-md-8">
								<!-- layer 1 -->
								<div class="layer-1 wow fadeInUp" data-wow-delay="0.3s">
								    <h2 class="title2" style="text-transform: capitalize; text-align: center; color: #fff !important;">Winning Numbers</h2>
									<!-- <h2 class="title2">Play lottery everyday and win big amount</h2> -->
								</div>
								<!-- layer 2 -->
								<!-- <div class="layer-2 wow fadeInUp" data-wow-delay="0.5s">
									<p>{!! $home->banner_text !!}</p>
								</div> -->

							<div class="winner-content" style="margin-left: -30px; width: 100% !important">
                                    <!-- <h4>MEGA JACKPOT</h4> -->
								 <ul class="winning-number">
								@php $lottery_array_new = explode(",",$winner->lottery_draw_no); @endphp
								@foreach($lottery_array_new as $lottery_new)
			                    <li><a style="width:90px; height: 90px; border-radius: 45px; font-size: 35px; line-height: 90px;">{{$lottery_new}}</a></li>
								@endforeach
								<li><a style="background:blue;width:37px; width:90px; height: 90px; border-radius: 45px; font-size: 35px; line-height: 90px;">{{$winner->lottery_draw_power_ball}}</a></li>
                                    </ul>
                                     <h6 style="text-align: center; color: #fff !important;">{{date("F, m/d/Y",strtotime($winner->today_date))}}</h6>
                                     <br>
                                     <h4 style="text-align: center; color: #fff !important;">{{$winner->lottery_name}} <br> Winners</h4><hr style="border-top: 1px solid #ccc !important">
                                     <h3 style="text-align: center; color: #fff !important;">OH</h3>
                                   <div style="align-items: center; margin-left: 40% !important;"><a class="ticket-btn " href="{{url('past-winners')}}">View All Winners</a></div>
										
											
                                </div>
								<!-- layer 3 -->
								<!-- <div class="layer-3 wow fadeInUp" data-wow-delay="0.7s">
									<a href="{{url('lottery')}}" class="ready-btn left-btn" >Play Lottery</a>
								</div> -->
							</div>

							<div class="col-md-4">
								<div class="support-services" style="border : 1px solid #1FC157">
                          <h2 class="title2" style="text-transform: capitalize; color: #1FC157;">Next Estimated {{$winner->lottery_name}}</h2>
                            <div class="support-content">
                                <h1 style="color: #fff !important;">${{$winner->cat1_val}}</h1>

                              <!--   <h6 style="color: #fff !important;">CASH OPTION: $49.3 MILLION</h6>-->
                                <h6 style="color: #1FC157;">Next Drawing:</h6>
                                <h6 style="color: #1FC157;">Last Purchase: {{$end_time}}</h6>
                                <h6 style="color: #1FC157;">{{date("d M Y",strtotime("next $day"))}} {{$lottery->draw_timing}}</h6>
                             <!--  <a class="ticket-btn " href="http://pentagoninfosys.com/lottery/lottery/1">Where to Play</a>
                                <a class="ticket-btn " href="http://pentagoninfosys.com/lottery/lottery/1">How to Play</a> -->
                            </div>
                        </div>
							</div>
						</div>
					</div>
				</div>
				@if($loop->iteration==1)
					@php break;@endphp
				@endif
			@endforeach


			</div>
        </div>
        <!-- End Slider Area-->








