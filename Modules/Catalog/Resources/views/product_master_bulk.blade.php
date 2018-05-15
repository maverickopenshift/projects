@extends('layouts.app')
@section('content')

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
@php
if(isset($kategori->id)){
    $title="- ". $kategori->code ." - ". $kategori->display_name;
    $idkategori=$kategori->id;
}else{
    $title="";
    $idkategori=0;
}
@endphp
<div class="row">
    <div class="loading2"></div>
    <div class="col-md-12">
        <div class="box box-danger test-product">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Master Item {{$title}}</h3>
                <div class="pull-right">
                    <div class="col-sm-12">                        
                        <a class="btn btn-primary upload-product-master-btn" type="button"><i class="fa fa-upload"></i> Upload</a>
                        <a href="{{route('doc.tmp.download',['filename'=>'product_master_bulk'])}}" class="btn btn-info">
                            <i class="glyphicon glyphicon-download-alt"></i> Download Template
                        </a>
                        <span class="error error-product-master text-danger"></span>
                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('catalog.product_master.bulk_add') }}" id="form-produk">

                <input type="hidden" class="f_parentid" name="f_parentid" value="{{$idkategori}}">
                {{ csrf_field() }}
                <div class="box-body form-horizontal">
                    <div class="flash-message" id="alertBS">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                    </div>

                    <table class="table table-striped table-parent-product" width="100%">
                        <thead>
                            <tr>
                                <th>Taxonomy</th>
                                <th>Kode</th>
                                <th>Keterangan</th>
                                <th>Satuan</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-test">
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-tools pull-right">
                        <a class="btn bg-red btn-reset" href="{{route('catalog.product.master')}}" style="margin-bottom: 2px;">
                            Reset
                        </a>
                        <input type="submit" class="btn btn-primary simpan-product" value="Simpan">
                    </div>
                </div>
            </form>

            <form id="form_me_upload_master" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="upload-product-master" class="upload-product-master hide" accept=".csv,.xls,.xlsx"/>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    var to = false;
    $('#daftar1').DataTable();

    $('.upload-product-master-btn').on('click', function(event) {
        event.stopPropagation();
        event.preventDefault();
        var $file = $('.upload-product-master').click();
    });

    $('.upload-product-master').on('change', function(event) {
        event.stopPropagation();
        event.preventDefault();
        $(".loading2").show();
        $.ajax({
            url: "{{ route('catalog.product_master.upload_bulk') }}",
            type: 'post',
            processData: false,
            contentType: false,
            data: new FormData(document.getElementById("form_me_upload_master")),
            dataType: 'json',
        })
        .done(function(data) {
            if(data.status==true){
                handleFile(data);
                $(".loading2").hide();
            }else{
                $(".loading2").hide();
                alertBS('File yang di upload kosong, atau tidak sesuai format template','danger');
            }
        });

        $(this).val('');
    });

    function handleFile(data) {
        $.each(data.data,function(index, el) {
            var dt = data.data[index];
            //var new_row = $(template_add('','')).clone(true);
            
            var new_row = $(template_add(dt.kode, dt.keterangan, dt.error_kategori, dt.error_satuan)).clone(true);;
            $(".table-test").prepend(new_row);
            var input_new_row = new_row.find('td');
            select_satuan(input_new_row.eq(3).find('.select_satuan'));
            select_kategori(input_new_row.eq(0).find('.select_category'));

            if(dt.no_satuan!=0){
                set_select2(input_new_row.eq(3).find('.select_satuan'),dt.satuan,dt.no_satuan);
            }

            if(dt.id_kategori!=0){
                set_select2(input_new_row.eq(0).find('.select_category'),dt.kode_kategori,dt.id_kategori);
            }
        });
        fix_no_error();       
    }

    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {
                $(".f_parentname").html("Tambah Master Item - " + data.instance.get_node(data.selected[0]).text);
                $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
                $(".test-product").removeClass("disabledbutton");
                $(".add-product").prop("disabled", false);
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

             if(parent!=""){
                $('#jstree').jstree('select_node', parent);
             }
        });

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
        var new_row = $(template_add('','','','')).clone(true).insertAfter(".tabel-product:last");
        var input_new_row = new_row.find('td');

        select_satuan(input_new_row.eq(3).find('.select_satuan'));
        select_kategori(input_new_row.eq(0).find('.select_category'));
        
        fix_no_error();
    });

    function template_add(kode, keterangan, error_kategori, error_satuan){
        var template = '\
        <tr class="tabel-product">';

            if(error_kategori!=""){
                template  = template + '\
                    <td class="formerror formerror-f_idcategory-0 has-error">\
                        <select class="form-control select_category" name="f_idcategory[]" style="width: 100%;" required>\
                        <option value=""></option>\
                        </select>\
                        <div class="error error-f_idcategory error-f_idcategory-0 has-error"><span class="help-block">"'+ error_kategori +'"</span></div>\
                    </td>';
            }else{
                template = template + '\
                    <td class="formerror formerror-f_idcategory-0">\
                        <select class="form-control select_category" name="f_idcategory[]" style="width: 100%;" required>\
                        <option value=""></option>\
                        </select>\
                        <div class="error error-f_idcategory error-f_idcategory-0"></div>\
                    </td>';
            }

            template = template + '\
                <td class="formerror formerror-f_kodeproduct-0">\
                    <input type="text" name="f_kodeproduct[]" placeholder="Kode.." value="'+ kode +'" class="form-control">\
                    <div class="error error-f_kodeproduct error-f_kodeproduct-0"></div>\
                </td>\
                <td class="formerror formerror-f_ketproduct-0">\
                    <input type="text" name="f_ketproduct[]" placeholder="Keterangan .." value="'+ keterangan +'" class="form-control">\
                    <div class="error error-f_ketproduct error-f_ketproduct-0"></div>\
                </td>';

            if(error_satuan!=""){
                template  = template + '\
                    <td class="formerror formerror-f_unitproduct-0 has-error">\
                        <select class="form-control select_satuan" name="f_unitproduct[]" style="width: 100%;" required>\
                        <option value=""></option>\
                        </select>\
                        <div class="error error-f_unitproduct error-f_unitproduct-0 has-error"><span class="help-block">"'+ error_satuan +'"</span></div>\
                    </td>';
            }else{
                template = template + '\
                    <td class="formerror formerror-f_unitproduct-0">\
                        <select class="form-control select_satuan" name="f_unitproduct[]" style="width: 100%;" required>\
                        <option value=""></option>\
                        </select>\
                        <div class="error error-f_unitproduct error-f_unitproduct-0"></div>\
                    </td>';
            }

            template = template + '\
            <td class="formerror formerror-f_gambar-0">\
                <div class="input-group">\
                    <input type="file" name="f_gambar[]" accept=".jpg" class="hide">\
                    <input class="form-control" type="text" placeholder="Gambar.." readonly>\
                    <span class="input-group-btn">\
                        <button class="btn btn-success click-upload" type="button"><i class="glyphicon glyphicon-search"></i></button>\
                    </span>\
                </div>\
                <div class="error error-f_gambar error-f_gambar-0"></div>\
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

        return template;
    }

    function select_satuan(input){
        input.select2({
            placeholder : "Silahkan Pilih....",
            ajax: {
                url: '{!! route('catalog.product_master.get_satuan') !!}',
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

    function select_kategori(input){
        input.select2({
            placeholder : "Silahkan Pilih....",
            ajax: {
                url: '{!! route('catalog.product_master.get_category') !!}',
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
        var $this = $('.tabel-product');
        $.each($this,function(index, el) {
            var mdf_new_row = $(this).find('td');

            if(mdf_new_row.eq(0).hasClass("has-error")){
                mdf_new_row.eq(0).removeClass().addClass("has-error formerror formerror-f_idcategory-"+ index);
            }else{
                mdf_new_row.eq(0).removeClass().addClass("formerror formerror-f_idcategory-"+ index);
            }

            if(mdf_new_row.eq(1).hasClass("has-error")){
                mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-f_kodeproduct-"+ index);
            }else{
                mdf_new_row.eq(1).removeClass().addClass("formerror formerror-f_kodeproduct-"+ index);
            }

            if(mdf_new_row.eq(2).hasClass("has-error")){
                mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-f_ketproduct-"+ index);
            }else{
                mdf_new_row.eq(2).removeClass().addClass("formerror formerror-f_ketproduct-"+ index);
            }

            if(mdf_new_row.eq(3).hasClass("has-error")){
                mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-f_unitproduct-"+ index);
            }else{
                mdf_new_row.eq(3).removeClass().addClass("formerror formerror-f_unitproduct-"+ index);
            }

            if(mdf_new_row.eq(4).hasClass("has-error")){
                mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-f_gambar-"+ index);
            }else{
                mdf_new_row.eq(4).removeClass().addClass("formerror formerror-f_gambar-"+ index);
            }

            $(this).find('.error-f_idcategory').removeClass().addClass("error error-f_idcategory error-f_idcategory-"+ index);
            $(this).find('.error-f_kodeproduct').removeClass().addClass("error error-f_kodeproduct error-f_kodeproduct-"+ index);
            $(this).find('.error-f_ketproduct').removeClass().addClass("error error-f_ketproduct error-f_ketproduct-"+ index);
            $(this).find('.error-f_unitproduct').removeClass().addClass("error error-f_unitproduct error-f_unitproduct-"+ index);
            $(this).find('.error-f_gambar').removeClass().addClass("error error-f_gambar error-f_gambar-"+ index);

        });        
    }

    $(document).on('click', '.simpan-product', function(event) {
        event.preventDefault();
        $(".loading2").show();
        var formMe = $('#form-produk');
        $(".formerror").removeClass("has-error");
        $(".error").html('');
        var f_parentid = $(".f_parentid").val();
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
                    $(".loading2").hide();

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
                    if(response.status=="all"){
                      window.location.href = "{{route('catalog.list.product_master')}}";
                    }
                  }
                }
              });
            }
          }
        });
    });

    function set_select2(attr_obj,text,id) {
        attr_obj.find('option').remove();
        var newOption = new Option(text, id, false, true);
        attr_obj.append(newOption);
        attr_obj.val(id).change();
        //var id_name = attr_obj.attr('id');
    }

    $(function(){
        var new_row = $(template_add('','','','')).clone(true);
        $(".table-test").append(new_row);
        var input_new_row = new_row.find('td');
        
        select_satuan(input_new_row.eq(3).find('.select_satuan'));
        select_kategori(input_new_row.eq(0).find('.select_category'));

        $("#alertBS").fadeTo(2000, 500).slideUp(500, function(){
            $("#alertBS").slideUp(500);
        });
    });
</script>
@endpush
