@extends('layouts.app')

@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">
          <div class="btn-group" role="group" aria-label="...">
            @if(\Auth::user()->hasPermission('tambah-user'))
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form-modal" data-title="Add"  data-backdrop="static" data-keyboard="false">
                  <i class="glyphicon glyphicon-plus"></i> Tambah
              </button>
            @endif
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
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div id="alertBS"></div>
        <table class="table table-condensed table-striped" id="datatables">
            <thead>
            <tr>
                <th width="20">No.</th>
                <th width="250">Name</th>
                <th width="350">Address</th>
                <th width="150">Phone</th>
                <th width="100">Created At</th>
                <th width="100">Updated At</th>
                <th width="100">Action</th>
            </tr>
            </thead>
        </table>
    </div>
<!-- /.box-body -->
</div>
@include('users::_form_modal_subsidiary_telkom')
@endsection
@push('css')
  <style>
    .loading-modal{
      background-image: url(images/loader.gif);background-color: rgba(255,255,255,0.6);position: absolute;width: 100%;height: 100%;z-index: 1;background-repeat: no-repeat;background-position: center center;display: none;
    }
  </style>
@endpush
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
      autoWidth : true,
      scrollX   : true,
      // fixedColumns:   {
      //       leftColumns: 2,
      //       rightColumns:1
      // },
      order : [[ 5, 'desc' ]],
      pageLength: 50,
      //ajax: '{!! route('users.subsidiary-telkom.data') !!}',
      ajax: {
          "url": "{!! route('users.subsidiary-telkom.data') !!}",
          "type": "POST",
          'headers': {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
      },
      columns: [
          {data : 'DT_Row_Index',orderable:false,searchable:false},
          { data: 'name', name: 'name' },
          { data: 'address', name: 'address' },
          { data: 'phone', name: 'phone' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
          { data: 'action', name: 'action',orderable:false,searchable:false }
      ]
  });
});
</script>
@endpush
