<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Jaminan dan Asuransi</h3>
      <div class="pull-right attr-btn">
        <button type="button" class="btn btn-success btn-xs add-asre"><i class="glyphicon glyphicon-plus"></i> tambah</button>
      </div>
    </div>
    <!-- /.box-header -->
    @php
      $doc_jaminan = Helper::old_prop_each($doc,'doc_jaminan');
      $doc_asuransi = Helper::old_prop_each($doc,'doc_asuransi');
      $doc_jaminan_nilai = Helper::old_prop_each($doc,'doc_jaminan_nilai');
      $doc_jaminan_startdate = Helper::old_prop_each($doc,'doc_jaminan_startdate');
      $doc_jaminan_enddate = Helper::old_prop_each($doc,'doc_jaminan_enddate');
      $doc_jaminan_desc = Helper::old_prop_each($doc,'doc_jaminan_desc');
      $doc_jaminan_file = Helper::old_prop_each($doc,'doc_jaminan_file');
    @endphp
    <div class="box-body form-asr">
      @if(count($doc_asuransi)>0)
        @foreach ($doc_asuransi as $key => $value)
      <div class="form-horizontal form1">
        <div class="form-group text-right top10 tombol">
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan.'.$key) ? ' has-error' : '' }}">
            <label for="doc_jaminan" class="col-sm-2 control-label"><span class="text-red">*</span> Jenis Jaminan</label>
            <div class="col-sm-10">
              <select class="form-control" name="doc_jaminan[]">
                <option value="{{$doc_jaminan[$key]}}" {!!Helper::old_prop_selected($doc,'doc_jaminan','PL'.$key)!!}>Pelaksanaan</option>
                <option value="{{$doc_jaminan[$key]}}" {!!Helper::old_prop_selected($doc,'doc_jaminan','PM'.$key)!!}>Pemeliharaan</option>
              </select>
            </div>
            <div class="col-sm-10 col-sm-offset-2 help-block">
              {!!Helper::error_help($errors,'doc_jaminan.'.$key)!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_asuransi.'.$key) ? ' has-error' : '' }}">
            <label for="doc_asuransi" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Asuransi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="doc_asuransi[]" value="{{$value}}"  placeholder="Masukan Nama Asuransi" autocomplete="off">
            </div>
            <div class="col-sm-10 col-sm-offset-2 help-block">
              {!!Helper::error_help($errors,'doc_asuransi.'.$key)!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan_nilai.'.$key) ? ' has-error' : '' }}">
            <label for="doc_jaminan_nilai" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Jaminan</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon mtu-set">
                </div>
                <input type="text" class="form-control input-rupiah" name="doc_jaminan_nilai[]" value="{{$doc_jaminan_nilai[$key]}}"  placeholder="Masukan Nilai Jaminan" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2 help-block">
              {!!Helper::error_help($errors,'doc_jaminan_nilai.'.$key)!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan_startdate.'.$key) ? ' has-error' : '' }}">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="doc_jaminan_startdate[]" value="{{$doc_jaminan_startdate[$key]}}" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2 help-block">
              {!!Helper::error_help($errors,'doc_jaminan_startdate.'.$key)!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan_enddate.'.$key) ? ' has-error' : '' }}">
            <label for="doc_jaminan_enddate" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control" name="doc_jaminan_enddate[]" value="{{$doc_jaminan_enddate[$key]}}" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2 help-block">
              {!!Helper::error_help($errors,'doc_jaminan_enddate.'.$key)!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_jaminan_desc.'.$key) ? ' has-error' : '' }}">
            <label for="doc_jaminan_desc" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="doc_jaminan_desc[]" placeholder="">{{$doc_jaminan_desc[$key]}}</textarea>
            </div>
            <div class="col-sm-10 col-sm-offset-2 help-block">
              {!!Helper::error_help($errors,'doc_jaminan_desc.'.$key)!!}
            </div>
          </div>
          <div class="form-group  {{ $errors->has('doc_jaminan_file.'.$key) ? ' has-error' : '' }}">
            <label for="doc_jaminan_file" class="col-sm-2 control-label">File <br/><small class="text-danger" style="font-style:italic;font-weight:normal;">(optional)</small></label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="file" class="hide" name="doc_jaminan_file[]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                </span>
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2 help-block">
              {!!Helper::error_help($errors,'doc_jaminan_file.'.$key)!!}
            </div>
          </div>
      </div>
      <div id="new"></div>
    @endforeach
  @else
    <div class="form-horizontal form1">
      <div class="form-group text-right top10 tombol">
        </div>
        <div class="form-group">
          <label for="doc_jaminan" class="col-sm-2 control-label"><span class="text-red">*</span> Jenis Jaminan</label>
          <div class="col-sm-10">
            <select class="form-control" name="doc_jaminan[]">
              <option value="PL">Pelaksanaan</option>
              <option value="PM">Pemeliharaan</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="doc_asuransi" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Asuransi</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="doc_asuransi[]" placeholder="Masukan Nama Asuransi" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_nilai" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Jaminan</label>
          <div class="col-sm-4">
            <div class="input-group">
              <div class="input-group-addon mtu-set">
              </div>
              <input type="text" class="form-control input-rupiah" name="doc_jaminan_nilai[]" placeholder="Masukan Nilai Jaminan" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_startdate" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai</label>
          <div class="col-sm-4">
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control" name="doc_jaminan_startdate[]" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_enddate" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir</label>
          <div class="col-sm-4">
            <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" name="doc_jaminan_enddate[]" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_desc" class="col-sm-2 control-label">Keterangan</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" name="doc_jaminan_desc[]" placeholder=""></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_file" class="col-sm-2 control-label">File <br/><small class="text-danger" style="font-style:italic;font-weight:normal;">(optional)</small></label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="file" class="hide" name="doc_jaminan_file[]">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
              </span>
            </div>
          </div>
        </div>
    </div>
  @endif
      @include('documents::partials.buttons')
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
  $('.add-asre').click(function () {
    var $this = $('.form-asr');
    var row = $this.find('.form1');
    var new_row = row.clone();
    var $clone_btn = $this.clone();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-asr"><i class="glyphicon glyphicon-remove"></i> hapus</button>';



    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="file"]').val('');
    new_row.find('textarea').val('');
    // new_row.btn_del;
    new_row.find('.tombol').html(btn_del);
    new_row.appendTo(row);

    $('.date').datepicker(datepicker_ops);
  });
</script>
@endpush
