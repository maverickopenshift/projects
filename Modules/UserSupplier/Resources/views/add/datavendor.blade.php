<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Vendor
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
        <div class="form-group {{ $errors->has('alamat') ? ' has-error' : '' }}">
          <label class="col-sm-2 control-label"><span class="text-red">*</span> Alamat</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" name="alamat" placeholder="Masukan Alamat">{{ old('alamat') }}</textarea>
            @if ($errors->has('alamat'))
                <span class="help-block">
                    <strong>{{ $errors->first('alamat') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="form-group {{ $errors->has('kota') ? ' has-error' : '' }} {{ $errors->has('kd_pos') ? ' has-error' : '' }}">
          <label class="col-sm-2 control-label"><span class="text-red">*</span> Kota -  Kode Pos</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="kota" value="{{ old('kota') }}" placeholder="Masukan Kota" autocomplete="off">
            @if ($errors->has('kota'))
                <div class="help-block">
                    <strong>{{ $errors->first('kota') }}</strong>
                </div>
            @endif
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="kd_pos" value="{{ old('kd_pos') }}"  placeholder="Masukan Kode Pos" autocomplete="off">
            @if ($errors->has('kd_pos'))
                <div class="help-block">
                    <strong>{{ $errors->first('kd_pos') }}</strong>
                </div>
            @endif
          </div>
        </div>
        <div class="form-group {{ $errors->has('telepn') ? ' has-error' : '' }} {{ $errors->has('fax') ? ' has-error' : '' }}">
          <label class="col-sm-2 control-label"><span class="text-red">*</span> Telepon - Faximili</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="telepon" value="{{$datas['phone']}}" placeholder="Masukan Telepon" autocomplete="off">
            @if ($errors->has('telepon'))
                <div class="help-block">
                    <strong>{{ $errors->first('telepon') }}</strong>
                </div>
            @endif
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="fax" value="{{ old('fax') }}"  placeholder="Masukan Faximili" autocomplete="off">
            @if ($errors->has('fax'))
                <div class="help-block">
                    <strong>{{ $errors->first('fax') }}</strong>
                </div>
            @endif
          </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="email" class="col-sm-2 control-label"><span class="text-red">*</span> Email Address</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="email" value="{{$datas['email']}}"  placeholder="Masukan Email Address" autocomplete="off">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="form-group {{ $errors->has('web_site') ? ' has-error' : '' }}">
          <label for="web_site" class="col-sm-2 control-label">Websites</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="web_site" value="{{ old('web_site') }}"  placeholder="Masukan Websites" autocomplete="off">
            @if ($errors->has('web_site'))
                <span class="help-block">
                    <strong>{{ $errors->first('web_site') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="form-group {{ $errors->has('induk_perus') ? ' has-error' : '' }}">
          <label for="induk_perus" class="col-sm-2 control-label">Induk Perusahaan</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="induk_perus" value="{{ old('induk_perus') }}"  placeholder="Masukan Induk Perusahaan" autocomplete="off">
            @if ($errors->has('induk_perus'))
                <span class="help-block">
                    <strong>{{ $errors->first('induk_perus') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="form-group {{ $errors->has('anak_perusahaan.*') ? ' has-error' : '' }}">
          <label for="anak_perusahaan" class="col-sm-2 control-label">Anak Perusahaan</label>
          <div class="col-sm-10">
            @if(count(old('anak_perusahaan'))>0)
              @foreach (old('anak_perusahaan') as $key => $value)
                <div class="input-group bottom15 ">
                  <input type="text" class="form-control anak_perusahaan" name="anak_perusahaan[]" value="{{$value}}" autocomplete="off">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default add-anak_perusahaan"><i class="glyphicon glyphicon-plus"></i></button>
                    @if(count(old('anak_perusahaan'))>1)
                      <button type="button" class="btn btn-default delete-anak_perusahaan"><i class="glyphicon glyphicon-trash"></i></button>
                    @endif
                  </div>
                </div>
                @if ($errors->has('anak_perusahaan.'.$key))
                    <span class="help-block">
                        <strong>{{ $errors->first('anak_perusahaan.'.$key) }}</strong>
                    </span>
                @endif
              @endforeach
            @else
              <div class="input-group bottom15">
                <input type="text" class="form-control anak_perusahaan" name="anak_perusahaan[]" autocomplete="off">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default add-anak_perusahaan"><i class="glyphicon glyphicon-plus"></i></button>
                </div>
              </div>
              @if ($errors->has('anak_perusahaan'))
                  <span class="help-block">
                      <strong>{{ $errors->first('anak_perusahaan') }}</strong>
                  </span>
              @endif
            @endif
          </div>
        </div>
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function(){
  add_select('anak_perusahaan');
  delete_select('anak_perusahaan');
});
</script>
@endpush
