@extends('layouts.app')

@section('content')
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Informasi Vendor
            (<span class="text-info" style="font-weight:bold;font-size:20px;"> {{Helper::prop_exists($supplierSap,'vendor')}}</span>)
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nama Perusahaan </label>
          <div class="col-sm-10 text-me">{{$supplierSap->name_1 or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Negara </label>
          <div class="col-sm-10 text-me">{{$supplierSap->cty or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Kota </label>
          <div class="col-sm-10 text-me">{{$supplierSap->city or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Alamat </label>
          <div class="col-sm-10 text-me">{{$supplierSap->street or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Kode Pos </label>
          <div class="col-sm-10 text-me">{{$supplierSap->postalcode or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Title </label>
          <div class="col-sm-10 text-me">{{$supplierSap->title or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Group </label>
          <div class="col-sm-10 text-me">{{$supplierSap->group or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">NPWP </label>
          <div class="col-sm-10 text-me">{{$supplierSap->vat_registration_no or '-'}}</div>
        </div>
      </div>
      <div class="form-group text-center top50">
        <a href="{{route('suppliersap')}}" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">BACK</a>
      </div>
    </div>
<!-- /.box-body -->
</div>
@endsection
@push('scripts')
<script>

</script>
@endpush
