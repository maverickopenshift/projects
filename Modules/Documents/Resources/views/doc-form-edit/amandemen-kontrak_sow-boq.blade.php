<div class="box utamabanget">

    <div class="box-header with-border" style="padding-bottom: 14px;">
      <h3 class="box-title">

      </h3>
      <div class="pull-right box-tools">
        <button type="button" class="btn btn-success add-sow-boq"><i class="glyphicon glyphicon-plus"></i> tambah</button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @php
        $sow_boq = Helper::old_prop_each($doc,'sow_boq');
        $f_judul = Helper::old_prop_each($doc,'f_judul');
        $f_harga = Helper::old_prop_each($doc,'f_harga');
        $f_tanggal1 = Helper::old_prop_each($doc,'f_tanggal1');
        $f_tanggal2 = Helper::old_prop_each($doc,'f_tanggal2');
        $f_isi = Helper::old_prop_each($doc,'f_isi');
      @endphp

      @if(count($sow_boq)>=1)
        @foreach ($sow_boq as $key => $value)
        @php
          $f_judul = Helper::old_prop_each($value,'meta_title');
          $f_desc = Helper::old_prop_each($value,'meta_desc');

          $f_harga="";
          $f_tanggal1="";
          $f_tanggal2="";
          $f_isi="";

          if($f_judul=="Harga"){
            $f_harga=$f_desc;
          }elseif($f_judul=="Jangka Waktu"){
            $pecah=explode("|",$f_desc);

            if(isset($pecah[0])){
              $f_tanggal1=$pecah[0];
            }else{
              $f_tanggal1="";
            }

            if(isset($pecah[1])){
              $f_tanggal2=$pecah[1];
            }else{
              $f_tanggal2="";
            }

          }elseif($f_judul=="Lainnya"){
            $f_isi=$f_desc;
          }else{
            $f_harga="";
            $f_tanggal1="";
            $f_tanggal2="";
            $f_isi="";
          }
        @endphp

        <div class="form-horizontal perubahan" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">

            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Sow-Boq <span class="total_pasal">{{$key+1}}</span></div>
              @if(count($sow_boq)>1)
                <button type="button" class="btn btn-danger delete-pasal" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
              @endif
            </div>

            <div class="form-group">
              <label for="f_judul" class="col-sm-2 control-label">Judul</label>
              <div class="col-sm-6">
                <select class="form-control f_judul" name="f_judul[]" onchange="freeText()" autocomplete="off">
                  <option value="" {!!Helper::prop_selected($f_judul,"")!!} >Pilih</option>
                  <option value="Harga" {!!Helper::prop_selected($f_judul,"Harga")!!} >Harga</option>
                  <option value="Jangka Waktu" {!!Helper::prop_selected($f_judul,"Jangka Waktu")!!} >Jangka Waktu</option>
                  <option value="Lainnya" {!!Helper::prop_selected($f_judul,"Lainnya")!!} >Lainnya</option>
                </select>
              </div>
            </div>

            <div class="form-group show_lainnya">
                <label for="f_isi" class="col-sm-2 control-label"> Isi</label>
                <div class="col-sm-10">
                  <textarea class="form-control f_isi" name="f_isi[]" cols="4" rows="4">{{$f_isi}}</textarea>
                </div>
            </div>

            <div class="form-group show_tanggal1">
                <label class="col-sm-2 control-label"> Tanggal Mulai</label>
                <div class="col-sm-6">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" name="f_tanggal1[]" value="{{$f_tanggal1}}" class="form-control f_tanggal1">
                  </div>
                </div>
            </div>

            <div class="form-group show_tanggal2">
                <label class="col-sm-2 control-label"> Tanggal Akhir </label>
                <div class="col-sm-6">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" name="f_tanggal2[]" value="{{$f_tanggal2}}" class="form-control f_tanggal2">
                  </div>
                </div>
            </div>

            <div class="form-group show_harga">
                <label for="bdn_usaha" class="col-sm-2 control-label"> Harga</label>
                <div class="col-sm-3">
                  <input type="text" name="f_harga[]" value="{{$f_harga}}" class="form-control f_harga input-rupiah">
                </div>
            </div>

          </div>
        @endforeach
      @else
        <div class="form-horizontal perubahan" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Sow-Boq <span class="total_perubahan">1</span></div>
            </div>

            <div class="form-group">
              <label for="f_judul" class="col-sm-2 control-label">Perubahan</label>
              <div class="col-sm-6">
                <select class="form-control f_judul" name="f_judul[]" onchange="freeText()"  autocomplete="off">
                  <option value="">Pilih</option>
                  <option value="Harga">Harga</option>
                  <option value="Jangka Waktu">Jangka Waktu</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>
              <div class="clearfix"></div>
              <div class="col-sm-6 col-sm-offset-2" id="tambahan">
              </div>
            </div>

            <div class="form-group show_lainnya">
                <label for="f_isi" class="col-sm-2 control-label"> Isi</label>
                <div class="col-sm-10">
                  <textarea class="form-control f_isi" name="f_isi[]" cols="4" rows="4"></textarea>
                </div>
            </div>

            <div class="form-group show_tanggal1">
                <label class="col-sm-2 control-label"> Tanggal Mulai</label>
                <div class="col-sm-6">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" name="f_tanggal1[]" class="form-control f_tanggal1">
                  </div>
                </div>
            </div>

            <div class="form-group show_tanggal2">
                <label class="col-sm-2 control-label"> Tanggal Akhir </label>
                <div class="col-sm-6">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" name="f_tanggal2[]" class="form-control f_tanggal2">
                  </div>
                </div>
            </div>

            <div class="form-group show_harga">
                <label for="bdn_usaha" class="col-sm-2 control-label"> Harga</label>
                <div class="col-sm-3">
                  <input type="text" name="f_harga[]" class="form-control f_harga input-rupiah">
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
function freeText() {
  var row = $('.perubahan');
  $.each(row,function(index, el) {
    var judul = $(this).find('.f_judul').find(":selected").val();

    if(judul=="Harga"){
      $(this).find('.show_harga').show();
      $(this).find('.show_tanggal1').hide();
      $(this).find('.show_tanggal2').hide();
      $(this).find('.show_lainnya').hide();
    }else if(judul=="Jangka Waktu"){
      $(this).find('.show_harga').hide();
      $(this).find('.show_tanggal1').show();
      $(this).find('.show_tanggal2').show();
      $(this).find('.show_lainnya').hide();
    }else if(judul=="Lainnya"){
      $(this).find('.show_harga').hide();
      $(this).find('.show_tanggal1').hide();
      $(this).find('.show_tanggal2').hide();
      $(this).find('.show_lainnya').show();
    }else{
      $(this).find('.show_harga').hide();
      $(this).find('.show_tanggal1').hide();
      $(this).find('.show_tanggal2').hide();
      $(this).find('.show_lainnya').hide();
    }

  });
}

