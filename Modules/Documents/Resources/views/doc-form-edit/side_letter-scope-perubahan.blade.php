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
          <th width="150">Pasal</th>
          <th width="150">Judul</th>
          <th width="150">Isi</th>
          <th width="150">Semula</th>
          <th width="150">Diubah Menjadi</th>
          <th width="300">Attachment</th>
          <th  width="70"><button type="button" class="btn btn-success btn-xs add-scope"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
        </tr>
      </thead>
      <tbody>
        @php
          $scope_pasal = Helper::old_prop_each($doc,'scope_pasal');
          $scope_judul = Helper::old_prop_each($doc,'scope_judul');
          $scope_isi = Helper::old_prop_each($doc,'scope_isi');
          $scope_awal = Helper::old_prop_each($doc,'scope_awal');
          $scope_akhir = Helper::old_prop_each($doc,'scope_akhir');
          $scope_file = Helper::old_prop_each($doc,'scope_file');
          $scope_file_old = Helper::old_prop_each($doc,'scope_file_old');
        @endphp
        @if(count($scope_pasal)>0)
          @foreach ($scope_pasal as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                <td class="formerror formerror-scope_pasal-0">
                  <input type="text" class="form-control" name="scope_pasal[]" autocomplete="off" value="{{$scope_pasal[$key]}}" placeholder="Pasal..">
                  <div class="error error-scope_pasal error-scope_pasal-0"></div>
                </td>

                <td class="formerror formerror-scope_judul-0">
                  <input type="text" class="form-control" name="scope_judul[]" autocomplete="off" value="{{$scope_judul[$key]}}" placeholder="Judul..">
                  <div class="error error-scope_judul error-scope_judul-0"></div>
                </td>

                <td class="formerror formerror-scope_isi-0">
                  <textarea rows="5" class="form-control" name="scope_isi[]" placeholder="Isi..">{{$scope_isi[$key]}}</textarea>
                  <div class="error error-scope_isi error-scope_isi-0"></div>
                </td>

                <td class="formerror formerror-scope_awal-0">
                  <textarea rows="5" class="form-control" name="scope_awal[]" placeholder="Semula..">{{$scope_awal[$key]}}</textarea>
                  <div class="error error-scope_awal error-scope_awal-0"></div>
                </td>

                <td class="formerror formerror-scope_akhir-0">
                  <textarea rows="5" class="form-control" name="scope_akhir[]" placeholder="Diubah..">{{$scope_akhir[$key]}}</textarea>
                  <div class="error error-pic_posscope_akhirisi error-scope_akhir-0"></div>
                </td>

                <td class="formerror formerror-scope_file-0">
                  <div class="input-group">
                    <input type="file" class="hide" name="scope_file[]">
                    <input class="form-control" type="text" disabled>
                    <span class="input-group-btn">
                      <button class="btn btn-default click-upload" type="button">Browse</button>
                      <input type="hidden" name="scope_file_old[]" value="{{$scope_file_old[$key]}}">
                      @if(isset($scope_file_old[$key]))
                        <a class="btn btn-primary btn-lihat lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file.scope',['filename'=>$scope_file_old[$key],'type'=>$doc_type->name])}}">
                          <i class="glyphicon glyphicon-paperclip"></i>  Lihat
                        </a>
                      @endif
                    </span>
                  </div>
                  <div class="error error-scope_file error-scope_file-0"></div>
                </td>
                <td class="action">
                  @if(count($scope_pasal)>1)
                    <button type="button" class="btn btn-danger btn-xs delete-sc"><i class="glyphicon glyphicon-remove"></i> hapus</button>
                  @endif
                </td>
            </tr>
          @endforeach
          @else
          <tr>
            <td>1</td>
            <td class="formerror formerror-scope_pasal-0">
              <input type="text" class="form-control" name="scope_pasal[]" placeholder="Pasal.." autocomplete="off">
              <div class="error error-scope_pasal error-scope_pasal-0"></div>
            </td>
            <td class="formerror formerror-scope_judul-0">
              <input type="text" class="form-control" name="scope_judul[]" placeholder="Judul.." autocomplete="off">
              <div class="error error-scope_judul error-scope_judul-0"></div>
            </td>
            <td class="formerror formerror-scope_isi-0">
              <textarea rows="5" class="form-control" name="scope_isi[]" placeholder="Isi.."></textarea>
              <div class="error error-scope_isi error-scope_isi-0"></div>
            </td>
            <td class="formerror formerror-scope_awal-0">
              <textarea rows="5" class="form-control" name="scope_awal[]" placeholder="Semula.."></textarea>
              <div class="error error-scope_awal error-scope_awal-0"></div>
            </td>
            <td class="formerror formerror-scope_akhir-0">
              <textarea rows="5" class="form-control" name="scope_akhir[]" placeholder="Diubah.."></textarea>
              <div class="error error-pic_posscope_akhirisi error-scope_akhir-0"></div>
            </td>
            <td class="formerror formerror-scope_file-0">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="file" class="hide" name="scope_file[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                  </span>
                </div>
              </div>
              <div class="error error-scope_file error-scope_file-0"></div>
            </td>
            <td class="action"></td>
          </tr>
          @endif
      </tbody>
      </table>
    @include('documents::partials.button-edit')
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
    mdf_new_row.eq(1).find('.error').html('');

    mdf_new_row.eq(2).find('input').val('');
    mdf_new_row.eq(2).find('.error').html('');

    mdf_new_row.eq(3).find('textarea').val('');
    mdf_new_row.eq(3).find('.error').html('');

    mdf_new_row.eq(4).find('textarea').val('');
    mdf_new_row.eq(4).find('.error').html('');

    mdf_new_row.eq(5).find('textarea').val('');
    mdf_new_row.eq(5).find('.error').html('');

    mdf_new_row.eq(6).find('.btn-file').remove();
    mdf_new_row.eq(6).find('input').val('');
    mdf_new_row.eq(6).find('.error').html('');
    mdf_new_row.eq(6).find('.lihat').remove();

    var id_editor = 'editor'+(row.length+1);
    $this.find('tbody').prepend(new_row);
    var row = $this.find('tbody>tr');
    $.each(row,function(index, el) {
      var mdf = $(this).find('.action');
      var mdf_new_row = $(this).find('td');
      mdf_new_row.eq(0).html(index+1);

      if(mdf_new_row.eq(1).hasClass("has-error")){
        mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-scope_pasal-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("formerror formerror-scope_pasal-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-scope_judul-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("formerror formerror-scope_judul-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-scope_isi-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("formerror formerror-scope_isi-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-scope_awal-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("formerror formerror-scope_awal-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-scope_akhir-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("formerror formerror-scope_akhir-"+ index);
      }

      if(mdf_new_row.eq(6).hasClass("has-error")){
        mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-scope_file-"+ index);
      }else{
        mdf_new_row.eq(6).removeClass().addClass("formerror formerror-scope_file-"+ index);
      }

      mdf_new_row.eq(1).find('.error-scope_pasal').removeClass().addClass("error error-scope_pasal error-scope_pasal-"+ index);
      mdf_new_row.eq(2).find('.error-scope_judul').removeClass().addClass("error error-scope_judul error-scope_judul-"+ index);
      mdf_new_row.eq(3).find('.error-scope_isi').removeClass().addClass("error error-scope_isi error-scope_isi-"+ index);
      mdf_new_row.eq(4).find('.error-scope_awal').removeClass().addClass("error error-scope_awal error-scope_awal-"+ index);
      mdf_new_row.eq(5).find('.error-scope_akhir').removeClass().addClass("error error-scope_akhir error-scope_akhir-"+ index);
      mdf_new_row.eq(6).find('.error-scope_file').removeClass().addClass("error error-scope_file error-scope_file-"+ index);

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

      if(mdf_new_row.eq(1).hasClass("has-error")){
        mdf_new_row.eq(1).removeClass().addClass("has-error formerror formerror-scope_pasal-"+ index);
      }else{
        mdf_new_row.eq(1).removeClass().addClass("formerror formerror-scope_pasal-"+ index);
      }

      if(mdf_new_row.eq(2).hasClass("has-error")){
        mdf_new_row.eq(2).removeClass().addClass("has-error formerror formerror-scope_judul-"+ index);
      }else{
        mdf_new_row.eq(2).removeClass().addClass("formerror formerror-scope_judul-"+ index);
      }

      if(mdf_new_row.eq(3).hasClass("has-error")){
        mdf_new_row.eq(3).removeClass().addClass("has-error formerror formerror-scope_isi-"+ index);
      }else{
        mdf_new_row.eq(3).removeClass().addClass("formerror formerror-scope_isi-"+ index);
      }

      if(mdf_new_row.eq(4).hasClass("has-error")){
        mdf_new_row.eq(4).removeClass().addClass("has-error formerror formerror-scope_awal-"+ index);
      }else{
        mdf_new_row.eq(4).removeClass().addClass("formerror formerror-scope_awal-"+ index);
      }

      if(mdf_new_row.eq(5).hasClass("has-error")){
        mdf_new_row.eq(5).removeClass().addClass("has-error formerror formerror-scope_akhir-"+ index);
      }else{
        mdf_new_row.eq(5).removeClass().addClass("formerror formerror-scope_akhir-"+ index);
      }

      if(mdf_new_row.eq(6).hasClass("has-error")){
        mdf_new_row.eq(6).removeClass().addClass("has-error formerror formerror-scope_file-"+ index);
      }else{
        mdf_new_row.eq(6).removeClass().addClass("formerror formerror-scope_file-"+ index);
      }

      mdf_new_row.eq(1).find('.error-scope_pasal').removeClass().addClass("error error-scope_pasal error-scope_pasal-"+ index);
      mdf_new_row.eq(2).find('.error-scope_judul').removeClass().addClass("error error-scope_judul error-scope_judul-"+ index);
      mdf_new_row.eq(3).find('.error-scope_isi').removeClass().addClass("error error-scope_isi error-scope_isi-"+ index);
      mdf_new_row.eq(4).find('.error-scope_awal').removeClass().addClass("error error-scope_awal error-scope_awal-"+ index);
      mdf_new_row.eq(5).find('.error-scope_akhir').removeClass().addClass("error error-scope_akhir error-scope_akhir-"+ index);
      mdf_new_row.eq(6).find('.error-scope_file').removeClass().addClass("error error-scope_file error-scope_file-"+ index);

      var mdf = $(this).find('.action');
      if(row.length==1){
        mdf.html('');
      }
    });
  });
});
</script>
@endpush
