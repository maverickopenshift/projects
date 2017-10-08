<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Dashboard SRM') }} | Register Supplier</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <!-- /.login-logo -->
    <div class="register-box-body" style="border-radius: 10px;">
      <div class="register-logo">
          <img src="images/logo.png" alt="Consys">
      </div>

    <form action="{{ url('/login') }}" method="post">
      {{ csrf_field() }}
      @if ($errors->has('error'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ $errors->first('error') }}
      </div>
      @endif
      <div class="form-group {{ $errors->has('bdn_usaha') ? ' has-error' : '' }}">
        <label>Badan Usaha</label>
        <select class="form-control" name="bdn_usaha">
          <option value="PT" {{ old('bdn_usaha')=='PT'?"selected='selected'":"" }}>PT</option>
          <option value="CV" {{ old('bdn_usaha')=='CV'?"selected='selected'":"" }}>CV</option>
        </select>
        @if ($errors->has('bdn_usaha'))
            <span class="help-block">
                <strong>{{ $errors->first('bdn_usaha') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group {{ $errors->has('nm_vendor') ? ' has-error' : '' }}">
        <label>Nama Perusahaan</label>
        <input type="text" class="form-control" name="nm_vendor" value="{{ old('nm_vendor') }}" required>
        @if ($errors->has('nm_vendor'))
            <span class="help-block">
                <strong>{{ $errors->first('nm_vendor') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group {{ $errors->has('nm_vendor_uq') ? ' has-error' : '' }}">
        <label>Inisial Perusahaan</label>
        <input type="text" class="form-control" name="nm_vendor_uq" value="{{ old('nm_vendor_uq') }}" required placeholder="Isi 3 digit inisial Perusahaan">
        @if ($errors->has('nm_vendor_uq'))
            <span class="help-block">
                <strong>{{ $errors->first('nm_vendor_uq') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label>Password</label>
        <input type="text" class="form-control" name="password" required>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
        <label>No Tlp Flexi</label>
        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
        @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        <label>E-Mail Address</label>
        <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group"> <small>Konfirmasi email dan password akan dikirim melalu email</small>
      </div>
      <div class="form-group"> <button type="submit" class="btn btn-danger btn-block btn-flat">Simpan</button>
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
