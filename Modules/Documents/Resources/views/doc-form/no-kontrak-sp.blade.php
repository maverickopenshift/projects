<div class="form-group  {{ $errors->has('parent_kontrak_sp') ? ' has-error' : '' }}">
  <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> No Kontrak Induk</label>
  <div class="col-sm-10">
    <input type="hidden" class="select-kontrak-text-sp" name="parent_kontrak_text_sp" value="{{Helper::old_prop($doc,'parent_kontrak_text_sp')}}">
    <select class="form-control select-kontrak-sp" style="width: 100%;" name="parent_kontrak_sp" data-id="{{Helper::old_prop($doc,'parent_kontrak_sp')}}">
    </select>
    @if ($errors->has('parent_kontrak_sp'))
        <span class="help-block">
            <strong>{{ $errors->first('parent_kontrak_sp') }}</strong>
        </span>
    @endif
  </div>
</div>
@push('scripts')
  <script>
  $(function() {
    var selectKontrakSP = $(".select-kontrak-sp").select2({
      placeholder : "Pilih Kontrak....",
      ajax: {
          url: '{!! route('doc.get-select-kontrak') !!}',
          dataType: 'json',
          delay: 250,
          data: function (params) {
              return {
                  q: params.term, // search term
                  type:'{!!$doc_type->name!!}',
                  page: params.page
              };
          },
          //id: function(data){ return data.store_id; },
          processResults: function (data, params) {
              // parse the results into the format expected by Select2
              // since we are using custom formatting functions we do not need to
              // alter the remote JSON data, except to indicate that infinite
              // scrolling can be used

              var results = [];

              $.each(data.data, function (i, v) {
                  var o = {};
                  var startdate=(v.doc_startdate!==null)?$.format.date(v.doc_startdate+" 10:54:50", "dd-MM-yyyy"):'-';
                  var enddate=(v.doc_enddate!==null)?$.format.date(v.doc_enddate+" 10:54:50", "dd-MM-yyyy"):'-';
                  o.id = v.id;
                  o.name = v.doc_title;
                  o.value = v.doc_no;
                  o.date = $.format.date(v.doc_date+" 10:54:50", "ddd, dd MMMM yyyy");
                  o.date_start = startdate;
                  o.date_end = enddate;
                  o.type = v.type;
                  o.jenis = v.jenis;
                  o.nama_supplier = v.supplier.nm_vendor;
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
      minimumInputLength: 0,
      escapeMarkup: function (markup) { return markup; },
      templateResult: function (state) {
          if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ; }
          var $state = $(
              '<span>' +  state.name +' <i>('+  state.value + ')</i></span>'
          );
          return $state;
      },
      templateSelection: function (data) {
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return 'Cari Nomor/Judul Kontrak';
          }
          var render = data.value;
          if(data.value === undefined){
            render = $('.select-kontrak-sp :selected').text();
          }
          $('.select-kontrak-text-sp').val(render);
          return render ;
      }
    });
    selectKontrakSP.on('select2:select', function (e) {
        var data = e.params.data;
    });
    var kontrak_set = $(".select-kontrak-sp");
    if(kontrak_set.data('id')!==""){
      var text_kontrak = $(".select-kontrak-text-sp").val();
      var newOption_ = new Option(text_kontrak, kontrak_set.data('id'), false, true);
      kontrak_set.append(newOption_);
      kontrak_set.val(kontrak_set.data('id')).change();
      $.ajax({
        url: '{!! route('doc.get-select-kontrak') !!}',
        type: 'GET',
        dataType: 'json',
        data: {
            q: text_kontrak, // search term
            type:'{!!$doc_type->name!!}'
        }
      })
      .done(function(data) {
        var o = {};
        $.each(data.data, function (i, v) {
            //var o = {};
            var startdate=(v.doc_startdate!==null)?$.format.date(v.doc_startdate+" 10:54:50", "dd-MM-yyyy"):'-';
            var enddate=(v.doc_enddate!==null)?$.format.date(v.doc_enddate+" 10:54:50", "dd-MM-yyyy"):'-';
            o.id = v.id;
            o.name = v.doc_title;
            o.value = v.doc_no;
            o.date = $.format.date(v.doc_date+" 10:54:50", "ddd, dd MMMM yyyy");
            o.date_start = startdate;
            o.date_end = enddate;
            o.type = v.type;
            o.jenis = v.jenis;
            o.nama_supplier = v.supplier.nm_vendor;
        })
      });

    }
  });
  </script>
@endpush
