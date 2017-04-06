@extends('frontend.layouts.masterProfile')
@section('title') Profile | {{ $siteTitle }}@endsection

@section('content')
    <section class="banner profile-banner" style="background-image:url({{ asset($guide->user->bannerPic) }})">
        <div class="overlay"></div>
    <div class="search-container">
        <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-wrap">
                            @include('frontend.includes.searchbar')
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </section>


    <section class="guide-profile">
        <div class="container">
            <div class="row guide-wrapper">
                <div class="col-md-9">
                    <div class="guide-name">
                    @if ($guide->certified)
                        <div class="name pull-left">
                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Certified guide"><i class="fa fa-certificate"></i></button>
                            <h3 class="">{{$guide->user->fname}} {{$guide->user->lname}}</h3>
                        </div>
                    @endif
                        <div class="rating-review pull-right text-center">
                                <span class="rating remarkable">
                                    <span>{{$guide->rating_count}}</span>
                                </span>
                                <span>
                                    <a href="#reviews-anchor">Reviews</a>
                                </span>
                        </div>
                    </div> <!-- guide-name closing -->
                </div> <!-- col-md-12 closing -->
            </div> <!--row closing -->
            
            <!-- Include error message page -->
            @include('includes.partials.messages') 

            <div class="row">
                <div class="col-md-3">
                    <div class="traveller-rating">
                        <div class="title">
                            <h4>Guide Rating</h4>
                            <div class="rating-wrap">
                            @if($guide->rating_cache >= 4.5)
                                <div class="rating-type">
                                    <p>Excellent</p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                            
                                            </div>
                                        </div>

                                    <small class="pull-right">20</small>
                                </div>
                            @endif
                            @if($guide->rating_cache >= 3.5 && $guide->rating_cache < 4.5)
                                <div class="rating-type">
                                    <p>Very Good</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">10</small>
                                </div>
                            @endif
                            @if($guide->rating_cache >= 2.5 && $guide->rating_cache < 3.5)
                                <div class="rating-type">
                                    <p>Average</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">2</small>
                                </div>
                            @endif
                            @if($guide->rating_cache >= 1.5 && $guide->rating_cache < 2.5)
                                <div class="rating-type">
                                    <p>Poor</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">0</small>
                                </div>
                            @endif
                            @if($guide->rating_cache >= 0 && $guide->rating_cache <= 1)
                                <div class="rating-type">
                                    <p>Terrible</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                           
                                        </div>
                                    </div>
                                    <small class="pull-right">0</small>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="review-sm">
                        <div class="title">
                            <h4>Recent Reviews</h4>
                        </div>
                        <div class="reivew-wrap">
                        @foreach($recentreviews as $recentreview)
                            <div class="review-by">
                                <div class="figure" style="background-image:url({{ asset($recentreview->user->picture) }})">
                                </div>
                                <h5><a href="#">{{ $recentreview->user ? $recentreview->user->name : 'Anonymous'}}</a>
                                    <span>{{ $recentreview->review_count($recentreview->user->id,$guide->user_id) }} review</span>
                                </h5>
                                <a  class="review-text">
                                    <i class="fa fa-quote-left"></i>{{$recentreview->comment }} <i class="fa fa-quote-right"></i>
                                </a>
                            </div>
                        @endforeach
                            <div class="view-more">
                                <a href="#reviews-anchor">View all Review</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row profile-content">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-img">
                                        <a class="fancybox" href="{{ $guide->user->profilePic }}" data-fancybox-group="gallery" title="{{ $guide->user->name }}" style="background-image:url({{ $guide->user->profilePic }})"></a>
                                    </div>
                                </div>
                                <div class="col-md-8 guide-detail">
                                    <!--<div class="guide-detail">-->
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Tour ID :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <p>{{$guide->gid}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Experience :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <p>{{ $guide->user->experience }} 
                                                @if($guide->user->experience<'2')
                                                Year
                                                @else
                                                Years
                                                @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Gender :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <p>{{$guide->user->gender}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Main Guiding Area :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <p>{{$guide->user->profile->mGuidingArea}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Other Guiding Area :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <p>{{$guide->user->profile->oGuidingArea}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Language :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <p>{{$guide->user->profile->language}}</p>
                                            </div>
                                        </div>
                                        

                                </div>
                            </div>
                        </div>
                         @if ($guide->certified)
                        @include ('frontend.guide.bookModal')
                        @endif
                    </div>

                    <div class="about-me">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>About Me</strong>
                            </div>
                            <div class="col-md-9">
                                <p><span>{{$guide->user->profile->about}}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="certificate">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Professional License/Certificate</strong>
                            </div>
                            <div class="col-md-9">
                                <div class="certificate-img">
                                <div class="row"> 
                                     @foreach ($guide->user->License as  $gallery)
                                        <div class="col-md-3">
                                            <a class="fancybox" href="{{ asset($gallery->path) }}" data-fancybox-group="gallery" title="License" style="background-image:url({{ asset($gallery->path) }})"></a>
                                        </div>
                                    @endforeach
                               </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="video">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Videos</strong>
                            </div>
                            <div class="col-md-9">
                                <div class="video-gallery row">
                                
                                 @foreach ($guide->user->limitvideos as  $videos)
                                    <div class="col-md-3">
                                     <a style="background-image:url({{ asset('images/1.jpg') }})" data-fancybox-group="gallery" href="{{ $videos->path }}?fs=1&amp;autoplay=1" class="video">
                                     </a>
                                     </div>
                                @endforeach
                                </div>
                                @if (Auth::guest())
                                     <a href="{{ route('frontend.guide.user.video',$guide->user->username) }}"class="btn btn-primary pull-right cust-btn-sm">view more</a>
                                 @else
                                    <a href="{{ route('frontend.guide.video') }}"class="btn btn-primary pull-right cust-btn-sm">view more</a>
                                @endif
                               </div>
                        </div>
                    </div>

                    <div class="gallery">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Gallery</strong>
                            </div>
                            <div class="col-md-9">
                                <div class="img-gallery row">
                                 @foreach ($guide->user->limitimages as  $images)
                                 <div class="col-md-3">
                                    <a class="fancybox" href="{{ asset( $images->path ) }}" data-fancybox-group="gallery" title="{{ $images->caption }} " style="background-image:url({{ asset( $images->path ) }})"></a>
                                    </div>
                                @endforeach
                                </div>
                                 @if (Auth::guest())
                                     <a href="{{ route('frontend.guide.user.gallery',$guide->user->username) }}"class="btn btn-primary pull-right cust-btn-sm">view more</a>
                                 @else
                                    <a href="{{ route('frontend.guide.gallery') }}"class="btn btn-primary pull-right cust-btn-sm">view more</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @include('frontend.guide.review')
            
                </div>
            </div>


        </div>
    </section>

@endsection
@section('after-styles-end')
    {!! HTML::style('datepicker/css/bootstrap-datepicker.css') !!}

    <style type="text/css">
         /* Enhance the look of the textarea expanding animation */
         .animated {
            -webkit-transition: height 0.2s;
            -moz-transition: height 0.2s;
            transition: height 0.2s;
          }
          .stars {
            margin: 20px 0;
            font-size: 24px;
            color: #d17581;
          }
     </style>
@endsection

@section('after-scripts-end')

<script>
    $(document).ready(function() {
        $(document).on('click', '#loadmore-review', function (e) {
            e.preventDefault();
            $('#loadmore-pagination #loadmore-loader').show();
            $('#loadmore-pagination #loadmore-review').hide();
            $.ajax({
                type:'GET',
                url : $(this).attr('href'),
                }).done(function (data) {
                    $('#loadmore-pagination').remove();
                    $('#loadmore-pagination #loadmore-loader').hide();
                    $('#loadmore-pagination #loadmore-review').show();
                    $('.review-list #reviews-listing').append(data.html);
                })
            });
        });

</script>
    {!! HTML::script('js/customCalendar.js') !!}
    {!! HTML::script('js/expanding.js') !!}
    {!! HTML::script('js/starrr.js') !!}

  <script type="text/javascript">
    $(function(){
      // initialize the autosize plugin on the review text area
      $('#new-review').autosize({append: "\n"});
      var reviewBox = $('#post-review-box');
      var newReview = $('#new-review');
      var openReviewBtn = $('#open-review-box');
      var closeReviewBtn = $('#close-review-box');
      var ratingsField = $('#ratings-hidden');
      openReviewBtn.click(function(e)
      {
        reviewBox.slideDown(400, function()
          {
            $('#new-review').trigger('autosize.resize');
            newReview.focus();
          });
        openReviewBtn.fadeOut(100);
        closeReviewBtn.show();
      });
      closeReviewBtn.click(function(e)
      {
        e.preventDefault();
        reviewBox.slideUp(300, function()
          {
            newReview.focus();
            openReviewBtn.fadeIn(200);
          });
        closeReviewBtn.hide();
        
      });
      // If there were validation errors we need to open the comment form programmatically 
      @if($errors->first('comment') || $errors->first('rating'))
        openReviewBtn.click();
      @endif
      // Bind the change event for the star rating - store the rating value in a hidden field
      $('.starrr').on('starrr:change', function(e, value){
        ratingsField.val(value);
      });
    });
  </script>

{!! HTML::script('datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('datepicker/js/foundation-datepicker.js') !!}

@endsection