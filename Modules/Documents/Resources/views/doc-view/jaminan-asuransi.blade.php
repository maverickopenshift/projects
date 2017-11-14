<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Jaminan dan Asuransi</h3>
      <div class="pull-right attr-btn">
        <button type="button" class="btn btn-success btn-xs add-asre"><i class="glyphicon glyphicon-plus"></i> tambah</button>
      </div>
    </div>

    <div class="box-body form-asr">
    @if(count($doc->asuransi)>0)
@foreach ($doc->asuransi as $key=>$dt)
    <div class="form-horizontal form1">
      <div class="form-group text-right top10 tombol">
        </div>
        <div class="form-group">
          <label for="doc_jaminan" class="col-sm-2 control-label"><span class="text-red">*</span> Jenis Jaminan</label>
          <div class="col-sm-10 text-me">{{$dt->doc_jaminan or '-'}}</div>
        </div>
        <div class="form-group">
          <label for="doc_asuransi" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Asuransi</label>
          <div class="col-sm-10 text-me">{{$dt->doc_jaminan_name or '-'}}</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_nilai" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Jaminan</label>
          <div class="col-sm-10 text-me">{{$dt->doc_jaminan_nilai or '-'}}</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_startdate" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai</label>
          <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($dt->doc_jaminan_startdate)->format('l, d F Y')}}</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_enddate" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir</label>
          <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($dt->doc_jaminan_enddate)->format('l, d F Y')}}</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_desc" class="col-sm-2 control-label">Keterangan</label>
          <div class="col-sm-10 text-me">{{$dt->doc_jaminan_desc or '-'}}</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan_file" class="col-sm-2 control-label">File <br/><small class="text-danger" style="font-style:italic;font-weight:normal;">(optional)</small></label>
          @if(!empty($dt->doc_jaminan_file))<a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$dt->doc_jaminan_file,'type'=>$doc_type['name'].'_asuransi'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
          @else
          -
        @endif
        </div>
    </div>
    @endforeach
  @endif
      @include('documents::partials.buttons-view')
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
</script>
@endpush
