<script src="{{ mix('js/all.js') }}"></script>
<script>
// function us(){
//   var usernm = ""
// }
function add(){
  var bdn_usaha = $("#bdn_usaha").val();
  var nm_vendor = $("#nm_vendor").val();
  var nm_vendor_uq = $("#nm_vendor_uq").val();
  var password = $("#password").val();
  var phone = $("#phone").val();
  var email = $("#email").val();
  var username = $("#username").val();

  // var data = $("#form-me").serialize();
  $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url: "{{ route('usersupplier.add') }}",
      type: 'post',
      data: { 'bdn_usaha': bdn_usaha, 'nm_vendor': nm_vendor, 'nm_vendor_uq': nm_vendor_uq, 'password': password, 'phone': phone, 'email': email, 'username': username  }, // Remember that you need to have your csrf token included
      dataType: 'json',
      success: function( _response ){
        document.getElementById("form-me").reset();
        $('#form-modal').modal('show');
      }

  });
  }

  function reload(){
    location.reload();
  }
</script>
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
      <form id="form-me" onsubmit="add(); return false;"  method="post">

          {{ csrf_field() }}
          <?php
           $users = \DB::table('users')
           ->select(DB::raw('count(id) as jum'))
           ->where('username', 'like', '%VR%')->get();

           foreach ($users as $usr) {
            $jml= $usr->jum; //hasil query
            $tot= $jml+1;
            $us= "VR00".$tot;
          }
           ?>
          <input type="hidden" class="form-control" name="username" id="username" value="<?php echo $us; ?>" required>
          <div class="form-group">
            <div class="error-global"></div>
            <label>Badan Usaha</label>
            <select class="form-control" name="bdn_usaha" id="bdn_usaha">
              <option value="PT">PT</option>
              <option value="CV">CV</option>
            </select>
            <div class="error-bdn_usaha"></div>
          </div>

          <div class="form-group">
            <label>Nama Perusahaan</label>
            <input type="text" class="form-control" name="nm_vendor" id="nm_vendor" required>
            <div class="error-nm_vendor"></div>
          </div>

          <div class="form-group">
            <label>Inisial Perusahaan</label>
            <input type="text" class="form-control" name="nm_vendor_uq" id="nm_vendor_uq" required placeholder="Isi 3 digit inisial Perusahaan">
            <div class="error-nm_vendor_uq"></div>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
            <div class="error-password"></div>
          </div>

          <div class="form-group">
            <label>No Tlp Flexi</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
            <div class="error-phone"></div>
          </div>

          <div class="form-group">
            <label>E-Mail Address</label>
            <input type="text" class="form-control" name="email" id="email" required>
            <div class="error-email"></div>
          </div>

          <div class="form-group text-center"><label>Sudah punya akun? <a href="{{url('/login')}}">Login</a></label></div>
          <div class="form-group"> <small>Konfirmasi email dan password akan dikirim melalu email</small></div>
          <div class="form-group"> <button type="submit" class="btn btn-danger btn-block btn-flat" id="bnt_simpan">Simpan</button></div>
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
              <p>Data berhasil tersimpan</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reload(); return false;">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</body>
    <!-- /.login-box -->

  <!--  <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>-->
</html>
