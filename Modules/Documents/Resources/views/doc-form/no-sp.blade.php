<div class="form-group  {{ $errors->has('parent_kontrak') ? ' has-error' : '' }}">
  <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> No Kontrak Induk</label>
  <div class="col-sm-10">
    <input type="hidden" class="select-kontrak-sp-text" name="parent_kontrak_text" value="{{Helper::old_prop($doc,'parent_kontrak_text')}}">
    <select class="form-control select-kontrak-sp" style="width: 100%;" name="parent_kontrak" data-id="{{Helper::old_prop($doc,'parent_kontrak')}}">
    </select>
    @if ($errors->has('parent_kontrak'))
        <span class="help-block">
            <strong>{{ $errors->first('parent_kontrak') }}</strong>
        </span>
    @endif
    <div class="result-kontrak top20"></div>
  </div>
</div>
<div class="form-group  {{ $errors->has('parent_sp') ? ' has-error' : '' }}">
  <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> No SP Induk</label>
  <div class="col-sm-10">
    <input type="hidden" class="select-sp-text" name="parent_sp_text" value="{{Helper::old_prop($doc,'parent_sp_text')}}">
    <select class="form-control select-sp" style="width: 100%;" name="parent_sp" data-id="{{Helper::old_prop($doc,'parent_sp')}}">
    </select>
    @if ($errors->has('parent_sp'))
        <span class="help-block">
            <strong>{{ $errors->first('parent_sp') }}</strong>
        </span>
    @endif
    <div class="result-sp top15"></div>
  </div>
</div>
<div class="judul-man" style="display:none;">
  <div class="form-group">
    <label for="nm_vendor" class="col-sm-2 control-label">No Kontrak {{$doc_type['title']}}</label>
    <div class="col-sm-10"> - </div>
  </div>
  <div class="form-group {{ $errors->has('doc_title') ? ' has-error' : '' }}">
    <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Judul {{$doc_type['title']}}</label>
    <div class="col-sm-10">
      <input type="text" class="form-control text-me" name="doc_title"  value="{{old('doc_title',Helper::prop_exists($doc,'doc_title'))}}"  placeholder="Masukan Judul {{$doc_type['title']}}" autocomplete="off">
      @if ($errors->has('doc_title'))
          <span class="help-block">
              <strong>{{ $errors->first('doc_title') }}</strong>
          </span>
      @endif
    </div>
  </div>
