@extends('layouts.app')

@section('content')


    <form action="{{route('doc.closing.store',['id'=>$id])}}" class="form-kontrak" name="feedback" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="nav-tabs-custom ">
      <div class="loading2"></div>
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a></li>
        <li class=""><a href="#tab_2" data-toggle="tab">LAMPIRAN </a></li>
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
          <div class="tab-pane" id="tab_2">
            @include('documents::partials.alert-errors')
            @include('documents::doc-closing.lampiran')
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
});

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
</script>
@endpush
