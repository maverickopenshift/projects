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
    <div class="col-md-12">
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
                                <select class="form-control" name="f_nokategori" id="f_nokategori">
                                    <option value="">Pilih Kategori</option>
                                </select>
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

                            <div class="form-group top10">
                                <input type="text" class="form-control input-rupiah" id="f_hargaterendah" name="f_hargaterendah"  placeholder="Harga Terendah ...">
                            </div>

                            <div class="form-group top10">
                                <input type="text" class="form-control input-rupiah" id="f_hargatertinggi" name="f_hargatertinggi"  placeholder="Harga Tertinggi ...">
                            </div>

                                <button type="submit" class="btn btn-success search top10">Cari</button>
                        </form>
                    </div>


                    <table class="table table-striped" id="daftar_product_price">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Taxonomy</th>
                                <th>Master Item</th>
                                <th>Satuan</th>
                                <th>Group Coverage</th>
                                <th>Coverage</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                                <th>Referensi</th>
                                <th>KHS</th>
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
var table_price;

function create_table_price(divisi, unit_bisnis, unit_kerja, f_caritext, f_nokategori, f_hargatertinggi, f_hargaterendah){
    var coloumx=[
        { data: 'DT_Row_Index',orderable:false,searchable:false},
        { data: 'taxonomy'},
        { data: 'nama_product'},        
        { data: 'nama_satuan'},
        { data: 'nama_group_coverage'},
        { data: 'nama_coverage'},
        { data: 'harga_barang_logistic'},
        { data: 'harga_jasa_logistic'},
        { data: 'referensi_fix', orderable:false, searchable:false},
        { data: 'flag', orderable:false, searchable:false}];

    table_price = $('#daftar_product_price').on('xhr.dt', function ( e, settings, json, xhr ) {
        if(xhr.responseText=='Unauthorized.'){
            location.reload();
        }
    }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth : false,
        searching : false,
        pageLength: 50,
        ajax: {
            "url": "{!! route('catalog.list.product_logistic_view.datatables') !!}?divisi=" + divisi + "&unit_bisnis=" + unit_bisnis + "&unit_kerja=" + unit_kerja  + "&f_caritext=" + f_caritext +"&f_nokategori=" + f_nokategori + "&f_hargatertinggi=" + f_hargatertinggi + "&f_hargaterendah=" + f_hargaterendah,
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: coloumx,
    });
}

function refresh_product_price(divisi, unit_bisnis, unit_kerja, f_caritext, f_nokategori, f_hargatertinggi, f_hargaterendah){
    table_price.destroy();
    create_table_price(divisi, unit_bisnis, unit_kerja, f_caritext, f_nokategori, f_hargatertinggi, f_hargaterendah);
}

function select_kategori(input){
    input.select2({
        placeholder : "Silahkan Pilih....",
        ajax: {
            url: '{!! route('catalog.product_master.get_category') !!}',
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

    var divisi = $("#divisi").val();
    var unit_bisnis = $("#unit_bisnis").val();
    var unit_kerja = $("#unit_kerja").val();

    var f_caritext = $("#f_caritext").val();
    var f_nokategori = $("#f_nokategori").val();
    var f_hargatertinggi = $("#f_hargatertinggi").val();
    var f_hargaterendah = $("#f_hargaterendah").val();

    refresh_product_price(divisi , unit_bisnis, unit_kerja, f_caritext, f_nokategori, f_hargatertinggi, f_hargaterendah);
});

$(function(){
    $('#unit_bisnis').change();
    $('#divisi').change();
    select_kategori($("#f_nokategori"));

    create_table_price('','','','','','','');

});
</script>
@endpush