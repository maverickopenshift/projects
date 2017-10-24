@extends('layouts.app')

@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">
        <div class="btn-group" role="group" aria-label="...">
          @if(\Auth::user()->hasPermission('tambah-role'))
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form-modal" data-title="Add">
                <i class="glyphicon glyphicon-plus"></i> Add Roles
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
                <th width="">Name</th>
                <th width="">Display Name</th>
                <th width="">Description</th>
                {{-- <th width="">Created At</th>
                <th width="">Updated At</th> --}}
                <th width="500">Permissions</th>
                <th width="">Action</th>
            </tr>
            </thead>
        </table>
    </div>
<!-- /.box-body -->
</div>
@include('users::roles._form_modal')
@endsection
@push('scripts')
  <script src="/vendor/datatables/buttons.server-side.js"></script>
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
        autoWidth : false,
        order : [[ 1, 'desc' ]],
        pageLength: 50,
        ajax: '{!! route('users.roles.data') !!}',
        columns: [
            {data : 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'name', name: 'name' },
            { data: 'display_name', name: 'display_name' },
            { data: 'description', name: 'description' },
            // { data: 'created_at', name: 'created_at' },
            // { data: 'updated_at', name: 'updated_at' },
            {data: 'permission_name', name: 'permissions.name'},
            { data: 'action', name: 'action',orderable:false,searchable:false }
        ]
    });
  });
  </script>
@endpush
