<div class="form-group {{ $errors->has('pic_data') ? ' has-error' : '' }} {{ $errors->has('pic_posisi') ? ' has-error' : '' }}">
  <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> PIC</label>
  <div class="col-sm-5">
    <select class="form-control select-user-telkom" style="width: 100%;" name="pict" id="pict">
        <option value="">Pilih PIC</option>
    </select>
  </div>
  <div class="col-sm-10 col-sm-offset-2">
    {!!Helper::error_help($errors,'pic_data')!!}
    {!!Helper::error_help($errors,'pic_posisi')!!}
  </div>
</div>
<div class="parent-pictable" style="display:none;">
  <table class="table table-condensed table-striped" id="pictable">
      <thead>
      <tr>
          <th width="40">No.</th>
          <th  width="200">NIK</th>
          <th  width="250">Nama</th>
          <th>Posisi</th>
          <th width="60">Action</th>
      </tr>
      </thead>
      <tbody>
        <tr class="loading-tr">
          <td colspan="5" class="text-center"><img src="{{asset('/images/loader.gif')}}" title="please wait..."/></td>
        </tr>
      </tbody>
  </table>
</div>
<table class="table table-bordered table-pic">
  <thead>
  <tr>
    <th width="40">No.</th>
    <th  width="200">Nama</th>
    <th  width="250">Jabatan</th>
    <th  width="250">Email</th>
    <th  width="250">No.Telp</th>
    <th>Posisi</th>
    <th  width="60"><button type="button" class="btn btn-success btn-xs add-pic"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
  </tr>
</thead>
<tbody>
  @php
      $pic         = Helper::old_prop_each($doc,'pic_data');
      $pic_posisi  = Helper::old_prop_each($doc,'pic_posisi');
      $pic_nama    = Helper::old_prop_each($doc,'pic_nama');
      $pic_jabatan = Helper::old_prop_each($doc,'pic_jabatan');
      $pic_email   = Helper::old_prop_each($doc,'pic_email');
      $pic_telp   = Helper::old_prop_each($doc,'pic_telp');
  @endphp
  @if(count($pic)>0)
    @foreach ($pic as $key => $value)
      <tr>
          <td>{{$key+1}}</td>
          <td class="{{ $errors->has('pic_nama.'.$key) ? ' has-error' : '' }}">
            <input type="text" class="form-control" name="pic_nama[]" autocomplete="off" value="{{$pic_nama[$Key]}}">
            {!!Helper::error_help($errors,'pic_nama.'.$key)!!}
          </td>
          <td class="{{ $errors->has('pic_jabatan.'.$key) ? ' has-error' : '' }}">
            <input type="text" class="form-control" name="pic_jabatan[]" autocomplete="off" value="{{$pic_jabatan[$Key]}}">
            {!!Helper::error_help($errors,'pic_jabatan.'.$key)!!}
          </td>
          <td class="{{ $errors->has('pic_email.'.$key) ? ' has-error' : '' }}">
            <input type="text" class="form-control" name="pic_email[]" autocomplete="off" value="{{$pic_email[$Key]}}">
            {!!Helper::error_help($errors,'pic_email.'.$key)!!}
          </td>
          <td class="{{ $errors->has('pic_telp.'.$key) ? ' has-error' : '' }}">
            <input type="text" class="form-control" name="pic_telp[]" autocomplete="off" value="{{$pic_telp[$Key]}}">
            {!!Helper::error_help($errors,'pic_telp.'.$key)!!}
          </td>
          <td class="{{ $errors->has('pic_telp.'.$key) ? ' has-error' : '' }}">
            {!!Helper::select_posisi($pic_posisi[$key])!!}
            {!!Helper::error_help($errors,'pic_telp.'.$key)!!}
          </td>
          <td class="action">
            @if(count($pic)>1)
              <button type="button" class="btn btn-danger btn-xs delete-pic"><i class="glyphicon glyphicon-remove"></i> hapus</button>
            @endif
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
        <td class="action"></td>
    </tr>
    @endif
</tbody>
</table>