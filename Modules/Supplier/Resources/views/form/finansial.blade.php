<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Finansial Aspek
      </h3>
      @if($action_type=='lihat' || $action_type=='edit')
        @include('supplier::partials.buttons-edit')
      @endif
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group formerror formerror-asset">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Asset Perusahaan</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon" id="asset">Rp.</span>
                <input type="text" name="asset" value="{{old('asset',Helper::prop_exists($supplier,'asset'))}}" class="form-control input-rupiah" placeholder="Masukan Asset Perusahaan" aria-describedby="asset" autocomplete="off">
              </div>
              <div class="error error-asset"></div>
            </div>
          </div>
          <div class="form-group">
            <div class="clearfix"></div>
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Rekening Perusahaan</label><hr />
          </div>
          <div class="form-group formerror formerror-bank_nama">
            <label for="bank_nama" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Bank</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="bank_nama" value="{{ old('bank_nama',Helper::prop_exists($supplier,'bank_nama')) }}" placeholder="Masukan Nama Bank" autocomplete="off">
              <div class="error error-bank_nama"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-bank_cabang">
            <label for="bank_cabang" class="col-sm-2 control-label"><span class="text-red">*</span> Cabang</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="bank_cabang" value="{{ old('bank_cabang',Helper::prop_exists($supplier,'bank_cabang')) }}" placeholder="Masukan Cabang Bank" autocomplete="off">
              <div class="error error-bank_cabang"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-bank_kota">
            <label for="bank_kota" class="col-sm-2 control-label"><span class="text-red">*</span> Kota</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="bank_kota" value="{{ old('bank_kota',Helper::prop_exists($supplier,'bank_kota')) }}" placeholder="Masukan Kota Bank" autocomplete="off">
              <div class="error error-bank_kota"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-bank_norek">
            <label for="bank_norek" class="col-sm-2 control-label"><span class="text-red">*</span> Nomor ACC</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="bank_norek" value="{{ old('bank_norek',Helper::prop_exists($supplier,'bank_norek')) }}" placeholder="Masukan Nomor ACC" autocomplete="off">
              <div class="error error-bank_norek"></div>
            </div>
          </div>
          <div class="form-group">
            <hr  />
          </div>
          @if($action_type=='lihat' || $action_type=='edit')
          @include('supplier::partials.buttons')
          @endif
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>

</script>
@endpush
