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
					</div>
				</div>
			</div>	
		</div>
		<div class="container">
			<div class="wrapper">
				<div class="row">
					<div class="col-md-12">
						<div class="recentactives">
							<h1>Your Earnings</h1>
							@if ($bookings)
								<table class="table">
									<tr>
										<th>Traveler</th>
										<th>E-Mail Address</th>
										<th>Location Details</th>
										<th>Dates</th>
										<th>Number of days</th>
										<th>Amount ($)</th>
									</tr>
								@foreach ($bookings as $booking)
									<tr>
										<th>
											{{ User::find($booking->uid)->fname }} {{ User::find($booking->uid)->lname }}
										</th>
										<th>
											{{ $booking->email }}
										</th>
										<th>
											{{ $booking->country }}<br>{{ $booking->state }}<br>{{ $booking->city }}
										</th>
										<th>
											{!! str_replace(',', "<br>", $booking->dates) !!}
										</th>
										<th>
											{!! $booking->days !!}
										</th>
										<th>
											${{ ($booking->transaction_amount+$booking->next_amount-$booking->service_charge-$booking->next_service_charge) }}
										</th>
									</tr>
								@endforeach
								</table>
							@else
								<div class="alert alert-info text-center">
									Sorry, you have not been booked by any traveler yet.
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

