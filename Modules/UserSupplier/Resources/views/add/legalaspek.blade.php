<div class="box">
    <div class="box-header with-border border-bottom-red">
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
                <input type="text" class="form-control" name="akte_akhir_notaris" value="{{ old('akte_akhir_notaris') }}">
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
                  <input class="check-me" type="radio" name="siup_kualifikasi" value="1"> Besar
                </label>
                <label class="radio-inline">
                  <input class="check-me" type="radio" name="siup_kualifikasi" value="2"> Menengah
                </label>
                <label class="radio-inline">
                  <input class="check-me" type="radio" name="siup_kualifikasi" value="3"> Kecil
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
        <div class="col-sm-12">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('pkp') ? ' has-error' : '' }}">
              <label for="pkp" class="col-sm-2 control-label"><span class="text-red">*</span> Perusahaan Kena Pajak</label>
              <div class="col-sm-10">
                <select class="form-control" name="pkp">
                  <option value="1" {{ old('pkp')=='1'?"selected='selected'":"" }}>Ya</option>
                  <option value="0" {{ old('pkp')!='1'?"selected='selected'":"" }}>Tidak</option>
                </select>
                <small> Jika Ya Maka NPWP Wajib Diisi </small>
                @if ($errors->has('pkp'))
                    <span class="help-block">
                        <strong>{{ $errors->first('pkp') }}</strong>
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
            <div class="form-group {{ $errors->has('npwp_no') ? ' has-error' : '' }}">
              <label for="npwp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No NPWP</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="npwp_no" value="{{ old('npwp_no') }}">
                @if ($errors->has('npwp_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('npwp_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('npwp_tg') ? ' has-error' : '' }}">
              <label for="npwp_tg" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="npwp_tg" value="{{ old('npwp_tg') }}">
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
      </div>

      <div class="row">
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('tdp_no') ? ' has-error' : '' }}">
              <label for="tdp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No TDP (Pemda)</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="tdp_no" value="{{ old('tdp_no') }}">
                @if ($errors->has('tdp_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('tdp_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('tdp_tg_terbit') ? ' has-error' : '' }}">
              <label for="tdp_tg_terbit" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="tdp_tg_terbit" value="{{ old('tdp_tg_terbit') }}">
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
              <label for="tdp_tg_expired" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Expired</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="tdp_tg_expired" value="{{ old('tdp_tg_expired') }}">
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
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('idp_no') ? ' has-error' : '' }}">
              <label for="idp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No IDP/SITU (Pemda)</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="idp_no" value="{{ old('idp_no') }}">
                @if ($errors->has('idp_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('idp_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group {{ $errors->has('idp_tg_terbit') ? ' has-error' : '' }}">
              <label for="idp_tg_terbit" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="idp_tg_terbit" value="{{ old('idp_tg_terbit') }}">
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
              <label for="idp_tg_expired" class="col-sm-5 control-label"><span class="text-red">*</span> Tgl Expired</label>
              <div class="col-sm-7">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="idp_tg_expired" value="{{ old('idp_tg_expired') }}">
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
        <hr  />
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-2 control-label"><span class="text-red">*</span> Legal Dokumen</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="dokumen[]" value="">
              </div>
              <div class="col-sm-2">
                <input type="file" name="dokumen[]">
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
              </div>
              <div class="col-sm-10">
                <hr  />
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
var urlKlasifikasi = '{!!route('supplier.klasifikasi.getselect')!!}';
$(function() {
  autocomp('klasifikasi_usaha',urlKlasifikasi);
  add_select('klasifikasi_usaha');
  delete_select('klasifikasi_usaha');
});
function add_select(attr) {
  $(document).on('click','.add-'+attr,function(){
    var _this = $(this);
    var content = _this.parent().parent();
    var btnDelete = content.find('.delete-'+attr);
    if(btnDelete.length==0){
      content.find('.input-group-btn').append('<button type="button" class="btn btn-default delete-'+attr+'"><i class="glyphicon glyphicon-trash"></i></button>');
    }
    content.after(create_content(attr));
    if(attr=='klasifikasi_usaha'){
      autocomp(attr,urlKlasifikasi);
    }
  });
}
function delete_select(attr) {
  $(document).on('click','.delete-'+attr,function(){
    var _this = $(this);
    var content = _this.parent().parent();
    content.remove();
    var attrNya = $('.'+attr);
    if(attrNya.length==1){
      attrNya.parent().find('.delete-'+attr).remove();
    }
  });
}
function create_content(attr){
  var content = $('.'+attr),btnDelete;
  //console.log(content.length)
  if(content.length>0){
    btnDelete = '<button type="button" class="btn btn-default delete-'+attr+'"><i class="glyphicon glyphicon-trash"></i></button>'
  }
  return '<div class="input-group bottom15">\
        <input type="text" class="form-control '+attr+'" name="'+attr+'[]">\
        <div class="input-group-btn">\
          <button type="button" class="btn btn-default add-'+attr+'"><i class="glyphicon glyphicon-plus"></i></button>\
          '+btnDelete+'\
        </div>\
      </div>';
}
function autocomp(attr,url) {
  $('.'+attr).autocomplete({
    serviceUrl: url,
    onSelect: function (suggestion) {
      // var _this = $(this);
      // _this.parent().removeClass('input-groups').addClass('input-group').find('.input-group-btn').removeClass('hide');
      // console.log($(this));
    },
    dataType: 'json',
    paramName:'q',
  });
}
</script>
@endpush
