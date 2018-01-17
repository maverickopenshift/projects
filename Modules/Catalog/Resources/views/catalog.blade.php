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
                <h3 class="box-title f_parentname_product">Daftar Product</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="alertBS_2"></div>
                <table class="table table-striped" id="daftar_product">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga Material</th>
                            <th>Harga Jasa</th>
                            <th>Satuan</th>
                            <th>Deksripsi</th>
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
            <form id="form-me-product" action="{{route('catalog.product.edit')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Produk</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="f_id" name="f_id">
                    <input type="hidden" id="f_parentid" name="f_parentid">

                    <div class="form-group formerror-f_kodeproduk">
                        <label>Kode Produk</label>
                        <input type="text" class="form-control" id="f_kodeproduk" name="f_kodeproduct" placeholder="Kode Produk ...">
                        <div class="error-f_kodeproduk"></div>
                    </div>
                    
                    <div class="form-group formerror-f_namaproduk">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" id="f_namaproduk" name="f_namaproduct"  placeholder="Nama Produk ...">
                        <div class="error-f_namaproduk"></div>
                    </div>

                    <div class="form-group formerror-f_produk_parentid">
                        <label>Induk Kategori</label>
                        <select class="form-control select2" id="f_produk_parent" name="f_produk_parent" style="width: 100%;" required>                      
                        </select>
                        <div class="error-f_produk_parentid"></div>
                    </div>

                    <div class="form-group formerror-f_unitproduk">
                        <label>Unit Produk</label>
                        <input type="text" class="form-control" id="f_unitproduk" name="f_unitproduct"  placeholder="Unit Produk ...">
                        <div class="error-f_unitproduk"></div>
                    </div>

                    <div class="form-group formerror-f_matauangproduk">
                        <label>Mata Uang</label>
                        <select class="form-control select2" id="f_matauangproduk" name="f_mtuproduct" style="width: 100%;" required>
                            <option value=""></option>
                            <option value="RP">RP</option>
                            <option value="USD">USD</option>                       
                        </select>
                        <div class="error-f_matauangproduk"></div>
                    </div>

                    <div class="form-group formerror-f_hargaproduk">
                        <label>Harga Material</label>
                        <input type="text" class="form-control input-rupiah" id="f_hargaproduk" name="f_hargaproduct"  placeholder="Harga Produk ...">
                        <div class="error-f_hargaproduk"></div>
                    </div>

                    <div class="form-group formerror-f_hargajasa">
                        <label>Harga Jasa</label>
                        <input type="text" class="form-control input-rupiah" id="f_hargajasa" name="f_hargajasa"  placeholder="Harga Produk ...">
                        <div class="error-f_hargajasa"></div>
                    </div>

                    <div class="form-group formerror-f_descproduk">
                        <label>Deskripsi</label>
                        <textarea class="form-control"  placeholder="Deskripsi.." id="f_descproduk" name="f_descproduct" ></textarea>
                        <div class="error-f_descproduk"></div>
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
    $(".select2").select2({
        placeholder:"Silahkan Pilih"
    });

    $(".f_produk_parentid_select").select2({
            data:{id:0,text:"asd"}
        });

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
            "url": "{!! route('catalog.product.datatables') !!}?parent_id=0",
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
        },
        columns: [
            { data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'code'},
            { data: 'name'},
            { data: 'price'},
            { data: 'price_jasa'},
            { data: 'currency'},
            { data: 'desc'},            
            { data: 'action', name: 'action',orderable:false,searchable:false },        
        ]
    });

    function refresh_product(no_kategori){
        table_product.destroy();

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
                "url": "{!! route('catalog.product.datatables') !!}?parent_id="+ no_kategori,
                "type": "POST",
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
            },
            columns: [
                { data: 'DT_Row_Index',orderable:false,searchable:false},
                { data: 'code'},
                { data: 'name'},
                { data: 'price'},
                { data: 'price_jasa'},
                { data: 'currency'},
                { data: 'desc'},            
                { data: 'action', name: 'action',orderable:false,searchable:false },        
            ]
        });
    }

    function refresh_kategori(no_kategori){
        table_kategori.destroy();

        table_kategori = $('#daftar_kategori').on('xhr.dt', function ( e, settings, json, xhr ) {
            if(xhr.responseText=='Unauthorized.'){
                location.reload();
            }
        }).DataTable({
            processing: true,
            serverSide: true,
            autoWidth : false,
            pageLength: 50,
            ajax: {
                "url": "{!! route('catalog.category.datatables') !!}?parent_id="+ no_kategori,
                "type": "POST",
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
            },
            columns: [
                { data: 'DT_Row_Index',orderable:false,searchable:false},
                { data: 'code', name: 'code' },
                { data: 'display_name', name: 'display_name' },
                { data: 'desc', name: 'desc' },
                { data: 'action', name: 'action',orderable:false,searchable:false },
            ]
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

    $(document).on('click', '.btn-delete-modal', function(event) {
        event.preventDefault();
        var btnDelete = $(this)
        var type=$(this).attr('data-type');
        btnDelete.button('loading');
        console.log(type);
        
        if(type=="category"){
            $.ajax({
                url: "{!! route('catalog.category.delete') !!}",
                method: 'delete',
                chache:false,
                data: {_token:'{!! csrf_token() !!}', id:$(this).attr('data-id')},
                dataType: 'json',
                success: function(response){
                    if(response==1){
                        alertBS('Data Berhasil DiHapus','success');
                        refresh_kategori(0);
                        btnDelete.button('reset');
                        btnDelete.attr('data-is','');
                        modalDelete.modal('hide');
                    }else{
                        alertBS('Data ini memiliki child, tidak bisa dihapus','danger')
                        btnDelete.button('reset');
                        btnDelete.attr('data-is','');
                        modalDelete.modal('hide');                    
                    }
                }
            });
        }else if(type=="product"){
            $.ajax({
                url: "{!! route('catalog.product.delete') !!}",
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
        }
    });

    function get_produk_induk(parent){
        $("#f_produk_parent").empty().trigger('change');

        $.ajax({
            url: "{{route('catalog.product.get_product_induk')}}",
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
 

    var formModal = $('#form-modal-product');
    formModal.on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)

        var title = button.data('title');        
        var btnSave = modal.find('.btn-save')
        btnSave.button('reset')
        modal.find('.modal-title').text(title)

        var data = button.data('data');

        console.log(data.price_jasa);

        get_produk_induk(data.catalog_category_id);
        
        modal.find('.modal-body input#f_id').val(data.id);
        modal.find('.modal-body input#f_parentid').val(data.catalog_category_id);
        modal.find('.modal-body input#f_kodeproduk').val(data.code);
        modal.find('.modal-body input#f_namaproduk').val(data.name);
        modal.find('.modal-body input#f_unitproduk').val(data.unit);
        modal.find('.modal-body select#f_matauangproduk').val(data.currency).trigger('change');        
        modal.find('.modal-body input#f_hargaproduk').val(data.price);
        modal.find('.modal-body input#f_hargajasa').val(data.price_jasa);
        modal.find('.modal-body textarea#f_descproduk').val(data.desc);
    });

    $(document).on('submit','#form-me-product',function (event) {
        event.preventDefault();

        var formMe = $(this)
        
        var attError_f_kodeproduk = formMe.find('.error-f_kodeproduk')
        var attError_f_namaproduk = formMe.find('.error-f_namaproduk')
        var attError_f_unitproduk = formMe.find('.error-f_unitproduk')
        var attError_f_matauangproduk = formMe.find('.error-f_matauangproduk')
        var attError_f_hargaproduk = formMe.find('.error-f_hargaproduk')
        var attError_f_hargajasa = formMe.find('.error-f_hargajasa')
        var attError_f_descproduk = formMe.find('.error-f_descproduk')

        formMe.find('.formerror-f_kodeproduk').removeClass("has-error");
        formMe.find('.formerror-f_namaproduk').removeClass("has-error");
        formMe.find('.formerror-f_unitproduk').removeClass("has-error");
        formMe.find('.formerror-f_matauangproduk').removeClass("has-error");
        formMe.find('.formerror-f_hargaproduk').removeClass("has-error");
        formMe.find('.formerror-f_hargajasa').removeClass("has-error");
        formMe.find('.formerror-f_descproduk').removeClass("has-error");

        attError_f_kodeproduk.html('')
        attError_f_namaproduk.html('')
        attError_f_unitproduk.html('')
        attError_f_matauangproduk.html('')
        attError_f_hargaproduk.html('')
        attError_f_hargajasa.html('')
        attError_f_descproduk.html('')
        
        var btnSave = formMe.find('.btn-simpan')
        btnSave.button('loading')
        
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
                        attError_f_namaproduk.html('<span class="help-block">'+response.errors.f_namaproduk+'</span>');
                        formMe.find('.formerror-f_namaproduk').addClass("has-error");
                    }
                    if(response.errors.f_unitproduk){
                        attError_f_unitproduk.html('<span class="help-block">'+response.errors.f_unitproduk+'</span>');
                        formMe.find('.formerror-f_unitproduk').addClass("has-error");
                    }
                    if(response.errors.f_matauangproduk){
                        attError_f_matauangproduk.html('<span class="help-block">'+response.errors.f_matauangproduk+'</span>');
                        formMe.find('.formerror-f_matauangproduk').addClass("has-error");
                    }
                    if(response.errors.f_hargaproduk){
                        attError_f_hargaproduk.html('<span class="help-block">'+response.errors.f_hargaproduk+'</span>');
                        formMe.find('.formerror-f_hargaproduk').addClass("has-error");
                    }
                    if(response.errors.f_hargajasa){
                        attError_f_hargajasa.html('<span class="help-block">'+response.errors.f_hargajasa+'</span>');
                        formMe.find('.formerror-f_hargajasa').addClass("has-error");
                    }
                    if(response.errors.f_descproduk){
                        attError_f_descproduk.html('<span class="help-block">'+response.errors.f_descproduk+'</span>');
                        formMe.find('.formerror-f_descproduk').addClass("has-error");
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
});
</script>
@endpush
