@extends('layouts.app')
@section('content')
@php
$id=0;
$parent_id=0;
if(isset($data->id)){
	$id=$data->id;
    $parent_id=$data->parent_id;
}

@endphp
<div class="row">
    <div class="col-md-3">
        <div class="box box-danger">
            <div class="box-body form-horizontal">
                 <div class="form-group">
                    <div class="col-sm-12">
                        <a class="btn btn-success btn-block add-kategori">
                            <i class="glyphicon glyphicon-plus"></i>
                            Induk Kategori
                        </a>
                    </div>
                </div>
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
                <h3 class="box-title f_parentname">Tambah Induk Kategori</h3>
            </div>
            <div class="box-body form-horizontal parent-category">
                <form method="post" action="{{route('catalog.category.proses')}}" id="fileinfo">
                    <br>
                    <input type="hidden" class="f_parentid" name="f_parentid">
                    <input type="hidden" class="f_id" name="f_id">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kode Kategori</label>
                        <div class="col-sm-8">
                            <input type="text" name="f_kodekategori" placeholder="Kode Kategori.." class="form-control f_kodekategori" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Kategori</label>
                        <div class="col-sm-8">
                            <input type="text" name="f_namakategori" placeholder="Nama Kategori.." class="form-control f_namakategori" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea class="form-control f_deskripsikategori"  name="f_deskripsikategori" placeholder="Deskripsi.."></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6 col-md-offset-3">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box box-danger">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Deskripsi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-horizontal">
                <div class="form-group">
                    <div class="col-sm-12">
                        <textarea class="form-control f_deskripsi" placeholder="Deskripsi.."></textarea>
                    </div>
                </div>
            </div>
             <div class="box-footer">
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-edit">Edit</button>
                    <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#modal-delete">Delete</button>
                </div>
            </div>
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
    $('.f_id').val(0);
    $('.f_parentid').val(0);
    $(".btn-edit").prop( "disabled", true);
    $(".btn-delete").prop( "disabled", true);
    $(".btn-delete-modal").prop( "disabled", true);

    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {
                console.log(data.instance.get_node(data.selected[0]));
                $(".f_parentname").html("Tambah Kategori - " + data.instance.get_node(data.selected[0]).text);
                $(".f_deskripsi").val(data.instance.get_node(data.selected[0]).data.desc);
                $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);

                $(".btn-edit").attr('data-id',data.instance.get_node(data.selected[0]).id);
                $(".btn-delete-modal").attr('data-id',data.instance.get_node(data.selected[0]).id);

                $('.f_id').val(0);
                $('.f_kodekategori').val("");
                $('.f_namakategori').val("");
                $('.f_deskripsikategori').val("");

                $(".btn-edit").prop( "disabled", false);
                $(".btn-delete").prop( "disabled", false);
                $(".btn-delete-modal").prop( "disabled", false);
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

    var to = false;
    $('.f_carikategori').keyup(function () {
        if(to){clearTimeout(to);}

        to = setTimeout(function () {

            var v = $('.f_carikategori').val();
            $('#jstree').jstree(true).search(v);
        }, 250);
    });
    
    $(document).on('click', '.add-kategori', function(event) {
        $(".f_parentname").html("Tambah Induk Kategori");
        $(".f_parentid").val(0);
        $(".btn-edit").attr('data-id',0);
        $(".btn-delete-modal").attr('data-id',0);
        $(".f_deskripsi").val("");

        $('.f_id').val(0);
        $('.f_kodekategori').val("");
        $('.f_namakategori').val("");
        $('.f_deskripsikategori').val("");

        $(".btn-edit").prop( "disabled", true);
        $(".btn-delete").prop( "disabled", true);
        $(".btn-delete-modal").prop( "disabled", true);
    });

    $(document).on('click', '.btn-edit', function(event) {
        var id = $('.btn-edit').data('id');
        $(".btn-edit").prop( "disabled", true);

        $.ajax({
            url: "{!! route('catalog.category.get_category') !!}?id=" + id,
            dataType: 'json',
            success: function(response){
                if(response.length!=0){
                    $(".f_parentname").html("Edit Kategori - " + response[0].code + " - " + response[0].display_name);
                    $('.f_parentid').val(response[0].parent_id);
                    $('.f_id').val(response[0].id);
                    $('.f_kodekategori').val(response[0].code);
                    $('.f_namakategori').val(response[0].display_name);
                    $('.f_deskripsikategori').val(response[0].desc);
                    $(".btn-edit").prop( "disabled", false);
                }
            }
        });
    });

    $(document).on('click', '.btn-delete-modal', function(event) {
        var id = $('.btn-delete-modal').data('id');
        $(".btn-delete-modal").prop( "disabled", true);

        $.ajax({
            url: "{!! route('catalog.category.delete') !!}",
            method: 'delete',
            chache:false,
            data: {_token:'{!! csrf_token() !!}', id:$(this).attr('data-id')},
            dataType: 'json',
            success: function(response){
                location.reload();
            }
        });
    });
});
</script>
@endpush
