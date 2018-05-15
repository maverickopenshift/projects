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
</style>

<div class="row">
    <div class="loading2"></div>
    <div class="col-md-12">
        <div class="box box-danger test-product">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Taxonomy</h3>
                <div class="pull-right">
                    <div class="col-sm-12">                        
                        <a class="btn btn-primary upload-kategori-btn" type="button"><i class="fa fa-upload"></i> Upload</a>
                        <a href="{{route('doc.tmp.download',['filename'=>'taxonomy'])}}" class="btn btn-info">
                            <i class="glyphicon glyphicon-download-alt"></i> Download Template
                        </a>
                    </div>
                </div>
            </div>


            <form method="post" action="{{ route('catalog.category.bulk_add') }}" id="form-produk">
                {{ csrf_field() }}
                <div class="box-body form-horizontal">
                    <div id="alertBS"></div>

                    <table class="table table-striped table-parent-kontrak" width="100%">
                        <thead>
                            <tr>
                                <th>Kode Parent</th>
                                <th>Kode Taxonomy</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-isi">
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-tools pull-right">
                        <a class="btn bg-red btn-reset" href="{{route('catalog.product.kontrak')}}" style="margin-bottom: 2px;">
                            Reset
                        </a>
                        <input type="submit" class="btn btn-primary simpan-product" value="Simpan">
                    </div>
                </div>
            </form>

            <form id="form_me_upload_taxonomy" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="upload-taxonomy" class="upload-product-taxonomy hide" accept=".csv,.xls,.xlsx"/>
            </form>
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

$('.upload-kategori-btn').on('click', function(event) {
    event.stopPropagation();
    event.preventDefault();
    var $file = $('.upload-product-taxonomy').click();
});

$('.upload-product-taxonomy').on('change', function(event) {
    event.stopPropagation();
    event.preventDefault();
    $(".loading2").show();
    $.ajax({
        url: "{{ route('catalog.category.bulk_upload') }}",
        type: 'post',
        processData: false,
        contentType: false,
        data: new FormData(document.getElementById("form_me_upload_taxonomy")),
        dataType: 'json',
    })
    .done(function(data) {
        console.log(data.status);
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
        var new_row = $(template_add(dt.id_parent, dt.kode_parent, dt.kode, dt.nama, dt.error_kode_parent, dt.error_kode)).clone(true);
        $(".table-isi").prepend(new_row);
    });
    fix_no_error();
}

$(document).on('click', '.add-product', function(event) {        
    var new_row = $(template_add('','','','','','')).clone(true);
    $(".table-isi").append(new_row);
    var input_new_row = new_row.find('td');
    fix_no_error();
});

$('.table-parent-kontrak').on('click', '.btn-delete', function(e){
    var rowCount = $('.table-parent-kontrak tr:last').index() + 1;
    if(rowCount!=1){
        $(this).closest('tr').remove();
    }else{
        alertBS('Jika jumlah baris hanya ada 1 tidak bisa di hapus, silahkan tambah sebelum menghapus','danger');
    }
    fix_no_error();
});

function template_add(id_parent, kode_parent, kode, nama, error_kode_parent, error_kode, error_nama){
    var template ='\
    <tr class="tabel-product">';

        if(error_kode_parent!=""){
            template  = template + '\
                <td class="formerror formerror-f_kodeparent-0 has-error">\
                    <input type="hidden" name="f_idparent[]" value="'+ id_parent +'">\
                    <input type="text" name="f_kodeparent[]" placeholder="Kode Parent .." value="'+ kode_parent +'" class="form-control">\
                        <div class="error error-f_kodeparent error-f_kodeparent-0 has-error"><span class="help-block">"'+ error_kode_parent +'"</span></div>\
                </td>';
        }else{
            template = template + '\
                <td class="formerror formerror-f_kodeparent-0">\
                    <input type="hidden" name="f_idparent[]" value="'+ id_parent +'">\
                    <input type="text" name="f_kodeparent[]" placeholder="Kode Parent .." value="'+ kode_parent +'" class="form-control">\
                        <div class="error error-f_kodeparent error-f_kodeparent-0"></div>\
                </td>';
        }

        if(error_kode!=""){
            template  = template + '\
            <td class="formerror formerror-f_kode-0 has-error">\
                <input class="form-control f_kode" name="f_kode[]" type="text" placeholder="Kode Kategori" value="'+ kode +'">\
                <div class="error error-f_kode error-f_kode-0 has-error"><span class="help-block">"'+ error_kode +'"</span></div>\
            </td>';
        }else{
            template  = template + '\
            <td class="formerror formerror-f_kode-0">\
                <input class="form-control f_kode"  name="f_kode[]" type="text" placeholder="Kode Kategori" value="'+ kode +'">\
                <div class="error error-f_kode error-f_kode-0"></div>\
            </td>';  
        }

        template  = template + '\
        <td class="formerror formerror-f_nama-0">\
            <input class="form-control doc_text_input" name="f_nama[]" type="text" placeholder="Nama Kategori" value="'+ nama +'">\
            <div class="error error-f_nama error-f_nama-0"></div>\
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

function fix_no_error(){
    var $this = $('.tabel-isi');
    $.each($this,function(index, el) {
        var mdf_new_row = $(this).find('td');

        if(mdf_new_row.eq(0).hasClass("has-error")){
            mdf_new_row.eq(0).removeClass().addClass("has-error formerror formerror-f_kodeparent-"+ index);
        }else{
            mdf_new_row.eq(0).removeClass().addClass("formerror formerror-f_kodeparent-"+ index);
        }

        if(mdf_new_row.eq(1).hasClass("has-error")){
            mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-f_kode-"+ index);
        }else{
            mdf_new_row.eq(1).removeClass().addClass("formerror formerror-f_kode-"+ index);
        }

        if(mdf_new_row.eq(2).hasClass("has-error")){
            mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-f_nama-"+ index);
        }else{
            mdf_new_row.eq(2).removeClass().addClass("formerror formerror-f_nama-"+ index);
        }

        $(this).find('.error-f_kodeparent').removeClass().addClass("error error-f_kodeparent error-f_kodeparent-"+ index);
        $(this).find('.error-f_kode').removeClass().addClass("error error-f_kode error-f_kode-"+ index);
        $(this).find('.error-f_nama').removeClass().addClass("error error-f_nama error-f_nama-"+ index);

    });        
}

$(document).on('click', '.simpan-product', function(event) {
    event.preventDefault();
    
    var formMe = $('#form-produk');
    $(".formerror").removeClass("has-error");
    $(".error").html('');

    bootbox.confirm({
      title:"Konfirmasi",
      message: "Apakah anda yakin untuk submit? Data yang error tidak akan diskip",
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
                  window.location.href = "{{route('catalog.category')}}";
                }
              }
            }
          });
        }
      }
    });
});

$(function(){
    var new_row = $(template_add('','','','','','','')).clone(true);
    $(".table-isi").append(new_row);
    var input_new_row = new_row.find('td');
});
</script>
@endpush
