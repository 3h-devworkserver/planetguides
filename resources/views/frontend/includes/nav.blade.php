	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#"><img src="{{ URL::asset('images/logo-25.png') }}"></a>
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
	    <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-1 ">
	      <ul class="nav navbar-nav ">
	        <li class="active"><a href="#">How it works <span class="sr-only">(current)</span></a></li>
	        <li><a href="#">FAQ</a></li>
	      <!--   @if (Auth::guest())
				<li><a href="#" data-toggle="modal" data-target="#login-popup"><i class="fa fa-user"></i></span>{!! trans('navs.login') !!}</a></li>
			@endif -->

	        <li><a href="#"><i class="fa fa-shopping-cart"></i></span>Cart</a></li>
	       
	        @if (Auth::guest())
				<li><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#signup-modal">{!! trans('navs.register') !!}</a></li>
			@else
			<div class="language-select">
			<div class="form-group">
			<div class="dropdown" id="dropdownMenu2">
	                <button class="btn btn-default" data-toggle="dropdown">
	                    <span id="dropdown_title2">{{ Auth::user()->name }}</span>
	                    <span class="caret"></span>
	                </button>
	                <ul class="dropdown-menu" >
	                		<li>{!! link_to('dashboard', trans('navs.dashboard'), ['style' =>'color:#000']) !!}</li>
							<li>{!! link_to('auth/password/change', trans('navs.change_password'), ['style' =>'color:#000']) !!}</li>
						    
							<li>{!! link_to('auth/logout', trans('navs.logout'), ['style' =>'color:#000']) !!}</li>
	                   
	                </ul>
	        </div>
	        </div>
	        </div>
			@endif
	      </ul>
	    </div><!-- /navbar-collapse -->
	  </div><!-- /container-fluid -->
	</nav>