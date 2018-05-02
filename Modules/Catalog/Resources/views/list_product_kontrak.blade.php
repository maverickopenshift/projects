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
        <div class="box box-danger">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname_product">Daftar Kontrak Item</h3>
                <div class="pull-right">
                    @permission('katalog-item-price-proses')
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-additem" href="{{route('catalog.product.kontrak')}}" type="button"><i class="fa fa-plus"></i> Tambah Kontrak Item</a>
                    </div>
                    @endpermission
                </div>
            </div>
            <div class="box-body">
                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endforeach
                </div>
                <table class="table table-striped" id="daftar_product_kontrak">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No.Kontrak</th>
                            <th>Judul Dokumen</th>
                            <th>Tipe</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
        <div class="box box-danger parent_product_price">
            <input type="hidden" id="f_id_doc">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <i class="fa fa-cogs"></i>
                    <h3 class="box-title f_parentname_product">Daftar Item Price</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="alertBS_2"></div>

                    <div class="form-inline bottom25" style="width: 100%;">
                        <form id="form_me_cari" method="post">
                            <div class="form-group top10">
                                {!!Helper::select_all_divisi('divisi')!!}
                            </div>

                            <div class="form-group top10">
                                <select class="form-control" name="unit_bisnis" id="unit_bisnis">
                                    <option value="">Pilih Unit Bisnis</option>
                                </select>
                            </div>
                            <div class="form-group top10">
                                <select class="form-control" name="unit_kerja" id="unit_kerja">
                                    <option value="">Pilih Unit Kerja</option>
                                </select>
                            </div>

                                <button type="submit" class="btn btn-success search top10">Cari</button>
                        </form>
                    </div>


                    <table class="table table-striped" id="daftar_product_price">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Price Coverage</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{--
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
--}}
@endsection
@push('scripts')
<script>
var table_kontrak;
var table_price;

function create_table_kontrak(){
    table_product = $('#daftar_product_kontrak').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth : false,
        pageLength: 50,
        ajax: {
            "url": "{!! route('catalog.list.product_kontrak.datatables') !!}?",
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
        },
        columns: [
            { data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'doc_no'},
            { data: 'doc_title'},
            { data: 'doc_type'},
            { data: 'action', name: 'action',orderable:false,searchable:false},
        ]
    });
}

function create_table_price(id_doc, divisi, unit_bisnis, unit_kerja){

    var coloumx=[
            { data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'lokasi_logistic'},
            { data: 'harga_barang_logistic'},
            { data: 'harga_jasa_logistic'}];
    
    table_price = $('#daftar_product_price').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth : false,
        pageLength: 50,
        ajax: {
            "url": "{!! route('catalog.list.product_kontrak_logistic.datatables') !!}?id="+ id_doc + "&divisi=" + divisi + "&unit_bisnis=" + unit_bisnis + "&unit_kerja=" + unit_kerja,
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: coloumx,
    });
}

function refresh_product_kontrak(){
    table_product.destroy();
    create_table_master()
}

function refresh_product_price(no_product, divisi, unit_bisnis, unit_kerja){
    table_price.destroy();
    create_table_price(no_product, divisi, unit_bisnis, unit_kerja);
}
/*
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

function select_kontrak_referensi(parent){
    $(".select_kontrak").empty().trigger('change');
    {{--
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
    --}}
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

    $('#f_id').val(data.id);
    $('#f_parentid').val(data.product_master_id);
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

                var no_product = $("#f_noproduct").val();
                var divisi = $("#divisi").val();
                var unit_bisnis = $("#unit_bisnis").val();
                var unit_kerja = $("#unit_kerja").val();

                refresh_product_price(no_product, divisi , unit_bisnis, unit_kerja);

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

                var no_product = $("#f_noproduct").val();
                var divisi = $("#divisi").val();
                var unit_bisnis = $("#unit_bisnis").val();
                var unit_kerja = $("#unit_kerja").val();

                refresh_product_price(no_product, divisi , unit_bisnis, unit_kerja);

                //refresh_product_price(0,'','','');
                btnDelete.button('reset');
                btnDelete.attr('data-is','');
                modalDelete.modal('hide');
            }
        }
    });
});
*/
$(document).on('click', '.detail_price', function(event) {
    event.preventDefault();
    var id=$(this).attr('data-id');
    refresh_product_price(id,'','','');
    $("#f_id_doc").val(id);
    $(".parent_product_price").show();
});

$(document).on('change', '#divisi', function(event) {
    event.preventDefault();
    var divisi = this.value;

    $('#unit_bisnis').find('option').not('option[value=""]').remove();
    var t_awal = $('#unit_bisnis').find('option[value=""]').text();
    $('#unit_bisnis').find('option[value=""]').text('Please wait.....');
    $('#unit_kerja').find('option').not('option[value=""]').remove();

    $.ajax({
        url: '{!!route('doc.get-unit-bisnis')!!}',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {divisi: encodeURIComponent(divisi)}
    })
    .done(function(data) {
        console.log("test");
        if(data.length>0){
            $.each(data,function(index, el) {
                $('#unit_bisnis').append('<option value="'+this.id+'">'+this.title+'</option>');
            });
            $('#unit_bisnis').find('option[value=""]').text('Pilih Unit Bisnis');
        }else{
            $('#unit_bisnis').find('option[value=""]').text('Tidak ada data');
        }
    });
});

$(document).on('change', '#unit_bisnis', function(event) {
    event.preventDefault();
    var unit_bisnis = this.value;
    $('#unit_kerja').find('option').not('option[value=""]').remove();
    var t_awal = $('#unit_kerja').find('option[value=""]').text();
    $('#unit_kerja').find('option[value=""]').text('Please wait.....');
        $.ajax({
            url: '{!!route('doc.get-unit-kerja')!!}',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {unit_bisnis: encodeURIComponent(unit_bisnis)}
        })
        .done(function(data) {
            if(data.length>0){
                $.each(data,function(index, el) {
                    $('#unit_kerja').append('<option value="'+this.id+'">'+this.title+'</option>');
                });
                $('#unit_kerja').find('option[value=""]').text('Pilih Unit Kerja');
            }else{
                $('#unit_kerja').find('option[value=""]').text('Tidak ada data');
            }
        });
});

$(document).on('submit','#form_me_cari',function (event) {
    event.preventDefault();
    var id_doc = $("#f_id_doc").val();
    var divisi = $("#divisi").val();
    var unit_bisnis = $("#unit_bisnis").val();
    var unit_kerja = $("#unit_kerja").val();

    refresh_product_price(id_doc, divisi , unit_bisnis, unit_kerja);
});

$(function() {
    create_table_kontrak();
    create_table_price(0,'','','');
    $(".parent_product_price").hide();

    $('#unit_bisnis').change();
    $('#divisi').change();

    $(".flash-message").fadeTo(2000, 500).slideUp(500, function(){
        $(".flash-message").slideUp(500);
    });
});
</script>
@endpush