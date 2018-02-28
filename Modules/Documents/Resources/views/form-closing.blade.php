@extends('layouts.app')

@section('content')
<form action="{{route('doc.closing.store_ajax',['id'=>$id])}}" id="form-kontrak" name="feedback" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="nav-tabs-custom ">
    <div class="loading2"></div>
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab">KELENGKAPAN DOKUMEN </a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
        @include('documents::partials.alert-errors')
        @include('documents::doc-closing.general-info')
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
@push('scripts')
<script>
$(function () {
  var data = $('.form-control').val();
  $('.btnNext').click(function(){
   $('.nav-tabs > .active').next('li').find('a').trigger('click');
  });
  $('.btnPrevious').click(function(){
   $('.nav-tabs > .active').prev('li').find('a').trigger('click');
  });
});

/*
$(document).on('click', '#btn-submit', function(event) {
  event.preventDefault();
  var content = $('.nav-tabs-custom');
  var loading = content.find('.loading2');
  bootbox.confirm({
    title:"Konfirmasi",
    message: "Apakah anda yakin untuk menutup dokumen ini?",
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
        loading.show();
        $('.btn_submit').click();
    }
    }
  });
});
*/

  $(document).on('click', '#btn-submit', function(event) {
    $('#statusButton').val('0');
    event.preventDefault();
    var content = $('.content-view');
    var loading = content.find('.loading2');

    var formMe = $('#form-kontrak');
    $(".formerror").removeClass("has-error");
    $(".error").html('');

    bootbox.confirm({
      title:"Konfirmasi",
      message: "Apakah anda yakin untuk menutup dokumen ini?",
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
              if(response.status=="tutup"){
                window.location.href = "{{route('doc',['status'=>'tutup'])}}";
              }
            }
          }
        });                
      }
    });
  });
</script>
@endpush
