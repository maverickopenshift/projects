{{--
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
        @include('usersupplier::add.__part-sertifikat-dokumen')
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
--}}



<div class="form-group" style="position: relative;margin-top: 15px;margin-bottom: 50px;">
  @if($action_type!='lihat')
  <div class="pull-right">
    <button type="button" class="btn btn-success add-sertifikat"><i class="glyphicon glyphicon-plus"></i> Tambah Sertifikat</button>
  </div>
  @endif
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
            @if($action_type!='lihat')
            @if(count($iujk_no)>1)
              <button type="button" class="btn btn-danger delete-sertifikat" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>
            @endif
            @endif
          </div>
          <div class="col-sm-5">
            <div class="form-group formerror formerror-iujk_no-{{$key}}">
              <label for="iujk_no" class="col-sm-5 control-label">Sertifikat Keahlian #<span class="total_sertifikat">{{$key+1}}</span></label>
              <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="No. Sertifikat" name="iujk_no[]" value="{{$iujk_no[$key]}}" autocomplete="off">
                <div class="error error-iujk_no error-iujk_no-0"></div>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group formerror formerror-iujk_tg_terbit-{{$key}}">
              <label for="iujk_tg_terbit" class="col-sm-4 control-label">Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="iujk_tg_terbit[]" value="{{$iujk_tg_terbit[$key]}}" autocomplete="off">
                </div>
                <div class="error error-iujk_tg_terbit error-iujk_tg_terbit-0"></div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group formerror formerror-iujk_tg_expired-{{$key}}">
              <label for="iujk_tg_expired" class="col-sm-4 control-label">Tgl Expired</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="iujk_tg_expired[]" value="{{$iujk_tg_expired[$key]}}" autocomplete="off">
                </div>
                <div class="error error-iujk_tg_expired error-iujk_tg_expired-0"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-sm-5">
            <div class="form-group formerror formerror-nama_sertifikat_dokumen-{{$key}}">
              <label for="nama_sertifikat_dokumen" class="col-sm-5 control-label">File Sertifikat</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="Nama File" name="nama_sertifikat_dokumen[]" value="{{$nama_sertifikat_dokumen[$key]}}" autocomplete="off">
                <div class="error error-nama_sertifikat_dokumen error-nama_sertifikat_dokumen-0"></div>
              </div>
            </div>
          </div>
          
          <div class="col-sm-6">
            <div class="form-group formerror formerror-file_sertifikat_dokumen-{{$key}}">
              <div class="col-sm-8">
                <div class="input-group">
                  <input type="file" class="hide" name="file_sertifikat_dokumen[]" autocomplete="off">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse </button>
                    <input type="hidden" name="file_sertifikat_dokumen_old[]" value="{{$file_sertifikat_dokumen_old[$key]}}">
                    @if(isset($file_sertifikat_dokumen_old[$key]))
                      <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('usersupplier.sertifikat.file',['filename'=>$file_sertifikat_dokumen_old[$key]])}}">
                      <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                      </a>
                    @endif
                  </span>
                </div>
                                
                <div class="error error-file_sertifikat_dokumen error-file_sertifikat_dokumen-0"></div>
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
          <div class="form-group formerror formerror-iujk_no-0">
            <label for="iujk_no" class="col-sm-5 control-label">Sertifikat Keahlian #<span class="total_sertifikat">1</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="No. Sertifikat" name="iujk_no[]" autocomplete="off">
              <div class="error error-iujk_no error-iujk_no-0"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group formerror formerror-iujk_tg_terbit-0">
            <label for="iujk_tg_terbit" class="col-sm-4 control-label">Tgl Terbit</label>
            <div class="col-sm-8">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="iujk_tg_terbit[]" autocomplete="off">
              </div>
              <div class="error error-iujk_tg_terbit error-iujk_tg_terbit-0"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group formerror formerror-iujk_tg_expired-0">
            <label for="iujk_tg_expired" class="col-sm-4 control-label">Tgl Expired</label>
            <div class="col-sm-8">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="iujk_tg_expired[]" autocomplete="off">
              </div>
              <div class="error error-iujk_tg_expired error-iujk_tg_expired-0"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="form-group formerror formerror-nama_sertifikat_dokumen-0">
            <label for="nama_sertifikat_dokumen" class="col-sm-5 control-label">File Sertifikat</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Nama File" name="nama_sertifikat_dokumen[]" autocomplete="off">
              <div class="error error-nama_sertifikat_dokumen error-nama_sertifikat_dokumen-0"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group formerror formerror-file_sertifikat_dokumen-0">
            <div class="col-sm-8">
              <div class="input-group">
                <input type="file" class="hide" name="file_sertifikat_dokumen[]" autocomplete="off" value="">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="file_sertifikat_dokumen_old[]">
                </span>
              </div>
              <div class="error error-file_sertifikat_dokumen error-file_sertifikat_dokumen-0"></div>
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
  /*
  $(document).on('click', '.add-sertifikat', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-sertifikat" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
    
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
  */
  
  $(document).on('click', '.add-sertifikat', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger delete-sertifikat" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
    
    var $this = $('.sertifikat');
    var new_row = $this.eq(0).clone();
    new_row.find('.has-error').removeClass('has-error');
    var mdf_new_row = new_row.find('.form-group');
    new_row.find('.btn-lihat').remove();

    mdf_new_row.eq(1).find('.total_sertifikat').text($this+1);

    mdf_new_row.eq(1).find('input').val('');
    mdf_new_row.eq(1).find('.error').html('');

    mdf_new_row.eq(2).find('input').val('');
    mdf_new_row.eq(2).find('.error').html('');

    mdf_new_row.eq(3).find('input').val('');
    mdf_new_row.eq(3).find('.error').html('');

    mdf_new_row.eq(4).find('input').val('');
    mdf_new_row.eq(4).find('.error').html('');

    mdf_new_row.eq(5).find('input').val('');
    mdf_new_row.eq(5).find('.error').html('');

    $('.parent-sertifikat').append(new_row);
    $('.date').datepicker(datepicker_ops);
    var row = $('.sertifikat');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.delete-sertifikat');
      var mdf_new_row = $(this).find('.form-group');
      mdf_new_row.eq(1).find('.total_sertifikat').text(index+1);

      if(mdf_new_row.eq(1).hasClass("has-error")){
        mdf_new_row.eq(1).removeClass().addClass("form-group has-error formerror formerror-iujk_no-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("form-group formerror formerror-iujk_no-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("form-group has-error formerror formerror-iujk_tg_terbit-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("form-group formerror formerror-iujk_tg_terbit-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("form-group has-error formerror formerror-iujk_tg_expired-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("form-group formerror formerror-iujk_tg_expired-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("form-group has-error formerror formerror-nama_sertifikat_dokumen-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("form-group formerror formerror-nama_sertifikat_dokumen-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("form-group has-error formerror formerror-file_sertifikat_dokumen-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("form-group formerror formerror-file_sertifikat_dokumen-"+ index);
      }
      
      mdf_new_row.eq(1).find('.error-iujk_no').removeClass().addClass("error error-iujk_no error-iujk_no-"+ index);
      mdf_new_row.eq(2).find('.error-iujk_tg_terbit').removeClass().addClass("error error-iujk_tg_terbit error-iujk_tg_terbit-"+ index);
      mdf_new_row.eq(3).find('.error-iujk_tg_expired').removeClass().addClass("error error-iujk_tg_expired error-iujk_tg_expired-"+ index);
      mdf_new_row.eq(4).find('.error-nama_sertifikat_dokumen').removeClass().addClass("error error-nama_sertifikat_dokumen error-nama_sertifikat_dokumen-"+ index);
      mdf_new_row.eq(5).find('.error-file_sertifikat_dokumen').removeClass().addClass("error error-file_sertifikat_dokumen error-file_sertifikat_dokumen-"+ index);

      if(row.length==1){
        mdf.remove();
      }else{
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

      if(mdf_new_row.eq(1).hasClass("has-error")){
        mdf_new_row.eq(1).removeClass().addClass("form-group has-error formerror formerror-iujk_no-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("form-group formerror formerror-iujk_no-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("form-group has-error formerror formerror-iujk_tg_terbit-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("form-group formerror formerror-iujk_tg_terbit-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("form-group has-error formerror formerror-iujk_tg_expired-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("form-group formerror formerror-iujk_tg_expired-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("form-group has-error formerror formerror-nama_sertifikat_dokumen-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("form-group formerror formerror-nama_sertifikat_dokumen-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("form-group has-error formerror formerror-file_sertifikat_dokumen-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("form-group formerror formerror-file_sertifikat_dokumen-"+ index);
      }
      
      mdf_new_row.eq(1).find('.error-iujk_no').removeClass().addClass("error error-iujk_no error-iujk_no-"+ index);
      mdf_new_row.eq(2).find('.error-iujk_tg_terbit').removeClass().addClass("error error-iujk_tg_terbit error-iujk_tg_terbit-"+ index);
      mdf_new_row.eq(3).find('.error-iujk_tg_expired').removeClass().addClass("error error-iujk_tg_expired error-iujk_tg_expired-"+ index);
      mdf_new_row.eq(4).find('.error-nama_sertifikat_dokumen').removeClass().addClass("error error-nama_sertifikat_dokumen error-nama_sertifikat_dokumen-"+ index);
      mdf_new_row.eq(5).find('.error-file_sertifikat_dokumen').removeClass().addClass("error error-file_sertifikat_dokumen error-file_sertifikat_dokumen-"+ index);
      
      if($this.length==1){
        mdf.remove();
      }
    });
  });
});
</script>
@endpush
