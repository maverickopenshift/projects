<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group {{ $errors->has('jdl_kontrak') ? ' has-error' : '' }}">
            <label for="jdl_kontrak" class="col-sm-2 control-label"><span class="text-red">*</span> Judul Kontrak</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="jdl_kontrak" value="{{ old('jdl_kontrak') }}" placeholder="Masukan Judul Kontrak" autocomplete="off">
              @if ($errors->has('jdl_kontrak'))
                  <span class="help-block">
                      <strong>{{ $errors->first('jdl_kontrak') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('pihak1') ? ' has-error' : '' }}">
            <label for="pihak1" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak I</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="pihak1" value="{{ old('pihak1') }}" placeholder="Masukan Pihak ke 1" autocomplete="off">
              @if ($errors->has('pihak1'))
                  <span class="help-block">
                      <strong>{{ $errors->first('pihak1') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('pihak2') ? ' has-error' : '' }}">
            <label for="pihak2" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak II</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="pihak2" value="{{ old('pihak2') }}" placeholder="Masukan Pihak ke 2" autocomplete="off">
              @if ($errors->has('pihak2'))
                  <span class="help-block">
                      <strong>{{ $errors->first('pihak2') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('tgl_kontrak') ? ' has-error' : '' }}">
            <label for="tgl_kontrak" class="col-sm-2 control-label"><span class="text-red">*</span> Tgl Kontrak</label>
            <div class="col-sm-10">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="tgl_kontrak" value="{{ old('tgl_kontrak') }}" autocomplete="off">
              </div>
              @if ($errors->has('tgl_kontrak'))
                  <span class="help-block">
                      <strong>{{ $errors->first('tgl_kontrak') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('metode_pengadaan') ? ' has-error' : '' }}">
            <label for="metode_pengadaan" class="col-sm-2 control-label"><span class="text-red">*</span> Cara Pengadaan</label>
            <div class="col-sm-10">
              <select class="form-control">
                <option value="">Pelelangan</option>
                <option value="">Pemilihan Langsung</option>
                <option value="">Penunjukan Langsung</option>
              </select>
              @if ($errors->has('metode_pengadaan'))
                  <span class="help-block">
                      <strong>{{ $errors->first('metode_pengadaan') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('nl_kontrak') ? ' has-error' : '' }}">
            <label for="nl_kontrak" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Kontrak</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nl_kontrak" value="{{ old('nl_kontrak') }}" placeholder="Masukan Nilai Kontrak" autocomplete="off">
              @if ($errors->has('nl_kontrak'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nl_kontrak') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('unit_penanggung_jawab') ? ' has-error' : '' }}">
            <label for="unit_penanggung_jawab" class="col-sm-2 control-label"><span class="text-red">*</span> Unit Penanggungjawab</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="unit_penanggung_jawab" value="{{ old('unit_penanggung_jawab') }}" placeholder="Masukan Penanggung Jawab Kontrak" autocomplete="off">
              @if ($errors->has('unit_penanggung_jawab'))
                  <span class="help-block">
                      <strong>{{ $errors->first('unit_penanggung_jawab') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('pic') ? ' has-error' : '' }}">
            <label for="pic" class="col-sm-2 control-label"><span class="text-red">*</span> PIC</label>
            <div class="col-sm-10">
              <a class="btn btn-app" href="#">+</a>
              @if ($errors->has('pic'))
                  <span class="help-block">
                      <strong>{{ $errors->first('pic') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('po_sap.*') ? ' has-error' : '' }}">
            <label for="po_sap" class="col-sm-2 control-label"><span class="text-red">*</span> PO SAP</label>
            <div class="col-sm-10">
              <div class="input-group bottom15">
                  <input type="text" class="form-control po_sap" name="po_sap[]" autocomplete="off">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default add-po_sap"><i class="glyphicon glyphicon-plus"></i></button>
                  </div>
                </div>
                @if ($errors->has('po_sap'))
                    <span class="help-block">
                        <strong>{{ $errors->first('po_sap') }}</strong>
                    </span>
                @endif
            </div>
          </div>





            @include('usersupplier::partials.buttons')
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
