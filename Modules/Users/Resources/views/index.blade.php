@extends('layouts.app')

@section('content')
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form-modal" data-title="Add">
                <i class="glyphicon glyphicon-plus"></i> Add User
            </button>
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
                <th width="">Username</th>
                <th width="">Email</th>
                <th width="">Phone</th>
                <th width="">Created At</th>
                <th width="">Updated At</th>
                <th width="">Roles</th>
                <th width="">Action</th>
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
      autoWidth : false,
      order : [[ 4, 'desc' ]],
      pageLength: 50,
      ajax: '{!! route('users.data') !!}',
      columns: [
          {data : 'DT_Row_Index',orderable:false,searchable:false},
          { data: 'name', name: 'name' },
          { data: 'username', name: 'username' },
          { data: 'email', name: 'email' },
          { data: 'phone', name: 'phone' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
          {data: 'role_name', name: 'roles.name'},
          { data: 'action', name: 'action',orderable:false,searchable:false }
      ]
  });
});
</script>
@endpush

