	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
	        <span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="{{url('')}}"><img src="{{ URL::asset($siteLogo) }}"></a>

	      <div class="language-select hidden-md visible-xs hidden-sm">
			<div class="form-group">
			@if(Auth::check())
			<div class="dropdown" id="dropdownMenu2">
	                <button class="btn btn-default" data-toggle="dropdown">
	                    <span id="dropdown_title2">{{Auth::user()->name}}</span>
	                    <span class="caret"></span>
	                </button>
	                <ul class="dropdown-menu" >
	                		 @role('Administrator')
							        <li>{!! link_to('admin/dashboard', trans('navs.administration'), ['style' =>'color:#000']) !!}</li>
							 @endauth
							 @role('Guide')
							 		<li><a href="{{ route('guide.earnings') }}">My Earnings</a></li>
							 		<li>{!! link_to('guide/profile/edit', trans('navs.my_profile'), ['style' =>'color:#000']) !!}</li>
							 	@permission('view-reviews-page')
							 		<li>{!! link_to('guide/reviews', trans('navs.my_reviews'), ['style' =>'color:#000']) !!}</li>
							 	@endauth
							        <li>{!! link_to('guide/profile/edit', trans('navs.edit_profile'), ['style' =>'color:#000']) !!}</li>
							        <li>{!! link_to('guide/settings', trans('navs.settings'), ['style' =>'color:#000']) !!}</li>
							 @endauth
							 @role('Traveller')
							 		<li><a href="{{ route('frontend.traveller.favotites') }}">My Favorites</a></li>
							        <li>{!! link_to('traveller/profile', trans('navs.my_profile'), ['style' =>'color:#000']) !!}</li>
							         <li>{!! link_to('traveller/activity', trans('navs.my_activity'), ['style' =>'color:#000']) !!}</li>
							        {{-- <li>{!! link_to('traveller/settings', trans('navs.settings'), ['style' =>'color:#000']) !!}</li> --}}
							 @endauth
							
						    
							<li>{!! link_to('auth/logout', trans('navs.logout'), ['style' =>'color:#000']) !!}</li>
	                   
	                </ul>
	        </div>
	        @else
	        <button class="btn btn-default" data-toggle="dropdown">
                <span id="dropdown_title2">login</span>
                <span class="caret"></span>
            </button>
	        @endif

	        </div>
	        </div>
	    </div>
	    
		<div class="language-select">
			<div class="form-group">
	            <div class="dropdown" id="dropdownMenu2">
	                <button class="btn btn-default" data-toggle="dropdown">
	                    <span id="dropdown_title2">{{ trans('menus.language-picker.language') }}</span>
	                    <span class="caret"></span>
	                </button>
	                <ul class="dropdown-menu" >
	                		<li>{!! link_to('lang/en', trans('menus.language-picker.langs.en')) !!}</li>
	                		<li>{!! link_to('lang/es', trans('menus.language-picker.langs.es')) !!}</li>
	                		<li>{!! link_to('lang/fr-FR', trans('menus.language-picker.langs.fr-FR')) !!}</li>
	                </ul>
	            </div>  
   	  		</div>
   		 </div>


	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="main-menu">
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="{{ URL::to('how-it-works') }}">How it works <span class="sr-only">(current)</span></a></li>
	        <li><a href="{{ URL::to('faqs') }}">FAQ</a></li>
	        @if (Auth::guest())
				<li><a href="#" data-toggle="modal" data-target="#login-popup">{!! trans('navs.login') !!}</a></li>
			@endif

	        @if (Auth::guest())
				<li><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#signup-modal">{!! trans('navs.register') !!}</a></li>
			@else
			<li>
			<div class="language-select hidden-sm hidden-xs">
			<div class="form-group">
			<div class="dropdown" id="dropdownMenu2">
	                <button class="btn btn-default" data-toggle="dropdown">
	                    <span id="dropdown_title2">{{ Auth::user()->name }}</span>
	                    <span class="caret"></span>
	                </button>
	                <ul class="dropdown-menu" >
	                		 @role('Administrator')
							        <li>{!! link_to('admin/dashboard', trans('navs.administration'), ['style' =>'color:#000']) !!}</li>
							 @endauth
							 @role('Guide')
							 		<li><a href="{{ route('guide.earnings') }}">My Earnings</a></li>
							 		<li>{!! link_to('guide/profile/edit', trans('navs.my_profile'), ['style' =>'color:#000']) !!}</li>
							 	@permission('view-reviews-page')
							 		<li>{!! link_to('guide/reviews', trans('navs.my_reviews'), ['style' =>'color:#000']) !!}</li>
							 	@endauth
							        <li>{!! link_to('guide/profile/edit', trans('navs.edit_profile'), ['style' =>'color:#000']) !!}</li>
							        <li>{!! link_to('guide/settings', trans('navs.settings'), ['style' =>'color:#000']) !!}</li>
							 @endauth
							 @role('Traveller')
							 		<li><a href="{{ route('frontend.traveller.favotites') }}">My Favorites</a></li>
							        <li>{!! link_to('traveller/profile', trans('navs.my_profile'), ['style' =>'color:#000']) !!}</li>
							         <li>{!! link_to('traveller/activity', trans('navs.my_activity'), ['style' =>'color:#000']) !!}</li>
							        {{-- <li>{!! link_to('traveller/settings', trans('navs.settings'), ['style' =>'color:#000']) !!}</li> --}}
							 @endauth
							
						    
							<li>{!! link_to('auth/logout', trans('navs.logout'), ['style' =>'color:#000']) !!}</li>
	                   
	                </ul>
	        </div>
	        </div>
	        </div>
	        </li>
			@endif
	      </ul>
	    </div><!-- /navbar-collapse -->
	  </div><!-- /container-fluid -->
	</nav>

