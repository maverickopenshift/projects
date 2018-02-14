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
      $f_latar_belakang_file = Helper::old_prop_each($doc,'f_latar_belakang_file');
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
          <input type="text" class="form-control" name="lt_judul_rks" disabled="true" autocomplete="off" value="RKS">
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
              @if(isset($lt_file_rks))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$lt_file_rks,'type'=>$doc_type->name.'_latar_belakang_rks'])}}">
                <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                </a>
              @endif
            </span>
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          {!!Helper::error_help($errors,'lt_file_rks')!!}
        </div>
      </div>
    </div>
    @endif

    @if(in_array($doc_type->name,['surat_pengikatan', 'khs', 'turnkey', 'sp', 'amandemen_sp', 'amandemen_kontrak', 'adendum', 'side_letter']))
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
              @if(isset($lt_file_ketetapan_pemenang))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$lt_file_ketetapan_pemenang,'type'=>$doc_type->name.'_latar_belakang_ketetapan_pemenang'])}}">
                <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                </a>
              @endif
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
        <label for="lt_file" class="col-sm-2 control-label"><span class="text-red">*</span> File </label>
        <div class="col-sm-4">
          <div class="input-group">
            <input type="file" class="hide" name="lt_file_kesanggupan_mitra">
            <input class="form-control" type="text" disabled>
            <span class="input-group-btn">
              <button class="btn btn-default click-upload" type="button">Browsex</button>
              <input type="hidden" name="lt_file_kesanggupan_mitra_old">
              @if(isset($lt_file_kesanggupan_mitra))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$lt_file_kesanggupan_mitra,'type'=>$doc_type->name.'_latar_belakang_kesanggupan_mitra'])}}">
                <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                </a>
              @endif
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
        <div class="parent-perubahan">
          <div class="form-horizontal perubahan" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Latar Belakang <span class="total_perubahan">{{ $key+1 }}</span></div>
              <div class="btn-group" style="position: absolute;right: 5px;top: -10px;border-radius: 0;">
                <button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>
                @if(count($f_latar_belakang_judul)>1)
                <button type="button" class="btn btn-danger delete-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="f_judul" class="col-sm-2 control-label">Perubahan</label>
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
                    @if(isset($f_latar_belakang_file[$key]))
                      <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$f_latar_belakang_file[$key],'type'=>$doc_type->name.'_latar_belakang_optional'])}}">
                      <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                      </a>
                    @endif
                  </span>
                </div>
              </div>
            </div>

          </div>
        </div>
      @endforeach
    @else
      <div class="parent-perubahan">
        <div class="form-horizontal perubahan" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Latar Belakang <span class="total_perubahan">1</span></div>
            <div class="btn-group" style="position: absolute;right: 5px;top: -10px;border-radius: 0;">
              <button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
          </div>

          <div class="form-group">
            <label for="f_judul" class="col-sm-2 control-label">Perubahan</label>
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
    @endif

    @include('documents::partials.button-edit')
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

      $('.parent-perubahan').find(".f_latar_belakang_judul").each(function(index){
        if($(this).data('select2')) {
          $(this).select2('destroy');
        }
      });

      var btn_add = '<button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
      var btn_del = '<button type="button" class="btn btn-danger delete-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

      var $this = $('.perubahan');
      var new_row = $this.eq(0).clone();

      new_row.find('.has-error').removeClass('has-error');
      var mdf_new_row = new_row.find('.form-group');

      mdf_new_row.eq(0).find('.total_perubahan').text(1);

      mdf_new_row.eq(1).find('.f_latar_belakang_judul').val('');
      mdf_new_row.eq(1).find('.error').remove();

      mdf_new_row.eq(2).find('.f_latar_belakang_tanggal').val('');
      mdf_new_row.eq(2).find('.error').remove();

      mdf_new_row.eq(3).find('.f_latar_belakang_isi').val('');
      mdf_new_row.eq(3).find('.error').remove();

      mdf_new_row.eq(4).find('.f_latar_belakang_file').val('');
      mdf_new_row.eq(4).find('.error').remove();

      $('.parent-perubahan').prepend(new_row);

      var row = $('.perubahan');
      $.each(row,function(index, el) {
        var mdf_new_row = $(this).find('.form-group');
        var mdf_new_row_button = $(this).find('.btn-group');
        mdf_new_row.eq(0).find('.total_perubahan').text(index+1);

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

      var row = $('.perubahan');
      $.each(row,function(index, el) {
        var mdf_new_row = $(this).find('.form-group');
        var mdf_new_row_button = $(this).find('.btn-group');
        mdf_new_row.eq(0).find('.total_perubahan').text(index+1);

        mdf_new_row_button.html('');
        if(row.length==1){
          mdf_new_row_button.eq(0).append(btn_add)
        }else{
          mdf_new_row_button.eq(0).append(btn_add)
          mdf_new_row_button.eq(0).append(btn_del)
        }
      });
    });

    /*
    var text_mou = $(".text-mou").val();
    var select_kontrak_mou = $(".select-kontrak-mou");
    var selectKontrak_mou = $(".select-kontrak-mou").select2({
      placeholder : "Pilih Kontrak....",
      ajax: {
          url: '{!! route('doc.get-select-kontrak') !!}',
          dataType: 'json',
          delay: 250,
          data: function (params) {
              return {
                  q: params.term, // search term
                  type:'mou',
                  page: params.page
              };
          },
          processResults: function (data, params) {
              var results = [];

              $.each(data.data, function (i, v) {
                  var o = {};
                  var startdate=(v.doc_startdate!==null)?$.format.date(v.doc_startdate+" 10:54:50", "dd-MM-yyyy"):'-';
                  var enddate=(v.doc_enddate!==null)?$.format.date(v.doc_enddate+" 10:54:50", "dd-MM-yyyy"):'-';
                  o.id = v.id;
                  o.name = v.doc_title;
                  o.value = v.doc_no;
                  o.date = $.format.date(v.doc_date+" 10:54:50", "ddd, dd MMMM yyyy");
                  o.date_start = startdate;
                  o.date_end = enddate;
                  o.type = v.type;
                  o.jenis = v.jenis;
                  o.nama_supplier = v.supplier.bdn_usaha+"."+v.supplier.nm_vendor;
                  o.lampiran_ttd=v.lampiran_ttd;

                  results.push(o);
              })
              params.page = params.page || 1;
              return {
                  results: results,
                  pagination: {
                      more: (data.next_page_url ? true: false)
                  }
              };
          },
          cache: true
      },
      minimumInputLength: 0,
      escapeMarkup: function (markup) { return markup; },
      templateResult: function (state) {
          if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ; }
          var $state = $(
              '<span>' +  state.name +' <i>('+  state.value + ')</i></span>'
          );
          return $state;
      },
      templateSelection: function (data) {
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return 'Cari Nomor/Judul Kontrak';
          }
          var render = data.value;
          if(data.value === undefined){
            render = $('.select-kontrak-mou :selected').text();
          }
          $('.text-mou').val(render);
          return render ;
      }
    });

    selectKontrak_mou.on('select2:select', function (e) {
        var data = e.params.data;
        $(".f_judul_mou").text(data.name);
        $(".f_tanggal_mou").text(data.date_start + " - " + data.date_end);
        var link="";
        $.each(data.lampiran_ttd, function (i, v) {
         link+="<a class='btn btn-primary btn-lihat' data-toggle='modal' data-target='#ModalPDF' data-load-url='"+ v.url +"'><i class='glyphicon glyphicon-paperclip'></i>  Lihat Lampiran</a> ";

        })
        $(".f_file_mou").html(link);

        if(set_content_reset!==undefined){
          set_content_reset();
        }
    });

    if(select_kontrak_mou.data('id')!==""){
      var text_mou = $(".text-mou").val();
      var newOption_ = new Option(text_mou, select_kontrak_mou.data('id'), false, true);
      select_kontrak_mou.append(newOption_);
      select_kontrak_mou.val(select_kontrak_mou.data('id')).change();

      $.ajax({
        url: '{!! route('doc.get-select-kontrak') !!}',
        type: 'GET',
        dataType: 'json',
        data: {
            q: text_mou, // search term
            type:'mou'
        }
      })
      .done(function(data) {
        var o = {};
        $.each(data.data, function (i, v) {
            //var o = {};
            var startdate=(v.doc_startdate!==null)?$.format.date(v.doc_startdate+" 10:54:50", "dd-MM-yyyy"):'-';
            var enddate=(v.doc_enddate!==null)?$.format.date(v.doc_enddate+" 10:54:50", "dd-MM-yyyy"):'-';
            o.id = v.id;
            o.name = v.doc_title;
            o.value = v.doc_no;
            o.date = $.format.date(v.doc_date+" 10:54:50", "ddd, dd MMMM yyyy");
            o.date_start = startdate;
            o.date_end = enddate;
            o.type = v.type;
            o.jenis = v.jenis;
            o.nama_supplier = v.supplier.bdn_usaha+"."+v.supplier.nm_vendor;
            o.lampiran_ttd=v.lampiran_ttd;
        })
        select_mou(o);
        //console.log(JSON.stringify(o));
      });
    }

    function select_mou(data){
        $(".f_judul_mou").text(data.name);
        $(".f_tanggal_mou").text(data.date_start + " - " + data.date_end);
        var link="";
        $.each(data.lampiran_ttd, function (i, v) {
         link+="<a class='btn btn-primary btn-lihat' data-toggle='modal' data-target='#ModalPDF' data-load-url='"+ v.url +"'><i class='glyphicon glyphicon-paperclip'></i>  Lihat Lampiran</a> ";

        })
        console.log(link);
        $(".f_file_mou").html(link);

        if(set_content_reset!==undefined){
          set_content_reset();
        }
    }

    var text_surat_pengikatan = $(".text-surat-pengikatan").val();
    var select_kontrak_surat_pengikatan = $(".select-kontrak-surat-pengikatan");
    var selectKontrak_surat_pengikatan = $(".select-kontrak-surat-pengikatan").select2({
      placeholder : "Pilih Kontrak....",
      ajax: {
          url: '{!! route('doc.get-select-kontrak') !!}',
          dataType: 'json',
          delay: 250,
          data: function (params) {
              return {
                  q: params.term, // search term
                  type:'surat_pengikatan',
                  page: params.page
              };
          },
          processResults: function (data, params) {
              var results = [];

              $.each(data.data, function (i, v) {
                  var o = {};
                  var startdate=(v.doc_startdate!==null)?$.format.date(v.doc_startdate+" 10:54:50", "dd-MM-yyyy"):'-';
                  var enddate=(v.doc_enddate!==null)?$.format.date(v.doc_enddate+" 10:54:50", "dd-MM-yyyy"):'-';
                  o.id = v.id;
                  o.name = v.doc_title;
                  o.value = v.doc_no;
                  o.date = $.format.date(v.doc_date+" 10:54:50", "ddd, dd MMMM yyyy");
                  o.date_start = startdate;
                  o.date_end = enddate;
                  o.type = v.type;
                  o.jenis = v.jenis;
                  o.nama_supplier = v.supplier.bdn_usaha+"."+v.supplier.nm_vendor;
                  o.lampiran_ttd=v.lampiran_ttd;
                  results.push(o);
              })
              params.page = params.page || 1;
              return {
                  results: results,
                  pagination: {
                      more: (data.next_page_url ? true: false)
                  }
              };
          },
          cache: true
      },
      minimumInputLength: 0,
      escapeMarkup: function (markup) { return markup; },
      templateResult: function (state) {
          if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ; }
          var $state = $(
              '<span>' +  state.name +' <i>('+  state.value + ')</i></span>'
          );
          return $state;
      },
      templateSelection: function (data) {
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return 'Cari Nomor/Judul Kontrak';
          }
          var render = data.value;
          if(data.value === undefined){
            render = $('.select-kontrak-surat-pengikatan :selected').text();
          }
          $('.text-surat-pengikatan').val(render);
          return render ;
      }
    });

    selectKontrak_surat_pengikatan.on('select2:select', function (e) {
        var data = e.params.data;
        $(".f_judul_surat_pengikatan").text(data.name);
        $(".f_tanggal_surat_pengikatan").text(data.date_start + " - " + data.date_end);
        var link="";
        $.each(data.lampiran_ttd, function (i, v) {
         link+="<a class='btn btn-primary btn-lihat' data-toggle='modal' data-target='#ModalPDF' data-load-url='"+ v.url +"'><i class='glyphicon glyphicon-paperclip'></i>  Lihat Lampiran</a> ";

        })
        $(".f_file_surat_pengikatan").html(link);
        if(set_content_reset!==undefined){
          set_content_reset();
        }
    });

    if(select_kontrak_surat_pengikatan.data('id')!==""){
      var text_surat_pengikatan = $(".text-surat-pengikatan").val();
      var newOption_ = new Option(text_surat_pengikatan, select_kontrak_surat_pengikatan.data('id'), false, true);
      select_kontrak_surat_pengikatan.append(newOption_);
      select_kontrak_surat_pengikatan.val(select_kontrak_surat_pengikatan.data('id')).change();

      $.ajax({
        url: '{!! route('doc.get-select-kontrak') !!}',
        type: 'GET',
        dataType: 'json',
        data: {
            q: text_surat_pengikatan,
            type:'surat_pengikatan'
        }
      })
      .done(function(data) {
        var o = {};
        $.each(data.data, function (i, v) {
            var startdate=(v.doc_startdate!==null)?$.format.date(v.doc_startdate+" 10:54:50", "dd-MM-yyyy"):'-';
            var enddate=(v.doc_enddate!==null)?$.format.date(v.doc_enddate+" 10:54:50", "dd-MM-yyyy"):'-';
            o.id = v.id;
            o.name = v.doc_title;
            o.value = v.doc_no;
            o.date = $.format.date(v.doc_date+" 10:54:50", "ddd, dd MMMM yyyy");
            o.date_start = startdate;
            o.date_end = enddate;
            o.type = v.type;
            o.jenis = v.jenis;
            o.nama_supplier = v.supplier.bdn_usaha+"."+v.supplier.nm_vendor;
            o.lampiran_ttd=v.lampiran_ttd;
        })
        select_surat_pengikatan(o);
      });
    }

    function select_surat_pengikatan(data){
      $(".f_judul_surat_pengikatan").text(data.name);
        $(".f_tanggal_surat_pengikatan").text(data.date_start + " - " + data.date_end);
        var link="";
        $.each(data.lampiran_ttd, function (i, v) {
         link+="<a class='btn btn-primary btn-lihat' data-toggle='modal' data-target='#ModalPDF' data-load-url='"+ v.url +"'><i class='glyphicon glyphicon-paperclip'></i>  Lihat Lampiran</a> ";

        })
        $(".f_file_surat_pengikatan").html(link);
        if(set_content_reset!==undefined){
          set_content_reset();
        }
    }
    */
  });
</script>
@endpush
