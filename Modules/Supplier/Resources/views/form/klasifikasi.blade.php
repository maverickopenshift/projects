<div class="form-group formerror formerror-klasifikasi_err">
  <label class="col-sm-2 control-label"><span class="text-red">*</span> Klasifikasi Usaha</label>
  <div class="col-sm-10">
    <select class="form-control select-klasifikasi-usaha" style="width: 100%;" name="klasifikasi_usaha" id="klasifikasi_usaha" data-action="klasifikasi_usaha">
        <option value="">Pilih Klasifikasi Usaha</option>
    </select>
    <div class="col-sm-10">
      <div class="error error-klasifikasi_err"></div>
    </div>
  </div>
</div>
@php
    $klasifikasi_kode    = Helper::old_prop_each($supplier,'klasifikasi_kode');
    $klasifikasi_text    = Helper::old_prop_each($supplier,'klasifikasi_text');
@endphp
<div class="table-klasifikasi_usaha table-responsive">
  <table class="table table-bordered">
        <thead>
        <tr>
          <th width="40">No.</th>
          <th class="hide"></th>
          <th width="200">Kode Klasifikasi</th>
          <th width="150">Nama Klasifikasi</th>
          <th class="hide">Nama Klasifikasi 2</th>
          <th width="60">Action</th>
        </tr>
      </thead>
      <tbody>
        @if(count($klasifikasi_kode)>0)
            @foreach ($klasifikasi_kode as $key => $value)
              <tr>
                <td>{{$key+1}}</td>
                <td class="hide"><input class="klasifikasi_kode" type="hidden" name="klasifikasi_kode[]" value="{{$klasifikasi_kode[$key]}}"></td>
                <td> {{$klasifikasi_kode[$key]}} </td>
                <td>{{$klasifikasi_text[$key]}}</td>
                <td class="hide"><input type="hidden" name="klasifikasi_text[]" value="{{$klasifikasi_text[$key]}}"></td>
                <td class="action"><button type="button" class="btn btn-danger btn-xs delete-atasan"><i class="glyphicon glyphicon-remove"></i> hapus</button></td>
              </tr>
            @endforeach

        @endif
      </tbody>
  </table>
</div>
@push('scripts')
<script>
$('.select-klasifikasi-usaha').select2({
    placeholder : "Pilih Klasifikasi Usaha....",
    dropdownParent: $('.select-klasifikasi-usaha').parent(),
    ajax: {
        url: '{!! route('supplier.klasifikasi.getselect') !!}',
        dataType: 'json',
        delay: 350,
        data: function (params) {
            var param_val = [];
            var form_param = $('.table-klasifikasi_usaha').find('input[class="klasifikasi_kode"]');
            if(form_param.length>0){
              form_param.each(function(index, el) {
                param_val.push($(this).val())
              });
            }
            var datas =  {
                q: params.term, // search term
                notin:param_val,
                page: params.page
            };
            return datas;

        },
        processResults: function (data, params) {
            var results = [];
            $.each(data.data, function (i, v) {
                var o = {};
                o.id = v.id;
                o.kode = v.kode;
                o.text = v.text;
                results.push(o);
            })
            params.page = params.page || 1;
            return {
                results: data.data,
                pagination: {
                    more: (data.next_page_url ? true: false)
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 0,
    templateResult: aoTempResult ,
    templateSelection: aoTempSelect
});

function aoTempResult(state) {
    if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ;  }
    var $state = $(
        '<span>' +  state.kode +' <i>('+  state.text + ')</i></span>'
    );
    return $state;
}
function aoTempSelect(data){
    if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
        return;
    }
    if(data.kode === undefined || data.text === undefined){
      return data.text;
    }
    return data.kode +' - '+  data.text ;
}
function templateAtasan(){
  return '<tr>\
            <td>1</td>\
            <td class="hide"><input class="klasifikasi_kode" type="hidden" name="klasifikasi_kode[]"></td>\
            <td></td>\
            <td></td>\
            <td class="hide"><input type="hidden" name="klasifikasi_text[]"></td>\
            <td class="action"><button type="button" class="btn btn-danger btn-xs delete-atasan"><i class="glyphicon glyphicon-remove"></i> hapus</button></td>\
          </tr>';
}

$(document).on('select2:select', '#klasifikasi_usaha', function(event) {
  event.preventDefault();
  var data = event.params.data;
  
  $(this).val('');
  $('#select2-klasifikasi_usaha-container').html('');
  console.log(data);
  var $this = $('.table-'+$(this).data('action'));
  $this.show();
  var row = $this.find('table>tbody>tr');
  var new_row = $(templateAtasan(data)).clone();
  var mdf_new_row = new_row.find('td');
  mdf_new_row.eq(0).html(row.length+1);
  mdf_new_row.eq(1).find('input').val(data.kode);
  mdf_new_row.eq(2).text(data.kode);
  mdf_new_row.eq(3).text(data.text);
  mdf_new_row.eq(4).find('input').val(data.text);
  $this.find('table>tbody').append(new_row);
});

$(document).on('click', '.delete-atasan', function(event) {
  var tbl_t = $(this).parent().parent().parent().parent().parent();
  $(this).parent().parent().remove();
  var $this = tbl_t.clone();
  var row = $this.find('table>tbody>tr');
  if(row.length==0){
    //mdf.html('');
    tbl_t.hide();
  }
});
</script>
@endpush
