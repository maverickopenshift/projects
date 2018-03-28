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

    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }

    .modal-xl {
        width: 90%;
        max-width:1200px;
    }
</style>

<div class="row">
    <div class="col-md-3">
        <div class="box box-danger">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Kategori</h3>
            </div>
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
        <div class="box box-danger test-product">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title f_parentname">Tambah Master Item</h3>
                <div class="pull-right">
                    <div class="col-sm-12">
                        <input type="file" name="upload-boq" class="upload-boq hide"/>
                        <a class="btn btn-primary upload-boq-btn" type="button"><i class="fa fa-upload"></i> Upload</a>
                        <a href="{{route('doc.tmp.download',['filename'=>'harga_satuan'])}}" class="btn btn-info">
                            <i class="glyphicon glyphicon-download-alt"></i> Download Template
                        </a>
                    </div>
                </div>
            </div>    
            <form method="post" action="{{ route('catalog.product_master.add_ajax') }}" id="form-produk">
                <input type="hidden" class="f_parentid" name="f_parentid">
                {{ csrf_field() }}
                <div class="box-body form-horizontal">
                    <div class="flash-message" id="alertBS">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                    </div>

                    <table class="table table-striped table-parent-product" width="100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Keterangan</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-test">
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="box-tools pull-right">
                        <a class="btn bg-red btn-reset" href="{{route('catalog.product.master')}}" style="margin-bottom: 2px;">
                            Reset
                        </a>
                        <input type="submit" class="btn btn-primary simpan-product" value="Simpan">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
