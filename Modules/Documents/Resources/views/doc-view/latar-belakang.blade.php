<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Latar Belakang
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
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

              @foreach ($meta_lt as $key=>$dt)
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
    {{-- @include('documents::partials.buttons-view') --}}
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
