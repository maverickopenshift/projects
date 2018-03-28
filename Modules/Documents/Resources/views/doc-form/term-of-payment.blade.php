<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">

    </h3>
  </div>

  <div class="box-body">
    <div class="form-horizontal">

      <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;"></div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nilai Kontrak </label>
          <div class="col-sm-6 text-me text-uppercase"><span class="mtu-set"></span> <span class="total-harga-kontrak"></span></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Periode Kontrak </label>
          <div class="col-sm-6 text-me text-uppercase__"><span class="periode-kontrak"></span></div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-parent-top" width="100%">
            <thead>
              <tr>
                <th>Deskripsi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Harga per Periode</th>
                <th>Target BAPP</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-isi">
            </tbody>
          </table>
        </div>

      </div>

      @include('documents::partials.buttons')
    </div>
  </div>
</div>
@push('scripts')
<script>
$(document).ready(function(e){
  $('input[name="doc_value"]').on('keyup', function(event) {
    event.preventDefault();
    /* Act on the event */
    $('.total-harga-kontrak').text($(this).val());
  });
  $('input[name="doc_enddate"]').on('change', function(event) {
    $('.periode-kontrak').text($('input[name="doc_startdate"]').val()+' s.d '+$(this).val());
  });
});
  normal();

  function normal(){
    var new_row = $(template_add()).clone(true);
    $(".table-isi").append(new_row);
    var input_new_row = new_row.find('td');
    input_new_row.eq(1).find('.top-date').addClass("date");
    input_new_row.eq(1).find('.top-datepicker').addClass("datepicker");

    var matauang=$(".top_matauang").val();
    $(".top-matauang-set").html(matauang);

    $('.date').datepicker({
     format: 'dd-mm-yyyy',
     autoclose:true,
     todayHighlight:true
    });
  }

  $(document).on('change', '.top_matauang', function(event) {
    var matauang=$(".top_matauang").val();
    $(".top-matauang-set").html(matauang);
  });

  $(document).on('click', '.add-top', function(event) {
    var new_row = $(template_add()).clone(true).insertAfter(".tabel-top:last");
    var input_new_row = new_row.find('td');
    input_new_row.eq(1).find('.top-date').addClass("date");
    input_new_row.eq(1).find('.top-datepicker').addClass("datepicker");

    fix_no_error();

    $('.date').datepicker({
     format: 'dd-mm-yyyy',
     autoclose:true,
     todayHighlight:true
    });
  });

  $(document).on('click', '.delete-top', function(e){
    var rowCount = $('.table-parent-top tr:last').index() + 1;
    if(rowCount!=1){
        $(this).closest('tr').remove();
        fix_no_error();
    }else{
      bootbox.alert({
        title:"Pemberitahuan",
        message: "Jika jumlah baris hanya ada 1 tidak bisa di hapus, silahkan tambah sebelum menghapus!",
      });
    }
  });

  function template_add(){
    return '\
    <tr class="tabel-top">\
      <td class="formerror formerror-top_deskripsi-0">\
        <input type="text" class="form-control" name="top_deskripsi[]" autocomplete="off" placeholder="Deskripsi..">\
        <div class="error error-top_deskripsi error-top_deskripsi-0"></div>\
      </td>\
      <td class="formerror formerror-top_tanggal_mulai-0">\
        <div class="input-group top-date" data-provide="datepicker">\
          <div class="input-group-addon">\
            <span class="fa fa-calendar"></span>\
          </div>\
          <input type="text" class="form-control top-datepicker" name="top_tanggal_mulai[]" autocomplete="off" placeholder="Tanggal Mulai..">\
        </div>\
        <div class="error error-top_tanggal_mulai error-top_tanggal_mulai-0"></div>\
      </td>\
      <td class="formerror formerror-top_tanggal_selesai-0">\
        <div class="input-group date" data-provide="datepicker">\
          <div class="input-group-addon">\
            <span class="fa fa-calendar"></span>\
          </div>\
          <input type="text" class="form-control datepicker" name="top_tanggal_selesai[]" autocomplete="off" placeholder="Tanggal Selesai..">\
        </div>\
        <div class="error error-top_tanggal_selesai error-top_tanggal_selesai-0"></div>\
      </td>\
      <td class="formerror formerror-top_harga-0">\
        <div class="input-group">\
          <div class="input-group-addon top-matauang-set">\
          </div>\
          <input type="text" class="form-control input-rupiah" name="top_harga[]" autocomplete="off" placeholder="Harga per Periode..">\
        </div>\
        <div class="error error-top_harga error-top_harga-0"></div>\
      </td>\
      <td class="formerror formerror-top_tanggal_bapp-0">\
        <div class="input-group date" data-provide="datepicker">\
          <div class="input-group-addon">\
            <span class="fa fa-calendar"></span>\
          </div>\
          <input type="text" class="form-control datepicker" name="top_tanggal_bapp[]" autocomplete="off" placeholder="Tanggal BAPP..">\
        </div>\
        <div class="error error-top_tanggal_bapp error-top_tanggal_bapp-0"></div>\
      </td>\
      <td width="100px">\
        <div class="btn-group">\
          <a class="btn btn-primary add-top">\
            <i class="glyphicon glyphicon-plus"></i>\
          </a>\
          <a class="btn bg-red delete-top" style="margin-bottom: 2px;">\
            <i class="glyphicon glyphicon-trash"></i>\
          </a>\
        </div>\
      </td>\
    </tr>';
  }

  function fix_no_error(){
    var matauang=$(".top_matauang").val();
    $(".top-matauang-set").html(matauang);

    var $this = $('.tabel-top');
    $.each($this,function(index, el) {
      var mdf_new_row = $(this).find('td');

      if(mdf_new_row.eq(0).hasClass("has-error")){
          mdf_new_row.eq(0).removeClass().addClass("has-error formerror formerror-top_deskripsi-"+ index);
      }else{
          mdf_new_row.eq(0).removeClass().addClass("formerror formerror-top_deskripsi-"+ index);
      }

      if(mdf_new_row.eq(1).hasClass("has-error")){
          mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-top_tanggal_mulai-"+ index);
      }else{
          mdf_new_row.eq(1).removeClass().addClass("formerror formerror-top_tanggal_mulai-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
          mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-top_tanggal_selesai-"+ index);
      }else{
          mdf_new_row.eq(2).removeClass().addClass("formerror formerror-top_tanggal_selesai-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
          mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-top_harga-"+ index);
      }else{
          mdf_new_row.eq(3).removeClass().addClass("formerror formerror-top_harga-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
          mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-top_tanggal_bapp-"+ index);
      }else{
          mdf_new_row.eq(4).removeClass().addClass("formerror formerror-top_tanggal_bapp-"+ index);
      }

      $(this).find('.error-top_deskripsi').removeClass().addClass("error error-top_deskripsi error-top_deskripsi-"+ index);
      $(this).find('.error-top_tanggal_mulai').removeClass().addClass("error error-top_tanggal_mulai error-top_tanggal_mulai-"+ index);
      $(this).find('.error-top_tanggal_selesai').removeClass().addClass("error error-top_tanggal_selesai error-top_tanggal_selesai-"+ index);
      $(this).find('.error-top_harga').removeClass().addClass("error error-top_harga error-top_harga-"+ index);
      $(this).find('.error-top_tanggal_bapp').removeClass().addClass("error error-top_tanggal_bapp error-top_tanggal_bapp-"+ index);

    });
  }


/*
$(function() {
  $('.upload-daftar_harga').on('click', function(event) {
    event.stopPropagation();
    event.preventDefault();

    $('.error-daftar_harga').html('');
    var $file = $('.daftar_harga').click();
  });

  $('.daftar_harga').on('change', function(event) {
    // $('.btn_submit').click();
    event.stopPropagation();
    event.preventDefault();

    var loading = $('.loading2');
    var form_user =  $('#form_me_boq');
    loading.show();
    $.ajax({
      url: form_user.attr('action'),
      type: 'post',
      processData: false,
      contentType: false,
      data: new FormData(document.getElementById("form_me_boq")),
      dataType: 'json',
    })
    .done(function(data) {
    if(data.status){
      handleDaftarHargaFileSelect(data);
    }
    else{
      $('.error-daftar_harga').html('Format File tidak valid!');
        return false;
    }
    loading.hide();
    })
    .always(function(){
      loading.hide();
    });
  });

});

function handleDaftarHargaFileSelect(data) {
      var $this = $('#table-hargasatuan');
      var tbody = $this.find('tbody');
      var parse_row,btn_del;
      // console.log(data.data.length);exit();

      if(data.data.length>1){
        btn_del = '<button type="button" class="btn btn-danger btn-xs delete-hs"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
      }

      $.each(data.data,function(index, el) {
        // if(data[index].KODE_ITEM!=""){
        var dt = data.data;
          row_html = templateHS(dt[index],index);
          row_html = $(row_html).clone();
          row_html.find('.action').html(btn_del);
          parse_row += $('<tr>').append(row_html).html();
        // }
      });

      tbody.append(parse_row);

      var row =  $('#table-hargasatuan').find('tbody>tr');
      $.each(row,function(index, el) {
        var mdf = $(this).find('.action');
        var mdf_new_row = $(this).find('td');
        mdf_new_row.eq(0).html(index+1);
        @php
          if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs'){
        @endphp
          if(mdf_new_row.eq(1).hasClass("has-error")){
          mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-hs_kode_item-"+ index);
          }else{
            mdf_new_row.eq(1).removeClass().addClass("formerror formerror-hs_kode_item-"+ index);
          }

          if(mdf_new_row.eq(2).hasClass("has-error")){
            mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-hs_item-"+ index);
          }else{
            mdf_new_row.eq(2).removeClass().addClass("formerror formerror-hs_item-"+ index);
          }

          if(mdf_new_row.eq(3).hasClass("has-error")){
            mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-hs_qty-"+ index);
          }else{
            mdf_new_row.eq(3).removeClass().addClass("formerror formerror-hs_qty-"+ index);
          }

          if(mdf_new_row.eq(4).hasClass("has-error")){
            mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-hs_satuan-"+ index);
          }else{
            mdf_new_row.eq(4).removeClass().addClass("formerror formerror-hs_satuan-"+ index);
          }

          if(mdf_new_row.eq(5).hasClass("has-error")){
            mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-hs_mtu-"+ index);
          }else{
            mdf_new_row.eq(5).removeClass().addClass("formerror formerror-hs_mtu-"+ index);
          }

          if(mdf_new_row.eq(6).hasClass("has-error")){
            mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-hs_harga-"+ index);
          }else{
            mdf_new_row.eq(6).removeClass().addClass("formerror formerror-hs_harga-"+ index);
          }

          if(mdf_new_row.eq(7).hasClass("has-error")){
            mdf_new_row.eq(7).removeClass().addClass("has-error formerror formerror-hs_harga_jasa-"+ index);
          }else{
            mdf_new_row.eq(7).removeClass().addClass("formerror formerror-hs_harga_jasa-"+ index);
          }

          if(mdf_new_row.eq(9).hasClass("has-error")){
            mdf_new_row.eq(9).removeClass().addClass("has-error formerror formerror-hs_keterangan-"+ index);
          }else{
            mdf_new_row.eq(9).removeClass().addClass("formerror formerror-hs_keterangan-"+ index);
          }

          mdf_new_row.eq(1).find('.error-hs_kode_item').removeClass().addClass("error error-hs_kode_item error-hs_kode_item-"+ index);
          mdf_new_row.eq(2).find('.error-hs_item').removeClass().addClass("error error-hs_item error-hs_item-"+ index);
          mdf_new_row.eq(3).find('.error-hs_qty').removeClass().addClass("error error-hs_qty error-hs_qty-"+ index);
          mdf_new_row.eq(4).find('.error-hs_satuan').removeClass().addClass("error error-hs_satuan error-hs_satuan-"+ index);
          mdf_new_row.eq(5).find('.error-hs_mtu').removeClass().addClass("error error-hs_mtu error-hs_mtu-"+ index);
          mdf_new_row.eq(6).find('.error-hs_harga').removeClass().addClass("error error-hs_harga error-hs_harga-"+ index);
          mdf_new_row.eq(7).find('.error-hs_harga_jasa').removeClass().addClass("error error-hs_harga_jasa error-hs_harga_jasa-"+ index);
          mdf_new_row.eq(9).find('.error-hs_keterangan').removeClass().addClass("error error-pic_posisi error-hs_keterangan-"+ index);
        @php
        }else{
        @endphp
          if(mdf_new_row.eq(1).hasClass("has-error")){
          mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-hs_kode_item-"+ index);
          }else{
            mdf_new_row.eq(1).removeClass().addClass("formerror formerror-hs_kode_item-"+ index);
          }

          if(mdf_new_row.eq(2).hasClass("has-error")){
            mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-hs_item-"+ index);
          }else{
            mdf_new_row.eq(2).removeClass().addClass("formerror formerror-hs_item-"+ index);
          }

          if(mdf_new_row.eq(3).hasClass("has-error")){
            mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-hs_satuan-"+ index);
          }else{
            mdf_new_row.eq(3).removeClass().addClass("formerror formerror-hs_satuan-"+ index);
          }

          if(mdf_new_row.eq(4).hasClass("has-error")){
            mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-hs_mtu-"+ index);
          }else{
            mdf_new_row.eq(4).removeClass().addClass("formerror formerror-hs_mtu-"+ index);
          }

          if(mdf_new_row.eq(5).hasClass("has-error")){
            mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-hs_harga-"+ index);
          }else{
            mdf_new_row.eq(5).removeClass().addClass("formerror formerror-hs_harga-"+ index);
          }

          if(mdf_new_row.eq(6).hasClass("has-error")){
            mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-hs_harga_jasa-"+ index);
          }else{
            mdf_new_row.eq(6).removeClass().addClass("formerror formerror-hs_harga_jasa-"+ index);
          }

          if(mdf_new_row.eq(7).hasClass("has-error")){
            mdf_new_row.eq(7).removeClass().addClass("has-error formerror formerror-hs_keterangan-"+ index);
          }else{
            mdf_new_row.eq(7).removeClass().addClass("formerror formerror-hs_keterangan-"+ index);
          }

          mdf_new_row.eq(1).find('.error-hs_kode_item').removeClass().addClass("error error-hs_kode_item error-hs_kode_item-"+ index);
          mdf_new_row.eq(2).find('.error-hs_item').removeClass().addClass("error error-hs_item error-hs_item-"+ index);
          mdf_new_row.eq(3).find('.error-hs_satuan').removeClass().addClass("error error-hs_satuan error-hs_satuan-"+ index);
          mdf_new_row.eq(4).find('.error-hs_mtu').removeClass().addClass("error error-hs_mtu error-hs_mtu-"+ index);
          mdf_new_row.eq(5).find('.error-hs_harga').removeClass().addClass("error error-hs_harga error-hs_harga-"+ index);
          mdf_new_row.eq(6).find('.error-hs_harga_jasa').removeClass().addClass("error error-hs_harga_jasa error-hs_harga_jasa-"+ index);
          mdf_new_row.eq(7).find('.error-hs_keterangan').removeClass().addClass("error error-pic_posisi error-hs_keterangan-"+ index);
        @php
        }
        @endphp

        if(row.length==1){
          mdf.html('');
        }else{
          mdf.html(btn_del);
        }
      });
}

function templateHS(dt,index) {
  // console.log(dt);exit();
  var qty,harga_total,a,b;
  if(dt.mtu=="USD"){
    a="";
    b="selected";
  }else{
    a="selected";
    b="";
  }

  @php
    if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs'){
      echo "qty = '<td>\
          <input type=\"text\" class=\"form-control input-rupiah hitung_total\" name=\"hs_qty[]\" value=\"'+dt.qty+'\" />\
          <div class=\"error error-hs_qty\"></div>\
          </td>';";
      echo "harga_total = (dt.harga+dt.harga_jasa)*dt.qty;";
      echo "harga_total = '<td style=\"vertical-align: middle;\" class=\"text-right\">'+formatRupiah(harga_total.toString())+'</td>';";
    }
  @endphp

  return '<tr>\
    <td>'+(index+1)+'</td>\
    <td>\
      <input type="text" class="form-control" name="hs_kode_item[]" value="'+dt.kode_item+'" />\
      <div class="error error-hs_kode_item"></div>\
    </td>\
    <td>\
      <input type="text" class="form-control" name="hs_item[]" value="'+dt.item+'" />\
      <div class="error error-hs_item"></div>\
    </td>\
      '+qty+'\
    <td>\
      <input type="text" class="form-control" name="hs_satuan[]" value="'+dt.satuan+'" />\
      <div class="error error-hs_satuan"></div>\
    </td>\
    <td>\
      <select name="hs_mtu[]" class="form-control" style="width: 100%;">\
        <option value="IDR" '+ a +'>IDR</option>\
        <option value="USD" '+ b +'>USD</option>\
      </select>\
      <div class="error error-hs_mtu"></div>\
    </td>\
    <td>\
      <input type="text" class="form-control input-rupiah hitung_total" name="hs_harga[]" value="'+formatRupiah(dt.harga)+'" />\
      <div class="error error-hs_harga"></div>\
    </td>\
    <td>\
      <input type="text" class="form-control input-rupiah hitung_total" name="hs_harga_jasa[]" value="'+formatRupiah(dt.harga_jasa)+'" />\
      <div class="error error-hs_harga_jasa"></div>\
    </td>\
      '+harga_total+'\
    <td>\
      <input type="text" class="form-control" name="hs_keterangan[]" value="'+dt.keterangan+'" />\
    </td>\
    <td class="action"></td>\
  </tr>';
}

$(document).on('click', '.add-harga_satuan', function(event) {
  event.preventDefault();
  var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-hs"><i class="glyphicon glyphicon-remove"></i> hapus</button>';

  var $this = $('#table-hargasatuan');

  var row = $this.find('tbody>tr');
  var new_row = row.eq(0).clone();
  var mdf_new_row = new_row.find('td');
  mdf_new_row.eq(0).html(row.length+1);
  mdf_new_row.eq(1).find('input').val('');
  mdf_new_row.eq(1).find('.error').html('');
  mdf_new_row.eq(2).find('input').val('');
  mdf_new_row.eq(2).find('.error').html('');
  mdf_new_row.eq(3).find('input').val('');
  mdf_new_row.eq(3).find('.error').html('');
  mdf_new_row.eq(4).find('input').val('');
  mdf_new_row.eq(4).find('.error').html('');
  mdf_new_row.eq(5).find('input').val('');
  mdf_new_row.eq(5).find('.error').html('');
  mdf_new_row.eq(6).find('input').val('');
  mdf_new_row.eq(6).find('.error').html('');
  mdf_new_row.eq(7).find('input').val('');
  mdf_new_row.eq(7).find('.error').html('');

  @php
    if($doc_type->name!='khs'){
      echo "
        mdf_new_row.eq(8).html('0');
        mdf_new_row.eq(9).find('input').val('');
        mdf_new_row.eq(9).find('.error').html('');
      ";
    }
  @endphp

  $this.find('tbody').append(new_row);

  var row = $this.find('tbody>tr');
  $.each(row,function(index, el) {
    var mdf = $(this).find('.action');
    var mdf_new_row = $(this).find('td');
    mdf_new_row.eq(0).html(index+1);
    @php
      if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs'){
    @endphp
      if(mdf_new_row.eq(1).hasClass("has-error")){
      mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-hs_kode_item-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("formerror formerror-hs_kode_item-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-hs_item-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("formerror formerror-hs_item-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-hs_qty-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("formerror formerror-hs_qty-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-hs_satuan-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("formerror formerror-hs_satuan-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-hs_mtu-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("formerror formerror-hs_mtu-"+ index);
      }

      if(mdf_new_row.eq(6).hasClass("has-error")){
        mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-hs_harga-"+ index);
      }else{
        mdf_new_row.eq(6).removeClass().addClass("formerror formerror-hs_harga-"+ index);
      }

      if(mdf_new_row.eq(7).hasClass("has-error")){
        mdf_new_row.eq(7).removeClass().addClass("has-error formerror formerror-hs_harga_jasa-"+ index);
      }else{
        mdf_new_row.eq(7).removeClass().addClass("formerror formerror-hs_harga_jasa-"+ index);
      }

      if(mdf_new_row.eq(9).hasClass("has-error")){
        mdf_new_row.eq(9).removeClass().addClass("has-error formerror formerror-hs_keterangan-"+ index);
      }else{
        mdf_new_row.eq(9).removeClass().addClass("formerror formerror-hs_keterangan-"+ index);
      }

      mdf_new_row.eq(1).find('.error-hs_kode_item').removeClass().addClass("error error-hs_kode_item error-hs_kode_item-"+ index);
      mdf_new_row.eq(2).find('.error-hs_item').removeClass().addClass("error error-hs_item error-hs_item-"+ index);
      mdf_new_row.eq(3).find('.error-hs_qty').removeClass().addClass("error error-hs_qty error-hs_qty-"+ index);
      mdf_new_row.eq(4).find('.error-hs_satuan').removeClass().addClass("error error-hs_satuan error-hs_satuan-"+ index);
      mdf_new_row.eq(5).find('.error-hs_mtu').removeClass().addClass("error error-hs_mtu error-hs_mtu-"+ index);
      mdf_new_row.eq(6).find('.error-hs_harga').removeClass().addClass("error error-hs_harga error-hs_harga-"+ index);
      mdf_new_row.eq(7).find('.error-hs_harga_jasa').removeClass().addClass("error error-hs_harga_jasa error-hs_harga_jasa-"+ index);
      mdf_new_row.eq(9).find('.error-hs_keterangan').removeClass().addClass("error error-pic_posisi error-hs_keterangan-"+ index);
    @php
    }else{
    @endphp
      if(mdf_new_row.eq(1).hasClass("has-error")){
      mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-hs_kode_item-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("formerror formerror-hs_kode_item-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-hs_item-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("formerror formerror-hs_item-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-hs_satuan-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("formerror formerror-hs_satuan-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-hs_mtu-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("formerror formerror-hs_mtu-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-hs_harga-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("formerror formerror-hs_harga-"+ index);
      }

      if(mdf_new_row.eq(6).hasClass("has-error")){
        mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-hs_harga_jasa-"+ index);
      }else{
        mdf_new_row.eq(6).removeClass().addClass("formerror formerror-hs_harga_jasa-"+ index);
      }

      if(mdf_new_row.eq(7).hasClass("has-error")){
        mdf_new_row.eq(7).removeClass().addClass("has-error formerror formerror-hs_keterangan-"+ index);
      }else{
        mdf_new_row.eq(7).removeClass().addClass("formerror formerror-hs_keterangan-"+ index);
      }

      mdf_new_row.eq(1).find('.error-hs_kode_item').removeClass().addClass("error error-hs_kode_item error-hs_kode_item-"+ index);
      mdf_new_row.eq(2).find('.error-hs_item').removeClass().addClass("error error-hs_item error-hs_item-"+ index);
      mdf_new_row.eq(3).find('.error-hs_satuan').removeClass().addClass("error error-hs_satuan error-hs_satuan-"+ index);
      mdf_new_row.eq(4).find('.error-hs_mtu').removeClass().addClass("error error-hs_mtu error-hs_mtu-"+ index);
      mdf_new_row.eq(5).find('.error-hs_harga').removeClass().addClass("error error-hs_harga error-hs_harga-"+ index);
      mdf_new_row.eq(6).find('.error-hs_harga_jasa').removeClass().addClass("error error-hs_harga_jasa error-hs_harga_jasa-"+ index);
      mdf_new_row.eq(7).find('.error-hs_keterangan').removeClass().addClass("error error-pic_posisi error-hs_keterangan-"+ index);
    @php
    }
    @endphp

    if(row.length==1){
      mdf.html('');
    }else{
      mdf.html(btn_del);
    }
  });
});

$(document).on('click', '.delete-hs', function(event) {
  $(this).parent().parent().remove();
  var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-hs"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
  var $this = $('#table-hargasatuan');
  var row = $this.find('tbody>tr');

  var row = $this.find('tbody>tr');
  $.each(row,function(index, el) {
    var mdf = $(this).find('.action');
    var mdf_new_row = $(this).find('td');
    mdf_new_row.eq(0).html(index+1);
    @php
      if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs'){
    @endphp
      if(mdf_new_row.eq(1).hasClass("has-error")){
      mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-hs_kode_item-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("formerror formerror-hs_kode_item-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-hs_item-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("formerror formerror-hs_item-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-hs_qty-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("formerror formerror-hs_qty-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-hs_satuan-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("formerror formerror-hs_satuan-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-hs_mtu-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("formerror formerror-hs_mtu-"+ index);
      }

      if(mdf_new_row.eq(6).hasClass("has-error")){
        mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-hs_harga-"+ index);
      }else{
        mdf_new_row.eq(6).removeClass().addClass("formerror formerror-hs_harga-"+ index);
      }

      if(mdf_new_row.eq(7).hasClass("has-error")){
        mdf_new_row.eq(7).removeClass().addClass("has-error formerror formerror-hs_harga_jasa-"+ index);
      }else{
        mdf_new_row.eq(7).removeClass().addClass("formerror formerror-hs_harga_jasa-"+ index);
      }

      if(mdf_new_row.eq(9).hasClass("has-error")){
        mdf_new_row.eq(9).removeClass().addClass("has-error formerror formerror-hs_keterangan-"+ index);
      }else{
        mdf_new_row.eq(9).removeClass().addClass("formerror formerror-hs_keterangan-"+ index);
      }

      mdf_new_row.eq(1).find('.error-hs_kode_item').removeClass().addClass("error error-hs_kode_item error-hs_kode_item-"+ index);
      mdf_new_row.eq(2).find('.error-hs_item').removeClass().addClass("error error-hs_item error-hs_item-"+ index);
      mdf_new_row.eq(3).find('.error-hs_qty').removeClass().addClass("error error-hs_qty error-hs_qty-"+ index);
      mdf_new_row.eq(4).find('.error-hs_satuan').removeClass().addClass("error error-hs_satuan error-hs_satuan-"+ index);
      mdf_new_row.eq(5).find('.error-hs_mtu').removeClass().addClass("error error-hs_mtu error-hs_mtu-"+ index);
      mdf_new_row.eq(6).find('.error-hs_harga').removeClass().addClass("error error-hs_harga error-hs_harga-"+ index);
      mdf_new_row.eq(7).find('.error-hs_harga_jasa').removeClass().addClass("error error-hs_harga_jasa error-hs_harga_jasa-"+ index);
      mdf_new_row.eq(9).find('.error-hs_keterangan').removeClass().addClass("error error-pic_posisi error-hs_keterangan-"+ index);
    @php
    }else{
    @endphp
      if(mdf_new_row.eq(1).hasClass("has-error")){
      mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-hs_kode_item-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("formerror formerror-hs_kode_item-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-hs_item-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("formerror formerror-hs_item-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-hs_satuan-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("formerror formerror-hs_satuan-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-hs_mtu-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("formerror formerror-hs_mtu-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-hs_harga-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("formerror formerror-hs_harga-"+ index);
      }

      if(mdf_new_row.eq(6).hasClass("has-error")){
        mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-hs_harga_jasa-"+ index);
      }else{
        mdf_new_row.eq(6).removeClass().addClass("formerror formerror-hs_harga_jasa-"+ index);
      }

      if(mdf_new_row.eq(7).hasClass("has-error")){
        mdf_new_row.eq(7).removeClass().addClass("has-error formerror formerror-hs_keterangan-"+ index);
      }else{
        mdf_new_row.eq(7).removeClass().addClass("formerror formerror-hs_keterangan-"+ index);
      }

      mdf_new_row.eq(1).find('.error-hs_kode_item').removeClass().addClass("error error-hs_kode_item error-hs_kode_item-"+ index);
      mdf_new_row.eq(2).find('.error-hs_item').removeClass().addClass("error error-hs_item error-hs_item-"+ index);
      mdf_new_row.eq(3).find('.error-hs_satuan').removeClass().addClass("error error-hs_satuan error-hs_satuan-"+ index);
      mdf_new_row.eq(4).find('.error-hs_mtu').removeClass().addClass("error error-hs_mtu error-hs_mtu-"+ index);
      mdf_new_row.eq(5).find('.error-hs_harga').removeClass().addClass("error error-hs_harga error-hs_harga-"+ index);
      mdf_new_row.eq(6).find('.error-hs_harga_jasa').removeClass().addClass("error error-hs_harga_jasa error-hs_harga_jasa-"+ index);
      mdf_new_row.eq(7).find('.error-hs_keterangan').removeClass().addClass("error error-pic_posisi error-hs_keterangan-"+ index);
    @php
    }
    @endphp

    if(row.length==1){
      mdf.html('');
    }else{
      mdf.html(btn_del);
    }
  });
});

$(document).on('keyup', '.hitung_total', function(event) {
  var _this = $(this),harga_total;
  var td_length = _this.parent().parent().find('td');

  if(td_length.length==11){
    if(_this.attr('name')=='hs_qty[]'){
      var qty = _this.val();
    }else{
      var qty = _this.parent().parent().find('input[name="hs_qty[]"]').val();
    }

    if(_this.attr('name')=='hs_harga[]'){
      var harga = _this.val();
    }else{
      var harga = _this.parent().parent().find('input[name="hs_harga[]"]').val();
    }

    if(_this.attr('name')=='hs_harga_jasa[]'){
      var harga_jasa = _this.val();
    }else{
      var harga_jasa = _this.parent().parent().find('input[name="hs_harga_jasa[]"]').val();
    }

    if(harga==""){
      harga = 0
    }

    if(harga_jasa==""){
      harga_jasa = 0
    }

    if(qty==""){
      qty = 0
    }

    harga = backNominal(harga);
    harga_jasa = backNominal(harga_jasa);
    qty = backNominal(qty);

    harga_total = (harga+harga_jasa)*qty;
    harga_total = convertNumber(harga_total);
    _this.parent().parent().find('td').eq(8).text(formatRupiah(harga_total));
  }
});
*/
</script>
@endpush
