<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Latar Belakang
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-latar">
        <thead>
        <tr>
          <th width="30">No. </th>
          <th width="150">Nama Dokumen</th>
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
  $(document).on('click', '.add-baris', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-row"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
    /* Act on the event */
    var $this = $('.table-latar');
    var row = $this.find('tbody>tr');
    var new_row = row.eq(0).clone();
    var mdf_new_row = new_row.find('td');
    mdf_new_row.eq(0).html(row.length+1);
    mdf_new_row.eq(1).find('input').val('');
    mdf_new_row.eq(1).find('.error').remove();
    mdf_new_row.eq(2).html('');
    mdf_new_row.eq(2).find('.error').remove();
    var id_editor = 'editor'+(row.length+1);
    mdf_new_row.eq(2).html('<textarea  class="form-control" rows="5" name="isi[]" class="editor" id="'+id_editor+'"></textarea>');
    $this.find('tbody').append(new_row);
    var row = $this.find('tbody>tr');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.action');
      if(row.length==1){
        mdf.html('');
      }
      else{
        mdf.html(btn_del);
      }
    });
  });
  $(document).on('click', '.delete-row', function(event) {
    $(this).parent().parent().remove();
    var $this = $('.table-me');
    var row = $this.find('tbody>tr');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.action');
      if(row.length==1){
        mdf.html('');
      }
    });
  });
});
</script>
@endpush
