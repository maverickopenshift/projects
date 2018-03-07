<div class="box">
    <div class="box-header with-border" style="padding-bottom: 14px;">
      <h3 class="box-title">

      </h3>
      <div class="pull-right box-tools">
        <button type="button" class="btn btn-success add-ao-jas"><i class="glyphicon glyphicon-plus"></i> tambah</button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @php
        $doc_jaminan = Helper::old_prop_each($doc,'doc_jaminan');
        $doc_asuransi = Helper::old_prop_each($doc,'doc_asuransi');
        $doc_jaminan_nilai = Helper::old_prop_each($doc,'doc_jaminan_nilai');
        $doc_jaminan_startdate = Helper::old_prop_each($doc,'doc_jaminan_startdate');
        $doc_jaminan_enddate = Helper::old_prop_each($doc,'doc_jaminan_enddate');
        $doc_jaminan_desc = Helper::old_prop_each($doc,'doc_jaminan_desc');
        $doc_jaminan_file = Helper::old_prop_each($doc,'doc_jaminan_file');
        $doc_jaminan_file_old = Helper::old_prop_each($doc,'doc_jaminan_file_old');
      @endphp
      @if(count($doc_asuransi)>0)
        @foreach ($doc_asuransi as $key => $value)
            <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
                <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
                  <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Jaminan dan Asuransi <span class="total_asu">{{$key+1}}</span></div>
                  @if(count($doc_asuransi)>1)
                    <button type="button" class="btn btn-danger delete-ao-jas" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
                  @endif
                </div>

                <div class="form-group formerror formerror-doc_jaminan-{{$key}}">
                  <label for="doc_jaminan" class="col-sm-2 control-label">Jenis Jaminan</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="doc_jaminan[]">
                      <option value="" {!!Helper::prop_selected($doc_jaminan[$key],"")!!}>Pilih Jenis Jaminan</option>
                      <option value="PL" {!!Helper::prop_selected($doc_jaminan[$key],"PL")!!}>Pelaksanaan</option>
                      <option value="PM" {!!Helper::prop_selected($doc_jaminan[$key],"PM")!!}>Pemeliharaan</option>
                    </select>
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    <div class="error error-doc_jaminan error-doc_jaminan-{{$key}}"></div>
                  </div>
                </div>

                <div class="form-group formerror formerror-doc_asuransi-{{$key}}">
                  <label for="doc_asuransi" class="col-sm-2 control-label">Nama Asuransi</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="doc_asuransi[]" placeholder="Masukan Nama Asuransi" autocomplete="off" value="{{$value}}">
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    <div class="error error-doc_asuransi error-doc_asuransi-{{$key}}"></div>
                  </div>
                </div>

                <div class="form-group formerror formerror-doc_jaminan_nilai-{{$key}}">
                  <label for="doc_jaminan_nilai" class="col-sm-2 control-label">Nilai Jaminan</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <div class="input-group-addon mtu-set">
                      </div>
                      <input type="text" class="form-control input-rupiah" name="doc_jaminan_nilai[]" placeholder="Masukan Nilai Jaminan" autocomplete="off" value="{{$doc_jaminan_nilai[$key]}}">
                    </div>
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    <div class="error error-doc_jaminan_nilai error-doc_jaminan_nilai-{{$key}}"></div>
                  </div>
                </div>

                <div class="form-group formerror formerror-doc_jaminan_startdate-{{$key}}">
                  <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal Mulai</label>
                  <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control datepicker" name="doc_jaminan_startdate[]" autocomplete="off" value="{{date('d-m-Y', strtotime($doc_jaminan_startdate[$key]))}}">
                    </div>
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    <div class="error error-doc_jaminan_startdate error-doc_jaminan_startdate-{{$key}}"></div>
                  </div>
                </div>

                <div class="form-group formerror formerror-doc_jaminan_enddate-{{$key}}">
                  <label for="doc_jaminan_enddate" class="col-sm-2 control-label">Tanggal Akhir</label>
                  <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control datepicker" name="doc_jaminan_enddate[]" autocomplete="off" value="{{date('d-m-Y', strtotime($doc_jaminan_enddate[$key]))}}">
                    </div>
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    <div class="error error-doc_jaminan_enddate error-doc_jaminan_enddate-{{$key}}"></div>
                  </div>
                </div>

                <div class="form-group formerror formerror-doc_jaminan_desc-{{$key}}">
                  <label for="doc_jaminan_desc" class="col-sm-2 control-label">Keterangan</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" rows="4" name="doc_jaminan_desc[]" placeholder="">{{$doc_jaminan_desc[$key]}}</textarea>
                    <div class="error error-doc_jaminan_desc error-doc_jaminan_desc-{{$key}}"></div>
                  </div>
                </div>

                <div class="form-group formerror formerror-doc_jaminan_file-{{$key}}">
                  <label for="doc_jaminan_file" class="col-sm-2 control-label">File <br/><small class="text-danger" style="font-style:italic;font-weight:normal;">(optional)</small></label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="file" class="hide" name="doc_jaminan_file[]">
                      <input class="form-control" type="text" disabled>
                      <span class="input-group-btn">
                        <button class="btn btn-default click-upload" type="button">Browse</button>
                        <input type="hidden" name="doc_jaminan_file_old[]" value="{{$doc_jaminan_file_old[$key]}}">
                        @if(isset($doc_jaminan_file_old[$key]))
                          <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file.asuransi',['filename'=>$doc_jaminan_file_old[$key],'type'=>$doc_type->name])}}">
                          <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                          </a>
                        @endif
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    <div class="error error-doc_jaminan_file error-doc_jaminan_file-{{$key}}"></div>
                  </div>
                </div>
            </div>
        @endforeach
      @else
      <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Jaminan dan Asuransi <span class="total_asu">1</span></div>
          </div>

          <div class="form-group formerror formerror-doc_jaminan-0">
            <label for="doc_jaminan" class="col-sm-2 control-label">Jenis Jaminan</label>
            <div class="col-sm-4">
              <select class="form-control" name="doc_jaminan[]">
                <option value="">Pilih Jenis Jaminan</option>
                <option value="PL">Pelaksanaan</option>
                <option value="PM">Pemeliharaan</option>
              </select>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              <div class="error error-doc_jaminan error-doc_jaminan-0"></div>
            </div>
          </div>

          <div class="form-group formerror formerror-doc_asuransi-0">
            <label for="doc_asuransi" class="col-sm-2 control-label">Nama Asuransi</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="doc_asuransi[]" placeholder="Masukan Nama Asuransi" autocomplete="off">
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              <div class="error error-doc_asuransi error-doc_asuransi-0"></div>
            </div>
          </div>

          <div class="form-group formerror formerror-doc_jaminan_nilai-0">
            <label for="doc_jaminan_nilai" class="col-sm-2 control-label">Nilai Jaminan</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon mtu-set">
                </div>
                <input type="text" class="form-control input-rupiah" name="doc_jaminan_nilai[]" placeholder="Masukan Nilai Jaminan" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              <div class="error error-doc_jaminan_nilai error-doc_jaminan_nilai-0"></div>
            </div>
          </div>

          <div class="form-group formerror formerror-doc_jaminan_startdate-0">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal Mulai</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control datepicker" name="doc_jaminan_startdate[]" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              <div class="error error-doc_jaminan_startdate error-doc_jaminan_startdate-0"></div>
            </div>
          </div>

          <div class="form-group formerror formerror-doc_jaminan_enddate-0">
            <label for="doc_jaminan_enddate" class="col-sm-2 control-label">Tanggal Akhir</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control datepicker" name="doc_jaminan_enddate[]" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              <div class="error error-doc_jaminan_enddate error-doc_jaminan_enddate-0"></div>
            </div>
          </div>

          <div class="form-group formerror formerror-doc_jaminan_desc-0">
            <label for="doc_jaminan_desc" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="doc_jaminan_desc[]" placeholder=""></textarea>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              <div class="error error-doc_jaminan_desc error-doc_jaminan_desc-0"></div>
            </div>
          </div>

          <div class="form-group formerror formerror-doc_jaminan_file-0">
            <label for="doc_jaminan_file" class="col-sm-2 control-label">File <br/><small class="text-danger" style="font-style:italic;font-weight:normal;">(optional)</small></label>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="doc_jaminan_file[]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="doc_jaminan_file_old[]">
                </span>
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              <div class="error error-doc_jaminan_file error-doc_jaminan_file-0"></div>
            </div>
          </div>

      </div>
      @endif
      @include('documents::partials.button-edit')
    </div>


