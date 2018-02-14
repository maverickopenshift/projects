@extends('layouts.app')

@section('content')
<div class="box box-danger">
  <div class="loading2"></div>
    <div class="box-header with-border">
      <h3 class="box-title title_group">
        <span class="status" style="display:none">{{$sts}}</span>
          <div class="btn-group add_sup_group" role="group" aria-label="...">
            @if(\Auth::user()->hasPermission('tambah-supplier'))
              <a href="{{route('supplier.create')}}" class="btn btn-default">
                  <i class="glyphicon glyphicon-plus"></i> Add Supplier
              </a>
            @endif
          </div>
          <div class="btn-group add_smile_group" role="group" aria-label="...">
            @if(\Auth::user()->hasPermission('tambah-supplier'))
              <form action="{{route('supplier.upload.smile')}}" id="form-user" class="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-sm-12">
                  <input type="file" name="supplier_smile" class="supplier_smile hide" accept=".csv,.xls,.xlsx"/>
                  <button class="btn btn-primary btn-sm upload-supplier_smile" type="button"><i class="fa fa-upload"></i> Upload Supplier from SMILE</button>
                  <a href="{{route('sap.template.download',['filename'=>'smile'])}}" class="btn btn-info  btn-sm" title="Download Sample Template"><i class="glyphicon glyphicon-download-alt"></i> Download sample template</a>
                  <span class="error error-supplier_smile text-danger"></span>
                </div>
                <button class="btn btn-primary btn-sm btn_submit hide" type="submit"></button>
              </form>
            @endif
          </div>
        </h3>
        <br>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body content-view">
      <div class="form-group input-group filter_group" style="width: 50%;">

        <div class="input-group ">
          <select class="form-control select-filter">
            <option value="">Semua</option>
            <option value="1">Sudah Disetujui</option>
            <option value="0">Belum Disetujui</option>
            <option value="2">Data Dikembalikan</option>
            <option value="sudah_mapping">Sudah Mapping SAP</option>
            <option value="belum_mapping">Belum Mapping SAP</option>
          </select>
          <span class="input-group-btn">
              <a class="btn btn-primary cari-filter">Cari</a>
          </span>
        </div>
      </div>
      <div class="loading2"></div>
        @include('supplier::partials.alert-message')

        <div id="alertBS"></div>
        <table class="table table-striped table-condensed" id="datatables" style="width:100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>Supplier</th>
                <th>ID</th>
                <th>Kode SAP</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Telepon</th>
                <th>Fax</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status Approval</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="table-supplier">
              @php
                $i=0;
              @endphp
              @foreach ($sql as $sqls)
                <tr>
                  <td>{{$i+1}}</td>
                  <td>{{$sqls->nm_vendor}}</td>
                  <td>{{$sqls->kd_vendor}}</td>
                  @if ($sqls->id_sap=="" || $sqls->id_sap==null)
                    {{-- <td>{{$sqls->user->id}}</td> --}}
                    <td> - </td>
                  @else
                    @foreach ($sqls->supplierSap as $key => $v)
                      @php
                        $vendor[] = $v->vendor;
                      @endphp
                    @endforeach
                    <td>{{implode(', ',$vendor)}} </td>
                  @endif

                  <td>{{$sqls->alamat}}</td>
                  <td>{{$sqls->kota}}</td>
                  <td>{{$sqls->telepon}}</td>
                  <td>{{$sqls->fax}}</td>
                  <td>{{$sqls->email}}</td>
                  <td>{{$sqls->created_at}}</td>
                  <td>{{$sqls->updated_at}}</td>
                  @if ($sqls->vendor_status == '0')
                    <td> <span class="label label-warning">Belum Disetujui</span></td>
                  @elseif ($sqls->vendor_status == '1')
                    <td><span class="label label-success">Sudah Disetujui</span></td>
                  @elseif ($sqls->vendor_status == '2')
                    <td><span class="label label-danger">Data Dikembalikan</span></td>
                  @endif
                  <td>
                    <div class="">
                    @if (\Auth::user()->hasPermission('ubah-supplier'))
                      <a href="{{route('supplier.lihat',['id'=>$sqls->id,'status'=>'lihat'])}}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Lihat</a> <br>
                    @endif
                    @if ($sqls->vendor_status !== 0)
                      @if (\Auth::user()->hasPermission('ubah-supplier'))
                        @if ($sqls->id_sap =="" || $sqls->id_sap==null)
                          <a href="{{route('supplier.mapping.sap',['id'=>$sqls->id])}}" class="btn btn-success btn-xs">Link To SAP</a> <br>
                        @else
                          <button class="btn btn-danger btn-xs unlink_btn" data-id="{{$sqls->id}}">Unlink To SAP</button> <br>
                        @endif
                      @endif
                      @if (\Auth::user()->hasPermission('cetak-dmt'))
                        @if ($sqls->no_rekanan_telkom =="" || $sqls->no_rekanan_telkom==null)
                          <a href="{{route('supplier.cetak.dmt',['id'=>$sqls->id])}}" target="_blank" class="btn btn-primary btn-xs">Cetak DMT</a> <br>
                        @else
                          <a href="{{route('supplier.cetak.ulang.dmt',['id'=>$sqls->id])}}" target="_blank" class="btn btn-primary btn-xs">Cetak Ulang DMT</a> <br>
                        @endif

                      @endif
                    @endif
                    </div>
                  </td>



                </tr>
                @php
                  $i++;
                @endphp
              @endforeach
            </tbody>
        </table>
    </div>
