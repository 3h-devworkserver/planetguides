@extends('frontend.layouts.master')
@section('title'){{ $siteTitle }}@endsection
@section('banner')
	@include('frontend.includes.banner')
@stop
@section('content')
			<div class="row">
				<div class="col-md-12">
					<div class="page-header">
						<h2 class="text-center">Top Guides</small></h2>
					</div>
				</div>
			</div>
			<div class="guides">
				<div class="row">
					@foreach ($guides as $guide)
			@if($guide->user->confirmed == 1)
					<div class="col-sm-6 col-md-3">
						<!--<div class="thumbnail">
							<a href="{{ URL::to('guide/'.$guide->user->username) }}">
								<div style="background-image:url({{ asset($guide->user->profilePic) }})"></div>
							</a>
							<div class="caption">
								<h3><a href="{{ URL::to('guide/'.$guide->user->username) }}">{{ $guide->user->name }}</a></h3>
								<div class="experience pull-left">
									<em>Experience : {{ $guide->experience}}</em>
								</div>
								<div class="rating pull-right">
									<span class="guideStars">{{ $guide->rating_cache }}</span>
								</div>
							</div>
						</div>-->

						<div class="thumbnail text-center">
                                <!-- <div class="verified">
                                    <i class="fa fa-certificate"></i>
                                    <span class="triangle-up">
                                    </span>
                                </div> -->
                                <div class="inner-thumb">
                                	<a class="guide-image" href="{{ URL::to('guide/'.$guide->user->username) }}">
	                                <span class="bg-wrap" style="background-image:url({{ asset($guide->user->profilePic) }})">
	                                    
	                                </span>
                            	</a>
                                <h4 class="guide-name">
                                    <a href="{{ URL::to('guide/'.$guide->user->username) }}">{{ $guide->user->name }}</a>
                                    <small>since {{ $guide->experience}}</small>
                                </h4>
                                <div class="guide-rating">
                                    <!-- <ul class="list-inline">
                                        <li class="rated">
                                            <span><i class="fa fa-star"></i></span>
                                        </li>
                                        <li class="rated">
                                            <span><i class="fa fa-star"></i></span>
                                        </li>
                                        <li>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </li>
                                        <li>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </li>
                                        <li>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </li>
                                    </ul> -->
                                    <div class="rating">
										<span class="guideStars">{{ $guide->rating_cache }}</span>
									</div>
                                </div>
                                </div>
                                <a class="view-profile" href="{{ URL::to('guide/'.$guide->user->username) }}">View Profile</a>
                            </div>
					</div>
			@endif
				@endforeach
				</div><!--end row-->

				
			</div> <!--end guides-->
			
@stop

@section('after-scripts-end')


<script type="text/javascript">
	$(function() {    		
		$('span.guideStars').stars();
	});

	$.fn.stars = function() {
		return $(this).each(function() {
			$(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
		});
	}

	$(function() {
		var date = new Date(), y = date.getFullYear(), m = date.getMonth();
		var firstDay = new Date(y, m, 1);
		var lastDay = new Date(y, m + 1, 0);

		var dateToday = new Date();
  		$('#date-range').daterangepicker({
      		autoUpdateInput: false,
      		autoApply: true,
       		minDate: dateToday,
  		});
	});

	$('#autocomplete-name').autocomplete({
        serviceUrl: base_url+'/autocomplete/search?type=name',
        dataType: 'json',
        type: 'GET',
        onSelect: function (suggestion) {
            $('#autocomplete-name').val(suggestion.value);
        },
    });

</script>
@stop



