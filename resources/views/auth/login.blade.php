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
  <style>
    .loading-login{
      background-image: url(images/loader.gif);background-color: rgba(255,255,255,0.6);position: absolute;width: 100%;height: 100%;z-index: 1;background-repeat: no-repeat;background-position: center center;display: none;top:0;left:0;border-radius: 10px;
    }
  </style>
  <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
  </script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
    <div class="login-box-body" style="border-radius: 10px;position:relative;">
      <div class="loading-login"></div>
      <div class="login-logo">
          <img src="images/logo_new.png" alt="Consys">
      </div>

    <form action="#" id="form-login" data-action="{{route('login.ajax')}}" method="post">
      {{ csrf_field() }}
      <div class="alert alert-danger alert-dismissible alert-login" style="display:none;">
      </div>
      <div class="form-group">
        <label>User ID</label>
        <input type="text" class="form-control" name="login" required autofocus>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
            <div class="text-center">
                <label>
                  <a href="{{route('usersupplier.register')}}">Create User ID</a> | <a href="{{route('usersupplier.forgetpwd')}}">Forget Password</a>
                    <!-- <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me -->
                </label>
            </div>
        </div>
        <div class="col-xs-12">
          <button type="submit" class="btn btn-danger btn-block btn-flat">LOGIN</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <form action="#" id="form-pgs" data-action="{{route('home.pgschange')}}" method="post" style=display:none;>
      {{ csrf_field() }}
      <div class="alert alert-danger alert-dismissible alert-login" style="display:none;">
      </div>
      <div class="form-group">
        <select class="form-control roles" name="roles" required>
          <option value="">Pilih Roles</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-danger btn-block btn-flat">SUBMIT</button>
      </div>
        <!-- /.col -->
    </form>
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
  $(document).on('submit', '#form-login', function(event) {
    event.preventDefault();
    /* Act on the event */
    var formMe = $(this);
    var formPgs = $('#form-pgs');
    var loginBox = $('.login-box-body');
    var loading =loginBox.find('.loading-login');
    loading.show();
    var alert = loginBox.find('.alert-login');
    alert.hide().html('');
    var pgsRoles = formPgs.find('select.roles');
    pgsRoles.find('option[value!=""]').remove();
    $.ajax({
      url: formMe.data('action'),
      type: 'post',
      dataType: 'json',
      data: formMe.serialize()
    })
    .done(function(_response) {
      if(_response.status){
        if(_response.pgs){
          loading.hide();
          formMe.hide();
          pgsRoles.append('<option value="'+_response.pgs_list[0].id+'">'+_response.pgs_list[0].title+'</option>');
          pgsRoles.append('<option value="'+_response.pgs_list[1].id+'">'+_response.pgs_list[1].title+'</option>');
          formPgs.show();
        }
        else{
          window.location = '{!!route('home')!!}';
        }
      }
      else{
        alert.show().html(_response.msg);
        loading.hide();
      }
    });

  });
  $(document).on('submit', '#form-pgs', function(event) {
    event.preventDefault();
    /* Act on the event */
    var formPgs = $(this);
    var loginBox = $('.login-box-body');
    var loading =loginBox.find('.loading-login');
    loading.show();
    var alert = loginBox.find('.alert-login');
    alert.hide().html('');
    $.ajax({
      url: formPgs.data('action'),
      type: 'post',
      dataType: 'json',
      data: formPgs.serialize()
    })
    .done(function(_response) {
      if(_response.status){
          window.location = '{!!route('home')!!}';
      }
      else{
        alert.show().html(_response.msg);
        loading.hide();
      }
    });
  });
</script>
</body>
</html>
