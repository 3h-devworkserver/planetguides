@extends('frontend.layouts.masterProfile')
@section('Reviews Edit') Unapproved Reviews | {{ $siteTitle }}@endsection

@section('content')
    <section class="profile-banner" style="background-image:url({{ asset($guide->user->bannerPic) }})">
        <div class="overlay"></div>
    </section>
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
    <section class="guide-review">
        <div class="container">
            <div class="row guide-wrapper">
                <div class="col-md-9">
                    <div class="guide-name">
                    @if ($guide->user->certified)
                        <div class="name pull-left">
                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Certified guide"><i class="fa fa-certificate"></i></button>
                            <h3 class="">{{$guide->user->fname}} {{$guide->user->lname}}</h3>
                        </div>
                    @endif
                        <div class="rating-review pull-right text-center">
                                <span class="rating remarkable" data-toggle="tooltip" date-placement="top" title="Remarkable">
                                    <span>{{$guide->rating_count}}</span>
                                </span>
                                <span>
                                    <a href="#reviews-anchor">Reviews</a>
                                </span>
                        </div>
                    </div> <!-- guide-name closing -->
                </div> <!-- col-md-12 closing -->
            </div> <!--row closing -->



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
                </div>
                <div class="col-md-9">
                @include('includes.partials.messages')
                    <div class="row profile-content">
                        <div class="col-md-8">
                            <div class="row">
                                {!! $table !!}
                            </div>
                        </div>
                        
                    </div>

                    
                </div>
            </div>


        </div>
    </section>

@endsection

@section('after-styles-end')
    {!! HTML::style('css/jquery.dataTables.min.css') !!}
@stop
