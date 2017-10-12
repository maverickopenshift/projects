@extends('layouts.app')

@section('content')
  <form action="#" method="post">
    {{ csrf_field() }}
    @if ($errors->has('error'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      {{ $errors->first('error') }}
    </div>
    @endif
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">Informasi Vendor</a></li>
          <li><a href="#tab_2" data-toggle="tab">Data Vendor</a></li>
          <li><a href="#tab_3" data-toggle="tab">Finansial Aspek</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            @include('supplier::add.infovendor')
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_2">
            @include('supplier::add.datavendor')
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_3">
            @include('supplier::add.finansial')
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
  </form>
@endsection
@push('scripts')
<script>

</script>
@endpush
