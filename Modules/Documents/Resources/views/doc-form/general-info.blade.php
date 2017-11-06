<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group  {{ $errors->has('doc_title') ? ' has-error' : '' }}">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Judul {{$doc_type['title']}}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="doc_title"  value="{{old('doc_title',Helper::prop_exists($doc,'doc_title'))}}"  placeholder="Masukan Judul Kontrak" autocomplete="off">
              @if ($errors->has('doc_title'))
                  <span class="help-block">
                      <strong>{{ $errors->first('doc_title') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_desc') ? ' has-error' : '' }}">
            <label for="deskripsi_kontrak" class="col-sm-2 control-label"><span class="text-red">*</span> Deskripsi {{$doc_type['title']}}</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="doc_desc" placeholder="Masukan Deskripsi Kontrak">{{old('doc_desc',Helper::prop_exists($doc,'doc_desc'))}}</textarea>
              @if ($errors->has('doc_desc'))
                  <span class="help-block">
                      <strong>{{ $errors->first('doc_desc') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_template_id') ? ' has-error' : '' }}">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Jenis {{$doc_type['title']}}</label>
            <div class="col-sm-3">
              {!!Helper::select_jenis($doc_type->name,old('doc_template_id',Helper::prop_exists($doc,'doc_template_id')),'doc_template_id')!!}
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_template_id')!!}
            </div>
          </div>
          @if($doc_type->name=="sp")
            <div class="form-group {{ $errors->has('doc_startdate') ? ' has-error' : '' }}">
              <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai {{$doc_type['title']}}</label>
              <div class="col-sm-3">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="doc_startdate" value="{{old('doc_startdate',Helper::prop_exists($doc,'doc_startdate'))}}" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                {!!Helper::error_help($errors,'doc_startdate')!!}
              </div>
            </div>
            <div class="form-group {{ $errors->has('doc_enddate') ? ' has-error' : '' }}">
              <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir {{$doc_type['title']}}</label>
              <div class="col-sm-3">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="doc_enddate" value="{{old('doc_enddate',Helper::prop_exists($doc,'doc_enddate'))}}" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                {!!Helper::error_help($errors,'doc_enddate')!!}
              </div>
            </div>
          @else
            <div class="form-group {{ $errors->has('doc_date') ? ' has-error' : '' }}">
              <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal {{$doc_type['title']}}</label>
              <div class="col-sm-3">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="doc_date" value="{{old('doc_date',Helper::prop_exists($doc,'doc_date'))}}" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                {!!Helper::error_help($errors,'doc_date')!!}
              </div>
            </div>
          @endif
          <div class="form-group {{ $errors->has('doc_pihak1') ? ' has-error' : '' }}">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak I</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="doc_pihak1" id="pihak1" value="{{old('doc_pihak1',Helper::prop_exists($doc,'doc_pihak1'))}}" autocomplete="off">
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_pihak1')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_pihak1_nama') ? ' has-error' : '' }}">
            <label for="ttd_pihak1" class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak I</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="doc_pihak1_nama" value="{{old('doc_pihak1_nama',Helper::prop_exists($doc,'doc_pihak1_nama'))}}"  placeholder="Masukan Nama Penandatanganan Pihak I" autocomplete="off">
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_pihak1_nama')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak II</label>
            <div class="col-sm-6">
              <input type="hidden" class="select-user-vendor-text" name="supplier_text" value="{{old('supplier_text',Helper::prop_exists($doc,'supplier_text'))}}">
              <select class="form-control select-user-vendor" style="width: 100%;" name="supplier_id"  data-id="{{Helper::old_prop($doc,'supplier_id')}}">
                  <option value="">Pilih Pihak II</option>
              </select>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'supplier_id')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_pihak2_nama') ? ' has-error' : '' }}">
            <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak II</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="doc_pihak2_nama"  value="{{old('doc_pihak2_nama',Helper::prop_exists($doc,'doc_pihak2_nama'))}}"  placeholder="Masukan Nama Penandatanganan Pihak II" autocomplete="off">
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_pihak2_nama')!!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('doc_lampiran') ? ' has-error' : '' }}">
            <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Lampiran 1 <br/><small style="font-weight:normal" class="text-info"><i>(Lembar Tanda Tangan)</i></small></label>
            <div class="col-sm-6">
              <div class="input-group">
                <input type="file" class="hide" name="doc_lampiran">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                </span>
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_lampiran')!!}
            </div>
          </div>
          @if($doc_type->name!="sp")
            <div class="form-group {{ $errors->has('doc_proc_process') ? ' has-error' : '' }}">
              <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Cara Pengadaan</label>
              <div class="col-sm-3">
                <select class="form-control" name="doc_proc_process">
                  <option value="P" {!!Helper::old_prop_selected($doc,'doc_proc_process','P')!!}>Pelanggan</option>
                  <option value="PL" {!!Helper::old_prop_selected($doc,'doc_proc_process','PL')!!}>Pemilihan Langsung</option>
                  <option value="TL" {!!Helper::old_prop_selected($doc,'doc_proc_process','TL')!!}>Penunjukan Langsung</option>
                </select>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                {!!Helper::error_help($errors,'doc_proc_process')!!}
              </div>
            </div>
          @endif
            <div class="form-group {{ $errors->has('doc_proc_process') ? ' has-error' : '' }}">
              <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Mata Uang</label>
              <div class="col-sm-1">
                <select class="form-control mata-uang" name="doc_mtu">
                  <option value="RP" {!!Helper::old_prop_selected($doc,'doc_mtu','RP')!!}>Rp.</option>
                  <option value="USD" {!!Helper::old_prop_selected($doc,'doc_mtu','USD')!!}>USD</option>
                </select>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                {!!Helper::error_help($errors,'doc_mtu')!!}
              </div>
            </div>
          @if($doc_type->name!="sp")
            <div class="form-group {{ $errors->has('doc_value') ? ' has-error' : '' }}">
              <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Kontrak</label>
              <div class="col-sm-3">
                <div class="input-group">
                  <div class="input-group-addon mtu-set">
                  </div>
                  <input type="text" class="form-control input-rupiah" name="doc_value" value="{{Helper::old_prop($doc,'doc_value')}}">
                </div>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                {!!Helper::error_help($errors,'doc_value')!!}
              </div>
            </div>
          @endif
          @if($doc_type->name=="sp")
            <div class="form-group">
              <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Nilai SP</label>
              <div class="col-sm-10">
                <table class="table table-bordered table-latar">
                  <thead>
                  <tr>
                    <th>Material</th>
                    <th>Jasa</th>
                    <th>Total</th>
                    <th>PPN</th>
                    <th>Total PPN</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>
                        <div class="input-group {{ $errors->has('doc_nilai_material') ? ' has-error' : '' }}">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_material" value="{{Helper::old_prop($doc,'doc_nilai_material')}}" autocomplete="off">
                        </div>
                          {!!Helper::error_help($errors,'doc_nilai_material')!!}
                      </td>
                      <td>
                        <div class="input-group {{ $errors->has('doc_nilai_jasa') ? ' has-error' : '' }}">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_jasa" value="{{Helper::old_prop($doc,'doc_nilai_jasa')}}"  autocomplete="off">
                        </div>
                          {!!Helper::error_help($errors,'doc_nilai_jasa')!!}
                      </td>
                      <td>
                        <div class="input-group {{ $errors->has('doc_nilai_total') ? ' has-error' : '' }}">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_total" value="{{Helper::old_prop($doc,'doc_nilai_total')}}" autocomplete="off">
                        </div>
                          {!!Helper::error_help($errors,'doc_nilai_total')!!}
                      </td>
                      <td>
                        <div class="input-group {{ $errors->has('doc_nilai_ppn') ? ' has-error' : '' }}">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_ppn" value="{{Helper::old_prop($doc,'doc_nilai_ppn')}}" autocomplete="off">
                        </div>
                          {!!Helper::error_help($errors,'doc_nilai_ppn')!!}
                      </td>
                      <td>
                        <div class="input-group {{ $errors->has('doc_nilai_total_ppn') ? ' has-error' : '' }}">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_total_ppn" value="{{Helper::old_prop($doc,'doc_nilai_total_ppn')}}" autocomplete="off">
                        </div>
                          {!!Helper::error_help($errors,'doc_nilai_total_ppn')!!}
                      </td>
                    </tr>
                </tbody>
                </table>
              </div>
            </div>
          @endif
          <div class="form-group {{ $errors->has('pic_data') ? ' has-error' : '' }}">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Unit Penanggungjawab PIC</label>
            <div class="col-sm-5">
              <select class="form-control select-user-telkom" style="width: 100%;" name="pict" id="pict">
                  <option value="">Pilih Penanggungjawab</option>
              </select>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'pic_data')!!}
            </div>
          </div>
          <div class="parent-pictable" style="display:none;">
            <table class="table table-condensed table-striped" id="pictable">
                <thead>
                <tr>
                    <th width="40">No.</th>
                    <th  width="200">NIK</th>
                    <th  width="250">Nama</th>
                    <th>Posisi</th>
                    <th width="60">Action</th>
                </tr>
                </thead>
                <tbody>
                  <tr class="loading-tr">
                    <td colspan="5" class="text-center"><img src="{{asset('/images/loader.gif')}}" title="please wait..."/></td>
                  </tr>
                </tbody>
            </table>
          </div>
          @if($doc_type->name=="turnkey" || $doc_type->name=="sp")
          <div class="form-group {{ $errors->has('doc_po') ? ' has-error' : '' }}">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> PO</label>
            <div class="col-sm-4">
              <div class="input-group">
                <input class="form-control no_po" type="text" name="doc_po" value="{{Helper::old_prop($doc,'doc_po')}}" placeholder="Masukan No.PO">
                <span class="input-group-btn">
                  <button class="btn btn-default cari-po" type="button"><i class="glyphicon glyphicon-search"></i></button>
                </span>
              </div>
            </div>
            <span class="error error-po text-danger"></span>
            <div class="col-sm-10 col-sm-offset-2">
              {!!Helper::error_help($errors,'doc_po')!!}
            </div>
          </div>
          <div class="parent-potables" style="display:none;">
            <table class="table">
              <tbody>
              <tr>
                <td width="150">No PO </td>
                <td width="10">:</td>
                <td>PO0001</td>
              </tr>
              <tr>
                <td>Nama Pembuat</td>
                <td> : </td>
                <td>SUMARNI</td>
              </tr>
              <tr>
                <td>Tanggal PO</td>
                <td> : </td>
                <td>27 Agustus 2017</td>
              <tr>
              </tbody>
            </table>
            <table class="table table-condensed table-striped" id="potables">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Item</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>MTU</th>
                    <th>Harga</th>
                    <th>Harga Total</th>
                    <th>Keterangan</th>
                </tr>
                </thead>
                <tbody>
                  <tr class="loading-tr">
                    <td colspan="10" class="text-center"><img src="{{asset('/images/loader.gif')}}" title="please wait..."/></td>
                  </tr>
                </tbody>
            </table>
          </div>
          @endif
          {{-- @include('documents::partials.buttons') --}}
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  var po = $('.no_po').val()
  if(po!=""){
    render_po(po);
  }
  
  $('.mtu-set').text($('.mata-uang').val());
  $(".select-user-telkom").select2({
      placeholder : "Pilih Penanggung....",
      ajax: {
          url: '{!! route('users.get-select-user-telkom') !!}',
          dataType: 'json',
          delay: 350,
          data: function (params) {
              return {
                  q: params.term, // search term
                  page: params.page
              };
          },
          //id: function(data){ return data.store_id; },
          processResults: function (data, params) {
              // parse the results into the format expected by Select2
              // since we are using custom formatting functions we do not need to
              // alter the remote JSON data, except to indicate that infinite
              // scrolling can be used

              var results = [];

              $.each(data.data, function (i, v) {
                  var o = {};
                  o.id = v.n_nik;
                  o.name = v.v_nama_karyawan;
                  o.value = v.n_nik;
                  o.username = v.n_nik;
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
      //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      minimumInputLength: 0,
      templateResult: function (state) {
          if (state.id === undefined || state.id === "") { return ; }
          var $state = $(
              '<span>' +  state.name +' <i>('+  state.username + ')</i></span>'
          );
          return $state;
      },
      templateSelection: function (data) {
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return;
          }
          return data.name +' - '+  data.username ;
      }
  });
  var selectUserVendor = $(".select-user-vendor").select2({
      placeholder : "Pilih Pihak II....",
      ajax: {
          url: '{!! route('supplier.get-select') !!}',
          dataType: 'json',
          delay: 350,
          data: function (params) {
              return {
                  q: params.term, // search term
                  page: params.page
              };
          },
          //id: function(data){ return data.store_id; },
          processResults: function (data, params) {
              // parse the results into the format expected by Select2
              // since we are using custom formatting functions we do not need to
              // alter the remote JSON data, except to indicate that infinite
              // scrolling can be used

              var results = [];

              $.each(data.data, function (i, v) {
                  var o = {};
                  o.id = v.id;
                  o.name = v.nm_vendor;
                  o.value = v.id;
                  o.username = v.kd_vendor;
                  o.bdn_usaha = v.bdn_usaha;
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
      //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      minimumInputLength: 0,
      templateResult: templateResultVendor,
      templateSelection: templateSelectionVendor
  });
  function templateResultVendor(state) {
    if (state.id === undefined || state.id === "") { return ; }
    var $state = $(
        '<span>' +  state.bdn_usaha+'.'+state.name +' <i>('+  state.username + ')</i></span>'
    );
    return $state;
  }
  function templateSelectionVendor(data) {
    if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
        return;
    }
    var render = data.bdn_usaha+'.'+data.name +' - '+  data.username ;
    if(data.bdn_usaha === undefined){
      render = $('.select-user-vendor :selected').text();
    }
    $('.select-user-vendor-text').val(render);
    return render ;
  }
  
  var user_vendor = $(".select-user-vendor");
  if(user_vendor.data('id')!==""){
    var newOption = new Option($(".select-user-vendor-text").val(), user_vendor.data('id'), false, true);
    user_vendor.append(newOption);
    user_vendor.val(user_vendor.data('id')).change();
  }
  $(document).on('click', '.cari-po', function(event) {
    event.preventDefault();
    /* Act on the event */
    var po = $('.no_po').val(),error_po = $('.error-po');
    error_po.html('<img src="{!!asset('/images/loader.gif')!!}" title="please wait..." width="25"/>');
    if(po==""){
      error_po.html('No.PO harus diisi');
      return false;
    }
    render_po(po);
  });
function render_po(po){
  var error_po = $('.error-po');
  var table = $('#potables');
  var loading = table.find('.loading-tr');
  loading.show();
  var tr_count = table.find('tbody>tr').not('tbody>tr.loading-tr');
  table.parent().hide();
    $.ajax({
      url: '{!! route('doc.get-po') !!}',
      type: 'GET',
      dataType: 'json',
      data: {po: po}
    })
    .done(function(response) {
      if(response.status){
        if(response.length==0){
          error_po.html('No.PO tidak ditemukan!');
        }
        else{
          var data = response.data;
          loading.hide();
          table.parent().show();
          var tr;
          $.each(data,function(index, el) {
            var po_data = {
              no         : (index+1),
              kode_item  : this.kode_item,
              item       : this.item,
              qty        : formatRupiah(this.qty),
              satuan     : this.satuan,
              mtu        : this.mtu,
              harga      : formatRupiah(this.harga),
              harga_total: formatRupiah(this.harga_total),
              keterangan : this.keterangan,
            }
            var tr = templatePO(po_data);
            table.find('tbody').append(tr);
          });
          error_po.html('');
        }
      }
    });
}
function templatePO(data) {
  return '<tr>\
              <td>'+data.no+'</th>\
              <td>'+data.kode_item+'</th>\
              <td>'+data.item+'</th>\
              <td>'+data.qty+'</th>\
              <td>'+data.satuan+'</th>\
              <td>'+data.mtu+'</th>\
              <td>'+data.harga+'</th>\
              <td>'+data.harga_total+'</th>\
              <td>'+data.keterangan+'</th>\
          </tr>';
}
  @php 
    $pic=Helper::old_prop($doc,'pic_data');
  @endphp
  @if($pic)
      @if(count($pic)>0)
        var table = $('#pictable');
        var loading = table.find('.loading-tr');
        loading.hide();
        var tr_count = table.find('tbody>tr').not('tbody>tr.loading-tr');
        table.parent().show();
        var tr;
        @foreach ($pic as $key=>$value)
          @php echo 'var data_json=JSON.parse(decodeURIComponent("'.$value.'"));tr += templatePIC(data_json);'; @endphp
        @endforeach
        table.find('tbody').append(tr);
      @endif
  @endif
});
var tr_pic =[];

$(document).on('change', '#pict', function(event) {
  event.preventDefault();
  /* Act on the event */
  var nik = $(this).val();
  $(this).val('');
  $('#select2-pict-container').html('');
  var table = $('#pictable');
  var loading = table.find('.loading-tr');
  var render = true;
  $.each(table.find('.data-nik'),function(index, el) {
    if($(this).text()==nik){
      render = false;
    }
  });
  if(render){
    loading.show();
    var tr_count = table.find('tbody>tr').not('tbody>tr.loading-tr');
    table.parent().show();
    $.ajax({
      url: '{!! route('users.get-select-user-telkom-by-nik') !!}',
      type: 'GET',
      dataType: 'json',
      data: {nik: nik}
    })
    .done(function(response) {
      if(response.status){
        var data = response.data;
        loading.hide();
        var pic_data = {
          no     : (tr_count.length+1),
          id     : data.id,
          nik    : data.n_nik,
          nama   : data.v_nama_karyawan,
          posisi : (data.v_short_posisi==null?"-":data.v_short_posisi)
        }
        var tr = templatePIC(pic_data);
        table.find('tbody').append(tr);
      }
    });
  }
});
function templatePIC(pic_data) {
  var json_render =encodeURIComponent(JSON.stringify(pic_data));
  return '<tr><td class="data-no">'+pic_data.no+'<input type="hidden" name="pic_data[]" value="'+json_render+'" /></td><td class="data-nik">'+pic_data.nik+'</td><td>'+pic_data.nama+'</td><td>'+pic_data.posisi+'</td><td><button type="button" class="btn btn-danger btn-xs delete-pic"><i class="glyphicon glyphicon-remove"></i> batal</button></td></tr>';
}
$(document).on('click', '.delete-pic', function(event) {
  event.preventDefault();
  /* Act on the event */
  $(this).parent().parent().remove();
  var table = $('#pictable');
  var tr_count = table.find('tbody>tr').not('tbody>tr.loading-tr');
  var loading = table.find('.loading-tr');
  $.each(table.find('.data-no'),function(index, el) {
    $(this).html(index+1);
  });
  if(tr_count.length==0){
    loading.show();
    table.parent().hide();
  }
});
$(document).on('change', '.mata-uang', function(event) {
  event.preventDefault();
  /* Act on the event */
  $('.mtu-set').html($(this).val())
  //console.log($('.select-user-vendor').val());
});
</script>
@endpush
