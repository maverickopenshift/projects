<div class="box">
  <div class="box-header with-border" style="padding-bottom: 14px;">
    <h3 class="box-title">
      Latar Belakang
    </h3>
  </div>
  <div class="box-body">
    @php
      $lt_judul_rks = Helper::old_prop($doc,'lt_judul_rks');
      $lt_tanggal_rks = Helper::old_prop($doc,'lt_tanggal_rks');
      $lt_file_rks = Helper::old_prop($doc,'lt_file_rks');
      $lt_file_rks_old = Helper::old_prop($doc,'lt_file_rks_old');

      $lt_judul_ketetapan_pemenang = Helper::old_prop($doc,'lt_judul_ketetapan_pemenang');
      $lt_tanggal_ketetapan_pemenang = Helper::old_prop($doc,'lt_tanggal_ketetapan_pemenang');
      $lt_file_ketetapan_pemenang = Helper::old_prop($doc,'lt_file_ketetapan_pemenang');
      $lt_file_ketetapan_pemenang_old = Helper::old_prop($doc,'lt_file_ketetapan_pemenang_old');

      $lt_judul_kesanggupan_mitra = Helper::old_prop($doc,'lt_judul_kesanggupan_mitra');
      $lt_tanggal_kesanggupan_mitra = Helper::old_prop($doc,'lt_tanggal_kesanggupan_mitra');
      $lt_file_kesanggupan_mitra = Helper::old_prop($doc,'lt_file_kesanggupan_mitra');
      $lt_file_kesanggupan_mitra_old = Helper::old_prop($doc,'lt_file_kesanggupan_mitra_old');

      $f_latar_belakang_judul = Helper::old_prop_each($doc,'f_latar_belakang_judul');
      $f_latar_belakang_tanggal = Helper::old_prop_each($doc,'f_latar_belakang_tanggal');
      $f_latar_belakang_isi = Helper::old_prop_each($doc,'f_latar_belakang_isi');

      if($doc_type->name == "khs" || $doc_type->name == "turnkey" || $doc_type->name == "surat_pengikatan"){
        $judul = "Judul";
      }else{
        $judul = "Perubahan";
      }
    @endphp


    @if(in_array($doc_type->name,['surat_pengikatan']))
    <!-- RKS -->
    <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">RKS <span class="total_lt"></span><small class="text-danger"><i> (Wajib di isi) </i></small></div>
      </div>

      <div class="form-group {{ $errors->has('lt_judul_rks') ? ' has-error' : '' }}">
        <label for="lt_name" class="col-sm-2 control-label"><span class="text-red">*</span> Judul</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="lt_judul_rks" autocomplete="off" value="RKS" readonly>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
        {!!Helper::error_help($errors,'lt_judul_rks')!!}
      </div>
      </div>

      <div class="form-group {{ $errors->has('lt_tanggal_rks') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal</label>
        <div class="col-sm-4">
          <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" name="lt_tanggal_rks" autocomplete="off" placeholder="Tanggal..">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_tanggal_rks')!!}
        </div>
      </div>

      <div class="form-group {{ $errors->has('lt_file_rks') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> File</label>
        <div class="col-sm-4">
          <div class="input-group">
            <input type="file" class="hide" name="lt_file_rks">
            <input class="form-control" type="text" disabled>
            <span class="input-group-btn">
              <button class="btn btn-default click-upload" type="button">Browse</button>
              <input type="hidden" name="lt_file_rks_old">
            </span>
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_file_rks')!!}
        </div>
      </div>
    </div>
    @endif

    @if(in_array($doc_type->name,['surat_pengikatan', 'khs', 'turnkey', 'sp', 'amandemen_sp', 'amandemen_kontrak','amandemen_kontrak_khs','amandemen_kontrak_turnkey','adendum', 'side_letter']))
    <!-- Surat Ketetapan Pemenang-->
    <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Ketetapan Pemenang <span class="total_lt"></span><small class="text-danger"><i> (Wajib di isi) </i></small></div>
      </div>

      <div class="form-group {{ $errors->has('lt_judul_ketetapan_pemenang') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> Judul</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="lt_judul_ketetapan_pemenang" autocomplete="off" value="Ketetapan Pemenang" readonly>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_judul_ketetapan_pemenang')!!}
        </div>
      </div>

      <div class="form-group {{ $errors->has('lt_tanggal_ketetapan_pemenang') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal</label>
        <div class="col-sm-4">
          <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" value="{{$lt_tanggal_ketetapan_pemenang}}" class="form-control" name="lt_tanggal_ketetapan_pemenang" autocomplete="off" placeholder="Tanggal..">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_tanggal_ketetapan_pemenang')!!}
        </div>
      </div>

      <div class="form-group {{ $errors->has('lt_file_ketetapan_pemenang') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> File</label>
        <div class="col-sm-4">
          <div class="input-group">
            <input type="file" class="hide" name="lt_file_ketetapan_pemenang">
            <input class="form-control" type="text" disabled>
            <span class="input-group-btn">
              <button class="btn btn-default click-upload" type="button">Browse</button>
              <input type="hidden" name="lt_file_ketetapan_pemenang_old">
            </span>
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_file_ketetapan_pemenang')!!}
        </div>
      </div>
    </div>
    <!-- Surat Kesanggupan Mitra -->
    <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Kesanggupan Mitra <span class="total_lt"></span><small class="text-danger"><i> (Wajib di isi) </i></small></div>
      </div>

      <div class="form-group {{ $errors->has('lt_judul_kesanggupan_mitra') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> Judul</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="lt_judul_kesanggupan_mitra" autocomplete="off" value="Kesanggupan Mitra" readonly>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_judul_kesanggupan_mitra')!!}
        </div>
      </div>

      <div class="form-group {{ $errors->has('lt_tanggal_kesanggupan_mitra') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal</label>
        <div class="col-sm-4">
          <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" value="{{$lt_tanggal_kesanggupan_mitra}}" class="form-control" name="lt_tanggal_kesanggupan_mitra" autocomplete="off"  placeholder="Tanggal..">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_tanggal_kesanggupan_mitra')!!}
        </div>
      </div>

      <div class="form-group {{ $errors->has('lt_file_kesanggupan_mitra') ? ' has-error' : '' }}">
        <label for="lt_file" class="col-sm-2 control-label"><span class="text-red">*</span> File</label>
        <div class="col-sm-4">
          <div class="input-group">
            <input type="file" class="hide" name="lt_file_kesanggupan_mitra">
            <input class="form-control" type="text" disabled>
            <span class="input-group-btn">
              <button class="btn btn-default click-upload" type="button">Browse</button>
              <input type="hidden" name="lt_file_kesanggupan_mitra_old">
            </span>
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_file_kesanggupan_mitra')!!}
        </div>
      </div>
    </div>
    @endif

    @if(count($f_latar_belakang_judul)>=1)
      @foreach ($f_latar_belakang_judul as $key => $value)
        <div class="parent-perubahan_latar_belakang">
          <div class="form-horizontal perubahan_latar_belakang" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Lain-lain</div>
              <div class="btn-group" style="position: absolute;right: 5px;top: -10px;border-radius: 0;">
                <button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>
                @if(count($f_latar_belakang_judul)>1)
                <button type="button" class="btn btn-danger delete-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="f_judul" class="col-sm-2 control-label">{{$judul}}</label>
              <div class="col-sm-6">
                @php
                  $a="";
                  $b="";
                  $c="";
                  $d="";

                  if($f_latar_belakang_judul[$key]=="latar_belakang_surat_pengikatan"){
                    $a="selected";
                  }

                  if($f_latar_belakang_judul[$key]=="latar_belakang_mou"){
                    $b="selected";
                  }

                  if($f_latar_belakang_judul[$key]=="latar_belakang_bak"){
                    $c="selected";
                  }

                  if($f_latar_belakang_judul[$key]=="latar_belakang_bap"){
                    $d="selected";
                  }
                @endphp

                <select class="form-control f_latar_belakang_judul select2" name="f_latar_belakang_judul[]" style="width: 100%;">
                  <option value=""></option>
                  <option value="latar_belakang_surat_pengikatan" {{$a}}>No. Surat Pengikatan</option>
                  <option value="latar_belakang_mou" {{$b}}>No. Mou</option>
                  <option value="latar_belakang_bak" {{$c}}>BAK</option>
                  <option value="latar_belakang_bap" {{$d}}>BAP</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"> Tanggal </label>
              <div class="col-sm-6">
                <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" name="f_latar_belakang_tanggal[]" class="form-control f_latar_belakang_tanggal" value="{{$f_latar_belakang_tanggal[$key]}}" placeholder="Tanggal..">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"> Isi</label>
              <div class="col-sm-6">
                <textarea class="form-control f_latar_belakang_isi" name="f_latar_belakang_isi[]" cols="4" rows="4" placeholder="Isi..">{{$f_latar_belakang_isi[$key]}}</textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="lt_file" class="col-sm-2 control-label"> File</label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input type="file" class="hide" name="f_latar_belakang_file[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                    <input type="hidden" name="f_latar_belakang_file_old[]">
                  </span>
                </div>
              </div>
            </div>

          </div>
        </div>
      @endforeach
    @else
      <div class="parent-perubahan_latar_belakang">
        <div class="form-horizontal perubahan_latar_belakang" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Lain-lain</div>
            <div class="btn-group" style="position: absolute;right: 5px;top: -10px;border-radius: 0;">
              <button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
          </div>

          <div class="form-group">
            <label for="f_judul" class="col-sm-2 control-label">{{$judul}}</label>
            <div class="col-sm-6">
              <select class="form-control f_latar_belakang_judul" name="f_latar_belakang_judul[]" style="width: 100%;">
                <option value=""></option>
                <option value="latar_belakang_surat_pengikatan">No. Surat Pengikatan</option>
                <option value="latar_belakang_mou">No. Mou</option>
                <option value="latar_belakang_bak">BAK</option>
                <option value="latar_belakang_bap">BAP</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label"> Tanggal </label>
            <div class="col-sm-6">
              <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" name="f_latar_belakang_tanggal[]" class="form-control f_latar_belakang_tanggal" placeholder="Tanggal..">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label"> Isi</label>
            <div class="col-sm-6">
              <textarea class="form-control f_latar_belakang_isi" name="f_latar_belakang_isi[]" cols="4" rows="4" placeholder="Isi.."></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="lt_file" class="col-sm-2 control-label"> File</label>
            <div class="col-sm-6">
              <div class="input-group">
                <input type="file" class="hide f_latar_belakang_file" name="f_latar_belakang_file[]">
                <input class="form-control f_latar_belakang_file" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="f_latar_belakang_file_old[]">
                </span>
              </div>
            </div>
          </div>

        </div>
      </div>
    @endif

    @include('documents::partials.buttons')
  </div>
