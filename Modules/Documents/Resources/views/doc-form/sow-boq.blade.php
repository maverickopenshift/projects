<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">
      @if($doc_type['title']=="Turnkey" || $doc_type['title']=="SP")
        SOW,BOQ
      @elseif($doc_type['title']=="MoU")
        Ruang Lingkup Kerjasama
      @else
        Daftar Harga satuan
      @endif
    </h3>
  </div>
    
  <div class="box-body">
    <div class="form-horizontal">
      @if(in_array($doc_type->name,['turnkey','khs','mou']))
        <div class="form-group {{ $errors->has('doc_sow') ? ' has-error' : '' }}">
          <label for="doc_sow" class="col-sm-2 control-label"> Lingkup Pekerjaan</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="doc_sow" cols="4" rows="4">{{Helper::old_prop($doc,'doc_sow')}}</textarea>
            {!!Helper::error_help($errors,'doc_sow')!!}
          </div>
        </div>
      @endif

      @if(!in_array($doc_type->name,['mou']))
        @php
          $kode_item = Helper::old_prop_each($doc,'hs_kode_item');
          $item = Helper::old_prop_each($doc,'hs_item');
          $satuan = Helper::old_prop_each($doc,'hs_satuan');
          $mtu = Helper::old_prop_each($doc,'hs_mtu');
          $harga = Helper::old_prop_each($doc,'hs_harga');
          $harga_jasa = Helper::old_prop_each($doc,'hs_harga_jasa');
          $qty = Helper::old_prop_each($doc,'hs_qty');
          $keterangan = Helper::old_prop_each($doc,'hs_keterangan');
          if($doc_type->name=='khs'){
            $title_hs = 'Daftar Harga Satuan';
            $tm_download = 'harga_satuan';
          }
          else{
            $title_hs = 'BoQ';
            $tm_download = 'boq';
          }
        @endphp
      <div class="form-group top20">
        <label for="prinsipal_st" class="col-sm-2 control-label"> {{$title_hs}}</label>
        <div class="col-sm-10">
          <input type="file" name="daftar_harga" class="daftar_harga hide" accept=".csv,.xls">
          <button class="btn btn-primary btn-sm upload-daftar_harga" type="button"><i class="fa fa-upload"></i> Upload {{$title_hs}}</button>
          <a href="{{route('doc.template.download',['filename'=>$tm_download])}}" class="btn btn-info  btn-sm" title="Download Sample Template"><i class="glyphicon glyphicon-download-alt"></i> Download sample template</a>
          <span class="error error-daftar_harga text-danger"></span>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-condensed table-striped" id="table-hargasatuan">
            <thead>
            <tr>
                <th style="width:50px;">No.</th>
                <th>Kode Item</th>
                <th>Item</th>
                @if($doc_type->name!='khs')
                  <th  style="width:70px;">Qty</th>
                @endif
                <th style="width:100px;">Satuan</th>
                <th style="width:70px;">Currency</th>
                <th>Harga</th>
                <th>Harga Jasa</th>
                @if($doc_type->name!='khs')
                  <th style="width:100px;">Harga Total</th>
                @endif
                <th>Keterangan</th>
                <th><button type="button" class="btn btn-success btn-xs add-harga_satuan"><i class="glyphicon glyphicon-plus"></i> Tambah</button></th>
            </tr>
            </thead>
            @if(isset($kode_item) && count($kode_item)>0)
              <tbody>
                @foreach ($kode_item as $key => $value)
                  <tr>
                    <td>{{$key+1}}</td>

                    <td class="{{ $errors->has('hs_kode_item.'.$key) ? ' has-error' : '' }}">
                      <input type="text" class="form-control" name="hs_kode_item[]" value="{{$value}}" placeholder="Kode..">
                      {!!Helper::error_help($errors,'hs_kode_item.'.$key)!!}
                    </td>

                    <td class="{{ $errors->has('hs_item.'.$key) ? ' has-error' : '' }}">
                      <input type="text" class="form-control" name="hs_item[]" value="{{$item[$key]}}" placeholder="Nama..">
                      {!!Helper::error_help($errors,'hs_item.'.$key)!!}
                    </td>

                    @if($doc_type->name!='khs')
                      <td class="{{ $errors->has('hs_qty.'.$key) ? ' has-error' : '' }}">
                        <input type="text" class="form-control input-rupiah hitung_total" name="hs_qty[]" value="{{$qty[$key]}}" placeholder="Jumlah..">
                        {!!Helper::error_help($errors,'hs_qty.'.$key)!!}
                      </td>
                    @endif

                    <td class="{{ $errors->has('hs_satuan.'.$key) ? ' has-error' : '' }}">
                      <input type="text" class="form-control" name="hs_satuan[]" value="{{$satuan[$key]}}" placeholder="Satuan..">
                      {!!Helper::error_help($errors,'hs_satuan.'.$key)!!}
                    </td>

                    <td  class="{{ $errors->has('hs_mtu.'.$key) ? ' has-error' : '' }}">
                      @php
                        if($hs_mtu[$key]=="RP"){
                            $a="selected";
                            $b="";
                        }else if($hs_mtu[$key]=="USD"){
                            $a="";
                            $b="selected";
                        }else{
                            $a="";
                            $b="";
                        }
                      @endphp
                      <select name="hs_mtu[]" class="form-control select2" style="width: 100%;">
                          <option value=""></option>
                          <option value="RP" {{$a}}>RP</option>
                          <option value="USD" {{$b}}>USD</option>                       
                      </select>
                      {!!Helper::error_help($errors,'hs_mtu.'.$key)!!}
                    </td>
                    <td class="{{ $errors->has('hs_harga.'.$key) ? ' has-error' : '' }}">
                      <input type="text" class="form-control input-rupiah hitung_total" name="hs_harga[]" value="{{$harga[$key]}}" placeholder="Harga Material..">
                      {!!Helper::error_help($errors,'hs_harga.'.$key)!!}
                    </td>
                    <td class="{{ $errors->has('hs_harga_jasa.'.$key) ? ' has-error' : '' }}">
                      <input type="text" class="form-control input-rupiah hitung_total" name="hs_harga_jasa[]" value="{{$harga_jasa[$key]}}" placeholder="Harga Jasa..">
                      {!!Helper::error_help($errors,'hs_harga_jasa.'.$key)!!}
                    </td>
                    @if($doc_type->name!='khs')
                      <td class="text-right" style="vertical-align: middle;">0</td>
                    @endif
                    <td class="{{ $errors->has('hs_keterangan.'.$key) ? ' has-error' : '' }}">
                      <input type="text" class="form-control" name="hs_keterangan[]" value="{{$keterangan[$key]}}" placeholder="Keterangan..">
                      {!!Helper::error_help($errors,'hs_keterangan.'.$key)!!}
                    </td>
                    <td class="action">
                      @if(count($kode_item)>1)
                        <button type="button" class="btn btn-danger btn-xs delete-hs"><i class="glyphicon glyphicon-remove"></i> hapus</button>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            @else
              <tbody>
                <tr>
                  <td>1</td>
                  <td><input type="text" class="form-control" name="hs_kode_item[]" placeholder="Kode.."></td>
                  <td><input type="text" class="form-control" name="hs_item[]" placeholder="Nama.."></td>
                  @if($doc_type->name!='khs')
                    <td><input type="text" class="form-control input-rupiah hitung_total" name="hs_qty[]" placeholder="Jumlah.."></td>
                  @endif
                  <td><input type="text" class="form-control" name="hs_satuan[]" placeholder="Satuan.."></td>
                  <td>
                    <select name="hs_mtu[]" class="form-control select2" style="width: 100%;">
                      <option value=""></option>
                      <option value="RP">RP</option>
                      <option value="USD">USD</option>                       
                    </select>
                  </td>
                  <td><input type="text" class="form-control input-rupiah hitung_total" name="hs_harga[]" placeholder="Harga Barang.."></td>
                  <td><input type="text" class="form-control input-rupiah hitung_total" name="hs_harga_jasa[]"  placeholder="Harga Jasa.."></td>
                  @if($doc_type->name!='khs')
                    <td class="text-right" style="vertical-align: middle;">0</td>
                  @endif
                  <td><input type="text" class="form-control" name="hs_keterangan[]" placeholder="Keterangan.." /></td>
                  <td class="action"></td>
                </tr>
              </tbody>
            @endif
        </table>
      </div>
      @if($doc_type['title']=="SP")
        <div class="form-group  {{ $errors->has('doc_lampiran_teknis') ? ' has-error' : '' }}">
          <label for="ttd_pihak2" class="col-sm-2 control-label">Lampiran Teknis</label>
          <div class="col-sm-6">
            <div class="input-group">
              <input type="file" class="hide" name="doc_lampiran_teknis">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
              </span>
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-2">
            {!!Helper::error_help($errors,'doc_lampiran_teknis')!!}
          </div>
        </div>
      @endif
      @endif
      @include('documents::partials.buttons')
    </div>
  </div>
