@extends('layouts.app')

@section('content')
  <form action="#" method="get" id="form-me">
    {{ csrf_field() }}
    @if ($errors->has('error'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      {{ $errors->first('error') }}
    </div>
    @endif
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">Informasi Vendor</a></li>
          <li><a href="#tab_2" data-toggle="tab">Data Vendor</a></li>
          <li><a href="#tab_3" data-toggle="tab">Finansial Aspek</a></li>
          <li><a href="#tab_4" data-toggle="tab">Legal Aspek</a></li>
          <li><a href="#tab_5" data-toggle="tab">Employee Detail</a></li>
          <li><a href="#tab_6" data-toggle="tab">Log Notifikasi</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
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
            @include('usersupplier::add.employeedetail')
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_6">hi
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <button type="submit" class="btn btn-info pull-right">Simpan</button>

              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
  </form>
  <div class="modal fade" role="dialog" id="form-modal">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Success</h4>
              </div>
              <div class="modal-body">
                <p>Data berhasil tersimpan</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reload(); return false;">Close</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
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

var formModal = $('#form-modal');

  $(document).on('submit','#form-me',function (event) {
    event.preventDefault();
    var formMe = $(this)
    var isi = formMe.serialize();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{url('usersupplier/tambah')}}",
        type: 'get',
        data: formMe.serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){

                $('#form-modal').modal('show')
        },
        error: function( _response ){
          alert("error1");
          // console.log(isi);
        }
    });
    })
});

</script>
@endpush
