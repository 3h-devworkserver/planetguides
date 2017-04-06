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
<script type="text/javascript">
 $(document).ready(function() {

  var config = "{{$availibility}}";
  console.log(config);
  if (config != '') {
    console.log(config);
    var allBookeddates = config.split(",");
    $('#simpliest-usage').multiDatesPicker
    ({
            //format: 'yyyy-mm-dd',
            minDate: 0,
            addDates: allBookeddates,
          });

  }
  else {
    console.log("no data");
    $('#simpliest-usage').multiDatesPicker
    ({
                        //format: 'yyyy-mm-dd',
                        minDate: 0,
                        addDates: allBookeddates,

                      });
  }

  $('.demo .code').each(function() {

    eval($(this).attr('title','NEW: edit this code and test it!').text());
  })
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
    <div class="box-feature-btn">
      @if ($user->roles()->first()->id != 1 AND $user->roles()->first()->id != 3)
      <!-- Certified Button -->
      @if ($user->guide->certified == 1)
      <a class="btn btn-block btn-success btn-flat">
        <i class="fa fa-check"></i> Certified
      </a>
      @else
      <a class="btn btn-block btn-danger btn-flat">
        <i class="fa fa-circle-o"></i> Not Certified
      </a>
      @endif
      @if ($user->hasLicense())
      <a class="btn btn-block btn-primary btn-flat" href="{{ route('backend.license', $user->id) }}">
        <i class="fa fa-eye"></i> View License
      </a>
      @endif
      @endif
      @if ($user->roles()->first()->id==1)
      <a class="btn btn-block btn-primary btn-flat" href="{{ route('admin.access.user.change-password', $user->id) }}">
        <i class="fa fa-key"></i> Change Password
      </a>
      @endif
    </div>
  </div><!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <div id="successmsg" style="display: none;"></div>
      <div id="failedmsg" style="display: none;"></div>
      <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab">General Info</a></li>
        @if ($user->id != 1)
        <li><a href="#license" data-toggle="tab">Certification</a></li>
        <li><a href="#images" data-toggle="tab">Images</a></li>
        <li><a href="#videos" data-toggle="tab">Videos</a></li>
        <li><a href="#booking" data-toggle="tab">Booked Days</a></li>
        @endif

      </ul>
      <div class="tab-content user-profile-tab">
        @if ($user->id != 1)

        @endif
        <div class="active tab-pane" id="settings">
          {!! Form::model($user, ['route' => ['admin.access.users.update', $user->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}
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
            {!! Form::label('experience', trans('validation.attributes.experience'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              {!! Form::selectYear('experience', 1992, Carbon\Carbon::today()->format('Y'), $user->profile->experience, ['class' => 'form-control']) !!}

            </div>
          </div><!--form control-->
          <div class="form-group required" id="mainarea">
            {!! Form::label('mainArea', trans('validation.attributes.mainArea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">
              <select  name="mGuidingArea" class="form-control target" >
                @if(!empty($selectedarea))  <!-- edited yojan -->
                <option value="{{ $selectedarea[0]->id}}" selected>{{ $selectedarea[0]->guide_area}}</option>
                @else
                <option value="">-- Select Main Guiding Area --</option>
                @endif
                @foreach($guidearea as  $option)
                <option value="{{$option->id}}" >
                  {{$option->guide_area}}
                </option>
                @endforeach
              </select>
            </div>
          </div><!--form control-->

          <div id="onchangehide" style=" ">
            <div class="form-group required" id="otherarea">
              {!! Form::label('otherArea', trans('validation.attributes.otherArea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
              <div class="col-lg-10">

                <select class="chosen-select form-control" multiple="multiple" name="OtherGuidingArea[]" id="places">
                  @foreach($guidearea as $place)
                  <!--edited yojan -->
                  <option value="{{$place->id}}" @if(!empty($selectedoarea[0])) @foreach($selectedoarea as $p)
                   @if($place->id === $p[0]->id) selected="selected"
                   @endif
                   @endforeach
                   @endif
                   >
                   {{$place->guide_area}}
                 </option>
                 @endforeach
               </select>



             </div>
           </div><!--form control-->
         </div>
         <!--<div id="otherguidearea"></div> -->


         <div class="form-group">
          {!! Form::label('about', trans('validation.attributes.about'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
          <div class="col-lg-10">
            {!! Form::textarea('about', null, ['class' => 'form-control','size' => '30x5']) !!}
          </div>

        </div><!--form control-->
        <div id="onchangehide" style=" ">
          <div class="form-group required" >
            {!! Form::label('language', trans('validation.attributes.language'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
            <div class="col-lg-10">

              <select class="chosen-select form-control" multiple="multiple" name="language[]" id="places">

                @foreach($guidelanguage as $places)
                <!-- edited yojan -->
                <option value="{{$places->id}}" @if(!empty($selectedlang[0])) @foreach($selectedlang as  $p) @if($places->id === $p[0]->id) selected="selected"@endif @endforeach @endif>{{$places->language}}</option>
                @endforeach
              </select>



            </div>
          </div>
        </div><!--form control-->

        <div class="form-group required" id="mainarea">
          {!! Form::label('specilizedarea', trans('validation.attributes.specilizedarea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}

          <div class="col-lg-10" id="target">
            {!! Form::text('specilizedarea', $selectedskill, array('class' => 'form-control')) !!}
          </div>
        </div><!--form control-->
        @if ($user->id != 1)
        <div class="form-group">
          {!! Form::label('price', trans('validation.attributes.price'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
          <div class="col-lg-10">
            {!! Form::input('number','price', $user->guide->price, ['class' => 'form-control'])!!}
          </div>
        </div><!--form control-->

         <div class="form-group">
          {!! Form::label('guide_pts', trans('Guide Points'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
          <div class="col-lg-10">
            {!! Form::input('number','guide_pts', $user->guide->guide_pts, ['class' => 'form-control'])!!}
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
        @endif
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="pull-left">
              <input type="submit" class="btn btn-orange" value="{{ trans('strings.save_button') }}" />
            </div>
          </div>
        </div>

        {!! Form::close() !!}
      </div><!-- /.tab-pane -->

      <div class="tab-pane consistency" id="images">
        <div class="row-fluid wrap-all">
          {!! Form::open(['url'=>'#','id'=>'gallerySetProfileForm']) !!}
          <div class="gallery-list" id="images-list">

            <div id="galleryshow">
              @include('backend.gallery.images')
              <div class="col-md-3">
                <div class="thumbnail browse-image">
                 <div class="galleryUploadButton">
                   <span class="uploadButton"><i class="fa fa-plus"></i></span>
                   <input
                   id="galleryPicture"
                   name="galleryPic"
                   data-url="{{ route('frontend.guide.addgallery.upload') }}"
                   accept="image/*"
                   type="file"
                   multiple>
                 </div>
                 {!! Form::hidden('id', $user->id) !!}
                 <div class="imglicloader" style="display: none;">
                  {!!Form::image('images/ajax-loader.gif')!!}
                </div>

              </div>
              <div class="loader-overlay"><div class="custom-loader"></div></div>
            </div>
          </div>

        </div>


        <div class="form-group btmsave">
          {!! Form::submit(trans('strings.save_button'), ['class' => 'btn btn-orange', 'id' => 'submit']) !!}
        </div>
        {!! Form::close()!!}
      </div>

    </div>
        <!-- <div class="tab-pane" id="images">
          <div class="row">
            <div class="col-md-4 col-sm-4 imagesUploadArea">
              <div class="thumbnail browse-image">
                {!! Form::open() !!}
                   <div class="galleryUploadButton">
                       <span class="uploadButton"><i class="fa fa-plus"></i></span>
                          <input
                              id="galleryPic"
                              name="galleryPic"
                              data-url="{{ route('frontend.guide.gallery.upload') }}"
                              accept="image/*"
                              type="file"
                              multiple>
                    </div>
                    {!! Form::hidden('id', $user->id) !!}
                {!! Form::close() !!}
                <div class="loader-overlay"><div class="custom-loader"></div></div>
              </div>
            </div>
            <div class="gallery-list" id="images-list">
              @include('backend.gallery.images')
            </div>
          </div>
        </div> -->

        <div class="tab-pane" id="license">
          <div class="row-fluid">
           <div class="gallery-list" id="images-list">
            <div id="licenseshow">
              @include('backend.gallery.licence')
              <div class="col-md-3">
              <div class="imagesUploadArea">
                <div class="thumbnail browse-image">

                  {!! Form::open() !!}
                  <div class="galleryUploadButton">
                   <span class="uploadButton"><i class="fa fa-plus"></i></span>
                   <input
                   id="licensePicture"
                   name="licensegalleryPic"
                   data-user = "{{$user->id}}"
                   data-url="{{ route('backend.guide.license.upload') }}"
                   accept="image/*"
                   type="file"
                   required
                   multiple>
                 </div>
                 {!! Form::hidden('id', $user->id) !!}

                 {!! Form::close() !!}
                 <div class="imglicloader" style="display: none;">
                  {!!Form::image('images/ajax-loader.gif')!!}
                </div>
              </div>
              <div class="loader-overlay"><div class="custom-loader"></div></div>
            </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          {!! Form::open(['url' => '#','method'=>'POST', 'role' => 'form',  'files'=> false, 'id'=>'mylicenseForm']) !!}
          <div class="checkbox chkbox">
            <input type="checkbox"  value="1" name="certified" {{ $user->guide->certified == 1 ? 'checked' : '' }} /> Check here to certify this user
          </div>

          {!! Form::hidden('id', $user->id) !!}

          <div class="form-group">
            <input type="submit" class="btn btn-orange" value="{{ trans('strings.save_button') }}" />
          </div>
          {!! Form::close() !!}
        </div>
      </div>


    </div>
    <div class="tab-pane" id="videos">
      <div class="row-fluid">
        <div class="gallery-list"  id="videos-list">
          <div id="displayvideo">
            @include('backend.gallery.videos')
            <!-- <div class="imagesUploadArea"> -->
            <div class="col-md-3">
              <div class="thumbnail browse-image">

                <div class="galleryUploadButton" data-toggle="modal" data-target="#video-modal"><span class="uploadButton"><i class="fa fa-plus"></i>
                </span></div>

           <!--  <div class="galleryUploadButton"><span class="uploadButton">
                <a  data-toggle="modal" data-target="#video-modal" class="bg-image"><i class="fa fa-plus"></i></a></span></div> -->

                <div class="galleryUploadProcess"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

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
<div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-labelledby="myVideoLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Embed Your Video From Youtube</h4>
      </div>
      <div class="modal-body">
        <div class="row">
         <div class="video-message"></div>
         {!! Form::open(['url' => '', 'role' => 'form', 'id'=>'addVideoForm']) !!}
         <div class="col-md-6 col-sm-6">
          <div class="form-group">
            {!! Form::input('text', 'url',null, ['class' => 'form-control', 'id' => 'url','placeholder' => trans('validation.attributes.youtubeUrl'), 'required']) !!}
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            {!! Form::input('text', 'caption',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.caption')]) !!}
          </div>
        </div>
        <div class="col-md-12 col-sm-12">
          <div class="form-group">
            {!! Form::hidden('id', $user->id) !!}
            {!! Form::submit(trans('labels.button.submit'), ['class' => 'btn btn-defaultn btn-primary']) !!}
          </div>
        </div>
        <div class="loader-overlay"><div class="custom-loader"></div></div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
</div>
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