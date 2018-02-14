<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">
      @if($doc_type['title']=="Turnkey" || $doc_type['title']=="SP" || $doc_type['title']=="amandemen_kontrak_turnkey" )

      @elseif($doc_type['title']=="Mou")
        Ruang Lingkup Kerjasama
      @else

      @endif
    </h3>
  </div>

  <div class="box-body">
    <div class="form-horizontal">
      @if(in_array($doc_type->name,['turnkey','amandemen_kontrak_turnkey','khs','amandemen_kontrak_khs','mou']))
        <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">SoW</div>
          </div>
          <div class="form-group  formerror formerror-doc_sow">
            <label for="doc_sow" class="col-sm-2 control-label"> Lingkup Pekerjaan</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="doc_sow" cols="4" rows="4">{{Helper::old_prop($doc,'doc_sow')}}</textarea>
              <div class="error error-doc_sow"></div>
            </div>
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
          if($doc_type->name=='khs' || $doc_type->name=='amandemen_kontrak_khs'){
            $title_hs = 'Daftar Harga Satuan';
            $tm_download = 'harga_satuan';
          }else{
            $title_hs = 'BoQ';
            $tm_download = 'boq';
          }
        @endphp
        <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">{{$title_hs}}</div>
        </div>

          <div class="form-group top20">
            <label for="prinsipal_st" class="col-sm-2 control-label"> {{$title_hs}}</label>
            <div class="col-sm-10">
              <button class="btn btn-primary btn-sm upload-daftar_harga" type="button"><i class="fa fa-upload"></i> Upload {{$title_hs}}</button>
              <a href="{{route('doc.tmp.download',['filename'=>$tm_download])}}" class="btn btn-info  btn-sm" title="Download Sample Template"><i class="glyphicon glyphicon-download-alt"></i> Download sample template</a>
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
                @if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs')
                  <th  style="width:70px;">Qty</th>
                @endif
                <th style="width:100px;">Satuan</th>
                <th style="width:80px;">Currency</th>
                <th>Harga</th>
                <th>Harga Jasa</th>
                @if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs')
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
                        <td class="formerror formerror-hs_kode_item-0">
                          <input type="text" class="form-control" name="hs_kode_item[]" value="{{$value}}" placeholder="Kode..">
                          <div class="error error-hs_kode_item error-hs_kode_item-0"></div>
                        </td>
                        <td class="formerror formerror-hs_item-0">
                          <input type="text" class="form-control" name="hs_item[]" value="{{$item[$key]}}" placeholder="Nama..">
                          <div class="error error-hs_item error-hs_item-0"></div>
                        </td>
                        @if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs')
                          <td class="formerror formerror-hs_qty-0">
                            <input type="text" class="form-control input-rupiah hitung_total" name="hs_qty[]" value="{{$qty[$key]}}" placeholder="Jumlah..">
                            <div class="error error-hs_qty error-hs_qty-0"></div>
                          </td>
                        @endif
                        <td class="formerror formerror-hs_satuan-0">
                          <input type="text" class="form-control" name="hs_satuan[]" value="{{$satuan[$key]}}" placeholder="Satuan..">
                          <div class="error error-hs_satuan error-hs_satuan-0"></div>
                        </td>
                        <td class="formerror formerror-hs_mtu-0">
                          @php
                            if($mtu[$key]=="RP"){
                                $a="selected";
                                $b="";
                            }else if($mtu[$key]=="USD"){
                                $a="";
                                $b="selected";
                            }else{
                                $a="";
                                $b="";
                            }
                          @endphp
                          <select name="hs_mtu[]" class="form-control" style="width: 100%;">
                              <option value="RP" {{$a}}>RP</option>
                              <option value="USD" {{$b}}>USD</option>
                          </select>
                          <div class="error error-hs_mtu error-hs_mtu-0"></div>
                        </td>
                        <td class="formerror formerror-hs_harga-0">
                          <input type="text" class="form-control input-rupiah text-right hitung_total" name="hs_harga[]" value="{{$harga[$key]}}" placeholder="Harga Material..">
                          <div class="error error-hs_harga error-hs_harga-0"></div>
                        </td>

                        <td class="formerror formerror-hs_harga_jasa-0">
                          <input type="text" class="form-control input-rupiah text-right hitung_total" name="hs_harga_jasa[]" value="{{$harga_jasa[$key]}}" placeholder="Harga Jasa..">
                          <div class="error error-hs_harga_jasa error-hs_harga_jasa-0"></div>
                        </td>
                        @if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs')
                          <td class="text-right" style="vertical-align: middle;">0</td>
                        @endif
                        <td class="formerror formerror-hs_keterangan-0">
                          <input type="text" class="form-control" name="hs_keterangan[]" value="{{$keterangan[$key]}}" placeholder="Keterangan..">
                          <div class="error error-hs_keterangan error-hs_keterangan-0"></div>
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
                @foreach ($kode_item as $key => $value)
                  <tr>
                    <td>1</td>
                    <td class="formerror formerror-hs_kode_item-0">
                <input type="text" class="form-control" name="hs_kode_item[]" placeholder="Kode..">
                <div class="error error-hs_kode_item error-hs_kode_item-0"></div>
              </td>
              <td class="formerror formerror-hs_item-0">
                <input type="text" class="form-control" name="hs_item[]" placeholder="Nama..">
                <div class="error error-hs_item error-hs_item-0"></div>
              </td>
              @if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs')
                <td class="formerror formerror-hs_qty-0">
                  <input type="text" class="form-control input-rupiah hitung_total" name="hs_qty[]" placeholder="Jumlah..">
                  <div class="error error-hs_qty error-hs_qty-0"></div>
                </td>
              @endif
              <td class="formerror formerror-hs_satuan-0">
                <input type="text" class="form-control" name="hs_satuan[]" placeholder="Satuan..">
                <div class="error error-hs_satuan error-hs_satuan-0"></div>
              </td>
              <td class="formerror formerror-hs_mtu-0">
                <select name="hs_mtu[]" class="form-control" style="width: 100%;">
                  <option value="RP">RP</option>
                  <option value="USD">USD</option>
                </select>
                <div class="error error-hs_mtu error-hs_mtu-0"></div>
              </td>
              <td class="formerror formerror-hs_harga-0">
                <input type="text" class="form-control input-rupiah hitung_total" name="hs_harga[]" placeholder="Harga Barang..">
                <div class="error error-hs_harga error-hs_harga-0"></div>
              </td>
              <td class="formerror formerror-hs_harga_jasa-0">
                <input type="text" class="form-control input-rupiah hitung_total" name="hs_harga_jasa[]"  placeholder="Harga Jasa..">
                <div class="error error-hs_harga_jasa error-hs_harga_jasa-0"></div>
              </td>
              @if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs')
                <td class="text-right" style="vertical-align: middle;">0</td>
              @endif
              <td class="formerror formerror-hs_keterangan-0">
                <input type="text" class="form-control" name="hs_keterangan[]" placeholder="Keterangan.." />
                <div class="error error-hs_keterangan error-hs_keterangan-0"></div>
              </td>
              <td class="action"></td>
                  </tr>
                @endforeach
              </tbody>
            @else
              <tbody>
                <tr>
                  <td>1</td>
                  <td><input type="text" class="form-control" name="hs_kode_item[]" placeholder="Kode.."></td>
                  <td><input type="text" class="form-control" name="hs_item[]" placeholder="Nama.."></td>
                  @if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs')
                    <td><input type="text" class="form-control input-rupiah hitung_total" name="hs_qty[]" placeholder="Jumlah.."></td>
                  @endif
                  <td><input type="text" class="form-control" name="hs_satuan[]" placeholder="Satuan.."></td>
                  <td>
                    <select name="hs_mtu[]" class="form-control" style="width: 100%;">
                      <option value="IDR">IDR</option>
                      <option value="USD">USD</option>
                    </select>
                  </td>
                  <td><input type="text" class="form-control input-rupiah hitung_total" name="hs_harga[]" placeholder="Harga Barang.."></td>
                  <td><input type="text" class="form-control input-rupiah hitung_total" name="hs_harga_jasa[]"  placeholder="Harga Jasa.."></td>
                  @if($doc_type->name!='khs' && $doc_type->name!='amandemen_kontrak_khs')
                    <td class="text-right" style="vertical-align: middle;">0</td>
                  @endif
                  <td><input type="text" class="form-control" name="hs_keterangan[]" placeholder="Keterangan.." /></td>
                  <td class="action"></td>
                </tr>
              </tbody>
            @endif
        </table>
      </div>
    </div>

    @if($doc_type['title']=="SP")
      <div class="form-group formerror formerror-doc_lampiran_teknis">
        <label for="doc_lampiran_teknis" class="col-sm-2 control-label">Lampiran Teknis</label>
        <div class="col-sm-6">
          <div class="input-group">
            <input type="file" class="hide" name="doc_lampiran_teknis" multiple="multiple">
            <input class="form-control" type="text" disabled>
            <div class="input-group-btn">
              <button class="btn btn-default click-upload" type="button">Browse</button>
                <input type="hidden" name="doc_lampiran_teknis_old" value="{{$doc->doc_lampiran_teknis}}">
              @if(isset($doc->doc_lampiran_teknis))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$doc->doc_lampiran_teknis,'type'=>$doc_type['name']])}}">
                <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                </a>
              @endif
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-2">
            {!!Helper::error_help($errors,'doc_lampiran_teknis')!!}
          </div>
        </div>
        <div class="error error-doc_lampiran_teknis"></div>
      </div>
    @endif
    @endif
    @include('documents::partials.button-edit')
    </div>
  </div>
