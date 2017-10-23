<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Employee Detail
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group {{ $errors->has('nm_direktur_utama') ? ' has-error' : '' }}">
            <label for="nm_direktur_utama" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Direktur Utama</label>
            <div class="col-sm-10">
                <input type="text" name="nm_direktur_utama" value="{{old('nm_direktur_utama')}}" class="form-control" placeholder="" autocomplete="off">
              @if ($errors->has('nm_direktur_utama'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nm_direktur_utama') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('nm_komisaris_utama') ? ' has-error' : '' }}">
            <label for="nm_komisaris_utama" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Komisaris Utama</label>
            <div class="col-sm-10">
                <input type="text" name="nm_komisaris_utama" value="{{old('nm_komisaris_utama')}}" class="form-control" placeholder="" autocomplete="off">
              @if ($errors->has('nm_komisaris_utama'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nm_komisaris_utama') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Contact Person</label>
            <div class="col-sm-10">
            </div>
            <div class="clearfix"></div>
            <hr  />
          </div>
          <div class="form-group {{ $errors->has('cp1_nama') ? ' has-error' : '' }}">
            <label for="cp1_nama" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="cp1_nama" value="{{ old('cp1_nama') }}" placeholder="" autocomplete="off">
              @if ($errors->has('cp1_nama'))
                  <div class="help-block">
                      <strong>{{ $errors->first('cp1_nama') }}</strong>
                  </div>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('cp1_telp') ? ' has-error' : '' }}">
            <label for="cp1_telp" class="col-sm-2 control-label">No Telepon</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="cp1_telp" value="{{ old('cp1_telp') }}" placeholder="" autocomplete="off">
              @if ($errors->has('cp1_telp'))
                  <div class="help-block">
                      <strong>{{ $errors->first('cp1_telp') }}</strong>
                  </div>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('cp1_email') ? ' has-error' : '' }}">
            <label for="cp1_email" class="col-sm-2 control-label">Alamat Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="cp1_email" value="{{ old('cp1_email') }}" placeholder="" autocomplete="off">
              @if ($errors->has('cp1_email'))
                  <div class="help-block">
                      <strong>{{ $errors->first('cp1_email') }}</strong>
                  </div>
              @endif
            </div>
          </div>
          <div class="form-group">
            <hr  />
          </div>
          <div class="form-group {{ $errors->has('jml_peg_domestik') ? ' has-error' : '' }}">
            <label for="jml_peg_domestik" class="col-sm-2 control-label"><span class="text-red">*</span> Jumlah Pegawai Domestik</label>
            <div class="col-sm-10">
                <input type="text" name="jml_peg_domestik" value="{{old('jml_peg_domestik')}}" class="form-control" placeholder="" autocomplete="off">
              @if ($errors->has('jml_peg_domestik'))
                  <span class="help-block">
                      <strong>{{ $errors->first('jml_peg_domestik') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('jml_peg_asing') ? ' has-error' : '' }}">
            <label for="jml_peg_asing" class="col-sm-2 control-label"><span class="text-red">*</span> Jumlah Pegawai Asing</label>
            <div class="col-sm-10">
                <input type="text" name="jml_peg_asing" value="{{old('jml_peg_asing')}}" class="form-control" placeholder="" autocomplete="off">
              @if ($errors->has('jml_peg_asing'))
                  <span class="help-block">
                      <strong>{{ $errors->first('jml_peg_asing') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group text-center top55">
            <button type="submit" class="btn btn-success btn-lg">SIMPAN</button>
          </div>
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>

</script>
@endpush
