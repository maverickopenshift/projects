<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Legal Aspek
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_awal_no') ? ' has-error' : '' }}">
              <label for="akte_awal_no" class="col-sm-5 control-label"><span class="text-red">*</span> No Akte Pendirian</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="akte_awal_no" value="{{ old('akte_awal_no',Helper::prop_exists($supplier,'akte_awal_no')) }}" autocomplete="off">
                @if ($errors->has('akte_awal_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('akte_awal_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_awal_tg') ? ' has-error' : '' }}">
              <label for="akte_awal_tg" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="akte_awal_tg" value="{{ old('akte_awal_tg',Helper::prop_exists($supplier,'akte_awal_tg')) }}" autocomplete="off">
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
              <label for="akte_awal_notaris" class="col-sm-4 control-label"><span class="text-red">*</span> Notaris</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="akte_awal_notaris" value="{{ old('akte_awal_notaris',Helper::prop_exists($supplier,'akte_awal_notaris')) }}" autocomplete="off">
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
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_akhir_no') ? ' has-error' : '' }}">
              <label for="akte_akhir_no" class="col-sm-5 control-label"><span class="text-red">*</span> No Akte Perubahan</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="akte_akhir_no" value="{{ old('akte_akhir_no',Helper::prop_exists($supplier,'akte_akhir_no')) }}" autocomplete="off">
                @if ($errors->has('akte_akhir_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('akte_akhir_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('akte_akhir_tg') ? ' has-error' : '' }}">
              <label for="akte_akhir_tg" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="akte_akhir_tg" value="{{ old('akte_akhir_tg',Helper::prop_exists($supplier,'akte_akhir_tg')) }}" autocomplete="off">
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
              <label for="akte_akhir_notaris" class="col-sm-4 control-label"><span class="text-red">*</span> Notaris</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="akte_akhir_notaris" value="{{ old('akte_akhir_notaris',Helper::prop_exists($supplier,'akte_akhir_notaris')) }}" autocomplete="off">
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
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('siup_no') ? ' has-error' : '' }}">
              <label for="siup_no" class="col-sm-5 control-label"><span class="text-red">*</span> No SIUP</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="siup_no" value="{{ old('siup_no',Helper::prop_exists($supplier,'siup_no')) }}" autocomplete="off">
                @if ($errors->has('siup_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('siup_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('siup_tg_terbit') ? ' has-error' : '' }}">
              <label for="siup_tg_terbit" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="siup_tg_terbit" value="{{ old('siup_tg_terbit',Helper::prop_exists($supplier,'siup_tg_terbit')) }}" autocomplete="off">
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
              <label for="siup_tg_expired" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Expired</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="siup_tg_expired" value="{{ old('siup_tg_expired',Helper::prop_exists($supplier,'siup_tg_expired')) }}" autocomplete="off">
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
                <label class="radio-inline" style="padding-left:7px">
                  <input class="check-me" type="radio" value="1" name="siup_kualifikasi" {{!old('siup_kualifikasi',Helper::prop_exists($supplier,'siup_kualifikasi'))?'checked':''}} {{old('siup_kualifikasi',Helper::prop_exists($supplier,'siup_kualifikasi'))=='1'?'checked':''}}> Besar
                </label>
                <label class="radio-inline">
                  <input class="check-me" type="radio" value="2" name="siup_kualifikasi" {{old('siup_kualifikasi',Helper::prop_exists($supplier,'siup_kualifikasi'))=='2'?'checked':''}}> Menengah
                </label>
                <label class="radio-inline">
                  <input class="check-me" type="radio" value="3" name="siup_kualifikasi" {{old('siup_kualifikasi',Helper::prop_exists($supplier,'siup_kualifikasi'))=='3'?'checked':''}}> Kecil
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
      
      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('pkp') ? ' has-error' : '' }}">
              <label for="pkp" class="col-sm-5 control-label"><span class="text-red">*</span> Perusahaan Kena Pajak</label>
              <div class="col-sm-7">
                <select class="form-control" name="pkp">
                  <option value="1" {{ old('pkp',Helper::prop_exists($supplier,'pkp'))=='1'?"selected='selected'":"" }}>Ya</option>
                  <option value="0" {{ old('pkp',Helper::prop_exists($supplier,'pkp'))=='0'?"selected='selected'":"" }}>Tidak</option>
                </select>
                @if ($errors->has('pkp'))
                    <span class="help-block">
                        <strong>{{ $errors->first('pkp') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
              <div class="col-sm-12 text-info"> Jika Ya maka NPWP wajib diisi</div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      
      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('npwp_no') ? ' has-error' : '' }}">
              <label for="npwp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No NPWP</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="npwp_no" value="{{ old('npwp_no',Helper::prop_exists($supplier,'npwp_no')) }}" autocomplete="off">
                @if ($errors->has('npwp_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('npwp_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('npwp_tg') ? ' has-error' : '' }}">
              <label for="npwp_tg" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="npwp_tg" value="{{ old('npwp_tg',Helper::prop_exists($supplier,'npwp_tg')) }}" autocomplete="off">
                </div>
                @if ($errors->has('npwp_tg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('npwp_tg') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      
      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('tdp_no') ? ' has-error' : '' }}">
              <label for="tdp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No TDP (Pemda)</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="tdp_no" value="{{ old('tdp_no',Helper::prop_exists($supplier,'tdp_no')) }}" autocomplete="off">
                @if ($errors->has('tdp_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('tdp_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('tdp_tg_terbit') ? ' has-error' : '' }}">
              <label for="tdp_tg_terbit" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="tdp_tg_terbit" value="{{ old('tdp_tg_terbit',Helper::prop_exists($supplier,'tdp_tg_terbit')) }}" autocomplete="off">
                </div>
                @if ($errors->has('tdp_tg_terbit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('tdp_tg_terbit') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
              <div class="form-group {{ $errors->has('tdp_tg_expired') ? ' has-error' : '' }}">
                <label for="tdp_tg_expired" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Expired</label>
                <div class="col-sm-8">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control" name="tdp_tg_expired" value="{{ old('tdp_tg_expired',Helper::prop_exists($supplier,'tdp_tg_expired')) }}" autocomplete="off">
                  </div>
                  @if ($errors->has('tdp_tg_expired'))
                      <span class="help-block">
                          <strong>{{ $errors->first('tdp_tg_expired') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('idp_no') ? ' has-error' : '' }}">
              <label for="idp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No IDP/SITU (Pemda)</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="idp_no" value="{{ old('idp_no',Helper::prop_exists($supplier,'idp_no')) }}" autocomplete="off">
                @if ($errors->has('idp_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('idp_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('idp_tg_terbit') ? ' has-error' : '' }}">
              <label for="idp_tg_terbit" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="idp_tg_terbit" value="{{ old('idp_tg_terbit',Helper::prop_exists($supplier,'idp_tg_terbit')) }}" autocomplete="off">
                </div>
                @if ($errors->has('idp_tg_terbit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('idp_tg_terbit') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
              <div class="form-group {{ $errors->has('idp_tg_expired') ? ' has-error' : '' }}">
                <label for="idp_tg_expired" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Expired</label>
                <div class="col-sm-8">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control" name="idp_tg_expired" value="{{ old('idp_tg_expired',Helper::prop_exists($supplier,'idp_tg_expired')) }}" autocomplete="off">
                  </div>
                  @if ($errors->has('idp_tg_expired'))
                      <span class="help-block">
                          <strong>{{ $errors->first('idp_tg_expired') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <div class="clearfix"></div>
        <hr  />
      </div>
      
      @include('supplier::form.__part-legal-dokumen')
      
      <div class="form-group">
        <div class="clearfix"></div>
        <hr  />
      </div>
      
      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('iujk_no') ? ' has-error' : '' }}">
              <label for="iujk_no" class="col-sm-5 control-label"><span class="text-red">*</span> Sertifikat Keahlian</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="No. Sertifikat" name="iujk_no" value="{{ old('iujk_no',Helper::prop_exists($supplier,'iujk_no')) }}" autocomplete="off">
                @if ($errors->has('iujk_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('iujk_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('iujk_tg_terbit') ? ' has-error' : '' }}">
              <label for="iujk_tg_terbit" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="iujk_tg_terbit" value="{{ old('iujk_tg_terbit',Helper::prop_exists($supplier,'iujk_tg_terbit')) }}" autocomplete="off">
                </div>
                @if ($errors->has('iujk_tg_terbit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('iujk_tg_terbit') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
              <div class="form-group {{ $errors->has('iujk_tg_expired') ? ' has-error' : '' }}">
                <label for="iujk_tg_expired" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Expired</label>
                <div class="col-sm-8">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control" name="iujk_tg_expired" value="{{ old('iujk_tg_expired',Helper::prop_exists($supplier,'iujk_tg_expired')) }}" autocomplete="off">
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
      </div>
      @include('supplier::form.__part-sertifikat-dokumen')
      @include('supplier::partials.buttons')
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function(){
  //$('input').iCheck('uncheck');
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });
  add_field_x('legal-dokumen');
  delete_field_x('legal-dokumen');
  add_field_x('sertifikat-dokumen');
  delete_field_x('sertifikat-dokumen');
});

function delete_field_x(attr) {
  $(document).on('click', '.delete-'+attr, function(event) {
    var $parent = $(this).parent().parent();
    $parent.remove();
    var row_p = $('.row-'+attr);
    row_p.find('.add-'+attr).remove();
    var btn_cl = '<button type="button" class="btn btn-danger add-'+attr+'"><i class="glyphicon glyphicon-plus"></i></button>';
    if(row_p.length==1){
      row_p.find('.delete-'+attr).remove();
    }
    row_p.eq(row_p.length-1).find('.attr-btn').append(btn_cl);
  });
}
function add_field_x(attr) {
  $(document).on('click', '.add-'+attr, function(event) {
    event.preventDefault();
    /* Act on the event */
    var $this = $(this);
    var $clone_btn = $this.clone();
    var $parent = $(this).parent().parent().parent();
    var $clone = $(this).parent().parent();
    var btn_del = '<button style="margin-right:15px;" type="button" class="btn btn-default delete-'+attr+'"><i class="glyphicon glyphicon-remove"></i></button>';
    $this.remove();
    var $new_clone = $($clone).clone();
    $new_clone.find('input[type="file"]').val('');
    $new_clone.find('input[type="text"]').val('');
    $new_clone.find('.help-block').remove();
    $new_clone.find('.attr-btn').append($clone_btn);
    $new_clone.appendTo($parent);
    
    var row_p = $('.row-'+attr);
    if(row_p.length>1){
      $.each( row_p, function( key, value ) {
        var l_btn = $(this).find('.delete-'+attr);
        if(l_btn.length==0){
          $(this).find('.attr-btn').prepend(btn_del)
        }
      });
    }
    else{
      $new_clone.find('.delete-'+attr).remove()
    }
  });
}
</script>
@endpush
