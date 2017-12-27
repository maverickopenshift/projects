@extends('layouts.app')
@section('content')
@php
if(isset($data->id)){
	$id=$data->id;
}else{
	$id=0;
}

@endphp
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
                <h3 class="box-title f_parentname_kategori">Daftar Kategori</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="alertBS"></div>
                <table class="table table-striped" id="daftar_kategori">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Deksripsi</th>
                        <th width="20%">Aksi</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

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
                            <th>Harga</th>
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

<div class="modal fade" role="dialog" id="form-modal-category">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-me-category" action="{{route('catalog.category.proses')}}" method="post">
                
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Kategori</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="f_id" name="f_id">
                    <input type="hidden" id="f_parentid" name="f_parentid">
                    <div class="form-group">                       
                        <label>Kode Kategori</label>
                        <input type="text" placeholder="Nama Kategori.." class="form-control" id="f_kodekategori" name="f_kodekategori" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" placeholder="Nama Kategori.." class="form-control" id="f_namakategori" name="f_namakategori" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="f_deskripsikategori" name="f_deskripsikategori" placeholder="Deskripsi.."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-save" data-loading-text="Please wait..." autocomplete="off">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="form-modal-product">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-me" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Produk</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="f_id" name="f_id">
                    <input type="hidden" id="f_parentid" name="f_parentid">

                    <div class="form-group">
                        <label>Kode Produk</label>
                        <input type="text" class="form-control" id="f_kodeproduk" name="f_kodeproduk" placeholder="Kode Produk ...">
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" id="f_namaproduk" name="f_namaproduk"  placeholder="Nama Produk ...">
                    </div>

                    <div class="form-group">
                        <label>Unit Produk</label>
                        <input type="text" class="form-control" id="f_unitproduk" name="f_unitproduk"  placeholder="Unit Produk ...">
                    </div>

                    <div class="form-group">
                        <label>Mata Uang</label>
                        <select name="f_matauang" class="form-control select2" style="width: 100%;" required>
                            <option value=""></option>
                            <option value="RP">RP</option>
                            <option value="USD">USD</option>                       
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Harga Produk</label>
                        <input type="text" class="form-control" id="f_hargaproduk" name="f_hargaproduk"  placeholder="Harga Produk ...">
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control"  placeholder="Deskripsi.." id="f_descproduk" name="f_descproduk" ></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-save" data-loading-text="Please wait..." autocomplete="off">Save changes</button>
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

    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {
                $(".f_parentname_product").html("Daftar Product - " + data.instance.get_node(data.selected[0]).text);
                $(".f_parentname_kategori").html("Daftar Kategori - " + data.instance.get_node(data.selected[0]).text);
                $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
                $(".btn-edit").attr('data-id',data.instance.get_node(data.selected[0]).id)
                $(".btn-delete").attr('data-id',data.instance.get_node(data.selected[0]).id)

                refresh_kategori(data.instance.get_node(data.selected[0]).id);
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

    table_kategori = $('#daftar_kategori').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth : false,
        order : [[ 1, 'desc' ]],
        pageLength: 50,
        ajax: {
            "url": "{!! route('catalog.category.datatables') !!}?parent_id=0",
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

    var formModal = $('#form-modal-category');
    formModal.on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)

        var title = button.data('title');        
        var btnSave = modal.find('.btn-save')
        btnSave.button('reset')
        modal.find('.modal-title').text(title)

        var data = button.data('data');
        console.log(data);
        
        modal.find('.modal-body input#f_id').val(data.id);
        modal.find('.modal-body input#f_parentid').val(data.parent_id);
        modal.find('.modal-body input#f_kodekategori').val(data.code);
        modal.find('.modal-body input#f_namakategori').val(data.display_name);
        modal.find('.modal-body textarea#f_deskripsikategori').val(data.desc);
    });

    $(document).on('submit','#form-me-category',function (event) {
        event.preventDefault();

        var formMe = $(this)
        /*
        var attErrorKode = $('#fileinfo').find('.error-f_kodekategori')
        var attErrorName = $('#fileinfo').find('.error-f_namakategori')
        var attErrorDesc = $('#fileinfo').find('.error-f_deskripsikategori')
        attErrorKode.html('')
        attErrorName.html('')
        attErrorDesc.html('')
        */
        var btnSave = formMe.find('.btn-simpan')
        btnSave.button('loading')
        
        $.ajax({
            url: formMe.attr('action'),
            type: 'post',
            data: formMe.serialize(), // Remember that you need to have your csrf token included
            dataType: 'json',
            success: function(response){
                if(response.errors){
                    
                    alertBS('Something Wrong','danger');
                    /*
                    if(response.errors.f_kodekategori){
                        attErrorKode.html('<span class="help-block">'+response.errors.f_kodekategori+'</span>');
                        $("#formerror-f_kodekategori").addClass("has-error");
                    }
                    if(response.errors.f_namakategori){
                        attErrorName.html('<span class="help-block">'+response.errors.f_namakategori+'</span>');
                        $("#formerror-f_namakategori").addClass("has-error");
                    }
                    if(response.errors.f_deskripsikategori){
                        attErrorDesc.html('<span class="help-block">'+response.errors.f_deskripsikategori+'</span>');
                        $("#formerror-f_deskripsikategori").addClass("has-error");
                    }
                    */

                    btnSave.button('reset');
                }
                else{
                    alertBS('Data successfully updated','success');
                    $('#jstree').jstree(true).refresh();

                    $('#jstree').on('refresh.jstree', function() {
                        $("#jstree").jstree("open_all");          
                    });
                    refresh_kategori(0);
                    btnSave.button('reset');
                    $('#form-modal-category').modal('hide');
                }                
            }
        });
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
        console.log(data);
        
        modal.find('.modal-body input#f_id').val(data.id);
        modal.find('.modal-body input#f_parentid').val(data.parent_id);
        modal.find('.modal-body input#f_kodeproduk').val(data.code);
        modal.find('.modal-body input#f_kodeproduk').val(data.display_name);
        modal.find('.modal-body textarea#f_deskripsikategori').val(data.desc);
    });
});
</script>
@endpush
