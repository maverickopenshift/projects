@extends('layouts.app')
@section('content')
@php
if(isset($data->id)){
    $id=$data->id;
}else{
    $id=0;
}

$product=array();
$f_kodeproduct=Helper::old_prop_each($product,'f_kodeproduct');
$f_namaproduct=Helper::old_prop_each($product,'f_namaproduct');
$f_unitproduct=Helper::old_prop_each($product,'f_unitproduct');
$f_mtuproduct=Helper::old_prop_each($product,'f_mtuproduct');
$f_hargaproduct=Helper::old_prop_each($product,'f_hargaproduct');
$f_hargajasa=Helper::old_prop_each($product,'f_hargajasa');
$f_descproduct=Helper::old_prop_each($product,'f_descproduct');
$f_parentid=old('f_parentid');
@endphp

<style type="text/css">
    #jstree{
        max-width: 90%;
    }

    #jstree a {
        white-space: normal !important;
        height: auto;
        padding: 1px 2px;
    }

    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }
</style>

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
        <div class="box box-danger test-product">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Item Katalog</h3>
            </div>    
            <form method="post" action="{{route('catalog.product.add')}}">
                <input type="hidden" class="f_parentid" name="f_parentid" value="{{$f_parentid}}">
                {{ csrf_field() }}
                <div class="box-body form-horizontal">
                    <div id="alertBS"></div>

                    <div class="form-group pull-right">
                        <div class="col-sm-12">
                            <a class="btn btn-default add-boq" data-toggle="modal" data-target="#modalboq">
                                <i class="glyphicon glyphicon-plus"></i> BOQ Kontrak
                            </a>
                            <input type="file" name="upload-boq" class="upload-boq hide"/>
                            <a class="btn btn-primary upload-boq-btn" type="button"><i class="fa fa-upload"></i> Upload</a>
                            
                            <a href="{{route('doc.tmp.download',['filename'=>'harga_satuan'])}}" class="btn btn-info"><i class="glyphicon glyphicon-download-alt"></i> Download Template</a>
                            
                        </div>
                    </div>

                    <table class="table table-striped table-parent-product" width="100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th>Mata Uang</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                                <th>Deksripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-test">
                            @if(count($f_kodeproduct)>0)
                                @foreach ($f_kodeproduct as $key => $value)
                                <tr class="tabel-product">
                                    <td class="{{ $errors->has('f_kodeproduct.'.$key) ? ' has-error' : '' }}">
                                        <input type="text" value="{{$f_kodeproduct[$key]}}" name="f_kodeproduct[]" placeholder="Kode.." class="form-control">
                                        {!!Helper::error_help($errors,'f_kodeproduct.'.$key)!!}
                                    </td>
                                    <td class="{{ $errors->has('f_namaproduct.'.$key) ? ' has-error' : '' }}">
                                        <input type="text" value="{{$f_namaproduct[$key]}}" name="f_namaproduct[]" placeholder="Nama .." class="form-control">
                                        {!!Helper::error_help($errors,'f_namaproduct.'.$key)!!}
                                    </td>
                                    <td class="{{ $errors->has('f_unitproduct.'.$key) ? ' has-error' : '' }}">
                                        <input type="text" value="{{$f_unitproduct[$key]}}" name="f_unitproduct[]" placeholder="Unit.." class="form-control">
                                        {!!Helper::error_help($errors,'f_unitproduct.'.$key)!!}
                                    </td>
                                    <td class="{{ $errors->has('f_mtuproduct.'.$key) ? ' has-error' : '' }}">
                                      @php
                                          if($f_mtuproduct[$key]=="RP"){
                                              $a="selected";
                                              $b="";
                                          }else if($f_mtuproduct[$key]=="USD"){
                                              $a="";
                                              $b="selected";
                                          }else{
                                              $a="";
                                              $b="";
                                          }
                                      @endphp
                                        <select name="f_mtuproduct[]" class="form-control select2" style="width: 100%;">
                                            <option value=""></option>
                                            <option value="RP" {{$a}}>RP</option>
                                            <option value="USD" {{$b}}>USD</option>
                                        </select>
                                        {!!Helper::error_help($errors,'f_mtuproduct.'.$key)!!}
                                    </td>
                                    <td class="{{ $errors->has('f_hargaproduct.'.$key) ? ' has-error' : '' }}">
                                        <input type="text" value="{{$f_hargaproduct[$key]}}" name="f_hargaproduct[]" placeholder="Harga Barang.." class="form-control input-rupiah">
                                        {!!Helper::error_help($errors,'f_hargaproduct.'.$key)!!}
                                    </td>
                                    <td class="{{ $errors->has('f_hargajasa.'.$key) ? ' has-error' : '' }}">
                                        <input type="text" value="{{$f_hargajasa[$key]}}" name="f_hargajasa[]" placeholder="Harga Jasa.." class="form-control input-rupiah">
                                        {!!Helper::error_help($errors,'f_hargajasa.'.$key)!!}
                                    </td>
                                    <td class="{{ $errors->has('f_descproduct.'.$key) ? ' has-error' : '' }}">
                                        <input type="text" value="{{$f_descproduct[$key]}}" name="f_descproduct[]" placeholder="Deskripsi.." class="form-control">
                                        {!!Helper::error_help($errors,'f_descproduct.'.$key)!!}
                                    </td>
                                    <td width="100px">
                                        <div class="btn-group">
                                            <a class="btn btn-primary add-product">
                                                <i class="glyphicon glyphicon-plus"></i>
                                            </a>
                                            <a class="btn bg-red btn-delete" style="margin-bottom: 2px;">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr class="tabel-product">
                                <td>
                                    <input type="text" name="f_kodeproduct[]" placeholder="Kode.." class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="f_namaproduct[]" placeholder="Nama .." class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="f_unitproduct[]" placeholder="Unit.." class="form-control">
                                </td>
                                <td>
                                    <select name="f_mtuproduct[]" class="form-control select2" style="width: 100%;">
                                        <option value=""></option>
                                        <option value="RP">RP</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="f_hargaproduct[]" placeholder="Harga Barang.." class="form-control input-rupiah">
                                </td>
                                <td>
                                    <input type="text" name="f_hargajasa[]" placeholder="Harga Jasa.." class="form-control input-rupiah">
                                </td>
                                <td>
                                    <input type="text" name="f_descproduct[]" placeholder="Deskripsi.." class="form-control">
                                </td>
                                <td width="100px">
                                    <div class="btn-group">
                                        <a class="btn btn-primary add-product">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </a>
                                        <a class="btn bg-red btn-delete" style="margin-bottom: 2px;">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-tools pull-right">
                        <a class="btn bg-red btn-reset" href="{{route('catalog.product')}}" style="margin-bottom: 2px;">
                            Reset
                        </a>
                        <input type="submit" class="btn btn-primary simpan-product" value="Simpan">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalboq" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Data BOQ</h4>
            </div>
            <div class="modal-body">
                <div class="form-group input-group">
                    <select class="form-control select-kontrak" style="width: 100%;">
                    </select>
                    <span class="input-group-btn">
                        <a class="btn btn-primary cari-kontrak">Cari No Kontrak</a>
                    </span>
                </div>

                <div class="form-group table-parent-boq">
                    <div style=" max-height: 500px; overflow: auto;" style="text-align: center;" id="holder">
                        <table id="daftar2" class="table table-striped table-parent-boq" width="100%">
                            <thead>
                                <tr>
                                    <th>Aksi</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Unit</th>
                                    <th>Mata Uang</th>
                                    <th>Harga Material</th>
                                    <th>Harga Jasa</th>
                                    <th>Deksripsi</th>
                                </tr>
                            </thead>
                            <tbody class="table-boq">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-primary simpan-boq">Simpan</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
