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
              <input type="text" class="form-control" name="nm_vendor" value="{{ old('nm_vendor') }}">
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
          <div class="form-group {{ $errors->has('klasifikasi_usaha') ? ' has-error' : '' }}">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Klasifikasi Usaha</label>
            <div class="col-sm-10">
              <div class="input-group bottom15">
                <input type="text" class="form-control klasifikasi_usaha" name="klasifikasi_usaha[]">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default add-klasifikasi"><i class="glyphicon glyphicon-plus"></i></button>
                </div>
              </div>
              @if ($errors->has('klasifikasi_usaha'))
                  <span class="help-block">
                      <strong>{{ $errors->first('klasifikasi_usaha') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          {{-- <div class="form-group {{ $errors->has('pengalaman_kerja') ? ' has-error' : '' }}">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Pengalaman Kerja</label>
            <div class="col-sm-10">
              <div class="input-group bottom15">
                <input type="text" class="form-control klasifikasi_usaha" name="pengalaman_kerja[]">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default add-klasifikasi"><i class="glyphicon glyphicon-plus"></i></button>
                </div>
              </div>
              @if ($errors->has('klasifikasi_usaha'))
                  <span class="help-block">
                      <strong>{{ $errors->first('klasifikasi_usaha') }}</strong>
                  </span>
              @endif
            </div>
          </div> --}}
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  // autocomp();
  // $(document).on('click','.add-klasifikasi',function(){
  //   var _this = $(this);
  //   var content = _this.parent().parent();
  //   var btnDelete = content.find('.delete-klasifikasi');
  //   if(btnDelete.length==0){
  //     content.find('.input-group-btn').append('<button type="button" class="btn btn-default delete-klasifikasi"><i class="glyphicon glyphicon-trash"></i></button>');
  //   }
  //   content.after(create_klasifikasi());
  //   autocomp();
  // });
  // $(document).on('click','.delete-klasifikasi',function(){
  //   var _this = $(this);
  //   var content = _this.parent().parent();
  //   content.remove();
  //   var klasifikasiUsaha = $('.klasifikasi_usaha');
  //   if(klasifikasiUsaha.length==1){
  //     klasifikasiUsaha.parent().find('.delete-klasifikasi').remove();
  //   }
  // });
  var app = {
    type : false,
    attr : false,
    name : false,
    input_autocomplete : false,
    url_autocomplete : false,
    init : function () {
      app.autocomplete();
      app.add_field();
      app.delete_field();
    },
    create_content : function () {
      var content = $(this.attr),btnDelete;
      //console.log(content.length)
      if(content.length>0){
        btnDelete = '<button type="button" class="btn btn-default delete-'+this.type+'"><i class="glyphicon glyphicon-trash"></i></button>'
      }
      return '<div class="input-group bottom15">\
            <input type="text" class="form-control '+this.attr+'" name="'+this.name+'">\
            <div class="input-group-btn">\
              <button type="button" class="btn btn-default add-'+this.type+'"><i class="glyphicon glyphicon-plus"></i></button>\
              '+btnDelete+'\
            </div>\
          </div>';
    },
    add_field : function() {
      $(document).on('click','.add-'+this.type,function(){
        var _this = $(this);
        var content = _this.parent().parent();
        var btnDelete = content.find('.delete-'+this.type);
        if(btnDelete.length==0){
          content.find('.input-group-btn').append('<button type="button" class="btn btn-default delete-'+this.type+'"><i class="glyphicon glyphicon-trash"></i></button>');
        }
        console.log(btnDelete.length);
        content.after(app.create_content());
        if(this.input_autocomplete){
          app.autocomplete();
        }
      });
    },
    autocomplete : function () {
      $(this.attr).autocomplete({
        serviceUrl: this.url_autocomplete,
        onSelect: function (suggestion) {
          // var _this = $(this);
          // _this.parent().removeClass('input-groups').addClass('input-group').find('.input-group-btn').removeClass('hide');
          // console.log($(this));
        },
        dataType: 'json',
        paramName:'q',
      });
    },
    delete_field : function () {
      $(document).on('click','.delete-'+this.type,function(){
        var _this = $(this);
        var content = _this.parent().parent();
        content.remove();
        var klasifikasiUsaha = $(this.attr);
        if(klasifikasiUsaha.length==1){
          klasifikasiUsaha.parent().find('.delete-'+this.type).remove();
        }
      });
    }
  };
  app.type = 'klasifikasi';
  app.attr = '.klasifikasi_usaha';
  app.name = 'klasifikasi_usaha[]';
  app.input_autocomplete = true;
  app.url_autocomplete = '{!!route('supplier.klasifikasi.getselect')!!}';
  app.init();
});
function content_klasifikasi(){
  var content = $('.klasifikasi_usaha'),btnDelete;
  //console.log(content.length)
  if(content.length>0){
    btnDelete = '<button type="button" class="btn btn-default delete-klasifikasi"><i class="glyphicon glyphicon-trash"></i></button>'
  }
  return '<div class="input-group bottom15">\
        <input type="text" class="form-control klasifikasi_usaha" name="klasifikasi_usaha[]">\
        <div class="input-group-btn">\
          <button type="button" class="btn btn-default add-klasifikasi"><i class="glyphicon glyphicon-plus"></i></button>\
          '+btnDelete+'\
        </div>\
      </div>';
}
function autocomp() {
  $('.klasifikasi_usaha').autocomplete({
    serviceUrl: '{!!route('supplier.klasifikasi.getselect')!!}',
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
