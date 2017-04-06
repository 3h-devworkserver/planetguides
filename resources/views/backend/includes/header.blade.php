          <!-- Main Header -->
          <header class="main-header">

             <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>G</b>NP</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b>Panel</span>
        </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
              </a>
              <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ trans('menus.language-picker.language') }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li>{!! link_to('lang/en', trans('menus.language-picker.langs.en')) !!}</li>
          					  <li>{!! link_to('lang/es', trans('menus.language-picker.langs.es')) !!}</li>
          					  <li>{!! link_to('lang/fr-FR', trans('menus.language-picker.langs.fr-FR')) !!}</li>
                     
                    </ul>
                  </li>
                  

                
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="{!! access()->user()->picture !!}" class="user-image" alt="User Image"/>
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs">{{ access()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                        <img src="{!! asset(access()->user()->profilepic) !!}" class="img-circle" alt="User Image" />
                        {{-- <img src="{{access()->user()->profile->profileImg}}" class="img-circle" alt="User Image" /> --}}
                        <p>
                          {{ access()->user()->name }} - {{ trans('roles.web_developer') }}
                          <small>{{ trans('strings.member_since') }} {{ access()->user()->created_at }}</small>
                        </p>
                      </li>
                    
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="{{ route('admin.access.users.edit', access()->user()->id) }}" class="btn btn-default btn-flat">{{ trans('navs.my_profile') }}</a>
                        </div>
                        <div class="pull-right">
                          <a href="{!!url('auth/logout')!!}" class="btn btn-default btn-flat">{{ trans('navs.logout') }}</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
          </header>
