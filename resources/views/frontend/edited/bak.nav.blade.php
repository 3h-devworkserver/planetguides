	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Brand</a>
	    </div>
		<div class="language-select">
			<div class="form-group">
	            <div class="dropdown" id="dropdownMenu2">
	                <button class="btn btn-default"
	                        data-toggle="dropdown">
	                    <span id="dropdown_title2">English</span>
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
	        <li><a href="#"><i class="fa fa-shopping-cart"></i>Cart</a></li>
	       	@if (Auth::guest())
						<li>{!! link_to('auth/login', trans('navs.login')) !!}</li>
						<li>{!! link_to('auth/register', trans('navs.register')) !!}</li>
			@else
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					    <li>{!! link_to('dashboard', trans('navs.dashboard')) !!}</li>
					    <li>{!! link_to('auth/password/change', trans('navs.change_password')) !!}</li>

					    @permission('view-backend')
					        <li>{!! link_to_route('backend.dashboard', trans('navs.administration')) !!}</li>
					    @endauth

						<li>{!! link_to('auth/logout', trans('navs.logout')) !!}</li>
					</ul>
				</li>
			@endif
	      </ul>
	    </div><!-- /navbar-collapse -->
	  </div><!-- /container-fluid -->
	</nav>