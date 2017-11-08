<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Jaminan dan Asuransi
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
        <div class="form-group ">
          <label class="col-sm-2 control-label">Jaminan Asuransi</label>
          <div class="col-sm-10 text-me">
            {{($doc->doc_jaminan=='PL')?'Pelaksana':''}}
            {{($doc->doc_jaminan=='PM')?'Pemeliharaan':''}}
          </div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nama Asuransi</label>
          <div class="col-sm-10 text-me">{{$doc->doc_asuransi or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nilai Jaminan</label>
          <div class="col-sm-10 text-me">{{$doc->doc_jaminan_nilai or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Tanggal Mulai</label>
          <div class="col-sm-10 text-me">{{$doc->doc_jaminan_startdate or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Tanggal Akhir</label>
          <div class="col-sm-10 text-me">{{$doc->doc_jaminan_enddate or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Keterangan</label>
          <div class="col-sm-10 text-me">{{$doc->doc_jaminan_desc or '-'}}</div>
        </div>

          @include('documents::partials.buttons-view')
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
