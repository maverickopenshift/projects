@extends('layouts.app')

@section('content')
  <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">
            <div class="btn-group" role="group" aria-label="...">
              @if(\Auth::user()->hasPermission('tambah-config'))
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form-modal" data-title="Add">
                    <i class="glyphicon glyphicon-plus"></i> Add Config
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
          <table class="table table-condensed table-striped" id="datatables" style="width:100%">
              <thead>
              <tr>
                  <th>No.</th>
                  <th>Config Name</th>
                  <th>Description</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Action</th>
              </tr>
              </thead>
          </table>
      </div>
  <!-- /.box-body -->
  </div>
@include('config::form_modal')
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
      // scrollX   : true,
      // fixedColumns:   {
      //       leftColumns: 2,
      //       rightColumns:1
      // },
      order : [[ 1, 'desc' ]],
      pageLength: 50,
      ajax: '{!! route('config.data') !!}',
      columns: [
          {data : 'DT_Row_Index',orderable:false,searchable:false},
          { data: 'object_key', name: 'object_key' },
          { data: 'object_value', name: 'object_value' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
          { data: 'action', name: 'action',orderable:false,searchable:false }
      ]
  });
});
</script>
@endpush
