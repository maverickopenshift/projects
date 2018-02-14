<div class="form-group" style="position: relative;margin-top: 10px;margin-right:2px;">
  <div class="pull-right">
    <button type="button" class="btn btn-success add-lampiran"><i class="glyphicon glyphicon-plus"></i> tambah</button>
  </div>
</div>
  @php
    $baut_judul     = Helper::old_prop_each($doc,'baut_judul');
    $baut_tgl       = Helper::old_prop_each($doc,'baut_tgl');
    $baut_file      = Helper::old_prop_each($doc,'baut_file');
    $baut_file_old  = Helper::old_prop_each($doc,'baut_file_old');
  @endphp

  @if(count($baut_judul)>0)
    @foreach ($baut_judul as $key => $value)
      <div class="parent-lampiran">
        <div class="form-horizontal lampiran" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            @if(count($baut_judul)>1)
              <button type="button" class="btn btn-danger delete-lampiran" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
            @endif
            <div style="position: absolute;top: -60px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">BAUT <small class="text-danger"><i> (Wajib di isi) </i></small></div>
          </div>
          <div class="form-group {{ $errors->has('baut_judul.'.$key) ? ' has-error' : '' }}">
            <label for="baut_judul" class="col-sm-3 control-label"><span class="text-red">*</span> Judul Lampiran</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="baut_judul[]" autocomplete="off" value="{{$baut_judul[$key]}}">
            </div>
            <div class="col-sm-10 col-sm-offset-3 err">
              {!!Helper::error_help($errors,'baut_judul.'.$key)!!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('baut_tgl.'.$key) ? ' has-error' : '' }}">
            <label class="col-sm-3 control-label"><span class="text-red">*</span> Tanggal Lampiran</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="baut_tgl[]" autocomplete="off" placeholder="Tanggal.." value="{{$baut_tgl[$key]}}">
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-3 err">
              {!!Helper::error_help($errors,'baut_tgl.'.$key)!!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('baut_file.'.$key) ? ' has-error' : '' }}">
            <label class="col-sm-3 control-label"><span class="text-red">*</span> File</label>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="baut_file[]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="baut_file_old[]">
                </span>
              </div>
            </div>
            <div class="col-sm-10 col-sm-offset-3 err">
              {!!Helper::error_help($errors,'baut_file.'.$key)!!}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="parent-lampiran">
      <div class="form-horizontal lampiran"style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">BAUT <small class="text-danger"><i> (Wajib di isi) </i></small></div>
        </div>
        <div class="form-group {{ $errors->has('baut_judul.*') ? ' has-error' : '' }}">
          <label for="baut_judul" class="col-sm-3 control-label"><span class="text-red">*</span> Judul Lampiran</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="baut_judul[]" autocomplete="off" value="{{old('baut_judul',Helper::prop_exists($doc,'baut_judul'))}}">
          </div>
          <div class="col-sm-10 col-sm-offset-3 err">
            {!!Helper::error_help($errors,'baut_judul.*')!!}
          </div>
        </div>
        <div class="form-group {{ $errors->has('baut_tgl.*') ? ' has-error' : '' }}">
          <label class="col-sm-3 control-label"><span class="text-red">*</span> Tanggal Lampiran</label>
          <div class="col-sm-4">
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control" name="baut_tgl[]" autocomplete="off" placeholder="Tanggal.." value="{{old('baut_tgl',Helper::prop_exists($doc,'baut_tgl'))}}">
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-3 err">
            {!!Helper::error_help($errors,'baut_tgl.*')!!}
          </div>
        </div>
        <div class="form-group {{ $errors->has('baut_file.*') ? ' has-error' : '' }}">
          <label class="col-sm-3 control-label"><span class="text-red">*</span> File</label>
          <div class="col-sm-4">
            <div class="input-group">
              <input type="file" class="hide" name="baut_file[]">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
                <input type="hidden" name="baut_file_old[]">
              </span>
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-3 err">
            {!!Helper::error_help($errors,'baut_file.*')!!}
          </div>
        </div>
      </div>
    </div>
  @endif <!--end of form-->

@push('scripts')
<script>
$(function() {

  $(document).on('click', '.add-lampiran', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-lampiran" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
    /* Act on the event */
    var $this = $('.lampiran');
    var new_row = $this.eq(0).clone();
    new_row.find('.has-error').removeClass('has-error');
    var mdf_new_row = new_row.find('.form-group');

    // mdf_new_row.eq(1).find('.total_lampiran').text($this+1);//title and button

    mdf_new_row.eq(1).find('input').val('');      //baut_judul
    mdf_new_row.eq(1).find('.err').remove();    //baut_judul

    mdf_new_row.eq(2).find('input').val('');   //baut_tgl
    mdf_new_row.eq(2).find('.err').remove();  //baut_tgl

    mdf_new_row.eq(3).find('input').val('');   //baut_file
    mdf_new_row.eq(3).find('.err').remove(); //baut_file

    $('.parent-lampiran').append(new_row);
    $('.date').datepicker(datepicker_ops);
    var row = $('.lampiran');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.delete-lampiran');
      var mdf_new_row = $(this).find('.form-group');
      // mdf_new_row.eq(1).find('.total_lampiran').text(index+1);
      if(row.length==1){
        mdf.remove();
      }
      else{
        mdf_new_row.eq(0).append(btn_del)
      }
    });
  });

  $(document).on('click', '.delete-lampiran', function(event) {
    $(this).parent().parent().remove();
    var $this = $('.lampiran');
    $.each($this,function(index, el) {
      var mdf_new_row = $(this).find('.form-group');
      // mdf_new_row.eq(1).find('.total_lampiran').text(index+1);
      var mdf = $(this).find('.delete-lampiran');
      if($this.length==1){
        mdf.remove();
      }
    });
  });
});
</script>
@endpush
