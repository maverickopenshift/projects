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
                        @permission('katalog-master-item-proses')
                        <a class="btn btn-danger btn-additem" href="{{route('catalog.product.master')}}?id_kategori=0" type="button"><i class="fa fa-plus"></i> Tambah Master Item</a>
                        <a class="btn btn-danger btn-additem" href="{{route('catalog.product_master.bulk')}}" type="button"><i class="fa fa-plus"></i> Tambah Master Item Bulk</a>
                        @endpermission
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div id="alertBS_2"></div>
                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endforeach
                </div>

                <table class="table table-striped" id="daftar_product">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Satuan</th>
                            <th>Serial</th>
                            <th>Manufacture</th>
                            @permission('katalog-master-item-proses')
                            <th width="25%">Aksi</th>
                            @endpermission
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

                    <div class="form-group formerror formerror-f_produk_parentid">
                        <label>Induk Kategori</label>
                        <select class="form-control select2" id="f_produk_parent" name="f_produk_parent" style="width: 100%;" required>
                        </select>
                        <div class="error error-f_produk_parentid"></div>
                    </div>

                    <div class="form-group formerror formerror-f_kodeproduct">
                        <label>Kode Produk</label>
                        <input type="text" class="form-control" id="f_kodeproduct" name="f_kodeproduct" placeholder="Kode Produk ...">
                        <div class="error error-f_kodeproduct"></div>
                    </div>

                    <div class="form-group formerror formerror-f_namaproduct">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" id="f_namaproduct" name="f_namaproduct"  placeholder="Nama Produk ...">
                        <div class="error error-f_namaproduct"></div>
                    </div>

                    <div class="form-group formerror formerror-f_unitproduct">
                        <label>Satuan Produk</label>
                        <select class="form-control select_satuan" name="f_unitproduct" style="width: 100%;">
                            <option value=""></option>
                        </select>
                        <div class="error error-f_unitproduct"></div>
                    </div>

                    <div class="form-group formerror formerror-f_serialproduct">
                        <label>Serial Produk</label>
                        <input type="text" class="form-control" id="f_serialproduct" name="f_serialproduct"  placeholder="Serial Produk ...">
                        <div class="error error-f_serialproduct"></div>
                    </div>

                    <div class="form-group formerror formerror-f_manufactureproduct">
                        <label>Manufacture Produk</label>
                        <input type="text" class="form-control" id="f_manufactureproduct" name="f_manufactureproduct"  placeholder="Manufacture Produk ...">
                        <div class="error error-f_manufactureproduct"></div>
                    </div>
                    
                    <div class="form-group">
                        <label>Gambar Produk</label>
                        <div class="input-group">
                            <input type="file" name="f_gambar" accept=".jpg" class="f_gambar hide">
                            <input class="form-control f_gambar_text" type="text" placeholder="Gambar.." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-success click-upload" type="button"><i class="glyphicon glyphicon-search"></i></button>
                            </span>
                        </div>
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

<div class="modal modal-danger fade" role="dialog" id="modal-delete">
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
            $(".f_parentname_product").html("Daftar Master Item - " + data.instance.get_node(data.selected[0]).text);
            $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
            $(".btn-edit").attr('data-id',data.instance.get_node(data.selected[0]).id)
            $(".btn-delete").attr('data-id',data.instance.get_node(data.selected[0]).id)
            $(".btn-additem").attr("href","{{ route('catalog.product.master') }}?id_kategori=" + data.instance.get_node(data.selected[0]).id )

            refresh_product(data.instance.get_node(data.selected[0]).id);
        }
    })
    .jstree({
        "plugins" : ["search"],
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
    if ($('.btn-additem').length){
        var coloumx=[
            { data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'image_product',
                render: function( data, type, full, meta ) {
                    if(data!=''){
                        return "<img src='product_master/image/" + data + "' height='50'/>"
                    }else{
                        var url = "{{asset('/images/no_image.png')}}";
                        return "<img src='"+ url +"' height='60'>";
                    }
                }
            },
            { data: 'kode_product'},
            { data: 'nama_product'},
            { data: 'nama_satuan'},
            { data: 'serial_product'},
            { data: 'manufacture_product'},
            { data: 'action', name: 'action',orderable:false,searchable:false}];
    }else{
        var coloumx=[
            { data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'image_product',
                render: function( data, type, full, meta ) {
                    if(data!=''){
                        return "<img src=\"product_master/image/" + data + "\" height=\"50\"/>";
                    }else{
                        return "";
                    }                    
                }
            },
            { data: 'kode_product'},
            { data: 'nama_product'},
            { data: 'nama_satuan'},
            { data: 'serial_product'},
            { data: 'manufacture_product'}];
    }

    table_product = $('#daftar_product').on('xhr.dt', function ( e, settings, json, xhr ) {
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
            "url": "{!! route('catalog.list.product_master.datatables') !!}?parent_id="+ no_kategori + "&type=1",
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: coloumx,
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

function select_satuan(input){
    input.select2({
        placeholder : "Silahkan Pilih....",
        ajax: {
            url: '{!! route('catalog.product_master.get_satuan') !!}',
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

function set_select2(attr_obj,text,id) {
    attr_obj.find('option').remove();
    var newOption = new Option(text, id, false, true);
    attr_obj.append(newOption);
    attr_obj.val(id).change();
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

    $(".formerror").removeClass("has-error");
    $(".error").html('');

    get_produk_induk(data.catalog_category_id);

    modal.find('.modal-body input#f_id').val(data.id);
    modal.find('.modal-body input#f_parentid').val(data.catalog_category_id);

    modal.find('.modal-body input#f_kodeproduct').val(data.kode_product);
    modal.find('.modal-body input#f_namaproduct').val(data.nama_product);

    modal.find('.modal-body input#f_serialproduct').val(data.serial_product);
    modal.find('.modal-body input#f_manufactureproduct').val(data.manufacture_product);


    modal.find('.modal-body .f_gambar').val('');
    modal.find('.modal-body .f_gambar_text').val('');

    select_satuan(modal.find('.modal-body .select_satuan'));
    set_select2(modal.find('.modal-body .select_satuan'),data.nama_satuan,data.satuan_id);
});    

$(document).on('submit','#form-me-product',function (event) {
    event.preventDefault();
    var formMe = $(this)
    
    $(".formerror").removeClass("has-error");
    $(".error").html('');

    var btnSave = formMe.find('.btn-simpan')
    //btnSave.button('loading')

    $.ajax({
        url: formMe.attr('action'),
        type: 'post',
        processData: false,
        contentType: false,
        data: new FormData(document.getElementById("form-me-product")),
        dataType: 'json',
        success: function(response){
            if(response.errors){
                alertBS_2('Something Wrong','danger');

                $.each(response.errors, function(index, value){
                    if (value.length !== 0){
                      index = index.replace(".", "-");
                      $(".formerror-"+ index).removeClass("has-error");
                      $(".error-"+ index).html('');

                      $(".formerror-"+ index).addClass("has-error");
                      $(".error-"+ index).html('<span class="help-block">'+ value +'</span>');
                    }
                });
                
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
            }else{
                alertBS_2('Data gagal di hapus, master item ini sudah memiliki item price','danger');
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

    $(".flash-message").fadeTo(2000, 500).slideUp(500, function(){
        $(".flash-message").slideUp(500);
    });
});
</script>
@endpush