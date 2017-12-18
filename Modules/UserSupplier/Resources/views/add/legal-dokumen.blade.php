<div class="form-group" style="position: relative;margin-top: 15px;margin-bottom: 10px;">
  <div class="pull-right">
    <button type="button" class="btn btn-success add-legal"><i class="glyphicon glyphicon-plus"></i> tambah</button>
  </div>
</div>

  <div class="legal">
    <div class="form-horizontal">
      <div class="row">
        <div class="form-group button-delete" style="position:relative;margin-top: 25px;margin-bottom: 10px;margin-right:12px;">
        </div>
        <div class="col-sm-5">
          <div class="form-group {{ $errors->has('nama_legal_dokumen') ? ' has-error' : '' }}">
            <label for="nama_legal_dokumen" class="col-sm-5 control-label">Legal Dokumen #<span class="total_legal">1</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Nama File" name="nama_legal_dokumen[]" autocomplete="off">
              @if ($errors->has('nama_legal_dokumen'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nama_legal_dokumen') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group {{ $errors->has('file_legal_dokumen') ? ' has-error' : '' }}">
            <div class="col-sm-8">
              <div class="input-group">
                <input type="file" class="hide" name="file_legal_dokumen[]" autocomplete="off">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="file_legal_dokumen_old[]">
                </span>
              </div>
              @if ($errors->has('file_legal_dokumen'))
                  <span class="help-block">
                      <strong>{{ $errors->first('file_legal_dokumen') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@push('scripts')
<script>
$(function() {

  $(document).on('click', '.add-legal', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-legal" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
    /* Act on the event */
    var $this = $('.legal');
    var new_row = $this.eq(0).clone();
    new_row.find('.has-error').removeClass('has-error');
    var mdf_new_row = new_row.find('.form-group');

    mdf_new_row.eq(1).find('.total_legal').text($this+1);//title and button

    mdf_new_row.eq(1).find('input').val('');   //file_sertifikat
    mdf_new_row.eq(1).find('.error').remove(); //file_sertifikat

    mdf_new_row.eq(2).find('input').val('');   //file_sertifikat
    mdf_new_row.eq(2).find('.error').remove(); //file_sertifikat


    $this.parent().parent().append(new_row);
    $('.date').datepicker(datepicker_ops);
    var row = $('.legal');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.delete-legal');
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(1).find('.total_legal').text(index+1);
      if(row.length==1){
        mdf.remove();
      }
      else{
        mdf_new_row.eq(0).append(btn_del)
      }
    });
  });

  $(document).on('click', '.delete-legal', function(event) {
    $(this).parent().parent().parent().parent().remove();
    var $this = $('.legal');
    $.each($this,function(index, el) {
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(1).find('.total_legal').text(index+1);
      var mdf = $(this).find('.delete-legal');
      if($this.length==1){
        mdf.remove();
      }
    });
  });
});
</script>
@endpush
