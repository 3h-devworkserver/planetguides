<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <meta name="_token" content="{{ csrf_token() }}" />
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'GuideNp')">
        <meta name="author" content="@yield('author', 'GuideNp')">
        @yield('meta')

        @yield('before-styles-end')
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
        {!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
         {!! HTML::style('css/backend/mdp.css') !!}
        {!! HTML::style('css/backend/prettify.css') !!}
        {!! HTML::style('css/backend/AdminLTE.min.css') !!}
        {!! HTML::style('css/bootstrap.css') !!}
        {!! HTML::style('css/backend/chosen.min.css') !!}
        {!! HTML::style('css/jquery.datepick.css') !!}
        {!! HTML::style('css/backend/jquery.wizard.min.css') !!}
        {!! HTML::style('css/backend/skin-blue.min.css') !!}
        {!! HTML::style('css/backend/skin-orange.css') !!}
        {!! HTML::style('css/jquery.dataTables.min.css') !!}
        {!! HTML::style('css/backend/custom.css') !!}
        {!! HTML::style('css/backend/blue.css') !!}
        {{-- {!! HTML::style('css/backend/stylee.css') !!} --}}
        @yield('after-styles-end')

        {!! HTML::script('js/jquery-1.11.2.min.js') !!}
        {!! HTML::script('js/jquery-ui.js') !!}
        {!! HTML::script('js/backend/jquery-ui.multidatespicker.js') !!}

        <!-- DataTables -->
          {!! HTML::script('js/backend/jquery.dataTables.min.js') !!}
          {!! HTML::script('js/backend/chosen.jquery.min.js') !!}
          {!! HTML::script('js/backend/moment.js') !!}
          <!-- {!! HTML::script('js/backend/jquery.wizard.js') !!} -->
          {!! HTML::script('js/backend/wizardformtab.js') !!}

       <script>
          var base_url = '{{ URL::to("") }}';
          var full_current_url = '{{ URL::full() }}';
          var current_url = '{{ URL::current() }}';
        </script>
        <script type="text/javascript">
          $(document).ready(function(){
            $("select.chosen-select").chosen();
           

//             $(function() {
//     $('input[name="daterange"]').daterangepicker();
// });
                    })
        </script>
        {!! HTML::script('js/backend/lang-css.js') !!}
  {!! HTML::script('js/backend/prettify.js') !!}
     
        
    </head>
    <body class="hold-transition skin-orange sidebar-mini">
        <div class="wrapper">
          @include('backend.includes.header')
          @include('backend.includes.sidebar')

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              @yield('page-header')
              <ol class="breadcrumb">
                @yield('breadcrumbs')
              </ol>
            </section>

            <!-- Main content -->
            <section class="content">
              @include('includes.partials.messages')
              @include('flash::message')
              @yield('content')
            </section><!-- /.content -->
          </div><!-- /.content-wrapper -->

          @include('backend.includes.footer')
        </div><!-- ./wrapper -->
       @yield('before-scripts-end')
    
        
       
        @yield('after-scripts-end')
        {!! HTML::script('js/vendor/bootstrap.min.js') !!}
        {!! HTML::script('js/backend/custom.js') !!}
        {!! HTML::script('js/backend/app.js') !!}
        {!! HTML::script('js/backend/icheck.min.js') !!}
        
    </body>
</html>
