<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'Default Description')">
    <meta name="author" content="@yield('author', 'Anthony Rappa')">
    @yield('meta')

{!! HTML::style(asset('font-awesome-4.4.0/css/font-awesome.min.css')) !!}

     @yield('before-styles-end')
    {!! HTML::style(asset('css/normalize.css')) !!}
    {!! HTML::style(asset('css/bootstrap.css')) !!}
    {!! HTML::style(asset('css/sumoselect.css')) !!}
    {!! HTML::style(asset('css/style.css')) !!}
     @yield('after-styles-end')

  
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- Icons-->
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    


	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,800italic,800,700italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Poppins:400,700,600,500,300' rel='stylesheet' type='text/css'>
	
</head>
<body class="home">
 <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        @include('frontend.includes.nav')
        @yield('content')
        @include('frontend.includes.footer')

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
        {!! HTML::script('js/vendor/bootstrap.min.js') !!}

        @yield('before-scripts-end')
        {!! HTML::script(asset('js/custom.js')) !!}
        {!! HTML::script(asset('js/jquery.sumoselect.min.js')) !!}
        @yield('after-scripts-end')

        @include('includes.partials.ga')
    </body>
</html>