</div>
@push('scripts')
<script>
$(function() {

  $(".select2").select2({
    placeholder:"Silahkan Pilih"
  });

  $('.upload-daftar_harga').on('click', function(event) {
    event.stopPropagation();
    event.preventDefault();

    $('.error-daftar_harga').html('');
    var $file = $('.daftar_harga').click();
  });

  $('.daftar_harga').on('change', function(event) {
    event.stopPropagation();
    event.preventDefault();
    var validfile = [".csv", ".xls"];  
    var namefile = $('.daftar_harga').val().split('\\').pop();
    var valid = 0;

    for (var i = 0; i < validfile.length; i++) {
      var validfilex=validfile[i];

      if (namefile.substr(namefile.length - validfilex.length, validfilex.length).toLowerCase() == validfilex.toLowerCase()) {
        valid = 1;
        break;
      }
    }

    if(valid==1){
      handleDaftarHargaFileSelect(this.files[0]);
    }else{
      $('.error-daftar_harga').html('Format File tidak valid! hanya CSV & XLS yang valid');
    }
  });

});

function handleDaftarHargaFileSelect(file) {
  Papa.parse(file, {
    header: true,
    dynamicTyping: true,
    complete: function(results) {
      var fields = results.meta.fields;

      @php
        if($doc_type->name!='khs'){
          echo "var fields_dec = ['KODE_ITEM','ITEM','QTY','SATUAN','MTU','HARGA','HARGA_JASA','KETERANGAN'];";
          echo "var fields_length_set = 8;";
        }
        else{
          echo "var fields_dec = ['KODE_ITEM','ITEM','SATUAN','MTU','HARGA','HARGA_JASA','KETERANGAN'];";
          echo "var fields_length_set = 7;";
        }
      @endphp

      if(fields.length!==fields_length_set || JSON.stringify(fields_dec)!==JSON.stringify(fields)){
        $('.error-daftar_harga').html('Format CSV tidak valid!');
        return false;
      }

      if(results.data.length==0){
        $('.error-daftar_harga').html('Data tidak ada!');
        return false;
      }

      var $this = $('#table-hargasatuan');
      var tbody = $this.find('tbody');
      tbody.html('');
      var parse_row,btn_del;

      if(results.data.length>1){
        btn_del = '<button type="button" class="btn btn-danger btn-xs delete-hs"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
      }

      $.each(results.data,function(index, el) {
        if(results.data[index].KODE_ITEM!=""){
          $('#table-hargasatuan').find(".select2").each(function(index){
            if($(this).data('select2')) {
              $(this).select2('destroy');
            }
          });

          row_html = templateHS(results.data[index],index);
          row_html = $(row_html).clone();
          row_html.find('.action').html(btn_del);
          parse_row += $('<tr>').append(row_html).html();

          $(".select2").select2({
            placeholder:"Silahkan Pilih"
          });
        }
      });

      tbody.html(parse_row);
    }
  });
}

