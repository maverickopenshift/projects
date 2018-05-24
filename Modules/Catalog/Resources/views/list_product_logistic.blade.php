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

    .modal-xl {
        width: 90%;
        max-width:1200px;
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
            </div>
            <div class="box-body">
                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endforeach
                </div>

                <input type="hidden" class="f_noproduct_origin" value="{{$no_product}}">
                <input type="hidden" class="f_kodeproduct_origin" value="{{$kode_product}}">
                <input type="hidden" class="f_namaproduct_origin" value="{{$nama_product}}">
                <table class="table table-striped" id="daftar_product_master">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Item</th>
                            <th>Satuan</th>
                            <th>Serial</th>
                            <th>Manufacture</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="box box-danger parent_product_price">
            <input type="hidden" id="f_noproduct">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <i class="fa fa-cogs"></i>
                    <h3 class="box-title f_parentname_price">Daftar Item Price</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="alertBS_2"></div>

                    <div class="form-inline bottom25" style="width: 100%;">
                        <form id="form_me_cari" method="post">
                            <div class="form-group top10">
                                <input type="text" class="form-control" id="f_caritext" name="f_caritext"  placeholder="Pencarian ...">
                            </div>

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
                                <th>Group Coverage</th>
                                <th>Coverage</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                                <th>Referensi</th>
                                <th>KHS</th>
                                @permission('katalog-item-price-proses')
                                <th width="20%">Aksi</th>
                                @endpermission
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="form-modal-product">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="form-me-product" action="{{route('catalog.product_logistic.edit')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Logistic</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="f_id" name="f_id">

                    <div class="form-group formerror-f_nogroupcoverage">
                        <label>Group Coverage</label>
                        <select class="form-control select_group_coverage" name="f_nogroupcoverage" style="width: 100%;">
                            <option value=""></option>
                        </select>
                        <div class="error-f_nogroupcoverage"></div>
                    </div>

                    <div class="form-group formerror-f_nocoverage">
                        <label>Coverage</label>
                        <select class="form-control select_coverage" name="f_nocoverage" style="width: 100%;">
                            <option value=""></option>
                        </select>
                        <div class="error-f_nocoverage"></div>
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
                    <div class="referensi_kontrak">
                        <br><br>

                        <div class="form-group input-group">
                            <input class="form-control doc_text" type="text" placeholder="No.Kontrak / Judul Kontrak">
                            <span class="input-group-btn">
                                <a class="btn btn-primary cari-kontrak">Cari No Kontrak</a>
                            </span>
                        </div>

                        <div class="form-group formerror-f_referensi">
                            <table class="table table-striped" id="daftar_kontrak">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Kontrak</th>
                                        <th>Judul Kontrak</th>
                                        <th>Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Mitra</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
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
var table_price;
var table_kontrak;
var table_kategori;
var no_kategori=0;

$('#jstree')
    .on("changed.jstree", function (e, data) {
        if(data.selected.length) {
            $(".f_parentname_product").html("Daftar Master Item - " + data.instance.get_node(data.selected[0]).text);
            $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
            $(".btn-edit").attr('data-id',data.instance.get_node(data.selected[0]).id)
            $(".btn-delete").attr('data-id',data.instance.get_node(data.selected[0]).id)

            refresh_product_master(data.instance.get_node(data.selected[0]).id);
            $(".parent_product_price").hide();
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

function create_table_master(no_kategori){
    table_product = $('#daftar_product_master').on('xhr.dt', function ( e, settings, json, xhr ) {
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
            "url": "{!! route('catalog.list.product_master.datatables') !!}?parent_id="+ no_kategori + "&type=2",
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
        },
        columns: [
            { data: 'kode_product'},
            { data: 'nama_product'},
            { data: 'nama_satuan'},
            { data: 'serial_product'},
            { data: 'manufacture_product'},
            { data: 'action', name: 'action',orderable:false,searchable:false},
        ]
    });
}

function create_table_price(no_product, divisi, unit_bisnis, unit_kerja, f_caritext){
    var coloumx=[
        { data: 'DT_Row_Index',orderable:false,searchable:false},
        { data: 'nama_group_coverage', name: 'a.nama_group_coverage'},
        { data: 'nama_coverage', name: 'a.nama_coverage'},
        {
            data: 'harga_barang_logistic', name: 'a.harga_barang_logistic',
            className : 'text-right',
            render: $.fn.dataTable.render.number( ',', '.')
        },
        {
            data: 'harga_jasa_logistic', name: 'a.harga_jasa_logistic',
            className : 'text-right',
            render: $.fn.dataTable.render.number( ',', '.')
        },
        { data: 'referensi_fix', name: 'c.doc_no'},
        { data: 'flag', searchable:false},
        { data: 'action', name: 'action',orderable:false,searchable:false }];

    table_price = $('#daftar_product_price').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        scrollX   : true,
        processing: true,
        serverSide: true,
        autoWidth : false,
        searching : false,
        pageLength: 50,
        ajax: {
            "url": "{!! route('catalog.list.product_logistic.datatables') !!}?id="+ no_product + "&divisi=" + divisi + "&unit_bisnis=" + unit_bisnis + "&unit_kerja=" + unit_kerja  + "&f_caritext=" + f_caritext,
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: coloumx,
    });
}

function create_table_kontrak(text_cari_kontrak){
    table_kontrak = $('#daftar_kontrak').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        scrollX   : true,
        processing: true,
        serverSide: true,
        autoWidth : false,
        searching : false,
        pageLength: 50,
        ajax: {
            "url": "{!! route('catalog.list.kontrak.datatables') !!}?cari=" + text_cari_kontrak,
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns:[
            { data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'doc_no'},
            { data: 'doc_title'},
            { data: 'doc_type'},
            { data: 'doc_startdate'},
            { data: 'doc_enddate'},
            { data: 'nama_supplier'},
            { data: 'action', name: 'action',orderable:false,searchable:false }],
    });
}

function refresh_product_master(no_kategori){
    table_product.destroy();
    create_table_master(no_kategori)
}

function refresh_product_price(no_product, divisi, unit_bisnis, unit_kerja, f_caritext){
    table_price.destroy();
    create_table_price(no_product, divisi, unit_bisnis, unit_kerja, f_caritext);
}

function refresh_table_kontrak(text_cari_kontrak){
    table_kontrak.destroy();
    create_table_kontrak(text_cari_kontrak)
}

function template_referensi_kontrak(id_doc, doc_no){
    return '\
            <input type="hidden" name="f_referensi" class="doc_no_input" value="'+ id_doc +'">\
            <input class="form-control doc_text_input" type="text" placeholder="No.Kontrak" value="'+ doc_no +'" readonly>\
    ';
}

function template_refrensi_freetext(){
    return '\
        <input type="text" class="form-control f_referensi" name="f_referensi" autocomplete="off" placeholder="Referensi..">\
    ';
}

function select_group_coverage(input){
    input.select2({
        placeholder : "Silahkan Pilih....",
        ajax: {
            url: '{!! route('catalog.coverage.get_group_coverage') !!}',
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

function select_coverage(input, group_coverage){
    input.select2({
        placeholder : "Silahkan Pilih....",
        ajax: {
            url: '{!! route('catalog.coverage.get_coverage') !!}?id_group_coverage=' + group_coverage,
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

    select_group_coverage($('.select_group_coverage'));
    //select_coverage($('.select_group_coverage'));
    set_select2($('.select_group_coverage'), data.nama_group_coverage, data.group_coverage_id);
    set_select2($('.select_coverage'), data.nama_coverage, data.coverage_id);

    $('#f_id').val(data.id);
    $('#f_parentid').val(data.product_master_id);
    $('#f_hargabarang').val(data.harga_barang_logistic);
    $('#f_hargajasa').val(data.harga_jasa_logistic);
    $('#f_jenis').val(data.jenis_referensi);

    if(data.jenis_referensi==1){
        var new_referensi = $(template_referensi_kontrak(data.referensi_logistic, data.doc_no)).clone(true);
        $(".isi-referensi").html('');
        $(".isi-referensi").append(new_referensi);

        refresh_table_kontrak('');
        $(".referensi_kontrak").show();
    }else{
        var new_referensi = $(template_refrensi_freetext()).clone(true);
        $(".isi-referensi").html('');
        $(".isi-referensi").append(new_referensi);

        $(".f_referensi").val(data.referensi_logistic);
        $(".referensi_kontrak").hide();
    }
});

$(document).on('click', '.cari-kontrak', function(event) {
    var text_cari_kontrak = $(".doc_text").val();
    refresh_table_kontrak(text_cari_kontrak);
});

$(document).on('click', '.btn-pilih-kontrak', function(event) {
    var data = $(this).data('data');
    $(".doc_no_input").val(data.id);
    $(".doc_text_input").val(data.doc_no);
});

$("#f_jenis").on('change', function(event) {        
    if($("#f_jenis").val()==1){
        var new_referensi = $(template_referensi_kontrak('','')).clone(true);
        $(".isi-referensi").html('');
        $(".isi-referensi").append(new_referensi);
        
        refresh_table_kontrak('');
        $(".referensi_kontrak").show();
    }else{
        var new_referensi = $(template_refrensi_freetext()).clone(true);
        $(".isi-referensi").html('');
        $(".isi-referensi").append(new_referensi);
        $(".referensi_kontrak").hide();
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
                var f_caritext = $("#f_caritext").val();

                refresh_product_price(no_product, divisi , unit_bisnis, unit_kerja, f_caritext);

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
                var f_caritext = $("#f_caritext").val();

                refresh_product_price(no_product, divisi , unit_bisnis, unit_kerja, f_caritext);

                btnDelete.button('reset');
                btnDelete.attr('data-is','');
                modalDelete.modal('hide');
            }
        }
    });
});

$(document).on('click', '.detail_price', function(event) {
    event.preventDefault();
    var id=$(this).attr('data-id');
    var kode=$(this).attr('data-kode');
    var ket=$(this).attr('data-ket');

    refresh_product_price(id,'','','','');
    $("#f_noproduct").val(id);

    $('.f_parentname_price').html('Daftar Item Price - ' + kode + ' - ' + ket)

    $(".parent_product_price").show();
});

$(document).on('change', '.select_group_coverage', function(event){
    $('.select_coverage').val('');
    select_coverage($('.select_coverage'),$(this).val());
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
            $('#unit_bisnis').find('option[value=""]').text('Pilih Unit Bisnis');
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
                $('#unit_kerja').find('option[value=""]').text('Pilih Unit Kerja');
            }
        });
});

$(document).on('submit','#form_me_cari',function (event) {
    event.preventDefault();
    /*
    var divisi = "";
    var unit_bisnis = "";
    var unit_kerja = "";
    */

    var no_product = $("#f_noproduct").val();
    var divisi = $("#divisi").val();
    var unit_bisnis = $("#unit_bisnis").val();
    var unit_kerja = $("#unit_kerja").val();
    var f_caritext = $("#f_caritext").val();

    refresh_product_price(no_product, divisi , unit_bisnis, unit_kerja, f_caritext);
});

$(function() {
    create_table_master(0);
    
    $(".parent_product_price").hide();

    $('#unit_bisnis').change();
    $('#divisi').change();

    create_table_kontrak('');

    if($('.f_noproduct_origin').val()!=0){
        var id      = $('.f_noproduct_origin').val()
        var kode    = $('.f_kodeproduct_origin').val()
        var ket     = $('.f_ketproduct_origin').val()

        //refresh_product_price(id,'','','','');
        create_table_price(id,'','','','');
        $("#f_noproduct").val(id);

        $('.f_parentname_price').html('Daftar Item Price - ' + kode + ' - ' + ket)

        $(".parent_product_price").show();
    }else{
        create_table_price(0,'','','','');
    }

    $(".flash-message").fadeTo(2000, 500).slideUp(500, function(){
        $(".flash-message").slideUp(500);
    });
});
</script>
@endpush