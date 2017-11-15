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
        @include('documents::doc-view.general-info-right')
        <div class="form-group">
          <label for="ttd_pihak2" class="col-sm-2 control-label">Lampiran 1 <br/><small style="font-weight:normal" class="text-info"><i>(Lembar Tanda Tangan)</i></small></label>
          <div class="col-sm-5">
            <div class="parent-pictable">
                <table class="table table-condensed table-striped">
                    <thead>
                      <tr>
                        <th>Lampiran Ke</th>
                        <th>Lihat</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($doc->lampiran_ttd as $key=>$dt)
                        <tr>
                          <td>{{($key+1)}}</td>
                          <td>@if(!empty($dt->meta_file))<a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_lampiran_ttd'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
                          @else
                          -
                        @endif</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
              </div>
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
