@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.user_profile'))
@section('page-header')
<h1>
Add Guide
</h1>
@endsection
@section ('breadcrumbs')

@stop
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script type=text/javascript>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
 </script>


  
<style type="text/css">
      .demo { position: relative; }
      .demo i {
        position: absolute; bottom: 10px; right: 24px; top: auto; cursor: pointer;
      }
      </style>

      <script type="text/javascript">
        $(function() {
          $('#simpliest-usage').multiDatesPicker({ minDate: 0});
        $('.demo .code').each(function() {
          eval($(this).attr('title','NEW: edit this code and test it!').text());
        })
      });
    </script>
<div class="row">
  
    <!-- Profile Image -->
    <div class="box box-primary no-border">
      
        <div class="col-md-12">
          <div id="successmsg" style="display: none;">New User Guide is created.</div>
          <div id="successimgupload" style="display: none;">Image  is successfully added.</div>
          <div id="failedmsg" style="display: none;"></div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">General Info</a></li>
              <li id="userlicense" style="display: none;"><a href="#license" data-toggle="tab">Certification</a></li>
              <li id="userimage" style="display: none;"><a href="#images" data-toggle="tab">Images</a></li>
              <li id="uservideos" style="display: none;"><a href="#videos" data-toggle="tab">Videos</a></li>
              <li id="userbooking" style="display: none;"><a href="#booking" data-toggle="tab">Booking Availability</a></li>
            </ul>
            <div class="tab-content">
              
                <div class="active tab-pane" id="settings">
                          
                          <!-- {!! Form::open(['route' => 'admin.access.users.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!} -->
                          {!! Form::open(['url' => '','role' => 'form', 'id'=>'addGuide','class' => 'form-horizontal',]) !!}
                          <div class="form-group required">
                              {!! Form::label('fname', trans('validation.attributes.fname'), ['class' => 'col-md-2 control-label']) !!}
                              <div class="col-md-10">
                                {!! Form::text('fname', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.fname'), 'required']) !!}
                              </div>
                          </div><!--form control-->
                            <div class="form-group required">
                              {!! Form::label('name', trans('validation.attributes.lname'), ['class' => 'col-md-2 control-label']) !!}
                              <div class="col-md-10">
                                {!! Form::text('lname', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.lname')]) !!}
                              </div>
                            </div><!--form control-->
                              <div class="form-group required">
                                {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-10">
                                  {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email'), 'required']) !!}
                                </div>
                                </div><!--form control-->

                                <div class="form-group required">
                                {!! Form::label('password', trans('validation.attributes.password'), ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-10">
                                  {!! Form::password('password', array('class' => 'form-control')) !!}
                                </div>
                                </div><!--form control-->

                                <div class="form-group required">
                                {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-10">
                                {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
                                </div>
                                </div><!--form control-->
                                <div class="form-group required">
                                {!! Form::label('gender', trans('validation.attributes.gender'), ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-10">
                                  {!! Form::select('gender', array('0' => 'Male', '1' => 'Female', '2' =>'Other'), 'null', array('class'=>'form-control')) !!}

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

                                <div class="form-group required">
                                {!! Form::label('experience', trans('validation.attributes.experience'), ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-10">
                                  {!! Form::selectYear('year', 1992, Carbon\Carbon::today()->format('Y'), Carbon\Carbon::today()->format('Y'), ['class' => 'form-control']) !!}

                                </div>
                                </div><!--form control-->
                                <div class="form-group required">
                                  {!! Form::label('mainArea', trans('validation.attributes.mainArea'), ['class' => 'col-md-2 control-label']) !!}
                                  <div class="col-md-10">
                                  <select  name="mainGuidingArea" class="form-control target" >
                                  <option value="" selected disabled>Please Choose Main Guide area...</option>
                                 
                                  @foreach($options as  $option)
                                  <option value="{{$option->id}}" >
                                    {{$option->guide_area}}
                                  </option>
                                  @endforeach
                                  </select>
                                  </div>
                                  </div><!--form control-->
                                  
                                  <div class="form-group required">
                                  {!! Form::label('otherArea', trans('validation.attributes.otherArea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                  <div class="col-md-10">
                                  <select name="OtherGuidingArea[]" multiple="multiple" class="chosen-select form-control">
                                 
                                  @foreach($options as  $options)
                                  <option value="{{$options->id}}" >
                                    {{$options->guide_area}}
                                  </option>
                                  @endforeach
                                  </select>
                                  
                                  </div>
                                  </div>
                                


                                 <!-- <div id="otherguidearea"></div> -->
                                    
                                    
                                  
                                <div class="form-group required">
                                  {!! Form::label('about', trans('validation.attributes.about'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                  <div class="col-lg-10">
                                    {!! Form::textarea('about', null, ['class' => 'form-control','size' => '30x5']) !!}
                                  </div>
                                  </div><!--form control-->

                                  <div class="form-group required">
                                  {!! Form::label('language', trans('validation.attributes.language'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                  <div class="col-lg-10">
                                  <select name="language[]" multiple="multiple" class="chosen-select form-control">
                                 
                                  @foreach($language as  $languag)
                                  <option value="{{$languag->id}}" >
                                    {{$languag->language}}
                                  </option>
                                  @endforeach
                                  </select>
                                  
                                  </div>
                                  </div><!--form control-->
                                  <div class="form-group required" id="otherarea">
                                      {!! Form::label('specilizedarea', trans('validation.attributes.specilizedarea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                      <div class="col-lg-10">
                                      {!! Form::text('specilizedarea', ' ', array('class' => 'form-control')) !!}
                                      </div>
                                  </div><!--form control-->
                                  <div class="form-group required">
                                    {!! Form::label('price', trans('validation.attributes.price'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                    <div class="col-lg-10">
                                      {!! Form::input('number','price', '', ['class' => 'form-control'])!!}
                                    </div>
                                    </div><!--form control-->
                                  <div class="form-group">
                                      <label class="col-md-2 control-label">Active</label>
                                      <div class="col-md-8">
                                        <input type="checkbox" value="1" name="status" />
                                      </div>
                                      </div><!--form control-->
                                      <div class="form-group">
                                        <label class="col-md-2 control-label">Confirm</label>
                                        <div class="col-md-8">
                                          <input type="checkbox"  value="1" name="confirmed"  />
                                        </div>
                                        </div><!--form control-->
                                       
                                        <!-- <div class="form-group">
                                          <label class="col-lg-2 col-md-2 control-label">Certified</label>
                                          <div class="col-md-8">
                                            <input type="checkbox"  value="1" name="certified"  /> Check here to certify this user
                                          </div>
                                          </div> -->
                                         
                                          <div class="form-group required">
                                              
                                              <div class="col-lg-3" style="display: none;">
                                                  
                                                          <input type="radio"  value="2" name="assignees_roles" id="role-2" checked /> <label for="role-2">Guide</label>

                                                          
                                                      
                                              </div>
                                          </div><!--form control-->
                                          <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                              {!! Form::submit(trans('strings.save_button'), ['class' => 'btn btn-orange']) !!}
                                            </div>
                                          </div>
                                         
                    {!! Form::close() !!}                                          
                </div>         
                                       
        <div class="tab-pane" id="images">
          <div class="row wrap-all">
              {!! Form::open(['url'=>'#','id'=>'gallerySetProfileForm']) !!}
            <div class="gallery-list" id="images-list">

                  <div id="galleryshow"></div>
                  
            </div>
            <div class="imagesUploadArea">
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
                    <input  type="hidden" name="id">
                <div class="imglicloader" style="display: none;">
                {!!Form::image('images/ajax-loader.gif')!!}
                </div>

              </div>
              <div class="loader-overlay"><div class="custom-loader"></div></div>
            </div>

            <div class="form-group btmsave">
                    <div class="col-md-12">
                      <div class="pull-right">
                      {!! Form::submit(trans('strings.save_button'), ['class' => 'btn btn-success', 'id' => 'submit']) !!}
                      </div>
                    </div>
                    </div>
              {!! Form::close()!!}
          </div>
            
        </div>
        <div class="tab-pane" id="license">
          <div class="row">
             <div class="gallery-list" id="images-list">
              <div id="licenseshow"></div>
        </div>
            <div class="imagesUploadArea">
              <div class="thumbnail browse-image">

                {!! Form::open() !!}
                   <div class="galleryUploadButton">
                       <span class="uploadButton"><i class="fa fa-plus"></i></span>
                          <input 
                              id="licensePicture"
                              name="licensegalleryPic"
                              data-url="{{ route('backend.guide.license.upload') }}"
                              accept="image/*" 
                              type="file"
                              multiple>
                    </div> 
                    <input  type="hidden" name="id">
                    
                {!! Form::close() !!}
                <div class="imglicloader" style="display: none;">
                {!!Form::image('images/ajax-loader.gif')!!}
                </div>
                </div>
                <div class="loader-overlay"><div class="custom-loader"></div></div>
          </div>
          <div class="col-md-12">
          {!! Form::open(['url' => '#','method'=>'POST', 'role' => 'form',  'files'=> false, 'id'=>'mylicenseForm']) !!}
                <div class="checkbox chkbox">
                      <input type="checkbox"  value="1" name="certified" /> Check here to certify this user
                </div>

                <input  type="hidden" name="id">
                    
                <div class="form-group">
                      <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
                </div>
                {!! Form::close() !!}
          </div>
        </div>
        
           
        </div>

        <div class="tab-pane" id="videos">
          <div class="row">
          <div class="gallery-list"  id="videos-list">
                <div id="displayvideo"></div>
            </div>
            <div class="imagesUploadArea">
              <div class="thumbnail browse-image">
                 <a  data-toggle="modal" data-target="#video-modal" class="bg-image">
                    <div class="galleryUploadButton"><span class="uploadButton"><i class="fa fa-plus"></i></span></div>
                  </a>
                <div class="galleryUploadProcess"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="booking">
          <div class="book-it-content">
          {!! Form::open(['url' => '#','method'=>'POST', 'role' => 'form',  'files'=> false, 'id'=>'mybookingForm']) !!}
            <!-- {!! Form::open(['route' => 'frontend.guide.booking.process']) !!} -->
            <div class="demo first">
            <h3 class="selectdates">Select Dates</h3>
            <div id="simpliest-usage" class="box"></div>
            </div>
           
            <input  type="hidden" name="id">
                    
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
            </div>
            {!! Form::close() !!}
          </div>
        </div>


      </div><!-- /.tab-content -->
     </div><!-- /.nav-tabs-custom -->
     </div>
     </div>
     </div>
    
  
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
                                        <input  type="hidden" name="id">
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
   print_country("country","");
      $("#state").append(new Option("", " "));
</script>
 


@stop
@section('after-styles-end')
  {!! HTML::style('fancybox/jquery.fancybox.css') !!}
  {!! HTML::style('blueimp/css/jquery.fileupload.css') !!}
  {!! HTML::style('blueimp/css/jquery.fileupload-ui.css') !!}
  {!! HTML::script('js/countries.js') !!}

@stop
@section('after-scripts-end')

<script>


    $(document).ready(function() {
        $(document).on('click', '#loadmore-review', function (e) {
            e.preventDefault();
            $('#loadmore-pagination #loadmore-loader').show();
            $('#loadmore-pagination #loadmore-review').hide();
            $.ajax({
                type:'GET',
                url : $(this).attr('href'),
                }).done(function (data) {
                    $('#loadmore-pagination').remove();
                    $('#loadmore-pagination #loadmore-loader').hide();
                    $('#loadmore-pagination #loadmore-review').show();
                    $('.review-list #reviews-listing').append(data.html);
                })
            });
        });

$(function() {
      prettyPrint();
    });
</script>

    {!! HTML::script('js/customCalendar.js') !!}
    {!! HTML::script('js/expanding.js') !!}
    {!! HTML::script('js/starrr.js') !!}

  <script type="text/javascript">
 
    $(function(){
      // initialize the autosize plugin on the review text area
      $('#new-review').autosize({append: "\n"});
      var reviewBox = $('#post-review-box');
      var newReview = $('#new-review');
      var openReviewBtn = $('#open-review-box');
      var closeReviewBtn = $('#close-review-box');
      var ratingsField = $('#ratings-hidden');
      openReviewBtn.click(function(e)
      {
        reviewBox.slideDown(400, function()
          {
            $('#new-review').trigger('autosize.resize');
            newReview.focus();
          });
        openReviewBtn.fadeOut(100);
        closeReviewBtn.show();
      });
      closeReviewBtn.click(function(e)
      {
        e.preventDefault();
        reviewBox.slideUp(300, function()
          {
            newReview.focus();
            openReviewBtn.fadeIn(200);
          });
        closeReviewBtn.hide();
        
      });
      // If there were validation errors we need to open the comment form programmatically 
      @if($errors->first('comment') || $errors->first('rating'))
        openReviewBtn.click();
      @endif
      // Bind the change event for the star rating - store the rating value in a hidden field
      $('.starrr').on('starrr:change', function(e, value){
        ratingsField.val(value);
      });
    });
  </script>

{!! HTML::script('datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('datepicker/js/foundation-datepicker.js') !!}
@endsection