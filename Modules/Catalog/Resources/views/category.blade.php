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
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-body form-horizontal">
                 <div class="form-group">
                    <div class="col-md-6">
                        <a class="btn btn-success btn-block add-kategori">
                            <i class="glyphicon glyphicon-plus"></i>
                            Induk Kategori
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-warning btn-block add-subkategori">Sub Kategori</button>
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
    <div class="col-md-8">
        <div class="box box-danger">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Induk Kategori</h3>
            </div>
            <div class="box-body form-horizontal parent-category">
                <div id="alertBS"></div>
                <form method="post" action="{{route('catalog.category.proses')}}" id="fileinfo">
                    <br>
                    <input type="hidden" class="f_parentid" name="f_parentid">
                    <input type="hidden" class="f_id" name="f_id">
                    {{ csrf_field() }}
                    
                    <div id="formerror-f_kodekategori" class="form-group">
                        <label class="col-sm-3 control-label">Kode Kategori</label>
                        <div class="col-sm-8">
                            <input type="text" name="f_kodekategori" placeholder="Kode Kategori.." class="form-control f_kodekategori">
                            <div class="error-f_kodekategori"></div>
                        </div>                        
                    </div>

                    <div id="formerror-f_namakategori" class="form-group">
                        <label class="col-sm-3 control-label">Nama Kategori</label>
                        <div class="col-sm-8">
                            <input type="text" name="f_namakategori" placeholder="Nama Kategori.." class="form-control f_namakategori">
                            <div class="error-f_namakategori"></div>
                        </div>                       
                    </div>

                    <div id="formerror-f_namakategori" class="form-group">
                        <label class="col-sm-3 control-label">Induk Kategori</label>
                        <div class="col-sm-8">
                            <select name="f_parentid_select" class="form-control f_parentid_select">                   
                            </select>
                            <div class="error-f_namakategori"></div>
                        </div>                       
                    </div>

                    <div id="formerror-f_deskripsikategori" class="form-group">
                        <label class="col-sm-3 control-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea class="form-control f_deskripsikategori"  name="f_deskripsikategori" placeholder="Deskripsi.."></textarea>
                            <div class="error-f_deskripsikategori"></div>
                        </div>                        
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6 col-md-offset-3">
                            <button class="btn btn-primary btn-edit">Ubah Simpan</button>
                            <a class="btn btn-danger btn-delete" data-toggle="modal" data-target="#modal-delete">Delete</a>
                            <input type="submit" class="btn btn-primary btn-simpan" value="Simpan">
                        </div>
                    </div>
                </form>
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
    normal();     

    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {               
                $(".f_kodekategori").prop( "disabled", false);
                $(".f_namakategori").prop( "disabled", false);
                $(".f_parentid_select").prop( "disabled", false);
                $(".f_deskripsikategori").prop( "disabled", false);
                $(".add-subkategori").prop( "disabled", false);
                $(".btn-edit").prop( "disabled", false);
                $(".btn-delete").prop( "disabled", false);
                $(".btn-simpan").prop( "disabled", true);

                $(".btn-edit").show();
                $(".btn-delete").show();
                $(".btn-simpan").hide();

                $(".btn-delete-modal").attr('data-id',data.instance.get_node(data.selected[0]).id);
                $(".f_id").val(data.instance.get_node(data.selected[0]).id);
                $(".f_parentid").val(data.instance.get_node(data.selected[0]).data.parent_id);
                $(".f_parentname").html("Ubah Kategori - " + data.instance.get_node(data.selected[0]).text);
                $(".f_kodekategori").val(data.instance.get_node(data.selected[0]).data.code);
                $(".f_namakategori").val(data.instance.get_node(data.selected[0]).data.name);
                $(".f_deskripsikategori").val(data.instance.get_node(data.selected[0]).data.desc);

                get_kategori(data.instance.get_node(data.selected[0]).id, data.instance.get_node(data.selected[0]).data.parent_id);

                var attErrorKode = $('#fileinfo').find('.error-f_kodekategori')
                var attErrorName = $('#fileinfo').find('.error-f_namakategori')
                var attErrorDesc = $('#fileinfo').find('.error-f_deskripsikategori')
                attErrorKode.html('')
                attErrorName.html('')
                attErrorDesc.html('')

                $("#formerror-f_kodekategori").removeClass("has-error");
                $("#formerror-f_namakategori").removeClass("has-error");
                $("#formerror-f_deskripsikategori").removeClass("has-error");
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

    function normal(){
        $(".btn-edit").hide();    
        $(".btn-delete").hide();    
        $(".btn-simpan").hide();

        $('.f_id').val(0);
        $('.f_parentid').val(0);
        $(".f_kodekategori").val("");
        $(".f_namakategori").val("");
        $(".f_deskripsikategori").val("");

        $(".f_kodekategori").prop( "disabled", true);
        $(".f_namakategori").prop( "disabled", true);
        $(".f_deskripsikategori").prop( "disabled", true);
        $(".f_parentid_select").prop( "disabled", true);

        $(".btn-edit").prop( "disabled", true);
        $(".btn-simpan").prop( "disabled", true);
        $(".btn-delete").prop( "disabled", true);

        $(".add-subkategori").prop( "disabled", true);

        $(".f_parentid_select").empty().trigger('change');

        $(".f_parentid_select").select2({
            placeholder:"Silahkan Pilih",
        }); 

        var attErrorKode = $('#fileinfo').find('.error-f_kodekategori')
        var attErrorName = $('#fileinfo').find('.error-f_namakategori')
        var attErrorDesc = $('#fileinfo').find('.error-f_deskripsikategori')
        attErrorKode.html('')
        attErrorName.html('')
        attErrorDesc.html('')
        $("#formerror-f_kodekategori").removeClass("has-error");
        $("#formerror-f_namakategori").removeClass("has-error");
        $("#formerror-f_deskripsikategori").removeClass("has-error");
    }

    function get_kategori(id, parent){
        console.log(id + " - " + parent);

        $(".f_parentid_select").empty().trigger('change');

        $.ajax({
            url: "{{route('catalog.category.get_category_induk')}}?id=" + id + "&parent_id=0",
            dataType: 'json',
            success: function(data)
            {                
                $(".f_parentid_select").select2({
                    data: data
                });

                $(".f_parentid_select").val(parent).trigger('change');
            }
        });        
    }
    
    $(document).on('click', '.add-kategori', function(event) { 

        $(".f_parentname").html("Tambah Induk Kategori");

        $(".btn-edit").attr('data-id',0);
        $(".btn-delete-modal").attr('data-id',0);
        
        $('.f_id').val(0);
        $('.f_parentid').val(0);
        $('.f_kodekategori').val("");
        $('.f_namakategori').val("");
        $('.f_deskripsikategori').val("");

        $(".f_kodekategori").prop( "disabled", false);
        $(".f_namakategori").prop( "disabled", false);
        $(".f_parentid_select").prop( "disabled", false);
        $(".f_deskripsikategori").prop( "disabled", false);
        $(".btn-simpan").prop( "disabled", false);

        $(".btn-edit").prop( "disabled", true);
        $(".btn-delete").prop( "disabled", true);

        $(".f_parentid_select").empty().trigger('change');

        $(".f_parentid_select").select2({
            data:[
                {id:0,text:"Tidak Memiliki Induk"}
            ],
        });

        $(".f_parentid_select").select2({
            placeholder:"Silahkan Pilih",
        });

        $(".btn-simpan").show();
        $(".btn-edit").hide();    
        $(".btn-delete").hide();  
    });

    $(document).on('click', '.add-subkategori', function(event) {
        console.log($("#jstree").jstree().get_selected(true)[0].text);
        
        $(".f_kodekategori").prop( "disabled", false);
        $(".f_namakategori").prop( "disabled", false);
        $(".f_parentid_select").prop( "disabled", false);
        $(".f_deskripsikategori").prop( "disabled", false);
        $(".btn-edit").prop( "disabled", true);
        $(".btn-delete").prop( "disabled", true);
        $(".btn-simpan").prop( "disabled", false);

        $(".btn-edit").hide();    
        $(".btn-delete").hide();
        $(".btn-simpan").show();

        $(".f_parentname").html("Tambah Sub Kategori - " + $("#jstree").jstree().get_selected(true)[0].text);
        $(".f_id").val(0);
        $(".f_parentid").val($("#jstree").jstree().get_selected(true)[0].id);
        $(".f_kodekategori").val("");
        $(".f_namakategori").val("");
        $(".f_deskripsikategori").val("");

        $(".f_parentid_select").empty().trigger('change');

        $(".f_parentid_select").select2({
            data:[
                {id:$("#jstree").jstree().get_selected(true)[0].id, text:$("#jstree").jstree().get_selected(true)[0].text}
            ],
        });

        $(".f_parentid_select").select2({
            placeholder:"Silahkan Pilih",
        });
    });

    $(document).on('click', '.btn-delete-modal', function(event) {
        var id = $('.btn-delete-modal').data('id');
        $('.btn-delete-modal').button('loading');
        $.ajax({
            url: "{!! route('catalog.category.delete') !!}",
            method: 'delete',
            chache:false,
            data: {_token:'{!! csrf_token() !!}', id:$(this).attr('data-id')},
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response==0){
                    alertBS('Terjadi Kesalahan, Data ini memiliki child','danger');
                }else{
                    alertBS('Data berhasil di hapus','success');    
                }               

                $('#jstree').jstree(true).refresh();

                $('#jstree').on('refresh.jstree', function() {
                    $("#jstree").jstree("open_all");          
                });

                $('.btn-delete-modal').attr('data-id','');
                $("#modal-delete").modal('hide');
                normal();
                $('.btn-delete-modal').button('reset');
            }
        });
    });

    $(document).on('submit','#fileinfo',function (event) {
        event.preventDefault();

        var formMe = $(this)
        var attErrorKode = $('#fileinfo').find('.error-f_kodekategori')
        var attErrorName = $('#fileinfo').find('.error-f_namakategori')
        var attErrorDesc = $('#fileinfo').find('.error-f_deskripsikategori')

        $("#formerror-f_kodekategori").removeClass("has-error");
        $("#formerror-f_namakategori").removeClass("has-error");
        $("#formerror-f_deskripsikategori").removeClass("has-error");

        attErrorKode.html('')
        attErrorName.html('')
        attErrorDesc.html('')
        var btnSave = formMe.find('.btn-simpan')
        btnSave.button('loading')
        
        $.ajax({
            url: formMe.attr('action'),
            type: 'post',
            data: formMe.serialize(),
            dataType: 'json',
            success: function(response){
                if(response.errors){
                    alertBS('Terjadi Kesalahan, Form tidak terisi dengan benar','danger');
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

                    btnSave.button('reset');
                }else{
                    if(response==1){
                        alertBS('Data berhasil di update','success');
                        $('#jstree').jstree(true).refresh();

                        $('#jstree').on('refresh.jstree', function() {
                            $("#jstree").jstree("open_all");          
                        });
                        
                        normal();
                    }else{
                        alertBS('Terjadi Kesalahan, Kode kategori tidak boleh sama','danger');

                        attErrorKode.html('<span class="help-block"> Kode kategori tidak boleh sama </span>');
                        $("#formerror-f_kodekategori").addClass("has-error");
                    }
                    
                    btnSave.button('reset');
                }
            }
        });
    });
});
</script>
@endpush
