<?php
use App\Models\Access\User\User;
?>
@extends('frontend.layouts.masterProfile')
@section('title') Favorite Guides | {{ $siteTitle }}@endsection
@section('content')	
	<section class="dashboard">
		@include('frontend.traveller.includes.navbar')
		<div class="container">
				<div class="row">
					@if (Session::has('message'))
						<div class="col-md-6 col-md-offset-3 alert alert-info">
							{{ Session::get('message') }}
						</div>
					@endif
					<div class="col-md-3">
						@include('frontend.traveller.includes.sidebar')
					</div>
					<div class="col-md-9">
						<div class="recentactives">
							<h1 class="content-title">My Favorite Guides</h1>
						
						@foreach ($favorites as $favorite)
							<div class="post">
								<div class="row">
									<div class="col-md-10">
										<div class="user">
											<a href="{{ URL::to('guide/'.User::find($favorite->guide_id)->username) }}" style="background-image:url({{ User::find($favorite->guide_id)->picture }})"></a>
											<div class="name" style="padding-top: 2px;">
												<h4 style="line-height: 18px;">{{ ucwords(User::find($favorite->guide_id)->name) }}</h4>
												<a class="btn btn-danger btn-block" style="width:200px;height: 35px;margin-top:10px;" href="{{ route('frontend.traveller.delete.favorites', $favorite->guide_id) }}">
	                                                 <i class="fa fa-heart"></i> Remove Favorite
	                                            </a>
											</div>

										</div>
									</div>
								</div>
							</div>
						@endforeach
						</div>
					</div>
				</div>
		</div>
	</section>
@endsection

