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


@endphp
<div class="row">
    <div class="loading2"></div>

    <div class="col-md-12">
        <div class="box box-danger test-product">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Item Price</h3>
                <div class="pull-right">
                    <div class="col-sm-12">
                        <a class="btn btn-primary upload-product-price-btn" type="button"><i class="fa fa-upload"></i> Upload</a>
                        <a href="{{route('doc.tmp.download',['filename'=>'product_price'])}}" class="btn btn-info">
                            <i class="glyphicon glyphicon-download-alt"></i> Download Template
                        </a>
                        <span class="error error-product-price text-danger"></span>
                    </div>
                </div>
            </div>
                        
                <div class="box-body form-horizontal">
                    <div class="flash-message" id="alertBS">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-6">

                        <div class="form-group ">
                            <label class="col-sm-4 control-label">Taxonomy </label>
                            <div class="col-sm-8 text-me">
                                @foreach ($tree_kategori as $tree_kategori)

                                    <p>{{ $tree_kategori }}</p>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-4 control-label">Master Item </label>
                            <div class="col-sm-8 text-me">{{$product->kode_product}} - {{$product->nama_product}}</div>
                        </div>


                        <div class="form-group ">
                            <label class="col-sm-4 control-label">Satuan </label>
                            <div class="col-sm-8 text-me">{{$product->nama_satuan}}</div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-4 control-label">Serial </label>
                            <div class="col-sm-8 text-me">{{$product->serial_product}}</div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-4 control-label">Manufacture </label>
                            <div class="col-sm-8 text-me">{{$product->manufacture_product}}</div>
                        </div>
                        <br>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group ">
                            @if($product->image_product!="")
                                <img src='product_master/image/{{$product->image_product}}'></img>
                            @else
                                <img src="{{asset('images/no_image.png')}}" alt="Consys" style="width: 40%; height: 40%">
                            @endif
                            
                            
                        </div>
                    </div>

                    <form method="post" action="{{ route('catalog.product_logistic.add_ajax') }}" id="form-produk">
                        {{ csrf_field() }}
                        <input type="hidden" class="f_idproduct" name="f_idproduct" value="{{$product->id}}">

                        <table class="table table-striped table-parent-product" width="100%">
                            <thead>
                                <tr>
                                    <th>Group Coverage</th>
                                    <th>Price Coverage</th>
                                    <th>Harga Barang</th>
                                    <th>Harga Jasa</th>
                                    <th>Jenis Referensi</th>
                                    <th>Referensi</th>
                                    <th>KHS</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-test">
                            </tbody>
                        </table>
                </div>
                <div class="box-footer">
                    <div class="box-tools pull-right">
                        <a class="btn bg-red btn-reset" href="{{route('catalog.product.logistic')}}?id_product={{$product->id}}" style="margin-bottom: 2px;">
                            Reset
                        </a>
                        <input type="submit" class="btn btn-primary simpan-product" value="Simpan">
                    </div>
                </div>
            </form>

            <form id="form_me_upload_price" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="upload-product-price" class="upload-product-price hide" accept=".csv,.xls,.xlsx"/>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalkontrak" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Data Kontrak</h4> 
            </div>
            <div class="modal-body">
                <div class="form-group input-group">
                    <input class="form-control doc_text" type="text" placeholder="No.Kontrak / Judul Kontrak">
                    <span class="input-group-btn">
                        <a class="btn btn-primary cari-kontrak">Cari No Kontrak</a>
                    </span>
                </div>

                <div class="form-group table-parent-kontrak">
                    <div id="holder">
                        <table class="table table-striped" id="daftar_kontrak">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Kontrak</th>
                                    <th>Judul Kontrak</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Mitra</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary simpan-kontrak">Simpan</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#daftar1').DataTable();
var table_kontrak;
var doc_no_input;
var doc_text_input;
var doc_type;

$('.upload-product-price-btn').on('click', function(event) {
    event.stopPropagation();
    event.preventDefault();
    var $file = $('.upload-product-price').click();
});

