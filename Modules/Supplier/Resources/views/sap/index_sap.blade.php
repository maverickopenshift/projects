@extends('layouts.app')

@section('content')
<div class="box box-danger">
  <div class="loading2"></div>
    <div class="box-header with-border">

          <div class="btn-group" role="group" >
            @if(\Auth::user()->hasPermission('tambah-supplier'))
              <form action="{{route('supplier.upload.sap')}}" class="" method="post" id="form-user" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-md-12">
                  <input type="file" name="supplier_sap" class="supplier_sap hide"/>
                  <button class="btn btn-primary btn-sm upload-supplier_sap" type="button"><i class="fa fa-upload"></i> Upload Supplier from SAP</button>
                  {{-- <span>Format File Tidak Valid</span> --}}
                  <span>{!!Helper::error_help($errors,'supplier_sap')!!}</span>
                </div>
                <button class="btn btn-primary btn-sm btn_submit hide" type="submit"></button>
              </form>
            @endif
          </div>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        @include('supplier::partials.alert-message')

        <div id="alertBS"></div>
        <table class="table table-condensed table-striped" id="datatables">
            <thead>
            <tr>
                <th width="">No.</th>
                <th width="150">Supplier</th>
                <th width="50">ID</th>
                <th width="180">Alamat</th>
                <th width="100">Kota</th>
                <th width="50">Upload By</th>
                <th width="150">Upload At</th>
                <th width="50">Action</th>
            </tr>
            </thead>
        </table>
    </div>
<!-- /.box-body -->
</div>
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
    // $('.btn_submit').click();
    event.stopPropagation();
    event.preventDefault();

    var loading = $('.loading2');
    var form_user =  $('#form-user');
    loading.show();
    $.ajax({
      url: form_user.attr('action'),
      type: 'post',
      processData: false,
      contentType: false,
      data: new FormData(document.getElementById("form-user")),
      dataType: 'json',
    })
    .done(function(data) {
      if(data.status){
        console.log("sukses");
        bootbox.alert({
            title:"Pemberitahuan",
            message: "Data berhasil diupload",
            callback: function (result) {
              window.location = '{!!route('suppliersap')!!}'
            }
        });
      }
      else{
        bootbox.alert({
            title:"Pemberitahuan",
            message: "Format CSV Tidak Valid!",
            callback: function (result) {
              window.location = '{!!route('suppliersap')!!}'
            }
        });
      }
      loading.hide();
    })
    .always(function(){
      loading.hide();
    });
  });



  datatablesMe = $('#datatables').on('xhr.dt', function ( e, settings, json, xhr ) {
      //console.log(JSON.stringify(xhr));
      if(xhr.responseText=='Unauthorized.'){
        location.reload();
      }
      }).DataTable({
      processing: true,
      serverSide: true,
      autoWidth : true,
      scrollX   : true,

      order : [[ 0, 'desc' ]],
      pageLength: 10,
      ajax: '{!! route('supplier.sap.data') !!}',
      columns: [
          {data : 'DT_Row_Index',orderable:false,searchable:false},
          { data: 'name_1', name: 'name_1' },
          { data: 'vendor', name: 'vendor' },
          { data: 'street', name: 'street' },
          { data: 'city', name: 'city' },
          { data: 'upload_by', name: 'upload_by' },
          { data: 'upload_date', name: 'upload_date' },
          { data: 'action', name: 'action',orderable:false,searchable:false }
      ]
  });
});
</script>
@endpush