<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  // $('.formatTanggal').datepicker({
  //       dateFormat: 'Y-m-d'
  //   });
  var datepicker_ops={
    format: 'dd-mm-yyyy',
    autoclose:true,
    todayHighlight:true
  };

  $(document).on('click', '.add-ao-jas', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-ao-jas" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
    /* Act on the event */
    var $this = $('.ao-jas');
    var new_row = $this.eq(0).clone();
    new_row.find('.has-error').removeClass('has-error');
    var mdf_new_row = new_row.find('.form-group');

    mdf_new_row.eq(0).find('.total_asu').text($this+1);//title and button

    mdf_new_row.eq(1).find('select').val('');      //jenisjaminan
    mdf_new_row.eq(1).find('.error').html('');    //jenisjaminan

    mdf_new_row.eq(2).find('input').val('');   //namaasuransi
    mdf_new_row.eq(2).find('.error').html('');

    mdf_new_row.eq(3).find('input').val('');     //nilaijaminan
    mdf_new_row.eq(3).find('.error').html('');

    mdf_new_row.eq(4).find('input').val('');     //tanggalmulai
    mdf_new_row.eq(4).find('.error').html('');

    mdf_new_row.eq(5).find('input').val('');     //tanggalend
    mdf_new_row.eq(5).find('.error').html('');

    mdf_new_row.eq(6).find('textarea').val('');   //keterangan
    mdf_new_row.eq(6).find('.error').html('');

    mdf_new_row.eq(7).find('input').val('');    //file
    mdf_new_row.eq(7).find('.error').html('');

    $this.parent().prepend(new_row);
    $('.date').datepicker(datepicker_ops);
    var row = $('.ao-jas');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.delete-ao-jas');
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(0).find('.total_asu').text(index+1);

      if(mdf_new_row.eq(1).hasClass("has-error")){
        mdf_new_row.eq(1).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("form-group formerror formerror-doc_jaminan-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("form-group has-error formerror formerror-doc_asuransi-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("form-group formerror formerror-doc_asuransi-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_nilai-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("form-group formerror formerror-doc_jaminan_nilai-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_startdate-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("form-group formerror formerror-doc_jaminan_startdate-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_enddate-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("form-group formerror formerror-doc_jaminan_enddate-"+ index);
      }

      if(mdf_new_row.eq(6).hasClass("has-error")){
        mdf_new_row.eq(6).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_desc-"+ index);
      }else{
        mdf_new_row.eq(6).removeClass().addClass("form-group formerror formerror-doc_jaminan_desc-"+ index);
      }

      if(mdf_new_row.eq(7).hasClass("has-error")){
        mdf_new_row.eq(7).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_file-"+ index);
      }else{
        mdf_new_row.eq(7).removeClass().addClass("form-group formerror formerror-doc_jaminan_file-"+ index);
      }

      mdf_new_row.eq(1).find('.error-doc_jaminan').removeClass().addClass("error error-doc_jaminan error-doc_jaminan-"+ index);
      mdf_new_row.eq(2).find('.error-doc_asuransi').removeClass().addClass("error error-doc_asuransi error-doc_asuransi-"+ index);
      mdf_new_row.eq(3).find('.error-doc_jaminan_nilai').removeClass().addClass("error error-doc_jaminan_nilai error-doc_jaminan_nilai-"+ index);
      mdf_new_row.eq(4).find('.error-doc_jaminan_startdate').removeClass().addClass("error error-doc_jaminan_startdate error-doc_jaminan_startdate-"+ index);
      mdf_new_row.eq(5).find('.error-doc_jaminan_enddate').removeClass().addClass("error error-doc_jaminan_enddate error-doc_jaminan_enddate-"+ index);
      mdf_new_row.eq(6).find('.error-doc_jaminan_desc').removeClass().addClass("error error-doc_jaminan_desc error-doc_jaminan_desc-"+ index);
      mdf_new_row.eq(7).find('.error-doc_jaminan_file').removeClass().addClass("error error-doc_jaminan_file error-doc_jaminan_file-"+ index);

      if(row.length==1){
        mdf.remove();
      }
      else{
        mdf_new_row.eq(0).append(btn_del)
      }
    });
  });

  $(document).on('click', '.delete-ao-jas', function(event) {
    $(this).parent().parent().remove();
    var $this = $('.ao-jas');
    $.each($this,function(index, el) {
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(0).find('.total_asu').text(index+1);
      if(mdf_new_row.eq(1).hasClass("has-error")){
        mdf_new_row.eq(1).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("form-group formerror formerror-doc_jaminan-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("form-group has-error formerror formerror-doc_asuransi-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("form-group formerror formerror-doc_asuransi-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_nilai-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("form-group formerror formerror-doc_jaminan_nilai-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_startdate-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("form-group formerror formerror-doc_jaminan_startdate-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_enddate-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("form-group formerror formerror-doc_jaminan_enddate-"+ index);
      }

      if(mdf_new_row.eq(6).hasClass("has-error")){
        mdf_new_row.eq(6).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_desc-"+ index);
      }else{
        mdf_new_row.eq(6).removeClass().addClass("form-group formerror formerror-doc_jaminan_desc-"+ index);
      }

      if(mdf_new_row.eq(7).hasClass("has-error")){
        mdf_new_row.eq(7).removeClass().addClass("form-group has-error formerror formerror-doc_jaminan_file-"+ index);
      }else{
        mdf_new_row.eq(7).removeClass().addClass("form-group formerror formerror-doc_jaminan_file-"+ index);
      }

      mdf_new_row.eq(1).find('.error-doc_jaminan').removeClass().addClass("error error-doc_jaminan error-doc_jaminan-"+ index);
      mdf_new_row.eq(2).find('.error-doc_asuransi').removeClass().addClass("error error-doc_asuransi error-doc_asuransi-"+ index);
      mdf_new_row.eq(3).find('.error-doc_jaminan_nilai').removeClass().addClass("error error-doc_jaminan_nilai error-doc_jaminan_nilai-"+ index);
      mdf_new_row.eq(4).find('.error-doc_jaminan_startdate').removeClass().addClass("error error-doc_jaminan_startdate error-doc_jaminan_startdate-"+ index);
      mdf_new_row.eq(5).find('.error-doc_jaminan_enddate').removeClass().addClass("error error-doc_jaminan_enddate error-doc_jaminan_enddate-"+ index);
      mdf_new_row.eq(6).find('.error-doc_jaminan_desc').removeClass().addClass("error error-doc_jaminan_desc error-doc_jaminan_desc-"+ index);
      mdf_new_row.eq(7).find('.error-doc_jaminan_file').removeClass().addClass("error error-doc_jaminan_file error-doc_jaminan_file-"+ index);

      var mdf = $(this).find('.delete-ao-jas');
      if($this.length==1){
        mdf.remove();
      }
    });
  });
});
</script>
@endpush