</div>
@push('scripts')
  <script>

  $(function() {
    var selectKontrakSP = $(".select-kontrak-sp").select2({
      placeholder : "Pilih Kontrak....",
      ajax: {
          url: '{!! route('doc.get-select-kontrak-sp') !!}',
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
                  o.nama_supplier = v.supplier.bdn_usaha+"."+v.supplier.nm_vendor;
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
// console.log(results);
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
          $('.select-kontrak-sp-text').val(render);

          return render ;

      }
    });
    selectKontrakSP.on('select2:select', function (e) {
        var data = e.params.data;
        fungsiSelectSp(data);
        if(typeof set_content_reset !== 'undefined'){
          set_content_reset();
        }
    });

    function fungsiSelectSp(data){
      var id_induk = data.id;
      // console.log(id_induk);
      var selectKontrak = $(".select-sp").select2({
        placeholder : "Pilih SP....",
        ajax: {
            url: '{!! route('doc.get-select-sp') !!}',
            dataType: 'json',
            delay: 350,
            data: function (params) {
                return {
                    id: id_induk,
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
                    o.id = v.id;
                    o.name = v.doc_title;
                    o.parent_title = v.parent_title;
                    o.parent_no = v.parent_no;
                    o.parent_title_first = v.parent_title_first;
                    o.parent_no_first = v.parent_no_first;
                    o.value = v.doc_no;
                    o.parent_date = $.format.date(v.parent_date+" 10:54:50", "dd-MM-yyyy");
                    o.datestart = $.format.date(v.doc_startdate+" 10:54:50", "dd-MM-yyyy");
                    o.dateend = $.format.date(v.doc_enddate+" 10:54:50", "dd-MM-yyyy");
                    o.type = v.type;
                    o.jenis = v.jenis;
                    o.nama_supplier = v.supplier.bdn_usaha+"."+v.supplier.nm_vendor;
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
        templateResult: function (state) {
            if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ; }
            var $state = $(
                '<span>'+state.name+' - '+  state.parent_title +' <i>('+  state.value + ')</i></span>'
            );
            return $state;
        },
        templateSelection: function (data) {
            if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
                return 'Cari Nomor/Judul SP';
            }
            var render = data.value;
            if(data.value === undefined){
              render = $('.select-sp :selected').text();
            }
            $('.select-sp-text').val(render);
            return render ;
        }

      });
      selectKontrak.on('select2:select', function (e) {
          var data = e.params.data;
          templateKontrakSelect(data);
          if(typeof set_content_reset !== 'undefined'){
            set_content_reset();
          }
      });

    }

    //Untuk memunculkan no induk kontrak pada saat EDIT SP
        var kontrak_sp = $(".select-kontrak-sp");
        if(kontrak_sp.data('id')!==""){
          var text_kontrak = $(".select-kontrak-sp-text").val();

          var newOption_ = new Option(text_kontrak, kontrak_sp.data('id'), false, true);
          kontrak_sp.append(newOption_);
          kontrak_sp.val(kontrak_sp.data('id')).change();
        }

    var kontrak_set = $(".select-sp");
    if(kontrak_set.data('id')!==""){
      var id_kon = kontrak_sp.data('id');
      var text_kontrak = $(".select-sp-text").val();
      var newOption_ = new Option(text_kontrak, kontrak_set.data('id'), false, true);
      kontrak_set.append(newOption_);
      kontrak_set.val(kontrak_set.data('id')).change();
      $.ajax({
        url: '{!! route('doc.get-select-sp') !!}',
        type: 'GET',
        dataType: 'json',
        data: {
            id: id_kon,
            q: text_kontrak, // search term
            type:'{!!$doc_type->name!!}'
        }
      })
      .done(function(data) {
        var o = {};
        $.each(data.data, function (i, v) {
            //var o = {};
            o.id = v.id;
            o.name = v.doc_title;
            o.parent_title = v.parent_title;
            o.parent_no = v.parent_no;
            o.parent_title_first = v.parent_title_first;
            o.parent_no_first = v.parent_no_first;
            o.value = v.doc_no;
            o.datestart = $.format.date(v.doc_startdate+" 10:54:50", "dd-MM-yyyy");
            o.dateend = $.format.date(v.doc_enddate+" 10:54:50", "dd-MM-yyyy");
            o.parent_date = $.format.date(v.parent_date+" 10:54:50", "dd-MM-yyyy");
            o.type = v.type;
            o.jenis = v.jenis;
            o.nama_supplier = v.supplier.bdn_usaha+"."+v.supplier.nm_vendor;
        })
        templateKontrakSelect(o);
        //console.log(JSON.stringify(o));
      });

    }


  });

  function templateKontrakSelect(data){
    $('.judul-man').hide().find('.text-me').html('');
    var table = $('.result-sp'),judul,t_type='';
    //console.log(JSON.stringify(data));
    table.html('');
    var s_type = JSON.parse(data.type);
    //console.log(JSON.stringify(s_type.length));
    var parent_no_first = '',parent_title_first='';
    var p_title = data.parent_title+' <small> <i>('+data.parent_no+')</i></small>';
    $('#nama_supplier').val(data.nama_supplier);
    if(data.parent_title_first!==null){
      p_title = data.parent_title_first+' <small> <i>('+data.parent_no_first+')</i></small><div class="top10">'+p_title+'</div>';
    }
    var t_table = '<table class="table">\
                    <thead>\
                      <tr >\
                            <th width="320">Kontrak Induk</th>\
                            <th width="150">Tanggal Kontrak</th>\
                            <th>Judul SP</th>\
                            <th  width="150">Tanggal Mulai SP</th>\
                            <th  width="150">Tanggal Akhir SP</th>\
                            <th>Jenis</th>\
                      </tr>\
                    </thead>\
                    <tbody>\
                      <tr>\
                            <td>'+p_title+'</td>\
                            <td>'+data.parent_date+'</td>\
                            <td>'+data.name+'</td>\
                            <td>'+data.datestart+'</td>\
                            <td>'+data.dateend+'</td>\
                            <td>'+data.jenis.type.title+'</td>\
                      </tr>\
                    </tbody>\
                  </table>';
      if(s_type.length>0){
        t_type = '<table class="table">\
                        <thead>\
                          <tr>\
                                <th>Judul</th>\
                                <th>No Amandemen SP</th>\
                                <th>Tanggal Amandemen SP</th>\
                          </tr>\
                        </thead>\
                        <tbody>';
                        $.each(s_type,function(index, el) {
                          t_type += '<tr>\
                                          <td>'+this.doc_title+'</td>\
                                          <td>'+((this.doc_no==null)?'-':this.doc_no)+'</td>\
                                          <td>'+$.format.date(this.doc_date+" 10:54:50", "dd-MM-yyyy")+'</td>\
                                    </tr>';
                        });
          t_type +=    '</tbody>\
                      </table>';
          judul = '{!!strtoupper($doc_type->title)!!} #'+(s_type.length+1)+' || '+data.parent_no+' ('+data.parent_title+')';
      }
      else{
        judul = '{!!strtoupper($doc_type->title)!!} #1 || '+data.parent_no+' ('+data.parent_title+')';
      }
    // $('.judul-man').show().find('.text-me').html(judul+'<input type="hidden" value="'+judul+'" name="doc_title"/>');
    $('.judul-man').show().find('.text-me').val(judul);
    table.html(t_table+t_type);
  }

  </script>
@endpush
