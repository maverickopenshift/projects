@extends('layouts.app')
@section('content')
    <div class="nav-tabs-custom content-view" style="position:relative;">
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
        <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a></li>

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

        @if(!in_array($doc_type->name,['amandemen_sp','amandemen_kontrak','amandemen_kontrak_khs','amandemen_kontrak_turnkey','adendum','side_letter','mou']) )
        <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
        @endif

        @if(in_array($doc_type->name,['turnkey','khs','surat_pengikatan','mou']))
          <li><a href="#tab_4" data-toggle="tab">PASAL KHUSUS</a></li>
        @endif

        @if(in_array($doc_type->name,['turnkey','sp']))
          <li><a href="#tab_5" data-toggle="tab">JAMINAN DAN ASURANSI</a></li>
        @endif

        @if(in_array($doc_type->name,['turnkey','amandemen_kontrak_turnkey']))
          <li><a href="#tab_6" data-toggle="tab">TERM OF PAYMENT</a></li>
        @endif
      </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            @include('documents::partials.alert-errors')
            @if(in_array($doc_type->name,['turnkey','sp','khs','surat_pengikatan','mou']))
              @include('documents::doc-view.general-info')
            @else
              @include('documents::doc-view.amademen')
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
            @if(in_array($doc_type->name,['turnkey','sp','khs','mou']))
              @include('documents::doc-view.sow-boq')
            @elseif(in_array($doc_type->name,['amandemen_kontrak','amandemen_kontrak_khs','amandemen_kontrak_turnkey']))
              @include('documents::doc-view.sow-boq')
            @elseif(in_array($doc_type->name,['amandemen_sp']))
              @include('documents::doc-view.amandemen_kontrak-sow-boq')
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
            @include('documents::doc-view.latar-belakang-fix')
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
            @if(in_array($doc_type->name,['turnkey','sp']))
              @include('documents::doc-view.jaminan-asuransi')
            @elseif(in_array($doc_type->name,['side_letter']))
              @include('documents::doc-view.scope-perubahan-fix')
            @else
              @include('documents::doc-view.scope-perubahan-fix')
            @endif
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info btnPrevious" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
                <a class="btn btn-info btnNext pull-right" >Selanjutnya <i class="glyphicon glyphicon-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <div class="tab-pane" id="tab_6">
            @include('documents::partials.alert-errors')
            @if(in_array($doc_type->name,['turnkey','amandemen_kontrak_turnkey']))
              @include('documents::doc-view.term-of-payment')
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
          @include('documents::partials.comments')
      </div>
@endsection
@push('scripts')
<script>
$(function () {
  $('.btn-setuju').prop('disabled', true);
  $('.btn-reject').prop('disabled', true);

  $('.btnNext').click(function(){
   $('.nav-tabs > .active').next('li').find('a').trigger('click');
  });
  $('.btnPrevious').click(function(){
   $('.nav-tabs > .active').prev('li').find('a').trigger('click');
  });
});

$(document).on('click', '.disclaimer', function(event) {
  if($(this).is(':checked')) {
    $('.disclaimer').prop('checked',true);
    $('.btn-setuju').prop('disabled', false);
    $('.btn-reject').prop('disabled', false);
  }else{
    $('.btn-setuju').prop('disabled', true);
    $('.btn-reject').prop('disabled', true);
    $('.disclaimer').prop('checked',false);
  }
});
$(document).on('click', '.btn-reject', function(event) {
  event.preventDefault();
  var content = $('.content-view');
  var loading = content.find('.loading2');
  var no_kontrak = '{{$doc->doc_no}}';
  bootbox.confirm({
    title:"Konfirmasi",
    message: "Apakah Anda Yakin Ingin Mengembalikan Dokumen ini?",
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
              bootbox.prompt({
              title: "Masukan Komentar",
              inputType: 'textarea',
              callback: function (komen) {
                if(komen){
                  loading.show();
                  $.ajaxSetup({
                    headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $.ajax({
                    url: '{!!route('doc.reject')!!}',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: '{!!$id!!}',reason: komen, no_kontrak: no_kontrak}
                  })
                  .done(function(data) {
                    if(data.status){
                      bootbox.alert({
                          title:"Pemberitahuan",
                          message: "Data berhasil dikembalikan",
                          callback: function (result) {
                              window.location = '{!!route('doc',['status'=>'selesai'])!!}'
                          }
                      });
                    }
                    loading.hide();
                })
              }
            }
          });
        }
      }
    });
  });

