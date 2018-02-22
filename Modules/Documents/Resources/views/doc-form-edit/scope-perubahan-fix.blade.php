<div class="box">
  <div class="box-header with-border" style="padding-bottom: 14px;">
    <h3 class="box-title">
      Latar Belakang
    </h3>
  </div>
  <div class="box-body">
    @php
      $f_scope_pasal = Helper::old_prop_each($doc,'scope_pasal');
      $f_scope_judul = Helper::old_prop_each($doc,'scope_judul');
      $f_scope_isi = Helper::old_prop_each($doc,'scope_isi');
      $f_scope_awal = Helper::old_prop_each($doc,'scope_awal');
      $f_scope_akhir = Helper::old_prop_each($doc,'scope_akhir');
      $f_scope_file = Helper::old_prop_each($doc,'scope_file');
      $f_scope_file_old = Helper::old_prop_each($doc,'scope_file');
    @endphp

    @if(count($f_scope_pasal)>=1)
      @foreach ($f_scope_pasal as $key => $value)
        <div class="parent_scope_perubahan">
          <div class="form-horizontal scope_perubahan" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Pasal <span class="total_scope_perubahan">{{$key+1}}</span></div>
              <div class="btn-group" style="position: absolute;right: 5px;top: -10px;border-radius: 0;">
                <button type="button" class="btn btn-success add_scope_perubahan" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>
              </div>            
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Pasal</label>
              <div class="col-sm-6">
                <input type="text" name="f_scope_pasal[]" class="form-control f_scope_pasal" value="{{$f_scope_pasal[$key]}}" placeholder="Pasal..">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Judul</label>
              <div class="col-sm-6">
                <input type="text" name="f_scope_judul[]" class="form-control f_scope_judul" value="{{$f_scope_judul[$key]}}" placeholder="Judul..">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"> Isi</label>
              <div class="col-sm-6">
                <textarea name="f_scope_isi[]" class="form-control f_scope_isi" cols="4" rows="4" placeholder="Isi..">{{$f_scope_isi[$key]}}</textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"> Semula</label>
              <div class="col-sm-6">
                <textarea name="f_scope_awal[]" class="form-control f_scope_awal" cols="4" rows="4" placeholder="Semula..">{{$f_scope_judul[$key]}}</textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"> Diubah Menjadi</label>
              <div class="col-sm-6">
                <textarea name="f_scope_akhir[]" class="form-control f_scope_akhir" cols="4" rows="4" placeholder="Akhir..">{{$f_scope_judul[$key]}}</textarea>
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
                    <input type="hidden" name="f_scope_file_old[]" value="{{$f_scope_file_old[$key]}}">
                    @if(!empty($f_scope_file_old[$key]))
                      <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file.scope',['filename'=>$f_scope_file_old[$key],'type'=>$doc_type->name])}}">
                      <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                      </a>
                    @else
                      -
                    @endif
                  </span>
                </div>
              </div>
            </div>

          </div>
        </div>
      @endforeach
    @else
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
    @endif

    @include('documents::partials.button-edit')
  </div>
</div>
@push('scripts')
<script>
  $(function(){
    var datepicker_ops={
      format: 'yyyy-mm-dd',
      autoclose:true,
      todayHighlight:true
    };

    $(document).on('click', '.add-latar-belakang', function(event) {
      event.preventDefault();

      var btn_add = '<button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
      var btn_del = '<button type="button" class="btn btn-danger delete-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

      var $this = $('.perubahan-latar_belakang');
      var new_row = $this.eq(0).clone();

      new_row.find('.has-error').removeClass('has-error');
      var mdf_new_row = new_row.find('.form-group');

      mdf_new_row.eq(0).find('.total_perubahan-latar_belakang').text(1);

      mdf_new_row.eq(1).find('.f_latar_belakang_judul').val('');
      mdf_new_row.eq(1).find('.error').html('');

      mdf_new_row.eq(2).find('.f_latar_belakang_tanggal').val('');    
      mdf_new_row.eq(2).find('.error').html('');

      mdf_new_row.eq(3).find('.f_latar_belakang_isi').val('');
      mdf_new_row.eq(3).find('.error').html('');

      mdf_new_row.eq(4).find('.f_latar_belakang_file').val('');
      mdf_new_row.eq(4).find('.error').html('');

      $('.parent-perubahan-latar_belakang').prepend(new_row);

      var row = $('.perubahan-latar_belakang');
      $.each(row,function(index, el) {
        var mdf_new_row = $(this).find('.form-group');
        var mdf_new_row_button = $(this).find('.btn-group');
        mdf_new_row.eq(0).find('.total_perubahan-latar_belakang').text(index+1);

        mdf_new_row_button.html('');
        if(row.length==1){
          mdf_new_row_button.eq(0).append(btn_add)
        }else{
          mdf_new_row_button.eq(0).append(btn_add)
          mdf_new_row_button.eq(0).append(btn_del)
        }
      });

      $('.date').datepicker(datepicker_ops);
    });

    $(document).on('click', '.delete-latar-belakang', function(event) {
      $(this).parent().parent().parent().remove();
      var btn_add = '<button type="button" class="btn btn-success add-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-plus"></i></button>';
      var btn_del = '<button type="button" class="btn btn-danger delete-latar-belakang" style="border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';

      var row = $('.perubahan');
      $.each(row,function(index, el) {
        var mdf_new_row = $(this).find('.form-group');
        var mdf_new_row_button = $(this).find('.btn-group');
        mdf_new_row.eq(0).find('.total_perubahan').text(index+1);

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
