<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Informasi Vendor
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group {{ $errors->has('bdn_usaha') ? ' has-error' : '' }}">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Badan Usaha</label>
            <div class="col-sm-10">
              {!!Helper::select_badan_usaha(old('bdn_usaha'))!!}
              @if ($errors->has('bdn_usaha'))
                  <span class="help-block">
                      <strong>{{ $errors->first('bdn_usaha') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('nm_vendor') ? ' has-error' : '' }}">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Perusahaan</label>
            <div class="col-sm-10">
              @if(!Request::is('update'))
              <input type="text" class="form-control" name="nm_vendor" value="{{$old['nm_vendor']}}"  placeholder="Masukan Nama Perusahaan" autocomplete="off">
              @else
              <input type="text" class="form-control" name="nm_vendor" value="{{$old['name']}}"  placeholder="Masukan Nama Perusahaan" autocomplete="off">
              @endif

              <!--<input type="text" class="form-control" name="nm_vendor" value="{{$old['nm_vendor']}}"  placeholder="Masukan Nama Perusahaan" autocomplete="off">
-->
              @if ($errors->has('nm_vendor'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nm_vendor') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('prinsipal_st') ? ' has-error' : '' }}">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Prinsipal</label>
            <div class="col-sm-10">
              <select class="form-control" name="prinsipal_st">
                <option value="1" {{ old('prinsipal_st')=='1'?"selected='selected'":"" }}>Ya</option>
                <option value="0" {{ old('prinsipal_st')!='1'?"selected='selected'":"" }}>Tidak</option>
              </select>
              @if ($errors->has('prinsipal_st'))
                  <span class="help-block">
                      <strong>{{ $errors->first('prinsipal_st') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('klasifikasi_usaha.*') ? ' has-error' : '' }}">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Klasifikasi Usaha</label>
            <div class="col-sm-10">
              @if(count(old('klasifikasi_usaha'))>0)
                @foreach (old('klasifikasi_usaha') as $key => $value)
                  <div class="input-group bottom15 ">
                    <input type="text" class="form-control klasifikasi_usaha" name="klasifikasi_usaha[]" value="{{$value}}" autocomplete="off">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default add-klasifikasi_usaha"><i class="glyphicon glyphicon-plus"></i></button>
                      @if(count(old('klasifikasi_usaha'))>1)
                        <button type="button" class="btn btn-default delete-klasifikasi_usaha"><i class="glyphicon glyphicon-trash"></i></button>
                      @endif
                    </div>
                  </div>
                  @if ($errors->has('klasifikasi_usaha.'.$key))
                      <span class="help-block">
                          <strong>{{ $errors->first('klasifikasi_usaha.'.$key) }}</strong>
                      </span>
                  @endif
                @endforeach
              @else
                <div class="input-group bottom15">
                  <input type="text" class="form-control klasifikasi_usaha" name="klasifikasi_usaha[]" autocomplete="off">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default add-klasifikasi_usaha"><i class="glyphicon glyphicon-plus"></i></button>
                  </div>
                </div>
                @if ($errors->has('klasifikasi_usaha'))
                    <span class="help-block">
                        <strong>{{ $errors->first('klasifikasi_usaha') }}</strong>
                    </span>
                @endif
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('pengalaman_kerja') ? ' has-error' : '' }}">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Pengalaman Kerja</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="pengalaman_kerja"  placeholder="Masukan Pengalaman Kerja">{{ old('pengalaman_kerja') }}</textarea>
              @if ($errors->has('pengalaman_kerja'))
                  <span class="help-block">
                      <strong>{{ $errors->first('pengalaman_kerja') }}</strong>
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
        <input type="text" class="form-control '+attr+'" name="'+attr+'[]"  autocomplete="off">\
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