$(document).on('click', '.btn-setuju', function(event) {
  event.preventDefault();
  var content = $('.content-view');
  var loading = content.find('.loading2');
  var no_kontrak = '{{$doc->doc_no}}';
  if(no_kontrak == ""){
  $.ajax({
    url: '{!!route('doc.getKontrak')!!}',
    type: 'GET',
    dataType: 'JSON',
    data: {id: '{!!$id!!}',}
  }).done(function(data) {
    if(data.status){
      bootbox.confirm({
        size:"large",
        title:"Konfirmasi",
        message: "Pastikan Data Yang Anda Masukkan Sudah Benar.<br><br>"+
        "Nomor Kontrak: <strong>"+data.doc_no+"</strong><br>"+
        "Judul Kontrak: <strong>"+data.data.judul+"</strong><br>"+
        "Nama Penandatangan/NIK/Jabatan: <strong>"+data.data.nama_pgw+"/"+data.data.nik+"/"+data.data.jabatan+"</strong><br>"+
        "Loker: <strong>"+data.data.loker+"/"+data.data.nama_loker+"</strong><br>",
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
                  bootbox.prompt({
                  title: "Masukan Komentar",
                  inputType: 'textarea',
                  callback: function (komen) {
                    if(komen){
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
                    data: {id: '{!!$id!!}',komentar: komen, no_kontrak: no_kontrak}
                  })
                  .done(function(data) {
                    if(data.status){
                      bootbox.alert({
                          title:"Pemberitahuan",
                          message: "Data berhasil disetujui",
                          callback: function (result) {
                              window.location = '{!!route('doc',['status'=>'selesai'])!!}'
                          }
                      });
                    }
                    loading.hide();
                  })
                  .always(function(){
                    loading.hide();
                  });
                }
              }
            });
            }
          }
      });
    }
    loading.hide();
  })
}else{
  var judul_kontrak = '{{$doc->doc_title}}';
  var nm_pihak1 = '{{$pegawai_pihak1->v_nama_karyawan}}';
  var nik_pihak1 = '{{$pegawai_pihak1->n_nik}}';
  var jbtn_pihak1 = '{{$pegawai_pihak1->v_short_posisi}}';
  var loker = '{{$pegawai_pihak1->c_kode_unit}}';
  var nm_loker = '{{$pegawai_pihak1->v_short_unit}}';
  bootbox.confirm({
    size:"large",
    title:"Konfirmasi",
    message: "Pastikan Data Yang Anda Masukkan Sudah Benar.<br><br>"+
    "Nomor Kontrak: <strong>"+no_kontrak+"</strong><br>"+
    "Judul Kontrak: <strong>"+judul_kontrak+"</strong><br>"+
    "Nama Penandatangan/NIK/Jabatan: <strong>"+nm_pihak1+"/"+nik_pihak1+"/"+jbtn_pihak1+"</strong><br>"+
    "Loker: <strong>"+loker+"/"+nm_loker+"</strong><br>",
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
              bootbox.prompt({
              title: "Masukan Komentar",
              inputType: 'textarea',
              callback: function (komen) {
                if(komen){
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
                data: {id: '{!!$id!!}',komentar: komen, no_kontrak: no_kontrak}
              })
              .done(function(data) {
                if(data.status){
                  bootbox.alert({
                      title:"Pemberitahuan",
                      message: "Data berhasil disetujui",
                      callback: function (result) {
                          window.location = '{!!route('doc',['status'=>'selesai'])!!}'
                      }
                  });
                }
                loading.hide();
              })
              .always(function(){
                loading.hide();
              });
            }
          }
        });
        }
      }
  });
}

});
</script>
@endpush
