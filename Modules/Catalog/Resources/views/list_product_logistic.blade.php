@extends('layouts.app')
@section('content')
@php
if(isset($data->id)){
    $id=$data->id;
}else{
    $id=0;
}

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
</style>
<div class="row">
    <div class="col-md-3">
        <div class="box box-danger">
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
                <h3 class="box-title f_parentname_product">Daftar Item Price</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="alertBS_2"></div>
                <table class="table table-striped" id="daftar_product">
                    <thead>
                        <tr>
                            <th>No</th>                            
                            <th>Kode Produk</th>
                            <th>Lokasi</th>
                            <th>Harga Barang</th>
                            <th>Harga Jasa</th>
                            <th>Referensi</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="form-modal-product">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-me-product" action="{{route('catalog.product_logistic.edit')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Logistic</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="f_id" name="f_id">

                    <div class="form-group formerror-f_lokasi">
                        <label>Lokasi Logistic</label>
                        <input type="text" class="form-control" id="f_lokasi" name="f_lokasi"  placeholder="Lokasi Logistic ...">
                        <div class="error-f_lokasi"></div>
                    </div>

                    <div class="form-group formerror-f_hargabarang">
                        <label>Harga Barang</label>
                        <input type="text" class="form-control input-rupiah" id="f_hargabarang" name="f_hargabarang"  placeholder="Harga Barang ...">
                        <div class="error-f_hargabarang"></div>
                    </div>

                    <div class="form-group formerror-f_hargajasa">
                        <label>Harga Jasa</label>
                        <input type="text" class="form-control input-rupiah" id="f_hargajasa" name="f_hargajasa"  placeholder="Harga Jasa ...">
                        <div class="error-f_hargajasa"></div>
                    </div>

                    <div class="form-group formerror-f_jenis">
                        <label>Jenis Referensi</label>
                        <select class="form-control select-jenis" id="f_jenis" name="f_jenis"; style="width: 100%;">
                            <option value="1">No.Kontrak</option>
                            <option value="2">Freetext</option>
                        </select>
                        <div class="error-f_jenis"></div>
                    </div>

                    <div class="form-group formerror-f_referensi">
                        <label>Referensi</label>
                        <div class="isi-referensi">
                        </div>
                        <div class="error-f_referensi"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-simpan" data-loading-text="Please wait..." autocomplete="off">Save changes</button>
                </div>
            </form>
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
                <button type="button" class="btn btn-outline btn-delete-modal" data-loading-text="Please wait..."><i class="glyphicon glyphicon-trash"></i> Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
var table_product;
var table_kategori;
var no_kategori=0;
$(function() {
    normal();

    function normal(){
        create_table(0);
    }

    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {
                $(".f_parentname_product").html("Daftar Product - " + data.instance.get_node(data.selected[0]).text);
                $("#f_parentid").val(data.instance.get_node(data.selected[0]).id);
                $(".btn-edit").attr('data-id',data.instance.get_node(data.selected[0]).id)
                $(".btn-delete").attr('data-id',data.instance.get_node(data.selected[0]).id)

                refresh_product(data.instance.get_node(data.selected[0]).id);
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
        });

    var to = false;
    $('.f_carikategori').keyup(function () {
        if(to){clearTimeout(to);}

        to = setTimeout(function () {

            var v = $('.f_carikategori').val();
            $('#jstree').jstree(true).search(v);
        }, 250);
    });

    function create_table(no_kategori){
        table_product = $('#daftar_product').on('xhr.dt', function ( e, settings, json, xhr ) {
            if(xhr.responseText=='Unauthorized.'){
                location.reload();
            }
        }).DataTable({
            processing: true,
            serverSide: true,
            autoWidth : false,
            pageLength: 50,
            ajax: {
                "url": "{!! route('catalog.list.product_logistic.datatables') !!}?parent_id="+ no_kategori,
                "type": "POST",
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
            },
            columns: [
                { data: 'DT_Row_Index',orderable:false,searchable:false},
                { data: 'kode_product'},
                { data: 'lokasi_logistic'},
                { data: 'harga_barang_logistic'},
                { data: 'harga_jasa_logistic'},
                { data: 'referensi_logistic'},
                { data: 'action', name: 'action',orderable:false,searchable:false },
            ]
        });
    }

    function refresh_product(no_kategori){
        table_product.destroy();
        create_table(no_kategori)
    }
    
    function select_kode_product_master(parent){
        $("#f_kodeproduct").empty().trigger('change');

        $.ajax({
            url: "{{route('catalog.product_logistic.get_kode_product_master_normal')}}",
            dataType: 'json',
            success: function(data)
            {
                $("#f_kodeproduct").select2({
                    data: data
                });

                $("#f_kodeproduct").val(parent).trigger('change');
            }
        });
    }

    function select_kontrak_referensi(parent){
        $(".select_kontrak").empty().trigger('change');

        $.ajax({
            url: "{{route('catalog.product_logistic.get_kontrak_normal')}}",
            dataType: 'json',
            success: function(data)
            {
                $(".select_kontrak").select2({
                    data: data,
                    placeholder: "Silahkan Pilih.."
                });

                $(".select_kontrak").val(parent).trigger('change');
            }
        });
    }


    /*
    function select_kode_product_master(input){
        var parent_id=$("#f_parentid").val();
        
        input.select2({
            placeholder : "Silahkan Pilih....",
            ajax: {
                url: '{!! route('catalog.product_logistic.get_kode_product_master') !!}?parent_id='+ parent_id,
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
    /*
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
    */

    var modalDelete = $('#modal-delete');
    modalDelete.on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var type = button.data('type');

        var modal = $(this);
        var btnDelete = modal.find('.btn-delete-modal');
        btnDelete.attr('data-id',button.data('id'));
        btnDelete.attr('data-type',button.data('type'));
        btnDelete.button('reset');
    });

    var formModal = $('#form-modal-product');
    formModal.on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)

        var title = button.data('title');
        var btnSave = modal.find('.btn-save')
        btnSave.button('reset')
        modal.find('.modal-title').text(title)

        var data = button.data('data');

        $('#f_id').val(data.id);
        $('#f_parentid').val(data.product_master_id);
        select_kode_product_master(data.product_master_id);
        $('#f_lokasi').val(data.lokasi_logistic);
        $('#f_hargabarang').val(data.harga_barang_logistic);
        $('#f_hargajasa').val(data.harga_jasa_logistic);
        $('#f_jenis').val(data.jenis_referensi);

        if(data.jenis_referensi==1){
            var new_referensi = $(template_referensi_kontrak()).clone(true);
            $(".isi-referensi").html('');
            $(".isi-referensi").append(new_referensi);
            select_kontrak_referensi(data.jenis_referensi);
        }else{
            var new_referensi = $(template_refrensi_freetext()).clone(true);
            $(".isi-referensi").html('');
            $(".isi-referensi").append(new_referensi);

            $(".f_referensi").val(data.referensi_logistic);
        }
    });

    $("#f_jenis").on('change', function(event) {        
        if($("#f_jenis").val()==1){
            var new_referensi = $(template_referensi_kontrak()).clone(true);
            $(".isi-referensi").html('');
            $(".isi-referensi").append(new_referensi);
            
            select_kontrak_referensi();
        }else{
            var new_referensi = $(template_refrensi_freetext()).clone(true);
            $(".isi-referensi").html('');
            $(".isi-referensi").append(new_referensi);
        }
    });

    function template_referensi_kontrak(){
        return '\
            <select class="form-control select_kontrak" name="f_referensi" style="width: 100%;" required>\
            </select>\
        ';
    }

    function template_refrensi_freetext(){
        return '\
            <input type="text" class="form-control f_referensi" name="f_referensi" autocomplete="off" placeholder="Referensi..">\
        ';
    }

    $(document).on('submit','#form-me-product',function (event) {
        event.preventDefault();

        var formMe = $(this)

        var attError_f_kodeproduk = formMe.find('.error-f_kodeproduk')
        var attError_f_lokasi = formMe.find('.error-f_lokasi')
        var attError_f_hargabarang = formMe.find('.error-f_hargabarang')
        var attError_f_hargajasa = formMe.find('.error-f_hargajasa')
        var attError_f_jenis = formMe.find('.error-f_jenis')
        var attError_f_referensi = formMe.find('.error-f_referensi')

        formMe.find('.formerror-f_kodeproduk').removeClass("has-error");
        formMe.find('.formerror-f_lokasi').removeClass("has-error");
        formMe.find('.formerror-f_hargabarang').removeClass("has-error");
        formMe.find('.formerror-f_hargajasa').removeClass("has-error");
        formMe.find('.formerror-f_jenis').removeClass("has-error");
        formMe.find('.formerror-f_referensi').removeClass("has-error");

        attError_f_kodeproduk.html('');
        attError_f_lokasi.html('');
        attError_f_hargabarang.html('');
        attError_f_hargajasa.html('');
        attError_f_jenis.html('');
        attError_f_referensi.html('');

        var btnSave = formMe.find('.btn-simpan')
        //btnSave.button('loading')

        $.ajax({
            url: formMe.attr('action'),
            type: 'post',
            data: formMe.serialize(),
            dataType: 'json',
            success: function(response){
                if(response.errors){
                    alertBS_2('Something Wrong','danger');

                    if(response.errors.f_kodeproduk){
                        attError_f_kodeproduk.html('<span class="help-block">'+response.errors.f_kodeproduk+'</span>');
                        formMe.find('.formerror-f_kodeproduk').addClass("has-error");
                    }
                    if(response.errors.f_lokasi){
                        attError_f_lokasi.html('<span class="help-block">'+response.errors.f_lokasi+'</span>');
                        formMe.find('.formerror-f_lokasi').addClass("has-error");
                    }
                    if(response.errors.f_hargabarang){
                        attError_f_hargabarang.html('<span class="help-block">'+response.errors.f_hargabarang+'</span>');
                        formMe.find('.formerror-f_hargabarang').addClass("has-error");
                    }
                    if(response.errors.f_hargajasa){
                        attError_f_hargajasa.html('<span class="help-block">'+response.errors.f_hargajasa+'</span>');
                        formMe.find('.formerror-f_hargajasa').addClass("has-error");
                    }
                    if(response.errors.f_jenis){
                        attError_f_jenis.html('<span class="help-block">'+response.errors.f_jenis+'</span>');
                        formMe.find('.formerror-f_jenis').addClass("has-error");
                    }
                    if(response.errors.f_referensi){
                        attError_f_referensi.html('<span class="help-block">'+response.errors.f_referensi+'</span>');
                        formMe.find('.formerror-f_referensi').addClass("has-error");
                    }

                    btnSave.button('reset');
                }
                else{
                    alertBS_2('Data successfully updated','success');
                    refresh_product(0);
                    btnSave.button('reset');
                    $('#form-modal-product').modal('hide');
                }
            }
        });
    });

    $(document).on('click', '.btn-delete-modal', function(event) {
        event.preventDefault();
        var btnDelete = $(this)
        var type=$(this).attr('data-type');
        btnDelete.button('loading');

        $.ajax({
            url: "{!! route('catalog.product_logistic.delete') !!}",
            method: 'delete',
            chache:false,
            data: {_token:'{!! csrf_token() !!}', id:$(this).attr('data-id')},
            dataType: 'json',
            success: function(response){
                if(response==1){
                    alertBS_2('Data Berhasil DiHapus','success');
                    refresh_product(0);
                    btnDelete.button('reset');
                    btnDelete.attr('data-is','');
                    modalDelete.modal('hide');
                }
            }
        });
    });
});
</script>
@endpush