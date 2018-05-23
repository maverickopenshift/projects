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
                <h3 class="box-title f_parentname_product">Daftar Item Kontrak</h3>
                <div class="pull-right">
                    @permission('katalog-item-price-proses')
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-additem" href="{{route('catalog.product.kontrak')}}" type="button"><i class="fa fa-plus"></i> Tambah Item Kontrak</a>
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
                                <input type="text" class="form-control" id="f_caritext" name="f_caritext"  placeholder="Pencarian ...">
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
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
        scrollX   : true,
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
            { data: 'doc_startdate'},
            { data: 'doc_enddate'},
            { data: 'nama_supplier'},
            { data: 'action', name: 'action',orderable:false,searchable:false},
        ]
    });
}

function create_table_price(id_doc, f_caritext){

    var coloumx=[
            { data: 'DT_Row_Index',orderable:false,searchable:false},
            { data: 'nama_group_coverage'},
            { data: 'nama_coverage'},
            {
                data: 'harga_barang_logistic',
                render: $.fn.dataTable.render.number( ',', '.')
            },
            {
                data: 'harga_jasa_logistic',
                render: $.fn.dataTable.render.number( ',', '.')
            }];
    
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
            "url": "{!! route('catalog.list.product_kontrak_logistic.datatables') !!}?id="+ id_doc + "&f_caritext=" + f_caritext,
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

function refresh_product_price(no_product, f_caritext){
    table_price.destroy();
    create_table_price(no_product, f_caritext);
}

$(document).on('click', '.detail_price', function(event) {
    event.preventDefault();
    var id=$(this).attr('data-id');
    refresh_product_price(id,'');
    $("#f_id_doc").val(id);
    $(".parent_product_price").show();
});

$(document).on('submit','#form_me_cari',function (event) {
    event.preventDefault();
    var id_doc = $("#f_id_doc").val();
    var f_caritext = $("#f_caritext").val();

    refresh_product_price(id_doc, f_caritext);
});

$(function() {
    create_table_kontrak();
    create_table_price(0,'');
    $(".parent_product_price").hide();

    $('#unit_bisnis').change();
    $('#divisi').change();

    $(".flash-message").fadeTo(2000, 500).slideUp(500, function(){
        $(".flash-message").slideUp(500);
    });
});
</script>
@endpush