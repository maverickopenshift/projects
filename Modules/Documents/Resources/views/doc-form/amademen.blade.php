<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">
        General Info
    </h3>
  </div>
  <div class="box-body">
    <div class="form-horizontal">
      @include('documents::form-penomoran-otomatis')
      <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        @if($doc_type->name=='amandemen_sp')
          @include('documents::doc-form.no-sp')
        @else
          @include('documents::doc-form.no-kontrak')
        @endif

        <div class="form-group formerror formerror-doc_desc">
          <label for="deskripsi_kontrak" class="col-sm-2 control-label">Deskripsi {{$doc_type['title']}}</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" name="doc_desc" placeholder="Masukan Deskripsi Kontrak">{{old('doc_desc',Helper::prop_exists($doc,'doc_desc'))}}</textarea>
            <div class="error error-doc_desc"></div>
          </div>
        </div>

        <div class="form-group formerror formerror-doc_startdate">
          <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai {{$doc_type['title']}}</label>
          <div class="col-sm-6">
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control datepicker" name="doc_startdate" value="{{old('doc_startdate',Helper::prop_exists($doc,'doc_startdate'))}}" autocomplete="off">
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-2">
            <div class="error error-doc_startdate"></div>
          </div>
        </div>

        <div class="form-group formerror formerror-doc_enddate">
          <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir {{$doc_type['title']}}</label>
          <div class="col-sm-6">
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control datepicker" name="doc_enddate" value="{{old('doc_enddate',Helper::prop_exists($doc,'doc_enddate'))}}" autocomplete="off">
            </div>
          </div>
          <div class="col-sm-10 col-sm-offset-2">
            <div class="error error-doc_enddate"></div>
          </div>
        </div>
      </div>

      <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        @include('documents::doc-form.general-info-right')
        @include('documents::doc-form.lampiran-1')
      </div>
        @include('documents::partials.buttons')
    </div>
  </div>
</div>
@push('scripts')
<script>
$(function() {
  add_select('doc_lampiran');
  delete_select('doc_lampiran');

  function add_select(attr) {
    $(document).on('click','.add-'+attr,function(){
      var _this = $(this);
      var content = _this.parent().parent();
      var btnDelete = content.find('.delete-'+attr);
      if(btnDelete.length==0){
        content.find('.input-group-btn').append('<button type="button" class="btn btn-default delete-'+attr+'"><i class="glyphicon glyphicon-trash"></i></button>');
      }
      content.after(create_content(attr));
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
    return '<div class="input-group">\
      <input type="file" class="hide" name="'+attr+'[]">\
      <input class="form-control" type="text" name="name_lampiran[]" val="lampiran"  disabled>\
      <div class="input-group-btn">\
        <button class="btn btn-default click-upload" type="button">Browse</button>\
        <button type="button" class="btn btn-default add-'+attr+'"><i class="glyphicon glyphicon-plus"></i></button>\
        '+btnDelete+'\
      </div>\
    </div>';
  }

  var selectUserVendor = $(".select-user-vendor").select2({
      placeholder : "Pilih Pihak II....",
      ajax: {
          url: '{!! route('supplier.get-select') !!}',
          dataType: 'json',
          delay: 350,
          data: function (params) {
              return {
                  q: params.term, // search term
                  page: params.page
              };
          },

          processResults: function (data, params) {
              var results = [];

              $.each(data.data, function (i, v) {
                  var o = {};
                  o.id = v.id;
                  o.name = v.nm_vendor;
                  o.value = v.id;
                  o.username = v.kd_vendor;
                  o.bdn_usaha = v.bdn_usaha;
                  results.push(o);
              })
              params.page = params.page || 1;
              return {
                  results: results,
                  pagination: {
                      more: (data.next_page_url ? true: false)
                  }
              };
          },
          cache: true
      },
      escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      minimumInputLength: 0,
      templateResult: templateResultVendor,
      templateSelection: templateSelectionVendor
  });

  function templateResultVendor(state) {
    if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ; }
    var $state = $(
        '<span>' +  state.bdn_usaha+'.'+state.name +' <i>('+  state.username + ')</i></span>'
    );
    return $state;
  }

  function templateSelectionVendor(data) {
    if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
        return "Pilih Pihak II...";
    }
    var render = data.bdn_usaha+'.'+data.name +' - '+  data.username ;
    if(data.bdn_usaha === undefined){
      render = $('.select-user-vendor :selected').text();
    }
    $('.select-user-vendor-text').val(render);
    return render ;
  }

  var user_vendor = $(".select-user-vendor");
  if(user_vendor.data('id')!==""){
    var newOption = new Option($(".select-user-vendor-text").val(), user_vendor.data('id'), false, true);
    user_vendor.append(newOption);
    user_vendor.val(user_vendor.data('id')).change();
  }
})
</script>
@endpush
