<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta_description', 'Default Description')">
    <meta name="author" content="@yield('author', 'GuideNp')">
    @yield('meta')
    @yield('before-styles-end')
    @include('frontend.includes.styles')
    @yield('after-styles-end')
    
    {!! HTML::script('js/jquery-1.11.2.min.js') !!}
    {!! HTML::script('js/backend/jquery.dataTables.min.js') !!}
    <script>
        var base_url = '{{ URL::to("") }}';
        var full_current_url = '{{ URL::full() }}';
        var current_url = '{{ URL::current() }}';
    </script>

</head>
<body class="{{ $class }}">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    @include('frontend.includes.header')
    
    
    
    <div class="main-container">
                      
            @yield('content')
        
    </div><!--end main-container-->

@include('frontend.includes.footer')
@include('frontend.includes.popup')
@yield('before-scripts-end')
@include('frontend.includes.script')
@yield('after-scripts-end')


</body>
</html>