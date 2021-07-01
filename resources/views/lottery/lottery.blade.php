@extends('layouts.admin')
@section('title','Lottery 2')
@section('content')
 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>Lottery One</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Lottery One</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Header -->
  <!-- Start Lottery area -->
  <div class="ticket-area area-padding-2">
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
                    <div class="ticket-content">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-ticket">
                                <span class="ticket-rate">20CD</span>
                                <div class="ticket-image">
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$2000k</span>
                                    <img src="{{url('public/frontend/img/about/chips1.png')}}" alt="">
                                </div>
                                <div class="ticket-text">
                                    <h4 class="ticket-name">Winter Jackpot</h4>
                                    <span class="draw">Next Draw: 20 may 2020</span>
                                    <a class="ticket-btn" href="#">Play Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-ticket">
                                <span class="ticket-rate">20CD</span>
                                <div class="ticket-image">
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$5000k</span>
                                    <img src="{{url('public/frontend/img/about/chips2.png')}}" alt="">
                                </div>
                                <div class="ticket-text">
                                    <h4 class="ticket-name">Las Vegas Lottery</h4>
                                    <span class="draw">Next Draw: 10 may 2020</span>
                                    <a class="ticket-btn" href="#">Play Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-ticket">
                                <span class="ticket-rate">20CD</span>
                                <div class="ticket-image">
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$8000k</span>
                                    <img src="{{url('public/frontend/img/about/chips4.png')}}" alt="">
                                </div>
                                <div class="ticket-text">
                                    <h4 class="ticket-name">Powerball</h4>
                                    <span class="draw">Next Draw: 15 may 2020</span>
                                    <a class="ticket-btn" href="#">Play Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-ticket">
                                <span class="ticket-rate">20CD</span>
                                <div class="ticket-image">
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$8000k</span>
                                    <img src="{{url('public/frontend/img/about/chips5.png')}}" alt="">
                                </div>
                                <div class="ticket-text">
                                    <h4 class="ticket-name">Millons Jackpot</h4>
                                    <span class="draw">Next Draw: 18 may 2020</span>
                                    <a class="ticket-btn" href="#">Play Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-ticket">
                                <span class="ticket-rate">20CD</span>
                                <div class="ticket-image">
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$8000k</span>
                                    <img src="{{url('public/frontend/img/about/chips6.png')}}" alt="">
                                </div>
                                <div class="ticket-text">
                                    <h4 class="ticket-name">Mega Jackpot</h4>
                                    <span class="draw">Next Draw: 18 may 2020</span>
                                    <a class="ticket-btn" href="#">Play Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-ticket">
                                <span class="ticket-rate">20CD</span>
                                <div class="ticket-image">
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$8000k</span>
                                    <img src="{{url('public/frontend/img/about/chips3.png')}}" alt="">
                                </div>
                                <div class="ticket-text">
                                    <h4 class="ticket-name">Summer Jackpot</h4>
                                    <span class="draw">Next Draw: 18 may 2020</span>
                                    <a class="ticket-btn" href="#">Play Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Lottery area -->
		
@endsection	