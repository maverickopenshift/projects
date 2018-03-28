<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Scope Perubahan
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="col-sm-12">
        <div>
            @if(count($doc->scope_perubahan_side_letter)>0)
            <table class="table table-condensed table-striped">
                <thead>
                  <tr>
                    <th width="30">No. </th>
                    <th width="150">Pasal</th>
                    <th width="150">Judul</th>
                    <th width="150">Isi</th>
                    <th width="150">Semula</th>
                    <th width="150">Diubah Menjadi</th>
                    <th width="300">Attachment</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($doc->scope_perubahan_side_letter as $key=>$dt)
                    <tr>
                      <td>{{($key+1)}}</td>
                      <td>{{($dt->meta_pasal)}} </td>
                      <td>{{($dt->meta_judul)}} </td>
                      <td>{{($dt->meta_isi)}} </td>
                      <td>{{($dt->meta_awal)}} </td>
                      <td>{{($dt->meta_akhir)}} </td>
                      <td>@if(!empty($dt->meta_file))
                      <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_scope_perubahan'])}}">
                      <i class="glyphicon glyphicon-paperclip"></i>  Lihat </a>
                      <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_scope_perubahan'])}}">
                      <i class="glyphicon glyphicon-download-alt"></i>  Download
                      </a>
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
          @include('documents::partials.buttons-view')
      </div>
    </div>

<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  $("#daftar1").DataTable( {
    "iDisplayLength": 100
  });
});
</script>
@endpush
