<div class="box">
  <div class="box-body form-asr">

  @if(count($doc->scope_perubahan_side_letter)>0)
    @foreach ($doc->scope_perubahan_side_letter as $key=>$dt)
      <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
              Pasal {{($key+1)}}
            </div>
          </div>
            
          <div class="form-group">
            <label for="doc_jaminan" class="col-sm-2 control-label">Pasal</label>
            <div class="col-sm-10 text-me">{{$dt->meta_pasal}}</div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
            <div class="col-sm-10 text-me">{{$dt->meta_judul}}</div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Isi</label>
            <div class="col-sm-10 text-me">
              {{$dt->meta_isi or '-'}}
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Semula</label>
            <div class="col-sm-10 text-me">
              {{$dt->meta_awal or '-'}}
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Diubah Menjadi</label>
            <div class="col-sm-10 text-me">
              {{$dt->meta_akhir or '-'}}
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Lampiran</label>
            <div class="col-sm-10 text-me">
              @if(!empty($dt->meta_file))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_scope_perubahan'])}}">
                <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran </a>
                <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_scope_perubahan'])}}?nik={{$pegawai->n_nik}}&nama={{$pegawai->v_nama_karyawan}}">
                <i class="glyphicon glyphicon-download-alt"></i>  Download
                </a>
              @else
                -
              @endif
            </div>
          </div>
      </div>
    @endforeach
  @endif

  @include('documents::partials.buttons-view')
  </div>
</div>
@push('scripts')
<script>
</script>
@endpush
