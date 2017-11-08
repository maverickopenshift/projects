<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Pasal Penting
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @if(count($meta_ps)>0)
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th width="40">No.</th>
                <th width="100">Pasal</th>
                <th width="250">Judul</th>
                <th>Isi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($meta_ps as $key=>$dt)
                <tr>
                  <td>{{($key+1)}}</td>
                  <td>{{($dt->meta_name)}} </td>
                  <td>{{($dt->meta_title)}}</td>
                  <td>{{($dt->meta_desc)}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    @else
      <div class="alert alert-info text-center" role="alert">Tidak ada data</div>
    @endif

        @if($doc_type->name=="khs")
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