$('.upload-product-price').on('change', function(event) {
    event.stopPropagation();
    event.preventDefault();
    $(".loading2").show();
    $.ajax({
        url: "{{ route('catalog.product_logistic.upload') }}",
        type: 'post',
        processData: false,
        contentType: false,
        data: new FormData(document.getElementById("form_me_upload_price")),
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
        var new_row = $(template_add(dt.error_group_coverage, dt.error_coverage, dt.harga_barang, dt.harga_jasa)).clone(true);
        $(".table-test").prepend(new_row);
        var input_new_row = new_row.find('td');
        select_referensi(input_new_row.eq(4).find('.select-jenis'), input_new_row.eq(5), input_new_row.eq(6));
        input_new_row.eq(4).find('.select-jenis').val(dt.jenis_referensi).trigger('change');

        if(dt.jenis_referensi==1){
            input_new_row.eq(5).find('.doc_no_input').val(dt.id_kontrak);
            input_new_row.eq(5).find('.doc_text_input').val(dt.referensi);
        }else{
            input_new_row.eq(5).find('.doc_no_input').val(dt.referensi);
        }

        if(dt.khs==1){
            input_new_row.eq(6).html('<i class="fa fa-check" style="color:green;"></i>');
        }else{
            input_new_row.eq(6).html('');
        }

        select_group_coverage(input_new_row.eq(0).find('.select_group_coverage'));

        if(dt.id_group_coverage!=0){
            set_select2(input_new_row.eq(0).find('.select_group_coverage'),dt.group_coverage, dt.id_group_coverage);
        }

        if(dt.id_coverage!=0){
            set_select2(input_new_row.eq(1).find('.select_coverage'),dt.coverage, dt.id_coverage);
        }
    });

    fix_no_error();
}

function set_select2(attr_obj,text,id) {
    attr_obj.find('option').remove();
    var newOption = new Option(text, id, false, true);
    attr_obj.append(newOption);
    attr_obj.val(id).change();
}

$('.table-parent-product').on('click', '.btn-delete', function(e){
    var rowCount = $('.table-parent-product tr:last').index() + 1;
    if(rowCount!=1){
        $(this).closest('tr').remove();
    }else{
        alertBS('Jika jumlah baris hanya ada 1 tidak bisa di hapus, silahkan tambah sebelum menghapus','danger');
    }

    fix_no_error();
});

$(document).on('click', '.add-product', function(event) {        
    var new_row = $(template_add('','','','','')).clone(true);
    $(".table-test").append(new_row);
    var input_new_row = new_row.find('td');

    select_referensi(input_new_row.eq(4).find('.select-jenis'), input_new_row.eq(5), input_new_row.eq(6));
    select_group_coverage(input_new_row.eq(0).find('.select_group_coverage'));

    var new_referensi = $(template_referensi_kontrak()).clone(true);
    input_new_row.eq(5).html('');
    input_new_row.eq(5).append(new_referensi);

    fix_no_error();
});

function select_referensi(input, isi, flag){
    $(input).on('change', function(event) {        
        if(input.val()==1){
            var new_referensi = $(template_referensi_kontrak()).clone(true);
            isi.html('');
            flag.html('');
            isi.removeClass().addClass("formerror formerror-f_referensi-0 isi-referensi");
            isi.append(new_referensi);
            fix_no_error();
        }else{
            var new_referensi = $(template_refrensi_freetext()).clone(true);
            isi.html('');
            flag.html('');
            isi.removeClass().addClass("formerror formerror-f_referensi-0 isi-referensi");

            isi.append(new_referensi);
            fix_no_error();
        }
    });   
}

function select_group_coverage(input){
    input.select2({
        placeholder : "Silahkan Pilih....",
        ajax: {
            url: '{!! route('catalog.coverage.get_group_coverage') !!}',
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

function select_coverage(input, group_coverage){
    input.select2({
        placeholder : "Silahkan Pilih....",
        ajax: {
            url: '{!! route('catalog.coverage.get_coverage') !!}?id_group_coverage=' + group_coverage,
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

function template_add(error_group_coverage, error_coverage, harga_barang, harga_jasa){
    console.log(harga_jasa);
    var template = '\
    <tr class="tabel-product">';

        if(error_group_coverage!=""){
            template = template + '\
                <td class="formerror formerror-f_nogroupcoverage-0 has-error">\
                    <select class="form-control select_group_coverage" name="f_nogroupcoverage[]" style="width: 100%;" required>\
                    <option value=""></option>\
                    </select>\
                    <div class="error error-f_nogroupcoverage error-f_nogroupcoverage-0 has-error"><span class="help-block">"'+ error_group_coverage +'"</span></div>\
                </td>';
        }else{
            template = template + '\
                <td class="formerror formerror-f_nogroupcoverage-0">\
                    <select class="form-control select_group_coverage" name="f_nogroupcoverage[]" style="width: 100%;" required>\
                    <option value=""></option>\
                    </select>\
                    <div class="error error-f_nogroupcoverage error-f_nogroupcoverage-0"></div>\
                </td>';
        }

        if(error_coverage!=""){
            template = template + '\
                <td class="formerror formerror-f_nocoverage-0 has-error">\
                    <select class="form-control select_coverage" name="f_nocoverage[]" style="width: 100%;" required>\
                    <option value=""></option>\
                    </select>\
                    <div class="error error-f_nocoverage error-f_nocoverage-0 has-error"><span class="help-block">"'+ error_coverage +'"</span></div>\
                </td>';
        }else{
            template = template + '\
                <td class="formerror formerror-f_nocoverage-0">\
                    <select class="form-control select_coverage" name="f_nocoverage[]" style="width: 100%;" required>\
                    <option value=""></option>\
                    </select>\
                    <div class="error error-f_nocoverage error-f_nocoverage-0"></div>\
                </td>';
        }

        template = template + '\
        <td class="formerror formerror-f_hargabarang-0">\
            <input type="text" name="f_hargabarang[]" placeholder="Harga Barang.." value="'+ harga_barang +'" class="form-control input-rupiah">\
            <div class="error error-f_hargabarang error-f_hargabarang-0"></div>\
        </td>\
        <td class="formerror formerror-f_hargajasa-0">\
            <input type="text" name="f_hargajasa[]" placeholder="Harga Jasa.."  value="'+ harga_jasa +'"  class="form-control input-rupiah">\
            <div class="error error-f_hargajasa error-f_hargajasa-0"></div>\
        </td>\
        <td class="formerror formerror-f_jenis-0">\
            <select class="form-control select-jenis" name="f_jenis[]"; style="width: 100%;">\
                <option value="1">No.Kontrak</option>\
                <option value="2">Freetext</option>\
            </select>\
            <div class="error error-f_jenis error-f_jenis-0"></div>\
        </td>\
        <td class="formerror formerror-f_referensi-0 isi-referensi">\
        </td>\
        <td class="isi-flag">\
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

    return template
}

function template_referensi_kontrak(){
    return '\
        <div class="input-group">\
            <input type="hidden" name="f_referensi[]" class="doc_no_input">\
            <input class="form-control doc_text_input" type="text" placeholder="No.Kontrak" readonly>\
            <span class="input-group-btn">\
                <button class="btn btn-success btn-open-kontrak" type="button"><i class="glyphicon glyphicon-search"></i></button>\
            </span>\
        </div>\
        <div class="error error-f_referensi error-f_referensi-0"></div>\
    ';
}

function template_refrensi_freetext(){
    return '\
        <input type="text" class="form-control doc_no_input" name="f_referensi[]" autocomplete="off" placeholder="Referensi..">\
        <div class="error error-f_referensi error-f_referensi-0"></div>\
    ';
}

function fix_no_error(){
    var $this = $('.tabel-product');
    $.each($this,function(index, el) {
        var mdf_new_row = $(this).find('td');

        if(mdf_new_row.eq(0).hasClass("has-error")){
            mdf_new_row.eq(0).removeClass().addClass("has-error formerror formerror-f_nogroupcoverage-"+ index);
        }else{
            mdf_new_row.eq(0).removeClass().addClass("formerror formerror-f_nogroupcoverage-"+ index);
        }

        if(mdf_new_row.eq(1).hasClass("has-error")){
            mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-f_nocoverage-"+ index);
        }else{
            mdf_new_row.eq(1).removeClass().addClass("formerror formerror-f_nocoverage-"+ index);
        }

        if(mdf_new_row.eq(2).hasClass("has-error")){
            mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-f_hargabarang-"+ index);
        }else{
            mdf_new_row.eq(2).removeClass().addClass("formerror formerror-f_hargabarang-"+ index);
        }

        if(mdf_new_row.eq(3).hasClass("has-error")){
            mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-f_hargajasa-"+ index);
        }else{
            mdf_new_row.eq(3).removeClass().addClass("formerror formerror-f_hargajasa-"+ index);
        }

        if(mdf_new_row.eq(4).hasClass("has-error")){
            mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-f_jenis-"+ index);
        }else{
            mdf_new_row.eq(4).removeClass().addClass("formerror formerror-f_jenis-"+ index);
        }

        if(mdf_new_row.eq(5).hasClass("has-error")){
            mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-f_referensi-"+ index);
        }else{
            mdf_new_row.eq(5).removeClass().addClass("formerror formerror-f_referensi-"+ index);
        }

        $(this).find('.error-f_nogroupcoverage').removeClass().addClass("error error-f_nogroupcoverage error-f_nogroupcoverage-"+ index);
        $(this).find('.error-f_nocoverage').removeClass().addClass("error error-f_nocoverage error-f_nocoverage-"+ index);
        $(this).find('.error-f_hargabarang').removeClass().addClass("error error-f_hargabarang error-f_hargabarang-"+ index);
        $(this).find('.error-f_hargajasa').removeClass().addClass("error error-f_hargajasa error-f_hargajasa-"+ index);
        $(this).find('.error-f_jenis').removeClass().addClass("error error-f_jenis error-f_jenis-"+ index);
        $(this).find('.error-f_referensi').removeClass().addClass("error error-f_referensi error-f_referensi-"+ index);

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
          $(".loading2").show();
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
                $(".loading2").hide();
                if(response.status=="all"){
                  window.location.href = "{{route('catalog.list.product_logistic')}}?no_product=" + $(".f_idproduct").val();
                }
              }
            }
          });
        }
      }
    });
});

function create_table_kontrak(text_cari_kontrak){
    table_kontrak = $('#daftar_kontrak').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth : false,
        searching : false,
        pageLength: 50,
        ajax: {
            "url": "{!! route('catalog.list.kontrak.datatables') !!}?cari=" + text_cari_kontrak,
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns:[
            { data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'doc_no'},
            { data: 'doc_title'},
            { data: 'doc_type'},
            { data: 'doc_startdate'},
            { data: 'doc_enddate'},
            { data: 'nama_supplier'},
            { data: 'action', name: 'action',orderable:false,searchable:false }],
    });
}

function refresh_table_kontrak(text_cari_kontrak){
    table_kontrak.destroy();
    create_table_kontrak(text_cari_kontrak)
}

var formModal = $('#modalkontrak');
formModal.on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)

    var text_cari_kontrak = $(".doc_text").val();

    refresh_table_kontrak('');
});

