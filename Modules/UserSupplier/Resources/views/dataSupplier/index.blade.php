@extends('layouts.app')

@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">
          <div class="btn-group" role="group" aria-label="...">
            <a href="{{route('supplier.tambah')}}" class="btn btn-default">
                <i class="glyphicon glyphicon-plus"></i> Tambah Kelengkapan Data
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
                <th width="100">Name Mitra Telkom</th>
                <th width="100">Alamat Perusahaan</th>
                <th width="150">Media Komunikasi</th>
                <th width="100">Klarisifikasi Usaha (KADIN)</th>
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
      // console.log(JSON.stringify(xhr));
      if(xhr.responseText=='Unauthorized.'){
        location.reload();
      }
      }).DataTable({
      processing: true,
      serverSide: true,
      // scrollX   : true,
      autoWidth : false,
      fixedColumns:   {
            leftColumns: 2,
            rightColumns:1
      },
      order : [[ 4, 'desc' ]],
      pageLength: 50,
      ajax: '{!! route('supplier.isi') !!}',
      columns: [
          {data : 'DT_Row_Index',orderable:false,searchable:false},
          { data: 'nm_vendor', name: 'nm_vendor' },
          { data: 'alamat', name: 'alamat' },
          { data: 'telepon', name: 'telepon' },
          { data: 'created_at', name: 'created_at' },
      ]
  });
});
</script>
@endpush
