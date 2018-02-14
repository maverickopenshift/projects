<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">
        <!-- Lampiran -->
    </h3>
    <!-- <div class="pull-right">
      <button type="button" class="btn btn-success add-ao-jas"><i class="glyphicon glyphicon-plus"></i> tambah</button>
    </div> -->
  </div>
  <div class="box-body">
    <div class="form-horizontal">
    <!-- BAST -->
      <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">BAST<small class="text-danger"><i> (Wajib di isi) </i></small>
          </div>
        </div>
          <div class="form-group {{ $errors->has('bast_judul') ? ' has-error' : '' }}">
            <label for="lt_name" class="col-sm-3 control-label"><span class="text-red">*</span> Judul Lampiran</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="bast_judul" autocomplete="off" value="{{old('bast_judul',Helper::prop_exists($doc,'bast_judul'))}}" >
            </div>
            <div class="col-sm-10 col-sm-offset-3">
              {!!Helper::error_help($errors,'bast_judul')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('bast_tgl') ? ' has-error' : '' }}">
            <label class="col-sm-3 control-label"><span class="text-red">*</span> Tanggal Lampiran</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="bast_tgl" autocomplete="off" placeholder="Tanggal.." value="{{old('bast_tgl',Helper::prop_exists($doc,'bast_tgl'))}}">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-3">
              {!!Helper::error_help($errors,'bast_tgl')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('bast_file') ? ' has-error' : '' }}">
            <label class="col-sm-3 control-label"><span class="text-red">*</span> File</label>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="bast_file">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="bast_file_old">
                </span>
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-3">
              {!!Helper::error_help($errors,'bast_file')!!}
            </div>
          </div>
        </div>
    <!-- BAUT -->
        <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">BAUT<small class="text-danger"><i> (Wajib di isi) </i></small>
            </div>
          </div>
          <div class="form-group {{ $errors->has('baut_judul') ? ' has-error' : '' }}">
            <label for="lt_name" class="col-sm-3 control-label"><span class="text-red">*</span> Judul Lampiran</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="baut_judul" autocomplete="off" value="{{old('baut_judul',Helper::prop_exists($doc,'baut_judul'))}}">
            </div>
            <div class="col-sm-10 col-sm-offset-3">
              {!!Helper::error_help($errors,'baut_judul')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('baut_tgl') ? ' has-error' : '' }}">
            <label class="col-sm-3 control-label"><span class="text-red">*</span> Tanggal Lampiran</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="baut_tgl" autocomplete="off" placeholder="Tanggal.." value="{{old('baut_tgl',Helper::prop_exists($doc,'baut_tgl'))}}">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-3">
              {!!Helper::error_help($errors,'baut_tgl')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('baut_file') ? ' has-error' : '' }}">
            <label class="col-sm-3 control-label"><span class="text-red">*</span> File</label>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="baut_file">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="baut_file_old">
                </span>
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-3">
              {!!Helper::error_help($errors,'baut_file')!!}
            </div>
          </div>
        </div>
    </div>
    <div class="form-group text-center">
      <a href="{{route('doc',['status'=>'tutup'])}}" class="btn btn-danger" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">CANCEL</a>
      <button class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;" id="btn-submit">SUBMIT</button>
      <button class="btn btn-primary btn-sm btn_submit hide" type="submit"></button>
    </div>
  </div><!-- /.box-body -->
</div>

@push('scripts')
<script>
$(function() {
});
</script>
@endpush
