<!-- Start Choose area -->
@php $data = DB::table('homes')->first(); @endphp
@if($data == '')
@php
$data = ""; @endphp
@endif 
<div class="choose-area area-padding-2">
            <div class="container">
                <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline text-center">
							<h3>{{$data->why_choose}}</h3>
							<p>{!! $data->why_choose_des  !!}</p>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- Start services -->
                        <div class="support-services">
                            <img class="support-images" src="{{url('public/frontend/img/about/ab-icon.png')}}" alt="">
                            <div class="support-content">
                               <h3>{{$data->why_choose1}}</h3>
							<p>{!! $data->why_choose_des1  !!}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Start services -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="support-services">
                            <img class="support-images" src="{{url('public/frontend/img/about/ab-icon2.png')}}" alt="">
                            <div class="support-content">
                               <h3>{{$data->why_choose2}}</h3>
							<p>{!! $data->why_choose_des2  !!}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Start services -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="support-services">
                            <img class="support-images" src="{{url('public/frontend/img/about/ab-icon3.png')}}" alt="">
                            <div class="support-content">
                                <h3>{{$data->why_choose3}}</h3>
							<p>{!! $data->why_choose_des3  !!}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Start services -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="support-services">
                            <img class="support-images" src="{{url('public/frontend/img/about/ab-icon4.png')}}" alt="">
                            <div class="support-content">
                               <h3>{{$data->why_choose4}}</h3>
							<p>{!! $data->why_choose_des4  !!}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Start services -->
                </div>
            </div>
        </div>
        <!-- End Choose area -->