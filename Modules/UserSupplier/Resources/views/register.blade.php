
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
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-box">
    <div class="register-box-body" style="border-radius: 10px;">
      <div class="register-logo">
        <img src="{{asset('images/logo_new.png')}}" alt="Consys">
      </div>
      <form id="form-me" action="{{ route('usersupplier.add') }}"  method="post">
        <img src="{{asset('images/loader.gif')}}" alt="Consys" id="loader" style="display:none;">
          {{ csrf_field() }}
          @include('usersupplier::partials.alert-message')
          @include('usersupplier::partials.alert-errors')
          <div class="form-group {{ $errors->has('bdn_usaha') ? ' has-error' : '' }}">
            <div class="error-global"></div>
            <label>Badan Usaha</label>
              {!!Helper::select_badan_usaha(old('bdn_usaha'))!!}
              @if ($errors->has('bdn_usaha'))
                  <span class="help-block">
                      <strong>{{ $errors->first('bdn_usaha') }}</strong>
                  </span>
              @endif
          </div>


          <div class="form-group {{ $errors->has('company_name') ? ' has-error' : '' }}">
            <label>Nama Perusahaan</label>
            <input type="text" class="form-control" name="company_name" id="company_name" >
            @if ($errors->has('company_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('company_name') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group {{ $errors->has('initial_company_name') ? ' has-error' : '' }}">
            <label>Inisial Perusahaan</label>
            <input type="text" class="form-control" name="initial_company_name" id="initial_company_name"  placeholder="Isi 3 digit inisial Perusahaan">
            @if ($errors->has('initial_company_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('initial_company_name') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label>Password</label>
            <input type="password" class="form-control" name="password" id="password" >
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
            <label>No Telepon</label>
            <input type="text" class="form-control" name="phone" id="phone" >
            @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <label>E-Mail Address</label>
            <input type="text" class="form-control" name="email" id="email" >
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group text-center"><label>Sudah punya akun? <a href="{{url('/login')}}">Login</a></label></div>
          <div class="form-group"> <small>Konfirmasi email dan password akan dikirim melalu email</small></div>
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
    @push('scripts')
    <script>
    $(document).on('submit','#form-me',function (event) {
        event.preventDefault();
        var formMe = $(this)
        $.ajax({
            url: formMe.attr('action'),
            type: 'post',
            data: formMe.serialize(), // Remember that you need to have your csrf token included
            dataType: 'json',
            $('#loader').show();
            success: function( _response ){
              $('#form-modal').modal('show')
            },
            complete: function(){
              $('#loader').hide();
            }

        });
    })
    function reload(){
      location.reload();
    }


    </script>
    @endpush

</html>