function templateHS(data,index) {
  //var harga = data.HARGA,qty,harga_total;
  //console.log(data.HARGA,qty,harga_total);
  @php
    if($doc_type->name!='khs'){
      echo "qty = '<td><input type=\"text\" class=\"form-control input-rupiah hitung_total\" name=\"hs_qty[]\" value=\"'+data.QTY+'\" /></td>';";
      echo "harga_total = (data.HARGA+data.HARGA_JASA)*data.QTY;";
      echo "harga_total = '<td style=\"vertical-align: middle;\" class=\"text-right\">'+formatRupiah(harga_total.toString())+'</td>';";
    }
  @endphp

  return '<tr>\
    <td>'+(index+1)+'</td>\
    <td><input type="text" class="form-control" name="hs_kode_item[]" value="'+data.KODE_ITEM+'" /></td>\
    <td><input type="text" class="form-control" name="hs_item[]" value="'+data.ITEM+'" /></td>\
    '+qty+'\
    <td><input type="text" class="form-control" name="hs_satuan[]" value="'+data.SATUAN+'" /></td>\
    <td><input type="text" class="form-control" name="hs_mtu[]" value="'+data.MTU+'" /></td>\
    <td><input type="text" class="form-control input-rupiah hitung_total" name="hs_harga[]" value="'+formatRupiah(data.HARGA)+'" /></td>\
    <td><input type="text" class="form-control input-rupiah hitung_total" name="hs_harga_jasa[]" value="'+formatRupiah(data.HARGA_JASA)+'" /></td>\
    '+harga_total+'\
    <td><input type="text" class="form-control" name="hs_keterangan[]" value="'+data.KETERANGAN+'" /></td>\
    <td class="action"></td>\
  </tr>';
}

