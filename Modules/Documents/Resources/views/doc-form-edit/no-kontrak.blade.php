<div class="form-group  {{ $errors->has('parent_kontrak') ? ' has-error' : '' }}">
  <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> No Kontrak Induk</label>
  <div class="col-sm-10">
    <input type="hidden" class="select-kontrak-text" name="parent_kontrak_text" value="{{Helper::old_prop($doc,'parent_kontrak_text')}}">
    <input type="hidden" class="select-kontrak-induk" name="parent_kontrak_id" value="{{Helper::old_prop($doc,'parent_kontrak_id')}}">
    <select class="form-control select-kontrak" style="width: 100%;" name="parent_kontrak" data-id="{{Helper::old_prop($doc,'parent_kontrak')}}">
    </select>
    @if ($errors->has('parent_kontrak'))
        <span class="help-block">
            <strong>{{ $errors->first('parent_kontrak') }}</strong>
        </span>
    @endif
    <div class="result-kontrak top20"></div>
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
    var selectKontrak = $(".select-kontrak").select2({
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
            render = $('.select-kontrak :selected').text();
          }
          $('.select-kontrak-text').val(render);
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
    var kontrak_set = $(".select-kontrak");
    if(kontrak_set.data('id')!==""){
      var text_kontrak = $(".select-kontrak-text").val();
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
            o.nama_supplier = v.supplier.bdn_usaha+"."+v.supplier.nm_vendor;
        })
        templateKontrakSelect(o);
        //console.log(JSON.stringify(o));
      });


    }
  });
  function templateKontrakSelect(data){
    $('.judul-man').hide().find('.text-me').html('');
    var table = $('.result-kontrak'),judul,t_type='';
    //console.log(JSON.stringify(data));
    table.html('');
    var h_title = '{!!strtoupper($doc_type->title)!!}';
    var s_type = JSON.parse(data.type);
    //console.log(JSON.stringify(s_type));
    // console.log(JSON.stringify(s_type.length));
    $('#nama_supplier').val(data.nama_supplier);
    var t_table = '<table class="table">\
                    <thead>\
                      <tr >\
                            <th width="400">Judul</th>\
                            <th>Tanggal Mulai</th>\
                            <th>Tanggal Akhir</th>\
                            <th  width="200">Jenis</th>\
                      </tr>\
                    </thead>\
                    <tbody>\
                      <tr>\
                            <td>'+data.name+ '</td>\
                            <td>'+data.date_start+'</td>\
                            <td>'+data.date_end+'</td>\
                            <td>'+data.jenis.type.title+'</td>\
                      </tr>\
                    </tbody>\
                  </table>';
      if(s_type.length>0){
        t_type = '<div><button type="button" class="btn btn-success bottom15 toggle-me">Lihat Data '+h_title+' <i class="glyphicon glyphicon-chevron-down"></i></button></div><table class="table table-123" style="display:none;">\
                        <thead>\
                          <tr width="400">\
                                <th>Judul</th>\
                                <th>Tanggal Mulai</th>\
                                <th>Tanggal Akhir</th>\
                                <th>Acuan Kontrak</th>\
                          </tr>\
                        </thead>\
                        <tbody>';
                        $.each(s_type,function(index, el) {
                          var s_start = (this.doc_startdate!==null)?$.format.date(this.doc_startdate+" 10:54:50", "dd-MM-yyyy"):'-';
                          var s_end = (this.doc_enddate!==null)?$.format.date(this.doc_enddate+" 10:54:50", "dd-MM-yyyy"):'-';
                          // var parent = (this.parent_title!==null && this.parent_title!==undefined)?this.parent_title:'-'
                          if(this.doc_parent_id==data.id){
                            var parent = data.name+"<br><small> ("+data.value+")</small>";
                          }else{
                            parent = this.title+"<br><small> ("+this.num+")</small>";
                          }
                          t_type += '<tr>\
                                          <td>'+this.doc_title+'</td>\
                                          <td>'+s_start+'</td>\
                                          <td>'+s_end+'</td>\
                                          <td>'+parent+'</td>\
                                    </tr>';
                        });
          t_type +=    '</tbody>\
                      </table>';
          judul = '{!!strtoupper($doc_type->title)!!} #'+(s_type.length+1)+' || '+data.value+' ('+data.name+')';
      }
      else{
        judul = '{!!strtoupper($doc_type->title)!!} #1 || '+data.value+' ('+data.name+')';
      }
    // $('.judul-man').show().find('.text-me').html(judul+'<input type="hidden" value="'+judul+'" name="doc_title"/>');
    $('.judul-man').show().find('.text-me').val(judul);
    table.html(t_table+t_type);
  }
  $(document).on('click', '.toggle-me', function(event) {
    event.preventDefault();
    /* Act on the event */
    var btn = $(this);
    if(btn.find('i').hasClass('glyphicon-chevron-down')){
      btn.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
      $('.table-123').show();
    }
    else{
      btn.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $('.table-123').hide();
    }

  });
  </script>
@endpush
