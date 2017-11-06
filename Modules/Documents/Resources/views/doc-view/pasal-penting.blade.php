<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Pasal Penting
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
        @if($doc_type->name=="khs")
              @include('documents::partials.buttons-view')
        @endif
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
