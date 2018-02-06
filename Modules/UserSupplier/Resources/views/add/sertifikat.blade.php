<div class="form-group" style="position: relative;margin-top: 15px;margin-bottom: 50px;">
  <div class="pull-right">
    <button type="button" class="btn btn-success add-sertifikat"><i class="glyphicon glyphicon-plus"></i> tambah</button>
  </div>
</div>

@php
  $iujk_no          = Helper::old_prop_each($data,'iujk_no');
  // $iujk_no          = old('iujk_no',Helper::prop_exists($data,'iujk_no'));
  $iujk_tg_terbit   = Helper::old_prop_each($data,'iujk_tg_terbit');
  $iujk_tg_expired  = Helper::old_prop_each($data,'iujk_tg_expired');
  // $old_file_sd = old('file_old_sd',Helper::prop_exists($data,'file_old_sd','array'));
  $nama_sertifikat_dokumen      = Helper::old_prop_each($data,'nama_sertifikat_dokumen');
  $file_sertifikat_dokumen_old  = Helper::old_prop_each($data,'file_sertifikat_dokumen_old');
@endphp

@if(count($iujk_no)>0)
  @foreach ($iujk_no as $key => $value)
    <div class="parent-sertifikat">
      <div class="form-horizontal sertifikat">
        <div class="row">
          <div class="form-group button-delete" style="position:relative;margin-top: 25px;margin-bottom: 60px;margin-right:12px;">
            @if(count($iujk_no)>1)
              <button type="button" class="btn btn-danger delete-sertifikat" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
            @endif
          </div>
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('iujk_no.'.$key) ? ' has-error' : '' }}">
              <label for="iujk_no" class="col-sm-5 control-label">Sertifikat Keahlian #<span class="total_sertifikat">{{$key+1}}</span></label>
              <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="No. Sertifikat" name="iujk_no[]" value="{{$iujk_no[$key]}}" autocomplete="off">
                @if ($errors->has('iujk_no.'.$key))
                    <span class="help-block">
                        <strong>{{ $errors->first('iujk_no.'.$key) }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group {{ $errors->has('iujk_tg_terbit.'.$key) ? ' has-error' : '' }}">
              <label for="iujk_tg_terbit" class="col-sm-4 control-label">Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="iujk_tg_terbit[]" value="{{$iujk_tg_terbit[$key]}}" autocomplete="off">
                </div>
                @if ($errors->has('iujk_tg_terbit.'.$key))
                    <span class="help-block">
                        <strong>{{ $errors->first('iujk_tg_terbit.'.$key) }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group {{ $errors->has('iujk_tg_expired.'.$key) ? ' has-error' : '' }}">
              <label for="iujk_tg_expired" class="col-sm-4 control-label">Tgl Expired</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="iujk_tg_expired[]" value="{{$iujk_tg_expired[$key]}}" autocomplete="off">
                </div>
                @if ($errors->has('iujk_tg_expired.'.$key))
                    <span class="help-block">
                        <strong>{{ $errors->first('iujk_tg_expired.'.$key) }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        {{-- @include('usersupplier::add.__part-sertifikat-dokumen') --}}
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group {{ $errors->has('nama_sertifikat_dokumen.'.$key) ? ' has-error' : '' }}">
                <label for="nama_sertifikat_dokumen" class="col-sm-5 control-label">File Sertifikat</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" placeholder="Nama File" name="nama_sertifikat_dokumen[]" value="{{$nama_sertifikat_dokumen[$key]}}" autocomplete="off">
                  @if ($errors->has('nama_sertifikat_dokumen.'.$key))
                      <span class="help-block">
                          <strong>{{ $errors->first('nama_sertifikat_dokumen.'.$key) }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('file_sertifikat_dokumen.'.$key) ? ' has-error' : '' }}">
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="file" class="hide" name="file_sertifikat_dokumen[]" autocomplete="off">
                    <input class="form-control" type="text" disabled>
                    <span class="input-group-btn">
                      <button class="btn btn-default click-upload" type="button">Browse</button>
                      <input type="hidden" name="file_sertifikat_dokumen_old[]" value="{{$file_sertifikat_dokumen_old[$key]}}">
                    </span>
                  </div>
                  @if(isset($file_sertifikat_dokumen_old[$key]))
                    <span class="help-block">

                    <a href="#" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('usersupplier.sertifikat.file',['filename'=>$file_sertifikat_dokumen_old[$key]])}}">
                    <i class="glyphicon glyphicon-paperclip"></i>{{$file_sertifikat_dokumen_old[$key]}}</a>
                    </span>
                  @endif
                  @if ($errors->has('file_sertifikat_dokumen.'.$key))
                      <span class="help-block">
                          <strong>{{ $errors->first('file_sertifikat_dokumen.'.$key) }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  @endforeach
@else
  <div class="parent-sertifikat">
    <div class="form-horizontal sertifikat">
      <div class="row">
        <div class="form-group button-delete" style="position:relative;margin-top: 25px;margin-bottom: 60px;margin-right:12px;">
        </div>
        <div class="col-sm-5">
          <div class="form-group {{ $errors->has('iujk_no') ? ' has-error' : '' }}">
            <label for="iujk_no" class="col-sm-5 control-label">Sertifikat Keahlian #<span class="total_sertifikat">1</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="No. Sertifikat" name="iujk_no[]" autocomplete="off">
              @if ($errors->has('iujk_no'))
                  <span class="help-block">
                      <strong>{{ $errors->first('iujk_no') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group {{ $errors->has('iujk_tg_terbit') ? ' has-error' : '' }}">
            <label for="iujk_tg_terbit" class="col-sm-4 control-label">Tgl Terbit</label>
            <div class="col-sm-8">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="iujk_tg_terbit[]" autocomplete="off">
              </div>
              @if ($errors->has('iujk_tg_terbit'))
                  <span class="help-block">
                      <strong>{{ $errors->first('iujk_tg_terbit') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group {{ $errors->has('iujk_tg_expired') ? ' has-error' : '' }}">
            <label for="iujk_tg_expired" class="col-sm-4 control-label">Tgl Expired</label>
            <div class="col-sm-8">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="iujk_tg_expired[]" autocomplete="off">
              </div>
              @if ($errors->has('iujk_tg_expired'))
                  <span class="help-block">
                      <strong>{{ $errors->first('iujk_tg_expired') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="form-group {{ $errors->has('nama_sertifikat_dokumen') ? ' has-error' : '' }}">
            <label for="nama_sertifikat_dokumen" class="col-sm-5 control-label">File Sertifikat</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Nama File" name="nama_sertifikat_dokumen[]" autocomplete="off">
              @if ($errors->has('nama_sertifikat_dokumen'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nama_sertifikat_dokumen') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group {{ $errors->has('file_sertifikat_dokumen') ? ' has-error' : '' }}">
            <div class="col-sm-8">
              <div class="input-group">
                <input type="file" class="hide" name="file_sertifikat_dokumen[]" autocomplete="off">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="file_sertifikat_dokumen_old[]">
                </span>
              </div>
              @if ($errors->has('file_sertifikat_dokumen'))
                  <span class="help-block">
                      <strong>{{ $errors->first('file_sertifikat_dokumen') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
      </div>
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
    mdf_new_row.eq(1).find('.help-block').remove();    //iujk_no

    mdf_new_row.eq(2).find('input').val('');   //iujk_tg_terbit
    mdf_new_row.eq(2).find('.help-block').remove();  //iujk_tg_terbit

    mdf_new_row.eq(3).find('input').val('');   //iujk_tg_expired
    mdf_new_row.eq(3).find('.help-block').remove(); //iujk_tg_expired

    mdf_new_row.eq(4).find('input').val('');   //file_sertifikat
    mdf_new_row.eq(4).find('.help-block').remove(); //file_sertifikat

    mdf_new_row.eq(5).find('input').val('');   //file_sertifikat
    mdf_new_row.eq(5).find('.help-block').remove(); //file_sertifikat

    $('.parent-sertifikat').append(new_row);
    $('.date').datepicker(datepicker_ops);
    var row = $('.sertifikat');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.delete-sertifikat');
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(1).find('.total_sertifikat').text(index+1);
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
    console.log($this.length);

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
