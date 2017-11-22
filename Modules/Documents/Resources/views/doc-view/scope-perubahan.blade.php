<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Scope Perubahan
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="col-sm-10">
        <div>
            @if(count($doc->scope_perubahan)>0)
            <table class="table table-condensed table-striped">
                <thead>
                  <tr>
                    <th width="30">No. </th>
                    <th width="150">Scope Perubahan</th>
                    <th width="150">Semula</th>
                    <th width="150">Diubah Menjadi</th>
                    <th width="300">Attachment</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($doc->scope_perubahan as $key=>$dt)
                    <tr>
                      <td>{{($key+1)}}</td>
                      <td>{{($dt->meta_name)}} </td>
                      <td>{{($dt->meta_title)}} </td>
                      <td>{{($dt->meta_desc)}} </td>
                      <td>@if(!empty($dt->meta_file))<a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_scope_perubahan'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
                      @else
                      -
                    @endif</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            @else
              <div class="alert alert-info text-center" role="alert">Tidak ada scope perubahan</div>
            @endif
          </div>
      </div>
    @include('documents::partials.buttons-view')
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
