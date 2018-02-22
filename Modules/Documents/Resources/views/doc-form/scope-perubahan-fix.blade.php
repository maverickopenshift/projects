<div class="box">
  <div class="box-header with-border" style="padding-bottom: 14px;">
    <h3 class="box-title">
      Scope Perubahan
    </h3>
  </div>
  <div class="box-body">
    
    <div class="parent_scope_perubahan">
      <div class="form-horizontal scope_perubahan" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Pasal <span class="total_scope_perubahan">1</span></div>
          <div class="btn-group" style="position: absolute;right: 5px;top: -10px;border-radius: 0;">
            <button type="button" class="btn btn-success add_scope_perubahan" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>
          </div>            
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Pasal</label>
          <div class="col-sm-6">
            <input type="text" name="f_scope_pasal[]" class="form-control f_scope_pasal" placeholder="Pasal..">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Judul</label>
          <div class="col-sm-6">
            <input type="text" name="f_scope_judul[]" class="form-control f_scope_judul" placeholder="Judul..">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label"> Isi</label>
          <div class="col-sm-6">
            <textarea name="f_scope_isi[]" class="form-control f_scope_isi" cols="4" rows="4" placeholder="Isi.."></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label"> Semula</label>
          <div class="col-sm-6">
            <textarea name="f_scope_awal[]" class="form-control f_scope_awal" cols="4" rows="4" placeholder="Semula.."></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label"> Diubah Menjadi</label>
          <div class="col-sm-6">
            <textarea name="f_scope_akhir[]" class="form-control f_scope_akhir" cols="4" rows="4" placeholder="Akhir.."></textarea>
          </div>
        </div>

        <div class="form-group">
          <label for="lt_file" class="col-sm-2 control-label"> File</label>
          <div class="col-sm-6">
            <div class="input-group">
              <input type="file" class="hide f_scope_file" name="f_scope_file[]">
              <input class="form-control f_scope_file" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
                <input type="hidden" name="f_scope_file_old[]">
              </span>
            </div>
          </div>
        </div>

      </div>
    </div>
    
    @include('documents::partials.buttons')
  </div>
</div>
@push('scripts')
<script>
  $(function(){    
    $(document).on('click', '.add_scope_perubahan', function(event) {
      event.preventDefault();

      var btn_add = '<button type="button" class="btn btn-success add_scope_perubahan" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
      var btn_del = '<button type="button" class="btn btn-danger delete_scope_perubahan" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

      var $this = $('.scope_perubahan');
      var new_row = $this.eq(0).clone();

      new_row.find('.has-error').removeClass('has-error');
      var mdf_new_row = new_row.find('.form-group');

      mdf_new_row.eq(0).find('.total_scope_perubahan').text(1);

      mdf_new_row.eq(1).find('.f_scope_pasal').val('');
      mdf_new_row.eq(1).find('.error').html('');

      mdf_new_row.eq(2).find('.f_scope_judul').val('');    
      mdf_new_row.eq(2).find('.error').html('');

      mdf_new_row.eq(3).find('.f_scope_isi').val('');
      mdf_new_row.eq(3).find('.error').html('');

      mdf_new_row.eq(4).find('.f_scope_awal').val('');
      mdf_new_row.eq(4).find('.error').html('');

      mdf_new_row.eq(5).find('.f_scope_akhir').val('');
      mdf_new_row.eq(5).find('.error').html('');

      mdf_new_row.eq(6).find('.f_scope_file').val('');
      mdf_new_row.eq(6).find('.error').html('');

      $('.parent_scope_perubahan').prepend(new_row);

      var row = $('.scope_perubahan');
      $.each(row,function(index, el) {
        var mdf_new_row = $(this).find('.form-group');
        var mdf_new_row_button = $(this).find('.btn-group');
        mdf_new_row.eq(0).find('.total_scope_perubahan').text(index+1);

        mdf_new_row_button.html('');
        if(row.length==1){
          mdf_new_row_button.eq(0).append(btn_add)
        }else{
          mdf_new_row_button.eq(0).append(btn_add)
          mdf_new_row_button.eq(0).append(btn_del)
        }
      });
    });
    
    $(document).on('click', '.delete_scope_perubahan', function(event) {
      $(this).parent().parent().parent().remove();
      var btn_add = '<button type="button" class="btn btn-success add_scope_perubahan" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
      var btn_del = '<button type="button" class="btn btn-danger delete_scope_perubahan" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

      var row = $('.scope_perubahan');
      $.each(row,function(index, el) {
        var mdf_new_row = $(this).find('.form-group');
        var mdf_new_row_button = $(this).find('.btn-group');
        mdf_new_row.eq(0).find('.total_scope_perubahan').text(index+1);

        mdf_new_row_button.html('');
        if(row.length==1){
          mdf_new_row_button.eq(0).append(btn_add)
        }else{
          mdf_new_row_button.eq(0).append(btn_add)
          mdf_new_row_button.eq(0).append(btn_del)
        }
      });
    });
    
  });
</script>
@endpush
