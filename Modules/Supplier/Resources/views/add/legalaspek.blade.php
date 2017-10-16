<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Legal Aspek
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_awal_no') ? ' has-error' : '' }}">
              <label for="akte_awal_no" class="col-sm-5 control-label"><span class="text-red">*</span> No Akte Pendirian</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="akte_awal_no" value="{{ old('akte_awal_no') }}">
                @if ($errors->has('akte_awal_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('akte_awal_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_awal_tg') ? ' has-error' : '' }}">
              <label for="akte_awal_tg" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="akte_awal_tg" value="{{ old('akte_awal_tg') }}">
                </div>
                @if ($errors->has('akte_awal_tg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('akte_awal_tg') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_awal_notaris') ? ' has-error' : '' }}">
              <label for="akte_awal_notaris" class="col-sm-5 control-label"><span class="text-red">*</span> Notaris</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="akte_awal_notaris" value="{{ old('akte_awal_notaris') }}">
                @if ($errors->has('akte_awal_notaris'))
                    <span class="help-block">
                        <strong>{{ $errors->first('akte_awal_notaris') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_akhir_no') ? ' has-error' : '' }}">
              <label for="akte_akhir_no" class="col-sm-5 control-label"><span class="text-red">*</span> No Akte Perubahan</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="akte_akhir_no" value="{{ old('akte_akhir_no') }}">
                @if ($errors->has('akte_akhir_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('akte_akhir_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_akhir_tg') ? ' has-error' : '' }}">
              <label for="akte_akhir_tg" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="akte_akhir_tg" value="{{ old('akte_akhir_tg') }}">
                </div>
                @if ($errors->has('akte_akhir_tg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('akte_akhir_tg') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_akhir_notaris') ? ' has-error' : '' }}">
              <label for="akte_akhir_notaris" class="col-sm-5 control-label"><span class="text-red">*</span> Notaris</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="akte_awal_notaris" value="{{ old('akte_akhir_notaris') }}">
                @if ($errors->has('akte_akhir_notaris'))
                    <span class="help-block">
                        <strong>{{ $errors->first('akte_akhir_notaris') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('siup_no') ? ' has-error' : '' }}">
              <label for="siup_no" class="col-sm-5 control-label"><span class="text-red">*</span> No SIUP</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="siup_no" value="{{ old('siup_no') }}">
                @if ($errors->has('siup_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('siup_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('siup_tg_terbit') ? ' has-error' : '' }}">
              <label for="siup_tg_terbit" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="siup_tg_terbit" value="{{ old('siup_tg_terbit') }}">
                </div>
                @if ($errors->has('siup_tg_terbit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('siup_tg_terbit') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('siup_tg_expired') ? ' has-error' : '' }}">
              <label for="siup_tg_expired" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Expired</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="siup_tg_expired" value="{{ old('siup_tg_expired') }}">
                </div>
                @if ($errors->has('siup_tg_expired'))
                    <span class="help-block">
                        <strong>{{ $errors->first('siup_tg_expired') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-12">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('siup_kualifikasi') ? ' has-error' : '' }}">
              <label for="siup_kualifikasi" class="col-sm-2 control-label"><span class="text-red">*</span> Kualifikasi SIUP</label>
              <div class="col-sm-10">
                <label class="radio-inline">
                  <input class="check-me" type="radio" name="siup_kualifikasi" {{old('siup_kualifikasi')=='1'?'checked':''}}> Besar
                </label>
                <label class="radio-inline">
                  <input class="check-me" type="radio" name="siup_kualifikasi" {{old('siup_kualifikasi')=='2'?'checked':''}}> Menengah
                </label>
                <label class="radio-inline">
                  <input class="check-me" type="radio" name="siup_kualifikasi" {{old('siup_kualifikasi')=='3'?'checked':''}}> Kecil
                </label>
                @if ($errors->has('siup_kualifikasi'))
                    <span class="help-block">
                        <strong>{{ $errors->first('siup_kualifikasi') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function(){
  $('input').iCheck('uncheck');
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });
});
</script>
@endpush
