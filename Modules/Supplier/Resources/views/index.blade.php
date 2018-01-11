@extends('layouts.app')

@section('content')
<div class="box box-danger">
  <div class="loading2"></div>
    <div class="box-header with-border">
      <h3 class="box-title">
          <div class="btn-group" role="group" aria-label="...">
            @if(\Auth::user()->hasPermission('tambah-supplier'))
              <a href="{{route('supplier.create')}}" class="btn btn-default">
                  <i class="glyphicon glyphicon-plus"></i> Add Supplier
              </a>
            @endif
          </div>
          <div class="btn-group" role="group" aria-label="...">
            @if(\Auth::user()->hasPermission('tambah-supplier'))
              <form action="{{route('supplier.upload.sap')}}" class="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-sm-10">
                  <input type="file" name="supplier_sap" class="supplier_sap hide"/>
                  <button class="btn btn-primary btn-sm upload-supplier_sap" type="button"><i class="fa fa-upload"></i> Upload Supplier from SMILE</button>
                  <span class="error error-supplier_sap text-danger"></span>
                </div>
                <button class="btn btn-primary btn-sm btn_submit hide" type="submit"></button>
              </form>
            @endif
          </div>
        </h3>
        <br>
          <div class="form-group input-group" role="group" style="margin-top: 10px; margin-bottom: -2px">
            <label for="nm_direktur_utama" class="col-sm-4 control-label">Filter :</label>
            <div class="col-sm-10">
              <select class="form-control filter">
                <option value="">Semua</option>
                <option value="Sudah Disetujui">Sudah Disetujui</option>
                <option value="Belum Disetujui">Belum Disetujui</option>
                <option value="Data Dikembalikan">Data Dikembalikan</option>
                <option value=",">Sudah Mapping SAP</option>
                <option value="-">Belum Mapping SAP</option>
              </select>
            </div>
          </div>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body content-view">
      <div class="loading2"></div>
        @include('supplier::partials.alert-message')

        <div id="alertBS"></div>
        <table class="table table-condensed table-striped" id="datatables">
            <thead>
            <tr>
                <th width="20">No.</th>
                <th width="100">Supplier</th>
                <th width="100">ID</th>
                <th width="50">Kode SAP</th>
                <th width="200">Alamat</th>
                <th width="150">Kota</th>
                <th width="100">Telepon</th>
                <th width="100">Fax</th>
                <th width="150">Email</th>
                <th width="100">Created At</th>
                <th width="100">Updated At</th>
                <th width="100">Status Approval</th>
                <th width="100">Action</th>
            </tr>
            </thead>
        </table>
    </div>
<!-- /.box-body -->
</div>
@include('supplier::form_editstatus')
@endsection
@push('scripts')
<script>
var datatablesMe;
$(function() {
  $('.upload-supplier_sap').on('click', function(event) {
    /* Act on the event */
    event.stopPropagation();
    event.preventDefault();
    $('.error-supplier_sap').html('');
    var $file = $('.supplier_sap').click();
  });
  $('.supplier_sap').on('change', function(event) {
    event.stopPropagation();
    event.preventDefault();
    $('.btn_submit').click();
  });
  $(document).on('click', '.unlink_btn', function(event) {
    event.preventDefault();
    var content = $('.content-view');
    var loading = content.find('.loading2');
    var btn = $('.unlink_btn');
    var id = btn.data('id');
    bootbox.confirm({
      title: "Konfirmasi",
      message: "Apakah anda yakin ingin manghapus link dengan SAP ?",
      buttons: {
          confirm: {
              label: 'Yakin',
              className: 'btn-success btn-sm'
          },
          cancel: {
              label: 'Tidak',
              className: 'btn-danger btn-sm'
          }
      },
      callback: function (result) {
        if(result){
          loading.show();
          $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            url: '{!!route('supplier.hapus.mapping')!!}',
            type: 'POST',
            dataType: 'JSON',
            data: {id: id}
          })
          .done(function(data) {
            if(data.status){
              console.log("sukses");
              bootbox.alert({
                  title:"Pemberitahuan",
                  message: "Data berhasil dihapus",
                  callback: function (result) {
                      window.location = '{!!route('supplier')!!}'
                  }
              });
            }
            else{
              console.log("err");
            }
            loading.hide();
          })
          .always(function(){
            loading.hide();
          });
        }
      }
    });
  });

var stat = "nol";

  datatablesMe = $('#datatables').on('xhr.dt', function ( e, settings, json, xhr ) {
      //console.log(JSON.stringify(xhr));
      if(xhr.responseText=='Unauthorized.'){
        location.reload();
      }
      }).DataTable({
      processing: true,
      serverSide: true,
      // autoWidth : true,
      scrollX   : true,
      fixedColumns:   {
            leftColumns: 4,
            rightColumns:2
      },
      order : [[ 8, 'desc' ]],
      pageLength: 50,

      ajax: '{!! route('supplier.data') !!}',
      columns: [
          {data : 'DT_Row_Index',orderable:false,searchable:false},
          { data: 'nm_vendor', name: 'nm_vendor' },
          { data: 'kd_vendor', name: 'kd_vendor' },
          { data: 'id_sap', name: 'id_sap' },
          { data: 'alamat', name: 'alamat' },
          { data: 'kota', name: 'kota' },
          { data: 'telepon', name: 'telepon' },
          { data: 'fax', name: 'fax' },
          { data: 'email', name: 'email' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
          { data: 'vendor_status', name: 'vendor_status' },
          { data: 'action', name: 'action',orderable:false,searchable:false }
      ]
  });
  $(".filter").change(function () {
    var val = this.value;
    if(val == '-'){
      datatablesMe.columns( 3 ).search(this.value).draw();
    }else if(val == ','){
      datatablesMe.columns( 3 ).search(this.value).draw();
    }else{
      datatablesMe.columns( 11 ).search(this.value).draw();
    }
  });
});
</script>
@endpush
