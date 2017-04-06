<?php
use App\Models\Access\User\User;
?>
@extends('frontend.layouts.masterProfile')
@section('title') Recent Activity | {{ $siteTitle }}@endsection
@section('content')	
	<section class="dashboard">
		<div class="profile">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
					    <div class="profile-img pull-left">
					        <span class="avatar"><i class="fa fa-user"></i></span>
					        <label class="username">{{ Auth::user()->username}}</label>
					    </div>

					    <div class="view-profile pull-right">
					        <a class="btn btn-danger" href="{{ route('frontend.traveller.profile')}}">View Profile</a>
					    </div>
					</div>
				</div>
			</div>	
		</div>
		<div class="container">
			<div class="wrapper">
				<div class="row">
				@if (Session::has('message'))
					<div class="col-md-6 col-md-offset-3 alert alert-info">
						{{ Session::get('message') }}
					</div>
				@endif
					<div class="col-md-12">
						<div class="recentactives">
							<h1>Recently Addes Guides</h1>
						
						@foreach ($bookings as $booking)
							<div class="post">
								<div class="row">
									<div class="col-md-10">
										<div class="user">
											<a href="{{ URL::to('guide/'.$booking->user->username) }}" style="background-image:url({{ $booking->user->picture }})"></a>
											<div class="name" style="padding-top: 2px;">
												<h4 style="line-height: 18px;">{{ ucwords($booking->user->name) }}</h4>
												<span style="font-weight: bold;">Since {{ $booking->user->experience }} </span>
												<div>
													<span class="rating average">
														<span>{{ $booking->user->guide->rating_cache }}</span>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 text-center">
										<span class="booked">Booked {{ $booking->created_at->diffForHumans() }}</span>
											<span class="label label-success">Approved</span>
											<?php

											$guide = User::findOrFail($booking->gid);

											$data['item_name'] = 'Booking Partial Fees';
									        $data['first_name'] = Auth::user()->fname;
									        $data['last_name'] = Auth::user()->lname;
									        $data['email'] = $booking->email;
									        //$data['business'] = 'yojanlaravelmail-facilitator@gmail.com';
									        $data['business'] = 'akash.progressarc-facilitator@gmail.com';
									        $data['quantity'] = 1;
									        $data['amount'] = $booking->amount - $booking->transaction_amount;
									        $data['notify_url'] = url() . '/paymentpaypal/paypalipn';
									        $data['return'] = url().'/callback/paypal/'.$guide->username.'?user='.Auth::user()->id."&booking=".$booking->id."&process=complete";
									        $data['cancel_return'] = url().'/?payment=success';
									        $data['tax'] = '';
									        $data['custom'] = $booking->id.'-'.$booking->gid;
											?>
											@if ($booking->transaction_type == 'partial' && $booking->next_status == 'remaining' && $booking->status == 'booked' && $booking->amount > ($booking->transaction_amount+$booking->next_amount))
											<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
												<input type="hidden" name="cmd" value="_xclick">
												<input type="hidden" name="item_name" value="{{ $data['item_name'] }}" />
												<input type="hidden" name="first_name" value="{{ $data['first_name'] }}" />
												<input type="hidden" name="last_name" value="{{ $data['last_name'] }}" />
												<input type="hidden" name="email" value="{{ $data['email'] }}" />
												<input type="hidden" name="business" value="{{ $data['business'] }}" />
												<input type="hidden" name="quantity" value="{{ $data['quantity'] }}" />
												<input type="hidden" name="amount" value="{{ $data['amount'] }}" />
												<input type="hidden" name="notify_url" value="{{ $data['notify_url'] }}" />
												<input type="hidden" name="return" value="{{ $data['return'] }}" />
												<input type="hidden" name="cancel_return" value="{{ $data['cancel_return'] }}" />
												<input type="hidden" name="no_shipping" value="1">
						                        <input type="hidden" name="no_note" value="1">
						                        <input type="hidden" name="currency_code" value="USD">
						                        <input type="hidden" name="bn" value="IC_Sample">
												<input type="hidden" name="tax" value="{{ $data['tax'] }}" />
												<input type="hidden" name="custom" value="{{ $data['custom'] }}" />
												<button class="btn btn-success" style="margin-top:5px;">Pay Remaining {{ '$' . ($booking->amount-$booking->transaction_amount) }}</button>
											</form>
											@endif
										<!-- Cancel Button added -->
										@if ($booking->status == 'booked')
										<?php
										$datess = explode(',', $booking->dates);
										?>
											@if (strtotime($datess[0]) >= time())
												<a href="{{ route('frontend.traveller.cancel.booking', $booking->id) }}" class="btn btn-warning cust-btn-sm" style="margin-top:5px;">Request Cancel</a>
											@endif
										@elseif ($booking->status == 'cancel requested')
											<span class="label label-danger">Cancel Requested</span>
										@else
											<span class="label label-danger">Booking Canceled</span>
										@endif
									</div>
								</div>
							</div>
						@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

