@extends('layouts.app')
@section('content')

@php
$id=0;
$matauang_a="selected";
$matauang_b="";
if(isset($data->id)){
	$id=$data->id;
    if($data->currency=="RP"){
        $matauang_a="selected";
        $matauang_b="";
    }else{
        $matauang_a="";
        $matauang_b="selected";
    }
}
@endphp

<div class="box box-danger">
    <div class="box-header with-border">
		<h3 class="box-title">Rubah Produk - {{$data->name or ''}}</h3>
    </div>
    <div class="box-body form-horizontal parent-product">
        <form method="post" action="{{route('catalog.product.edit_proses')}}" id="fileinfo">
        	<input type="hidden" name="id" value="{{$id}}">
        	{{ csrf_field() }}
        	
        	<div class="form-group">
                <label class="col-sm-3 control-label">Kode Produk</label>
                <div class="col-sm-6">
                    <input type="text" name="f_kodeproduct" value="{{$data->code or ''}}" placeholder="Kode Produk.." class="form-control" required>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-3 control-label">Nama Produk</label>
                <div class="col-sm-6">
                    <input type="text" name="f_namaproduct" value="{{$data->name or ''}}" placeholder="Nama Produk.." class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Induk Produk</label>
                <div class="col-sm-6">
                    <select name="f_indukproduct" class="form-control select2" required>
                        <option value=""></option>
                        @foreach($category as $i=>$rows)
                        @php                        
                        if($rows->id==$data->catalog_category_id){
	                        $a="selected";
	                    }else{
		                    $a="";
		                }
                        @endphp
                        	<option value="{{$rows->id}}" {{$a}}>{{$rows->display_name}}</option>
                        @endforeach                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Unit Produk</label>
                <div class="col-sm-6">
                    <input type="text" name="f_unitproduct" value="{{$data->unit or ''}}" placeholder="Nama Kategori.." class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Mata Uang</label>
                <div class="col-sm-6">
                    <select name="f_matauang" class="form-control select2" required>
                        <option value=""></option>
                        <option value="RP" {{$matauang_a}}>RP</option>
                        <option value="USD" {{$matauang_b}}>USD</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Harga Produk</label>
                <div class="col-sm-6">
                    <input type="text" name="f_hargaproduct" value="{{$data->price or ''}}" placeholder="Harga Produk.." class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Deskripsi</label>
                <div class="col-sm-6">
                	<textarea class="form-control"  name="f_descproduct" placeholder="Deskripsi..">{{$data->desc or ''}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-md-offset-3">
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('.parent-product').find(".select2").each(function(index){
    if($(this).data('select2')) {
        $(this).select2('destroy');
    } 
});

$(".select2").select2({
	placeholder:"Silahkan Pilih"
});
</script>
@endpush
