<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Pasal Penting
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-bordered table-me">
          <thead>
          <tr>
            <th width="40">No.</th>
            <th width="100">Pasal</th>
            <th width="250">Judul</th>
            <th>Isi</th>
            <th  width="70"><button type="button" class="btn btn-success btn-xs add-row"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><input type="text" class="form-control" name="pasal[]" autocomplete="off"></td>
                <td><input type="text" class="form-control" name="judul[]" autocomplete="off"></td>
                <td><textarea class="form-control" rows="5" name="isi[]" class="editor" id="editor1"></textarea></td>
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
  $(document).on('click', '.add-row', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-row"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
    /* Act on the event */
    var $this = $('.table-me');
    var row = $this.find('tbody>tr');
    var new_row = row.eq(0).clone();
    var mdf_new_row = new_row.find('td');
    mdf_new_row.eq(0).html(row.length+1);
    mdf_new_row.eq(1).find('input').val('');
    mdf_new_row.eq(1).find('.error').remove();
    mdf_new_row.eq(2).find('input').val('');
    mdf_new_row.eq(2).find('.error').remove();
    mdf_new_row.eq(3).html('');
    mdf_new_row.eq(3).find('.error').remove();
    var id_editor = 'editor'+(row.length+1);
    mdf_new_row.eq(3).html('<textarea  class="form-control" rows="5" name="isi[]" class="editor" id="'+id_editor+'"></textarea>');
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
