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
        <div class="box box-danger parent_product_coverage">
            <input type="hidden" id="f_nocoverage">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <i class="fa fa-cogs"></i>
                    <h3 class="box-title">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form-modal-coverage" data-title="Add">
                                <i class="glyphicon glyphicon-plus"></i> Add Coverage
                            </button>
                        </div>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="alertBS_2"></div>

                    <table class="table table-striped" id="daftar_product_coverage">
                        <thead>
                            <tr>
                                <th>Nama Coverage</th>
                                <th>Nama Group Coverage</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form-modal-coverage">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-me-coverage" action="" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="f_id" name="f_id">

                    <div class="form-group formerror-f_namacoverage">
                        <label>Nama Coverage</label>
                        <input type="text" class="form-control" id="f_namacoverage" name="f_namacoverage" autocomplete="off"  placeholder="Nama Coverage ...">
                        <div class="error-f_namacoverage"></div>
                    </div>

                    <div class="form-group formerror-f_nogroupcoverage">
                        <label>Nama Group Coverage</label>
                        <select class="form-control select_group_coverage" name="f_nogroupcoverage" style="width: 100%;" required>
                        </select>
                        <div class="error-f_nogroupcoverage"></div>
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
var table_coverage;

function create_table_coverage(){
    table_coverage = $('#daftar_product_coverage').on('xhr.dt', function ( e, settings, json, xhr ) {
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
            "url": "{!! route('catalog.list.coverage.datatables') !!}",
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: 'nama_coverage'},
            { data: 'nama_group_coverage'},
            { data: 'action', name: 'action',orderable:false,searchable:false },
        ]
    });
}

function refresh_coverage(){
    table_coverage.destroy();
    create_table_coverage();
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

var formModal = $('#form-modal-coverage');
formModal.on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)

    var attError_f_namacoverage = modal.find('.error-f_namacoverage')
    modal.find('.formerror-f_namacoverage').removeClass("has-error");
    attError_f_namacoverage.html('');

    var attError_f_nogroupcoverage = modal.find('.error-f_nogroupcoverage')
    modal.find('.formerror-f_nogroupcoverage').removeClass("has-error");
    attError_f_nogroupcoverage.html('');

    var title = button.data('title');
    var btnSave = modal.find('.btn-save')
    btnSave.button('reset')
    modal.find('.modal-title').text(title + " Coverage")

    var data = button.data('data');

    if(title=="Add"){
        modal.find('.modal-body input#f_id').val('');
        modal.find('.modal-body input#f_namacoverage').val('');

        select_group_coverage(modal.find('.modal-body .select_group_coverage'));

        modal.find('form').attr('action',"{{ route('catalog.coverage.add') }}")
    }else{
        modal.find('.modal-body input#f_id').val(data.id);
        modal.find('.modal-body input#f_namacoverage').val(data.nama_coverage);
        
        select_group_coverage(modal.find('.modal-body .select_group_coverage'));
        set_select2(modal.find('.modal-body .select_group_coverage'),data.nama_group_coverage,data.group_coverage_id);

        modal.find('form').attr('action',"{{ route('catalog.coverage.edit') }}")

    }
});

$(document).on('submit','#form-me-coverage',function (event) {
    event.preventDefault();

    var formMe = $(this)

    var attError_f_namacoverage = formMe.find('.error-f_namacoverage')
    formMe.find('.formerror-f_namacoverage').removeClass("has-error");
    attError_f_namacoverage.html('');

    var attError_f_nogroupcoverage = formMe.find('.error-f_nogroupcoverage')
    formMe.find('.formerror-f_nogroupcoverage').removeClass("has-error");
    attError_f_nogroupcoverage.html('');

    var btnSave = formMe.find('.btn-simpan')
    
    $.ajax({
        url: formMe.attr('action'),
        type: 'post',
        data: formMe.serialize(),
        dataType: 'json',
        success: function(response){
            if(response.errors){
                alertBS_2('Something Wrong','danger');

                if(response.errors.f_namacoverage){
                    attError_f_namacoverage.html('<span class="help-block">'+response.errors.f_namacoverage+'</span>');
                    formMe.find('.formerror-f_namacoverage').addClass("has-error");
                }

                if(response.errors.f_nogroupcoverage){
                    attError_f_nogroupcoverage.html('<span class="help-block">'+response.errors.f_nogroupcoverage+'</span>');
                    formMe.find('.formerror-f_nogroupcoverage').addClass("has-error");
                }

                btnSave.button('reset');
            }
            else{
                alertBS_2('Data successfully updated','success');

                refresh_coverage();

                btnSave.button('reset');
                $('#form-modal-coverage').modal('hide');
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
        url: "{!! route('catalog.coverage.delete') !!}",
        method: 'delete',
        chache:false,
        data: {_token:'{!! csrf_token() !!}', id:$(this).attr('data-id')},
        dataType: 'json',
        success: function(response){
            if(response==1){
                alertBS_2('Data Berhasil DiHapus','success');
                refresh_coverage();
                $('#modal-delete').modal('hide');
            }else{
                alertBS_2('Data Gagal di hapus, data satuan ini sudah dipakai oleh master item','danger');
                refresh_coverage();
                $('#modal-delete').modal('hide');
            }            
        }
    });
});

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

function set_select2(attr_obj,text,id) {
    console.log(text);
    console.log(id);
    attr_obj.find('option').remove();
    var newOption = new Option(text, id, false, true);
    attr_obj.append(newOption);
    attr_obj.val(id).change();
}
$(function() {
    create_table_coverage();
});
</script>
@endpush