$(function() {
    normal();
    $('#daftar1').DataTable();
    $('#daftar1').DataTable();
    $('#daftar2').DataTable();

    $(".select2").select2({
        placeholder:"Silahkan Pilih"
    });

    function normal(){
        $(".add-product").prop("disabled", true);
        $(".test-product").addClass("disabledbutton");
        $(".add-boq").prop("disabled", true);
        $(".upload-boq-btn").prop("disabled", true);
        $(".simpan-product").prop( "disabled", true );
    }

    $('.upload-boq-btn').on('click', function(event) {
        event.stopPropagation();
        event.preventDefault();
        var $file = $('.upload-boq').click();
    });

    $('.upload-boq').on('change', function(event) {
        event.stopPropagation();
        event.preventDefault();
        BoqFile(this.files[0]);
    });

    function BoqFile(file) {
        console.log("upload start");
        Papa.parse(file, {
            header: true,
            dynamicTyping: true,
            complete: function(results) {
                
                var fields = results.meta.fields;
                @php
                    echo "var fields_dec = ['KODE_ITEM','ITEM','SATUAN','MTU','HARGA','KETERANGAN'];";
                    echo "var fields_length_set = 6;";
                @endphp

                if(fields.length!==fields_length_set || JSON.stringify(fields_dec)!==JSON.stringify(fields)){
                    alertBS("Format file tidak valid");
                    //$('.error-daftar_harga').html('Format CSV tidak valid!');
                    return false;
                }

                if(results.data.length==0){
                    console.log("data tidak ada");
                    //$('.error-daftar_harga').html('Data tidak ada!');
                    return false;
                }                
                $.each(results.data,function(index, el) {
                    if(results.data[index].KODE_ITEM!=""){
                        $('.table-parent-product').find(".select2").each(function(index){
                            if($(this).data('select2')) {
                                $(this).select2('destroy');
                            }
                        });

                        var new_row = $('.tabel-product:last').clone(true).insertAfter(".tabel-product:last");
                        var input_new_row = new_row.find('td');

                        input_new_row.eq(0).find('input').val(results.data[index].KODE_ITEM);
                        input_new_row.eq(0).find('.error').remove();
                        input_new_row.eq(0).removeClass("has-error");
                        input_new_row.eq(1).find('input').val(results.data[index].ITEM);
                        input_new_row.eq(1).find('.error').remove();
                        input_new_row.eq(1).removeClass("has-error");
                        input_new_row.eq(2).find('input').val(results.data[index].SATUAN);
                        input_new_row.eq(2).find('.error').remove();
                        input_new_row.eq(2).removeClass("has-error");
                        input_new_row.eq(3).find('select').val(results.data[index].MTU);
                        input_new_row.eq(3).find('.error').remove();
                        input_new_row.eq(3).removeClass("has-error");
                        input_new_row.eq(4).find('input').val(results.data[index].HARGA);
                        input_new_row.eq(4).find('.error').remove();
                        input_new_row.eq(4).removeClass("has-error");
                        input_new_row.eq(5).find('input').val(results.data[index].HARGA_JASA);
                        input_new_row.eq(5).find('.error').remove();
                        input_new_row.eq(5).removeClass("has-error");
                        input_new_row.eq(6).find('input').val(results.data[index].KETERANGAN);
                        input_new_row.eq(6).find('.error').remove();
                        input_new_row.eq(6).removeClass("has-error");

                        $(".select2").select2({
                            placeholder:"Silahkan Pilih"
                        });
                    }
                });
            }
        });
    }

    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {
                $(".f_parentname").html("Tambah Product - " + data.instance.get_node(data.selected[0]).text);
                $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
                $(".test-product").removeClass("disabledbutton");
                $(".add-product").prop("disabled", false);
                $(".add-boq").prop("disabled", false);
                $(".upload-boq-btn").prop("disabled", false);
                $(".simpan-product").prop( "disabled", false );
            }
        })
        .jstree({
            "plugins" : [ "search" ],
            'core' : {
                'data' : {
                    "url" : "{{route('catalog.category.get_category_all',['parent_id' => 0])}}",
                }
            }
        })
        .bind("ready.jstree", function (event, data) {
             $(this).jstree("open_all");
             var parent=$(".f_parentid").val();
             console.log(parent);

             if(parent!=""){
                $('#jstree').jstree('select_node', parent);
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
        }else{
            alertBS('Jika jumlah baris hanya ada 1 tidak bisa di hapus, silahkan tambah sebelum menghapus','danger');
        }
    });

    $(document).on('click', '.add-product', function(event) {
        $('.table-parent-product').find(".select2").each(function(index){
            if($(this).data('select2')) {
                $(this).select2('destroy');
            }
        });

        var new_row = $('.tabel-product:last').clone(true).insertAfter(".tabel-product:last");
        var input_new_row = new_row.find('td');

        input_new_row.eq(0).find('input').val("");
        input_new_row.eq(0).find('.error').remove();
        input_new_row.eq(0).removeClass("has-error");
        input_new_row.eq(1).find('input').val("");
        input_new_row.eq(1).find('.error').remove();
        input_new_row.eq(1).removeClass("has-error");
        input_new_row.eq(2).find('input').val("");
        input_new_row.eq(2).find('.error').remove();
        input_new_row.eq(2).removeClass("has-error");
        input_new_row.eq(3).find('select').val("");
        input_new_row.eq(3).find('.error').remove();
        input_new_row.eq(3).removeClass("has-error");
        input_new_row.eq(4).find('input').val("");
        input_new_row.eq(4).find('.error').remove();
        input_new_row.eq(4).removeClass("has-error");
        input_new_row.eq(5).find('input').val("");
        input_new_row.eq(5).find('.error').remove();
        input_new_row.eq(5).removeClass("has-error");
        input_new_row.eq(6).find('input').val("");
        input_new_row.eq(6).find('.error').remove();
        input_new_row.eq(6).removeClass("has-error");

        $(".select2").select2({
            placeholder:"Silahkan Pilih"
        });
    });

    $(document).on('click', '.add-boq', function(event) {
        $.ajax({
            url: "{{route('catalog.no_kontrak')}}",
            dataType: 'json',
            success: function(data)
            {
                $(".select-kontrak").select2({
                    data: data
                });

            }
        });
    });

    $(document).on('click', '.cari-kontrak', function(event) {
        var id_kontrak = $(".select-kontrak").val();
        $.ajax({
            url: "{{route('catalog.cari_no_kontrak')}}?id=" + id_kontrak,
            dataType: 'json',
            success: function(data)
            {
                console.log(id_kontrak);
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
                                "<td>" + data[i].harga_jasa + "</td>" +
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
                console.log($(this).val());

                $.ajax({
                    url: "{{route('catalog.boq')}}?id=" + $(this).val(),
                    dataType: 'json',
                    success: function(data)
                    {
                        console.log(data);
                        $('.table-parent-product').find(".select2").each(function(index){
                            if($(this).data('select2')) {
                                $(this).select2('destroy');
                            }
                        });

                        var new_row = $('.tabel-product:last').clone(true).insertAfter(".tabel-product:last");
                        var input_new_row = new_row.find('td');

                        input_new_row.eq(0).find('input').val(data[0].kode_item);
                        input_new_row.eq(0).find('.error').remove();
                        input_new_row.eq(0).removeClass("has-error");
                        input_new_row.eq(1).find('input').val(data[0].item);
                        input_new_row.eq(1).find('.error').remove();
                        input_new_row.eq(1).removeClass("has-error");
                        input_new_row.eq(2).find('input').val(data[0].satuan);
                        input_new_row.eq(2).find('.error').remove();
                        input_new_row.eq(2).removeClass("has-error");
                        input_new_row.eq(3).find('select').val(data[0].mtu);
                        input_new_row.eq(3).find('.error').remove();
                        input_new_row.eq(3).removeClass("has-error");
                        input_new_row.eq(4).find('input').val(data[0].harga);
                        input_new_row.eq(4).find('.error').remove();
                        input_new_row.eq(4).removeClass("has-error");
                        input_new_row.eq(5).find('input').val(data[0].harga_jasa);
                        input_new_row.eq(5).find('.error').remove();
                        input_new_row.eq(5).removeClass("has-error");
                        input_new_row.eq(6).find('input').val(data[0].desc);
                        input_new_row.eq(6).find('.error').remove();
                        input_new_row.eq(6).removeClass("has-error");
                        $(".select2").select2({
                            placeholder:"Silahkan Pilih"
                        });

                        $("#modalboq").modal('hide');
                    }
                });
            }
        });
    });
});
</script>
@endpush
