{{--
  <!--
<div class="form-group {{ $errors->has('legal_dokumen.*') ? ' has-error' : '' }}">
  <label for="legal_dokumen" class="col-sm-2 control-label"><span class="text-red">*</span> Legal Dokumen</label>
  <div class="col-sm-10">
    @if(count(old('legal_dokumen',Helper::prop_exists($supplier,'legal_dokumen','array')))>0)
      @php
        $i=1;
      @endphp
      @foreach (old('legal_dokumen',Helper::prop_exists($supplier,'legal_dokumen','array')) as $k => $d)
        <div class="row row-legal-dokumen bottom15">
            <div class="col-sm-4">
                <input type="text" class="form-control" name="legal_dokumen[][name]" placeholder="Nama Dokumen" value="{{$d['name']}}" autocomplete="off">
                @if ($errors->has('legal_dokumen.'.($k).'.name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('legal_dokumen.'.($k).'.name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="legal_dokumen[][file]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                </span>
              </div>
              @if($action_type=='lihat' || $action_type=='edit')
                @php
                  $old_file = old('file_old_ld',Helper::prop_exists($supplier,'file_old_ld','array'));
                @endphp
                @if(!empty($old_file[$k]))
                  <span class="help-block">
                    <a href="#" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('usersupplier.legaldokumen.file',['filename'=>$old_file[$k]])}}">
                    <i class="glyphicon glyphicon-paperclip"></i>{{$old_file[$k]}}</a>

                    <input type="hidden" class="hide" name="file_old_ld[]" value="{{$old_file[$k]}}">
                  </span>
                @endif
              @endif
              @if ($errors->has('legal_dokumen.'.($k).'.file'))
                  <span class="help-block">
                      <strong>{{ $errors->first('legal_dokumen.'.($k).'.file') }}</strong>
                  </span>
              @endif
            </div>
            <div class="col-sm-4 attr-btn">
                @if(count(old('legal_dokumen',Helper::prop_exists($supplier,'legal_dokumen','array')))>1)
                  <button style="margin-right:15px;" type="button" class="btn btn-default delete-legal-dokumen"><i class="glyphicon glyphicon-remove"></i></button>
                @endif
                @if(count(old('legal_dokumen',Helper::prop_exists($supplier,'legal_dokumen','array')))==$i )
                  <button type="button" class="btn btn-danger add-legal-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
                @endif
            </div>
        </div>
        @php
          $i++;
        @endphp
      @endforeach
    @else
      <div class="row row-legal-dokumen bottom15">
          <div class="col-sm-4">
              <input type="text" class="form-control" name="legal_dokumen[][name]" placeholder="Nama Dokumen" autocomplete="off">
          </div>
          <div class="col-sm-4">
            <div class="input-group">
              <input type="file" class="hide" name="legal_dokumen[][file]">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
              </span>
            </div>
          </div>
          <div class="col-sm-4 attr-btn">
              <button type="button" class="btn btn-danger add-legal-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
          </div>
      </div>
    @endif
  </div>
</div>
-->
--}}

