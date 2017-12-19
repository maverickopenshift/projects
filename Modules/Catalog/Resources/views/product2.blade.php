@extends('layouts.app')
@section('content')
@php
if(isset($data->id)){
	$id=$data->id;
}else{
	$id=0;
}

//$vkodeproduct=Helper::old_prop_each($product,'f_kodeproduct');

@endphp
{{old('f_kodeproduct')}}
<div class="row">
    <div class="col-md-3">
        <div class="box box-danger">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Daftar Kategori</h3>                
            </div>
            <div class="box-body form-horizontal">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" placeholder="Search Kategori.." class="form-control f_carikategori">
                    </div>
                </div>
                <div id="jstree"></div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="box box-danger">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Product</h3>
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
                <input type="hidden" class="f_parentid" name="f_parentid">
                {{ csrf_field() }}
                <div class="box-body form-horizontal">
                    <table class="table table-striped table-parent-product" width="100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th>Mata Uang</th>
                                <th>Harga</th>
                                <th>Deksripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-test">
                            <tr class="tabel-product">
                                <td class="{{ $errors->has('f_kodeproduct') ? ' has-error' : '' }}"> 
                                    <input type="text" name="f_kodeproduct[]" placeholder="Kode.." class="form-control" required>
                                    {!!Helper::error_help($errors,'f_kodeproduct')!!}
                                </td>
                                <td class="{{ $errors->has('f_namaproduct') ? ' has-error' : '' }}"> 
                                    <input type="text" name="f_namaproduct[]" placeholder="Nama .." class="form-control" required>
                                    {!!Helper::error_help($errors,'f_namaproduct')!!}
                                </td>
                                <td class="{{ $errors->has('f_unitproduct') ? ' has-error' : '' }}"> 
                                    <input type="text" name="f_unitproduct[]" placeholder="Unit.." class="form-control" required>
                                    {!!Helper::error_help($errors,'f_unitproduct')!!}
                                </td>
                                <td class="{{ $errors->has('f_mtuproduct') ? ' has-error' : '' }}"> 
                                    <select name="f_mtuproduct[]" class="form-control select2" style="width: 100%;" required>
                                        <option value=""></option>
                                        <option value="RP">RP</option>
                                        <option value="USD">USD</option>                       
                                    </select>
                                    {!!Helper::error_help($errors,'f_mtuproduct')!!}
                                </td>
                                <td class="{{ $errors->has('f_hargaproduct') ? ' has-error' : '' }}"> 
                                    <input type="text" name="f_hargaproduct[]" placeholder="Harga.." class="form-control input-rupiah" required>
                                    {!!Helper::error_help($errors,'f_hargaproduct')!!}
                                </td>
                                <td class="{{ $errors->has('f_descproduct') ? ' has-error' : '' }}"> 
                                    <input type="text" name="f_descproduct[]" placeholder="Deskripsi.." class="form-control" required>
                                    {!!Helper::error_help($errors,'f_descproduct')!!}
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
                        <input type="submit" class="btn btn-primary simpan-product" value="Simpan">
                    </div>
                </div>
            </form>
        </div>
    </div>
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
$(function() {
    $(".simpan-product").prop( "disabled", true );
    $('#daftar1').DataTable();
    $('#daftar1').DataTable();
    $('#daftar2').DataTable();
    $(".select2").select2({
        placeholder:"Silahkan Pilih"
    });

    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {
                $(".f_parentname").html("Tambah Product - " + data.instance.get_node(data.selected[0]).text);
                $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
                $(".simpan-product").prop( "disabled", false);
            }
        })
        .jstree({
            "plugins" : [ "search" ],
            'core' : {
                'data' : {
                    "url" : "{{route('catalog.category.get_category_all',['parent_id' => 0])}}",
                }
            }
    });

    var to = false;
    $('.f_carikategori').keyup(function () {
        if(to){clearTimeout(to);}

        to = setTimeout(function () {

            var v = $('.f_carikategori').val();
            $('#jstree').jstree(true).search(v);
        }, 250);
    });

    $('.table-parent-product').on('click', '.btn-delete', function(e){
        var rowCount = $('.table-parent-product tr:last').index() + 1;
        if(rowCount!=1){
            $(this).closest('tr').remove();    
        }
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
    });

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
    });
});
</script>
@endpush