$(document).on('click', '.add-harga_satuan', function(event) {
  event.preventDefault();
  var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-hs"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
  /* Act on the event */
  var $this = $('#table-hargasatuan');

  $('#table-hargasatuan').find(".select2").each(function(index){
    if($(this).data('select2')) {
      $(this).select2('destroy');
    }
  });

  var row = $this.find('tbody>tr');
  var new_row = row.eq(0).clone();
  var mdf_new_row = new_row.find('td');
  mdf_new_row.eq(0).html(row.length+1);
  mdf_new_row.eq(1).find('input').val('');
  mdf_new_row.eq(1).find('.error').remove();
  mdf_new_row.eq(2).find('input').val('');
  mdf_new_row.eq(2).find('.error').remove();
  mdf_new_row.eq(3).find('input').val('');
  mdf_new_row.eq(3).find('.error').remove();
  mdf_new_row.eq(4).find('select').val('');
  mdf_new_row.eq(4).find('.error').remove();
  mdf_new_row.eq(5).find('input').val('');
  mdf_new_row.eq(5).find('.error').remove();
  mdf_new_row.eq(6).find('input').val('');
  mdf_new_row.eq(6).find('.error').remove();

    @php
      if($doc_type->name!='khs'){
        echo "
          mdf_new_row.eq(7).find('input').val('');
          mdf_new_row.eq(7).find('.error').remove();
          mdf_new_row.eq(8).html('0');
          mdf_new_row.eq(9).find('input').val('');
          mdf_new_row.eq(9).find('.error').remove();
        ";
      }
    @endphp
  
  $this.find('tbody').append(new_row);

  var row = $this.find('tbody>tr');
  $.each(row,function(index, el) {
    var mdf = $(this).find('.action');
    var mdf_new_row = $(this).find('td');
    mdf_new_row.eq(0).html(index+1);

    if(row.length==1){
      mdf.html('');
    }else{
      mdf.html(btn_del);
    }

  });

  $(".select2").select2({
    placeholder:"Silahkan Pilih"
  });
});

$(document).on('click', '.delete-hs', function(event) {
  $(this).parent().parent().remove();
  var $this = $('#table-hargasatuan');
  var row = $this.find('tbody>tr');

  $.each(row,function(index, el) {
    var mdf_new_row = $(this).find('td');
    mdf_new_row.eq(0).html(index+1);
    var mdf = $(this).find('.action');    

    if(row.length==1){
      mdf.html('');
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
</script>
@endpush
