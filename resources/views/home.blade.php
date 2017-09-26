@extends('layouts.app')

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Visitors Report</h3>

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

        You are logged in!
    </div>
<!-- /.box-body -->
</div>
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">Box Danger</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        Test Box danger
    </div>
<!-- /.box-body -->
</div>
@endsection
