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

<div class="row">
    <div class="loading2"></div>
    <div class="col-md-12">
        <div class="box box-danger test-product">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Item Kontrak</h3>
                <div class="pull-right">
                    <div class="col-sm-12">                        
                        <a class="btn btn-primary upload-product-kontrak-btn" type="button"><i class="fa fa-upload"></i> Upload</a>
                        <a href="{{route('doc.tmp.download',['filename'=>'product_kontrak'])}}" class="btn btn-info">
                            <i class="glyphicon glyphicon-download-alt"></i> Download Template
                        </a>
                        <span class="error error-product-price text-danger"></span>
                    </div>
                </div>
            </div>


            <form method="post" action="{{ route('catalog.product_kontrak.add_ajax') }}" id="form-produk">
                {{ csrf_field() }}
                <div class="box-body form-horizontal">
                    <div id="alertBS"></div>
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

                    <table class="table table-striped table-parent-kontrak" width="100%">
                        <thead>
                            <tr>
                                <th>Kode Master Item</th>
                                <th>Group Coverage</th>
                                <th>Coverage</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                                <th>Doc No</th>
                                <th>KHS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-kontrak">
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

            <form id="form_me_upload_kontrak" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="upload-product-kontrak" class="upload-product-kontrak hide" accept=".csv,.xls,.xlsx"/>
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

$('.upload-product-kontrak-btn').on('click', function(event) {
    event.stopPropagation();
    event.preventDefault();
    var $file = $('.upload-product-kontrak').click();
});

