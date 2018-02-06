<div class="form-group">
  <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Lampiran</label>
  <div class="col-sm-6">

    @php
      $lampiran_old = Helper::old_prop_each($doc,'doc_lampiran_old');
      $lampiran = Helper::old_prop_each($doc,'doc_lampiran');
      $lampiran_nama = Helper::old_prop_each($doc,'doc_lampiran_nama');
    @endphp

    @if (is_array($lampiran) && count($lampiran)>0)
      @foreach ($lampiran as $key => $value)
        <div class="form-group input-lampiran {{ $errors->has('doc_lampiran.'.$key) ? ' has-error' : '' }} {{ $errors->has('doc_lampiran_nama.'.$key) ? ' has-error' : '' }}">
          <div class="col-sm-6">
            <input type="text" class="form-control" name="doc_lampiran_nama[]" placeholder="Nama Lampiran" autocomplete="off" value="{{$lampiran_nama[$key]}}">
            {!!Helper::error_help($errors,'doc_lampiran_nama.'.$key)!!}
          </div>
          <div class="col-sm-6">
            <div class="input-group bottom10">
              <input type="file" class="hide" name="doc_lampiran[]" multiple="multiple">
              <input class="form-control" type="text" disabled>
              <div class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="doc_lampiran_old[]" value="{{$lampiran_old[$key]}}">
                @if(isset($lampiran_old[$key]))
                  <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file.lampiran',['filename'=>$lampiran_old[$key],'type'=>$doc_type->name])}}">
                  <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                  </a>
                @endif
                @if(count($lampiran)>0)
                  <button type="button" class="btn btn-danger delete-lampiran"><i class="glyphicon glyphicon-trash"></i></button>
                @endif

              </div>
            </div>
            {!!Helper::error_help($errors,'doc_lampiran.'.$key)!!}
          </div>
        </div>
      @endforeach
    @else
      <div class="form-group input-lampiran">
        <div class="col-sm-6">
            <input type="text" class="form-control" name="doc_lampiran_nama[]" placeholder="Nama Lampiran" autocomplete="off">
        </div>
        <div class="col-sm-6">
          <div class="input-group bottom10">
            <input type="file" class="hide" name="doc_lampiran[]">
            <input class="form-control" type="text" disabled>
            <div class="input-group-btn">
              <button class="btn btn-default click-upload" type="button">Browse</button>
              <input type="hidden" name="doc_lampiran_old[]">
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
  <!-- <div class="clearfix"></div>-->
  <div class="col-sm-3 align-bottom">
    <button type="button" class="btn btn-success add-lampiran align-bottom"><i class="glyphicon glyphicon-plus"></i> Tambah Lampiran</button>
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
        $(this).find('.add-lampiran').remove();
        $(this).find('.input-group-btn').append(btn_del);
      }
    });
  });
  $(document).on('click', '.delete-lampiran', function(event) {
    // $(this).parent().parent().parent().parent().parent().remove();
    $(this).parent().parent().parent().parent().remove();
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