<!-- /.box-body -->
</div>
@include('supplier::form_editstatus')
@endsection
@push('scripts')
<script>
var datatablesMe;
var $status = $('.status').text();
// console.log($status);
$(function() {
$('#datatables').DataTable({
  processing: true,
  autoWidth : true,
  scrollX   : true,
  pageLength: 10,
  // fixedColumns:   {
  //       leftColumns: 2,
  //       rightColumns:1
  // },
});
  $(document).on('click', '.cari-filter', function(event) {
      var filter = $(".select-filter").val();
      $.ajax({
          url: "{{route('supplier.filter')}}?kode=" + filter,
          dataType: 'json',
          success: function(data)
          {
            if(data == null || data == ""){
              $('.table-supplier').html("");
              var html = '';
              html += "<tr>"+
                           "<td colspan='13' align='center'>Data Tidak Ditemukan</td>" +

                       "</tr>";
                       $('.table-supplier').html(html);
            }else {

              // console.log(data);
              $('.table-supplier').html("");


              var html = '';
              var status_ve;
              var  sap;
              var vendor=[];
              var i;
              var j;
              var link_sap;
              for(i = 0; i < data.length; i++){
                var jm = i+1;
                if(data[i].vendor_status == 0){
                  status_ve = "<span class='label label-warning'>Belum Disetujui</span>";
                }else if (data[i].vendor_status == 1) {
                  status_ve = "<span class='label label-success'>Sudah Disetujui</span>";
                }else if(data[i].vendor_status == 2){
                  status_ve = "<span class='label label-danger'>Data Dikembalikan</span>";
                }else {
                  status_ve = " - ";
                }

                @if (\Auth::user()->hasPermission('ubah-supplier'))
                var tb_lihat =  '<a href="/supplier/'+data[i].id+'/lihat" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Lihat</a> <br>';
                @endif

                if(data[i].vendor_status !== 0){
                  @if (\Auth::user()->hasPermission('ubah-supplier'))
                    if(data[i].id_sap =="" || data[i].id_sap==null){
                      link_sap = '<a href="/supplier/sap-mapping-'+data[i].id+'" class="btn btn-success btn-xs">Link To SAP</a> <br>';
                    }else{
                      link_sap = '<button class="btn btn-danger btn-xs unlink_btn" data-id="'+data[i].id+'">Unlink To SAP</button> <br>';
                    }
                  @endif
                }

                if(data[i].id_sap =="" || data[i].id_sap ==null){
                  sap = "-";
                }else{
                  var $supplier = data[i].supplier_sap;
                  console.log($supplier.length);
                  for (j = 0; j < $supplier.length; j++) {
                    var arr = vendor.push($supplier[j].vendor);
                  }

                  sap = vendor.join(", ");
                  // console.log(energy);
                }
                 html += "<tr>"+
                              "<td>"+ jm +"</td>" +
                              "<td>" + data[i].nm_vendor + "</td>" +
                              "<td>" + data[i].kd_vendor + "</td>" +
                              "<td>" + sap + "</td>" +
                              "<td>" + data[i].alamat + "</td>" +
                              "<td>" + data[i].kota + "</td>" +
                              "<td>" + data[i].telepon + "</td>" +
                              "<td>" + data[i].fax + "</td>" +
                              "<td>" + data[i].email + "</td>" +
                              "<td>" + data[i].created_at + "</td>" +
                              "<td>" + data[i].updated_at + "</td>" +
                              "<td>" + status_ve + "</td>" +
                              "<td>" + tb_lihat + link_sap + "</td>" +
                          "</tr>";
                  }
              $('.table-supplier').html(html);
          }
        }
      });
  });

  $('.upload-supplier_smile').on('click', function(event) {
    /* Act on the event */
    event.stopPropagation();
    event.preventDefault();
    $('.error-supplier_smile').html('');
    var $file = $('.supplier_smile').click();
  });

  $('.supplier_smile').on('change', function(event) {
    // $('.btn_submit').click();
    event.stopPropagation();
    event.preventDefault();

    var loading = $('.loading2');
    var form_user =  $('#form-user');
    loading.show();
    $.ajax({
      url: form_user.attr('action'),
      type: 'post',
      processData: false,
      contentType: false,
      data: new FormData(document.getElementById("form-user")),
      dataType: 'json',
    })
    .done(function(data) {
      if(data.status){
        console.log("sukses");
        bootbox.alert({
            title:"Pemberitahuan",
            message: "Data berhasil diupload",
            callback: function (result) {
              window.location = '{!!route('supplier',['status'=>'all'])!!}'
            }
        });
      }
      else{
        bootbox.alert({
            title:"Pemberitahuan",
            message: "Format CSV Tidak Valid!",
            callback: function (result) {
              window.location = '{!!route('supplier',['status'=>'all'])!!}'
            }
        });
      }
      loading.hide();
    })
    .always(function(){
      loading.hide();
    });
  });

  $(document).on('click', '.unlink_btn', function(event) {
    event.preventDefault();
    var content = $('.content-view');
    var loading = content.find('.loading2');
    var btn = $('.unlink_btn');
    var id = btn.data('id');
    bootbox.confirm({
      title: "Konfirmasi",
      message: "Apakah anda yakin ingin manghapus link dengan SAP ?",
      buttons: {
          confirm: {
              label: 'Yakin',
              className: 'btn-success btn-sm'
          },
          cancel: {
              label: 'Tidak',
              className: 'btn-danger btn-sm'
          }
      },
      callback: function (result) {
        if(result){
          loading.show();
          $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            url: '{!!route('supplier.hapus.mapping')!!}',
            type: 'POST',
            dataType: 'JSON',
            data: {id: id}
          })
          .done(function(data) {
            if(data.status){
              console.log("sukses");
              bootbox.alert({
                  title:"Pemberitahuan",
                  message: "Data berhasil dihapus",
                  callback: function (result) {
                      window.location = '{!!route('supplier',['status'=>'all'])!!}'
                  }
              });
            }
            else{
              console.log("err");
            }
            loading.hide();
          })
          .always(function(){
            loading.hide();
          });
        }
      }
    });
  });

if($status == "proses"){
  $('.add_sup_group').hide();
  $('.add_smile_group').hide();
  $('.filter_group').hide();
  $('.title_group').text('Supplier Perlu Diproses');
}
  // $(".filter").change(function () {
  //   var val = this.value;
  //   if(val == '-'){
  //     datatablesMe.columns( 3 ).search(this.value).draw();
  //   }else if(val == ','){
  //     datatablesMe.columns( 3 ).search(this.value).draw();
  //   }else{
  //     datatablesMe.columns( 11 ).search(this.value).draw();
  //   }
  // });
});
</script>
@endpush
