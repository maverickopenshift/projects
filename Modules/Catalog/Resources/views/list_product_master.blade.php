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
                <h3 class="box-title f_parentname_product">Daftar Master Item</h3>
                <div class="pull-right">
                    <div class="col-sm-12">
                        <a class="btn btn-danger" href="{{route('catalog.product.master')}}" type="button"><i class="fa fa-plus"></i> Tambah Master Item</a>                       
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div id="alertBS_2"></div>
                <table class="table table-striped" id="daftar_product">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Satuan</th>
                            <th width="25%">Aksi</th>
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
            <form id="form-me-product" action="{{route('catalog.product_master.edit')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Produk</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="f_id" name="f_id">
                    <input type="hidden" id="f_parentid" name="f_parentid">

                    <div class="form-group formerror-f_produk_parentid">
                        <label>Induk Kategori</label>
                        <select class="form-control select2" id="f_produk_parent" name="f_produk_parent" style="width: 100%;" required>
                        </select>
                        <div class="error-f_produk_parentid"></div>
                    </div>

                    <div class="form-group formerror-f_kodeproduct">
                        <label>Kode Produk</label>
                        <input type="text" class="form-control" id="f_kodeproduct" name="f_kodeproduct" placeholder="Kode Produk ...">
                        <div class="error-f_kodeproduct"></div>
                    </div>

                    <div class="form-group formerror-f_ketproduct">
                        <label>Keterangan Produk</label>
                        <input type="text" class="form-control" id="f_ketproduct" name="f_ketproduct"  placeholder="Keterangan Produk ...">
                        <div class="error-f_ketproduct"></div>
                    </div>                    

                    <div class="form-group formerror-f_unitproduct">
                        <label>Satuan Produk</label>
                        <input type="text" class="form-control" id="f_unitproduct" name="f_unitproduct"  placeholder="Unit Produk ...">
                        <div class="error-f_unitproduct"></div>
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

$('#jstree')
    .on("changed.jstree", function (e, data) {
        if(data.selected.length) {
            $(".f_parentname_product").html("Daftar Product - " + data.instance.get_node(data.selected[0]).text);
            $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
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
            "url": "{!! route('catalog.list.product_master.datatables') !!}?parent_id="+ no_kategori,
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
        },
        columns: [
            //{ data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'kode_product'},
            { data: 'keterangan_product'},
            { data: 'satuan_product'},
            { data: 'action', name: 'action',orderable:false,searchable:false},
        ]
    });
}

function refresh_product(no_kategori){
    table_product.destroy();
    create_table(no_kategori)
}    

function get_produk_induk(parent){
    $("#f_produk_parent").empty().trigger('change');

    $.ajax({
        url: "{{route('catalog.product_master.get_product_induk')}}",
        dataType: 'json',
        success: function(data)
        {
            $("#f_produk_parent").select2({
                data: data
            });

            $("#f_produk_parent").val(parent).trigger('change');
        }
    });
}

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

    get_produk_induk(data.catalog_category_id);

    modal.find('.modal-body input#f_id').val(data.id);
    modal.find('.modal-body input#f_parentid').val(data.catalog_category_id);

    modal.find('.modal-body input#f_kodeproduct').val(data.kode_product);
    modal.find('.modal-body input#f_ketproduct').val(data.keterangan_product);
    modal.find('.modal-body input#f_unitproduct').val(data.satuan_product);
});    

$(document).on('submit','#form-me-product',function (event) {
    event.preventDefault();

    var formMe = $(this)

    var attError_f_kodeproduk = formMe.find('.error-f_kodeproduk')
    var attError_f_ketproduk = formMe.find('.error-f_ketproduk')
    var attError_f_unitproduk = formMe.find('.error-f_unitproduk')

    formMe.find('.formerror-f_kodeproduk').removeClass("has-error");
    formMe.find('.formerror-f_ketproduk').removeClass("has-error");
    formMe.find('.formerror-f_unitproduk').removeClass("has-error");

    attError_f_kodeproduk.html('');
    attError_f_ketproduk.html('');
    attError_f_unitproduk.html('');

    var btnSave = formMe.find('.btn-simpan')
    //btnSave.button('loading')

    $.ajax({
        url: formMe.attr('action'),
        type: 'post',
        data: formMe.serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function(response){
            if(response.errors){
                alertBS_2('Something Wrong','danger');

                if(response.errors.f_kodeproduk){
                    attError_f_kodeproduk.html('<span class="help-block">'+response.errors.f_kodeproduk+'</span>');
                    formMe.find('.formerror-f_kodeproduk').addClass("has-error");
                }
                if(response.errors.f_namaproduk){
                    attError_f_ketproduk.html('<span class="help-block">'+response.errors.f_ketproduk+'</span>');
                    formMe.find('.formerror-f_ketproduk').addClass("has-error");
                }
                if(response.errors.f_unitproduk){
                    attError_f_unitproduk.html('<span class="help-block">'+response.errors.f_unitproduk+'</span>');
                    formMe.find('.formerror-f_unitproduk').addClass("has-error");
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
        url: "{!! route('catalog.product_master.delete') !!}",
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


$(function() {
    create_table(0);
});
</script>
@endpush