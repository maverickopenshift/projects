<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Jaminan dan Asuransi
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Jenis Jaminan</label>
            <div class="col-sm-10">
              <select class="form-control" name="prinsipal_st">
                <option value="Pelaksanaan">Pelaksanaan</option>
                <option value="Pemeliharaan">Pemeliharaan</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Asuransi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="ttd_pihak2" value=""  placeholder="Masukan Nama Asuransi" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Jaminan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="ttd_pihak2" value=""  placeholder="Masukan Nilai Jaminan" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai</label>
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control" name="akte_awal_tg" value="{{ old('akte_awal_tg',Helper::prop_exists($data,'akte_awal_tg')) }}" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir</label>
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control" name="akte_awal_tg" value="{{ old('akte_awal_tg',Helper::prop_exists($data,'akte_awal_tg')) }}" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="deskripsi_kontrak" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="deskripsi_kontrak" placeholder=""></textarea>
            </div>
          </div>
          {{-- @include('documents::partials.buttons') --}}
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
