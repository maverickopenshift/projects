@extends('layouts.app')
@section('content')
@php
if(isset($data->id)){
	$id=$data->id;
}else{
	$id=0;
}

@endphp
<div class="box box-danger">
    <div class="box-header with-border">
		<h3 class="box-title">Tambah Product</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-default add-product">
                <i class="glyphicon glyphicon-plus"></i> Tambah
            </a>
            <a class="btn btn-default add-product">
                <i class="glyphicon glyphicon-plus"></i> Tambah BOQ
            </a>
        </div>
    </div>    
    <form method="post" action="{{route('catalog.product.add')}}">
        {{ csrf_field() }}
        <div class="box-body form-horizontal">
            <table class="table table-striped table-parent-product" width="100%">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Unit</th>
                    <th>Mata Uang</th>
                    <th>Harga</th>
                    <th>Deksripsi</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody >
                        <tr class="tabel-product">
                            <td> 
                                <input type="text" name="f_kodeproduct[]" placeholder="Kode.." class="form-control" required>
                            </td>
                            <td> 
                                <input type="text" name="f_namaproduct[]" placeholder="Nama .." class="form-control" required>
                            </td>
                            <td> 
                                <select name="f_indukproduct[]" class="form-control select2" required>
                                    <option value=""></option>
                                    @foreach($category as $i=>$rows)
                                    @php                        
                                    if($rows->id==$id){
                                        $a="selected";
                                    }else{
                                        $a="";
                                    }
                                    @endphp
                                        <option value="{{$rows->id}}" {{$a}}>{{$rows->display_name}}</option>
                                    @endforeach                        
                                </select>
                            </td>
                            <td> 
                                <input type="text" name="f_unitproduct[]" placeholder="Unit.." class="form-control" required>
                            </td>
                            <td> 
                                <select name="f_matauang[]" class="form-control select2" required>
                                    <option value=""></option>
                                    <option value="RP">RP</option>
                                    <option value="USD">USD</option>                       
                                </select>
                            </td>
                            <td> 
                                <input type="text" name="f_hargaproduct[]" placeholder="Harga.." class="form-control" required>
                            </td>
                            <td> 
                                <input type="text" name="f_descproduct[]" placeholder="Deskripsi.." class="form-control" required>
                            </td>
                            <td>
                                <button class="btn bg-red btn-delete" style="margin-bottom: 2px;">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="box-tools pull-right">
                <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
        </div>
    </form>
</div>


<div class="box box-danger">
    <div class="box-header with-border">
		<h3 class="box-title">
			Daftar Kategori
		</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="alertBS"></div>
        <table class="table table-striped" id="daftar1">
            <thead>
            <tr>
                <th width="20">Kode</th>
                <th width="100">Nama</th>
                <th width="100">Kategori</th>
                <th width="100">Unit</th>
                <th width="100">Mata Uang</th>
                <th width="100">Harga</th>
                <th width="150">Deksripsi</th>
                <th width="100">Keyword</th>
                <th width="200">Aksi</th>
            </tr>
            </thead>
            <tbody>
            	@foreach($product as $i=>$rows)
            		<tr>
            			<td>{{$rows->code}}</td>
            			<td>{{$rows->name}}</td>
            			<td>{{$rows->category_name}}</td>
            			<td>{{$rows->unit}}</td>
                        <td>{{$rows->currency}}</td>
                        <td>{{$rows->price}}</td>
                        <td>{{$rows->desc}}</td>
                        <td>{{$rows->keyword}}</td>
            			<td>
            				<a href="{{route('catalog.product.edit')}}?id={{$rows->id}}">
	            				<span class="btn bg-green" style="margin-bottom: 2px;">
	                                Rubah
	                            </span>
	                        </a>
	                        <a href="{{route('catalog.product.delete')}}?id={{$rows->id}}">
	            				<span class="btn bg-red" style="margin-bottom: 2px;">
	                                Hapus
	                            </span>
	                        </a>
	                    </td>
            		</tr>
            	@endforeach
            </tbody>
        </table>
    </div>
<!-- /.box-body -->
</div>
</div>
@endsection
@push('scripts')
<script>
$('#daftar1').DataTable();
$(".select2").select2({
	placeholder:"Silahkan Pilih"
});

$(document).on('click', '.add-product', function(event) {
    $('.table-parent-product').find(".select2").each(function(index){
        if($(this).data('select2')) {
            $(this).select2('destroy');
        } 
    });

    $('.tabel-product:last').clone( true).insertAfter(".tabel-product:last").find("input:text").val("");
    $(".select2").select2({
        placeholder:"Silahkan Pilih"
    });
});

$('.table-parent-product').on('click', '.btn-delete', function(e){
   $(this).closest('tr').remove()
})

function product_template(){
    return "";
}
</script>
@endpush
