@extends('layouts.app')

@section('content')
    <div class="nav-tabs-custom content-view" style="position:relative;">
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
        <li class="active"><a href="#tab_1" data-toggle="tab">GENERAL INFO </a></li>

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
          <!-- <li><a href="#tab_5" data-toggle="tab">SCOPE PERUBAHAN</a></li> -->
        @else
          @if(!in_array($doc_type->name,['surat_pengikatan']))
            <li><a href="#tab_2" data-toggle="tab">{{$title_sow}}</a></li>
          @endif
        @endif

        @if(!in_array($doc_type->name,['amandemen_sp','amandemen_kontrak','adendum','side_letter','mou']) )
        <li><a href="#tab_3" data-toggle="tab">LATAR BELAKANG</a></li>
        @endif

        @if(in_array($doc_type->name,['turnkey','khs','amandemen_kontrak_khs','surat_pengikatan','mou']))
          <li><a href="#tab_4" data-toggle="tab">PASAL KHUSUS</a></li>
        @endif

        @if(in_array($doc_type->name,['turnkey','sp']))
          <li><a href="#tab_5" data-toggle="tab">JAMINAN DAN ASURANSI</a></li>
        @endif
      </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            @include('documents::partials.alert-errors')
            @if(in_array($doc_type->name,['turnkey','sp','khs','amandemen_kontrak_khs','surat_pengikatan','mou']))
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
            @if(in_array($doc_type->name,['turnkey','sp','khs','amandemen_kontrak_khs','mou']))
              @include('documents::doc-view.sow-boq')
            @elseif(in_array($doc_type->name,['amandemen_kontrak','amandemen_sp']))
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
            @if(in_array($doc_type->name,['turnkey','sp']))
              @include('documents::doc-view.jaminan-asuransi')
            @elseif(in_array($doc_type->name,['side_letter']))
              @include('documents::doc-view.side_letter-scope-perubahan')
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
          @include('documents::partials.comments')
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

$(document).on('click', '.btn-reject', function(event) {
  event.preventDefault();
  /* Act on the event */
  var btn = $(this);
  swal({
    // html: '<div class="form-group">\
    //         <label class="text-left">Masukan Alasan</label>\
    //         <textarea rows="6" class="form-control reason-text"></textarea>\
    //       </div>',
    title:'Masukan Komentar',
    input:'textarea',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Submit',
    cancelButtonText: 'Batal',
    showLoaderOnConfirm: true,
    preConfirm: function (text) {
       return new Promise(function (resolve, reject) {
         $.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
         $.ajax({
           url: '{!!route('doc.reject')!!}',
           type: 'POST',
           dataType: 'json',
           data: {id: '{!!$id!!}',reason: text}
         })
         .done(function(data) {
           if(data.status){
             $('meta[name="csrf-token"]').attr('content',data.csrf_token);
             $('.direct-chat-messages').find('.alert').remove();
             btn.parent().find('.btn-setuju').remove();
             btn.remove();
             $('.direct-chat-messages').append(template_comment(data.data));
             resolve();
           }
           else{
             reject(data.msg)
           }
         });

       })
    },
  }).then(function (text) {
    swal({
      type: 'success',
      html: 'Dokumen berhasil direject'
    })
  }, function (dismiss) {
    // dismiss can be 'cancel', 'overlay',
    // 'close', and 'timer'
    if (dismiss === 'cancel') {

    }
  })
});

$(document).on('click', '.btn-setuju', function(event) {
  event.preventDefault();
  var content = $('.content-view');
  var loading = content.find('.loading2');
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
    loading.hide();
  })
});
</script>
@endpush
