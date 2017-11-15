<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Scoupe Perubahan
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-scope">
        <thead>
        <tr>
          <th width="30">No. </th>
          <th width="150">Scope Perubahan</th>
          <th width="150">Semula</th>
          <th width="150">Diubah Menjadi</th>
          <th width="300">Attachment</th>
          <th  width="70"><button type="button" class="btn btn-success btn-xs add-scope"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
        </tr>
      </thead>
      <tbody>
        @php
          $scope_name = Helper::old_prop_each($doc,'scope_name');
          $scope_awal = Helper::old_prop_each($doc,'scope_awal');
          $scope_akhir = Helper::old_prop_each($doc,'scope_akhir');
          $scope_file = Helper::old_prop_each($doc,'scope_file');
          $scope_file_old = Helper::old_prop_each($doc,'scope_file_old');
        @endphp
        @if(count($scope_name)>0)
          @foreach ($scope_name as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                <td class="{{ $errors->has('scope_name.'.$key) ? ' has-error' : '' }}"><input type="text" class="form-control" name="scope_name[]" autocomplete="off" value="{{$value}}" placeholder="Masukan Scope Perubahan">{!!Helper::error_help($errors,'scope_name.'.$key)!!}</td>
                <td class="{{ $errors->has('scope_awal.'.$key) ? ' has-error' : '' }}"><input type="text" class="form-control" name="scope_awal[]" autocomplete="off" value="{{$scope_awal[$key]}}">{!!Helper::error_help($errors,'scope_awal.'.$key)!!}</td>
                <td class="{{ $errors->has('scope_akhir.'.$key) ? ' has-error' : '' }}"><input type="text" class="form-control" name="scope_akhir[]" autocomplete="off" value="{{$scope_akhir[$key]}}">{!!Helper::error_help($errors,'scope_akhir.'.$key)!!}</td>
                <td class="{{ $errors->has('scope_file.'.$key) ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="file" class="hide" name="scope_file[]">
                    <input class="form-control" type="text" disabled>
                    <span class="input-group-btn">
                      <button class="btn btn-default click-upload" type="button">Browse</button>
                      <input type="hidden" name="scope_file_old[]" value="{{$scope_file_old[$key]}}">
                      @if(isset($scope_file_old[$key]))
                        <a class="btn btn-primary" target="_blank" href="{{route('doc.file.scope',['filename'=>$scope_file_old[$key],'type'=>$doc_type->name])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat</a>
                      @endif
                    </span>
                  </div>
                  {!!Helper::error_help($errors,'scope_file.'.$key)!!}
                  @if(isset($scope_file[$key]))
                    <a target="_blank" href="{{route('supplier.legaldokumen.file',['filename'=>$scope_file[$key]])}}"><i class="glyphicon glyphicon-paperclip"></i> {{$scope_file[$key]}}</a>
                  @endif
                </td>
                <td class="action">
                  @if(count($scope_name)>1)
                    <button type="button" class="btn btn-danger btn-xs delete-sc"><i class="glyphicon glyphicon-remove"></i> hapus</button>
                  @endif
                </td>
            </tr>
          @endforeach
          @else
          <tr>
              <td>1</td>
              <td><input type="text" class="form-control" name="scope_name[]" autocomplete="off" placeholder="Masukan Scope Perubahan"></td>
              <td><input type="text" class="form-control" name="scope_awal[]" autocomplete="off"></td>
              <td><input type="text" class="form-control" name="scope_akhir[]" autocomplete="off"></td>
              <td>
                <div class="input-group">
                  <input type="file" class="hide" name="scope_file[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                    <input type="hidden" name="scope_file_old[]">
                  </span>
                </div>
              </td>
              <td class="action"></td>
          </tr>
          @endif
      </tbody>
      </table>
    {{-- @include('documents::partials.buttons') --}}
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  $(document).on('click', '.add-scope', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-sc"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
    /* Act on the event */
    var $this = $('.table-scope');
    var row = $this.find('tbody>tr');
    var new_row = row.eq(0).clone();
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
  $(document).on('click', '.delete-sc', function(event) {
    $(this).parent().parent().remove();
    var $this = $('.table-scope');
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
