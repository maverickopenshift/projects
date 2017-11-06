<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Scoupe Perubahan
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-latar">
        <thead>
        <tr>
          <th width="30">No. </th>
          <th width="150">Scope Perubahan</th>
          <th width="150">Semula</th>
          <th width="150">Diubah Menjadi</th>
          <th width="300">Attachment</th>
          <th  width="70"><button type="button" class="btn btn-success btn-xs add-baris"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>1</td>
              <td><input type="text" class="form-control" name="judul[]" autocomplete="off"></td>
              <td><div class="col-sm-10">
                <div class="input-group">
                  <input type="file" class="hide" name="legal_dokumen[][file]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                  </span>
                </div>
              </div></td>
              <td class="action"></td>
          </tr>
      </tbody>
      </table>
    {{-- @include('documents::partials.buttons') --}}
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
