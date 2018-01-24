@extends('layouts.app')

@section('content')


    <form action="{{route('doc.store',['type'=>$doc_type->name])}}" class="form-kontrak" name="feedback" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="nav-tabs-custom">
      <div class="loading2"></div>
      @php
        $title_sow = 'SOW,BOQ';
        if($doc_type->name=='khs' || $doc_type->name=='amandemen_kontrak_khs'){
          $title_sow = 'DAFTAR HARGA SATUAN';
        }elseif($doc_type->name=='mou'){
          $title_sow = 'RUANG LINGKUP';
        }
      @endphp
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a>
        <input type="hidden" id="statusButton" name="statusButton"></li>
        @if(in_array($doc_type->name,['amandemen_sp','amandemen_kontrak','adendum','side_letter']))
          @if(in_array($doc_type->name,['amandemen_kontrak']))
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

        @if(!in_array($doc_type->name,['amandemen_sp','amandemen_kontrak','adendum','side_letter','mou']))
        <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
        @endif

        @if(in_array($doc_type->name,['khs','amandemen_kontrak_khs','turnkey','amandemen_kontrak_turnkey','surat_pengikatan','mou']))
          <li><a href="#tab_4" data-toggle="tab">PASAL KHUSUS</a></li>
        @endif

        @if(in_array($doc_type->name,['turnkey','amandemen_kontrak_turnkey','sp']))
          <li><a href="#tab_5" data-toggle="tab">JAMINAN DAN ASURANSI</a></li>
        @endif
      </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            @include('documents::partials.alert-errors')
            @if(in_array($doc_type->name,['turnkey','amandemen_kontrak_turnkey','sp','khs','amandemen_kontrak_khs','surat_pengikatan','mou']))
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
            @if(in_array($doc_type->name,['turnkey','amandemen_kontrak_turnkey','sp','khs','amandemen_kontrak_khs','mou']))
              @include('documents::doc-form.sow-boq')
            @elseif(in_array($doc_type->name,['amandemen_kontrak','amandemen_sp']))
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

            @if(in_array($doc_type->name,['surat_pengikatan']))
              @include('documents::doc-form.surat_pengikatan-latar-belakang')
            @elseif(!in_array($doc_type->name,['mou']))
              @include('documents::doc-form.latar-belakang')
            @endif

            {{--
            @include('documents::doc-form.latar-belakang-fix')
            --}}
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          @if(in_array($doc_type->name,['khs','amandemen_kontrak_khs','turnkey','amandemen_kontrak_turnkey','surat_pengikatan','mou']))
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
            @if(in_array($doc_type->name,['turnkey','amandemen_kontrak_turnkey','sp']))
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

  // $(document).on('click', '#btn-submit', function(event) {

// if(document.feedback.field.value == ""){
//   console.log("kosong coy");
// }
//
//   });

  $(document).on('click', '#btn-submit', function(event) {
    $('#statusButton').val('0');
    event.preventDefault();
    var content = $('.content-view');
    var loading = content.find('.loading2');
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
            $('.btn_submit').click();
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
