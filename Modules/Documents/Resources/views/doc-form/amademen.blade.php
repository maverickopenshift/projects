<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Nomer {{$doc_type['title']}}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_vendor" value=""  placeholder="Masukan Judul Kontrak" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal {{$doc_type['title']}}</label>
            <div class="col-sm-3">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="akte_awal_tg" value="" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak I</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="pihak1" id="pihak1" value="PT. TELEKOMUNIKASI INDONESIA Tbk"  placeholder="Masukan Judul Kontrak" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="ttd_pihak1" class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak I</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="ttd_pihak1" value=""  placeholder="Masukan Nama Penandatanganan Pihak I" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak II</label>
            <div class="col-sm-6">
              <select class="form-control select-user-vendor" style="width: 100%;" name="store_id" id="store_id">
                  <option value="">Pilih Pihak II</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak II</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="ttd_pihak2" value=""  placeholder="Masukan Nama Penandatanganan Pihak II" autocomplete="off">
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
})
</script>
@endpush
