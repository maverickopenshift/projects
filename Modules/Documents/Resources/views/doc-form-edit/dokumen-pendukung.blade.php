<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Dokumen Pendukung
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-file">
        <thead>
        <tr>
          <th width="40">No.</th>
          <th>Nama Dokumen</th>
          <th width="300">File</th>
          <th  width="70"><button type="button" class="btn btn-success btn-xs add-file"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>1</td>
              <td><input type="text" class="form-control" name="nama_dokumen[]" placeholder="Masukan Nama Dokumen" autocomplete="off"></td>
              <td>
                <div class="input-group">
                  <input type="file" class="hide" name="file_dokumen[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                  </span>
                </div>
              </td>
              <td class="action"></td>
          </tr>
      </tbody>
      </table>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  $(document).on('click', '.add-file', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-file"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
    /* Act on the event */
    var $this = $('.table-file');
    var row = $this.find('tbody>tr');
    var new_row = row.eq(0).clone();
    var mdf_new_row = new_row.find('td');
    mdf_new_row.eq(0).html(row.length+1);
    mdf_new_row.eq(1).find('input').val('');
    mdf_new_row.eq(1).find('.error').remove();
    mdf_new_row.eq(2).find('input').val('');
    mdf_new_row.eq(2).find('.error').remove();
    var id_editor = 'editor'+(row.length+1);
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
  $(document).on('click', '.delete-file', function(event) {
    $(this).parent().parent().remove();
    var $this = $('.table-file');
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
