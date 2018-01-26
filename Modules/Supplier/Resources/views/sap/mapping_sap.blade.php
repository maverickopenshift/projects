@extends('layouts.app')

@section('content')
<div class="box box-danger">
  <div class="loading2"></div>
    <div class="box-header with-border">
      <h3 class="box-title">
        Mapping Supplier ke SAP
      </h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body content-view">
      <form action="{{ route('supplier.update') }}" class="form_sap" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        @include('supplier::partials.alert-message')
        <input type="hidden" value="{{$id_sup}}" class="id_sup" name="id_sup">
        <div class="loading2"></div>
        <div id="alertBS"></div>
        <table class="table table-condensed table-striped" id="datatables">
            <thead>
            <tr>
                <th width="">No.</th>
                <th width="">Supplier</th>
                <th width="">ID</th>
                <th width="">Alamat</th>
                <th width="">Kota</th>
                <th width="">Action</th>
            </tr>
            </thead>
            <tbody>
              @php
                $i=0;
              @endphp
              @foreach ($sap as $saps)
                <tr>
                  <td>{{$i+1}}</td>
                  <td>{{ $saps->name_1}}</td>
                  <td>{{ $saps->vendor}}</td>
                  <td>{{ $saps->street}}</td>
                  <td>{{ $saps->city}}</td>
                  <td align="center"><input type="checkbox" class="checkbox_check" id="cb_sap[]" name="cb_sap[]" value="{{$saps->id}}"></td>
                </tr>
                @php
                  $i++;
                @endphp
              @endforeach
            </tbody>
        </table>
        <div class="form-group text-center top btn_smpn">
          <a href="{{route('supplier', ['status' => 'all'])}}" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">BACK</a>
          @if(count($sap)>0)
          <button type="submit" class="btn btn-success btn-sbm" style="padding:5px 20px;font-weight:bold;font-size:16px;">SIMPAN</button>
        @endif
        </div>
        </form>
    </div>
<!-- /.box-body -->
</div>
@endsection
@push('scripts')
  <script>
  var datatablesMe;
  $(function() {
  $('#datatables').DataTable();

  $(document).on('click', '.btn-sbm', function(event) {
    event.preventDefault();
    var content = $('.content-view');
    var loading = content.find('.loading2');
    var formMe = $('.form_sap');

    if ($('input.checkbox_check').is(':checked')) {
      loading.show();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: '{!!route('supplier.mapping.simpan')!!}',
        type: 'post',
        dataType: 'JSON',
        data: formMe.serialize(),
      })
      .done(function(data) {
        if(data.status){
          console.log("sukses");
          bootbox.alert({
              title:"Pemberitahuan",
              message: "Data berhasil dimapping",
              callback: function (result) {
                window.location = '{!!route('supplier', ['status' => 'all'])!!}'
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
    }else{
        bootbox.alert({
        message: "Supplier SAP Harus dipilih",
        size: 'small'
      });
    }
  });
});
  </script>
@endpush
