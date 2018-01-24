@extends('layouts.app')

@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">
        <div class="btn-group" role="group" aria-label="...">
          <a href="{{route('doc.template.create')}}" class="btn btn-default">
              <i class="glyphicon glyphicon-plus"></i> Add Template
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
                <th width="">Type</th>
                <th width="">Category</th>
                <th width="">Kode</th>
                <th width="">Created At</th>
                <th width="">Action</th>
            </tr>
            </thead>
        </table>
    </div>
<!-- /.box-body -->
</div>
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
        order : [[ 2, 'desc' ]],
        pageLength: 50,
        //ajax: '{!! route('doc.template.data') !!}',
        ajax: {
            "url": "{!! route('doc.template.data') !!}",
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
        },
        columns: [
            {data : 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'type.title', name: 'type.title' },
            { data: 'category.title', name: 'category.title' },
            { data: 'kode', name: 'kode' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action',orderable:false,searchable:false }
        ]
    });
  });
  </script>
@endpush
