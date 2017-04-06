@extends('frontend.layouts.masterProfile')
@section('title') Dashboard | {{ $siteTitle }}@endsection
@section('content')
<section class="dashboard">
	@include('frontend.traveller.includes.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				@include('frontend.traveller.includes.sidebar')
				<div class="dash-menu">
						<ul class="nav nav-tabs" role="tablist" id="myTab">
							<li role="presentation" class="active">
								<a href="#dash-home" aria-controls="home" role="tab" data-toggle="tab">
									<i class="fa fa-tachometer"></i>
									Recent Activities 
									<i class="fa fa-angle-right pull-right"></i>
								</a>
							</li>
							<li role="presentation">
								<a href="#reviews-home" aria-controls="profile" role="tab" data-toggle="tab">
									<i class="fa fa-pencil"></i>
									Reviews
									<i class="fa fa-angle-right pull-right"></i>
								</a>
							</li>
						</ul>
					</div>
			</div>
			<div class="col-md-9">
			    <div class="dashboard-activites">
			        <div class="tab-content" id="myTabContent">
			            <div role="tabpanel" class="tab-pane active" id="dash-home">
			                <div class="recentactives">
			                    <h1 class="content-title">recent activites</h1>
								@foreach ($bookings as $booking)
				                    <div class="post guide favourite">
				                        <div class="row">
				                            <div class="col-md-2">
											<a class="img-block bg-wrap" href="{{ URL::to('guide/'.$booking->user->username) }}" style="background-image:url({{ $booking->user->picture }})"></a>
				                            </div>
				                            <div class="col-md-10">
				                                <div class="post-top">
				                                    <div class="name">
				                                        <h4>
															<a href="{{ URL::to('guide/'.$booking->user->username) }}">{{$booking->user->name}}</a>@if(!empty($booking->user->profile->experience))<small> Experience: Since {{$booking->user->profile->experience}}</small>@endif
														</h4>
				                                        <p class="time">
				                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> {{ $booking->created_at->diffForHumans() }} <span>booked</span>.
				                                        </p>
				                                    </div>
				                                    <div class="review-rating">
				                                        <div class="rating average">
				                                            <span>{{ $booking->user->guide->rating_cache }}</span>
				                                        </div>
				                                        <div class="review">
				                                            <p>reviews<span>({{ $booking->user->guide->rating_count }})</span></p>
				                                        </div>
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
			                    @endforeach
			                    <?php /*?>
			                    <div class="post guide">
			                        <div class="row">
			                            <div class="col-md-2">
			                                <div class="img-block bg-wrap" style="background-image:url({{asset('images/guide-2.jpg')}})">
			                                </div>
			                            </div>
			                            <div class="col-md-10">
			                                <div class="post-top">
			                                    <div class="name">
			                                        <h4>
														<a href="#">John Doe</a><small>Since 2000</small>
													</h4>
			                                        <p class="time">
			                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 1 week ago <span>booked</span>.
			                                        </p>
			                                    </div>
			                                    <div class="review-rating">
			                                        <div class="rating remarkable">
			                                            <span>5</span>
			                                        </div>
			                                        <div class="review">
			                                            <p>review<span>(2)</span></p>
			                                        </div>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="post guide">
			                        <div class="row">
			                            <div class="col-md-2">
			                                <div class="img-block bg-wrap" style="background-image:url({{asset('images/guide-2.jpg')}})">
			                                </div>
			                            </div>
			                            <div class="col-md-10">
			                                <div class="post-top">
			                                    <div class="name">
			                                        <h4>
														<a href="#">Petey Cruiser </a><small>Since 2001</small>
													</h4>
			                                        <p class="time">
			                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 1 year ago <span>booked</span>
			                                        </p>
			                                    </div>
			                                    <div class="review-rating">
			                                        <div class="rating average">
			                                            <span>3</span>
			                                        </div>
			                                        <div class="review">
			                                            <p>review<span>(2)</span></p>
			                                        </div>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="post guide">
			                        <div class="row">
			                            <div class="col-md-2">
			                                <div class="img-block bg-wrap" style="background-image:url({{asset('images/guide-2.jpg')}})">
			                                </div>
			                            </div>
			                            <div class="col-md-10">
			                                <div class="post-top">
			                                    <div class="name">
			                                        <h4>
														<a href="#">Walter Melon</a><small>Since 2010</small>
													</h4>
			                                        <p class="time">
			                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 6 month ago <span>booked</span>.
			                                        </p>
			                                    </div>
			                                    <div class="review-rating">
			                                        <div class="rating worst">
			                                            <span>1</span>
			                                        </div>
			                                        <div class="review">
			                                            <p>review<span>(2)</span></p>
			                                        </div>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="post guide favourite">
			                        <div class="row">
			                            <div class="col-md-2">
			                                <div class="img-block bg-wrap" style="background-image:url({{asset('images/guide-3.jpg')}})">
			                                </div>
			                            </div>
			                            <div class="col-md-10">
			                                <div class="post-top">
			                                    <div class="name">
			                                        <h4>
														<a href="#">Rick O'Shea</a><small>Since 2015</small>
													</h4>
			                                        <p class="time">
			                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 1 day ago <span>booked</span>.
			                                        </p>
			                                    </div>
			                                    <div class="review-rating">
			                                        <div class="rating remarkable">
			                                            <span>5</span>
			                                        </div>
			                                        <div class="review">
			                                            <p>review<span>(2)</span></p>
			                                        </div>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                    <?php  */?>
			                </div>
			            </div>
			            <div role="tabpanel" class="tab-pane" id="reviews-home">
			                <h1>Recent Reviews</h1>

			                @foreach($reviews as $review)
				                <div class="post review">
				                <?php 
				                	$guide = App\Models\Guide::where('gid', $review->guide_id)->first();
				                ?>
				                    <div class="row">
				                        <div class="col-md-2">
				                        	<a class="img-block bg-wrap" href="{{ URL::to('guide/'.$booking->user->username) }}" style="background-image:url({{ $guide->user->picture }})"></a>
				                        </div>
				                        <div class="col-md-10">
				                            <div class="post-top">
				                                <div class="name">
				                                    <h4><a href="{{ URL::to('guide/'.$guide->user->username) }}"> {{$guide->user->name}} </a><small>Since {{$guide->user->experience}}</small></h4>
				                                    <div class="time">
				                                        <p>
				                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> {{ $review->created_at->diffForHumans() }} <span>review</span>.
				                                        </p>
				                                    </div>
				                                </div>
				                                <div class="review-rating">
				                                    <div class="rating remarkable">
				                                        <span>{{$review->rating}}</span>
				                                    </div>
				                                    <div class="review">
				                                       <p>Rating<span></span></p>
				                                    </div>
				                                </div>
				                            </div>
				                            <!--
				                            <div class="review-text">
				                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id distinctio doloribus nulla in magni saepe ipsa dolor ab, vero repudiandae porro et fugit nisi dolorum...</p>
				                            </div> -->
				                        </div>
				                    </div>
				                </div>
				            @endforeach
				            <?php /*  ?>
				                <div class="post review">
				                    <div class="row">
				                        <div class="col-md-2">
				                            <div class="img-block bg-wrap" style="background-image:url({{asset('images/guide-2.jpg')}})">
				                            </div>
				                        </div>
				                        <div class="col-md-10">
				                            <div class="post-top">
				                                <div class="name">
				                                    <h4><a href="#"> Ryan Sheridan </a><small>Since 1990</small></h4>
				                                    <div class="time">
				                                        <p>
				                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 6 days ago <span>review</span>.
				                                        </p>
				                                    </div>
				                                </div>
				                                <div class="review-rating">
				                                    <div class="rating remarkable">
				                                        <span>5</span>
				                                    </div>
				                                    <div class="review">
				                                        <p>review<span>(10)</span></p>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="review-text">
				                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id distinctio doloribus nulla in magni saepe ipsa dolor ab, vero repudiandae porro et fugit nisi dolorum...</p>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="post review">
				                    <div class="row">
				                        <div class="col-md-2">
				                            <div class="img-block bg-wrap" style="background-image:url({{asset('images/guide-2.jpg')}})">
				                            </div>
				                        </div>
				                        <div class="col-md-10">
				                            <div class="post-top">
				                                <div class="name">
				                                    <h4><a href="#"> Ryan Sheridan </a><small>Since 1990</small></h4>
				                                    <div class="time">
				                                        <p>
				                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 6 days ago <span>review</span>.
				                                        </p>
				                                    </div>
				                                </div>
				                                <div class="review-rating">
				                                    <div class="rating remarkable">
				                                        <span>5</span>
				                                    </div>
				                                    <div class="review">
				                                        <p>review<span>(10)</span></p>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="review-text">
				                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id distinctio doloribus nulla in magni saepe ipsa dolor ab, vero repudiandae porro et fugit nisi dolorum...</p>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="post review">
				                    <div class="row">
				                        <div class="col-md-2">
				                            <div class="img-block bg-wrap" style="background-image:url({{asset('images/guide-2.jpg')}})">
				                            </div>
				                        </div>
				                        <div class="col-md-10">
				                            <div class="post-top">
				                                <div class="name">
				                                    <h4><a href="#"> Ryan Sheridan </a><small>Since 1990</small></h4>
				                                    <div class="time">
				                                        <p>
				                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 6 days ago <span>review</span>.
				                                        </p>
				                                    </div>
				                                </div>
				                                <div class="review-rating">
				                                    <div class="rating remarkable">
				                                        <span>5</span>
				                                    </div>
				                                    <div class="review">
				                                        <p>review<span>(10)</span></p>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="review-text">
				                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id distinctio doloribus nulla in magni saepe ipsa dolor ab, vero repudiandae porro et fugit nisi dolorum...</p>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="post review">
				                    <div class="row">
				                        <div class="col-md-2">
				                            <div class="img-block bg-wrap" style="background-image:url({{asset('images/guide-2.jpg')}})">
				                            </div>
				                        </div>
				                        <div class="col-md-10">
				                            <div class="post-top">
				                                <div class="name">
				                                    <h4><a href="#"> Ryan Sheridan </a><small>Since 1990</small></h4>
				                                    <div class="time">
				                                        <p>
				                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 6 days ago <span>review</span>.
				                                        </p>
				                                    </div>
				                                </div>
				                                <div class="review-rating">
				                                    <div class="rating remarkable">
				                                        <span>5</span>
				                                    </div>
				                                    <div class="review">
				                                        <p>review<span>(10)</span></p>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="review-text">
				                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id distinctio doloribus nulla in magni saepe ipsa dolor ab, vero repudiandae porro et fugit nisi dolorum...</p>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            <?php */ ?>
			            </div>
			        </div>
			    </div>
			</div>

		</div>
	</div>
</section>

@endsection

@section('after-scripts-end')

    <!-- Load required JS libraries. -->
    {!! HTML::script('blueimp/load-image.all.min.js') !!}
    {!! HTML::script('blueimp/canvas-to-blob.js') !!}
    {!! HTML::script('blueimp/jquery.iframe-transport.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-process.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-image.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-validate.js') !!}

    {!! HTML::script('js/customUpload.js') !!}
    <script language="javascript">
    	print_country("country","{{ $user->country }}");
    	$("#state").append(new Option("{{ $user->state }}", "{{ $user->state }}"));
    </script>

  
@stop

@section('after-styles-end')
  {!! HTML::style('blueimp/css/jquery.fileupload.css') !!}
  {!! HTML::style('blueimp/css/jquery.fileupload-ui.css') !!}
  {!! HTML::script('js/countries.js') !!}
@stop