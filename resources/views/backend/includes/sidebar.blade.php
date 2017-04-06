          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              <!-- Sidebar user panel (optional) -->
              <div class="user-panel">
                <div class="pull-left image">
                  <img src="{!! access()->user()->picture !!}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                  <p>{{ access()->user()->name }}</p>
                  <!-- Status -->
                  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
              </div>

              

              <!-- Sidebar Menu -->
              <ul class="sidebar-menu">
                <li class="header">{{ trans('menus.main_navigation') }}</li>
                @permission('view-page-management')
                <li class="{{ Active::pattern('admin/pages*') }} treeview">
                  <a href="#">
                    <i class="fa fa-files-o"></i><span>{{ trans('menus.pages.pages') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/pages*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/pages*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/pages/create') }}">
                      <a href="{!! url('admin/pages/create') !!}"><i class="fa fa-plus"></i> {{ trans('menus.pages.new') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/pages ') }}">
                      <a href="{!! url('admin/pages') !!}"><i class="fa fa-file-text-o"></i> {{ trans('menus.pages.all') }}</a>
                    </li>
                  </ul>
                </li>
                @endauth


                @permission('view-access-management')
                   <li class="{{ Active::pattern('admin/access/users/*') }} treeview">
                      <a href="#">
                        <i class="fa fa-users"></i><span>{{ trans('menus.user_management') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu {{ Active::pattern('admin/access/users/*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/access/users/*', 'display: block;') }}">
                        <li class="{{ Active::pattern('admin/access/users/guide') }}">
                          <a href="{!! url('admin/access/users/guide') !!}"><i class="fa fa-user"></i> {{ trans('menus.guide_management') }}</a>
                        </li>
                        <li class="{{ Active::pattern('admin/access/users/traveller') }}">
                          <a href="{!! url('admin/access/users/traveller') !!}"><i class="fa fa-user"></i> {{ trans('menus.traveller_management') }}</a>
                        </li>
                      </ul>
                  </li>
                 
                @endauth


                @permission('view-reviews-management')
                   <li class="{{ Active::pattern('admin/reviews/*') }} treeview">
                      <a href="#">
                        <i class="fa fa-comments-o"></i><span>{{ trans('menus.review_management') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu {{ Active::pattern('admin/reviews/*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/reviews/*', 'display: block;') }}">
                        <li class="{{ Active::pattern('admin/reviews/unapproved') }}">
                          <a href="{!! url('admin/reviews/unapproved') !!}"><i class="fa fa-comment-o"></i> {{ trans('menus.unapproved_review') }}</a>
                        </li>
                        <li class="{{ Active::pattern('admin/reviews/all') }}">
                          <a href="{!! url('admin/reviews/all') !!}"><i class="fa fa-comments-o"></i> {{ trans('menus.all_review') }}</a>
                        </li>
                      </ul>
                  </li>
                 
                @endauth

                @permission('view-access-management')
                  <!--  <li class="{{ Active::pattern('admin/access/roles/*') }} treeview">
                      <a href="#">
                        <i class="fa fa-users"></i><span>{{ trans('menus.roles_permission') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu {{ Active::pattern('admin/access/roles/*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/access/roles/*', 'display: block;') }}">
                        <li class="{{ Active::pattern('admin/access/roles/create') }}">
                          <a href="{!! url('admin/access/roles/create') !!}"><i class="fa fa-user-secret"></i> {{ trans('menus.create_role') }}</a>
                        </li>
                        <li class="{{ Active::pattern('admin/access/roles') }}">
                          <a href="{!! url('admin/access/roles') !!}"><i class="fa fa-user-secret"></i> {{ trans('menus.header_buttons.roles.all') }}</a>
                        </li>
                        <li class="{{ Active::pattern('admin/access/roles/permissions/create') }}">
                          <a href="{!! url('admin/access/roles/permissions/create') !!}"><i class="fa fa-user-secret"></i> {{ trans('menus.create_permission') }}</a>
                        </li>
                        <li class="{{ Active::pattern('admin/access/roles/permissions') }}">
                          <a href="{!! url('admin/access/roles/permissions') !!}"><i class="fa fa-user-secret"></i> {{ trans('menus.header_buttons.permissions.all') }}</a>
                        </li>
                      </ul>
                  </li>
                  -->
                @endauth


                 <li class="{{ Active::pattern('admin/log-viewer*') }} treeview">
                  <a href="#">
                    <i class="fa fa-archive"></i><span>{{ trans('menus.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/log-viewer*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/log-viewer*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/log-viewer') }}">
                      <a href="{!! url('admin/log-viewer') !!}"><i class="fa fa-dashboard"></i> {{ trans('menus.log-viewer.dashboard') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/log-viewer/logs') }}">
                      <a href="{!! url('admin/log-viewer/logs') !!}"><i class="fa fa-search"></i> {{ trans('menus.log-viewer.logs') }}</a>
                    </li>
                  </ul>
                </li>

                 <li class="{{ Active::pattern('admin/service/charge') }}"><a href="{!!route('backend.service.charge')!!}"><i class="fa fa-money"></i><span>{{ trans('menus.service_charge') }}</span></a></li>

                 <li class="{{ Active::pattern('admin/license') }}"><a href="{!! route('backend.license.all') !!}"><i class="fa fa-credit-card"></i><span>{{ trans('menus.license') }}</span></a></li>

              @permission('view-booking-management')
                <li class="{{ Active::pattern('admin/bookings*') }} treeview">
                  <a href="#">
                    <i class="fa fa-shopping-bag"></i><span>{{ trans('menus.booking_management') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/bookings*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/bookings*', 'display: block;') }}">
                    {{-- <li class="{{ Active::pattern('admin/bookings/unapproved') }}">
                      <a href="{!! url('admin/bookings/unapproved') !!}"><i class="fa fa-shopping-bag"></i> {{ trans('menus.bookings.unapproved') }}</a>
                    </li> --}}
                    <li class="{{ Active::pattern('admin/bookings/approved ') }}">
                      <a href="{!! url('admin/bookings/approved') !!}"><i class="fa fa-shopping-bag"></i> {{ trans('menus.bookings.approved') }}</a>
                    </li>
                  </ul>
                </li>
              @endauth
              <!-- Sidebar Menu -->
                @permission('view-slider-management')
                <li class="{{ Active::pattern('admin/slides*') }} treeview">
                  <a href="#">
                    <i class="fa fa-file-image-o"></i><span>{{ trans('menus.slides.slide') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/slides*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/slides*', 'display: block;') }}">
                    <!-- <li class="{{ Active::pattern('admin/slides/create') }}">
                      <a href="{!! url('admin/slides/create') !!}"><i class="fa fa-plus"></i> {{ trans('menus.slides.new') }}</a>
                    </li> -->
                    <li class="{{ Active::pattern('admin/slides ') }}">
                      <a href="{!! url('admin/slides/management') !!}"><i class="fa fa-file-text-o"></i> {{ trans('menus.slides.Manages') }}</a>
                    </li>
                    <!-- <li class="{{ Active::pattern('admin/slides ') }}">
                      <a href="{!! url('admin/slides/settings') !!}"><i class="fa fa-cogs"></i> {{ trans('menus.slides.setting') }}</a>
                    </li> -->
                  </ul>
                </li>
                @endauth

                <li>
                    <a href="{!! url('admin/miscellaneous/commission') !!}"><i class="glyphicon glyphicon-usd"></i>My Commission</a>
                </li>

                <!-- setting Menu -->
                @permission('view-setting-management')
                <li class="{{ Active::pattern('admin/settings*') }} treeview">
                  <a href="#">
                    <i class="fa fa-cogs"></i><span>{{ trans('menus.settings') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/settings*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/settings*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/settings') }}">
                      <a href="{!! url('admin/settings') !!}"><i class="fa fa-cog"></i>{{ trans('menus.general_settings') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/settings/reset-email') }}">
                      <a href="{!! url('admin/settings/reset-email') !!}"><i class="fa fa-envelope-o"></i> {{ trans('menus.reset_email_settings') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/settings/confirm-email') }}">
                      <a href="{!! url('admin/settings/confirm-email') !!}"><i class="fa fa-envelope-o"></i> {{ trans('menus.confirm_email_settings') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/settings/success-email') }}">
                      <a href="{!! url('admin/settings/success-email') !!}"><i class="fa fa-envelope-o"></i> {{ trans('menus.success_email_settings') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/settings/notify-email') }}">
                      <a href="{!! url('admin/settings/notify-email') !!}"><i class="fa fa-envelope-o"></i> {{ trans('menus.notify_email_settings') }}</a>
                    </li>
                  </ul>
                </li>
                @endauth

                @permission('view-contactemail-management')
                <li class="{{ Active::pattern('admin/contactemail*') }} treeview">
                  <a href="{{url('admin/contactemail')}}">
                    <i class="fa fa-envelope"></i><span>{{ trans('Contact Email') }}</span>
                  </a>
                </li>
                @endauth


                @permission('view-Permission-management')
                <li class="{{ Active::pattern('admin/permission*') }} treeview">
                  <a href="#">
                    <i class="glyphicon glyphicon-ok-sign"></i><span>{{ trans('menus.permission.permission') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/permission*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/permission*', 'display: block;') }}">
                  <li class="{{ Active::pattern('admin/permission/user ') }}">{!! link_to_route('admin.access.users.index', trans('menus.permission.user')) !!}</li>

                  <li class="{{ Active::pattern('admin/permission/roles ') }}">{!! link_to_route('admin.access.roles.index', trans('menus.permission.role')) !!}</li>
                   
                  </ul>
                </li>
                
                @endauth

                @permission('view-mainguidearea-management')
                <li class="{{ Active::pattern('admin/miscellaneous*') }} treeview">
                  <a href="#">
                    <i class="glyphicon glyphicon-random"></i><span>{{ trans('menus.guidearea.permission') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/miscellaneous*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/miscellaneous*', 'display: block;') }}">
                  <!-- <li class="{{ Active::pattern('admin/miscellaneous/addguide') }}">
                      <a href="{!! url('admin/miscellaneous/addguide') !!}"><i class="glyphicon glyphicon-map-marker"></i> {{ trans('menus.guidearea.add') }}</a>
                  </li> -->

                  <li class="{{ Active::pattern('admin/miscellaneous/guidAreaemanagement') }}">
                      <a href="{!! url('admin/miscellaneous/guidAreaemanagement') !!}"><i class="glyphicon glyphicon-th-list"></i> {{ trans('menus.guidearea.manage') }}</a>
                  </li>

                  <!-- <li class="{{ Active::pattern('admin/miscellaneous/addlanguage') }}">
                      <a href="{!! url('admin/miscellaneous/addlanguage') !!}"><i class="glyphicon glyphicon-volume-up"></i> {{ trans('menus.guidearea.language_add') }}</a>
                  </li> -->

                  <li class="{{ Active::pattern('admin/miscellaneous/languagemgmt') }}">
                      <a href="{!! url('admin/miscellaneous/languagemanagement') !!}"><i class="glyphicon glyphicon-th-list"></i> {{ trans('menus.guidearea.language_mgmt') }}</a>
                  </li>
                  </ul>
                </li>
                @endauth
                

              </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
          </aside>
