<div class="box">
  <div class="box-body form-asr">
  @if(count($doc->latar_belakang_rks)>0)
    @foreach ($doc->latar_belakang_rks as $key=>$dt)
      <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
              RKS
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
            <div class="col-sm-10 text-me">RKS</div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal</label>
            <div class="col-sm-10 text-me">
              @if(isset($dt->meta_desc))
                {{Carbon\Carbon::parse($dt->meta_desc)->format('l, d F Y')}}
              @else
              -
              @endif
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Lampiran</label>
            <div class="col-sm-10 text-me">
              @if(!empty($dt->meta_file))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang_rks'])}}">
                  <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                </a>
                <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang_rks'])}}?nik={{$pegawai->n_nik}}&nama={{$pegawai->v_nama_karyawan}}">
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

  @if(count($doc->latar_belakang_ketetapan_pemenang)>0)
    @foreach ($doc->latar_belakang_ketetapan_pemenang as $key=>$dt)
      <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
              Ketetapan Pemenang
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
            <div class="col-sm-10 text-me">Ketetapan Pemenang</div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal</label>
            <div class="col-sm-10 text-me">
              @if(isset($dt->meta_desc))
                {{Carbon\Carbon::parse($dt->meta_desc)->format('l, d F Y')}}
              @else
              -
              @endif
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Lampiran</label>
            <div class="col-sm-10 text-me">
              @if(!empty($dt->meta_file))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang_ketetapan_pemenang'])}}">
                  <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                </a>
                <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang_ketetapan_pemenang'])}}?nik={{$pegawai->n_nik}}&nama={{$pegawai->v_nama_karyawan}}">
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

  @if(count($doc->latar_belakang_kesanggupan_mitra)>0)
    @foreach ($doc->latar_belakang_kesanggupan_mitra as $key=>$dt)
      <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
              Kesanggupan Mitra
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
            <div class="col-sm-10 text-me">Kesanggupan Mitra</div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal</label>
            <div class="col-sm-10 text-me">
              @if(isset($dt->meta_desc))
                {{Carbon\Carbon::parse($dt->meta_desc)->format('l, d F Y')}}
              @else
              -
              @endif
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Lampiran</label>
            <div class="col-sm-10 text-me">
              @if(!empty($dt->meta_file))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang_kesanggupan_mitra'])}}">
                  <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                </a>
                <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang_kesanggupan_mitra'])}}?nik={{$pegawai->n_nik}}&nama={{$pegawai->v_nama_karyawan}}">
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

  @if(count($doc->latar_belakang_optional)>0)
    @foreach ($doc->latar_belakang_optional as $key=>$dt)
      <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
              Lain-lain
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
            <div class="col-sm-10 text-me">{{$dt->meta_name}}</div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal</label>
            <div class="col-sm-10 text-me">
              @if(isset($dt->meta_title))
                {{Carbon\Carbon::parse($dt->meta_title)->format('l, d F Y')}}
              @else
              -
              @endif
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Isi</label>
            <div class="col-sm-10 text-me">
              {{$dt->meta_desc or '-'}}
            </div>
          </div>

          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Lampiran</label>
            <div class="col-sm-10 text-me">
              @if(!empty($dt->meta_file))
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang_optional'])}}">
                  <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                </a>
                <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang_optional'])}}?nik={{$pegawai->n_nik}}&nama={{$pegawai->v_nama_karyawan}}">
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
