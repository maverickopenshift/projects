<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">
        General Info
    </h3>
  </div>
  <div class="box-body">
    <div class="form-horizontal"  style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">

      @if(!in_array($doc_type->name,['turnkey','khs','surat_pengikatan','mou']))
        <div class="form-group ">
          <label class="col-sm-2 control-label">No.Kontrak Induk </label>
          <div class="col-sm-10 text-me">{{$doc_parent->doc_no or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Judul Kontrak Induk </label>
          <div class="col-sm-10 text-me">{{$doc_parent->doc_title or '-'}}</div>
        </div>
        <hr>
      @endif

      <div class="form-group ">
        <label class="col-sm-2 control-label">No.Kontrak </label>
        <div class="col-sm-10 text-me">{{$doc->doc_no or '-'}}</div>
      </div>

      <div class="form-group ">
        <label class="col-sm-2 control-label">Judul {{$doc_type['title']}}</label>
        <div class="col-sm-10 text-me">{{$doc->doc_title}}</div>
      </div>

      @if(in_array($doc_type->name,['sp','turnkey']))
        <div class="form-group ">
          <label class="col-sm-2 control-label">No PO</label>
          <div class="col-sm-10 text-me">Disini No PO</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nilai PO</label>
          <div class="col-sm-10 text-me">Disini Nilai PO</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">No PR</label>
          <div class="col-sm-10 text-me">Disini No PR</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nilai PR</label>
          <div class="col-sm-10 text-me">Disini Nilai PR</div>
        </div>
      @endif
    </div>

    <!-- BAST -->
    <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">BAST<small class="text-danger"><i> (Wajib di isi) </i></small>
        </div>
      </div>

      <div class="form-group formerror formerror-bast_judul">
        <label for="lt_name" class="col-sm-3 control-label"><span class="text-red">*</span> Judul Lampiran</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="bast_judul" autocomplete="off" placeholder="Judul Lampiran..">
        </div>
        <div class="col-sm-10 col-sm-offset-3">
          <div class="error error-bast_judul"></div>
        </div>
      </div>

      <div class="form-group formerror formerror-bast_tgl">
        <label class="col-sm-3 control-label"><span class="text-red">*</span> Tanggal Lampiran</label>
        <div class="col-sm-4">
          <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" name="bast_tgl" autocomplete="off" placeholder="Tanggal..">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-3">
          <div class="error error-bast_tgl"></div>
        </div>
      </div>

      <div class="form-group formerror formerror-bast_file">
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
          <div class="error error-bast_file"></div>
        </div>
      </div>
    </div>

    <!-- BAUT -->
    <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">BAUT<small class="text-danger"><i> (Wajib di isi) </i></small>
        </div>
      </div>

      <div class="form-group formerror formerror-baut_judul">
        <label for="lt_name" class="col-sm-3 control-label"><span class="text-red">*</span> Judul Lampiran</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="baut_judul" autocomplete="off" placeholder="Judul Lampiran..">
        </div>
        <div class="col-sm-10 col-sm-offset-3">
          <div class="error error-baut_judul"></div>
        </div>
      </div>

      <div class="form-group formerror formerror-baut_tgl">
        <label class="col-sm-3 control-label"><span class="text-red">*</span> Tanggal Lampiran</label>
        <div class="col-sm-4">
          <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" name="baut_tgl" autocomplete="off" placeholder="Tanggal..">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-3">
          <div class="error error-baut_tgl"></div>
        </div>
      </div>

      <div class="form-group formerror formerror-baut_file">
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
          <div class="error error-baut_file"></div>
        </div>
      </div>
    </div>

    <!-- Lain -->
    <div class="parent_lain">
      <div class="form-horizontal perubahan_lain" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Lain-Lain #<span class="total_lain">1</span></div>
            <div class="btn-group" style="position: absolute;right: 5px;top: -10px;border-radius: 0;">
              <button type="button" class="btn btn-success add-lain" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>
            </div>            
          </div>

        <div class="form-group formerror formerror-lain_judul-0">
          <label for="lt_name" class="col-sm-3 control-label">Judul Lampiran</label>
          <div class="col-sm-4">
            <input type="text" class="form-control lain_judul" name="lain_judul[]" autocomplete="off" placeholder="Judul Lampiran..">
          </div>
          <div class="col-sm-10 col-sm-offset-3">
            <div class="error error-lain_judul error-lain_judul-0"></div>
          </div>
        </div>

        <div class="form-group formerror formerror-lain_tanggal-0">
          <label class="col-sm-3 control-label">Tanggal Lampiran</label>
          <div class="col-sm-4">
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control" name="lain_tanggal[]" autocomplete="off" placeholder="Tanggal..">
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-3">
            <div class="error error-lain_tanggal error-lain_tanggal-0"></div>
          </div>
        </div>

        <div class="form-group formerror formerror-lain_file-0">
          <label class="col-sm-3 control-label"><span class="text-red">*</span> File</label>
          <div class="col-sm-4">
            <div class="input-group">
              <input type="file" class="hide" name="lain_file[]">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
                <input type="hidden" name="lain_file_old[]">
              </span>
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-3">
            <div class="error error-lain_file error-lain_file-0"></div>
          </div>
        </div>

        {{--
        <div class="form-group formerror formerror-lain_file-0">
          <label class="col-sm-3 control-label">File</label>
          <div class="col-sm-4">
            <div class="input-group">
              <input type="file" class="hide" name="lain_file[]">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
                <input type="hidden" name="lain_file_old[]">
              </span>
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-3">
            <div class="error error-lain_file error-lain_file-0"></div>
          </div>
        </div>
        --}}

      </div>
    </div>

    <div class="form-horizontal gr-lampiran"  style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group ">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> GR</label>
        <div class="col-sm-6">

              <div class="form-group input-lampiran formerror formerror-gr_nomer-0 formerror-gr_nilai-0">
                <div class="col-sm-6">
                  <input type="text" class="form-control gr_nomer" name="gr_nomer[]" placeholder="Masukkan Nomer GR" autocomplete="off">
                  <div class="error error-gr_nomer error-gr_nomer-0"></div>
                </div>

                <div class="col-sm-6">
                  <div class="input-group">
                    <input type="text" class="form-control input-rupiah gr_nilai" name="gr_nilai[]" placeholder="Masukkan Total GR" autocomplete="off">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-danger delete-lampiran"><i class="glyphicon glyphicon-trash"></i></button>
                    </div>
                  </div>
                  <div class="error error-gr_nilai error-gr_nilai-0"></div>
                </div>
              </div>

        </div>
        <!-- <div class="clearfix"></div>-->
        <div class="col-sm-3 align-bottom">
          <button type="button" class="btn btn-success add-lampiran align-bottom"><i class="glyphicon glyphicon-plus"></i> Tambah Lampiran</button>
        </div>
      </div>
    </div>

    <div class="form-group text-center">
      <a href="{{route('doc',['status'=>'tutup'])}}" class="btn btn-danger" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">CANCEL</a>
      <button class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;" id="btn-submit">SUBMIT</button>
      <button class="btn btn-primary btn-sm btn_submit hide" type="submit"></button>
    </div>

  </div>
</div>

@push('scripts')
<script>
$(function() {
  $(document).on('click', '.add-lampiran', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-lampiran"><i class="glyphicon glyphicon-trash"></i></button>';

    var $this = $('.input-lampiran');
    var new_row = $this.eq(0).clone();
    new_row.removeClass('has-error');

    new_row.find('input').val('');
    new_row.find('.error').html('');

    new_row.find('.btn-lihat').remove();
    new_row.find('.delete-lampiran').remove();

    $this.parent().append(new_row);

    var row = $('.input-lampiran');
    $.each(row,function(index, el) {

      if($(this).hasClass("has-error")){
        $(this).removeClass().addClass("form-group input-lampiran has-error formerror formerror-gr_nomer-"+ index +" formerror-gr_nilai-"+ index);
      }else{
        $(this).removeClass().addClass("form-group input-lampiran formerror formerror-gr_nomer-"+ index +" formerror-gr_nilai-"+ index);
      }

      $(this).find('.error-gr_nomer').removeClass().addClass("error error-gr_nomer error-gr_nomer-"+ index);
      $(this).find('.error-gr_nilai').removeClass().addClass("error error-gr_nilai error-gr_nilai-"+ index);

      if(row.length==1){
        $(this).find('.delete-lampiran').remove();
      }
      else{
        $(this).find('.delete-lampiran').remove();
        $(this).find('.add-lampiran').remove();
        $(this).find('.input-group-btn').append(btn_del);
      }
    });
  });

  $(document).on('click', '.delete-lampiran', function(event) {
    $(this).parent().parent().parent().parent().remove();
    var $this = $('.input-lampiran');
    $.each($this,function(index, el) {
      if($(this).hasClass("has-error")){
        $(this).removeClass().addClass("form-group input-lampiran has-error formerror formerror-gr_nomer-"+ index +" formerror-gr_nilai-"+ index);
      }else{
        $(this).removeClass().addClass("form-group input-lampiran formerror formerror-gr_nomer-"+ index +" formerror-gr_nilai-"+ index);
      }

      $(this).find('.error-gr_nomer').removeClass().addClass("error error-gr_nomer error-gr_nomer-"+ index);
      $(this).find('.error-gr_nilai').removeClass().addClass("error error-gr_nilai error-gr_nilai-"+ index);

      if($this.length==1){
        $(this).find('.delete-lampiran').remove();
      }
    });
  });
  
  $(document).on('click', '.add-lain', function(event) {
    event.preventDefault();

    var btn_add = '<button type="button" class="btn btn-success add-lain" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
    var btn_del = '<button type="button" class="btn btn-danger delete-lain" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

    var $this = $('.perubahan_lain');
    var new_row = $this.eq(0).clone();

    new_row.find('.has-error').removeClass('has-error');
    var mdf_new_row = new_row.find('.form-group');

    mdf_new_row.eq(0).find('.total_lain').text(1);

    mdf_new_row.eq(1).find('.lain_judul').val('');
    mdf_new_row.eq(1).find('.error').html('');

    mdf_new_row.eq(2).find('.lain_tanggal').val('');    
    mdf_new_row.eq(2).find('.error').html('');

    mdf_new_row.eq(3).find('.lain_file').val('');
    mdf_new_row.eq(3).find('.error').html('');

    $('.parent_lain').prepend(new_row);

    var row = $('.perubahan_lain');
    $.each(row,function(index, el) {
      var mdf_new_row = $(this).find('.form-group');
      var mdf_new_row_button = $(this).find('.btn-group');
      mdf_new_row.eq(0).find('.total_lain').text(index+1);

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("form-group has-error formerror formerror-lain_tanggal-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("form-group formerror formerror-lain_tanggal-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("form-group has-error formerror formerror-lain_file-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("form-group formerror formerror-lain_file-"+ index);
      }

      mdf_new_row.eq(1).find('.error-lain_judul').removeClass().addClass("error error-lain_judul error-lain_judul-"+ index);
      mdf_new_row.eq(2).find('.error-lain_tanggal').removeClass().addClass("error error-lain_tanggal error-lain_tanggal-"+ index);
      mdf_new_row.eq(3).find('.error-lain_file').removeClass().addClass("error error-lain_file error-lain_file-"+ index);

      mdf_new_row_button.html('');
      if(row.length==1){
        mdf_new_row_button.eq(0).append(btn_add)
      }else{
        mdf_new_row_button.eq(0).append(btn_add)
        mdf_new_row_button.eq(0).append(btn_del)
      }
    });

    $('.date').datepicker(datepicker_ops);
  });
  
  $(document).on('click', '.delete-lain', function(event) {
    $(this).parent().parent().parent().remove();
    var btn_add = '<button type="button" class="btn btn-success add-lain" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
    var btn_del = '<button type="button" class="btn btn-danger delete-lain" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

    var row = $('.perubahan_lain');
    $.each(row,function(index, el) {
      var mdf_new_row = $(this).find('.form-group');
      var mdf_new_row_button = $(this).find('.btn-group');
      mdf_new_row.eq(0).find('.total_lain').text(index+1);

      mdf_new_row_button.html('');
      if(row.length==1){
        mdf_new_row_button.eq(0).append(btn_add)
      }else{
        mdf_new_row_button.eq(0).append(btn_add)
        mdf_new_row_button.eq(0).append(btn_del)
      }
    });
  });
  
});
</script>
@endpush
