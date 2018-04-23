@extends('layouts.app')

@section('content')

  <form action="{{ $action_url }}" id="form-kontrak" method="post" enctype="multipart/form-data">
    @if($action_type == "edit")
      <input type="hidden" value="{{$data->id}}" name="id" id="id_supplier" />
    @endif
    {{ csrf_field() }}
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">Informasi Vendor</a></li>
          <li><a href="#tab_2" data-toggle="tab">Data Vendor</a></li>
          <li><a href="#tab_3" data-toggle="tab">Finansial Aspek</a></li>
          <li><a href="#tab_4" data-toggle="tab">Legal Aspek</a></li>
          <li><a href="#tab_5" data-toggle="tab">Employee Detail</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            @include('usersupplier::partials.alert-errors')
            @include('usersupplier::partials.alert-message')
            @include('usersupplier::add.infovendor')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_2">
            @include('usersupplier::partials.alert-errors')
            @include('usersupplier::partials.alert-message')
            @include('usersupplier::add.datavendor')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_3">
            @include('usersupplier::partials.alert-errors')
            @include('usersupplier::partials.alert-message')
            @include('usersupplier::add.finansial')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_4">
            @include('usersupplier::partials.alert-errors')
            @include('usersupplier::partials.alert-message')
            @include('usersupplier::add.legalaspek')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_5">
            @include('usersupplier::partials.alert-errors')
            @include('usersupplier::partials.alert-message')
            @include('usersupplier::add.employeedetail')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
        @include('usersupplier::partials.logActivity')
      </div>
  </form>
@endsection
@push('scripts')
<script>
$(function () {
  $('.btnNext').click(function(){
   $('.nav-tabs > .active').next('li').find('a').trigger('click');
  });
  $('.btnPrevious').click(function(){
   $('.nav-tabs > .active').prev('li').find('a').trigger('click');
  });
  /*
  var type = '{!!$action_type!!}';
  if(type == "edit"){
    $('.direct-chat-messages').show();
  }
  */

  $(document).on('click', '.btn-sbm', function(event) {
    event.preventDefault();

    var formMe = $('#form-kontrak');
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
          data: new FormData(document.getElementById("form-kontrak")),
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
              if(response.status=="all"){
                window.location.href = "{{route('supplier.list')}}";
              }
            }
          }
        });
      }
    }
    });
  });
});
/*
$(function () {
  $('.btnNext').click(function(){
   $('.nav-tabs > .active').next('li').find('a').trigger('click');
  });
  $('.btnPrevious').click(function(){
   $('.nav-tabs > .active').prev('li').find('a').trigger('click');
  });

  var id = $('#id_supplier').val();
  var type = '{!!$action_type!!}';
  if(type=="lihat"){
    $('.form-control, .check-me').attr('disabled',true);
    $('.delete-atasan').hide();

    $(document).on('click', '.btn-approve', function(event) {
      event.preventDefault();
      var content = $('.content-view');
      var loading = content.find('.loading2');
      bootbox.prompt({
      title: "Masukan Komentar",
      inputType: 'textarea',
      callback: function (result) {
        if(result){
          loading.show();
          $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            url: '{!!route('supplier.editstatus')!!}',
            type: 'POST',
            dataType: 'JSON',
            data: {id: id,reason: result}
          })
          .done(function(data) {
            if(data.status){
              console.log("sukses");
              bootbox.alert({
                  title:"Pemberitahuan",
                  message: "Data berhasil disetujui",
                  callback: function (result) {
                      window.location = '{!!route('supplier',['status'=>'proses'])!!}'
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

    $(document).on('click', '.btn-return', function(event) {
      event.preventDefault();
      var content = $('.content-view');
      var loading = content.find('.loading2');
      bootbox.prompt({
      title: "Masukan Komentar",
      inputType: 'textarea',
      callback: function (result) {
        if(result){
          loading.show();
          $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            url: '{!!route('supplier.return')!!}',
            type: 'POST',
            dataType: 'JSON',
            data: {id: id,reason: result}
          })
          .done(function(data) {
            if(data.status == true){
              bootbox.alert({
                  title:"Pemberitahuan",
                  message: "Data berhasil dikembalikan",
                  callback: function (result) {
                      window.location = '{!!route('supplier',['status'=>'proses'])!!}'
                  }
              });
            }
            else if(data.status == false){
              console.log(data.msg);

              // reject(data.msg)
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
  }else if(type=="edit"){
     $('.form-control, .check-me').attr('disabled',false);
     $('.btn_edit').hide();
     $('.btn_btl').show();
     $('.komentar').show();
     //tombol dibawah
     $('.btn_smpn').show();
     $('.btn_apprv').hide();
  }else{
    $('.komentar').show();
    $('.btn_smpn').show();
  }

  $(document).on('click', '.btn-sbm', function(event) {
    event.preventDefault();

    var formMe = $('#form-kontrak');
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
            data: new FormData(document.getElementById("form-kontrak")),
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
                if(response.status=="all"){
                  window.location.href = "{{route('supplier',['status'=>'all'])}}";
                }
              }
            }
          });
        }
      }
    });
  });

});
*/
</script>
@endpush
