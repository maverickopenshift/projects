<div class="form-group {{ $errors->has('pic_nama_err') ? ' has-error' : '' }}">
  <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> PIC</label>
  <div class="col-sm-3">
    <select class="form-control select-user-pic" style="width: 100%;" name="pic_search" id="pic_search">
        <option value="">Pilih PIC</option>
    </select>
  </div>
  <div class="col-sm-2">
    <button type="button" class="btn btn-success add-pic"><i class="glyphicon glyphicon-plus"></i> Tambah PIC</button>
  </div>
  <div class="col-sm-10 col-sm-offset-2">
    {!!Helper::error_help($errors,'pic_nama_err')!!}
  </div>
</div>
@php
    $pic_posisi  = Helper::old_prop_each($doc,'pic_posisi');
    $pic_nama    = Helper::old_prop_each($doc,'pic_nama');
    $pic_jabatan = Helper::old_prop_each($doc,'pic_jabatan');
    $pic_email   = Helper::old_prop_each($doc,'pic_email');
    $pic_telp    = Helper::old_prop_each($doc,'pic_telp');
    $pic_id      = Helper::old_prop_each($doc,'pic_id');
@endphp
<table class="table table-bordered table-pic">
  <thead>
  <tr>
    <th width="40">No.</th>
    <th  width="200">Nama</th>
    <th  width="250">Jabatan</th>
    <th  width="150">Email</th>
    <th  width="150">No.Telp</th>
    <th>Posisi</th>
    <th  width="60">Action</th>
  </tr>
</thead>
<tbody>
  @if(count($pic_nama)>0)
      @foreach ($pic_nama as $key => $value)
        <tr>
            <td>{{$key+1}}</td>
            <td class="{{ $errors->has('pic_nama.'.$key) ? ' has-error' : '' }}">
              <input type="text" class="form-control" name="pic_nama[]" autocomplete="off" value="{{$pic_nama[$key]}}">
              {!!Helper::error_help($errors,'pic_nama.'.$key)!!}
            </td>
            <td class="{{ $errors->has('pic_jabatan.'.$key) ? ' has-error' : '' }}">
              <input type="text" class="form-control" name="pic_jabatan[]" autocomplete="off" value="{{$pic_jabatan[$key]}}">
              {!!Helper::error_help($errors,'pic_jabatan.'.$key)!!}
            </td>
            <td class="{{ $errors->has('pic_email.'.$key) ? ' has-error' : '' }}">
              <input type="text" class="form-control" name="pic_email[]" autocomplete="off" value="{{$pic_email[$key]}}">
              {!!Helper::error_help($errors,'pic_email.'.$key)!!}
            </td>
            <td class="{{ $errors->has('pic_telp.'.$key) ? ' has-error' : '' }}">
              <input type="text" class="form-control" name="pic_telp[]" autocomplete="off" value="{{$pic_telp[$key]}}">
              {!!Helper::error_help($errors,'pic_telp.'.$key)!!}
            </td>
            <td class="{{ $errors->has('pic_posisi.'.$key) ? ' has-error' : '' }}">
              {!!Helper::select_posisi($pic_posisi[$key])!!}
              {!!Helper::error_help($errors,'pic_posisi.'.$key)!!}
            </td>
            <td class="action">
                <input type="hidden"  name="pic_id[]" autocomplete="off" value="{{$pic_id[$key]}}">
                <button type="button" class="btn btn-danger btn-xs delete-pic"><i class="glyphicon glyphicon-remove"></i> hapus</button>
            </td>
        </tr>
      @endforeach
    @else
      <tr>
          <td>1</td>
          <td><input type="text" class="form-control" name="pic_nama[]" autocomplete="off"></td>
          <td><input type="text" class="form-control" name="pic_jabatan[]" autocomplete="off"></td>
          <td><input type="text" class="form-control" name="pic_email[]" autocomplete="off"></td>
          <td><input type="text" class="form-control" name="pic_telp[]" autocomplete="off"></td>
          <td>{!!Helper::select_posisi()!!}</td>
          <td class="action"><input type="hidden" name="pic_id[]"><button type="button" class="btn btn-danger btn-xs delete-pic"><i class="glyphicon glyphicon-remove"></i> hapus</button></td>
      </tr>
    @endif
