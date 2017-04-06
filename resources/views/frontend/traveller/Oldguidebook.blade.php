@extends('frontend.layouts.masterProfile')
@section('title') Guide Booking | {{ $siteTitle }}@endsection
@section('content')

<section class="dashboard">
		<div class="container">

			<div class="row">

				<div class="col-md-9">
				@include('includes.partials.messages')
					<div class="profile-edit">
						<h4>Guide Booking</h4>
                                                
                                                <div class="BookingText">
                                                    Booking with {{$guide->fname.' '.$guide->lname}} for {{$totalDays}} days <br />
                                                    Total Amount = ${{$totalAmount}}
                                                    
                                                </div> 
                                                
                                                <!-- <table width="100%">
                                                <tbody><tr><th colspan="2">
                                                    Booking Details 
                                                </th>
                                                </tr><tr>
                                                    <td width="55%" id="priceCalculation">${{$guidePrice}} X {{$totalDays}}days</td>
                                                    <td width="40%" align="right" id="calculatedPrice">
                                                    ${{number_format($guidePrice*$totalDays,2)}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Total</td>
                                                    <td align="right" id="totalSumPrice">${{number_format($guidePrice*$totalDays,2)}}</td>
                                                </tr>
                                            </tbody></table>
                                                -->
                                                
                                                
						<div class="row">
							
							<div class="col-md-6"> 
								{!! Form::open(['route' => 'paymentpaypal.index', 'id' => 'ccForm']) !!}
                                                                   <input type="hidden" name="gid"  value="{{$guide->id}}" />
								   <div class="form-group">
								   {!! Form::label('First Name', 'CC Name', ['class' => 'control-label']) !!}
                                                                   <input type="text" name="firstname" class="form-control requiredz" />
								   </div>
                                                                <div class="form-group">
								   {!! Form::label('Last Name', 'Last Name', ['class' => 'control-label']) !!}
                                                                   <input type="text" name="lastname" class="form-control requiredz" />
								   </div>
                                                                
                                                                <div class="form-group">
								    {!! Form::label('ccv', 'Card Type', ['class' => 'control-label']) !!}
                                                                    <select name="cc_type" class="cc-month required">
                                                                    <option value="">Card Type</option>
                                                                    <option value="visa">Visa</option>   
                                                                    <option value="mastercard">Mastercard</option>   
                                                                        
                                                                    </select>
                                                                    
                                                                </div>
								   <div class="form-group">
								   {!! Form::label('cc', 'Credit Card', ['class' => 'control-label']) !!}
                                                                   <input name="cc_no" type="" class="form-control required" />
								   </div>
								   <div class="form-group">
								    {!! Form::label('ccv', 'CCV', ['class' => 'control-label']) !!}
								     <input name="ccv" type="" class="form-control required" />
								   </div>
                                                                   <div class="form-group">
								    {!! Form::label('ccv', 'Expire', ['class' => 'control-label']) !!}
                                                                    <select name="month" class="cc-month required">
                                                                    <option value="">Month</option>
                                                                        <?php 
                                                                        for($i=1;$i<=12;$i++)
                                                                         echo '<option value="'.$i.'">'.$i.'</option>';
                                                                        ?>
                                                                        
                                                                    </select>
                                                                    <select name="year" class="cc-year">
                                                                    <option value="">Year</option>
                                                                        <?php 
                                                                        for($i=date('Y');$i<=date('Y')+10;$i++)
                                                                         echo '<option value="'.$i.'">'.$i.'</option>';
                                                                        ?>
                                                                        
                                                                    </select>
                                                                    
								   </div>
								   <div class="form-group">
								   	{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
								   </div>
								{!! Form::close() !!}
							</div>
							</div>
						</div>
					</div>
				</div>
                    
                    <div class="row">
                    <div class="col-md-9 col-sm-8">
                        <form action="">
                            <div class="billing-address">
                                <h2>Billing Address</h2>
                                <div class="row">
                                    
                                        <div class="col-md-6 form-group">
                                            <label for="">First Name <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" >
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for=""> Last Name <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="">Street <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="">City <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">State/Province</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Zip/Postal Code <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Country <span class="asterisk">*</span></label>
                                        <select class="form-control" name="" id="">
                                            <option value="paypal">Nepal</option>
                                            <option value="paypal">USA</option>
                                            <option value="paypal">England</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="payment-type">
                                <h2>Payment</h2>
                                <div class="payment-card">
                                    <a href="#">
                                        <img alt="" src="images/paypal-logo.png">
                                    </a>
                                    <p class="">You will be redirected to Paypal site after clicking on above logo.</p>
                                </div>
                            </div>
                            <!-- <div class="payment-type">
                                <h2>Payment</h2>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Billing Country</label>
                                            <select class="form-control" name="" id="">
                                                <option value="paypal">Japan</option>
                                                <option value="paypal">China</option>
                                                <option value="paypal">England</option>
                                            </select>
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
                                            <input type="text" class="form-control">
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
                            </div> -->
                            <div class="text-left">
                                <button class="btn btn-primary cust-btn-lg">Continue <i class="fa fa-angle-right"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="booked-detail">
                            <div style="background-image:url(images/guide-2.jpg)" class="payment-for">
                            </div>
                            <div class="summary">
                                <div class="guide-detail">
                                    <h4>Anthony Bell</h4>
                                    <div class="row">
                                        <div class="col-md-8 col-xs-8">
                                            Experience : 2 year
                                        </div>
                                        <div class="col-md-4 col-xs-4">
                                            <span data-original-title="Remarkable" class="rating remarkable pull-right" data-toggle="tooltip" date-placement="top" title="">
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
		</div>
</section>

@endsection
