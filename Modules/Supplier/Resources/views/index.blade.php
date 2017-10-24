@extends('layouts.app')

@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">
          <div class="btn-group" role="group" aria-label="...">
            <a href="{{route('supplier.create')}}" class="btn btn-default">
                <i class="glyphicon glyphicon-plus"></i> Add Supplier
            </a>
          </div>
      </h3>

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
                <th width="20">No.</th>
                <th width="100">Supplier</th>
                <th width="100">ID</th>
                <th width="200">Alamat</th>
                <th width="150">Kota</th>
                <th width="100">Telepon</th>
                <th width="100">Fax</th>
                <th width="150">Email</th>
                <th width="100">Created At</th>
                <th width="100">Updated At</th>
                <th width="100">Action</th>
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
            leftColumns: 3,
            rightColumns:1
      },
      order : [[ 8, 'desc' ]],
      pageLength: 50,
      ajax: '{!! route('supplier.data') !!}',
      columns: [
          {data : 'DT_Row_Index',orderable:false,searchable:false},
          { data: 'nm_vendor', name: 'nm_vendor' },
          { data: 'kd_vendor', name: 'kd_vendor' },
          { data: 'alamat', name: 'alamat' },
          { data: 'kota', name: 'kota' },
          { data: 'telepon', name: 'telepon' },
          { data: 'fax', name: 'fax' },
          { data: 'email', name: 'email' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
          { data: 'action', name: 'action',orderable:false,searchable:false }
      ]
  });
});
</script>
@endpush
