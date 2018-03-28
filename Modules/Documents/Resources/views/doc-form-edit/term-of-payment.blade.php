<div class="box">

  @php
    $doc_top_matauang=Helper::old_prop($doc,'doc_top_matauang');
    $doc_top_totalharga=Helper::old_prop($doc,'doc_top_totalharga');

    if($doc_top_matauang=="IDR"){
      $a="selected";
      $b="";
    }
    else if($doc_top_matauang=="USD"){
      $a="";
      $b="selected";
    }else{
      $a="";
      $b="";
    }
  @endphp



  <div class="box-body">
    <div class="form-horizontal">

      <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;"></div>
        </div>
        
        @if($doc_type->name != 'amandemen_kontrak_turnkey')
          <div class="form-group">
            <label class="col-sm-2 control-label">Nilai Kontrak </label>
            <div class="col-sm-6 text-me text-uppercase"><span class="mtu-set"></span> <span class="total-harga-kontrak"></span></div>
          </div>
        @endif
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
                <th>Harga</th>
                <th>Target BAPP</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-isi">
              @if(count($doc->doc_top)>0)
                @foreach ($doc->doc_top as $key => $dt)
                  <tr class="tabel-top">

                    <td class="formerror formerror-top_deskripsi-{{$key}}">
                      <input type="text" class="form-control" name="top_deskripsi[]" autocomplete="off" placeholder="Deskripsi.." value="{{$dt->top_deskripsi}}">
                      <div class="error error-top_deskripsi error-top_deskripsi-{{$key}}"></div>
                    </td>

                    <td class="formerror formerror-top_tanggal_mulai-{{$key}}">
                      <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control datepicker" name="top_tanggal_mulai[]" autocomplete="off" placeholder="Tanggal Mulai.." value="{{Helper::date_set($dt->top_tanggal_mulai)}}">
                      </div>
                      <div class="error error-top_tanggal_mulai error-top_tanggal_mulai-{{$key}}"></div>
                    </td>

                    <td class="formerror formerror-top_tanggal_selesai-{{$key}}">
                      <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control datepicker" name="top_tanggal_selesai[]" autocomplete="off" placeholder="Tanggal Selesai.." value="{{Helper::date_set($dt->top_tanggal_selesai)}}">
                      </div>
                      <div class="error error-top_tanggal_selesai error-top_tanggal_selesai-{{$key}}"></div>
                    </td>

                    <td class="formerror formerror-top_harga-{{$key}}">
                      <div class="input-group">
                        <div class="input-group-addon top-matauang-set mtu-set">
                          {{$dt->doc_mtu}}
                        </div>
                        <input type="text" class="form-control input-rupiah" name="top_harga[]" autocomplete="off" placeholder="Harga per Periode.." value="{{$dt->top_harga}}">
                      </div>
                      <div class="error error-top_harga error-top_harga-{{$key}}"></div>
                    </td>

                    <td class="formerror formerror-top_tanggal_bapp-{{$key}}">
                      <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control datepicker" name="top_tanggal_bapp[]" autocomplete="off" placeholder="Tanggal BAPP.." value="{{Helper::date_set($dt->top_tanggal_bapp)}}">
                      </div>
                      <div class="error error-top_tanggal_bapp error-top_tanggal_bapp-{{$key}}"></div>
                    </td>

                    <td width="100px">
                      <div class="btn-group">
                        <a class="btn btn-primary add-top">
                          <i class="glyphicon glyphicon-plus"></i>
                        </a>
                        <a class="btn bg-red delete-top" style="margin-bottom: 2px;">
                          <i class="glyphicon glyphicon-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              @else
              @endif
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
  $('.total-harga-kontrak').text($('input[name="doc_value"]').val());
  $('.periode-kontrak').text($('input[name="doc_startdate"]').val()+' s.d '+$('input[name="doc_enddate"]').val());
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
          <div class="input-group-addon top-matauang-set mtu-set">{{$doc->doc_mtu}}\
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
</script>
@endpush
