@extends('layouts.app')
@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">
          <div class="btn-group" role="group" aria-label="...">
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form-modal" data-title="Add">
                  <i class="glyphicon glyphicon-plus"></i> Add Categrys
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
        <div id="alertBS"></div>
        <table class="table table-condensed table-striped" id="datatables">
            <thead>
            <tr>
                <th width="20">Code</th>
                <th width="100">Display</th>
                <th width="100">Parent</th>
                <th width="150">Desc</th>
            </tr>
            </thead>
        </table>
    </div>
<!-- /.box-body -->
</div>
@endsection
@push('scripts')
<script>

</script>
@endpush
