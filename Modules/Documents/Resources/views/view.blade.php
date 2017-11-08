@extends('layouts.app')

@section('content')
    <div class="nav-tabs-custom content-view" style="position:relative;">
      <div class="loading2"></div>
      @php
        $title_sow = 'SOW,BOQ';
        if($doc_type->name=='khs'){
          $title_sow = 'DAFTAR HARGA SATUAN';
        }
      @endphp
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a></li>

        @if(in_array($doc_type->name,['amandemen_sp','amandemen_kontrak']))
          <li><a href="#tab_5" data-toggle="tab">SCOPE PERUBAHAN</a></li>
        @else
          <li><a href="#tab_2" data-toggle="tab">{{$title_sow}}</a></li>
        @endif

        <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>

        @if(in_array($doc_type->name,['turnkey','khs']))
          <li><a href="#tab_4" data-toggle="tab">PASAL PENTING</a></li>
        @endif

        @if(in_array($doc_type->name,['turnkey','sp']))
          <li><a href="#tab_5" data-toggle="tab">JAMINAN DAN ASURANSI</a></li>
        @endif
      </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            @include('documents::partials.alert-errors')
            @if($doc_type['title'] == "Amandemen SP" || $doc_type['title'] == "Amandemen Kontrak")
              @include('documents::doc-view.amademen')
            @else
              @include('documents::doc-view.general-info')
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
            @include('documents::doc-view.sow-boq')
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
            @include('documents::doc-view.latar-belakang')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_4">
            @include('documents::partials.alert-errors')
            @include('documents::doc-view.pasal-penting')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_5">
            @include('documents::partials.alert-errors')
            @if(in_array($doc_type->name,['amandemen_sp']))
              @include('documents::doc-view.scope-perubahan')
            @elseif(in_array($doc_type->name,['turnkey','sp']))
              @include('documents::doc-view.jaminan-asuransi')
            @else
              @include('documents::doc-view.scope-perubahan-others')
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
});
$(document).on('click', '.btn-setuju', function(event) {
  event.preventDefault();
  var content = $('.content-view');
  var loading = content.find('.loading2');
  bootbox.confirm({
    title:"Pemberitahuan",
    message: "Anda yakin sudah mengecek semua data?",
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
                url: '{!!route('doc.approve')!!}',
                type: 'POST',
                dataType: 'JSON',
                data: {id: '{!!$id!!}',}
              })
              .done(function(data) {
                if(data.status){
                  bootbox.alert({
                      title:"Pemberitahuan",
                      message: "Data berhasil disetujui",
                      callback: function (result) {
                          window.location = '{!!route('doc')!!}'
                      }
                  });
                }
                loading.hide();
              });
            }
        }
  });
});
</script>
@endpush
