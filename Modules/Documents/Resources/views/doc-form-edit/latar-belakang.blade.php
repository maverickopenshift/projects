<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Latar Belakang
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-latar">
        <thead>
        <tr>
          <th width="30">No. </th>
          <th width="300">Judul</th>
          <th>Isi</th>
          <th width="250">File <small class="text-danger" style="font-style:italic;font-weight:normal;">(optional)</small></th>
          <th  width="70"><button type="button" class="btn btn-success btn-xs add-latar"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
        </tr>
      </thead>
      <tbody>
          @php
            $lt_name = Helper::old_prop_each($doc,'lt_name');
            $lt_file = Helper::old_prop_each($doc,'lt_file');
            $lt_desc = Helper::old_prop_each($doc,'lt_desc');
          @endphp
          @if(count($lt_name)>0)
            @foreach ($lt_name as $key => $value)
              <tr>
                  <td>{{$key+1}}</td>
                  <td class="{{ $errors->has('lt_name.'.$key) ? ' has-error' : '' }}"><input type="text" class="form-control" name="lt_name[]" autocomplete="off" value="{{$value}}" placeholder="Masukan Judul Latar Belakang">{!!Helper::error_help($errors,'lt_name.'.$key)!!}</td>
                  <td class="{{ $errors->has('lt_desc.'.$key) ? ' has-error' : '' }}">
                    <textarea class="form-control" rows="4" name="lt_desc[]" placeholder="Masukan Isi Latar Belakang">{{$lt_desc[$key]}}</textarea>{!!Helper::error_help($errors,'lt_desc.'.$key)!!}</td>
                  <td class="{{ $errors->has('lt_file.'.$key) ? ' has-error' : '' }}">
                    <div class="input-group">
                      <input type="file" class="hide" name="lt_file[]">
                      <input class="form-control" type="text" disabled>
                      <span class="input-group-btn">
                        <button class="btn btn-default click-upload" type="button">Browse</button>
                      </span>
                    </div>
                    {!!Helper::error_help($errors,'lt_file.'.$key)!!}
                    @if(isset($lt_file[$key]))
                      <a target="_blank" href="{{route('doc.file.latarbelakang',['filename'=>$lt_file[$key],'type'=>$doc_type->name])}}"><i class="glyphicon glyphicon-paperclip"></i> File {{$value}}</a>
                    @endif
                  </td>
                  <td class="action">
                    @if(count($lt_name)>1)
                      <button type="button" class="btn btn-danger btn-xs delete-lt"><i class="glyphicon glyphicon-remove"></i> hapus</button>
                    @endif
                  </td>
              </tr>
            @endforeach
          @else
            <tr>
                <td>1</td>
                <td><input type="text" class="form-control" name="lt_name[]" autocomplete="off" placeholder="Masukan Judul Latar Belakang"></td>
                <td><textarea class="form-control" rows="4" name="lt_desc[]" placeholder="Masukan Isi Latar Belakang"></textarea></td>
                <td>
                  <div class="input-group">
                    <input type="file" class="hide" name="lt_file[]">
                    <input class="form-control" type="text" disabled>
                    <span class="input-group-btn">
                      <button class="btn btn-default click-upload" type="button">Browse</button>
                    </span>
                  </div>
                </td>
                <td class="action"></td>
            </tr>
          @endif
      </tbody>
      </table>
        @if(in_array($doc_type->name,['amandemen_sp','amandemen_kontrak','adendum','side_letter']))
          @include('documents::partials.buttons')
        @endif
    </div>


<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  $(document).on('click', '.add-latar', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-lt"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
    /* Act on the event */
    var $this = $('.table-latar');
    var row = $this.find('tbody>tr');
    var new_row = row.eq(0).clone();
    var mdf_new_row = new_row.find('td');
    mdf_new_row.eq(0).html(row.length+1);
    mdf_new_row.eq(1).find('input').val('');
    mdf_new_row.eq(1).find('.error').remove();
    mdf_new_row.eq(2).find('textarea').val('');
    mdf_new_row.eq(2).find('.error').remove();
    mdf_new_row.eq(3).find('input').val('');
    mdf_new_row.eq(3).find('.error').remove();
    var id_editor = 'editor'+(row.length+1);
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
  $(document).on('click', '.delete-lt', function(event) {
    $(this).parent().parent().remove();
    var $this = $('.table-latar');
    var row = $this.find('tbody>tr');
    $.each(row,function(index, el) {
      var mdf_new_row = $(this).find('td');
      mdf_new_row.eq(0).html(index+1);
      var mdf = $(this).find('.action');
      if(row.length==1){
        mdf.html('');
      }
    });
  });
});
</script>
@endpush
