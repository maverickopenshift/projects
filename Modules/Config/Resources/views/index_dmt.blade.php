@extends('layouts.app')

@section('content')
  <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">
            <div class="btn-group" role="group" aria-label="...">

            </div>
        </h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="position:relative">
          <div id="alertBS"></div>
          <form action="{!! route('config.dmt.store') !!}" class="form-horizontal form-config" method="post">
            {{ csrf_field() }}
            <div class="loading-modal"></div>
              <div class="form-group">
                <div class="form-group">
                    <div class="error-global"></div>
                    <label class="col-sm-2 control-label">Pilih Pegawai</label>
                    <div class="col-sm-8">
                      <select class="form-control select-user-telkom" style="width: 100%;" name="user_search" id="user_search" data-nik="{{Helper::old_prop($config,'n_nik')}}" data-id="{{Helper::old_prop($config,'id')}}" data-data="{{Helper::old_prop($config,'v_nama_karyawan')}}">
                          <option value="">Pilih Pegawai</option>
                      </select>
                      <div class="error-user_search"></div>
                    </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 control-label">NIK</label>
                      <div class="col-sm-8">
                        <input type="text" value="{{Helper::old_prop($config,'n_nik')}}" id="nik_pgw" name="nik_pgw" class="form-control" disabled="disabled">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Pegawai</label>
                      <div class="col-sm-8">
                        <input type="text" id="nama_pgw" name="nama_pgw" value="{{Helper::old_prop($config,'v_nama_karyawan')}}" class="form-control" disabled="disabled">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Jabatan</label>
                      <div class="col-sm-8">
                        <input type="text" id="jabatan" name="jabatan" class="form-control" value="{{Helper::old_prop($config,'jabatan')}}" disabled="disabled">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Unit</label>
                      <div class="col-sm-8">
                        <input type="text" id="kd_unit" name="kd_unit" class="form-control" value="{{Helper::old_prop($config,'v_short_unit')}}" disabled="disabled">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Kota</label>
                      <div class="col-sm-8">
                        <input type="text" id="kota" name="kota" class="form-control" value="{{Helper::old_prop($config,'kota')}}" disabled="disabled">
                      </div>
                  </div>
              </div>
            <div class="form-group text-center top50">
              <button type="submit" class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;">SIMPAN</button>
            </div>
          </form>
      </div>
  <!-- /.box-body -->
  </div>
@endsection
@push('css')
  <style>
    .loading-modal{
      background-image: url(images/loader.gif);background-color: rgba(255,255,255,0.6);position: absolute;width: 100%;height: 100%;z-index: 1;background-repeat: no-repeat;background-position: center center;display: none;top:0;left: 0;
    }
  </style>
@endpush
@push('scripts')
<script>
var formModal = $('.form-config');
$(document).on('submit','.form-config',function (event) {
    event.preventDefault();
    var formMe = $(this);
    var loading = formMe.find('.loading-modal');
    loading.show();
    $.ajax({
        url: formMe.attr('action'),
        type: 'post',
        data: formMe.serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
            alertBS('Data successfully updated','success')
            loading.hide();
        }
    });
});
$(function() {
  $(document).on('select2:select', '#user_search', function(event) {
    event.preventDefault();
    /* Act on the event */
    var data = event.params.data;
    // console.log(data);
    formModal.find('#nik_pgw').val(data.n_nik);
    formModal.find('#nama_pgw').val(data.v_nama_karyawan);
    formModal.find('#jabatan').val(data.v_short_posisi);
    formModal.find('#kd_unit').val(data.v_short_unit);
    formModal.find('#kota').val(data.v_kota_gedung);
  });
});

    $('#user_search').select2({
      placeholder : "Pilih PIC....",
      dropdownParent: $('#user_search').parent(),
      ajax: {
          url: '{!! route('users.get-select-user-telkom') !!}',
          dataType: 'json',
          delay: 350,
          data: function (params) {
              var datas =  {
                  q: params.term, // search term
                  page: params.page
              };
              return datas;

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
                  o.jabatan = v.v_short_posisi;
                  o.unit = v.v_short_unit;
                  o.kota = v.v_kota_gedung;
                  results.push(o);
              })
              params.page = params.page || 1;
              return {
                  results: data.data,
                  pagination: {
                      more: (data.next_page_url ? true: false)
                  }
              };
          },
          cache: true
      },
      escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      minimumInputLength: 0,
      templateResult: aoTempResult ,
      templateSelection: aoTempSelect
  });
function aoTempResult(state) {
    if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ;  }
    var $state = $(
        '<span>' +  state.v_nama_karyawan +' <i>('+  state.n_nik + ')</i></span>'
    );
    return $state;
}
function aoTempSelect(data){
    if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
        return;
    }
    if(data.v_nama_karyawan === undefined || data.n_nik === undefined){
      return data.text;
    }
    return data.v_nama_karyawan +' - '+  data.n_nik ;
}

var selectPegawai = $("#user_search");

if(selectPegawai.data('id')!==""){
  var id = selectPegawai.data('id');
  var text_pegawai = selectPegawai.data('data')+' - '+selectPegawai.data('nik');
  var newOption_ = new Option(text_pegawai, id, false, true);
  selectPegawai.append(newOption_);
  selectPegawai.val(selectPegawai.data('id')).change();
}
</script>
@endpush
