<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Jaminan dan Asuransi
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-asr">
        <thead>
          <tr>
            <th width="30">No. </th>
            <th width="150">Jenis Jaminan</th>
            <th width="150">Nama Asuransi</th>
            <th width="150">Nilai Jaminan</th>
            <th width="100">Tanggal Mulai</th>
            <th width="100">Tanggal Akhir</th>
            <th width="200">Keterangan</th>
            <th width="150">File <small class="text-danger" style="font-style:italic;font-weight:normal;">(optional)</small></th>
            <th  width="30"><button type="button" class="btn btn-success btn-xs add-asr"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
          </tr>
      </thead>
      <tbody>
          @php
            $doc_jaminan = Helper::old_prop_each($doc,'doc_jaminan');
            $doc_asuransi = Helper::old_prop_each($doc,'doc_asuransi');
            $doc_jaminan_nilai = Helper::old_prop_each($doc,'doc_jaminan_nilai');
            $doc_jaminan_startdate = Helper::old_prop_each($doc,'doc_jaminan_startdate');
            $doc_jaminan_enddate = Helper::old_prop_each($doc,'doc_jaminan_enddate');
            $doc_jaminan_desc = Helper::old_prop_each($doc,'doc_jaminan_desc');
            $doc_jaminan_file = Helper::old_prop_each($doc,'doc_jaminan_file');
          @endphp
          @if(count($doc_asuransi)>0)
            @foreach ($doc_asuransi as $key => $value)
              <tr>
                  <td>{{$key+1}}</td>
                  <td class="{{ $errors->has('doc_jaminan.'.$key) ? ' has-error' : '' }}">
                    <select class="form-control" name="doc_jaminan[]">
                      <option value="{{$doc_jaminan[$key]}}" {!!Helper::old_prop_selected($doc,'doc_jaminan','PL'.$key)!!}>Pelaksanaan</option>
                      <option value="{{$doc_jaminan[$key]}}" {!!Helper::old_prop_selected($doc,'doc_jaminan','PM'.$key)!!}>Pemeliharaan</option>
                    </select>
                    {!!Helper::error_help($errors,'doc_jaminan.'.$key)!!}
                  </td>
                  <td class="{{ $errors->has('doc_asuransi.'.$key) ? ' has-error' : '' }}">
                    <input type="text" class="form-control" name="doc_asuransi[]" value="{{$value}}"  placeholder="Masukan Nama Asuransi" autocomplete="off">
                    {!!Helper::error_help($errors,'doc_asuransi.'.$key)!!}
                  </td>
                  <td class="{{ $errors->has('doc_jaminan_nilai.'.$key) ? ' has-error' : '' }}">
                    <div class="input-group">
                      <div class="input-group-addon mtu-set">
                      </div>
                      <input type="text" class="form-control input-rupiah" name="doc_jaminan_nilai[]" value="{{$doc_jaminan_nilai[$key]}}"  placeholder="Masukan Nilai Jaminan" autocomplete="off">
                    </div>
                    {!!Helper::error_help($errors,'doc_jaminan_nilai.'.$key)!!}
                  </td>
                  <td class="{{ $errors->has('doc_jaminan_startdate.'.$key) ? ' has-error' : '' }}">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control formatTanggal" name="doc_jaminan_startdate[]" value="{{$doc_jaminan_startdate[$key]}}" autocomplete="off">
                    </div>
                    {!!Helper::error_help($errors,'doc_jaminan_startdate.'.$key)!!}
                  </td>
                  <td class="{{ $errors->has('doc_jaminan_enddate.'.$key) ? ' has-error' : '' }}">
                    <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control formatTanggal" name="doc_jaminan_enddate[]" value="{{$doc_jaminan_enddate[$key]}}" autocomplete="off">
                    </div>
                    {!!Helper::error_help($errors,'doc_jaminan_enddate.'.$key)!!}
                  </td>
                  <td class="{{ $errors->has('doc_jaminan_desc.'.$key) ? ' has-error' : '' }}">
                    <textarea class="form-control" rows="4" name="doc_jaminan_desc[]" placeholder="">{{$doc_jaminan_desc[$key]}}</textarea>
                    {!!Helper::error_help($errors,'doc_jaminan_desc.'.$key)!!}
                  </td>
                  <td {{ $errors->has('doc_jaminan_file.'.$key) ? ' has-error' : '' }}>
                    <div class="input-group">
                      <input type="file" class="hide" name="doc_jaminan_file[]">
                      <input class="form-control" type="text" disabled>
                      <span class="input-group-btn">
                        <button class="btn btn-default click-upload" type="button">Browse</button>
                      </span>
                    </div>
                    {!!Helper::error_help($errors,'doc_jaminan_file.'.$key)!!}
                  </td>
                    @if(isset($doc_jaminan_file[$key]))
                      <a target="_blank" href="{{route('supplier.legaldokumen.file',['filename'=>$doc_jaminan_file[$key]])}}"><i class="glyphicon glyphicon-paperclip"></i> {{$doc_jaminan_file[$key]}}</a>
                    @endif
                  </td>
                  <td class="action">
                    @if(count($doc_asuransi)>1)
                      <button type="button" class="btn btn-danger btn-xs delete-lt"><i class="glyphicon glyphicon-remove"></i> hapus</button>
                    @endif
                  </td>
              </tr>
            @endforeach
          @else
            <tr>
                <td>1</td>
                <td>
                  <select class="form-control" name="doc_jaminan[]">
                    <option value="PL">Pelaksanaan</option>
                    <option value="PM">Pemeliharaan</option>
                  </select>
                </td>
                <td>
                  <input type="text" class="form-control" name="doc_asuransi[]"  placeholder="Masukan Nama Asuransi" autocomplete="off">
                </td>
                <td>
                  <div class="input-group">
                    <div class="input-group-addon mtu-set">
                    </div>
                    <input type="text" class="form-control input-rupiah" name="doc_jaminan_nilai[]" placeholder="Masukan Nilai Jaminan" autocomplete="off">
                  </div>
                </td>
                <td>
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control" name="doc_jaminan_startdate[]" autocomplete="off">
                  </div>
                </td>
                <td>
                  <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="doc_jaminan_enddate[]" autocomplete="off">
                  </div>
                </td>
                <td>
                  <textarea class="form-control" rows="4" name="doc_jaminan_desc[]" placeholder=""></textarea>
                </td>
                <td>
                  <div class="input-group">
                    <input type="file" class="hide" name="doc_jaminan_file[]">
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
      @include('documents::partials.buttons')
    </div>


