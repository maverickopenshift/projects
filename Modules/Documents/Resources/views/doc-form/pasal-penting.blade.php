<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Pasal Khusus
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-bordered table-pasal">
          <thead>
          <tr>
            <th width="40">No.</th>
            <th width="100">Pasal</th>
            <th width="250">Judul</th>
            <th>Isi</th>
            <th  width="70"><button type="button" class="btn btn-success btn-xs add-pasal"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
          </tr>
        </thead>
        <tbody>
            @php
              $ps_pasal = Helper::old_prop_each($doc,'ps_pasal');
              $ps_judul = Helper::old_prop_each($doc,'ps_judul');
              $ps_isi   = Helper::old_prop_each($doc,'ps_isi');
            @endphp
            @if (isset($ps_pasal) && count($ps_pasal)>0)
              @foreach ($ps_pasal as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td class="{{ $errors->has('ps_pasal.'.$key) ? ' has-error' : '' }}">
                      <input type="text" class="form-control" name="ps_pasal[]" autocomplete="off" value="{{$value}}">
                      {!!Helper::error_help($errors,'ps_pasal.'.$key)!!}
                    </td>
                    <td class="{{ $errors->has('ps_judul.'.$key) ? ' has-error' : '' }}">
                      <input type="text" class="form-control" name="ps_judul[]" autocomplete="off"  value="{{$ps_judul[$key]}}">
                      {!!Helper::error_help($errors,'ps_judul.'.$key)!!}
                    </td>
                    <td class="{{ $errors->has('ps_isi.'.$key) ? ' has-error' : '' }}">
                      <textarea class="form-control" rows="5" name="ps_isi[]" class="editor" id="editor1">{{$ps_isi[$key]}}</textarea>
                      {!!Helper::error_help($errors,'ps_isi.'.$key)!!}
                    </td>
                    <td class="action">
                      @if(count($ps_pasal)>1)
                        <button type="button" class="btn btn-danger btn-xs delete-pasal"><i class="glyphicon glyphicon-remove"></i> hapus</button>
                      @endif
                    </td>
                </tr>
              @endforeach
            @else
              <tr>
                  <td>1</td>
                  <td><input type="text" class="form-control" name="ps_pasal[]" autocomplete="off"></td>
                  <td><input type="text" class="form-control" name="ps_judul[]" autocomplete="off"></td>
                  <td><textarea class="form-control" rows="5" name="ps_isi[]" class="editor" id="editor1"></textarea></td>
                  <td class="action"></td>
              </tr>
            @endif
        </tbody>
        </table>
        {{-- @if($doc_type->name=="khs") --}}
              @include('documents::partials.buttons')
        {{-- @endif --}}
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  $(document).on('click', '.add-pasal', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-pasal"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
    /* Act on the event */
    var $this = $('.table-pasal');
    var row = $this.find('tbody>tr');
    var new_row = row.eq(0).clone();
    var mdf_new_row = new_row.find('td');
    mdf_new_row.eq(0).html(row.length+1);
    mdf_new_row.eq(1).find('input').val('');
    mdf_new_row.eq(1).find('.error').remove();
    mdf_new_row.eq(2).find('input').val('');
    mdf_new_row.eq(2).find('.error').remove();
    mdf_new_row.eq(3).find('textarea').val('');
    mdf_new_row.eq(3).find('.error').remove();
    $this.find('tbody').prepend(new_row);
    var row = $this.find('tbody>tr');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.action');
      var mdf_new_row = $(this).find('td');
      mdf_new_row.eq(0).html(index+1);
      if(row.length==1){
        mdf.html('');
      }
      else{
        mdf.html(btn_del);
      }
    });
  });
});
$(document).on('click', '.delete-pasal', function(event) {
  $(this).parent().parent().remove();
  var $this = $('.table-pasal');
  var row = $this.find('tbody>tr');
  $.each(row,function(index, el) {
    var mdf_new_row = $(this).find('td');
    mdf_new_row.eq(0).html(index+1);
    var mdf = $(this).find('.action');
    console.log(row.length);
    if(row.length==1){
      mdf.html('');
    }
  });
});
</script>
@endpush
