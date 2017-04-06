@extends ('backend.layouts.master')

@section ('title', 'Guide License View')

@section('page-header')
  <h1>
      View License
  </h1>
@endsection

@section ('breadcrumbs')
  <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
  <li class="active">View License</li>
@stop

@section('content')
  <div class="row">
    <div class="col-md-3">
    <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle profile-avatar" src="{!! $user->picture!!}" alt="User profile picture">
          <h3 class="profile-username text-center">{{ $user->name }}</h3>
          <p class="text-muted text-center">
            @if ($user->roles()->count() > 0)
                @foreach ($user->roles as $role)
                    {!! $role->name !!}<br/>
                @endforeach
            @else
                None
            @endif
          </p>
          @if ($user->id == access()->user()->id)
            {!! Form::open() !!}
              <div class="profileInput">
                <span class="uploadButton"><i class="fa fa-camera"></i> 
                  <input 
                  id="profilePic"
                  name="profilePic"
                  data-url="{{ route('backend.admin.profile.pic.upload') }}"
                  accept="image/*" 
                  type="file">
                </span>
              </div>  
            {!! Form::close() !!}
          @endif
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <div class="uploadProcess"></div>
     
      @if ($user->roles()->first()->id != 1 AND $user->roles()->first()->id != 3)
          <!-- Certified Button -->
          @if ($user->guide->certified == 1)
            <a class="btn btn-block btn-success btn-lg btn-flat btn-social">
              <i class="fa fa-certificate"></i> Certified
            </a>
          @else
            <a class="btn btn-block btn-danger btn-lg btn-flat btn-social">
              <i class="fa fa-circle-o"></i> Not Certified
            </a>
            <a class="btn btn-block btn-primary btn-lg btn-flat btn-social" href="{{ route('admin.access.users.edit', $user->id) }}">
              <i class="fa fa-backward"></i>Go back to certify
            </a>
          @endif
         
      @endif

    </div><!-- /.col -->
    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">License of {{ $user->fname }} {{ $user->lname }}</h3>
          <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body gallery-list">
        <div class="row-fluid"> 
        @foreach ($user->License as  $gallery)
        <div class="col-md-3">
          <div class="thumbnail">
            <a class="fancybox" href="{{ asset($gallery->path) }}" data-fancybox-group="gallery" title="License" style="background-image:url({{ asset($gallery->path) }})"></a>
            {!! Form::open(['url'=>'#','id'=>'licenseDeleteForm']) !!} 
              {!! Form::hidden('id',$gallery->id) !!}
              <button type="submit" id="licenseDeleteButton" class="delete-btn" onclick="return confirm('Are you sure you want to delete this item?');">
                  <span>&times;</span>
              </button> 
            {!! Form::close() !!}
          </div>
          </div>
        @endforeach
        </div>
        </div><!-- /.box-body -->
    </div><!--box box-success-->
    </div><!-- /.col -->
  </div><!-- /.row -->


@stop

@section('after-styles-end')
  {!! HTML::style('fancybox/jquery.fancybox.css') !!}
@stop
@section('after-scripts-end')
  {!! HTML::script('fancybox/jquery.fancybox.js?v=2.1.5') !!}
  <script type="text/javascript">
    
    $('.fancybox').fancybox();
    
    /*----------------licensse delete --------------*/
    $(document).on('submit', '#licenseDeleteForm', function(event) {
            event.preventDefault();
            var _data = $(this).serialize();
            $.ajax({
                url: base_url + '/admin/license/delete',
                type: 'POST',
                dataType: 'json',
                data: _data
            })
            .done(function(data) {
                if (data.stat == 'ok'){
                  location.reload();
                }
                else{
                    alert(data.stat);
                }
            });
      }); 
  </script>
@stop

