<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Judul Kontrak</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_vendor" value=""  placeholder="Masukan Judul Kontrak" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Kontrak</label>
            <div class="col-sm-3">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="akte_awal_tg" value="" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak I</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="nm_vendor" value="PT. TELEKOMUNIKASI INDONESIA Tbk"  placeholder="Masukan Judul Kontrak" autocomplete="off" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak II</label>
            <div class="col-sm-6">
              <select class="form-control select-user-vendor" style="width: 100%;" name="store_id" id="store_id">
                  <option value="">Pilih Pihak II</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Cara Pengadaan</label>
            <div class="col-sm-3">
              <select class="form-control" name="prinsipal_st">
                <option value="1">Pelanggan</option>
                <option value="0">Pemilihan Langsung</option>
                <option value="2">Penunjukan Langsung</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Kontrak</label>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon" id="asset">Rp.</span>
                <input type="text" name="asset" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Unit Penanggungjawab PIC</label>
            <div class="col-sm-3">
              <select class="form-control select-user-telkom" style="width: 100%;" name="store_id" id="store_id">
                  <option value="">Pilih Penanggungjawab</option>
              </select>
            </div>
          </div>
          {{-- @include('documents::partials.buttons') --}}
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  $(".select-user-telkom").select2({
      placeholder : "Pilih Penanggung....",
      ajax: {
          url: '{!! route('users.get-select-user-telkom') !!}',
          dataType: 'json',
          delay: 350,
          data: function (params) {
              return {
                  q: params.term, // search term
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
                  o.name = v.name;
                  o.value = v.id;
                  o.username = v.username;
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
      //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      minimumInputLength: 0,
      templateResult: function (state) {
          if (state.id === undefined || state.id === "") { return ; }
          var $state = $(
              '<span>' +  state.name +' <i>('+  state.username + ')</i></span>'
          );
          return $state;
      },
      templateSelection: function (data) {
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return;
          }
          return data.name +' - '+  data.username ;
      }
  });
  $(".select-user-vendor").select2({
      placeholder : "Pilih Pihak II....",
      ajax: {
          url: '{!! route('users.get-select-user-vendor') !!}',
          dataType: 'json',
          delay: 350,
          data: function (params) {
              return {
                  q: params.term, // search term
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
                  o.name = v.name;
                  o.value = v.id;
                  o.username = v.username;
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
      //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      minimumInputLength: 0,
      templateResult: function (state) {
          if (state.id === undefined || state.id === "") { return ; }
          var $state = $(
              '<span>' +  state.bdn_usaha+'.'+state.name +' <i>('+  state.username + ')</i></span>'
          );
          return $state;
      },
      templateSelection: function (data) {
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return;
          }
          return data.bdn_usaha+'.'+data.name +' - '+  data.username ;
      }
  });
});
</script>
@endpush
