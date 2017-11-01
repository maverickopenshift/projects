@extends('layouts.app')

@section('content')
@include('usersupplier::partials.alert-message')
@include('usersupplier::partials.alert-errors')
<form action="{{ route('home.profile.update') }}" method="post" id="form-me">
    {{ csrf_field() }}
<div class="box">
    <div class="box-header with-border border-bottom-red">
      <h3 class="box-title text-red">Ubah Profil User</h3>
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
                    <input type="hidden" class="form-control" id="tipe"  name="tipe" value="prof">
                    <input type="hidden" class="form-control" id="id"  name="id" value="{{$data['id']}}">
                    <input type="text" class="form-control" id="user_id" disabled="true" name="user_id" value="{{$data['username']}}">
                  </div>
                </div>
                <div class="form-group {{ $errors->has('nama_user') ? ' has-error' : '' }}">
                  <label for="nama_user" class="col-sm-4 control-label">Nama</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama_user" name="nama_user" value="{{ old('nama_user',Helper::prop_exists($data,'name')) }}">
                    @if ($errors->has('nama_user'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nama_user') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email" class="col-sm-4 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email',Helper::prop_exists($data,'email')) }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                  <label for="phone" class="col-sm-4 control-label">No Telepon</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone',Helper::prop_exists($data,'phone')) }}">
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
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

</form>

<form action="{{ route('home.profile.update') }}" method="post" id="form-me">
    {{ csrf_field() }}
<div class="box">
    <div class="box-header with-border border-bottom-red">
      <h3 class="box-title text-red">Ubah Password User</h3>

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
                <div class="form-group {{ $errors->has('Password') ? ' has-error' : '' }}">
                  <label for="Password" class="col-sm-4 control-label">Password Lama</label>
                  <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="tipe"  name="tipe" value="pwd">
                    <input type="hidden" class="form-control" id="id"  name="id" value="{{$data['id']}}">
                    <input type="password" class="form-control" id="Password" name="Password" value="{{ old('password') }}" autocomplete="off">
                    @if ($errors->has('Password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Password') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group {{ $errors->has('new_password') ? ' has-error' : '' }}">
                  <label for="new_password" class="col-sm-4 control-label">Password Baru</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="new_password" name="new_password"  value="{{ old('new_password') }}" autocomplete="off">
                    @if ($errors->has('new_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_password') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <label for="password_confirmation" class="col-sm-4 control-label">Konfirmasi Password Baru</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="off">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
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