$(document).on('click', '.cari-kontrak', function(event) {
    var text_cari_kontrak = $(".doc_text").val();
    refresh_table_kontrak(text_cari_kontrak);
});

$(document).on('click', '.btn-open-kontrak', function(event) {
    var parent          = $(this).parent().parent();

    doc_no_input    = parent.find(".doc_no_input");
    doc_text_input  = parent.find(".doc_text_input");
    doc_type  = parent.parent().parent().find(".isi-flag");
    
    $('#modalkontrak').modal();
    refresh_table_kontrak('');
});

$(document).on('click', '.btn-pilih-kontrak', function(event) {
    var data = $(this).data('data');
    doc_no_input.val(data.id);
    doc_text_input.val(data.doc_no);
    
    if(data.doc_type=="khs"){
        doc_type.html('<i class="fa fa-check" style="color:green;"></i>');
    }else{
        doc_type.html('');
    }
    
    
    $('#modalkontrak').modal('hide');
});

$(document).on('change', '.select_group_coverage', function(event){
    $(this).closest('tr').find('.select_coverage').val('');
    select_coverage($(this).closest('tr').find('.select_coverage'),$(this).val());
});

$(function(){
    var new_row = $(template_add('','','','','')).clone(true);
    $(".table-test").append(new_row);
    var input_new_row = new_row.find('td');
    
    select_referensi(input_new_row.eq(4).find('.select-jenis'), input_new_row.eq(5), input_new_row.eq(6));
    input_new_row.eq(4).find('.select-jenis').val('1').trigger('change');

    select_group_coverage(input_new_row.eq(0).find('.select_group_coverage'));
    create_table_kontrak('');
    
    $("#alertBS").fadeTo(2000, 500).slideUp(500, function(){
        $("#alertBS").slideUp(500);
    });
});
</script>
@endpush
