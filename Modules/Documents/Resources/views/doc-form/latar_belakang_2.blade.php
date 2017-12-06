@php
	$text_surat_pengikatan = Helper::old_prop($doc,'text_surat_pengikatan');
	$f_no_surat_pengikatan = Helper::old_prop($doc,'f_no_surat_pengikatan');
	$text_mou = Helper::old_prop($doc,'text_mou');
	$f_no_mou = Helper::old_prop($doc,'f_no_mou');
@endphp

<div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
    <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
      <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Surat Pengikatan <span class="total_lt"></span>
      </div>
    </div>
    
    <div class="form-group">
      <label for="lt_name" class="col-sm-2 control-label"> No. Surat Pengikatan</label>
      <div class="col-sm-4">
        <input type="hidden" class="text-surat-pengikatan" name="text_surat_pengikatan" value="{{$text_surat_pengikatan}}">
        <select class="form-control select-kontrak-surat-pengikatan" style="width: 100%;" name="f_no_surat_pengikatan" data-id="{{Helper::old_prop($doc,'f_no_surat_pengikatan')}}">
          <option value="">Pilih Surat Pengikatan</option>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="lt_name" class="col-sm-2 control-label"> Judul </label>
      <div class="col-sm-4 f_judul_surat_pengikatan">

      </div>
    </div>

    <div class="form-group">
      <label for="lt_desc" class="col-sm-2 control-label"> Tanggal</label>
      <div class="col-sm-4 f_tanggal_surat_pengikatan">
       
      </div>
    </div>

    <div class="form-group">
      <label for="lt_file" class="col-sm-2 control-label"> File</label>
      <div class="col-sm-8 f_file_surat_pengikatan">

      </div>
    </div>
</div>

<div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
    <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
      <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">MoU <span class="total_lt"></span>
      </div>
    </div>

    <div class="form-group">
      <label for="lt_name" class="col-sm-2 control-label"> No. MoU</label>
      <div class="col-sm-4">
        <input type="hidden" class="text-mou" name="text_mou" value="{{$text_mou}}">
        <select class="form-control select-kontrak-mou" style="width: 100%;" name="f_no_mou" data-id="{{Helper::old_prop($doc,'f_no_mou')}}">
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="lt_name" class="col-sm-2 control-label"> Judul</label>
      <div class="col-sm-4 f_judul_mou">
      </div>
    </div>

    <div class="form-group">
      <label for="lt_desc" class="col-sm-2 control-label"> Tanggal</label>
      <div class="col-sm-4 f_tanggal_mou">

      </div>
    </div>

    <div class="form-group">
      <label for="lt_file" class="col-sm-2 control-label"> File</label>
      <div class="col-sm-8 f_file_mou">

      </div>
    </div>
</div>


@push('scripts')
<script>
  $(function() {
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
    
  });
</script>
@endpush
