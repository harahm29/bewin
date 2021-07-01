 <!-- Start Number area -->
 <div class="winner-area bg-color area-padding-2" style="padding: 10px 0px 70px;">
            <div class="container">
                 <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline text-center">
							<h3>Latest Winner</h3>
							
						</div>
					</div>
				</div>
                <div class="row">
                    <!-- Start latest winner -->
					@foreach($winners as $winner)
                    <div class="col-md-6">
                        <div class="winner-results">
                            <div class="winner-inner">
                                <span class="draw-date"> {{date("d M",strtotime($winner->today_date))}}</span>
                                <img class="winner-images" src="{{url('public/frontend/img/about/win.png')}}" alt="">
                                <div class="winner-content">
                                    <h4>{{$winner->lottery_name}}</h4>
									@php $lottery_array = explode(",",$winner->lottery_draw_no); @endphp
                                    <ul class="winning-number">
										@foreach($lottery_array as $lottery)
                                          <li ><a href="#" style="width:37px;">{{$lottery}}</a></li>
									    @endforeach
										<li  ><a href="#" style="background:blue;width:37px;">{{$winner->lottery_draw_power_ball}}</a></li>
                                    </ul>
                                    <span class="jackpot">Win: {{$winner->cat1_val}}</span>
										
											
                                </div>
                            </div>
                        </div>
                    </div>
					@php if($loop->iteration==4)
											break;
										@endphp
					@endforeach
                    
                    <!-- Start latest winner -->
                </div>
            </div>
        </div>
        <!-- End Number area -->