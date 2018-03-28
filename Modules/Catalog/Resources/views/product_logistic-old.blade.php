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
    <div class="col-md-12">
        <div class="box box-danger test-product">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Item Logistik</h3>
                <div class="pull-right">
                    <input type="file" name="upload-boq" class="upload-boq hide"/>
                    <a class="btn btn-primary upload-boq-btn" type="button"><i class="fa fa-upload"></i> Upload</a>
                    <a href="{{route('doc.tmp.download',['filename'=>'harga_satuan'])}}" class="btn btn-info"><i class="glyphicon glyphicon-download-alt"></i> Download Template</a>
                </div>
            </div>
            <form method="post" action="{{ route('catalog.product_logistic.add_ajax') }}" id="form-produk">
                {{ csrf_field() }}
                <div class="box-body form-horizontal">

                    <div class="flash-message" id="alertBS">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                    </div>

                    <div class="parent_logistic">
                    </div>

                     <div class="form-group text-center">
                        <textarea class="form-control komentar hide" rows="4" name="komentar">{{old('komentar')}}</textarea>
                        <a href="{{route('doc',['status'=>'selesai'])}}" class="btn btn-danger" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">CANCEL</a>
                        <button class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;" id="btn-submit">SUBMIT</button>
                    </div>

                </div>
            </form>
        </div>


    </div>

</div>

@endsection
@push('scripts')
<script>

