<!-- Start Lottery area -->
<div class="ticket-area bg-color area-padding-2">
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
					@php 
					function get_day($draw_days_array,$d,$s_time,$end_time_lottery)
					{
						
						for($h=0;$h<count($draw_days_array);$h++)
						{
							// echo "count >>>> ".count($draw_days_array);
							// echo "s_time >> ";
							// print_r($s_time);
							// echo "end_time_lottery >> ";
							// print_r($end_time_lottery);
							// echo "<br>";
							// exit;
							// if($d < $draw_days_array[$h] && $s_time <= $end_time_lottery)
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
									return $draw_days_array[$h+1];
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
					@foreach($lotterys as $lottery)
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- fun_text  -->
                            <div class="single-ticket">
                                <span class="ticket-rate">{{$lottery->ticket_price}}CD</span>
                                <div class="ticket-image">
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">${{$lottery->cat1_val}}k</span>
                                    <img src="{{url('admin/public/images/'.$lottery->image)}}" alt="">
                                </div>
                                <div class="ticket-text">
								@php 
								$draw_days_array = explode(",",$lottery->draw_days);
								 // $d = date("w");
								 $d = 1;
								
								
								
								
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

$new_day = get_day($draw_days_array,$today_date,$s_time,$end_time_lottery);
$weekdays = ["sun","mon","tue","wed","thu","fri","sat"];
 $day = $weekdays[$new_day];

									
									
								@endphp
                                    <h4 class="ticket-name">{{$lottery->name}} </h4>
                                    <span class="draw">Last Purchase: {{$end_time}}<br>Next Draw: {{date("d M Y",strtotime("next $day"))}} {{$lottery->draw_timing}}</span>
								@if($time_status==1)
                                    <a  class="ticket-btn btn-danger stop_lottery" style="background:red;" href="#" data-toggle="tooltip" title="Lottery Has Stop Now It Will be Open At {{$start_time}}">Stop Now</a> 
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
		
        <!-- End Lottery area -->