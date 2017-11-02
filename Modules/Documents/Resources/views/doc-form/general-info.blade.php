<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info {{$doc_type['title']}}
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Judul {{$doc_type['title']}}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_vendor" value=""  placeholder="Masukan Judul Kontrak" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="deskripsi_kontrak" class="col-sm-2 control-label"><span class="text-red">*</span> Deskripsi {{$doc_type['title']}}</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="deskripsi_kontrak" placeholder="Masukan Deskripsi Kontrak"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Jenis {{$doc_type['title']}}</label>
            <div class="col-sm-3">
              {!!Helper::select_jenis($doc_type->name)!!}
            </div>
          </div>
          @if($doc_type->name=="sp")
            <div class="form-group">
              <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai {{$doc_type['title']}}</label>
              <div class="col-sm-3">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="doc_startdate" value="" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir {{$doc_type['title']}}</label>
              <div class="col-sm-3">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="doc_enddate" value="" autocomplete="off">
                </div>
              </div>
            </div>
          @else
            <div class="form-group">
              <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal {{$doc_type['title']}}</label>
              <div class="col-sm-3">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="akte_awal_tg" value="" autocomplete="off">
                </div>
              </div>
            </div>
          @endif
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak I</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="nm_vendor" value="PT. TELEKOMUNIKASI INDONESIA Tbk"  placeholder="Masukan Judul Kontrak" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="ttd_pihak1" class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak I</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="ttd_pihak1" value=""  placeholder="Masukan Nama Penandatanganan Pihak I" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak II</label>
            <div class="col-sm-6">
              <select class="form-control select-user-vendor" style="width: 100%;" name="store_id" id="store_id">
                  <option value="">Pilih Pihak II</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak II</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="ttd_pihak2" value=""  placeholder="Masukan Nama Penandatanganan Pihak II" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Lampiran 1</label>
            <div class="col-sm-6">
              <div class="input-group">
                <input type="file" class="hide" name="legal_dokumen[][file]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                </span>
              </div>
            </div>
          </div>
          @if($doc_type->name!="sp")
            <div class="form-group">
              <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Cara Pengadaan</label>
              <div class="col-sm-3">
                <select class="form-control" name="prinsipal_st">
                  <option value="1">Pelanggan</option>
                  <option value="0">Pemilihan Langsung</option>
                  <option value="2">Penunjukan Langsung</option>
                </select>
              </div>
            </div>
          @endif
            <div class="form-group">
              <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Mata Uang</label>
              <div class="col-sm-1">
                <select class="form-control mata-uang" name="doc_mtu">
                  <option value="RP">Rp.</option>
                  <option value="USD">USD</option>
                </select>
              </div>
            </div>
          @if($doc_type->name!="sp")
            <div class="form-group">
              <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Kontrak</label>
              <div class="col-sm-3">
                <div class="input-group">
                  <div class="input-group-addon mtu-set">
                  </div>
                  <input type="text" class="form-control" name="doc_value">
                </div>
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
                        <div class="input-group">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_material" autocomplete="off">
                        </div>
                      </td>
                      <td>
                        <div class="input-group">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_jasa" autocomplete="off">
                        </div>
                      </td>
                      <td>
                        <div class="input-group">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_total" autocomplete="off">
                        </div>
                      </td>
                      <td>
                        <div class="input-group">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_ppn" autocomplete="off">
                        </div>
                      </td>
                      <td>
                        <div class="input-group">
                          <span class="input-group-addon mtu-set"></span>
                          <input type="text" class="form-control" name="doc_nilai_total_ppn" autocomplete="off">
                        </div>
                      </td>
                    </tr>
                </tbody>
                </table>
              </div>
            </div>
          @endif
          <div class="form-group">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Unit Penanggungjawab PIC</label>
            <div class="col-sm-3">
              <select class="form-control select-user-telkom" style="width: 100%;" name="pict" id="pict">
                  <option value="">Pilih Penanggungjawab</option>
              </select>
            </div>
          </div>
          <div class="parent-pictable" style="display:none;">
            <table class="table table-condensed table-striped" id="pictable">
                <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Loker</th>
                    <th>Posisi</th>
                    <th>No Telepon</th>
                    <th>Email</th>
                </tr>
                </thead>
            </table>
          </div>
          @if($doc_type->name=="turnkey" || $doc_type->name=="sp")
          <div class="form-group">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> PO</label>
            <div class="col-sm-4">
              <div class="input-group">
                <input class="form-control no_po" type="text" name="po" placeholder="Masukan No.PO">
                <span class="input-group-btn">
                  <button class="btn btn-default cari-po" type="button"><i class="glyphicon glyphicon-search"></i></button>
                </span>
              </div>
            </div>
            <span class="error error-po text-danger"></span>
          </div>
          <div class="parent-potables" style="display:none;">
            <table class="table table-condensed" id="potables">
              <tbody class="col-sm-8">
              <tr>
                <td class="col-sm-1">No PO </td>
                <td class="col-sm-1"> : </td>
                <td class="col-sm-4">02452332 </td>
              </tr>
              <tr>
                <td>Nama Pembuat</td>
                <td> : </td>
                <td>ajsjadhsjad</td>
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
                    <th>No.PO</th>
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
                  o.id = v.id;
                  o.name = v.name;
                  o.value = v.id;
                  o.username = v.username;
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
              '<span id="pic">' +  state.name +' <i>('+  state.username + ')</i></span>'
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
  $(".select-user-vendor").select2({
      placeholder : "Pilih Pihak II....",
      ajax: {
          url: '{!! route('users.get-select-user-vendor') !!}',
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
                  o.name = v.name;
                  o.value = v.id;
                  o.username = v.username;
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
      templateResult: function (state) {
          if (state.id === undefined || state.id === "") { return ; }
          var $state = $(
              '<span>' +  state.bdn_usaha+'.'+state.name +' <i>('+  state.username + ')</i></span>'
          );
          return $state;
      },
      templateSelection: function (data) {
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return;
          }
          return data.bdn_usaha+'.'+data.name +' - '+  data.username ;
      }
  });
  $(document).on('click', '.cari-po', function(event) {
    event.preventDefault();
    /* Act on the event */
    var po = $('.no_po').val(),error_po = $('.error-po');
    error_po.html('');
    if(po==""){
      error_po.html('No.PO harus diisi');
      return false;
    }
    $('.parent-potables').show();
    $('#potables').DataTable().destroy();
    $('#potables').on('xhr.dt', function ( e, settings, json, xhr ) {
        // console.log(JSON.stringify(json));
        // if(json.recordsTotal==0){
        //   $('#potables').DataTable().destroy();
        //   $('.parent-potables').hide();
        //   error_po.html('Data tidak ditemukan');
        //   return false;
        // }
        if(xhr.responseText=='Unauthorized.'){
          location.reload();
        }
        }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth : false,
        order : [[ 1, 'desc' ]],
        pageLength: 10,
        ajax: '{!! route('doc.get-po') !!}?po='+po,
        columns: [
            {data : 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'no_po', name: 'no_po' },
            { data: 'kode_item', name: 'kode_item' },
            { data: 'item', name: 'item' },
            { data: 'qty', name: 'qty' },
            { data: 'satuan', name: 'satuan' },
            { data: 'mtu', name: 'mtu' },
            { data: 'harga', name: 'harga' },
            { data: 'harga_total', name: 'harga_total' },
            { data: 'keterangan', name: 'keterangan' },
        ]
    });
  });

$("#pic").on("change", function () {

$('.parent-pictable').show();
$('#pictable').DataTable().destroy();
$('#pictable').on('xhr.dt', function ( e, settings, json, xhr ) {
    if(xhr.responseText=='Unauthorized.'){
      location.reload();
    }
    }).DataTable({
    processing: true,
    serverSide: true,
    autoWidth : false,
    order : [[ 1, 'desc' ]],
    pageLength: 10,
    ajax: '{!! route('doc.get-pic') !!}?nik=123456',
    columns: [
        {data : 'DT_Row_Index',orderable:false,searchable:false},
        { data: 'nik', name: 'nik' },
        { data: 'nama', name: 'nama' },
        { data: 'loker', name: 'loker' },
        { data: 'posisi', name: 'posisi' },
        { data: 'phone', name: 'phone' },
        { data: 'email', name: 'email' },
    ]
});
 });

  //
  // $("#store_id").change(function () {
  //        alert('hai');
  //    });
});
$(document).on('change', '.mata-uang', function(event) {
  event.preventDefault();
  /* Act on the event */
  $('.mtu-set').html($(this).val())
});
</script>
@endpush
