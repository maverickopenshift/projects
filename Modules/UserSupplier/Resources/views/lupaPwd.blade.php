
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Dashboard SRM') }} | Forget Password Supplier</title>
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
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-box">
    <div class="register-box-body" style="border-radius: 10px;">
      <div class="loading2"></div>
      <div class="register-logo">
        <img src="{{asset('images/logo_new.png')}}" alt="Consys">
      </div>
      <form id="form-me" action="{{ route('usersupplier.forgetpwd.check') }}"  method="post">
          {{ csrf_field() }}
          <div class="alert alert-danger alert-dismissible forgetpwd-alert" style="display:none;">
          </div>
          <div class="alert alert-success alert-dismissible forgetpwd-sukses-alert" style="display:none;">
          </div>
          @include('usersupplier::partials.alert-message')
          @include('usersupplier::partials.alert-errors')
          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <label>E-Mail Address</label>
            <input type="text" class="form-control" name="email" id="email" value="{{old('email')}}">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group text-center"><label>Sudah punya akun? <a href="{{url('/login')}}">Login</a></label></div>
          <div class="form-group"> <small>Password akan dikirim melalu email</small></div>
          <div class="form-group"> <button type="submit" class="btn btn-danger btn-block btn-flat btn-save" data-loading-text="Please wait..." autocomplete="off" id="bnt_simpan">Simpan</button></div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Success</h4>
            </div>
            <div class="modal-body">
              <p>Data berhasil tersimpan. <br><br> Silahkan Cek email anda untuk info Username</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reload(); return false;">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</body>
    <!-- /.login-box -->
    <script src="{{ mix('js/login.js') }}"></script>
    <script>
    $(document).on('submit','#form-me',function (event) {
        event.preventDefault();
        var formMe = $(this);
        var box = $('.register-box-body');
        var loading = box.find('.loading2');
        var alert = box.find('.forgetpwd-alert');
        var alert_sukses = box.find('.forgetpwd-sukses-alert');
        alert.hide().html('');
        alert_sukses.hide().html('');
        loading.show();
        $.ajax({
            url: formMe.attr('action'),
            type: 'post',
            data: formMe.serialize(), // Remember that you need to have your csrf token included
            dataType: 'json',

            // success: function( _response ){
            //   $('#form-modal').modal('show')
            // },
            // complete: function(){
            //   $('#loader').hide();
            // }

        }).done(function(_response) {
          if(_response.status){
            alert_sukses.show().html(_response.msg);
            loading.hide();
          }
          else{
            alert.show().html(_response.msg);
            loading.hide();
          }
        });
    })
    // function reload(){
    //   location.reload();
    // }


    </script>


</html>
