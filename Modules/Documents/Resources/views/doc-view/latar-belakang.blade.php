<div class="box">
  <div class="box-body form-asr">
  @if(in_array($doc_type->name,['turnkey','khs']))
    @include('documents::doc-view.latar_belakang_2')
  @endif
  @if(count($doc->latar_belakang)>0)
    @foreach ($doc->latar_belakang as $key=>$dt)
      <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
            @if($doc_type->name=="surat_pengikatan")
              {{ $dt->meta_name }} <span class=""></span>
            @else
              {{$dt->meta_name}}
            @endif
            </div>
          </div>
          <div class="form-group">
            <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
            <div class="col-sm-10 text-me">{{$dt->meta_name or '-'}}</div>
          </div>
          <div class="form-group">
            <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal</label>
            <div class="col-sm-10 text-me">
              @if(isset($dt->meta_desc))
                {{Carbon\Carbon::parse($dt->meta_desc)->format('l, d F Y')}}
              @else - @endif
            </div>
          </div>
          <div class="form-group">
            <label for="doc_jaminan_file" class="col-sm-2 control-label">File</label>
            @if(!empty($dt->meta_file))
            <!--
            <a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
            -->
            <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang'])}}">
            <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
            </a>
            @else
            -
          @endif
          </div>
      </div>
    @endforeach
  @else
    <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Surat Penetapan Pemenang
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Judul</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_asuransi" class="col-sm-2 control-label">Tanggal</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_nilai" class="col-sm-2 control-label">File</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
    </div>
    <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Surat Kesanggupan Mitra
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Judul</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_asuransi" class="col-sm-2 control-label">Tanggal</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_nilai" class="col-sm-2 control-label">File</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
    </div>
  @endif
  @include('documents::partials.buttons-view')
  </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
</script>
@endpush
