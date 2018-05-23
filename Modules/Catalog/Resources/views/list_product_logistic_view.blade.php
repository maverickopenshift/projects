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

    .fix-table td{
        padding-top: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }

</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger parent_product_price">
            <input type="hidden" id="f_noproduct">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <i class="fa fa-cogs"></i>
                    <h3 class="box-title f_parentname_price">Daftar Item</h3>
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
                                <select class="form-control" name="f_nokategori" id="f_nokategori" style="width: 450px;">
                                    <option value="">Silahkan Pilih Kategori..</option>
                                    @php
                                    for($i=0;$i<count($kategori);$i++){
                                        if($kategori[$i]['child']==1){

                                            echo "<option value='".$kategori[$i]['id']."'>
                                                ".$kategori[$i]['text']."
                                                </option>";

                                        }elseif($kategori[$i]['child']==2){

                                            echo "<option value='".$kategori[$i]['id']."'>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                ".$kategori[$i]['text']."
                                                </option>";

                                        }elseif($kategori[$i]['child']==3){

                                            echo "<option value='".$kategori[$i]['id']."'>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                ".$kategori[$i]['text']."
                                                </option>";

                                        }elseif($kategori[$i]['child']==4){

                                            echo "<option value='".$kategori[$i]['id']."'>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                ".$kategori[$i]['text']."
                                                </option>";

                                        }elseif($kategori[$i]['child']==5){

                                            echo "<option value='".$kategori[$i]['id']."'>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                ".$kategori[$i]['text']."
                                                </option>";
                                        }
                                    }
                                    @endphp
                                </select>
                            </div>
                            
                            <br>

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

                            <br>

                            <div class="form-group top10">
                                <select class="form-control select_group_coverage" id="f_nogroupcoverage" name="f_nogroupcoverage" style="width: 300px;">
                                    <option value="">Pilih Group Coverage</option>
                                </select>
                            </div>

                            <div class="form-group top10">
                                <select class="form-control select_coverage" id="f_nocoverage"  name="f_nocoverage" style="width: 300px;">
                                    <option value="">Pilih Coverage</option>
                                </select>
                            </div>

                            <br>

                            <div class="form-group top10">
                                <select class="form-control select_supplier" id="f_nosupplier" name="f_nosupplier" style="width: 300px;">
                                    <option value="">Pilih Mitra</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success search top10">Cari</button>
                        </form>
                    </div>


                    <table class="table table-striped" id="daftar_product_price">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Satuan</th>
                                <th>Group Coverage</th>
                                <th>Coverage</th>
                                <th>Harga Barang</th>
                                <th>Harga Jasa</th>
                                <th>KHS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form-modal-detail" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" style="position:relative;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Data Item Price</h4> 
            </div>
            <div class="modal-body">
                <table width="100%" class="fix-table">
                    <tr>
                        <td colspan="2" class="modal-image"></img></td>
                    </tr>
                    <tr>
                        <td width="25%">Taxonomy</td>
                        <td class="modal-taxonomy"></td>
                    </tr>
                    <tr>
                        <td>Kode Item</td>
                        <td class="modal-kodeitem"></td>
                    </tr>
                    <tr>
                        <td>Nama Item</td>
                        <td class="modal-namaitem"></td>
                    </tr>
                    <tr>
                        <td>Satuan</td>
                        <td class="modal-satuan"></td>
                    </tr>
                    <tr>
                        <td>Group Coverage</td>
                        <td class="modal-groupcoverage"></td>
                    </tr>
                    <tr>
                        <td>Coverage</td>
                        <td class="modal-coverage"></td>
                    </tr>
                    <tr>
                        <td>Harga Barang</td>
                        <td class="modal-hargabarang"></td>
                    </tr>
                    <tr>
                        <td>Harga Jasa</td>
                        <td class="modal-hargajasa"></td>
                    </tr>
                    <tr>
                        <td>Referensi</td>
                        <td class="modal-referensi"></td>
                    </tr>
                    <tr>
                        <td>Mitra</td>
                        <td class="modal-mitra"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Mulai</td>
                        <td class="modal-tanggalmulai"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Akhir</td>
                        <td class="modal-tanggalakhir"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
var table_price;

$("#f_nokategori").select2();