<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  // $('.formatTanggal').datepicker({
  //       dateFormat: 'Y-m-d'
  //   });

  $(document).on('click', '.add-asr', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-asr"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
    /* Act on the event */
    var $this = $('.table-asr');
    var row = $this.find('tbody>tr');
    var new_row = row.eq(0).clone();
    var mdf_new_row = new_row.find('td');

    mdf_new_row.eq(0).html(row.length+1);
    mdf_new_row.eq(1).find('input').val('');      //jenisjaminan
    mdf_new_row.eq(1).find('.error').remove();    //jenisjaminan

    mdf_new_row.eq(2).find('input').val('');   //namaasuransi
    mdf_new_row.eq(2).find('.error').remove();

    mdf_new_row.eq(3).find('input').val('');     //nilaijaminan
    mdf_new_row.eq(3).find('.error').remove();

    mdf_new_row.eq(4).find('input').val('');     //tanggalmulai
    mdf_new_row.eq(4).find('.error').remove();

    mdf_new_row.eq(5).find('input').val('');     //tanggalend
    mdf_new_row.eq(5).find('.error').remove();

    mdf_new_row.eq(6).find('textarea').val('');   //keterangan
    mdf_new_row.eq(6).find('.error').remove();

    mdf_new_row.eq(7).find('input').val('');    //file
    mdf_new_row.eq(7).find('.error').remove();


    var id_editor = 'editor'+(row.length+1);
    $this.find('tbody').prepend(new_row);
    $('.date').datepicker(datepicker_ops);
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

  $(document).on('click', '.delete-asr', function(event) {
    $(this).parent().parent().remove();
    var $this = $('.table-asr');
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