$(function() {
  freeText();

  $(document).on('click', '.add-sow-boq', function(event) {
    event.preventDefault();

    var btn_del = '<button type="button" class="btn btn-danger delete-pasal" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
    var $this = $('.perubahan');
    var new_row = $this.eq(0).clone();

    new_row.find('.has-error').removeClass('has-error');
    var mdf_new_row = new_row.find('.form-group');

    mdf_new_row.eq(0).find('.total_perubahan').text($this+1);

    mdf_new_row.eq(1).find('.f_judul').val('');
    mdf_new_row.eq(1).find('.error').remove();

    mdf_new_row.eq(2).find('.f_isi').val('');
    mdf_new_row.eq(2).find('.error').remove();
    mdf_new_row.eq(2).hide();

    mdf_new_row.eq(3).find('.f_tanggal1').val('');
    mdf_new_row.eq(3).find('.error').remove();
    mdf_new_row.eq(3).hide();

    mdf_new_row.eq(4).find('.f_tanggal2').val('');
    mdf_new_row.eq(4).find('.error').remove();
    mdf_new_row.eq(4).hide();

    mdf_new_row.eq(5).find('.f_harga').val('');
    mdf_new_row.eq(5).find('.error').remove();
    mdf_new_row.eq(5).hide();

    $this.parent().prepend(new_row);
    new_row.find('.jdl_lain').remove();
    var row = $('.perubahan');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.delete-pasal');
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(0).find('.total_perubahan').text(index+1);
      if(row.length==1){
        mdf.remove();
      }
      else{
        mdf_new_row.eq(0).append(btn_del)
      }
    });
  });

  $(document).on('click', '.delete-pasal', function(event) {
    $(this).parent().parent().remove();
    var $this = $('.pasal');
    $.each($this,function(index, el) {
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(0).find('.total_pasal').text(index+1);
      var mdf = $(this).find('.delete-pasal');
      if($this.length==1){
        mdf.remove();
      }
    });
  });
});
</script>
@endpush
