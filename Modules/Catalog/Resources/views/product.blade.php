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
            <a class="btn btn-default add-boq" data-toggle="modal" data-target="#modalboq">
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
                <tbody class="table-test">
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
                            <input type="text" name="f_hargaproduct[]" placeholder="Harga.." class="form-control input-rupiah" required>
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
                            <div class="btn-group">
                                <a href="{{route('catalog.product.edit')}}?id={{$rows->id}}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                <a href="{{route('catalog.product.delete')}}?id={{$rows->id}}" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                            </div>
	                    </td>
            		</tr>
            	@endforeach
            </tbody>
        </table>
    </div>
<!-- /.box-body -->
</div>

<div class="modal fade" id="modalboq" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Data BOQ</h4> 
            </div>
            <div class="modal-body table-parent-boq">
                <div style=" max-height: 500px; overflow: auto;" style="text-align: center;" id="holder">
                    <table id="daftar2" class="table table-striped table-parent-boq" width="100%">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th>Mata Uang</th>
                                <th>Harga</th>
                                <th>Deksripsi</th>
                            </tr>
                        </thead>
                        <tbody class="table-boq">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary simpan-boq">Simpan</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-danger fade" id="modal-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this data</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline btn-delete" data-loading-text="Please wait..."><i class="glyphicon glyphicon-trash"></i> Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
$('#daftar1').DataTable();
$('#daftar2').DataTable();
$(".select2").select2({
	placeholder:"Silahkan Pilih"
});

$(document).on('click', '.add-product', function(event) {
    $('.table-parent-product').find(".select2").each(function(index){
        if($(this).data('select2')) {
            $(this).select2('destroy');
        } 
    });

    $('.tabel-product:last').clone(true).insertAfter(".tabel-product:last").find("input:text").val("");
    $(".select2").select2({
        placeholder:"Silahkan Pilih"
    });
});

$('.table-parent-product').on('click', '.btn-delete', function(e){
    var rowCount = $('.table-parent-product tr:last').index() + 1;
    if(rowCount!=1){
        $(this).closest('tr').remove();    
    }
})

$(document).on('click', '.add-boq', function(event) {
   $.ajax({
        url: "{{route('catalog.boq')}}?id=0",
        dataType: 'json',
        success: function(data)
        {
            $('.table-boq').html("");
            var html = '';
            for(var i = 0; i < data.length; i++){
               html += "<tr>"+
                            "<td><input type='checkbox' name='f_boq[]' value='"+ data[i].id +"'></td>" +
                            "<td>" + data[i].kode_item + "</td>" +
                            "<td>" + data[i].item + "</td>" +
                            "<td>" + data[i].satuan + "</td>" +
                            "<td>" + data[i].mtu + "</td>" +
                            "<td>" + data[i].harga + "</td>" +
                            "<td>" + data[i].desc + "</td>" +
                        "</tr>";
                        
                }   
            $('.table-boq').html(html);
        }
    });
})

$(document).on('click', '.simpan-boq', function(event) {
    $('.table-boq').find('input[type=checkbox]').each(function (index) {
        if (this.checked) {

            $.ajax({
                url: "{{route('catalog.boq')}}?id=" + $(this).val(),
                dataType: 'json',
                success: function(data)
                {
                    $('.table-parent-product').find(".select2").each(function(index){
                        if($(this).data('select2')) {
                            $(this).select2('destroy');
                        } 
                    });

                    var new_row = $('.tabel-product:last').clone(true).insertAfter(".tabel-product:last");
                    var input_new_row = new_row.find('td');
                    input_new_row.eq(0).find('input').val(data[0].kode_item);
                    input_new_row.eq(1).find('input').val(data[0].item);
                    input_new_row.eq(2).find('select').val("");
                    input_new_row.eq(3).find('input').val(data[0].satuan);
                    input_new_row.eq(4).find('select').val("");
                    input_new_row.eq(5).find('input').val(data[0].harga);
                    input_new_row.eq(6).find('input').val(data[0].desc);

                    $(".select2").select2({
                        placeholder:"Silahkan Pilih"
                    });
                }
            });            
        }
    });
})
</script>
@endpush
