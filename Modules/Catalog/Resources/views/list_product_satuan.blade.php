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
    <div class="col-md-12">
        <div class="box box-danger parent_product_price">
            <input type="hidden" id="f_noproduct">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <i class="fa fa-cogs"></i>
                    <h3 class="box-title">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form-modal-satuan" data-title="Add">
                                <i class="glyphicon glyphicon-plus"></i> Add Satuan
                            </button>
                        </div>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="alertBS_2"></div>

                    <table class="table table-striped" id="daftar_product_satuan">
                        <thead>
                            <tr>
                                <th>Nama Satuan</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form-modal-satuan">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-me-product" action="" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="f_id" name="f_id">

                    <div class="form-group formerror-f_namasatuan">
                        <label>Nama Satuan</label>
                        <input type="text" class="form-control" id="f_namasatuan" name="f_namasatuan" autocomplete="off"  placeholder="Satuan ...">
                        <div class="error-f_namasatuan"></div>
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
var table_satuan;

function create_table_satuan(){
    table_satuan = $('#daftar_product_satuan').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        scrollX   : true,
        processing: true,
        serverSide: true,
        autoWidth : false,
        pageLength: 50,
        ajax: {
            "url": "{!! route('catalog.list.satuan.datatables') !!}",
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: 'nama_satuan'},
            { data: 'action', name: 'action',orderable:false,searchable:false },
        ]
    });
}

function refresh_satuan(){
    table_satuan.destroy();
    create_table_satuan();
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

var formModal = $('#form-modal-satuan');
formModal.on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)

    var title = button.data('title');
    var btnSave = modal.find('.btn-save')
    btnSave.button('reset')
    modal.find('.modal-title').text(title + " Satuan")

    var data = button.data('data');

    if(title=="Add"){
        $('#f_id').val(0);
        $('#f_namasatuan').val('');
        modal.find('form').attr('action',"{{ route('catalog.satuan.add') }}")
    }else{
        var data = button.data('data');

        $('#f_id').val(data.id);
        $('#f_namasatuan').val(data.nama_satuan);
        modal.find('form').attr('action',"{{ route('catalog.satuan.edit') }}")
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

$(document).on('submit','#form-me-product',function (event) {
    event.preventDefault();

    var formMe = $(this)

    var attError_f_namasatuan = formMe.find('.error-f_namasatuan')
    formMe.find('.formerror-f_namasatuan').removeClass("has-error");
    attError_f_namasatuan.html('');

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

                if(response.errors.f_namasatuan){
                    attError_f_namasatuan.html('<span class="help-block">'+response.errors.f_namasatuan+'</span>');
                    formMe.find('.formerror-f_namasatuan').addClass("has-error");
                }

                btnSave.button('reset');
            }
            else{
                alertBS_2('Data successfully updated','success');

                var no_product = $("#f_noproduct").val();
                var divisi = $("#divisi").val();

                refresh_satuan();

                btnSave.button('reset');
                $('#form-modal-satuan').modal('hide');
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
        url: "{!! route('catalog.satuan.delete') !!}",
        method: 'delete',
        chache:false,
        data: {_token:'{!! csrf_token() !!}', id:$(this).attr('data-id')},
        dataType: 'json',
        success: function(response){
            if(response==1){
                alertBS_2('Data Berhasil DiHapus','success');
                refresh_satuan();
                $('#modal-delete').modal('hide');
            }else{
                alertBS_2('Data Gagal di hapus, data satuan ini sudah dipakai oleh master item','danger');
                refresh_satuan();
                $('#modal-delete').modal('hide');
            }            
        }
    });
});

$(function() {
    create_table_satuan();
});
</script>
@endpush