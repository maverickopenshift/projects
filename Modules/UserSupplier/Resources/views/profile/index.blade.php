@extends('layouts.app')
@section('content')
<form method="post" action="#">
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
                    <input type="hidden" class="form-control" id="id" disabled="true" name="doc_title" value="{{$data['id']}}">
                    <input type="text" class="form-control" id="user_id" disabled="true" name="user_id" placeholder="Masukan Data" value="{{$data['username']}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_number" class="col-sm-4 control-label">Nomer Flexi</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="phone" value="{{$data['phone']}}" name="phone" placeholder="Masukan Data">
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_roles" class="col-sm-4 control-label">Password Lama</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="pwd_lama" name="pwd_lama" placeholder="Masukan Data" value="i">
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_mitra" class="col-sm-4 control-label">Password Baru</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="pwd_baru" name="pwd_baru"  value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_mitra" class="col-sm-4 control-label">Konfirmasi Password Baru</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="konf_pwd_baru" name="konf_pwd_baru" >
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
