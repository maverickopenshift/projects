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
          {{-- @include('documents::doc-form.side_letter-scope-perubahan') --}}
          @include('documents::doc-form.scope-perubahan-fix')
        @else
          {{-- @include('documents::doc-form.scope-perubahan-others') --}}
          @include('documents::doc-form.scope-perubahan-fix')
        @endif
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
            <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
          </div>
        </div>  <!-- /.tab-content -->
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary direct-chat direct-chat-primary">
          <div class="box-header with-border">
            <i class="fa fa-comments-o"></i>
            <h3 class="box-title">Comments</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body relative komentar formerror formerror-komentar">
              <div class="loading-ao"></div>
              <div id="alertBS"></div>
              <textarea class="form-control comment" rows="4" placeholder="Masukan Komentar" name="komentar">{{ old('komentar') }}</textarea>
              <div class="col-sm-10">
              <strong><div class="error error-komentar"></div></strong>
              </div>
          </div><!-- /.box-body -->
        </div><!--/.direct-chat -->
      </div>
    </div>
  </div>
</form>
<form id="form_me_boq" action="{{route('doc.upload.hs')}}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="file" name="daftar_harga" class="daftar_harga hide" accept=".csv,.xls,.xlsx">
  <input type="text" name="type" class="hide" value="{{$doc_type->name}}">
</form>
@endsection
@push('scripts')
<script>
$(function () {
  $('.datepicker').datepicker({
   format: 'dd-mm-yyyy',
   autoclose:true,
   todayHighlight:true
  });
  var data = $('.form-control').val();
  $('.btnNext').click(function(){
    $('.nav-tabs > .active').next('li').find('a').trigger('click');
  });
  $('.btnPrevious').click(function(){
    $('.nav-tabs > .active').prev('li').find('a').trigger('click');
  });

  $(document).on('click', '#btn-draft', function(event) {
    $('#statusButton').val('2');

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
        }
      }
    });


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
  });

});
</script>
@endpush
