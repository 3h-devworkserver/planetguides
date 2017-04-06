<?php
use App\Models\Profile;
use App\Models\Guide;
?>
@extends('frontend.layouts.master')
@section('title') Search Results | {{ $siteTitle }}@endsection

@section('banner')
	<section class="banner">
	<div class="search-wrap">
      	<div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('frontend.includes.searchbar')
         		</div>
        	</div>
      	</div>
    </div>
    </section>
@endsection


@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h2 class="text-center">
					@if ($count == 1)
						{{ $count }} Guide
					@else
						{{ $count }} Guides
					@endif
				</h2>
			</div>
		</div>
	</div>
	<div class="guides">
		<div class="row">
		@if (!$guides)
			<h1 style="text-align: center;color:#E74C3C;">Sorry, no results found.</h1>
		@endif
		@foreach($guides as $guide)
			<div class="col-sm-6 col-md-3">
				<div class="thumbnail">
					<a href="{{URL::to('guide/'.$guide->username)}}">
					@if(!empty(Profile::where('user_id', $guide->id)->first()->profileImg))
						<div style="background-image:url({{ asset(Profile::where('user_id', $guide->id)->first()->profileImg) }})"></div>
					@elseif(!empty(Profile::where('user_id', $guide->id)->first()->avatar))
						<div style="background-image:url({{ asset(Profile::where('user_id', $guide->id)->first()->avatar) }})"></div>
					@else
						<div style="background-image:url({{ asset('/images/avatar.png') }})"></div>
					@endif
					</a>
					<div class="caption">
						<h3><a>{{$guide->fname}} {{$guide->lname}}</a></h3>
						<div class="experience pull-left">
						Experience : Since <?php foreach($profiles as $p){ if($p->user_id == $guide->id){ echo $p->experience;}} ?>

							<!-- Experience : <?php// $time = Carbon\Carbon::now()->format('Y'); 
											//$time = Carbon\Carbon::parse($time);
						 	//foreach($profiles as $p){ if($p->user_id == $guide->id){ $dbdate = Carbon\Carbon::parse($p->//experience);
							//echo $dbdate->diffInYears($time);}} ?> Years -->
						</div>
						<div class="rating pull-right">
							Rating : {{ Guide::where('user_id', $guide->id)->first()->rating_cache }} of 5.0
						</div>
					</div>
				</div>
			</div>
@endforeach

				</div>
			</div>
		</div>
		
	</div>
@stop