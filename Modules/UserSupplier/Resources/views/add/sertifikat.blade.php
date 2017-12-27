<div class="form-group" style="position: relative;margin-top: 15px;margin-bottom: 50px;">
  <div class="pull-right">
    <button type="button" class="btn btn-success add-sertifikat"><i class="glyphicon glyphicon-plus"></i> tambah</button>
  </div>
</div>
{{-- @if(count(old('jml_serti',Helper::prop_exists($data,'jml_serti','array')))>1) --}}
@if(count(old('jml_serti',Helper::prop_exists($data,'jml_serti','array')))>0)
  @foreach (old('sertifikat_dokumen',Helper::prop_exists($data,'sertifikat_dokumen','array')) as $k => $d)
    <div class="form-group sertifikat {{ $errors->has('sertifikat_dokumen.*') ? ' has-error' : '' }}">
      <div class="row">
        <div class="form-group button-delete" style="position:relative;margin-top: 25px;margin-bottom: 60px;margin-right:12px;">
            @if(count(old('sertifikat_dokumen',Helper::prop_exists($data,'sertifikat_dokumen','array')))>1)
              <button type="button" class="btn btn-danger delete-sertifikat" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
            @endif
          </div>
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="" class="col-sm-5 control-label">Sertifikat Keahlian #<span class="total_sertifikat">{{$k+1}}</span><input type="text" class="jum_sertifikat" name="jml_serti" value="{{$k+1}}" autocomplete="off"></label>
              <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="No. Sertifikat" name="sertifikat_dokumen[][iujk_no]" value="{{$d['iujk_no']}}" autocomplete="off">
                @if ($errors->has('sertifikat_dokumen.'.($k).'.iujk_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sertifikat_dokumen.'.($k).'.iujk_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="" class="col-sm-4 control-label">Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="sertifikat_dokumen[][iujk_tg_terbit]" value="{{$d['iujk_tg_terbit']}}" autocomplete="off">
                </div>
                @if ($errors->has('sertifikat_dokumen.'.($k).'.iujk_tg_terbit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sertifikat_dokumen.'.($k).'.iujk_tg_terbit') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
              <div class="form-group">
                <label for="" class="col-sm-4 control-label">Tgl Expired</label>
                <div class="col-sm-8">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control" name="sertifikat_dokumen[][iujk_tg_expired]" value="{{$d['iujk_tg_expired']}}" autocomplete="off">
                  </div>
                  @if ($errors->has('sertifikat_dokumen.'.($k).'.iujk_tg_expired'))
                      <span class="help-block">
                          <strong>{{ $errors->first('sertifikat_dokumen.'.($k).'.iujk_tg_expired') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="row bottom15">
          <div class="col-sm-4">
              <input type="text" class="form-control" name="sertifikat_dokumen[][name]" placeholder="Nama Dokumen" value="{{$d['name']}}" autocomplete="off">
              @if ($errors->has('sertifikat_dokumen.'.($k).'.name'))
                  <span class="help-block">
                      <strong>{{ $errors->first('sertifikat_dokumen.'.($k).'.name') }}</strong>
                  </span>
              @endif
          </div>
          <div class="col-sm-4">
            <div class="input-group">
              <input type="file" class="hide" name="sertifikat_dokumen[][file]">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
              </span>
            </div>
            @if($action_type=='edit')
              @php
                $old_file_sd = old('file_old_sd',Helper::prop_exists($data,'file_old_sd','array'));
              @endphp
              @if(!empty($old_file_sd[$k]))
                <span class="help-block">
                <!--
                  <a target="_blank" href="{{route('supplier.sertifikat.file',['filename'=>$old_file_sd[$k]])}}"><i class="glyphicon glyphicon-paperclip"></i> {{$old_file_sd[$k]}}</a>
                -->
                  <a href="#" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('supplier.sertifikat.file',['filename'=>$old_file_sd[$k]])}}">
                  <i class="glyphicon glyphicon-paperclip"></i>{{$old_file_sd[$k]}}</a>

                  <input type="hidden" class="hide" name="file_old_sd[]" value="{{$old_file_sd[$k]}}">
                </span>
              @endif
            @endif
            @if ($errors->has('sertifikat_dokumen.'.($k).'.file'))
                <span class="help-block">
                    <strong>{{ $errors->first('sertifikat_dokumen.'.($k).'.file') }}</strong>
                </span>
            @endif
          </div>
          <div class="col-sm-4 attr-btn">
              @if(count(old('sertifikat_dokumen',Helper::prop_exists($data,'sertifikat_dokumen','array')))>1)
                <button style="margin-right:15px;" type="button" class="btn btn-default delete-sertifikat-dokumen"><i class="glyphicon glyphicon-remove"></i></button>
              @endif
              {{-- @if(count(old('sertifikat_dokumen',Helper::prop_exists($data,'sertifikat_dokumen','array')))==$i )
                <button type="button" class="btn btn-danger add-sertifikat-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
              @endif --}}
          </div>
      </div>
    </div>
  @endforeach
@else
<div class="form-group sertifikat {{ $errors->has('sertifikat_dokumen.*') ? ' has-error' : '' }}">
  <div class="row">
    <div class="form-group button-delete" style="position:relative;margin-top: 25px;margin-bottom: 60px;margin-right:12px;">
    </div>
    <div class="col-sm-5">
      <div class="form-horizontal">
        <div class="form-group">
          <label for="" class="col-sm-5 control-label">Sertifikat Keahlian #<span class="total_sertifikat">1</span><input type="text" class="jum_sertifikat" name="jml_serti" value="1" autocomplete="off"></label>
          <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="No. Sertifikat" name="sertifikat_dokumen[][iujk_no]" autocomplete="off">

            {{-- @if ($errors->has('iujk_no'))
                <span class="help-block">
                    <strong>{{ $errors->first('iujk_no') }}</strong>
                </span>
            @endif --}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-horizontal">
        <div class="form-group">
          <label for="" class="col-sm-4 control-label">Tgl Terbit</label>
          <div class="col-sm-8">
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control" name="sertifikat_dokumen[][iujk_tg_terbit]" autocomplete="off">
            </div>
            {{-- @if ($errors->has('iujk_tg_terbit'))
                <span class="help-block">
                    <strong>{{ $errors->first('iujk_tg_terbit') }}</strong>
                </span>
            @endif --}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-horizontal">
          <div class="form-group">
            <label for="" class="col-sm-4 control-label">Tgl Expired</label>
            <div class="col-sm-8">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="sertifikat_dokumen[][iujk_tg_expired]" autocomplete="off">
              </div>
              {{-- @if ($errors->has('iujk_tg_expired'))
                  <span class="help-block">
                      <strong>{{ $errors->first('iujk_tg_expired') }}</strong>
                  </span>
              @endif --}}
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="row bottom15">
      <div class="col-sm-4">
          <input type="text" class="form-control" name="sertifikat_dokumen[][name]" placeholder="Nama Dokumen" autocomplete="off">
      </div>
      <div class="col-sm-4">
        <div class="input-group">
          <input type="file" class="hide" name="sertifikat_dokumen[][file]" autocomplete="off">
          <input class="form-control" type="text" disabled>
          <span class="input-group-btn">
            <button class="btn btn-default click-upload" type="button">Browse</button>
          </span>
        </div>
      </div>
      {{-- <div class="col-sm-4 attr-btn">
          <button type="button" class="btn btn-danger add-sertifikat-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
      </div> --}}
  </div>
</div>
@endif

@push('scripts')
<script>
$(function() {

  $(document).on('click', '.add-sertifikat', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-sertifikat" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
    /* Act on the event */
    var $this = $('.sertifikat');
    var new_row = $this.eq(0).clone();
    new_row.find('.has-error').removeClass('has-error');
    var mdf_new_row = new_row.find('.form-group');

    mdf_new_row.eq(1).find('.total_sertifikat').text($this+1);//title and button

    mdf_new_row.eq(1).find('input').val('');      //iujk_no
    mdf_new_row.eq(1).find('.error').remove();    //iujk_no

    mdf_new_row.eq(2).find('input').val('');   //iujk_tg_terbit
    mdf_new_row.eq(2).find('.error').remove();  //iujk_tg_terbit

    mdf_new_row.eq(3).find('input').val('');   //iujk_tg_expired
    mdf_new_row.eq(3).find('.error').remove(); //iujk_tg_expired

    mdf_new_row.eq(4).find('input').val('');   //file_sertifikat
    mdf_new_row.eq(4).find('.error').remove(); //file_sertifikat

    mdf_new_row.eq(5).find('input').val('');   //file_sertifikat
    mdf_new_row.eq(5).find('.error').remove(); //file_sertifikat


    $this.parent().append(new_row);
    $('.date').datepicker(datepicker_ops);
    var row = $('.sertifikat');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.delete-sertifikat');
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(1).find('.total_sertifikat').text(index+1);
      mdf_new_row.eq(1).find('.jum_sertifikat').val(index+1);
      if(row.length==1){
        mdf.remove();
      }
      else{
        mdf_new_row.eq(0).append(btn_del)
      }
    });
  });

  $(document).on('click', '.delete-sertifikat', function(event) {
    $(this).parent().parent().parent().remove();
    var $this = $('.sertifikat');
    $.each($this,function(index, el) {
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(1).find('.total_sertifikat').text(index+1);
      var mdf = $(this).find('.delete-sertifikat');
      if($this.length==1){
        mdf.remove();
      }
    });
  });
});
</script>
@endpush
