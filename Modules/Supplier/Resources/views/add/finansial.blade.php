<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Finansial Aspek
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group {{ $errors->has('asset') ? ' has-error' : '' }}">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Asset Perusahaan</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon" id="asset">Rp.</span>
                <input type="text" name="asset" value="{{old('asset',Helper::prop_exists($supplier,'asset'))}}" class="form-control" placeholder="Masukan Asset Perusahaan" aria-describedby="asset" autocomplete="off">
              </div>
              @if ($errors->has('asset'))
                  <span class="help-block">
                      <strong>{{ $errors->first('asset') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Rekening Perusahaan</label>
            <div class="col-sm-10">
            </div>
            <div class="clearfix"></div>
            <hr  />
          </div>
          <div class="form-group {{ $errors->has('bank_nama') ? ' has-error' : '' }}">
            <label for="bank_nama" class="col-sm-2 control-label">Nama Bank</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="bank_nama" value="{{ old('bank_nama',Helper::prop_exists($supplier,'bank_nama')) }}" placeholder="Masukan Nama Bank" autocomplete="off">
              @if ($errors->has('bank_nama'))
                  <div class="help-block">
                      <strong>{{ $errors->first('bank_nama') }}</strong>
                  </div>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('bank_cabang') ? ' has-error' : '' }}">
            <label for="bank_cabang" class="col-sm-2 control-label">Cabang</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="bank_cabang" value="{{ old('bank_cabang',Helper::prop_exists($supplier,'bank_cabang')) }}" placeholder="Masukan Cabang Bank" autocomplete="off">
              @if ($errors->has('bank_cabang'))
                  <div class="help-block">
                      <strong>{{ $errors->first('bank_cabang') }}</strong>
                  </div>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('bank_kota') ? ' has-error' : '' }}">
            <label for="bank_kota" class="col-sm-2 control-label">Kota</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="bank_kota" value="{{ old('bank_kota',Helper::prop_exists($supplier,'bank_kota')) }}" placeholder="Masukan Kota Bank" autocomplete="off">
              @if ($errors->has('bank_kota'))
                  <div class="help-block">
                      <strong>{{ $errors->first('bank_kota') }}</strong>
                  </div>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('bank_norek') ? ' has-error' : '' }}">
            <label for="bank_norek" class="col-sm-2 control-label">Nomor ACC</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="bank_norek" value="{{ old('bank_norek',Helper::prop_exists($supplier,'bank_norek')) }}" placeholder="Masukan Nomor ACC" autocomplete="off">
              @if ($errors->has('bank_norek'))
                  <div class="help-block">
                      <strong>{{ $errors->first('bank_norek') }}</strong>
                  </div>
              @endif
            </div>
          </div>
          <div class="form-group">
            <hr  />
          </div>
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>

</script>
@endpush
