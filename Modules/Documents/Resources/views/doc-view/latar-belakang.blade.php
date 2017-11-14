<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Latar Belakang
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @if(count($doc->latar_belakang)>0)
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
              <tr>
                  <th style="width:50px;">No.</th>
                  <th>Judul</th>
                  <th>Isi</th>
                  <th style="width:100px;">File</th>

              </tr>
            </thead>
            <tbody>

              @foreach ($doc->latar_belakang as $key=>$dt)
                <tr>
                  <td>{{($key+1)}}</td>
                  <td>{{($dt->meta_name)}} </td>
                  <td>{{($dt->meta_desc)}}</td>
                  <td>@if(!empty($dt->meta_file))<a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_latar_belakang'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
                  @else
                  -
                @endif</td>
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    @else
      <div class="alert alert-info text-center" role="alert">Tidak ada data</div>
    @endif
    @if(in_array($doc_type->name,['amandemen_sp','amandemen_kontrak','adendum','side_letter']))
      @include('documents::partials.buttons-view')
    @endif
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
