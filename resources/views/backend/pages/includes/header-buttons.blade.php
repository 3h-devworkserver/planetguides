    <div class="top-btn">
        <div class="btn-group">
          <button type="button" class="btn btn-orange dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              {{ trans('menus.pages.pages') }} <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li><a href="{{route('admin.pages.index')}}">{{ trans('menus.pages.all') }}</a></li>

            <li><a href="{{route('backend.pages.deactivated')}}">{{ trans('menus.pages.deactivated_pages') }}</a></li>
            
          </ul>
        </div>

       

        
    </div>

    <div class="clearfix"></div>