</tbody>
</table>
@push('scripts')
<script>
$(function() {
  $(document).on('click', '.add-pic', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-pic"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
    /* Act on the event */
    var $this = $('.table-pic');
    $this.show();
    var row = $this.find('tbody>tr');
    var new_row = $(PICtheme()).clone();
    var mdf_new_row = new_row.find('td');
    mdf_new_row.eq(0).html(row.length+1);
    mdf_new_row.eq(1).find('input').val('');
    mdf_new_row.eq(1).find('.error').remove();
    mdf_new_row.eq(2).find('input').val('');
    mdf_new_row.eq(2).find('.error').remove();
    mdf_new_row.eq(3).find('input').val('');
    mdf_new_row.eq(3).find('.error').remove();
    mdf_new_row.eq(4).find('input').val('');
    mdf_new_row.eq(4).find('.error').remove();
    mdf_new_row.eq(5).find('select').val('');
    mdf_new_row.eq(6).find('input').val('');
    mdf_new_row.eq(5).find('.error').remove();
    $this.find('tbody').append(new_row);
    var row = $this.find('tbody>tr');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.action');
      var mdf_new_row = $(this).find('td');
      mdf_new_row.eq(0).html(index+1);
      // if(row.length==1){
      //   mdf.html('');
      // }
      // else{
      //   mdf.html(btn_del);
      // }
    });
  });
  $(".select-user-pic").select2({
      placeholder : "Pilih PIC....",
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
                  o.id = v.n_nik;
                  o.name = v.v_nama_karyawan;
                  o.value = v.n_nik;
                  o.username = v.n_nik;
                  o.jabatan = v.v_short_posisi;
                  o.email = v.n_nik+'@telkom.co.id';
                  o.telp = '';
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
              '<span>' +  state.name +' <i>('+  state.username + ')</i></span>'
          );
          return $state;
      },
      templateSelection: function (data) {
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return "Pilih PIC....";
          }
          return data.name +' - '+  data.username ;
      }
  });
  $(document).on('select2:select', '.select-user-pic', function(e) {
    e.preventDefault();
    var data = e.params.data;
    console.log(data);
    $(this).val('');
    $('#select2-pic_search-container').html('');
    var $this = $('.table-pic');
    $this.show();
    var row = $this.find('tbody>tr');
    var new_row = $(PICtheme()).clone();
    var mdf_new_row = new_row.find('td');
    mdf_new_row.eq(0).html(row.length+1);
    mdf_new_row.eq(1).find('input').val(data.name);
    mdf_new_row.eq(2).find('input').val(data.jabatan);
    mdf_new_row.eq(3).find('input').val(data.email);
    mdf_new_row.eq(4).find('input').val(data.telp);
    mdf_new_row.eq(5).find('select').val('');
    mdf_new_row.eq(6).find('input').val(data.id);
    $this.find('tbody').append(new_row);
  });
});
$(document).on('click', '.delete-pic', function(event) {
  var tbl_t = $(this).parent().parent();
  $(this).parent().parent().remove();
  var $this = $('.table-pic');
  var row = $this.find('tbody>tr');
  if(row.length==0){
    //mdf.html('');
    $this.hide();
  }
  $.each(row,function(index, el) {
    var mdf_new_row = $(this).find('td');
    mdf_new_row.eq(0).html(index+1);
    var mdf = $(this).find('.action');
    console.log(row.length);
    
  });
});
function PICtheme(){
  @php echo 'var select_posisi = \''.trim(preg_replace('/\s+/', ' ',Helper::select_posisi())).'\';'; @endphp
  return '<tr>\
          <td>1</td>\
          <td><input type="text" class="form-control" name="pic_nama[]" autocomplete="off"></td>\
          <td><input type="text" class="form-control" name="pic_jabatan[]" autocomplete="off"></td>\
          <td><input type="text" class="form-control" name="pic_email[]" autocomplete="off"></td>\
          <td><input type="text" class="form-control" name="pic_telp[]" autocomplete="off"></td>\
          <td>'+select_posisi+'</td>\
          <td class="action"><input type="hidden" name="pic_id[]"><button type="button" class="btn btn-danger btn-xs delete-pic"><i class="glyphicon glyphicon-remove"></i> hapus</button></td>\
      </tr>';
}
</script>
@endpush
