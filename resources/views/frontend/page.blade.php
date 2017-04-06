@extends('frontend.layouts.master')
@section('title'){{ $siteTitle }}@endsection
@section('content')
	<div style="margin-top:75px;">
	</div>
	<div class="row">
		<h2>{!! $page->title !!}</h2>
		<hr />
	</div>
	<div class="row">
		{!! $page->content !!}
	</div>
@stop