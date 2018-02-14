@extends('layouts.app')

@section('content')
<form action="{{route('doc.store_ajax',['type'=>$doc_type->name])}}" id="form-kontrak" name="feedback" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
  <div class="nav-tabs-custom">
    <div class="loading2"></div>
    @php
      $title_sow = 'SoW,BoQ';
      if($doc_type->name=='khs' || $doc_type->name=='amandemen_kontrak_khs'){
        $title_sow = 'DAFTAR HARGA SATUAN';
      }elseif($doc_type->name=='mou'){
        $title_sow = 'RUANG LINGKUP';
      }
    @endphp
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a>
      <input type="hidden" id="statusButton" name="statusButton"></li>
      @if(in_array($doc_type->name,['amandemen_sp','amandemen_kontrak','amandemen_kontrak_khs','amandemen_kontrak_turnkey','adendum','side_letter']))
        @if(in_array($doc_type->name,['amandemen_kontrak','amandemen_kontrak_khs','amandemen_kontrak_turnkey']))
          <li><a href="#tab_2" data-toggle="tab">{{$title_sow}}</a></li>
          <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
          <li><a href="#tab_5" data-toggle="tab">SCOPE PERUBAHAN</a></li>
        @elseif(in_array($doc_type->name,['amandemen_sp']))
          <li><a href="#tab_2" data-toggle="tab">{{$title_sow}}</a></li>
          <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
        @else
          <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
          <li><a href="#tab_5" data-toggle="tab">SCOPE PERUBAHAN</a></li>
        @endif
      @else
        @if(!in_array($doc_type->name,['surat_pengikatan']))
          <li><a href="#tab_2" data-toggle="tab">{{$title_sow}}</a></li>
        @endif
      @endif

      @if(!in_array($doc_type->name,['amandemen_sp','amandemen_kontrak','amandemen_kontrak_khs','amandemen_kontrak_turnkey','adendum','side_letter','mou']))
        <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
      @endif

      @if(in_array($doc_type->name,['khs','turnkey','surat_pengikatan','mou']))
        <li><a href="#tab_4" data-toggle="tab">PASAL KHUSUS</a></li>
      @endif

      @if(in_array($doc_type->name,['turnkey','sp']))
        <li><a href="#tab_5" data-toggle="tab">JAMINAN DAN ASURANSI</a></li>
      @endif
    </ul>

    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
        @include('documents::partials.alert-errors')
        @if(in_array($doc_type->name,['turnkey','sp','khs','surat_pengikatan','mou']))
          @include('documents::doc-form.general-info')
        @else
          @include('documents::doc-form.amademen')
        @endif
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="tab-pane" id="tab_2">
        @include('documents::partials.alert-errors')
        @if(in_array($doc_type->name,['turnkey','sp','khs','mou','amandemen_kontrak','amandemen_kontrak_turnkey','amandemen_kontrak_khs']))
          @include('documents::doc-form.sow-boq')
        @elseif(in_array($doc_type->name,['amandemen_sp']))  
          @include('documents::doc-form.amandemen_kontrak-sow-boq')
        @endif
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
            <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="tab-pane ok" id="tab_3">
        @include('documents::partials.alert-errors')
        {{--
        @if(in_array($doc_type->name,['surat_pengikatan']))
          @include('documents::doc-form.surat_pengikatan-latar-belakang')
        @elseif(!in_array($doc_type->name,['mou']))
          @include('documents::doc-form.latar-belakang')
        @endif
        --}}
        @include('documents::doc-form.latar-belakang-fix')
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
            <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
          </div>
        </div>
      </div>

      @if(in_array($doc_type->name,['khs','turnkey','surat_pengikatan','mou']))
      <div class="tab-pane" id="tab_4">
        @include('documents::partials.alert-errors')
        @include('documents::doc-form.pasal-penting')
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
            <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
          </div>
        </div>
      </div>
      @endif

      <div class="tab-pane" id="tab_5">
        @include('documents::partials.alert-errors')
        @if(in_array($doc_type->name,['turnkey','sp']))
          @include('documents::doc-form.jaminan-asuransi')
        @elseif(in_array($doc_type->name,['side_letter']))
          @include('documents::doc-form.side_letter-scope-perubahan')
        @else
          @include('documents::doc-form.scope-perubahan-others')
        @endif
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
            <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.tab-content -->
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

  $(document).on('click', '#btn-draft', function(event) {
    $('#statusButton').val('2');
  });

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
          bootbox.prompt({
            title: "Masukan Komentar",
            inputType: 'textarea',
            callback: function (komen) {
              if(komen){
                loading.show();
                $('.komentar').val(komen);
                //$('.btn_submit').click();
                
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
                        if(response.status=="tracking"){
                          window.location.href = "{{route('doc',['status'=>'tracking'])}}";
                        }else if(response.status=="draft"){
                          window.location.href = "{{route('doc',['status'=>'draft'])}}";
                        }
                      }
                    }
                  });
                
                ////// end ajax
              }
            }
          });
        }
      }
    });
  });

  /*
  $(document).on('submit','#form-me-uploadboq',function (event) {
    var btnSave = formMe.find('.btn-simpan')
    btnSave.button('loading')

    $.ajax({
      url: formMe.attr('action'),
      type: 'post',
      data: formMe.serialize(),
      dataType: 'json',
      success: function(response){
        if(response.errors){

        }
      }
    });
  });

  $('.daftar_harga').on('change', function(event) {
    event.stopPropagation();
    event.preventDefault();
    var validfile = [".csv", ".xls", ".xlsx"];
    var namefile = $('.daftar_harga').val().split('\\').pop();
    var valid = 0;

    for (var i = 0; i < validfile.length; i++) {
      var validfilex=validfile[i];

      if (namefile.substr(namefile.length - validfilex.length, validfilex.length).toLowerCase() == validfilex.toLowerCase()) {
        valid = 1;
        break;
      }
    }

    if(valid==1){
      handleDaftarHargaFileSelect(this.files[0]);
    }else{
      $('.error-daftar_harga').html('Format File tidak valid! hanya CSV, XLS & XLXS yang valid');
    }
  });
  */

});
</script>
@endpush
