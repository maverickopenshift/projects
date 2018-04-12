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
            
                {{ csrf_field() }}
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
                        <div class="col-sm-10 text-me">{{$product->satuan_product}}</div>
                    </div>

                
                    {{--
                    <div class="form-group">
                        <label for="pemilik_kontrak" class="col-sm-2 control-label"><span class="text-red">*</span>Pemilik Kontrak</label>
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <div class="form-group formerror formerror-divisi">
                                    <div class="input-group" style="width:100%">
                                        <span class="input-group-addon" style="font-weight:bold;width:90px;text-align:left;">Divisi :</span>
                                        {!!Helper::select_all_divisi('divisi')!!}
                                    </div>
                                    <div class="error error-divisi" style="margin-bottom:10px"></div>
                                </div>

                                <div class="form-group formerror formerror-unit_bisnis">
                                    <div class="input-group" style="width:100%">
                                        <span class="input-group-addon text-right" style="font-weight:bold;width:90px;text-align:left;">Unit Bisnis :</span>
                                        <select class="form-control" name="unit_bisnis" id="unit_bisnis">
                                            <option value="">Pilih Unit Bisnis</option>
                                        </select>
                                    </div>
                                    <div class="error error-unit_bisnis" style="margin-bottom:10px"></div>
                                </div>

                                <div class="form-group formerror formerror-unit_kerja">
                                    <div class="input-group" style="width:100%">
                                        <span class="input-group-addon text-right" style="font-weight:bold;width:90px;text-align:left;">Unit Kerja :</span>
                                        <select class="form-control" name="unit_kerja" id="unit_kerja">
                                            <option value="">Pilih Unit Kerja</option>
                                        </select>
                                    </div>
                                    <div class="error error-unit_kerja" style="margin-bottom:10px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}
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
                <form method="post" action="{{ route('catalog.product_logistic.add_ajax') }}" id="form-produk">
                    {{ csrf_field() }}
                    <input type="hidden" name="f_idproduct" value="{{$product->id}}">

                    <table class="table table-striped table-parent-product" width="100%">
                        <thead>
                            <tr>
                                <th>Lokasi</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                                <th>Jenis Referensi</th>
                                <th>Referensi</th>
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

            <form id="form_me_upload_price" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="upload-product-price" class="upload-product-price hide" accept=".csv,.xls,.xlsx"/>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
$('#daftar1').DataTable();

$('.upload-product-price-btn').on('click', function(event) {
    event.stopPropagation();
    event.preventDefault();
    var $file = $('.upload-product-price').click();
});

$('.upload-product-price').on('change', function(event) {
    event.stopPropagation();
    event.preventDefault();

    $.ajax({
        url: "{{ route('catalog.product_logistic.upload') }}",
        type: 'post',
        processData: false,
        contentType: false,
        data: new FormData(document.getElementById("form_me_upload_price")),
        dataType: 'json',
    })
    .done(function(data) {
        if(data.status){
            handleFile(data);
        }else{
            $('.error-product-price').html('Format File tidak valid!');
            return false;
        }
    });

    $(this).val('');
});

function handleFile(data) {
    $.each(data.data,function(index, el) {
        var dt = data.data[index];
        console.log(dt);
        var new_row = $(template_add(dt.lokasi, dt.harga_barang, dt.harga_jasa)).clone(true).insertAfter(".tabel-product:last");
        var input_new_row = new_row.find('td');

        select_referensi(input_new_row.eq(3).find('.select-jenis'), input_new_row.eq(4));

        var new_referensi = $(template_referensi_kontrak()).clone(true);
        input_new_row.eq(4).html('');
        input_new_row.eq(4).append(new_referensi);
        select_kontrak_referensi(input_new_row.eq(4).find('.select_kontrak'));
        
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
    input.select2({
        placeholder : "Silahkan Pilih....",
        ajax: {
            url: '{!! route('catalog.product_logistic.get_kontrak') !!}',
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

function select_referensi(input, isi){
    $(input).on('change', function(event) {        
        if(input.val()==1){
            var new_referensi = $(template_referensi_kontrak()).clone(true);
            isi.html('');
            isi.append(new_referensi);
            select_kontrak_referensi(isi.find('.select_kontrak'));
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
            <input type="text" name="f_lokasi[]" placeholder="Lokasi .." value="'+ lokasi +'" class="form-control">\
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
        <select class="form-control select_kontrak" name="f_referensi[]" style="width: 100%;" required>\
        </select>\
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
/*
$(document).on('change', '#divisi', function(event) {
    event.preventDefault();
    var divisi = this.value;

    $('#unit_bisnis').find('option').not('option[value=""]').remove();
    var t_awal = $('#unit_bisnis').find('option[value=""]').text();
    $('#unit_bisnis').find('option[value=""]').text('Please wait.....');
    $('#unit_kerja').find('option').not('option[value=""]').remove();

    $.ajax({
        url: '{!!route('doc.get-unit-bisnis')!!}',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {divisi: encodeURIComponent(divisi)}
    })
    .done(function(data) {
        console.log("test");
        if(data.length>0){
            $.each(data,function(index, el) {
                $('#unit_bisnis').append('<option value="'+this.id+'">'+this.title+'</option>');
            });
            $('#unit_bisnis').find('option[value=""]').text('Pilih Unit Bisnis');
        }else{
            $('#unit_bisnis').find('option[value=""]').text('Tidak ada data');
        }
    });
});

$(document).on('change', '#unit_bisnis', function(event) {
    event.preventDefault();
    var unit_bisnis = this.value;
    $('#unit_kerja').find('option').not('option[value=""]').remove();
    var t_awal = $('#unit_kerja').find('option[value=""]').text();
    $('#unit_kerja').find('option[value=""]').text('Please wait.....');
        $.ajax({
            url: '{!!route('doc.get-unit-kerja')!!}',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {unit_bisnis: encodeURIComponent(unit_bisnis)}
        })
        .done(function(data) {
            if(data.length>0){
                $.each(data,function(index, el) {
                    $('#unit_kerja').append('<option value="'+this.id+'">'+this.title+'</option>');
                });
                $('#unit_kerja').find('option[value=""]').text('Pilih Unit Kerja');
            }else{
                $('#unit_kerja').find('option[value=""]').text('Tidak ada data');
            }
        });
});
*/
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

$(function() {

    var new_row = $(template_add('','','')).clone(true);
    $(".table-test").append(new_row);
    var input_new_row = new_row.find('td');
    
    select_referensi(input_new_row.eq(3).find('.select-jenis'), input_new_row.eq(4));
    
    var new_referensi = $(template_referensi_kontrak()).clone(true);
    input_new_row.eq(4).html('');
    input_new_row.eq(4).append(new_referensi);
    select_kontrak_referensi(input_new_row.eq(4).find('.select_kontrak'));
    
    $("#alertBS").fadeTo(2000, 500).slideUp(500, function(){
        $("#alertBS").slideUp(500);
    });
});
</script>
@endpush
