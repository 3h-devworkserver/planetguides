@extends('frontend.layouts.masterProfile')
@section('title') Guide Booking | {{ $siteTitle }}@endsection
@section('content')
<section class="payment-booked_detail" style="padding-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <?php if ($paypalSubmit) { ?>

                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="PaypalForm">
                        <input type="hidden" name="cmd" value="_xclick">	
                        <input type="hidden" name="first_name" value="<?= $first_name ?>" />
                        <input type="hidden" name="last_name" value="<?= $last_name ?>" />
                        <input type="hidden" name="business" value="<?= $business ?>">
                        <input type="hidden" name="item_name" value="<?= $item_name ?>">
                        <input type="hidden" name="amount" value="<?= $amount ?>">
                        <input type="hidden" name="tax" value="<?= $tax ?>">
                        <input type="hidden" name="quantity" value="<?=$quantity?>">
                        <input type="hidden" name="no_shipping" value="2">
                        <input type="hidden" name="no_note" value="1">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="bn" value="IC_Sample">
                        <input type="hidden" name="custom" value="<?= $custom ?>">            
                        <input type="hidden" name="return" value="">
                        <input type="hidden" name="notify_url" value="<?= $notify_url ?>">
                        <input type="hidden" name="return" value="<?php echo $return; ?>">
                        <input type="hidden" name="cancel_return" value="<?php echo $cancel_return; ?>">
                    </form>
                    <div style="text-align: center;">
                        <h2 style="vertical-align: central;" align="center">
                            <i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br /><br />
                            Redirecting to Paypal...
                        </h2>
                    </div>
                    <script>
                        $(document).ready(function () {
                         $('#PaypalForm').submit();
                        });
                    </script>
                <?php } else { ?>

                    {!! Form::open(['route' => 'frontend.guide.paypal.post', 'id' => 'ccForm']) !!}
                    <div class="billing-address">
                        <h2>Billing Address</h2>
                        <div class="row">
                            <input type="hidden" name="totalDays" value="{{$totalDays}}" />
                            <input type="hidden" name="dates" value="{{$dates}}" />
                            <input type="hidden" name="gid"  value="{{$guide->id}}" />

                            <div class="col-md-6 form-group">
                                <label for="">First Name <span class="asterisk">*</span></label>
                                <input type="text" name="first_name" class="form-control required" >
                            </div>
                            <div class="col-md-6 form-group">
                                <label for=""> Last Name <span class="asterisk">*</span></label>
                                <input type="text" name="last_name" class="form-control required">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="">Email <span class="asterisk">*</span></label>
                                <input type="text" name="email" class="form-control required email">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="">Street <span class="asterisk">*</span></label>
                                <input type="text" name="street" class="form-control required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">City <span class="asterisk">*</span></label>
                                <input type="text" name="city" class="form-control required">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">State/Province</label>
                                <input type="text" name="state" class="form-control required">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Zip/Postal Code <span class="asterisk">*</span></label>
                                <input type="text" name="zip" class="form-control required">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country <span class="asterisk">*</span></label>
                                <select id="" name="country" class="form-control required">
                                    <option value="">Country</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="USA">USA</option>
                                    <option value="England">England</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-grup">
                                <label>Payment Type <span class="asterisk">*</span></label>
                                <select id="payment_type" name="payment_type" class="form-control" style="margin-top:5px;font-weight:600;">
                                    <option value="full">Full Payment.</option>
                                    <option value="partial">I wish to pay partially for now.</option>
                                </select>
                                <script>
                                    $(document).ready(function() {
                                        $("#partialBlock").hide();
                                        $("#payment_type").change(function() {
                                            var type = $(this).val();
                                            if (type=="full") {
                                                $("#fullBlock").show();
                                                $("#partialBlock").hide();
                                            } else {
                                                $("#partialBlock").show();
                                                $("#fullBlock").hide();
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>

                    </div>


                    <div class="payment-type">
                        <h2>Payment</h2>
                        <div class="payment-card">
                            <a href="#">
                                <img src="images/paypal-logo.png" alt="">
                            </a>
                            <p class="">You will be redirected to Paypal site after clicking on above logo.</p>
                        </div>
                    </div>

                    <div class="text-left">
                        <input type="hidden" name="submitPayment" value="1" />
                        <button class="btn btn-primary cust-btn-lg" name="submit">Continue <i class="fa fa-angle-right"></i></button>
                    </div>
                    </form>

                <?php } ?>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="booked-detail">
                    <div class="payment-for" style="background-image:url({{ asset($guide->profilePic) }})">
                    </div>
                    <div class="summary">
                        <div class="guide-detail">
                            <h4>{{$guide->fname.' '.$guide->lname}}</h4>
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
                            <p>Booked for {{$totalDays}} days</p>
                            <div class="date">
                                <p style="word-break: normal;word-wrap: break-word;">For: {{$dates}}</p>
                            </div>
                        </div>
                        <div class="pricing" id="fullBlock">
                            <div class="pricing-detail">
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <td>${{$guidePrice}} x {{$totalDays}}</td>
                                            <td class="text-center">${{$totalAmount}}</td>
                                        </tr>
                                        <tr>
                                            <td>Service fee</td>
                                            <td class="text-center">${{$serviceFee}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="total">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-center">${{$serviceFee + $totalAmount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pricing" id="partialBlock">
                            <div class="pricing-detail">
                                <table width="100%" style="margin-top:20px;">
                                    <tbody>
                                        <tr>
                                            <th colspan="2">For Partial Payment (20% payment)</th>
                                        </tr>
                                        <tr>
                                            <td>20% of ${{$guidePrice}} x {{$totalDays}}</td>
                                            <td class="text-center">${{$totalAmount *  (20/100)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Service fee</td>
                                            <td class="text-center">${{$serviceFee * (20/100)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="total">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Total Partial</td>
                                            <td class="text-center">${{($serviceFee * (20/100)) + ($totalAmount *  (20/100)) }}</td>
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
