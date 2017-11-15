<div class="box">

    <div class="box-body form-asr">
    @if(count($doc->asuransi)>0)
@foreach ($doc->asuransi as $key=>$dt)
  <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Jaminan dan Asuransi <span class="total_asu">{{$key+1}}</span></div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">Jenis Jaminan</label>
        <div class="col-sm-10 text-me">{{$dt->doc_jaminan or '-'}}</div>
      </div>
      <div class="form-group">
        <label for="doc_asuransi" class="col-sm-2 control-label">Nama Asuransi</label>
        <div class="col-sm-10 text-me">{{$dt->doc_jaminan_name or '-'}}</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan_nilai" class="col-sm-2 control-label">Nilai Jaminan</label>
        <div class="col-sm-10 text-me">{{$dt->doc_jaminan_nilai or '-'}}</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal Mulai</label>
        <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($dt->doc_jaminan_startdate)->format('l, d F Y')}}</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan_enddate" class="col-sm-2 control-label">Tanggal Akhir</label>
        <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($dt->doc_jaminan_enddate)->format('l, d F Y')}}</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan_desc" class="col-sm-2 control-label">Keterangan</label>
        <div class="col-sm-10 text-me">{{$dt->doc_jaminan_desc or '-'}}</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan_file" class="col-sm-2 control-label">File</label>
        @if(!empty($dt->doc_jaminan_file))<a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$dt->doc_jaminan_file,'type'=>$doc_type['name'].'_asuransi'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
        @else
        -
      @endif
      </div>
  </div>
    @endforeach
  @else
    <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Jaminan dan Asuransi</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan" class="col-sm-2 control-label">Jenis Jaminan</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_asuransi" class="col-sm-2 control-label">Nama Asuransi</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_nilai" class="col-sm-2 control-label">Nilai Jaminan</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal Mulai</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_enddate" class="col-sm-2 control-label">Tanggal Akhir</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_desc" class="col-sm-2 control-label">Keterangan</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_file" class="col-sm-2 control-label">File</label>
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
