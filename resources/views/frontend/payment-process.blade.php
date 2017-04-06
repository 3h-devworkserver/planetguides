@extends('frontend.layouts.masterProfile')
@section('title') Payment Process | {{ $siteTitle }}@endsection

@section('content')
<section class="payment-booked_detail">
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-sm-7">
				  {!! Form::open(['role' => 'form', 'method' => 'POST']) !!}
					<div class="payment-type">
						<h2>Payment</h2>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">Billing Country</label>
											{!! Form::selectCountry('country', '', ['class' => 'form-control']) !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">Payment Type</label>
											<select id="payment-type" name="payment-type" class="form-control">
												<option value="paypal">Paypal</option>
											</select>
									</div>
									<div class="col-md-6">
										<ul class="payment-card">
											<li><i class="fa fa-cc-paypal"></i></li>
										</ul>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">Card Number</label>
										{!! Form::text('cardno', null ,['class' => 'form-control']) !!}
									</div>
								</div>
							</div>

							<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label for="">Expire on</label>
													<div class="row">
														<div class="col-md-6">
															<select id="sel1" class="form-control">
																<option>1</option>
																<option>2</option>
																<option>3</option>
																<option>4</option>
															</select>
														</div>
														<div class="col-md-6">
															<select id="sel1" class="form-control">
																<option>1</option>
																<option>2</option>
																<option>3</option>
																<option>4</option>
															</select>
														</div>
													</div>
									
									</div>
									<div class="col-md-6 security-code">
										<label for="">Security code</label>
											<input type="text" class="form-control">
									</div>
								</div>
							</div>
					</div>
					<div class="billing-address">
						<h2>Billing Address</h2>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">First Name</label>
										<input type="text" class="form-control">
									</div>
									<div class="col-md-6">
										<label for=""> Last Name</label>
										<input type="text" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">Street Address</label>
										<input type="text" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label for="">City</label>
										<input type="text" class="form-control">
									</div>
									<div class="col-md-2">
										<label for="">State</label>
										<input type="text" class="form-control">
									</div>
									<div class="col-md-3">
										<label for="">Postal Address</label>
										<input type="text" class="form-control">
									</div>
									<div class="col-md-3">
										<label>Country</label>
										<p class="help-block">Nepal</p>
									</div>
								</div>
							</div>
					</div>
						<div class="text-center">
							<button class="btn btn-primary cust-btn-lg">Continue</button>
						</div>
					{!! Form::close() !!}
				</div>
				<div class="col-md-3 col-sm-5">
					<div class="booked-detail">
						<div class="payment-for" style="background-image:url(images/guide-2.jpg)">
							
						</div>
						<div class="summary">
							<div class="guide-detail">
								<h4>Anthony Bell</h4>
								<div class="row">
									<div class="col-md-8 col-xs-8">
										Experience : 2 year
									</div>
									<div class="col-md-4 col-xs-4">
										<span title="" date-placement="top" data-toggle="tooltip" class="rating remarkable pull-right" data-original-title="Remarkable">
											<span>5</span>
										</span>
									</div>
								</div>
							</div>
							<div class="booked-date">
								<p>Booked for 3 days</p>
								<div class="date">
									<p>From: Jan 01,2016 To: Jan 03,2016</p>
								</div>
							</div>
							<div class="pricing">
								<div class="pricing-detail">
									<table width="100%">
											<tbody>
												<tr>
													<td>$50 x 1</td>
													<td class="text-center">$50</td>
												</tr>
												<tr>
													<td>Service fee</td>
													<td class="text-center">$10</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="total">
										<table>
											<tbody>
												<tr>
													<td>Total</td>
													<td class="text-center">$60</td>
												</tr>
											</tbody>
										</table>
									</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection