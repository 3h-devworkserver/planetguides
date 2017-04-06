@extends('frontend.layouts.masterProfile')
@section('title') Edit Profile | {{ $siteTitle }}@endsection
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
    <section class="profile-banner" style="background-image:url({{ asset($guide->bannerPic) }})">
        
      {!! Form::open() !!}
             <div class="bannerArea">
                 <span class="uploadButton"><i class="fa fa-camera"></i><span>Upload</span></span>
                    <input 
                        id="bannerPic"
                        name="bannerPic"
                        data-url="{{ route('frontend.guide.banner.upload') }}"                        
                        accept="image/*" 
                        type="file">
              </div> 
      {!! Form::close() !!}
      <div class="bannerUploadProcess"></div>
    </section>
  

    <section class="guide-profile">
        <div class="container">
            <div class="row guide-wrapper">
                <div class="col-md-9">
                    <div class="guide-name">
                    @if ($guide->guide->certified)
                        <div class="name pull-left">
                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Certified guide"><i class="fa fa-certificate"></i></button>
                            <h3 class="">{{$guide->fname}} {{$guide->lname}}</h3>
                        </div>
                    @endif
                        <div class="rating-review pull-right text-center">
                                <span class="rating remarkable">
                                    <span>{{$guide->guide->rating_count}}</span>
                                </span>
                                <span>
                                    <a href="#">Reviews</a>
                                </span>
                        </div>
                    </div> <!-- guide-name closing -->
                </div> <!-- col-md-12 closing -->
            </div> <!--row closing -->

            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="traveller-rating">
                        <div class="title">
                            <h4>Guide Rating</h4>
                            <div class="rating-wrap">
                            @if($guide->guide->rating_cache >= 4.5)
                                <div class="rating-type">
                                    <p>Excellent</p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                            
                                            </div>
                                        </div>

                                    <small class="pull-right">20</small>
                                </div>
                            @endif
                            @if($guide->guide->rating_cache >= 3.5 && $guide->guide->rating_cache < 4.5)
                                <div class="rating-type">
                                    <p>Very Good</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">10</small>
                                </div>
                            @endif
                            @if($guide->guide->rating_cache >= 2.5 && $guide->guide->rating_cache < 3.5)
                                <div class="rating-type">
                                    <p>Average</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">2</small>
                                </div>
                            @endif
                            @if($guide->guide->rating_cache >= 1.5 && $guide->guide->rating_cache < 2.5)
                                <div class="rating-type">
                                    <p>Poor</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                            
                                        </div>
                                    </div>
                                    <small class="pull-right">0</small>
                                </div>
                            @endif
                            @if($guide->guide->rating_cache >= 0 && $guide->guide->rating_cache <= 1)
                                <div class="rating-type">
                                    <p>Terrible</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                           
                                        </div>
                                    </div>
                                    <small class="pull-right">0</small>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-8">
               
                    <div class="row profile-content">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="profile-image">
                        
                                        {!! Form::open() !!}
                                            
                                             <img src="{{ $guide->profilePic }}" class="profile-avatar bg-image" />
                                             
                                             <div class="profileInput">
                                             <span class="uploadButton"><i class="fa fa-camera"></i><span>Upload</span>
                                             <input 
                                                    id="profilePic"
                                                    name="profilePic"
                                                    data-url="{{ route('frontend.guide.profile.pic.upload') }}"
                                                    
                                                    accept="image/*" 
                                                    type="file"></span>
                                                
                                              </div>  
                                        {!! Form::close() !!}

                    </div>
                    <div class="uploadProcess"></div>
                                </div>
                                <div class="col-md-8 col-sm-12">
                                    <div class="guide-detail">
                                        <ul>
                                            <li>
                                                <p><span>Tour ID :</span>{{ $guide->guide->gid }}</p>
                                            </li>
                                            <li>
                                               
                                                <span>Experience :</span>
                                                {!! Form::model($guide, ['url' => '#', 'role' => 'form', 'id'=>'experienceForm']) !!}
                                                
                                                <div id="textWrapperExp" class="field">{{ $guide->experience }}
                                                @if($guide->experience<'2')
                                                Year
                                                @else
                                                Years
                                                @endif
                                                </div>
                                                <div id="editInputExp" class="edit-field" style="display:none">
                                                    {!! Form::text('experience', null, ['class' => 'form-control', 'id'=>'experienceInput','placeholder' => 'Years']) !!}
                                                    {!! Form::hidden('id', null) !!}
                                                </div>
                                                <span id="editExperience" class="edit-icon" title="Edit"><i class="fa fa-pencil"></i></span>
                                                <a id="cancelExp" class="cancel-icon" href="javascript:void(0);" style="display:none"><i class="fa fa-times"></i></a>
                                                
                                                <input type="submit" class="btn btn-success" id="saveExperience" value="{{ trans('strings.save_button') }}" style="display:none"/>
                                                
                                                {!! Form::close() !!}
                                            
                        
                                            </li>
                                           
                                            <li>

                                                <span>Gender :</span>
                                                {!! Form::model($guide, ['url' => '#', 'role' => 'form', 'id'=>'genderForm']) !!}
                                                
                                                <div id="textWrapperGen" class="field">{{ $guide->gender }}</div>
                                                <div id="editInputGen" class="edit-field" style="display:none">
                                                    <span class="radio">
                                                        <label>
                                                            {!! Form::radio('gender', 'male',  ['class' => 'form-control']) !!} Male
                                                        </label> 
                                                        <label>
                                                            {!! Form::radio('gender', 'female',  ['class' => 'form-control']) !!} Female
                                                        </label>
                                                    </span>
                                                    
                                                    {!! Form::hidden('id', null) !!}
                                                </div>
                                                <span id="editGender" class="edit-icon" title="Edit"><i class="fa fa-pencil"></i></span>
                                                <a id="cancelGen" class="cancel-icon" href="javascript:void(0);" style="display:none"><i class="fa fa-times"></i></a>
                                                
                                                <input type="submit" class="btn btn-success" id="saveGender" value="{{ trans('strings.save_button') }}" style="display:none"/>
                                                
                                                {!! Form::close() !!}
                                             
                                            </li>
                                            <li>
                                                 <span>Main Guiding Area :</span>
                                                {!! Form::model($guide, ['url' => '#', 'role' => 'form', 'id'=>'MgForm']) !!}
                                                
                                                <div id="textWrapperMg" class="field">{{ $guide->mGuidingArea }}</div>
                                                <div id="editInputMg" class="edit-field" style="display:none">
                                                    {!! Form::text('mGuidingArea', null, ['class' => 'form-control', 'id'=>'MgInput']) !!}
                                                    {!! Form::hidden('id', null) !!}
                                                </div>
                                                <span id="editMg" class="edit-icon" title="Edit"><i class="fa fa-pencil"></i></span>
                                                <a id="cancelMg" class="cancel-icon" href="javascript:void(0);" style="display:none"><i class="fa fa-times"></i></a>
                                                
                                                <input type="submit" class="btn btn-success" id="saveMg" value="{{ trans('strings.save_button') }}" style="display:none"/>
                                                
                                                {!! Form::close() !!}
                                            </li>
                                            <li>
                                               
                                                    <span>Other Guiding Area :</span>
                                                    
                                                   {!! Form::model($guide, ['url' => '#', 'role' => 'form', 'id'=>'OgForm']) !!}
                                                
                                                <div id="textWrapperOg" class="field">{{ $guide->oGuidingArea }}</div>
                                                <div id="editInputOg" class="edit-field" style="display:none">
                                                   {!! Form::text('oGuidingArea', null, ['class' => 'form-control', 'id'=>'OgInput']) !!}
                                                    {!! Form::hidden('id', null) !!}
                                                </div>
                                                <span id="editOg" class="edit-icon" title="Edit"><i class="fa fa-pencil"></i></span>
                                                <a id="cancelOg" class="cancel-icon" href="javascript:void(0);" style="display:none"><i class="fa fa-times"></i></a>
                                                
                                                <input type="submit" class="btn btn-success" id="saveOg" value="{{ trans('strings.save_button') }}" style="display:none"/>
                                                
                                                {!! Form::close() !!}
                                               
                                            </li>
                                            <li>
                                               
                                                    <span>Language :</span>
                                                   {!! Form::model($guide, ['url' => '#', 'role' => 'form', 'id'=>'LangForm']) !!}
                                                
                                                <div id="textWrapperLang" class="field">{{ $guide->language }}</div>
                                                <div id="editInputLang" class="edit-field" style="display:none">
                                                   {!! Form::text('language', null, ['class' => 'form-control', 'id'=>'languageInput']) !!}
                                                    {!! Form::hidden('id', null) !!}
                                                </div>
                                                <span id="editLang" class="edit-icon" title="Edit"><i class="fa fa-pencil"></i></span>
                                                <a id="cancelLang" class="cancel-icon" href="javascript:void(0);" style="display:none"><i class="fa fa-times"></i></a>
                                                
                                                <input type="submit" class="btn btn-success" id="saveLang" value="{{ trans('strings.save_button') }}" style="display:none"/>
                                                
                                                {!! Form::close() !!}
                                                
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> <!-- end profile-content -->

                    <div class="about-me">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>About Me :</strong>
                            </div>
                            <div class="col-md-9">
                                {!! Form::model($guide, ['url' => '#', 'role' => 'form', 'id'=>'AboutForm']) !!}
                                                    
                                    <div id="textWrapperAbout" class="field">{{ $guide->about }}</div>
                                    <div id="editInputAbout" class="edit-field" style="display:none">
                                       {!! Form::textarea('about', null, ['size' => '30x5','class' => 'form-control']) !!}
                                        {!! Form::hidden('id', null) !!}
                                    </div>
                                    <span id="editAbout" class="edit-icon" title="Edit"><i class="fa fa-pencil"></i></span>
                                    <a id="cancelAbout" class="cancel-icon" href="javascript:void(0);" style="display:none"><i class="fa fa-times"></i></a>
                                    
                                    <input type="submit" class="btn btn-success" id="saveAbout" value="{{ trans('strings.save_button') }}" style="display:none"/>
                                                    
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="certificate">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Professional License/Certificate</strong>
                            </div>
                            <div class="col-md-9">
                                <div class="certificate-img">
                                    <div class="row">
                                  @foreach ($guide->License as  $gallery)
                                        <div class="col-md-3">
                                            <a class="fancybox" href="{{ asset($gallery->path) }}" data-fancybox-group="gallery" title="License" style="background-image:url({{ asset($gallery->path) }})"></a>
                                            {!! Form::open(['url'=>'#','id'=>'licenseDeleteForm']) !!} 
                                                {!! Form::hidden('id',$gallery->id) !!}
                                                <button type="submit" id="licenseButton" onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i>&times;</i>
                                                </button> 
                                            {!! Form::close() !!}
                                        </div>
                                  @endforeach
                                        <div class="loader-overlay"><div class="custom-loader"></div></div>
                                    </div>
                                     
           

                                </div>
                                @if ($guide->CountLicense < 3)
                                {!! Form::open() !!}
                                  
                                             <div class="licenseInput">
                                             <span class="uploadButton"><i class="fa fa-camera"></i><span>Upload License</span>
                                             <input 
                                                    id="licensePic"
                                                    name="licensePic"
                                                    data-url="{{ route('frontend.guide.license.upload') }}"
                                                    accept="image/*" 
                                                    type="file"></span>
                                                
                                              </div>  
                             {!! Form::close() !!}
                             @endif
                              
                            </div>
                        </div>
                    </div> <!-- end certificate  --> 

                    <div class="video">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Videos</strong>
                            </div>
                            <div class="col-md-9">
                                <div class="video-gallery">
                                    <div class="row">
                                    @foreach ($guide->limitvideos as  $gallery)
                                        <div class="col-md-3">
                                            <a style="background-image:url({{ asset('images/1.jpg') }})" data-fancybox-group="gallery" href="{{ $gallery->path }}?fs=1&amp;autoplay=1" class="video">
                                            </a>
                                        </div>
                                    @endforeach
                                    </div>
                                 </div>
                                <a class="uploadButton" data-toggle="modal" data-target="#video-modal"><i class="fa fa-plus"></i> Upload files</a>
                            </div>
                        </div>
                    </div> <!-- video -->

                    <div class="gallery">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Gallery</strong>
                            </div>
                            <div class="col-md-9">
                                <div class="img-gallery">
                                   @foreach ($guide->limitimages as  $images)
                                        <a class="fancybox" href="{{ asset( $images->path ) }}" data-fancybox-group="gallery" title="{{ $images->caption }} " style="background-image:url({{ asset( $images->path ) }})"></a>
                                    @endforeach
                                </div>
                                 {!! Form::open() !!}
                                  
                                             <div class="galleryInput">
                                             <span class="uploadButton"><i class="fa fa-camera"></i><span>Upload Images</span>
                                             <input 
                                                    id="galleryPic"
                                                    name="galleryPic"
                                                    data-url="{{ route('frontend.guide.gallery.upload') }}"
                                                    accept="image/*" 
                                                    type="file"
                                                    multiple>
                                            </span>
                                                
                                              </div>  
                                              {!! Form::hidden('id', $guide->id) !!}
                             {!! Form::close() !!}
                            </div>
                        </div>
                    </div> <!-- gallery -->

                    <div class="calender">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Calendaraaa</strong>
                            </div>
                            <div class="col-md-9">
                                <div id="booking">
                                  <div class="book-it-content">
                                <form action="#" id="mybookingEditForm" method="POST">
                                {!! Form::token() !!}
                                    <div class="demo first">
                                    <h3 class="selectdates">Select Dates</h3>
                                     <div id="simpliest-usage" class="box"></div>
                                    </div>
                                   {!! Form::hidden('id', $guide->id) !!}     
                                    <div class="form-group">
                                      <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
                                    </div>
                                    </form>
                                  </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- Callender -->
                 
                   
                </div> <!-- end col-md-9 -->
            </div> <!-- end row -->
        </div> <!-- container -->
    </section>
