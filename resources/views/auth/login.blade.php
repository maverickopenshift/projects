<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Dashboard SRM') }} | Log in</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link href="{{ mix("css/login.css") }}" rel="stylesheet" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
  </script>
</head>
<body class="hold-transition login-page" style="background-image:url('img/bg_chatbot.jpg');height: auto">
<div class="login-box">
  <!-- /.login-logo -->
    <div class="login-box-body" style="background: none">
        <div class="login-logo">
        <!-- <img src="img/logo_nestle.png"> -->
        </div>
    </div>
    <div class="login-box-body" style="border-radius: 10px;">
      <div class="login-logo">
        <b>Dashboard</b>SRM
      </div>

    <form action="{{ url('/login') }}" method="post">
      {{ csrf_field() }}
      @if ($errors->has('error'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ $errors->first('error') }}
      </div>
      @endif
      <div class="form-group {{ $errors->has('login') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="login" placeholder="Email or Username" value="{{ old('login') }}" required autofocus>
        @if ($errors->has('login'))
            <span class="help-block">
                <strong>{{ $errors->first('login') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-8">
            <div class="checkbox">
                <label>
                    <!-- <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me -->
                </label>
            </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-warning btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- <a href="{{ url('/password/reset') }}" class="text-center">Forgot Your Password?</a> -->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="{{ mix('js/login.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>