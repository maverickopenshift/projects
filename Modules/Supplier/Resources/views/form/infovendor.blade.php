<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Informasi Vendor
          @if($action_type=='lihat' || $action_type=='edit')
            (<span class="text-info" style="font-weight:bold;font-size:20px;"> {{Helper::prop_exists($supplier,'kd_vendor')}}</span>)
          @endif
      </h3>
      @if($action_type=='lihat' || $action_type=='edit')
        @include('supplier::partials.buttons-edit')
      @endif
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group formerror formerror-bdn_usaha">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Badan Usaha</label>
            <div class="col-sm-10">
              {!!Helper::select_badan_usaha(old('bdn_usaha',Helper::prop_exists($supplier,'bdn_usaha')))!!}
              <div class="error error-bdn_usaha"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-nm_vendor">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Perusahaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_vendor" value="{{ old('nm_vendor',Helper::prop_exists($supplier,'nm_vendor')) }}"  placeholder="Masukan Nama Perusahaan" autocomplete="off">
              <div class="error error-nm_vendor"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-nm_vendor_uq">
            <label for="nm_vendor" class="col-sm-2 control-label">Inisial Perusahaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_vendor_uq" value="{{ old('nm_vendor_uq',Helper::prop_exists($supplier,'nm_vendor_uq')) }}" placeholder="Isikan 3 Digit Inisial Perusahaan" autocomplete="off">
              <div class="error error-nm_vendor_uq"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-prinsipal_st">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Prinsipal</label>
            <div class="col-sm-10">
              <select class="form-control" name="prinsipal_st">
                <option value="1" {{ old('prinsipal_st',Helper::prop_exists($supplier,'prinsipal_st'))=='1'?"selected='selected'":"" }}>Ya</option>
                <option value="0" {{ old('prinsipal_st',Helper::prop_exists($supplier,'prinsipal_st'))!='1'?"selected='selected'":"" }}>Tidak</option>
              </select>
              <div class="error error-prinsipal_st"></div>
            </div>
          </div>
          @include('supplier::form.klasifikasi')

          <div class="form-group formerror formerror-pengalaman_kerja">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Pengalaman Kerja</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="pengalaman_kerja"  placeholder="Masukan Pengalaman Kerja">{{ old('pengalaman_kerja',Helper::prop_exists($supplier,'pengalaman_kerja')) }}</textarea>
              <div class="error error-pengalaman_kerja"></div>
            </div>
          </div>
          @if($action_type=='lihat' || $action_type=='edit')
          @include('supplier::partials.buttons')
          @endif
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
var urlKlasifikasi = '{!!route('supplier.klasifikasi.getselect')!!}';
$(function() {
  // autocomp('klasifikasi_usaha',urlKlasifikasi);
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
