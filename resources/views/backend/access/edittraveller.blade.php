@extends ('backend.layouts.master')
@section ('title', trans('menus.user_management') . ' | ' . trans('menus.user_profile'))
@section('page-header')
<h1>
  {{ trans('menus.user_profile') }}
</h1>
@endsection
@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! trans('menus.user_profile') !!}</li>
@stop
@section('content')
<script type="text/javascript">
  $(document).ready(function(){
    $("select.chosen-selectmain").chosen();
  });
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type=text/javascript>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>


<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle profile-avatar" src="
          @if (file_exists($user->profile->profilesmallImg))
            {{ asset($user->profile->profilesmallImg) }}
          @else
            {{ '/images/avatar.png' }}
          @endif
        " alt="User profile picture">
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
        {!! Form::open() !!}
        <div class="profileInput">
          <span class="uploadButton"><i class="fa fa-camera"></i>
            <input
            id="profilePic"
            name="profilePic"
            data-url="{{ route('backend.traveller.profile.pic.upload',$user->id) }}"
            accept="image/*"
            type="file">
          </span>
        </div>
        {!! Form::close() !!}
      </div><!-- /.box-body -->
    </div><!-- /.box -->
    <div class="uploadProcess"></div>
    
  </div><!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <div id="successmsg" style="display: none;"></div>
      <div id="failedmsg" style="display: none;"></div>
      <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab">General Info</a></li>
        @if ($user->id != 1)
        <!--  <li><a href="#images" data-toggle="tab">Images</a></li>  -->
        <!-- <li><a href="#booking" data-toggle="tab">Booked Days</a></li> -->
        @endif
        
      </ul>
      <div class="tab-content user-profile-tab">
        @if ($user->id != 1)
        
        @endif
        <div class="active tab-pane" id="settings">
          {!! Form::model($user, ['route' => ['admin.access.travellers.update', $user->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}
          <div class="form-group">
            {!! Form::label('fname', trans('validation.attributes.fname'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::text('fname', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.fname'), 'required']) !!}
            </div>
          </div><!--form control-->
          <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.lname'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::text('lname', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.lname'), 'required']) !!}
            </div>
          </div><!--form control-->

          <div class="form-group">
            {!! Form::label('nickname', trans('Nickname'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::text('nickname', null, ['class' => 'form-control', 'placeholder' => trans('Nickname'), 'required']) !!}
            </div>
          </div><!--form control-->

          <div class="form-group">
            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email'), 'required']) !!}
            </div>
          </div><!--form control-->
          <div class="form-group">
            {!! Form::label('gender', trans('validation.attributes.gender'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::select('gender', array('0' => 'Male', '1' => 'Female', '2' =>'Other'), $user->gender, array('class'=>'form-control')) !!}

            </div>
          </div><!--form control-->

          <div class="form-group">
            {!! Form::label('address', trans('Address'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => trans('Address'), 'required']) !!}
            </div>
          </div><!--form control-->

          <div class="form-group">
            {!! Form::label('city', trans('City'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => trans('City'), 'required']) !!}
            </div>
          </div><!--form control-->

          <div class="form-group">
            {!! Form::label('zip', trans('Zip'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::text('zip', null, ['class' => 'form-control', 'placeholder' => trans('Zip Code'), 'required']) !!}
            </div>
          </div><!--form control-->

          <div class="form-group">
            {!! Form::label('country', trans('Country'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
            <select id="country" name="country" class="form-control" onchange="print_state('state',this.selectedIndex);" required></select>

            </div>
          </div><!--form control-->

          <div class="form-group">
            {!! Form::label('state', trans('State'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
            <select name="state" class="form-control" id="state" required></select>

            </div>
          </div><!--form control-->

          <div class="form-group">
            {!! Form::label('phone', trans('Phone'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => trans('Phone')]) !!}
            </div>
          </div><!--form control-->
          
          
         <div class="form-group">
          {!! Form::label('about', trans('validation.attributes.about'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
          <div class="col-lg-10">
            {!! Form::textarea('about', null, ['class' => 'form-control','size' => '30x5']) !!}
          </div>
          
        </div><!--form control-->
        
        <div class="form-group">
          <label class="col-lg-2 col-md-2 control-label">{{ trans('validation.attributes.active') }}</label>
          <div class="col-md-8">
            <input type="checkbox" value="1" name="status" {{ $user->status == 1 ? 'checked' : '' }} />
          </div>
        </div><!--form control-->

        <div class="form-group">
          <label class="col-lg-2 col-md-2 control-label">{{ trans('validation.attributes.confirmed') }}</label>
          <div class="col-md-8">
            <input type="checkbox"  value="1" name="confirmed" {{ $user->confirmed == 1 ? 'checked' : '' }} />
          </div>
        </div><!--form control-->

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="pull-left">
              <input type="submit" class="btn btn-orange" value="{{ trans('strings.save_button') }}" />
            </div>
          </div>
        </div>
        
        {!! Form::close() !!}
      </div><!-- /.tab-pane -->

                                    

    <div class="tab-pane" id="booking">
      <div class="book-it-content">

        {!! Form::open(['url' => '#','method'=>'POST', 'role' => 'form',  'files'=> false, 'id'=>'mybookingEditForm']) !!}
        
        <div class="demo first">
          <h3 class="selectdates">Select Dates</h3>
          <div id="simpliest-usage" class="box"></div>
        </div>
        {!! Form::hidden('id', $user->id) !!}       
        <div class="form-group">
          <input type="submit" class="btn btn-orange" value="{{ trans('strings.save_button') }}" />
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div><!-- /.tab-content -->
</div><!-- /.nav-tabs-custom -->
</div><!-- /.col -->
</div><!-- /.row -->

@stop
@section('after-scripts-end')
{!! HTML::script('js/backend/access/permissions/script.js') !!}
{!! HTML::script('js/backend/access/users/script.js') !!}
{!! HTML::script('blueimp/load-image.all.min.js') !!}
{!! HTML::script('blueimp/canvas-to-blob.js') !!}
{!! HTML::script('blueimp/jquery.iframe-transport.js') !!}
{!! HTML::script('blueimp/jquery.fileupload.js') !!}
{!! HTML::script('blueimp/jquery.fileupload-process.js') !!}
{!! HTML::script('blueimp/jquery.fileupload-image.js') !!}
{!! HTML::script('blueimp/jquery.fileupload-validate.js') !!}
{!! HTML::script('fancybox/jquery.fancybox.js?v=2.1.5') !!}
{!! HTML::script('js/customUpload.js') !!}
{!! HTML::script('js/backend/customCalendarbackend.js') !!}
{!! HTML::script('js/backend/daterangepicker.js') !!}

<script type="text/javascript">
      print_country("country","{{ $user->country }}");
      $("#state").append(new Option("{{ $user->state }}", "{{ $user->state }}"));
  /*
       *  Simple image gallery. Uses default settings
       */
$(document).ready(function(){
        $('#galleryshow .fancybox').fancybox();
        $('#license .fancybox').fancybox();
        $('#displayvideo .fancybox').fancybox();
        $('.profile-img .fancybox').fancybox();
       $(document).on('click','.video', function(){
          $.fancybox({ 'padding' : 0,'arrows':true, 'autoScale' : false, 'transitionIn' : 'none', 'transitionOut' : 'none', 'title' : this.title, 'width' : 640, 'height' : 385, 'href' : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'), 'type' : 'swf', 'swf' : { 'wmode' : 'transparent', 'allowfullscreen' : 'true' } }); return false; });  
       });

    
</script>



@stop

@section('after-styles-end')
{!! HTML::style('fancybox/jquery.fancybox.css') !!}
{!! HTML::style('blueimp/css/jquery.fileupload.css') !!}
{!! HTML::style('blueimp/css/jquery.fileupload-ui.css') !!}
  {!! HTML::script('js/countries.js') !!}

@stop