<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ env('APP_NAME') }} {{ $page_title or null }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="{{ mix("css/login.css") }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
  <div class="error-box">
    <!-- /.login-logo -->
    <div class="login-box-body" style="border-radius: 10px;position:relative;">
        <div class="error-text">403</div>
        <div class="error-text-2">Unauthorized action.</div>
        <div class="text-center" style="margin-top:20px;"><a href="{{url('/')}}">Kembali ke Beranda</a></div>
    </div>
    <!-- /.login-box-body -->
  </div>


<script src="{{ mix('js/login.js') }}"></script>
@stack('scripts')
</body>
</html>