$('.upload-product-kontrak').on('change', function(event) {
    $(".table-kontrak").empty();
    event.stopPropagation();
    event.preventDefault();
    $(".loading2").show();
    $.ajax({
        url: "{{ route('catalog.product_kontrak.upload') }}",
        type: 'post',
        processData: false,
        contentType: false,
        data: new FormData(document.getElementById("form_me_upload_kontrak")),
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
        var new_row = $(template_add(dt.id_master_item, dt.kode_master_item, dt.kode_master_item_error, dt.id_group_coverage, dt.group_coverage, dt.group_coverage_error, dt.id_coverage, dt.coverage, dt.coverage_error, dt.harga_barang, dt.harga_jasa, dt.no_kontrak, dt.id_kontrak, dt.error_kontrak, dt.flag)).clone(true);
        $(".table-kontrak").append(new_row);
    });
}

$('.table-parent-kontrak').on('click', '.btn-delete', function(e){
    var rowCount = $('.table-parent-kontrak tr:last').index() + 1;
    if(rowCount!=1){
        $(this).closest('tr').remove();
    }else{
        alertBS('Jika jumlah baris hanya ada 1 tidak bisa di hapus, silahkan tambah sebelum menghapus','danger');
    }
});

function template_add(id_master_item, kode_master_item, kode_master_item_error, id_group_coverage, group_coverage, group_coverage_error, id_coverage, coverage, coverage_error, harga_barang, harga_jasa, no_kontrak, id_kontrak, error_kontrak, flag){
    var template ='\
    <tr class="tabel-product">';

        if(kode_master_item_error!=""){
            template  = template + '\
                <td class="formerror formerror-f_kodemaster-0 has-error">\
                    <input type="hidden" name="f_id_master_item[]" value="'+ id_master_item +'">\
                    <input type="text" placeholder="Kode Master .." value="'+ kode_master_item +'" class="form-control" readonly>\
                        <div class="error error-f_kodemaster error-f_kodemaster-0 has-error"><span class="help-block">"'+ kode_master_item_error +'"</span></div>\
                </td>';
        }else{
            template = template + '\
                <td class="formerror formerror-f_kodemaster-0">\
                    <input type="hidden" name="f_id_master_item[]" value="'+ id_master_item +'">\
                    <input type="text" placeholder="Kode Master .." value="'+ kode_master_item +'" class="form-control" readonly>\
                        <div class="error error-f_kodemaster error-f_kodemaster-0"></div>\
                </td>';
        }

        if(group_coverage_error!=""){
            template  = template + '\
                <td class="formerror formerror-f_nogroupcoverage-0 has-error">\
                    <input type="hidden" name="f_nogroupcoverage[]" value="'+ id_group_coverage +'">\
                    <input type="text" placeholder="Group Coverage.." value="'+ group_coverage +'" class="form-control" readonly>\
                        <div class="error error-f_nogroupcoverage error-f_nogroupcoverage-0 has-error"><span class="help-block">"'+ group_coverage_error +'"</span></div>\
                </td>';
        }else{
            template = template + '\
                <td class="formerror formerror-f_nogroupcoverage-0">\
                    <input type="hidden" name="f_nogroupcoverage[]" value="'+ id_group_coverage +'">\
                    <input type="text" placeholder="Group Coverage.." value="'+ group_coverage +'" class="form-control" readonly>\
                        <div class="error error-f_nogroupcoverage error-f_nogroupcoverage-0"></div>\
                </td>';
        }

        if(coverage_error!=""){
            template  = template + '\
                <td class="formerror formerror-f_nocoverage-0 has-error">\
                    <input type="hidden" name="f_nocoverage[]" value="'+ id_coverage +'">\
                    <input type="text" placeholder="Kode Master .." value="'+ coverage +'" class="form-control" readonly>\
                        <div class="error error-f_nocoverage error-f_nocoverage-0 has-error"><span class="help-block">"'+ coverage_error +'"</span></div>\
                </td>';
        }else{
            template = template + '\
                <td class="formerror formerror-f_nocoverage-0">\
                    <input type="hidden" name="f_nocoverage[]" value="'+ id_coverage +'">\
                    <input type="text" placeholder="Kode Master .." value="'+ coverage +'" class="form-control" readonly>\
                        <div class="error error-f_nocoverage error-f_nocoverage-0"></div>\
                </td>';
        }

        template  = template + '\
        <td class="formerror formerror-f_hargabarang-0">\
            <input type="text" name="f_hargabarang[]" placeholder="Harga Barang.." value="'+ harga_barang +'" class="form-control input-rupiah" readonly>\
            <div class="error error-f_hargabarang error-f_hargabarang-0"></div>\
        </td>\
        <td class="formerror formerror-f_hargajasa-0">\
            <input type="text" name="f_hargajasa[]" placeholder="Harga Jasa.." value="'+ harga_jasa +'"  class="form-control input-rupiah" readonly>\
            <div class="error error-f_hargajasa error-f_hargajasa-0"></div>\
        </td>';

        if(error_kontrak!=""){
            template  = template + '\
            <td class="formerror formerror-f_refernsi-0 has-error">\
                <input type="hidden" name="f_referensi[]" class="doc_no_input" value="'+ id_kontrak +'">\
                <input class="form-control doc_text_input" type="text" placeholder="No.Kontrak" value="'+ no_kontrak +'" readonly>\
                <div class="error error-f_refernsi error-f_refernsi-0 has-error"><span class="help-block">"'+ error_kontrak +'"</span></div>\
            </td>';
        }else{
            template  = template + '\
            <td class="formerror formerror-f_refernsi-0">\
                <input type="hidden" name="f_referensi[]" class="doc_no_input" value="'+ id_kontrak +'">\
                <input class="form-control doc_text_input" type="text" placeholder="No.Kontrak" value="'+ no_kontrak +'" readonly>\
                <div class="error error-f_refernsi error-f_refernsi-0"></div>\
            </td>';  
        }
        
        if(flag!=""){
            template  = template + '\
            <td>\
                <i class="fa fa-check" style="color:green;"></i>\
            </td>';
        }else{
            template  = template + '\
            <td>\
            </td>';
        }       

        template  = template + '\
        <td width="100px">\
            <div class="btn-group">\
                <a class="btn bg-red btn-delete" style="margin-bottom: 2px;">\
                    <i class="glyphicon glyphicon-trash"></i>\
                </a>\
            </div>\
        </td>\
    </tr>';

    return template;
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
                  //window.location.href = "{{route('catalog.list.product_kontrak')}}";
                }
              }
            }
          });
        }
      }
    });
});

$(function(){
    var new_row = $(template_add('','','','','','','','','','','','','','','','')).clone(true);
    $(".table-kontrak").append(new_row);
    var input_new_row = new_row.find('td');
});
</script>
@endpush