@include('frontend.guide.modal')

@endsection
@section('before-scripts-end')
    <script>
        var language = ['Afrikaans','Albanian','Arabic','Armenian','Azerbaijani','Basque','Belarusian','Bengali','Bosnian','Bulgarian','Burmese','Buryat','Cambodian','Cantonese','Catalan','Croatian','Czech','Danish','Dutch','Dzongkha','English','Esperanto','Estonian','Filipino','Finnish','French','Galician','Georgian','German','Greek','Gujurati','Haitian Creole','Hebrew','Hindi','Hungarian','Icelandic','Indonesian','Irish','Italian','Japanese','Jurchen','Kalmyk','Kannada','Kazakh','Kirghiz','Korean','Lao','Latin','Latvian','Lithuanian','Macedonian','Malay','Malayalam','Maltese','Mandarin','Marathi','Mongolian','Nepali','Norwegian','Persian','Polish','Portuguese','Punjabi','Romanian','Russian','Sakha','Serbian','Slovak','Slovenian','Spanish','Swahili','Swedish','Tamil','Telugu','Thai','Turkish','Ukrainian','Urdu','Vietnamese','Welsh','Yiddish'];

        var guidingArea =['Tour','Safari','Rafting','Peaking-Climbing','Yoga-Meditation','Trekking','Bird-Watching','Advanture-Sports','Cycling'];
    </script>
@stop

@section('after-scripts-end')
    {!! HTML::script('blueimp/load-image.all.min.js') !!}
    {!! HTML::script('blueimp/canvas-to-blob.js') !!}
    {!! HTML::script('blueimp/jquery.iframe-transport.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-process.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-image.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-validate.js') !!}

    {!! HTML::script('js/customUpload.js') !!}
    {!! HTML::script('js/tag-it.min.js') !!}
    {!! HTML::script('js/profile.js') !!}
@stop

@section('after-styles-end')
  {!! HTML::style('blueimp/css/jquery.fileupload.css') !!}
  {!! HTML::style('blueimp/css/jquery.fileupload-ui.css') !!}
    {!! HTML::style('css/jquery.tagit.css') !!}
    {!! HTML::style('css/tagit.ui-zendesk.css') !!}
@stop
