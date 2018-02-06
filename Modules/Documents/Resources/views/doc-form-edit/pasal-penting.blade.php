<div class="box utamabanget">

    <div class="box-header with-border" style="padding-bottom: 14px;">
      <h3 class="box-title">

      </h3>
      <div class="pull-right box-tools">
        <button type="button" class="btn btn-success add-pasal"><i class="glyphicon glyphicon-plus"></i> tambah</button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @php
        $ps_judul_new = Helper::old_prop_each($doc,'ps_judul_new');
        $ps_judul = Helper::old_prop_each($doc,'ps_judul');
        $ps_isi   = Helper::old_prop_each($doc,'ps_isi');
      @endphp
      @if(count($ps_judul)>=1)
        @foreach ($ps_judul as $key => $value)
        <div class="parent-pasal">
            <div class="form-horizontal pasal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
                <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
                  <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Pasal Khusus #<span class="total_pasal">{{$key+1}}</span></div>
                  @if(count($ps_judul)>1)
                    <button type="button" class="btn btn-danger delete-pasal" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
                  @endif
                </div>
                <div class="form-group  {{ $errors->has('ps_judul.'.$key) ? ' has-error' : '' }}">
                  <label for="ps_judul" class="col-sm-2 control-label">Judul</label>
                  <div class="col-sm-6">
                    <select class="form-control pasal_judul" name="ps_judul[]" onchange="freeText()">
                      <option value="" {!!Helper::prop_selected($ps_judul[$key],"")!!}>Pilih Pasal</option>
                      @if($doc_type->name=="khs")
                      <option value="Jangka Waktu Penerbitan Surat Pesanan" {!!Helper::prop_selected($ps_judul[$key],"Jangka Waktu Penerbitan Surat Pesanan")!!}>Jangka Waktu Penerbitan Surat Pesanan</option>
                      @endif
                      @if($doc_type->name=="turnkey")
                      <option value="Jangka Waktu Penyerahan Pekerjaan" {!!Helper::prop_selected($ps_judul[$key],"Jangka Waktu Penyerahan Pekerjaan")!!}>Jangka Waktu Penyerahan Pekerjaan</option>
                      @endif
                      <option value="Tata Cara Pembayaran" {!!Helper::prop_selected($ps_judul[$key],"Tata Cara Pembayaran")!!}>Tata Cara Pembayaran</option>
                      <option value="Tanggal Efektif dan Masa Laku Perjanjian" {!!Helper::prop_selected($ps_judul[$key],"Tanggal Efektif dan Masa Laku Perjanjian")!!}>Tanggal Efektif dan Masa Laku Perjanjian</option>
                      <option value="Jaminan Pelaksanaan" {!!Helper::prop_selected($ps_judul[$key],"Jaminan Pelaksanaan")!!}>Jaminan Pelaksanaan</option>
                      <option value="Jaminan Uang Muka" {!!Helper::prop_selected($ps_judul[$key],"Jaminan Uang Muka")!!}>Jaminan Uang Muka</option>
                      <option value="Jaminan Pemeliharaan" {!!Helper::prop_selected($ps_judul[$key],"Jaminan Pemeliharaan")!!}>Jaminan Pemeliharaan</option>
                      @if($doc_type->name=="khs")
                      <option value="Masa Laku Jaminan" {!!Helper::prop_selected($ps_judul[$key],"Masa Laku Jaminan")!!}>Masa Laku Jaminan</option>
                      @endif
                      @if($doc_type->name=="turnkey")
                      <option value="Harga Kontrak" {!!Helper::prop_selected($ps_judul[$key],"Harga Kontrak")!!}>Harga Kontrak</option>
                      @endif
                      <option value="Lainnya" {!!Helper::prop_selected($ps_judul[$key],"Lainnya")!!}>Lainnya..</option>
                    </select>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-6 col-sm-offset-2 {{ $errors->has('ps_judul_new.'.$key) ? ' has-error' : '' }}" id="tambahan">
                    @if(count($ps_judul)>1 && $ps_judul[$key] == "Lainnya")
                      <input type="text" class="form-control jdl_lain" value="{{$ps_judul_new[$key]}}" placeholder="Masukkan Judul Pasal" name="ps_judul_new[]" autocomplete="off">
                    @endif
                    @if(count($ps_judul)>1 && $ps_judul[$key] != "Lainnya")
                      <input type="text" class="form-control jdl_lain" value="{{$ps_judul_new[$key]}}"  style="Display:none" name="ps_judul_new[]" autocomplete="off">
                    @endif
                    {!!Helper::error_help($errors,'ps_judul_new.'.$key)!!}
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    {!!Helper::error_help($errors,'ps_judul.'.$key)!!}
                  </div>
                </div>
                <div class="form-group {{ $errors->has('ps_isi.'.$key) ? ' has-error' : '' }}">
                  <label for="ps_isi" class="col-sm-2 control-label">Keterangan</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" rows="5" name="ps_isi[]" class="editor" id="editor1">{{$ps_isi[$key]}}</textarea>
                    {!!Helper::error_help($errors,'ps_isi.'.$key)!!}
                  </div>
                </div>
            </div>
          </div>
        @endforeach
      @else
      <div class="parent-pasal">
      <div class="form-horizontal pasal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Pasal Khusus #<span class="total_pasal">1</span></div>
          </div>
          <div class="form-group">
            <label for="ps_judul" class="col-sm-2 control-label">Judul</label>
            <div class="col-sm-6">
              <select class="form-control pasal_judul" name="ps_judul[]" onchange="freeText()">
                <option value="">Pilih Pasal</option>
                @if($doc_type->name=="khs")
                <option value="Jangka Waktu Penerbitan Surat Pesanan">Jangka Waktu Penerbitan Surat Pesanan</option>
                @endif
                @if($doc_type->name=="turnkey")
                <option value="Jangka Waktu Penyerahan Pekerjaan">Jangka Waktu Penyerahan Pekerjaan</option>
                @endif
                <option value="Tata Cara Pembayaran">Tata Cara Pembayaran</option>
                <option value="Tanggal Efektif dan Masa Laku Perjanjian">Tanggal Efektif dan Masa Laku Perjanjian</option>
                <option value="Jaminan Pelaksanaan">Jaminan Pelaksanaan</option>
                <option value="Jaminan Uang Muka">Jaminan Uang Muka</option>
                <option value="Jaminan Pemeliharaan">Jaminan Pemeliharaan</option>
                @if($doc_type->name=="khs")
                <option value="Masa Laku Jaminan">Masa Laku Jaminan</option>
                @endif
                @if($doc_type->name=="turnkey")
                <option value="Harga Kontrak">Harga Kontrak</option>
                @endif
                <option value="Lainnya">Lainnya..</option>
              </select>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-6 col-sm-offset-2" id="tambahan">
            </div>
          </div>
          <div class="form-group">
            <label for="ps_isi" class="col-sm-2 control-label">Isi</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="5" name="ps_isi[]" class="editor" id="editor1"></textarea>
            </div>
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
  var row = $('.pasal');
  $.each(row,function(index, el) {
  var select = $('.pasal_judul');
  var jum = $('.pasal_judul').val();
  if(jum== "Lainnya"){
    $('#tambahan').find('.jdl_lain').remove();
    $('#tambahan').append('<input type="text" class="form-control jdl_lain" placeholder="Masukkan Judul Pasal" name="ps_judul_new[]" autocomplete="off">');
  }
  else{
    $('#tambahan').find('.jdl_lain').remove();
    $('#tambahan').append('<input type="text" class="form-control jdl_lain" style="Display:none" name="ps_judul_new[]" autocomplete="off">');
    $('#tambahan').find('.jdl_lain').val(jum);
      }
    });
}

$(function() {

  $(document).on('click', '.add-pasal', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-pasal" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
    /* Act on the event */
    var $this = $('.pasal');
    var new_row = $this.eq(0).clone();
    new_row.find('.has-error').removeClass('has-error');
    var mdf_new_row = new_row.find('.form-group');

    mdf_new_row.eq(0).find('.total_pasal').text($this+1);//title and button

    mdf_new_row.eq(1).find('select').val('');      //jenisjaminan
    mdf_new_row.eq(1).find('.error').remove();    //jenisjaminan

    // mdf_new_row.eq(2).find('input').val('');   //keterangan
    // mdf_new_row.eq(2).find('input').remove();
    // mdf_new_row.eq(2).find('.error').remove();

    mdf_new_row.eq(2).find('textarea').val('');   //keterangan
    mdf_new_row.eq(2).find('.error').remove();

    $('.parent-pasal').append(new_row);
    new_row.find('.jdl_lain').remove();
    $('.date').datepicker(datepicker_ops);
    var row = $('.pasal');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.delete-pasal');
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(0).find('.total_pasal').text(index+1);
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