</div>
@push('scripts')
<script>
  $(function(){
    var datepicker_ops={
      format: 'yyyy-mm-dd',
      autoclose:true,
      todayHighlight:true
    };

    $(".f_latar_belakang_judul").select2({
      placeholder:"Silahkan Pilih"
    });

    $(document).on('click', '.add-latar-belakang', function(event) {
      event.preventDefault();

      $('.parent-perubahan_latar_belakang').find(".f_latar_belakang_judul").each(function(index){
        if($(this).data('select2')) {
          $(this).select2('destroy');
        }
      });

      var btn_add = '<button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
      var btn_del = '<button type="button" class="btn btn-danger delete-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

      var $this = $('.perubahan_latar_belakang');
      var new_row = $this.eq(0).clone();

      new_row.find('.has-error').removeClass('has-error');
      var mdf_new_row = new_row.find('.form-group');

      mdf_new_row.eq(0).find('.total_perubahan_latar_belakang').text(1);

      mdf_new_row.eq(1).find('.f_latar_belakang_judul').val('');
      mdf_new_row.eq(1).find('.error').remove();

      mdf_new_row.eq(2).find('.f_latar_belakang_tanggal').val('');
      mdf_new_row.eq(2).find('.error').remove();

      mdf_new_row.eq(3).find('.f_latar_belakang_isi').val('');
      mdf_new_row.eq(3).find('.error').remove();

      mdf_new_row.eq(4).find('.f_latar_belakang_file').val('');
      mdf_new_row.eq(4).find('.error').remove();

      $('.parent-perubahan_latar_belakang').prepend(new_row);

      var row = $('.perubahan_latar_belakang');
      $.each(row,function(index, el) {
        var mdf_new_row = $(this).find('.form-group');
        var mdf_new_row_button = $(this).find('.btn-group');
        mdf_new_row.eq(0).find('.total_perubahan_latar_belakang').text(index+1);

        mdf_new_row_button.html('');
        if(row.length==1){
          mdf_new_row_button.eq(0).append(btn_add)
        }else{
          mdf_new_row_button.eq(0).append(btn_add)
          mdf_new_row_button.eq(0).append(btn_del)
        }
      });

      $(".f_latar_belakang_judul").select2({
        placeholder:"Silahkan Pilih"
      });

      $('.date').datepicker(datepicker_ops);
    });

    $(document).on('click', '.delete-latar-belakang', function(event) {
      $(this).parent().parent().parent().remove();
      var btn_add = '<button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
      var btn_del = '<button type="button" class="btn btn-danger delete-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

      var row = $('.perubahan_latar_belakang');
      $.each(row,function(index, el) {
        var mdf_new_row = $(this).find('.form-group');
        var mdf_new_row_button = $(this).find('.btn-group');
        mdf_new_row.eq(0).find('.total_perubahan_latar_belakang').text(index+1);

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