function select_referensi(input, isi){        
    $(input).on('change', function(event) {        
        console.log("test");
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

function radio_jenis(input){
    /*
    input.iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    */
}    

function select_kode_product_master(input){
    input.select2({
        placeholder : "Silahkan Pilih....",
        ajax: {
            url: '{!! route('catalog.product_logistic.get_kode_product_master') !!}',
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

function template_add(){
    return '\
    <div class="form-horizontal child-logistic" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">\
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">\
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Lain-lain</div>\
                <div class="btn-group" style="position: absolute;right: 5px;top: -10px;border-radius: 0;">\
                <button type="button" class="btn btn-success add-product-logistic" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>\
                <button type="button" class="btn btn-danger delete-product-logistic" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>\
            </div>\
        </div>\
        \
        <div class="form-group formerror formerror-f_kodeproduct-0">\
            <label class="col-sm-2 control-label"><span class="text-red">*</span> Kode Designator</label>\
            <div class="col-sm-4">\
                <select class="form-control select_kode_product" name="f_kodeproduct[]" style="width: 100%;" required>\
                </select>\
            </div>\
            <div class="col-sm-10 col-sm-offset-2">\
                <div class="error error-f_kodeproduct error-f_kodeproduct-0"></div>\
            </div>\
        </div>\
        \
        <div class="form-group formerror formerror-f_lokasilogistic-0">\
            <label class="col-sm-2 control-label"><span class="text-red">*</span> Lokasi</label>\
            <div class="col-sm-4">\
                <input type="text" class="form-control" name="f_lokasilogistic[]" autocomplete="off" placeholder="Lokasi">\
            </div>\
            <div class="col-sm-10 col-sm-offset-2">\
                <div class="error error-f_lokasilogistic error-f_lokasilogistic-0"></div>\
            </div>\
        </div>\
        \
        <div class="form-group formerror formerror-f_hargabaranglogistic-0">\
            <label class="col-sm-2 control-label"><span class="text-red">*</span> Harga Material</label>\
            <div class="col-sm-4">\
                <input type="text" class="form-control input-rupiah" name="f_hargabaranglogistic[]" autocomplete="off" placeholder="Harga Material">\
            </div>\
            <div class="col-sm-10 col-sm-offset-2">\
                <div class="error error-f_hargabaranglogistic error-f_hargabaranglogistic-0"></div>\
            </div>\
        </div>\
        \
        <div class="form-group formerror formerror-f_hargajasalogistic-0">\
            <label class="col-sm-2 control-label"><span class="text-red">*</span> Harga jasa</label>\
            <div class="col-sm-4">\
                <input type="text" class="form-control input-rupiah" name="f_hargajasalogistic[]" autocomplete="off" placeholder="Harga Jasa">\
            </div>\
            <div class="col-sm-10 col-sm-offset-2">\
                <div class="error error-f_hargajasalogistic error-f_hargajasalogistic-0"></div>\
            </div>\
        </div>\
        \
        <div class="form-group formerror formerror-f_jenisreferensi-0">\
            <label class="col-sm-2 control-label"><span class="text-red">*</span> Jenis Referensi</label>\
            <div class="col-sm-4">\
                <select class="form-control f_jenisreferensi" name="f_jenisreferensi[]" style="width: 100%;" required>\
                    <option value="1">No.Kontrak</option>\
                    <option value="2">Freetext</option>\
                </select>\
            </div>\
            <div class="col-sm-10 col-sm-offset-2">\
                <div class="error error-f_jenisreferensi error-f_jenisreferensi-0"></div>\
            </div>\
        </div>\
        \
        <div class="form-group formerror formerror-f_referensi-0">\
            <label class="col-sm-2 control-label"><span class="text-red">*</span> Referensi</label>\
            <div class="col-sm-4 isi-referensi">\
            </div>\
            <div class="col-sm-10 col-sm-offset-2">\
                <div class="error error-f_referensi error-f_referensi-0"></div>\
            </div>\
        </div>\
    </div>';
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
    var $this = $('.child-logistic');
    $.each($this,function(index, el) {
        console.log(index);
        var mdf_new_row = $(this).find('.form-group');

        if(mdf_new_row.eq(1).hasClass("has-error")){
            mdf_new_row.eq(1).removeClass().addClass("form-group has-error formerror formerror-f_kodeproduct-"+ index);
        }else{
            mdf_new_row.eq(1).removeClass().addClass("form-group formerror formerror-f_kodeproduct-"+ index);
        }

        if(mdf_new_row.eq(2).hasClass("has-error")){
            mdf_new_row.eq(2).removeClass().addClass("form-group has-error formerror formerror-f_lokasilogistic-"+ index);
        }else{
            mdf_new_row.eq(2).removeClass().addClass("form-group formerror formerror-f_lokasilogistic-"+ index);
        }

        if(mdf_new_row.eq(3).hasClass("has-error")){
            mdf_new_row.eq(3).removeClass().addClass("form-group has-error formerror formerror-f_hargabaranglogistic-"+ index);
        }else{
            mdf_new_row.eq(3).removeClass().addClass("form-group formerror formerror-f_hargabaranglogistic-"+ index);
        }

        if(mdf_new_row.eq(4).hasClass("has-error")){
            mdf_new_row.eq(4).removeClass().addClass("form-group has-error formerror formerror-f_hargajasalogistic-"+ index);
        }else{
            mdf_new_row.eq(4).removeClass().addClass("form-group formerror formerror-f_hargajasalogistic-"+ index);
        }

        if(mdf_new_row.eq(5).hasClass("has-error")){
            mdf_new_row.eq(5).removeClass().addClass("form-group has-error formerror formerror-f_jenisreferensi-"+ index);
        }else{
            mdf_new_row.eq(5).removeClass().addClass("form-group formerror formerror-f_jenisreferensi-"+ index);
        }

        if(mdf_new_row.eq(6).hasClass("has-error")){
            mdf_new_row.eq(6).removeClass().addClass("form-group has-error formerror formerror-f_referensi-"+ index);
        }else{
            mdf_new_row.eq(6).removeClass().addClass("form-group formerror formerror-f_referensi-"+ index);
        }

        $(this).find('.error-f_kodeproduct').removeClass().addClass("error error-f_kodeproduct error-f_kodeproduct-"+ index);
        $(this).find('.error-f_lokasilogistic').removeClass().addClass("error error-f_lokasilogistic error-f_lokasilogistic-"+ index);
        $(this).find('.error-f_hargabaranglogistic').removeClass().addClass("error error-f_hargabaranglogistic error-f_hargabaranglogistic-"+ index);
        $(this).find('.error-f_hargajasalogistic').removeClass().addClass("error error-f_hargajasalogistic error-f_hargajasalogistic-"+ index);
        $(this).find('.error-f_jenisreferensi').removeClass().addClass("error error-f_jenisreferensi error-f_jenisreferensi-"+ index);
        $(this).find('.error-f_referensi').removeClass().addClass("error error-f_referensi error-f_referensi-"+ index);

        $(this).find('.check-me').attr('name', 'jenis-referensi-' + index);
    });        
}

$(document).on('click', '.add-product-logistic', function(event) {        
    var new_row = $(template_add()).clone(true);
    $(".parent_logistic").append(new_row);
    var input_new_row = new_row.find('.form-group');

    select_kode_product_master(input_new_row.eq(1).find('.select_kode_product'));

    fix_no_error();

    var new_referensi = $(template_referensi_kontrak()).clone(true);
    input_new_row.eq(6).find('.isi-referensi').append(new_referensi);
    select_referensi(input_new_row.eq(5).find('select'), input_new_row.eq(6).find('.isi-referensi'));
    select_kontrak_referensi(input_new_row.eq(6).find('.isi-referensi').find('.select_kontrak'))
});

$(document).on('click', '#btn-submit', function(event) {
    event.preventDefault();
    
    var formMe = $('#form-produk');
    $(".formerror").removeClass("has-error");
    $(".error").html('');

    bootbox.confirm({
        title:"Konfirmasi",
        message: "Apakah anda yakin untuk menyimpan data ini?",
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
                                window.location.href = "{{route('catalog.product.master')}}";
                            }
                        }
                    }
                });
            }
        }
    });
});

$(function(){
    var new_row = $(template_add()).clone(true);
    $(".parent_logistic").append(new_row);
    var input_new_row = new_row.find('.form-group');
    
    select_kode_product_master(input_new_row.eq(1).find('.select_kode_product'));

    //var new_referensi = $(template_referensi_kontrak()).clone(true);
    //input_new_row.eq(6).find('.isi-referensi').append(new_referensi);
    //console.log(input_new_row.eq(5).find('.f_jenisreferensi'));
    var test1 = input_new_row.eq(5).find('.f_jenisreferensi');
    var test2 = input_new_row.eq(6).find('.isi-referensi');
    console.log(test1.val());
    //console.log(test1.val());
    select_referensi(test1, test2);
    //select_referensi(input_new_row.eq(5).find('.f_jenisreferensi'), input_new_row.eq(6).find('.isi-referensi'));
    //select_referensi();
    //select_kontrak_referensi(input_new_row.eq(6).find('.isi-referensi').find('.select_kontrak'));
});
</script>
@endpush
