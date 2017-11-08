<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nomer {{$doc_type['title']}}</label>
          <div class="col-sm-10 text-me">{{$doc->doc_no or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Tanggal {{$doc_type['title']}}</label>
          <div class="col-sm-10 text-me">{{$doc->doc_date or '-'}}</div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Pihak I</label>
          <div class="col-sm-10 text-me">{{$doc->doc_pihak1}}</div>
        </div>
        <div class="form-group">
          <label for="ttd_pihak1" class="col-sm-2 control-label">Penandatangan Pihak I</label>
          <div class="col-sm-10 text-me">{{$doc->doc_pihak1_nama}}</div>
        </div>
        <div class="form-group">
          <label for="akte_awal_tg" class="col-sm-2 control-label">Pihak II</label>
          <div class="col-sm-10 text-me">{{$doc->supplier->bdn_usaha.'.'.$doc->supplier->nm_vendor}}</div>
        </div>
        <div class="form-group">
          <label for="ttd_pihak2" class="col-sm-2 control-label">Penandatangan Pihak II</label>
          <div class="col-sm-10 text-me">{{$doc->doc_pihak2_nama}}</div>
        </div>
        <div class="form-group">
          <label for="ttd_pihak2" class="col-sm-2 control-label">Lampiran 1 <br/><small style="font-weight:normal" class="text-info"><i>(Lembar Tanda Tangan)</i></small></label>
          <div class="col-sm-10 text-me">
            @if(!empty($doc->doc_lampiran))
                <a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$doc->doc_lampiran,'type'=>$doc_type['name']])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
            @endif
          </div>
        </div>
          {{-- @include('documents::partials.buttons') --}}
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
})
</script>
@endpush
