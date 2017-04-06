@extends('frontend.layouts.masterProfile')
@section('title') Profile | {{ $siteTitle }}@endsection

@section('content')
<script type="text/javascript">
    
     var unavailableDates = "{{$availibility}}";
     var guidePrice       = '{{$guide->price}}';
     var serviceFeePercentage = '{{Session::get('serviceFee')}}';
     
    var countDays = 0;
    // var unavailableDates = "9/9/2016,14/9/2016,15/10/2016"
     
     if (unavailableDates != '') {
          var unavailableDates = unavailableDates.split(",");
      }
      
     
        
    //alert(unavailableDates);
    //var unavailableDates = ["9/9/2016", "14/9/2016", "15/10/2016"];
    function unavailable(date) {
        dmy = (date.getMonth() + 1) + "/" + date.getDate() + "/" +  date.getFullYear();
        if ($.inArray(dmy, unavailableDates) == -1) {
            return [false, "", "Unavailable"];
            
        } else {
            return [true, ""];
        }
    }
    
    $(function() {
        
        //$('#disable-dates').multiDatesPicker('value', '<?php //echo $_GET['dates']?>');
        var paymentStatus = '{{$paymentStatus}}';
        
        if(paymentStatus){
            $('.alert').hide();
            $('#PaymentSuccessful').show();
            
            
        }
        
                    $('#disable-dates').multiDatesPicker({
                        minDate: 0,

                        beforeShowDay: unavailable,
                        onSelect: function(dateText, inst) {
                        var dates = $('#disable-dates').multiDatesPicker('getDates');

                        var countDays = dates.length;
                        
                        $('#dates').val(dates); //array
                        $('#date_count').val(countDays);
                        
                        if (countDays > 0) {
                                    $('.book-it-status').show(); 
                                    $('#priceCalculation').html('$' + guidePrice + 'X '+ countDays + 'days');
                                    var totalPrice = (guidePrice * countDays).toFixed(2);
                                    $('#calculatedPrice').html('$' + totalPrice);
                                    
                                    serviceFee = ((totalPrice * serviceFeePercentage)/100).toFixed(2);
                                    $('#serviceFee').html('$' + serviceFee);
                                    
                                    var total = (parseFloat(totalPrice) + parseFloat(serviceFee)).toFixed(2);
                                    
                                    $('#totalSumPrice').html('$' + total);
                                    
                                    
                                }else{
                                    $('.book-it-status').hide(); 
                                    
                                }
                    }

                    });
      
        $('.demo .code').each(function() {
          eval($(this).attr('title','NEW: edit this code and test it!').text());
        });
        
        $(document).on('submit', '#bookingFormId', function(event) {
            var dates = $('#disable-dates').multiDatesPicker('getDates');
            var countDays = dates.length;
            if(countDays == 0){
                
                alert('Please select dates to book from the calendar');
                return false;
            }
        });
        
        
      });
