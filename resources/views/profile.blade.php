@extends('layouts.app')

@section('content')
<form action="{{ route('home.profile.update') }}" method="post" id="form-me">
    {{ csrf_field() }}
<div class="box">
    <div class="box-header with-border border-bottom-red">
      <h3 class="box-title text-red">Ubah Profil User</h3>

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
                  <label for="doc_title" class="col-sm-4 control-label">Username</label>
                  <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="id"  name="id" value="{{$data['id']}}">
                    <input type="text" class="form-control" id="user_id" disabled="true" name="user_id" value="{{$data['username']}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_title" class="col-sm-4 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" name="email" value="{{$data['email']}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_title" class="col-sm-4 control-label">No Telepon</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="phone" name="phone" value="{{$data['phone']}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_roles" class="col-sm-4 control-label">Password Lama</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="Password" name="Password" value="">
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
@endsection
