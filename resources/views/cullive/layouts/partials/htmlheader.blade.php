<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <title>{{ trans('message.description') }}</title>
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('/adminlte/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css') }}">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fullcalendar/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
  <!-- Morris charts -->
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/morris/morris.css') }}">
  <!-- bootstrap slider -->
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/bootstrap-slider/slider.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/skins/skin-blue.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
</head>