</script>
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
                <div class="col-md-9 col-sm-9">
                    <div class="guide-name">
                        <div class="name pull-left">
                            @if ($guide->certified)
                                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Certified guide"><i class="fa fa-certificate"></i></button>
                            @endif
                            <h3 class="">{{$guide->user->fname}} {{$guide->user->lname}}</h3>
                        </div>
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
            
            <div class="alert alert-success" id="PaymentSuccessful" style="display:none;">
                    Your Payment is successful 
            </div>
            
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="traveller-rating">
                        <div class="title title_rating">
                            <h4>Guide Rating</h4>
                             @if($guide->rating_cache >= 4.5)
                             <div class="rating-review text-center">
                                <span class="rating Excellent" data-toggle="tooltip" data-placement="top" title="Excellent">
                                    <span>{{$guide->rating_count}}</span>
                                </span>
                        </div>
                        @endif
                        @if($guide->rating_cache >= 3.5 && $guide->rating_cache < 4.5)
                        <div class="rating-review text-center">
                                <span class="rating Very-Good" data-toggle="tooltip" data-placement="top" title="Very Good">
                                    <span>{{$guide->rating_count}}</span>
                                </span>
                        </div>
                        @endif
                        @if($guide->rating_cache >= 2.5 && $guide->rating_cache < 3.5)
                         <div class="rating-review text-center">
                                <span class="rating Poor" data-toggle="tooltip" data-placement="top" title="Poor">
                                    <span>{{$guide->rating_count}}</span>
                                </span>
                        </div>
                        @endif
                        @if($guide->rating_cache >= 0 && $guide->rating_cache <= 1)
                        <div class="rating-review text-center">
                                <span class="rating no-rating" data-toggle="tooltip" data-placement="top" title="No Ratings">
                                    <span>{{$guide->rating_count}}</span>
                                </span>
                        </div>
                        @endif

                            <!-- <div class="rating-wrap"> -->
                            @if($guide->rating_cache >= 4.5)
                              <!--   <div class="rating-type">
                                    <p>Excellent</p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                            
                                            </div>
                                        </div>

                                    <small class="pull-right">20</small>
                                </div> -->
                            @endif
                            @if($guide->rating_cache >= 3.5 && $guide->rating_cache < 4.5)
                                <!-- <div class="rating-type">
                                    <p>Very Good</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">10</small>
                                </div> -->
                            @endif
                            @if($guide->rating_cache >= 2.5 && $guide->rating_cache < 3.5)
                                <!-- <div class="rating-type">
                                    <p>Average</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">2</small>
                                </div> -->
                            @endif
                            @if($guide->rating_cache >= 1.5 && $guide->rating_cache < 2.5)
                                <!-- <div class="rating-type">
                                    <p>Poor</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">0</small>
                                </div> -->
                            @endif
                            @if($guide->rating_cache >= 0 && $guide->rating_cache <= 1)
                                <!-- <div class="rating-type">
                                    <p>No Ratings </p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                           
                                        </div>
                                    </div>
                                    <small class="pull-right">0</small>
                                </div> -->
                            @endif
                            <!-- </div> -->
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
                <div class="col-md-9 col-sm-8">
                    <div class="row profile-content">
                        <div class="col-md-8 col-sm-12">
                            <div class="row res-half-grid">
                                <div class="col-md-4 col-sm-6">
                                    <div class="profile-img">
                                        <a class="fancybox bg-wrap  " href="{{ $guide->user->profilePic }}" data-fancybox-group="gallery" title="{{ $guide->user->name }}" style="background-image:url({{ $guide->user->profilePic }})"></a>
                                    </div>
                                    @if (Auth::user())
                                        @if ($has_favorited)
                                        <div class="favorite favorite-click">
                                            <a class="btn btn-danger" href="{{ route('frontend.traveller.delete.favorites', $guide->user->id) }}">
                                                 <i class="fa fa-heart"></i> <span>Remove Favorite</span>
                                            </a>
                                        </div>
                                        @else
                                        <div class="favorite">
                                            <a class="btn btn-danger" href="{{ route('frontend.traveller.add.favorites', $guide->user->id) }}">
                                                <i class="fa fa-heart-o"></i> <span>Add Favorite</span>
                                            </a>
                                        </div>
                                        @endif
                                    @endif
                                </div>

                                <div class="col-md-8 guide-detail col-sm-12">
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
                                                <p>Since  {{ $guide->user->experience }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Gender :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                
                                                @if ($guide->user->gender == 0)
                                                   <p>Male</p>
                                                @elseif ($guide->user->gender == 1)
                                                    <p>Female</p>
                                                @else
                                                    <p>OtherO</p>
                                                @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Main Guiding Area :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                 <p>
                                                    <?php 
                                                    $i=0; 
                                                    $selectedoarea = explode(',', $guide->user->profile->mGuidingArea);
                                                    ?>
                                                    @foreach($selectedoarea as $p)
                                                        @if($i == 0)
                                                        <?php echo DB::table('guideareas')->where('id', $p)->value('guide_area'); $i++;?>
                                                        @else
                                                        <?php echo ", ".DB::table('guideareas')->where('id', $p)->value('guide_area'); $i++;?>
                                                        @endif
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Other Guiding Area :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <p>
                                                    <?php 
                                                    $i=0; 
                                                    $selectedoarea = explode(',', $guide->user->profile->oGuidingArea);
                                                    ?>
                                            @foreach($selectedoarea as $p)
                                                @if($i == 0)
                                                <?php echo DB::table('guideareas')->where('id', $p)->value('guide_area'); $i++;?>
                                                @else
                                                <?php echo ", ".DB::table('guideareas')->where('id', $p)->value('guide_area'); $i++;?>
                                                @endif
                                            @endforeach
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Language :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                            <p>
                                            <?php $i=0; $selectedlang = explode(',',$guide->user->profile->language); ?>
                                            @foreach($selectedlang as $lang)
                                                @if($i == 0)
                                                <?php echo DB::table('languages')->where('id', $lang)->value('language'); $i++;?>
                                                @else
                                                <?php echo ", ".DB::table('languages')->where('id', $lang)->value('language'); $i++;?>
                                                @endif
                                            @endforeach
                                            </p>
                                            </div>
                                        </div>
                                        @if (!$guide->user->profile->specilizedarea)
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                <span>Specialized Skill/Location :</span>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <p>{{$guide->user->profile->specilizedarea}}</p>
                                            </div>
                                        </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                         @if ($guide->certified)
                          @include ('frontend.guide.bookModal')
                        @endif
                    </div>

                    <div class="about-me">
                        <div class="row">
                            <div class="col-md-3 section-title col-sm-12">
                                <strong>About Me</strong>
                            </div>
                            <div class="col-md-9">
                                <p><span>{{$guide->user->profile->about}}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="certificate">
                        <div class="row">
                            <div class="col-md-3 section-title col-sm-12">
                                <strong>Professional License/Certificate</strong>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <div class="certificate-img">
                                <div class="row"> 
                                     @foreach ($guide->user->License as  $gallery)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="thumb-wrap">
                                            <a class="fancybox bg-wrap" href="{{ asset($gallery->path) }}" data-fancybox-group="gallery" title="License" style="background-image:url({{ asset($gallery->path) }})"></a>
                                            </div>
                                        </div>
                                    @endforeach
                               </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="video">
                        <div class="row">
                            <div class="col-md-3 section-title col-sm-12">
                                <strong>Videos</strong>
                            </div>
                            <div class="col-md-9 co-sm-12">
                                <div class="video-gallery row">
                                
                                 @foreach ($guide->user->limitvideos as  $videos)
                                    <div class="col-md-4 col-sm-6">
                                        <div class="thumb-wrap">
                                     <a style="background-image:url({{ asset('images/1.jpg') }})" data-fancybox-group="gallery" href="{{ $videos->path }}?fs=1&amp;autoplay=1" class="video bg-wrap fancybox">
                                     </a>
                                     </div>
                                     </div>
                                @endforeach
                                </div>
                                    <button data-toggle="modal" data-target="#myModal" class="btn btn-primary-o pull-right">View All</button>
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                          </div>
                                          <div class="modal-body">

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                               </div>
                        </div>
                    </div>

                    <div class="gallery">
                        <div class="row">
                            <div class="col-md-3 section-title col-sm-12">
                                <strong>Gallery</strong>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <div class="img-gallery row">
                                 @foreach ($guide->user->limitimages as  $images)
                                 <div class="col-md-4 col-sm-6">
                                    <div class="thumb-wrap">
                                        <a class="fancybox bg-wrap" href="{{ asset( $images->path ) }}" data-fancybox-group="gallery" title="{{ $images->caption }} " style="background-image:url({{ asset( $images->path ) }})"></a>
                                    </div>
                                    </div>
                                @endforeach
                                </div>
                                 <button data-toggle="modal" data-target="#myModal2" class="btn btn-primary-o pull-right">View All</button>
                                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                          </div>
                                          <div class="modal-body">
                                          <div class="video-gallery row">
                                            @foreach ($imagesx as $image)                                                
                                                                     <div class="col-md-4 col-sm-6">
                                        <div class="thumb-wrap">
                                     <a style="background-image:url({{ $image->path }})" data-fancybox-group="gallery" href="{{ $image->path }}" class="image bg-wrap fancybox">
                                     </a>
                                     </div>
                                     </div>
                                                                
                                            @endforeach
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
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
@endsection
