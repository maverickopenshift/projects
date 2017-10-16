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
        <img src="{{asset('images/logo.png')}}" alt="Consys">
      </div>
      <form id="form-me" action="{!! route('usersupplier.add') !!}" method="post">
          {{ csrf_field() }}
          <div class="form-group">
            <div class="error-global"></div>
            <label>Badan Usaha</label>
            <select class="form-control" name="bdn_usaha">
              <option value="PT">PT</option>
              <option value="CV">CV</option>
            </select>
            <div class="error-bdn_usaha"></div>
          </div>
          <div class="form-group">
            <label>Nama Perusahaan</label>
            <input type="text" class="form-control" name="nm_vendor" required>
            <div class="error-nm_vendor"></div>
          </div>
          <div class="form-group">
            <label>Inisial Perusahaan</label>
            <input type="text" class="form-control" name="nm_vendor_uq" required placeholder="Isi 3 digit inisial Perusahaan">
            <div class="error-nm_vendor_uq"></div>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" required>
            <div class="error-password"></div>
          </div>

          <div class="form-group">
            <label>No Tlp Flexi</label>
            <input type="text" class="form-control" name="phone" required>
            <div class="error-phone"></div>
          </div>
          <div class="form-group">
            <label>E-Mail Address</label>
            <input type="text" class="form-control" name="email" required>
            <div class="error-email"></div>
          </div>
          <div class="form-group text-center"><label>Sudah punya akun? <a href="{{url('/login')}}">Login</a></label></div>
          <div class="form-group"> <small>Konfirmasi email dan password akan dikirim melalu email</small></div>
          <div class="form-group"> <button type="submit" class="btn btn-danger btn-block btn-flat btn-save">Simpan</button></div>
      </form>
    </div>
  </div>
</div>
</body>
    <!-- /.login-box -->

    <!-- <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script> -->
    @push('scripts')
    <script>
        $(function() {
          $(document).on('submit','#form-me',function (event) {
              event.preventDefault();
              var formMe = $(this)
              var attErrorBdn_usaha     = formMe.find('.error-bdn_usaha')
              var attErrorNm_vendor     = formMe.find('.error-nm_vendor')
              var attErrorNm_vendor_uq  = formMe.find('.error-nm_vendor_uq')
              var attErrorPassword      = formMe.find('.error-password')
              var attErrorPhone         = formMe.find('.error-phone')
              var attErrorEmail         = formMe.find('.error-email')
              attErrorBdn_usaha.html('')
              attErrorNm_vendor.html('')
              attErrorNm_vendor_uq.html('')
              attErrorPassword.html('')
              attErrorPhone.html('')
              attErrorEmail.html('')
              var btnSave = formMe.find('.btn-save')
              btnSave.button('loading')
              $.ajax({
                  url: formMe.attr('action'),
                  type: 'post',
                  data: formMe.serialize(), // Remember that you need to have your csrf token included
                  dataType: 'json',
                  success: function( _response ){
                      // Handle your response..
                      console.log(_response)
                      if(_response.errors){
                          if(_response.errors.bdn_usaha){
                              attErrorBdn_usaha.html('<span class="text-danger">'+_response.errors.bdn_usaha+'</span>');
                          }
                          if(_response.errors.nm_vendor){
                              attErrorNm_vendor.html('<span class="text-danger">'+_response.errors.nm_vendor+'</span>');
                          }
                          if(_response.errors.nm_vendor_uq){
                              attErrorNm_vendor_uq.html('<span class="text-danger">'+_response.errors.nm_vendor_uq+'</span>');
                          }
                          if(_response.errors.password){
                              attErrorPassword.html('<span class="text-danger">'+_response.errors.password+'</span>');
                          }
                          if(_response.errors.phone){
                              attErrorPhone.html('<span class="text-danger">'+_response.errors.phone+'</span>');
                          }
                          if(_response.errors.email){
                              attErrorEmail.html('<span class="text-danger">'+_response.errors.email+'</span>');
                          }
                      }
                      else{
                      alertBS('Data successfully added','success')
                    }
                    btnSave.button('reset')
                  },
                  error: function( _response ){
                      // Handle error
                      btnSave.button('reset')
                      alertBS('Something wrong, please try again','danger')
                  }
              });
          })
          });
      </script>
      @endpush
  </body>
</html>