</div>
@push('scripts')
<script>
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
      //tbody.html('');
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
// console.log(dt.mtu);exit();
  if(dt.mtu=="USD"){
    a="";
    b="selected";
  }else{
    a="selected";
    b="";
  }

  @php
    if($doc_type->name!='khs'){
      echo "qty = '<td>\
          <input type=\"text\" class=\"form-control input-rupiah hitung_total\" name=\"hs_qty[]\" value=\"'+data.QTY+'\" />\
          <div class=\"error error-hs_qty\"></div>\
          </td>';";
      echo "harga_total = (data.HARGA+data.HARGA_JASA)*data.QTY;";
      echo "harga_total = '<td style=\"vertical-align: middle;\" class=\"text-right\">'+formatRupiah(harga_total.toString())+'</td>';";
    }
  @endphp

  return '<tr>\
    <td>'+(index+1)+'</td>\
    <td>\
      <input type="text" class="form-control" name="hs_kode_item[]" value="'+data.KODE_ITEM+'" />\
      <div class="error error-hs_kode_item"></div>\
    </td>\
    <td>\
      <input type="text" class="form-control" name="hs_item[]" value="'+data.ITEM+'" />\
      <div class="error error-hs_item"></div>\
    </td>\
      '+qty+'\
    <td>\
      <input type="text" class="form-control" name="hs_satuan[]" value="'+data.SATUAN+'" />\
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
      <input type="text" class="form-control input-rupiah hitung_total" name="hs_harga[]" value="'+formatRupiah(data.HARGA)+'" />\
      <div class="error error-hs_harga"></div>\
    </td>\
    <td>\
      <input type="text" class="form-control input-rupiah hitung_total" name="hs_harga_jasa[]" value="'+formatRupiah(data.HARGA_JASA)+'" />\
      <div class="error error-hs_harga_jasa"></div>\
    </td>\
      '+harga_total+'\
    <td>\
      <input type="text" class="form-control" name="hs_keterangan[]" value="'+data.KETERANGAN+'" />\
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
  mdf_new_row.eq(4).find('select').val(mdf_new_row.eq(4).find('select option:first').val());
  mdf_new_row.eq(4).find('.error').html('');
  mdf_new_row.eq(5).find('input').val('');
  mdf_new_row.eq(5).find('.error').html('');
  mdf_new_row.eq(6).find('input').val('');
  mdf_new_row.eq(6).find('.error').html('');

  @php
    if($doc_type->name!='khs'){
      echo "
        mdf_new_row.eq(7).find('input').val('');
        mdf_new_row.eq(7).find('.error').html('');
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

</script>
@endpush
