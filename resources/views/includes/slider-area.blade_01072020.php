<!-- Start Slider Area -->
		<div class="intro-area intro-home">
            <div class="bg-wrapper">
            	<img src="{{url('admin/public/images/'.$home->banner_image)}}" alt="">
            </div>
			<div class="intro-content">
				<div class="slider-content">
					<div class="container">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<!-- layer 1 -->
								<div class="layer-1 wow fadeInUp" data-wow-delay="0.3s">
								    <h6 class="best-title">Play & win lottery easily</h6>
									<h2 class="title2">Play lottery everyday and win big amount</h2>
								</div>
								<!-- layer 2 -->
								<div class="layer-2 wow fadeInUp" data-wow-delay="0.5s">
									<p>{!! $home->banner_text !!}</p>
								</div>
								<!-- layer 3 -->
								<div class="layer-3 wow fadeInUp" data-wow-delay="0.7s">
									<a href="{{url('lottery')}}" class="ready-btn left-btn" >Play Lottery</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- End Slider Area -->