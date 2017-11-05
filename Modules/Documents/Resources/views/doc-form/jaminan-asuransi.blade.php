<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Jaminan dan Asuransi
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group {{ $errors->has('doc_jaminan') ? ' has-error' : '' }}">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Jenis Jaminan</label>
            <div class="col-sm-3">
              <select class="form-control" name="doc_jaminan">
                <option value="PL" {!!Helper::old_prop_selected($doc,'doc_jaminan','PL')!!}>Pelaksanaan</option>
                <option value="PM" {!!Helper::old_prop_selected($doc,'doc_jaminan','PM')!!}>Pemeliharaan</option>
              </select>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_jaminan')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_asuransi') ? ' has-error' : '' }}">
            <label for="doc_asuransi" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Asuransi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="doc_asuransi" value="{{Helper::old_prop($doc,'doc_asuransi')}}"  placeholder="Masukan Nama Asuransi" autocomplete="off">
              {!!Helper::error_help($errors,'doc_asuransi')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan_nilai') ? ' has-error' : '' }}">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Jaminan</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon mtu-set">
                </div>
                <input type="text" class="form-control input-rupiah" name="doc_jaminan_nilai" value="{{Helper::old_prop($doc,'doc_jaminan_nilai')}}"  placeholder="Masukan Nilai Jaminan" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_jaminan_nilai')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan_startdate') ? ' has-error' : '' }}">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai</label>
            <div class="col-sm-3">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="doc_jaminan_startdate" value="{{Helper::old_prop($doc,'doc_jaminan_startdate')}}" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_jaminan_startdate')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan_enddate') ? ' has-error' : '' }}">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir</label>
            <div class="col-sm-3">
              <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control" name="doc_jaminan_enddate" value="{{Helper::old_prop($doc,'doc_jaminan_enddate')}}" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_jaminan_enddate')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan_desc') ? ' has-error' : '' }}">
            <label for="deskripsi_kontrak" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="doc_jaminan_desc" placeholder="">{{Helper::old_prop($doc,'doc_jaminan_desc')}}</textarea>
              {!!Helper::error_help($errors,'doc_jaminan_desc')!!}
            </div>
          </div>
          @include('documents::partials.buttons')
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