<div class="form-horizontal">
  <div class="row">
    <div class="col-sm-12">
      
      <div class="form-group">
        <label class="col-sm-2 control-label"><span class="text-red">*</span> Legal Dokumen</label>
        <div class="col-sm-7">

          @php
            $legal_dokumen_old = Helper::old_prop_each($supplier,'file_old_ld');
            $legal_dokumen = Helper::old_prop_each($supplier,'file_old_ld');
            $legal_dokumen_nama = Helper::old_prop_each($supplier,'legal_dokumen_nama');

          @endphp

          @if (is_array($legal_dokumen) && count($legal_dokumen)>0)
            @foreach ($legal_dokumen as $key => $value)
              <div class="form-group input-legal_dokumen formerror formerror-legal_dokumen-{{$key}} formerror-legal_dokumen_nama-{{$key}}">
              <div class="col-sm-5">
                <div class="">
                  <input type="text" class="form-control" name="legal_dokumen_nama[]" placeholder="Nama Legal Dokumen" autocomplete="off" value="{{$legal_dokumen_nama[$key]}}">
                </div>
                <div class="error error-legal_dokumen_nama error-legal_dokumen_nama-0"></div>
              </div>

              <div class="col-sm-7">
                <div class="input-group bottom10">
                  <input type="file" class="hide" name="legal_dokumen[]" value="{{$legal_dokumen_old[$key]}}">
                  <input class="form-control" type="text" disabled>
                  <div class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse </button>
                    <input type="hidden" name="legal_dokumen_old[]" value="{{$legal_dokumen_old[$key]}}">
                    @if(isset($legal_dokumen_old[$key]))
                      <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('usersupplier.legaldokumen.file',['filename'=>$legal_dokumen_old[$key]])}}">
                      <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                      </a>
                    @endif
                    @if($action_type!='lihat')
                      @if(count($legal_dokumen)>1)
                        <button type="button" class="btn btn-danger delete-lampiran"><i class="glyphicon glyphicon-trash"></i></button>
                      @endif
                    @endif
                  </div>
                </div>
                <div class="error error-legal_dokumen error-legal_dokumen-0"></div>
              </div>
            </div>
            @endforeach
          @else
            <div class="form-group input-legal_dokumen formerror formerror-legal_dokumen-0 formerror-legal_dokumen_nama-0">
              <div class="col-sm-5">
                <div class="">
                  <input type="text" class="form-control" name="legal_dokumen_nama[]" placeholder="Nama Legal Dokumen" autocomplete="off">
                </div>
                <div class="error error-legal_dokumen_nama error-legal_dokumen_nama-0"></div>
              </div>
              <div class="col-sm-7">
                <div class="input-group bottom10">
                  <input type="file" class="hide" name="legal_dokumen[]">
                  <input class="form-control" type="text" disabled>
                  <div class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                    <input type="hidden" name="legal_dokumen_old[]">
                  </div>
                </div>
                <div class="error error-legal_dokumen error-legal_dokumen-0"></div>
              </div>
            </div>
          @endif
          
        </div>
        
        @if($action_type!='lihat')
        <div class="col-sm-3 align-bottom">
          <button type="button" class="btn btn-success add-legal_dokumen align-bottom"><i class="glyphicon glyphicon-plus"></i> Tambah Lampiran</button>
        </div>
        @endif
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
$(function() {
  $(document).on('click', '.add-legal_dokumen', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-legal_dokumen"><i class="glyphicon glyphicon-trash"></i></button>';

    /* Act on the event */
    var $this = $('.input-legal_dokumen');
    var new_row = $this.eq(0).clone();

    new_row.removeClass('has-error');
    new_row.find('input').val('');
    new_row.find('.error').html('');
    new_row.find('.btn-lihat').remove();
    new_row.find('.delete-legal_dokumen').remove();
    $this.parent().append(new_row);

    var row = $('.input-legal_dokumen');
    $.each(row,function(index, el) {
      if($(this).hasClass("has-error")){
        $(this).removeClass().addClass("form-group input-legal_dokumen has-error formerror formerror-legal_dokumen-"+ index);
      }else{
        $(this).removeClass().addClass("form-group input-legal_dokumen formerror formerror-legal_dokumen-"+ index);
      }
      
      $(this).find('.error-legal_dokumen').removeClass().addClass("error error-legal_dokumen error-legal_dokumen-"+ index);
      $(this).find('.error-legal_dokumen_nama').removeClass().addClass("error error-legal_dokumen_nama error-legal_dokumen_nama-"+ index);

      if(row.length==1){
        $(this).find('.delete-legal_dokumen').remove();
      }else{
        $(this).find('.delete-legal_dokumen').remove();
        $(this).find('.add-legal_dokumen').remove();
        $(this).find('.input-group-btn').append(btn_del);
      }
    });
  });
  
  $(document).on('click', '.delete-legal_dokumen', function(event) {
    $(this).parent().parent().parent().parent().remove();
    var $this = $('.input-legal_dokumen');
    $.each($this,function(index, el) {
      if($(this).hasClass("has-error")){
        $(this).removeClass().addClass("form-group input-legal_dokumen has-error formerror formerror-legal_dokumen-"+ index);
      }else{
        $(this).removeClass().addClass("form-group input-legal_dokumen formerror formerror-legal_dokumen-"+ index);
      }

      $(this).find('.error-legal_dokumen').removeClass().addClass("error error-legal_dokumen error-legal_dokumen-"+ index);
      $(this).find('.error-legal_dokumen_nama').removeClass().addClass("error error-legal_dokumen_nama error-legal_dokumen_nama-"+ index);
      
      if($this.length==1){
        $(this).find('.delete-legal_dokumen').remove();
      }
    });
  });

});
</script>
@endpush