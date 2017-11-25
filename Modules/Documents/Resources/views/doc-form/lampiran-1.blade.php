<div class="form-group">
  <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Lampiran 1</label>
  <div class="col-sm-6">
    @php
      $lampiran_old = Helper::old_prop_each($doc,'doc_lampiran_old');
      $lampiran = Helper::old_prop_each($doc,'doc_lampiran');
    @endphp
    @if (is_array($lampiran) && count($lampiran)>0)
      @foreach ($lampiran as $key => $value)
        <div class="{{ $errors->has('doc_lampiran.'.$key) ? ' has-error' : '' }} input-lampiran">
          <div class="input-group bottom10">
            <input type="file" class="hide" name="doc_lampiran[]" multiple="multiple">
            <input class="form-control" type="text" disabled>
            <div class="input-group-btn">
              <button class="btn btn-default click-upload" type="button">Browse</button>
                <input type="hidden" name="doc_lampiran_old[]" value="{{$lampiran_old[$key]}}">
              @if(isset($lampiran_old[$key]))
                <a target="_blank" class="btn btn-primary btn-lihat" href="{{route('doc.file.lampiran',['filename'=>$lampiran_old[$key],'type'=>$doc_type->name])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat</a>
              @endif
              @if(count($lampiran)>1)
                <button type="button" class="btn btn-danger delete-lampiran"><i class="glyphicon glyphicon-trash"></i></button>
              @endif
            </div>
          </div>
          {!!Helper::error_help($errors,'doc_lampiran.'.$key)!!}
        </div>
      @endforeach
    @else
      <div class="input-lampiran">
        <div class="input-group bottom10">
          <input type="file" class="hide" name="doc_lampiran[]">
          <input class="form-control" type="text" disabled>
          <div class="input-group-btn">
            <button class="btn btn-default click-upload" type="button">Browse</button>
            <input type="hidden" name="doc_lampiran_old[]">
          </div>
        </div>
      </div>
    @endif
  </div>
  <div class="clearfix"></div>
  <div class="col-sm-6 col-sm-offset-2">
    <button type="button" class="btn btn-success add-lampiran"><i class="glyphicon glyphicon-plus"></i> Tambah Lampiran</button>
  </div>
</div>
@push('scripts')
<script>
$(function() {
  $(document).on('click', '.add-lampiran', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-lampiran"><i class="glyphicon glyphicon-trash"></i></button>';
    /* Act on the event */
    var $this = $('.input-lampiran');
    var new_row = $this.eq(0).clone();
    new_row.removeClass('has-error');
    new_row.find('input').val('');
    new_row.find('.error').remove();
    new_row.find('.btn-lihat').remove();
    new_row.find('.delete-lampiran').remove();
    $this.parent().append(new_row);
    var row = $('.input-lampiran');
    $.each(row,function(index, el) {
      if(row.length==1){
        $(this).find('.delete-lampiran').remove();
      }
      else{
        $(this).find('.delete-lampiran').remove();
        $(this).find('.input-group-btn').append(btn_del);
      }
    });
  });
  $(document).on('click', '.delete-lampiran', function(event) {
    $(this).parent().parent().parent().remove();
    var $this = $('.input-lampiran');
    $.each($this,function(index, el) {
      if($this.length==1){
        $(this).find('.delete-lampiran').remove();
      }
    });
  });
});
</script>
@endpush