function create_table_price(divisi, unit_bisnis, unit_kerja, f_caritext, f_nokategori, f_nogroupcoverage, f_nocoverage, f_nosupplier){
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
        { data: 'nama_group_coverage'},
        { data: 'nama_coverage'},
        {
            data: 'harga_barang_logistic',
            render: $.fn.dataTable.render.number( ',', '.')
        },
        {
            data: 'harga_jasa_logistic',
            render: $.fn.dataTable.render.number( ',', '.')
        },
        { data: 'flag', orderable:false, searchable:false},
        { data: 'action', orderable:false, searchable:false}];

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
            "url": "{!! route('catalog.list.product_logistic_view.datatables') !!}?divisi=" + divisi + "&unit_bisnis=" + unit_bisnis + "&unit_kerja=" + unit_kerja  + "&f_caritext=" + f_caritext +"&f_nokategori=" + f_nokategori + "&f_nogroupcoverage=" + f_nogroupcoverage + "&f_nocoverage=" + f_nocoverage + "&f_nosupplier=" + f_nosupplier,
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: coloumx,
    });
}

function refresh_product_price(divisi, unit_bisnis, unit_kerja, f_caritext, f_nokategori, f_nogroupcoverage, f_nocoverage, f_nosupplier){
    table_price.destroy();
    create_table_price(divisi, unit_bisnis, unit_kerja, f_caritext, f_nokategori, f_nogroupcoverage, f_nocoverage, f_nosupplier);
}

function select_group_coverage(input){
    input.select2({
        placeholder : "Silahkan Pilih Group Coverage....",
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
                return "Silahkan Pilih Group Coverage..";
            }
            if(data.text === undefined){
              return data.text;
            }
            return data.text ;
        }
    });
}

function select_supplier(input){
    input.select2({
        placeholder : "Silahkan Pilih Mitra....",
        ajax: {
            url: '{!! route('catalog.product_logistic.get_supplier') !!}',
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
                return "Silahkan Pilih Mitra..";
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

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

var formModal = $('#form-modal-detail');
formModal.on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)    

    var data = button.data('data');

    $('.modal-title').text("Data Item - " + data.kode_product +" - "+ data.nama_product)
    if(data.image_product!=""){
        $('.modal-image').html("<img src='product_master/image/"+ data.image_product +"'>");
    }else{
        var url_noimage = "{{asset('/images/no_image.png')}}";
        $('.modal-image').html("<img src='"+ url_noimage +"'  style='width: 25%; height: 25%'>");
    }
    
    $('.modal-taxonomy').html(data.taxonomy);
    $('.modal-kodeitem').html(data.kode_product);
    $('.modal-namaitem').html(data.nama_product);
    $('.modal-satuan').html(data.nama_satuan);
    $('.modal-groupcoverage').html(data.nama_group_coverage);
    $('.modal-coverage').html(data.nama_coverage);

    var fix_number_barang = addCommas(data.harga_barang_logistic);
    var fix_number_jasa = addCommas(data.harga_jasa_logistic);

    $('.modal-hargabarang').html(fix_number_barang);
    $('.modal-hargajasa').html(fix_number_jasa);
    $('.modal-hargabarang').html(data.harga_barang);

    if(data.jenis_referensi==2){
        $('.modal-referensi').html(data.referensi_logistic);
        $('.modal-khs').html("");
        $('.modal-mitra').html("");        
    }else{
        $('.modal-referensi').html(data.doc_no);
        $('.modal-mitra').html(data.nama_supplier);
        $('.modal-tanggalmulai').html(data.doc_startdate);
        $('.modal-tanggalakhir').html(data.doc_enddate);

        if(data.doc_type=="khs"){
            $('.modal-referensi').html("KHS No: " + data.doc_no);
        }else{   
            $('.modal-referensi').html("No: "+ data.doc_no);
        }
    }
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
    var f_nogroupcoverage = $("#f_nogroupcoverage").val();
    var f_nocoverage = $("#f_nocoverage").val();

    var f_nosupplier = $("#f_nosupplier").val();
    
    refresh_product_price(divisi , unit_bisnis, unit_kerja, f_caritext, f_nokategori, f_nogroupcoverage, f_nocoverage, f_nosupplier);
});

$(function(){
    $('#unit_bisnis').change();
    $('#divisi').change();

    select_group_coverage($('.select_group_coverage'));
    select_supplier($('.select_supplier'));
    create_table_price('','','','','','','','');
});
</script>
@endpush