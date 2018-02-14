<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info
      </h3>
    </div>
    <div class="box-body">
      <div class="form-horizontal">
        @if(!in_array($doc_type->name,['turnkey','khs','surat_pengikatan','mou']))
        <div class="form-group ">
          <label class="col-sm-2 control-label">No.Kontrak Induk </label>
          <div class="col-sm-10 text-me">{{$doc_parent->doc_no or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Judul Kontrak Induk </label>
          <div class="col-sm-10 text-me">{{$doc_parent->doc_title or '-'}}</div>
        </div>
        <hr>
        @endif
        <div class="form-group ">
          <label class="col-sm-2 control-label">No.Kontrak </label>
          <div class="col-sm-10 text-me">{{$doc->doc_no or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Judul {{$doc_type['title']}}</label>
          <div class="col-sm-10 text-me">{{$doc->doc_title}}</div>
        </div>
        @if(in_array($doc_type->name,['sp','turnkey']))
        <div class="form-group ">
          <label class="col-sm-2 control-label">No PO</label>
          <div class="col-sm-10 text-me">Disini No PO</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nilai PO</label>
          <div class="col-sm-10 text-me">Disini Nilai PO</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">No PR</label>
          <div class="col-sm-10 text-me">Disini No PR</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nilai PR</label>
          <div class="col-sm-10 text-me">Disini Nilai PR</div>
        </div>
        @endif
        <div class="form-group ">
          <label class="col-sm-2 control-label"><span class="text-red">*</span> GR</label>
          <div class="col-sm-6">
            @php
              $gr_nomer = Helper::old_prop_each($doc,'gr_nomer');
              $gr_nilai = Helper::old_prop_each($doc,'gr_nilai');
            @endphp
            @if (count($gr_nomer) >0)
              @foreach ($gr_nomer as $key => $value)
                <div class="form-group input-lampiran {{ $errors->has('gr_nomer.'.$key) ? ' has-error' : '' }} {{ $errors->has('gr_nilai.'.$key) ? ' has-error' : '' }}">
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="gr_nomer[]" placeholder="Masukkan Nomer GR" autocomplete="off" value="{{$gr_nomer[$key]}}">
                    {!!Helper::error_help($errors,'gr_nomer.'.$key)!!}
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group">
                      <input type="text" class="form-control input-rupiah" name="gr_nilai[]" placeholder="Masukkan Total GR" autocomplete="off" value="{{$gr_nilai[$key]}}">
                      <div class="input-group-btn">
                        @if(count($gr_nomer)>1)
                          <button type="button" class="btn btn-danger delete-lampiran"><i class="glyphicon glyphicon-trash"></i></button>
                        @endif
                      </div>
                    </div>
                    {!!Helper::error_help($errors,'gr_nilai.'.$key)!!}
                  </div>
                </div>
              @endforeach
            @else
            <div class="form-group input-lampiran">
              <div class="col-sm-6">
                  <input type="text" class="form-control" name="gr_nomer[]" placeholder="Masukkan Nomer GR" autocomplete="off">
              </div>
              <div class="col-sm-6 ">
                <div class="input-group">
                  <input type="text" class="form-control input-rupiah" name="gr_nilai[]" placeholder="Masukkan Total GR" autocomplete="off">
                  <div class="input-group-btn">
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
      </div>
    </div>
<!-- /.box-body -->
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
