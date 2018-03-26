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

    .modal-xl {
        width: 90%;
        max-width:1200px;
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
            <form method="post" action="{{route('catalog.product.add_ajax')}}" id="form-produk">
                <input type="hidden" class="f_parentid" name="f_parentid" value="{{$f_parentid}}">
                {{ csrf_field() }}
                <div class="box-body form-horizontal">
                    <div class="flash-message" id="alertBS">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                    </div> <!-- end .flash-message -->

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
                                <th>Supplier</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th width="10%">Mata Uang</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                                <th>Deksripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-test">
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
    <div class="modal-dialog modal-xl">
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
                        <table id="daftar1" class="table table-striped table-parent-boq" width="100%">
                            <thead>
                                <tr>
                                    <th>Aksi</th>
                                    <th>Supplier</th>
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
                <button class="btn btn-primary simpan-boq">Simpan</button>
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

    function normal(){
        $(".add-product").prop("disabled", true);
        $(".test-product").addClass("disabledbutton");
        $(".add-boq").prop("disabled", true);
        $(".upload-boq-btn").prop("disabled", true);
        $(".simpan-product").prop( "disabled", true );

        //var new_row = $(template_add()).clone(true).insertAfter(".tabel-product:last");
        var new_row = $(template_add()).clone(true);
        $(".table-test").append(new_row);
        var input_new_row = new_row.find('td');
        
        select_supplier(input_new_row.eq(0).find('.select-supplier'));
        input_new_row.eq(4).find('select').select2({
            placeholder:"Silahkan Pilih"
        });

        $("#alertBS").fadeTo(2000, 500).slideUp(500, function(){
            $("#alertBS").slideUp(500);
        });
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
            fix_no_error();
        }else{
            alertBS('Jika jumlah baris hanya ada 1 tidak bisa di hapus, silahkan tambah sebelum menghapus','danger');
        }
    });

    $(document).on('click', '.add-product', function(event) {        
        var new_row = $(template_add()).clone(true).insertAfter(".tabel-product:last");
        var input_new_row = new_row.find('td');
        
        select_supplier(input_new_row.eq(0).find('.select-supplier'));
        input_new_row.eq(4).find('select').select2({
            placeholder:"Silahkan Pilih"
        });

        fix_no_error();
    });

    $(document).on('click', '.add-boq', function(event) {
        if($(".select-kontrak").data('select2')){
            $(".select-kontrak").select2('destroy');
        }

        $('.select-kontrak').select2({
            placeholder : "Silahkan Pilih....",
            dropdownParent: $('.select-kontrak').parent(),
            ajax: {
                url: '{!! route('catalog.no_kontrak') !!}',
                dataType: 'json',
                delay: 350,
                
                data: function (params) {
                    var datas =  {
                        q: params.term,
                        page: params.page
                    };
                    return datas;
                },                
                processResults: function (data, params) {
                    var results = [];
                    $.each(data.data, function (i, v) {                       
                        var o = {};
                        o.id = v.id;
                        o.text = v.text;
                        results.push(o);
                    })
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: (data.next_page_url ? true: false)
                        }
                    };
                },                
                cache: true
            },        
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            templateResult: function (state) {
                if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching..' ;  }
                var $state = $(
                    '<span>'+  state.text + '</span>'
                );
                return $state;
            },
            templateSelection: function (data) {
                if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
                    return "Silahkan Pilih..";
                }
                if(data.text === undefined){
                  return data.text;
                }
                return data.text ;
            }
        });

        fix_no_error();
    });

    $(document).on('click', '.cari-kontrak', function(event) {
        var id_kontrak = $(".select-kontrak").val();
        $.ajax({
            url: "{{route('catalog.cari_no_kontrak')}}?id=" + id_kontrak,
            dataType: 'json',
            success: function(data)
            {
                $('.table-boq').html("");
                var html = '';
                for(var i = 0; i < data.length; i++){
                   html += "<tr>"+
                                "<td><input type='checkbox' name='f_boq[]' value='"+ data[i].id +"'></td>" +
                                "<td>" + data[i].bdn_usaha + "."+ data[i].nm_vendor +"</td>" +
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
        $(".simpan-boq").prop("disabled",true);
        
        $('.table-boq').find('input[type=checkbox]').each(function (index) {
            if (this.checked) {
                $.ajax({
                    url: "{{route('catalog.boq')}}?id=" + $(this).val(),
                    dataType: 'json',
                    success: function(data)
                    {
                        var new_row = $(template_boq()).clone(true).insertAfter(".tabel-product:last");
                        var input_new_row = new_row.find('td');

                        input_new_row.eq(0).find('.f_nosupplier').val(data[0].supplier_id);
                        input_new_row.eq(0).find('.f_namasupplier').val(data[0].bdn_usaha + "."+ data[0].nm_vendor);                        
                        input_new_row.eq(1).find('input').val(data[0].kode_item);                        
                        input_new_row.eq(2).find('input').val(data[0].item);                        
                        input_new_row.eq(3).find('input').val(data[0].satuan);                        
                        input_new_row.eq(4).find('select').val(data[0].mtu);
                        input_new_row.eq(4).find('select').select2({
                            placeholder:"Silahkan Pilih"
                        });

                        input_new_row.eq(5).find('input').val(data[0].harga);                        
                        input_new_row.eq(6).find('input').val(data[0].harga_jasa);                        
                        input_new_row.eq(7).find('input').val(data[0].desc);                        
                    }
                });
            }
        });

        $("#modalboq").modal('hide');
        $(".simpan-boq").prop("disabled",false);
    });

    function template_boq(){
        return '\
        <tr class="tabel-product">\
            <td class="formerror formerror-f_nosupplier-0">\
                <input type="hidden" name="f_nosupplier[]" class="f_nosupplier">\
                <input type="text" name="f_namasupplier[]" placeholder="Kode.." class="form-control f_namasupplier" readonly>\
                <div class="error error-f_nosupplier error-f_nosupplier-0"></div>\
            </td>\
            <td class="formerror formerror-f_kodeproduct-0">\
                <input type="text" name="f_kodeproduct[]" placeholder="Kode.." class="form-control">\
                <div class="error error-f_kodeproduct error-f_kodeproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_namaproduct-0">\
                <input type="text" name="f_namaproduct[]" placeholder="Nama .." class="form-control">\
                <div class="error error-f_namaproduct error-f_namaproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_unitproduct-0">\
                <input type="text" name="f_unitproduct[]" placeholder="Unit.." class="form-control">\
                <div class="error error-f_unitproduct error-f_unitproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_mtuproduct-0">\
                <select name="f_mtuproduct[]" class="form-control" style="width: 100%;">\
                    <option value="IDR">IDR</option>\
                    <option value="USD">USD</option>\
                </select>\
                <div class="error error-f_mtuproduct error-f_mtuproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_hargaproduct-0">\
                <input type="text" name="f_hargaproduct[]" placeholder="Harga Barang.." class="form-control input-rupiah">\
                <div class="error error-f_hargaproduct error-f_hargaproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_hargajasa-0">\
                <input type="text" name="f_hargajasa[]" placeholder="Harga Jasa.." class="form-control input-rupiah">\
                <div class="error error-f_hargajasa error-f_hargajasa-0"></div>\
            </td>\
            <td class="formerror formerror-f_descproduct-0">\
                <input type="text" name="f_descproduct[]" placeholder="Deskripsi.." class="form-control">\
                <div class="error error-f_descproduct error-f_descproduct-0"></div>\
            </td>\
            <td width="100px">\
                <div class="btn-group">\
                    <a class="btn btn-primary add-product">\
                        <i class="glyphicon glyphicon-plus"></i>\
                    </a>\
                    <a class="btn bg-red btn-delete" style="margin-bottom: 2px;">\
                        <i class="glyphicon glyphicon-trash"></i>\
                    </a>\
                </div>\
            </td>\
        </tr>';
    }

    function template_add(){
        return '\
        <tr class="tabel-product">\
            <td class="formerror formerror-f_nosupplier-0">\
                <select class="form-control select-supplier" name="f_nosupplier[]"; style="width: 100%;">\
                </select>\
                <div class="error error-f_nosupplier error-f_nosupplier-0"></div>\
            </td>\
            <td class="formerror formerror-f_kodeproduct-0">\
                <input type="text" name="f_kodeproduct[]" placeholder="Kode.." class="form-control">\
                <div class="error error-f_kodeproduct error-f_kodeproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_namaproduct-0">\
                <input type="text" name="f_namaproduct[]" placeholder="Nama .." class="form-control">\
                <div class="error error-f_namaproduct error-f_namaproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_unitproduct-0">\
                <input type="text" name="f_unitproduct[]" placeholder="Unit.." class="form-control">\
                <div class="error error-f_unitproduct error-f_unitproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_mtuproduct-0">\
                <select name="f_mtuproduct[]" class="form-control" style="width: 100%;">\
                    <option value="IDR" selected>IDR</option>\
                    <option value="USD">USD</option>\
                </select>\
                <div class="error error-f_mtuproduct error-f_mtuproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_hargaproduct-0">\
                <input type="text" name="f_hargaproduct[]" placeholder="Harga Barang.." class="form-control input-rupiah">\
                <div class="error error-f_hargaproduct error-f_hargaproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_hargajasa-0">\
                <input type="text" name="f_hargajasa[]" placeholder="Harga Jasa.." class="form-control input-rupiah">\
                <div class="error error-f_hargajasa error-f_hargajasa-0"></div>\
            </td>\
            <td class="formerror formerror-f_descproduct-0">\
                <input type="text" name="f_descproduct[]" placeholder="Deskripsi.." class="form-control">\
                <div class="error error-f_descproduct error-f_descproduct-0"></div>\
            </td>\
            <td width="100px">\
                <div class="btn-group">\
                    <a class="btn btn-primary add-product">\
                        <i class="glyphicon glyphicon-plus"></i>\
                    </a>\
                    <a class="btn bg-red btn-delete" style="margin-bottom: 2px;">\
                        <i class="glyphicon glyphicon-trash"></i>\
                    </a>\
                </div>\
            </td>\
        </tr>';
    }

    function select_supplier(input){
        input.select2({
            placeholder : "Silahkan Pilih....",
            ajax: {
                url: '{!! route('catalog.supplier') !!}',
                dataType: 'json',
                delay: 350,
                
                data: function (params) {
                    var datas =  {
                        q: params.term,
                        page: params.page
                    };
                    return datas;
                },                
                processResults: function (data, params) {
                    var results = [];
                    $.each(data.data, function (i, v) {                       
                        var o = {};
                        o.id = v.id;
                        o.text = v.text;
                        results.push(o);
                    })
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: (data.next_page_url ? true: false)
                        }
                    };
                },                
                cache: true
            },        
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            templateResult: function (state) {
                if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching..' ;  }
                var $state = $(
                    '<span>'+  state.text + '</span>'
                );
                return $state;
            },
            templateSelection: function (data) {
                if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
                    return "Silahkan Pilih..";
                }
                if(data.text === undefined){
                  return data.text;
                }
                return data.text ;
            }
        });
    }

    function fix_no_error(){
        console.log("test");
        var $this = $('.tabel-product');
        $.each($this,function(index, el) {
            console.log(index);
            var mdf_new_row = $(this).find('td');
            //mdf_new_row.eq(0).find('.total_pasal').text(index+1);

            if(mdf_new_row.eq(0).hasClass("has-error")){
                mdf_new_row.eq(0).removeClass().addClass("has-error formerror formerror-f_nosupplier-"+ index);
            }else{
                mdf_new_row.eq(0).removeClass().addClass("formerror formerror-f_nosupplier-"+ index);
            }

            if(mdf_new_row.eq(1).hasClass("has-error")){
                mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-f_kodeproduct-"+ index);
            }else{
                mdf_new_row.eq(1).removeClass().addClass("formerror formerror-f_kodeproduct-"+ index);
            }

            if(mdf_new_row.eq(2).hasClass("has-error")){
                mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-f_namaproduct-"+ index);
            }else{
                mdf_new_row.eq(2).removeClass().addClass("formerror formerror-f_namaproduct-"+ index);
            }

            if(mdf_new_row.eq(3).hasClass("has-error")){
                mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-f_unitproduct-"+ index);
            }else{
                mdf_new_row.eq(3).removeClass().addClass("formerror formerror-f_unitproduct-"+ index);
            }

            if(mdf_new_row.eq(4).hasClass("has-error")){
                mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-f_mtuproduct-"+ index);
            }else{
                mdf_new_row.eq(4).removeClass().addClass("formerror formerror-f_mtuproduct-"+ index);
            }

            if(mdf_new_row.eq(5).hasClass("has-error")){
                mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-f_hargaproduct-"+ index);
            }else{
                mdf_new_row.eq(5).removeClass().addClass("formerror formerror-f_hargaproduct-"+ index);
            }

            if(mdf_new_row.eq(6).hasClass("has-error")){
                mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-f_hargajasa-"+ index);
            }else{
                mdf_new_row.eq(6).removeClass().addClass("formerror formerror-f_hargajasa-"+ index);
            }

            if(mdf_new_row.eq(7).hasClass("has-error")){
                mdf_new_row.eq(7).removeClass().addClass("has-error formerror formerror-f_descproduct-"+ index);
            }else{
                mdf_new_row.eq(7).removeClass().addClass("formerror formerror-f_descproduct-"+ index);
            }

            $(this).find('.error-f_nosupplier').removeClass().addClass("error error-f_nosupplier error-f_nosupplier-"+ index);
            $(this).find('.error-f_kodeproduct').removeClass().addClass("error error-f_kodeproduct error-f_kodeproduct-"+ index);
            $(this).find('.error-f_namaproduct').removeClass().addClass("error error-f_namaproduct error-f_namaproduct-"+ index);
            $(this).find('.error-f_unitproduct').removeClass().addClass("error error-f_unitproduct error-f_unitproduct-"+ index);
            $(this).find('.error-f_mtuproduct').removeClass().addClass("error error-f_mtuproduct error-f_mtuproduct-"+ index);
            $(this).find('.error-f_hargaproduct').removeClass().addClass("error error-f_hargaproduct error-f_hargaproduct-"+ index);
            $(this).find('.error-f_hargajasa').removeClass().addClass("error error-f_hargajasa error-f_hargajasa-"+ index);
            $(this).find('.error-f_descproduct').removeClass().addClass("error error-f_descproduct error-f_descproduct-"+ index);

        });        
    }

    $(document).on('click', '.simpan-product', function(event) {
        event.preventDefault();
        
        var formMe = $('#form-produk');
        $(".formerror").removeClass("has-error");
        $(".error").html('');

        bootbox.confirm({
          title:"Konfirmasi",
          message: "Apakah anda yakin untuk submit?",
          buttons: {
              confirm: {
                  label: 'Yakin',
                  className: 'btn-success'
              },
              cancel: {
                  label: 'Tidak',
                  className: 'btn-danger'
              }
          },
          callback: function (result) {
            if(result){
              $.ajax({
                url: formMe.attr('action'),
                type: 'post',
                processData: false,
                contentType: false,
                data: new FormData(document.getElementById("form-produk")),
                dataType: 'json',
                success: function(response){
                  if(response.errors){
                    $.each(response.errors, function(index, value){
                        if (value.length !== 0){
                          index = index.replace(".", "-");
                          $(".formerror-"+ index).removeClass("has-error");
                          $(".error-"+ index).html('');

                          $(".formerror-"+ index).addClass("has-error");
                          $(".error-"+ index).html('<span class="help-block">'+ value +'</span>');
                        }
                    });

                    bootbox.alert({
                      title:"Pemberitahuan",
                      message: "Data yang Anda masukan belum valid, silahkan periksa kembali!",
                    });
                  }else{
                    /*
                    bootbox.success({
                      title:"Pemberitahuan",
                      message: "Data Product berhasil di masukin!",
                    });
                    */

                    if(response.status=="all"){
                      window.location.href = "{{route('catalog.product')}}";
                    }
                  }
                }
              });
            }
          }
        });
      });
});
</script>
@endpush
