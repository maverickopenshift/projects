@extends('layouts.app')

@section('content')


    <form action="#" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="nav-tabs-custom">
      @if($doc_type['title'] == "Turnkey")
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a></li>
          <li><a href="#tab_2" data-toggle="tab">SOW,BOQ</a></li>
          <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
          <li><a href="#tab_4" data-toggle="tab">PASAL PENTING</a></li>
          <li><a href="#tab_5" data-toggle="tab">JAMINAN DAN ASURANSI</a></li>
        </ul>
      @endif
      @if($doc_type['title'] == "KHS")
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a></li>
          <li><a href="#tab_2" data-toggle="tab">DAFTAR HARGA SATUAN</a></li>
          <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
          <li><a href="#tab_4" data-toggle="tab">PASAL PENTING</a></li>
        </ul>
      @endif
      @if($doc_type['title'] == "SP")
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a></li>
          <li><a href="#tab_2" data-toggle="tab">SOW,BOQ</a></li>
          <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
          <li><a href="#tab_4" data-toggle="tab">JAMINAN</a></li>
        </ul>
      @endif
      @if($doc_type['title'] == "Amandemen SP" || $doc_type['title'] == "Amandemen Kontrak")
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a></li>
          <li><a href="#tab_5" data-toggle="tab">SCOPE PERUBAHAN</a></li>
          <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
        </ul>
      @endif

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            @if($doc_type['title'] == "Amandemen SP" || $doc_type['title'] == "Amandemen Kontrak")
              @include('documents::doc-form.amademen')
            @else
              @include('documents::doc-form.general-info')
            @endif
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_2">
            @include('documents::doc-form.sow-boq')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_3">
            @include('documents::doc-form.latar-belakang')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_4">
            @include('documents::doc-form.pasal-penting')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_5">
            @include('documents::doc-form.jaminan-asuransi')
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
  $('.btnNext').click(function(){
   $('.nav-tabs > .active').next('li').find('a').trigger('click');
  });
  $('.btnPrevious').click(function(){
   $('.nav-tabs > .active').prev('li').find('a').trigger('click');
  });
});
</script>
@endpush