$(function() {
    normal();
    
    $('#daftar1').DataTable();

    function normal(){
        $(".add-product").prop("disabled", true);
        $(".test-product").addClass("disabledbutton");
        $(".upload-boq-btn").prop("disabled", true);
        $(".simpan-product").prop( "disabled", true );

        var new_row = $(template_add()).clone(true);
        $(".table-test").append(new_row);
        var input_new_row = new_row.find('td');
        
        input_new_row.eq(4).find('select').select2({
            placeholder:"Silahkan Pilih"
        });

        $("#alertBS").fadeTo(2000, 500).slideUp(500, function(){
            $("#alertBS").slideUp(500);
        });
    }

    $('.upload-boq-btn').on('click', function(event) {
        event.stopPropagation();
        event.preventDefault();
        var $file = $('.upload-boq').click();
    });

    $('.upload-boq').on('change', function(event) {
        event.stopPropagation();
        event.preventDefault();
        //BoqFile(this.files[0]);
    });

    /*
    function BoqFile(file) {
        console.log("upload start");
        Papa.parse(file, {
            header: true,
            dynamicTyping: true,
            complete: function(results) {
                
                var fields = results.meta.fields;
                @php
                    echo "var fields_dec = ['KODE_ITEM','ITEM','SATUAN','MTU','HARGA','KETERANGAN'];";
                    echo "var fields_length_set = 6;";
                @endphp

                if(fields.length!==fields_length_set || JSON.stringify(fields_dec)!==JSON.stringify(fields)){
                    alertBS("Format file tidak valid");
                    return false;
                }

                if(results.data.length==0){
                    alertBS("Format file tidak valid");
                    return false;
                }                
                $.each(results.data,function(index, el) {
                    if(results.data[index].KODE_ITEM!=""){
                        var new_row = $('.tabel-product:last').clone(true).insertAfter(".tabel-product:last");
                        var input_new_row = new_row.find('td');

                        input_new_row.eq(0).find('input').val(results.data[index].KODE_ITEM);
                        input_new_row.eq(0).find('.error').remove();
                        input_new_row.eq(0).removeClass("has-error");
                        input_new_row.eq(1).find('input').val(results.data[index].ITEM);
                        input_new_row.eq(1).find('.error').remove();
                        input_new_row.eq(1).removeClass("has-error");
                        input_new_row.eq(2).find('input').val(results.data[index].SATUAN);
                        input_new_row.eq(2).find('.error').remove();
                        input_new_row.eq(2).removeClass("has-error");

                    }
                });
            }
        });
    }
    */

    $('#jstree')
        .on("changed.jstree", function (e, data) {
            if(data.selected.length) {
                $(".f_parentname").html("Tambah Master Item - " + data.instance.get_node(data.selected[0]).text);
                $(".f_parentid").val(data.instance.get_node(data.selected[0]).id);
                $(".test-product").removeClass("disabledbutton");
                $(".add-product").prop("disabled", false);
                $(".upload-boq-btn").prop("disabled", false);
                $(".simpan-product").prop( "disabled", false );
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
             var parent=$(".f_parentid").val();
             console.log(parent);

             if(parent!=""){
                $('#jstree').jstree('select_node', parent);
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

    $('.table-parent-product').on('click', '.btn-delete', function(e){
        var rowCount = $('.table-parent-product tr:last').index() + 1;
        if(rowCount!=1){
            $(this).closest('tr').remove();
        }else{
            alertBS('Jika jumlah baris hanya ada 1 tidak bisa di hapus, silahkan tambah sebelum menghapus','danger');
        }
    });

    $(document).on('click', '.add-product', function(event) {        
        var new_row = $(template_add()).clone(true).insertAfter(".tabel-product:last");
        var input_new_row = new_row.find('td');
        
        fix_no_error();
    });

    function template_add(){
        return '\
        <tr class="tabel-product">\
            <td class="formerror formerror-f_kodeproduct-0">\
                <input type="text" name="f_kodeproduct[]" placeholder="Kode.." class="form-control">\
                <div class="error error-f_kodeproduct error-f_kodeproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_ketproduct-0">\
                <input type="text" name="f_ketproduct[]" placeholder="Keterangan .." class="form-control">\
                <div class="error error-f_ketproduct error-f_ketproduct-0"></div>\
            </td>\
            <td class="formerror formerror-f_unitproduct-0">\
                <input type="text" name="f_unitproduct[]" placeholder="Satuan.." class="form-control">\
                <div class="error error-f_unitproduct error-f_unitproduct-0"></div>\
            </td>\
            <td width="100px">\
                <div class="btn-group">\
                    <a class="btn btn-primary add-product">\
                        <i class="glyphicon glyphicon-plus"></i>\
                    </a>\
                    <a class="btn bg-red btn-delete" style="margin-bottom: 2px;">\
                        <i class="glyphicon glyphicon-trash"></i>\
                    </a>\
                </div>\
            </td>\
        </tr>';
    }

    function fix_no_error(){
        console.log("test");
        var $this = $('.tabel-product');
        $.each($this,function(index, el) {
            console.log(index);
            var mdf_new_row = $(this).find('td');
            //mdf_new_row.eq(0).find('.total_pasal').text(index+1);

            if(mdf_new_row.eq(0).hasClass("has-error")){
                mdf_new_row.eq(0).removeClass().addClass("has-error formerror formerror-f_kodeproduct-"+ index);
            }else{
                mdf_new_row.eq(0).removeClass().addClass("formerror formerror-f_kodeproduct-"+ index);
            }

            if(mdf_new_row.eq(1).hasClass("has-error")){
                mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-f_ketproduct-"+ index);
            }else{
                mdf_new_row.eq(1).removeClass().addClass("formerror formerror-f_ketproduct-"+ index);
            }

            if(mdf_new_row.eq(2).hasClass("has-error")){
                mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-f_unitproduct-"+ index);
            }else{
                mdf_new_row.eq(2).removeClass().addClass("formerror formerror-f_unitproduct-"+ index);
            }

            $(this).find('.error-f_kodeproduct').removeClass().addClass("error error-f_kodeproduct error-f_kodeproduct-"+ index);
            $(this).find('.error-f_ketproduct').removeClass().addClass("error error-f_ketproduct error-f_ketproduct-"+ index);
            $(this).find('.error-f_unitproduct').removeClass().addClass("error error-f_unitproduct error-f_unitproduct-"+ index);

        });        
    }

    $(document).on('click', '.simpan-product', function(event) {
        event.preventDefault();
        
        var formMe = $('#form-produk');
        $(".formerror").removeClass("has-error");
        $(".error").html('');

        bootbox.confirm({
          title:"Konfirmasi",
          message: "Apakah anda yakin untuk submit?",
          buttons: {
              confirm: {
                  label: 'Yakin',
                  className: 'btn-success'
              },
              cancel: {
                  label: 'Tidak',
                  className: 'btn-danger'
              }
          },
          callback: function (result) {
            if(result){
              $.ajax({
                url: formMe.attr('action'),
                type: 'post',
                processData: false,
                contentType: false,
                data: new FormData(document.getElementById("form-produk")),
                dataType: 'json',
                success: function(response){
                  if(response.errors){
                    $.each(response.errors, function(index, value){
                        if (value.length !== 0){
                          index = index.replace(".", "-");
                          $(".formerror-"+ index).removeClass("has-error");
                          $(".error-"+ index).html('');

                          $(".formerror-"+ index).addClass("has-error");
                          $(".error-"+ index).html('<span class="help-block">'+ value +'</span>');
                        }
                    });

                    bootbox.alert({
                      title:"Pemberitahuan",
                      message: "Data yang Anda masukan belum valid, silahkan periksa kembali!",
                    });
                  }else{
                    /*
                    bootbox.success({
                      title:"Pemberitahuan",
                      message: "Data Product berhasil di masukin!",
                    });
                    */

                    if(response.status=="all"){
                      window.location.href = "{{route('catalog.product.master')}}";
                    }
                  }
                }
              });
            }
          }
        });
      });
});
</script>
@endpush
