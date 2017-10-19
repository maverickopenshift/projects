<div class="box">
    <div class="box-header with-border border-bottom-red">
      <h3 class="box-title">
          Data Employee
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group {{ $errors->has('nm_direktur') ? ' has-error' : '' }}">
            <label for="nm_direktur" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Direktur Utama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_direktur" id="nm_direktur" value="{{ old('nm_direktur') }}"  placeholder="Masukan Nama Direktur Utama">
              @if ($errors->has('nm_direktur'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nm_direktur') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('nm_komisaris') ? ' has-error' : '' }}">
            <label for="nm_komisaris" class="col-sm-2 control-label">Nama Komisaris Utama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_komisaris" id="nm_komisaris" value="{{ old('nm_komisaris') }}"  placeholder="Masukan Nama Komisaris Utama">
              @if ($errors->has('nm_komisaris'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nm_komisaris') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            <label for="kontak" class="col-sm-2 control-label"> Contact Person</label>
            <div class="col-sm-10">
            </div>
            <div class="clearfix"></div>
            <hr  />
          </div>
          <div class="form-group {{ $errors->has('nm_kontak') ? ' has-error' : '' }}">
            <label for="nm_kontak" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_kontak" id="nm_kontak" value="{{ old('nm_kontak') }}" placeholder="Masukan Nama">
              @if ($errors->has('nm_kontak'))
                  <div class="help-block">
                      <strong>{{ $errors->first('nm_kontak') }}</strong>
                  </div>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('phone_kontak') ? ' has-error' : '' }}">
            <label for="phone_kontak" class="col-sm-2 control-label"><span class="text-red">*</span> No Telepon</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="phone_kontak" id="phone_kontak" value="{{ old('phone_kontak') }}"  placeholder="Masukan No Telepon">
              @if ($errors->has('phone_kontak'))
                  <span class="help-block">
                      <strong>{{ $errors->first('phone_kontak') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('alamat_email') ? ' has-error' : '' }}">
            <label for="alamat_email" class="col-sm-2 control-label"><span class="text-red">*</span> Alamat Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="alamat_email" id="alamat_email" value="{{ old('alamat_email') }}"  placeholder="Masukan Alamat Email">
              @if ($errors->has('alamat_email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('alamat_email') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-10">
            </div>
            <div class="clearfix"></div>
            <hr  />
          </div>
          <div class="form-group {{ $errors->has('jum_dom') ? ' has-error' : '' }}">
            <label for="jum_dom" class="col-sm-2 control-label">Jumlah Pegawai Domestik</label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="text" class="form-control" name="jum_dom" id="jum_dom" value="{{ old('jum_dom') }}"  placeholder="Masukan Jumlah Pegawai">
                <span class="input-group-addon">Orang</span>
              </div>

              @if ($errors->has('jum_dom'))
                  <span class="help-block">
                      <strong>{{ $errors->first('jum_dom') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('jum_as') ? ' has-error' : '' }}">
            <label for="jum_as" class="col-sm-2 control-label">Jumlah Pegawai Asing</label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="text" class="form-control" name="jum_as" id="jum_as" value="{{ old('jum_as') }}"  placeholder="Masukan Jumlah Pegawai">
                <span class="input-group-addon">Orang</span>
              </div>
              @if ($errors->has('jum_as'))
                  <span class="help-block">
                      <strong>{{ $errors->first('jum_as') }}</strong>
                  </span>
              @endif
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
