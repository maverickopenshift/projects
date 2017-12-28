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
                <div class="box-tools pull-right">
                    <button class="btn btn-default add-kategori-test">
                        <i class="glyphicon glyphicon-plus"></i> Tambah
                    </button>
                </div>
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
                <div class="box-tools pull-right">
                    <button class="btn btn-default add-product-test">
                        <i class="glyphicon glyphicon-plus"></i> Tambah
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="alertBS_2"></div>
                <table class="table table-striped" id="daftar_product">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
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
            <form id="form-me-category" action="#" method="post">
                <input type="hidden" class="f_idkategori" name="f_idkategori">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Kategori</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">                       
                        <label>Kode Kategori</label>
                        <input type="text" placeholder="Nama Kategori.." class="form-control f_kodekategori" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" placeholder="Nama Kategori.." class="form-control f_namakategori" required>
                    </div>

                    <div class="form-group">
                        <label>Induk Kategori</label>
                        <br>
                        <select  class="form-control f_indukkategori" style="width: 100%;">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control f_deskripsikategori"  placeholder="Deskripsi.."></textarea>
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

                    <div class="form-group">
                        <label>Kode Produk</label>
                        <input type="text" class="form-control" placeholder="Kode Produk ...">
                        <div class="error-display_name"></div>
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" placeholder="Nama Produk ...">
                        <div class="error-display_name"></div>
                    </div>

                    <div class="form-group">
                        <label>Induk Kategori</label>
                        <br>
                        <select  class="form-control select2" style="width: 100%;">
                            <option></option>
                        </select>
                        <div class="error-description"></div>
                    </div>

                    <div class="form-group">
                        <label>Unit Produk</label>
                        <input type="text" class="form-control" placeholder="Unit Produk ...">
                        <div class="error-display_name"></div>
                    </div>

                    <div class="form-group">
                        <label>Induk Kategori</label>
                        <br>
                        <select  class="form-control select2" style="width: 100%;">
                            <option></option>
                        </select>
                        <div class="error-description"></div>
                    </div>

                    <div class="form-group">
                        <label>Mata Uang</label>
                        <input type="text"class="form-control" placeholder="Harga Produk ...">
                        <div class="error-display_name"></div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control"  placeholder="Deskripsi.."></textarea>
                        <div class="error-description"></div>
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
$(function() {
    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {
                $(".f_parentname").html("Tambah Kategori - " + data.instance.get_node(data.selected[0]).text);
                $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
                $(".btn-edit").attr('data-id',data.instance.get_node(data.selected[0]).id)
                $(".btn-delete").attr('data-id',data.instance.get_node(data.selected[0]).id)
            }
        })
        .jstree({
            "plugins" : [ "search" ],
            'core' : {
                'data' : {
                    "url" : "{{route('catalog.category.get_category_all',['parent_id' => 0])}}",
                }
            }
    });

    $(".select2").select2({
        placeholder:"Silahkan Pilih"
    });

    var to = false;
    $('.f_carikategori').keyup(function () {
        if(to){clearTimeout(to);}

        to = setTimeout(function () {

            var v = $('.f_carikategori').val();
            $('#jstree').jstree(true).search(v);
        }, 250);
    });

    $('#daftar_kategori').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth : false,
        pageLength: 50,
        ajax: '{!! route('catalog.category.datatables') !!}',
        columns: [
            { data : 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'code', name: 'code' },
            { data: 'display_name', name: 'display_name' },
            { data: 'desc', name: 'desc' },
            { data: 'action', name: 'action',orderable:false,searchable:false }
        ]
    });

    $('#daftar_product').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth : false,
        pageLength: 50,
        ajax: '{!! route('catalog.product.datatables') !!}',
        columns: [
            {data: 'code'},
            {data: 'name'},
        
        ]
    });

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

    var modalEditCategory = $('#form-modal-category');
    modalEditCategory.on('show.bs.modal', function (event) {
        
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var type = button.data('type');

        $.ajax({
            url: "{{route('catalog.category.get_category')}}?id=" + id,
            dataType: 'json',
            success: function(data)
            {
                console.log(data);
                
                $(".f_kodekategori").val(data.category[0].code);
                $(".f_namakategori").val(data.category[0].parent_id);
                
                $(".f_indukkategori").select2({
                    data: data.induk,
                }).val(data.category[0].parent_id).trigger('change');

                $(".f_deskripsikategori").val(data.category[0].desc);
                
            }
        });
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
                        $('#daftar_kategori').dataTable().fnStandingRedraw();
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
                        //$('#daftar_product').dataTable().fnStandingRedraw();
                        $('#daftar_product').ajax.reload();
                        btnDelete.button('reset');
                        btnDelete.attr('data-is','');
                        modalDelete.modal('hide');
                    }
                }
            });
        }
    });

    $(document).on('click', '.add-kategori-test', function(event) {
        //$('#daftar_kategori').dataTable().fnStandingRedraw();
    });

    $(document).on('click', '.add-product-test', function(event) {
        var table = $('#daftar_product').dataTable();
            table.fnStandingRedraw();
    });

    var formModal = $('#form-modal');
        formModal.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            var btnSave = modal.find('.btn-save')
            btnSave.button('reset')
            modal.find('.modal-title').text(title+' Permission')
            if(title=='Edit'){
                var data = button.data('data');
                //data = JSON.parse(data);
                modal.find('.modal-body input#id').val(data.id)
                modal.find('.modal-body input#display_name').val(data.display_name)
                modal.find('.modal-body input#description').val(data.description)
                modal.find('form').attr('action','{!! route('users.permissions.update') !!}')
            }
            else{
                modal.find('.modal-body input#display_name').val('')
                modal.find('.modal-body input#description').val('')
                modal.find('form').attr('action','{!! route('users.permissions.add') !!}')
            }
        })
});
</script>
@endpush
