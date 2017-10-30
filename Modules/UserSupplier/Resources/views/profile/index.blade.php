@extends('layouts.app')
@section('content')
<form method="post" action="#" id="form-me">
    {{ csrf_field() }}
<div class="box">
    <div class="box-header with-border border-bottom-red">
      <h3 class="box-title text-red">Ubah Password</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif


          <div class="row">
            <div class="col-sm-12">
              <div  class="form-horizontal">
                <div class="form-group">
                  <label for="doc_title" class="col-sm-4 control-label">User ID</label>
                  <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="id"  name="id" value="{{$data['id']}}">
                    <input type="text" class="form-control" id="user_id" disabled="true" name="user_id" value="{{$data['username']}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_number" class="col-sm-4 control-label">Nomer Telepon</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="phone" value="{{$data['phone']}}" name="phone">
                    <div class="error-phone"></div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_roles" class="col-sm-4 control-label">Password Lama</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="Password" name="Password">
                    <div class="error-Password"></div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_mitra" class="col-sm-4 control-label">Password Baru</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="new_password" name="new_password"  value="">
                    <div class="error-Password_Baru"></div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_mitra" class="col-sm-4 control-label">Konfirmasi Password Baru</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" >
                    <div class="error-Konfirmasi_Password"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="pull-right">
                      <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
                </div>
                </div>
              </div>
            </div>
          </div>
</div>
<!-- /.box-body -->
</div>
</form>
<div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
              <p>Password Anda Telah Berhasil Diubah</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reload(); return false;">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="{{ mix('js/all.js') }}"></script>
<script>
    $(function() {
        var formModal = $('#form-modal');
        $(document).on('submit','#form-me',function (event) {
          event.preventDefault();
          var formMe = $(this)
          var attErrorPhone = formMe.find('.error-phone')
          var attErrorPassword = formMe.find('.error-Password')
          var attErrorPassword_Baru = formMe.find('.error-Password_Baru')
          var attErrorKonfirmasi_Password = formMe.find('.error-Konfirmasi_Password')
          attErrorPhone.html('')
          attErrorPassword.html('')
          attErrorPassword_Baru.html('')
          attErrorKonfirmasi_Password.html('')
          // var btnSave = formMe.find('.btn-save')
          // btnSave.button('loading')
          $.ajax({
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              url: "{{ route('profile.update') }}",
              type: 'post',
              data: formMe.serialize(), // Remember that you need to have your csrf token included
              dataType: 'json',
              success: function( _response ){
                  // Handle your response..
                  console.log(_response)
                  if(_response.errors){
                      if(_response.errors.phone){
                          attErrorPhone.html('<span class="text-danger">'+_response.errors.phone+'</span>');
                      }
                      if(_response.errors.Password){
                          attErrorPassword.html('<span class="text-danger">'+_response.errors.Password+'</span>');
                      }
                      if(_response.errors.new_password){
                          attErrorPassword_Baru.html('<span class="text-danger">'+_response.errors.new_password+'</span>');
                      }
                      if(_response.errors.password_confirmation){
                          attErrorKonfirmasi_Password.html('<span class="text-danger">'+_response.errors.password_confirmation+'</span>');
                      }
                      if(_response.errors.password_confirmation){
                          attErrorKonfirmasi_Password.html('<span class="text-danger">'+_response.errors.password_confirmation+'</span>');
                      }
                  }
                  else{
                      $('#form-modal').modal('show')
                  }
              },
              error: function( _response ){
                alert("error1");
              }
          });
          })
        });

          function reload(){
            location.reload();
          }
    </script>
@endsection
