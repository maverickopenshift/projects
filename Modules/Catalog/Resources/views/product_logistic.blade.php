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

            <form method="post" action="{{ route('catalog.product_logistic.add_ajax') }}" id="form-produk">
                {{ csrf_field() }}
                <input type="hidden" name="f_idproduct" value="{{$product->id}}">
                <div class="box-body form-horizontal">
                    <div class="flash-message" id="alertBS">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                    </div>

                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Taxonomy </label>
                        <div class="col-sm-10 text-me">{{$product->category_name}}</div>
                    </div>

                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Kode Master Item </label>
                        <div class="col-sm-10 text-me">{{$product->kode_product}}</div>
                    </div>

                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Keterangan </label>
                        <div class="col-sm-10 text-me">{{$product->keterangan_product}}</div>
                    </div>

                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Satuan </label>
                        <div class="col-sm-10 text-me">{{$product->nama_satuan}}</div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Pemilik Katalog </label>
                        <div class="col-sm-6 text-me text-uppercase">
                            <span class="span-oke">Nama</span> {{$pegawai->v_nama_karyawan}} <i>({{$pegawai->n_nik}})</i></br> 
                            <span class="span-oke">Divisi</span> {{$pegawai->divisi}} </br>
                            <span class="span-oke">Unit Bisnis</span> {{$pegawai->unit_bisnis}} </br>
                            <span class="span-oke">Unit Kerja</span> {{$pegawai->unit_kerja}} </br>
                            <span class="span-oke">Jabatan</span> {{$pegawai->v_short_posisi}} </br>
                        </div>
                    </div>

                    <table class="table table-striped table-parent-product" width="100%">
                        <thead>
                            <tr>
                                <th>Price Coverage</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                                <th>Jenis Referensi</th>
                                <th>Referensi</th>
                                <th>Flag</th>
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
        var new_row = $(template_add(dt.price_coverage, dt.harga_barang, dt.harga_jasa)).clone(true);
        $(".table-test").prepend(new_row);
        var input_new_row = new_row.find('td');

        select_referensi(input_new_row.eq(3).find('.select-jenis'), input_new_row.eq(4));

        var new_referensi = $(template_referensi_kontrak()).clone(true);
        input_new_row.eq(4).html('');
        input_new_row.eq(4).append(new_referensi);
        //select_kontrak_referensi(input_new_row.eq(4).find('.select_kontrak'));
        
    });

    fix_no_error();
}

$('.table-parent-product').on('click', '.btn-delete', function(e){
    var rowCount = $('.table-parent-product tr:last').index() + 1;
    if(rowCount!=1){
        $(this).closest('tr').remove();
    }else{
        alertBS('Jika jumlah baris hanya ada 1 tidak bisa di hapus, silahkan tambah sebelum menghapus','danger');
    }
});

$(document).on('click', '.add-product', function(event) {        
    var new_row = $(template_add('','','')).clone(true).insertAfter(".tabel-product:last");
    var input_new_row = new_row.find('td');

    select_referensi(input_new_row.eq(3).find('.select-jenis'), input_new_row.eq(4));

    var new_referensi = $(template_referensi_kontrak()).clone(true);
    input_new_row.eq(4).html('');
    input_new_row.eq(4).append(new_referensi);
    select_kontrak_referensi(input_new_row.eq(4).find('.select_kontrak'));
    
    fix_no_error();
});

function select_kontrak_referensi(input){
}

function select_referensi(input, isi){
    $(input).on('change', function(event) {        
        if(input.val()==1){
            var new_referensi = $(template_referensi_kontrak()).clone(true);
            isi.html('');
            isi.append(new_referensi);
            /*
            select_kontrak_referensi(isi.find('.select_kontrak'));
            */
        }else{
            var new_referensi = $(template_refrensi_freetext()).clone(true);
            isi.html('');
            isi.append(new_referensi);
        }
    });
}

function template_add(lokasi, harga_barang, harga_jasa){
    return '\
    <tr class="tabel-product">\
        <td class="formerror formerror-f_lokasi-0">\
            <input type="text" name="f_lokasi[]" placeholder="Price Coverage .." value="'+ lokasi +'" class="form-control">\
            <div class="error error-f_lokasi error-f_lokasi-0"></div>\
        </td>\
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
            <div class="error error-f_unitproduct error-f_unitproduct-0"></div>\
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
    ';
}

function template_refrensi_freetext(){
    return '\
        <input type="text" class="form-control" name="f_referensi[]" autocomplete="off" placeholder="Referensi..">\
    ';
}

function fix_no_error(){
    var $this = $('.tabel-product');
    $.each($this,function(index, el) {
        var mdf_new_row = $(this).find('td');

        if(mdf_new_row.eq(0).hasClass("has-error")){
            mdf_new_row.eq(0).removeClass().addClass("has-error formerror formerror-f_lokasi-"+ index);
        }else{
            mdf_new_row.eq(0).removeClass().addClass("formerror formerror-f_lokasi-"+ index);
        }

        if(mdf_new_row.eq(1).hasClass("has-error")){
            mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-f_hargabarang-"+ index);
        }else{
            mdf_new_row.eq(1).removeClass().addClass("formerror formerror-f_hargabarang-"+ index);
        }

        if(mdf_new_row.eq(2).hasClass("has-error")){
            mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-f_hargajasa-"+ index);
        }else{
            mdf_new_row.eq(2).removeClass().addClass("formerror formerror-f_hargajasa-"+ index);
        }

        if(mdf_new_row.eq(3).hasClass("has-error")){
            mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-f_jenis-"+ index);
        }else{
            mdf_new_row.eq(3).removeClass().addClass("formerror formerror-f_jenis-"+ index);
        }

        if(mdf_new_row.eq(4).hasClass("has-error")){
            mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-f_referensi-"+ index);
        }else{
            mdf_new_row.eq(4).removeClass().addClass("formerror formerror-f_referensi-"+ index);
        }

        $(this).find('.error-f_lokasi').removeClass().addClass("error error-f_lokasi error-f_lokasi-"+ index);
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
                  window.location.href = "{{route('catalog.list.product_logistic')}}";
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
    
    //doc_type.html(data.doc_type.toUpperCase());
    if(data.doc_type=="khs"){
        doc_type.html('<i class="fa fa-check" style="color:green;"></i>');
    }else{
        doc_type.html('');
    }
    
    
    $('#modalkontrak').modal('hide');
});

$(function(){
    var new_row = $(template_add('','','')).clone(true);
    $(".table-test").append(new_row);
    var input_new_row = new_row.find('td');
    
    select_referensi(input_new_row.eq(3).find('.select-jenis'), input_new_row.eq(4));
    
    var new_referensi = $(template_referensi_kontrak()).clone(true);
    input_new_row.eq(4).html('');
    input_new_row.eq(4).append(new_referensi);

    create_table_kontrak('');
    
    $("#alertBS").fadeTo(2000, 500).slideUp(500, function(){
        $("#alertBS").slideUp(500);
    });
});
</script>
@endpush
