<!--Start payment-history area -->
<div class="payment-history-area bg-color-2 fix area-padding">
            <div class="container">
                <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline text-center">
							<h3>Past Winners</h3>
							<p></p>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="deposite-content">
                            <div class="diposite-box">
                                <div class="deposite-table">
                                    <table>
                                        <tr>
                                           
                                            <th>Draw Date</th>
											<th>Lottery name</th>
                                            <th>Winning Number</th>
                                            <th>Winning Amount</th>
                                            <th>Winner Name</th>
                                        </tr>
                                        @foreach($pastwinners as $winner)
										<tr>
                                           
                                            <td>{{date("d-m-Y",strtotime($winner->draw_date))}}</td>
											<td><img src="{{url('admin/public/images/'.$winner->lottery_image)}}" alt=""  style="max-width:30px;" >{{$winner->lottery_name}}</td>
                                            <td>
											@php $lottery_array = explode(",",$winner->winning_no); @endphp
                                               <ul class="self-number">
											   @foreach($lottery_array as $lottery)
                                                    <li><a href="#">{{$lottery}}</a></li>
											   @endforeach
											    <li><a href="#" style="background:blue;">{{$winner->powerball}}</a></li>
                                                </ul>
                                            </td>
                                            <td>@if(is_numeric($winner->winning_amount))${{$winner->winning_amount}} @else {{$winner->winning_amount}} @endif</td>
                                            <td>{{$winner->winner_name}}</td>
                                           
                                        </tr>
                                    
										@php if($loop->iteration==10)
											break;
										@endphp
                                        @endforeach
                                       
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End payment-history area -->