 <div class="box">
    <div class="box-header with-border" style="padding-bottom: 14px;">
      <h3 class="box-title">

      </h3>
      {{-- <div class="pull-right box-tools">
        <button type="button" class="btn btn-success add-lt"><i class="glyphicon glyphicon-plus"></i> tambah</button>
      </div> --}}
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @php
        $lt_name = Helper::old_prop_each($doc,'lt_name');
        $lt_file = Helper::old_prop_each($doc,'lt_file');
        $lt_desc = Helper::old_prop_each($doc,'lt_desc');
        $lt_file_old = Helper::old_prop_each($doc,'lt_file_old');
      @endphp
      @if(count($lt_name)>0)
        @foreach ($lt_name as $key => $value)
            <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
                <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
                  <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Latar Belakang <span class="total_lt">{{$key+1}}</span></div>
                </div>
                <div class="form-group {{ $errors->has('lt_name.'.$key) ? ' has-error' : '' }}">
                  <label for="lt_name" class="col-sm-2 control-label"><span class="text-red">*</span> Judul</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="" disabled="true" autocomplete="off" value="{{$value}}">
                    <input type="text" class="form-control" name="lt_name[]"  style="Display:none" autocomplete="off" value="{{$value}}">
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    {!!Helper::error_help($errors,'lt_name.'.$key)!!}
                  </div>
                </div>

                <div class="form-group {{ $errors->has('lt_desc.'.$key) ? ' has-error' : '' }}">
                  <label for="lt_desc" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal</label>
                  <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control" name="lt_desc[]" autocomplete="off" value="{{$lt_desc[$key]}}">
                    </div>
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    {!!Helper::error_help($errors,'lt_desc.'.$key)!!}
                  </div>
                </div>
                <div class="form-group {{ $errors->has('lt_file.'.$key) ? ' has-error' : '' }}">
                  <label for="lt_file" class="col-sm-2 control-label"><span class="text-red">*</span> File</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="file" class="hide" name="lt_file[]" multiple="multiple">
                      <input class="form-control" type="text" disabled>
                      <span class="input-group-btn">
                        <button class="btn btn-default click-upload" type="button">Browse</button>
                        <input type="hidden" name="lt_file_old[]" value="{{$lt_file_old[$key]}}">
                        @if(isset($lt_file_old[$key]))
                          <a target="_blank" class="btn btn-primary btn-lihat" href="{{route('doc.file',['filename'=>$lt_file_old[$key],'type'=>$doc_type->name.'_latar_belakang'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat</a>
                        @endif
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-10 col-sm-offset-2">
                    {!!Helper::error_help($errors,'lt_file.'.$key)!!}
                  </div>
                </div>
            </div>
        @endforeach
      @else
        <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Latar Belakang <span class="total_lt">1</span><small class="text-danger"><i> (Wajib di isi) </i></small></div>
            </div>
            <div class="form-group">
              <label for="lt_name" class="col-sm-2 control-label"><span class="text-red">*</span> Judul</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="" disabled="true" autocomplete="off" value="RKS">
                <input type="text" class="form-control" name="lt_name[]" style="Display:none" autocomplete="off" value="RKS">
              </div>
            </div>
            <div class="form-group">
              <label for="lt_desc" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal</label>
              <div class="col-sm-4">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="lt_desc[]" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="lt_file" class="col-sm-2 control-label"><span class="text-red">*</span> File</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="file" class="hide" name="lt_file[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                    <input type="hidden" name="lt_file_old[]">
                  </span>
                </div>
              </div>
            </div>
        </div>

        <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Latar Belakang <span class="total_lt">2</span></div>
            </div>
            <div class="form-group">
              <label for="lt_name" class="col-sm-2 control-label"> Judul</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="" disabled="true" autocomplete="off" value="BAP">
                <input type="text" class="form-control" name="lt_name[]" style="Display:none" autocomplete="off" value="BAP">
              </div>

            </div>
            <div class="form-group">
              <label for="lt_desc" class="col-sm-2 control-label"> Tanggal</label>
              <div class="col-sm-4">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="lt_desc[]" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="lt_file" class="col-sm-2 control-label"> File</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="file" class="hide" name="lt_file[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                    <input type="hidden" name="lt_file_old[]">
                  </span>
                </div>
              </div>
            </div>
        </div>

        <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Latar Belakang <span class="total_lt">3</span></div>
            </div>
            <div class="form-group">
              <label for="lt_name" class="col-sm-2 control-label"> Judul</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="" disabled="true" autocomplete="off" value="BAK">
                <input type="text" class="form-control" name="lt_name[]" style="Display:none" autocomplete="off" value="BAK">
              </div>

            </div>
            <div class="form-group">
              <label for="lt_desc" class="col-sm-2 control-label"> Tanggal</label>
              <div class="col-sm-4">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="lt_desc[]" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="lt_file" class="col-sm-2 control-label"> File</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="file" class="hide" name="lt_file[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                    <input type="hidden" name="lt_file_old[]">
                  </span>
                </div>
              </div>
            </div>
        </div>

        <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Latar Belakang <span class="total_lt">4</span><small class="text-danger"><i> (Wajib di isi) </i></small></div>
            </div>
            <div class="form-group">
              <label for="lt_name" class="col-sm-2 control-label"><span class="text-red">*</span> Judul</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="" disabled="true" autocomplete="off" value="Ketetapan Pemenang">
                <input type="text" class="form-control" name="lt_name[]" style="Display:none" autocomplete="off" value="Ketetapan Pemenang">
              </div>

            </div>
            <div class="form-group">
              <label for="lt_desc" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal</label>
              <div class="col-sm-4">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="lt_desc[]" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="lt_file" class="col-sm-2 control-label"><span class="text-red">*</span> File</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="file" class="hide" name="lt_file[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                    <input type="hidden" name="lt_file_old[]">
                  </span>
                </div>
              </div>
            </div>
        </div>

        <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Latar Belakang <span class="total_lt">5</span><small class="text-danger"><i> (Wajib di isi) </i></small></div>
            </div>
            <div class="form-group">
              <label for="lt_name" class="col-sm-2 control-label"><span class="text-red">*</span> Judul</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="" disabled="true" autocomplete="off" value="Kesanggupan Mitra">
                <input type="text" class="form-control" name="lt_name[]" style="Display:none" autocomplete="off" value="Kesanggupan Mitra">
              </div>

            </div>
            <div class="form-group">
              <label for="lt_desc" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal</label>
              <div class="col-sm-4">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="lt_desc[]" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="lt_file" class="col-sm-2 control-label"><span class="text-red">*</span> File</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="file" class="hide" name="lt_file[]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                    <input type="hidden" name="lt_file_old[]">
                  </span>
                </div>
              </div>
            </div>
        </div>
      @endif
      @include('documents::partials.button-edit')
    </div>


<!-- /.box-body -->
</div>
@push('scripts')
<script>
// $(function() {
  // $('.formatTanggal').datepicker({
  //       dateFormat: 'Y-m-d'
  //   });

//   $(document).on('click', '.add-lt', function(event) {
//     event.preventDefault();
//     var btn_del = '<button type="button" class="btn btn-danger delete-lt" style="position: absolute;right: 5px;top: -10px;border-radius: 0;"><i class="glyphicon glyphicon-trash"></i></button>';
//     /* Act on the event */
//     var $this = $('.lt');
//     var new_row = $this.eq(0).clone();
//     new_row.find('.has-error').removeClass('has-error');
//     var mdf_new_row = new_row.find('.form-group');
//
//     mdf_new_row.eq(0).find('.total_lt').text($this+1);//title and button
//
//     mdf_new_row.eq(1).find('select').val('');      //jenisjaminan
//     mdf_new_row.eq(1).find('.error').remove();    //jenisjaminan
//
//     mdf_new_row.eq(2).find('input').val('');     //tanggalmulai
//     mdf_new_row.eq(2).find('.error').remove();
//
//     mdf_new_row.eq(3).find('input').val('');    //file
//     mdf_new_row.eq(3).find('.error').remove();
//
//     $this.parent().prepend(new_row);
//     $('.add-lt').hide();
//     $('.date').datepicker(datepicker_ops);
//     var row = $('.lt');
//     $.each(row,function(index, el) {
//       var mdf = $(this).find('.delete-lt');
//       var mdf_new_row = $(this).find('.form-group');
//       mdf_new_row.eq(0).find('.total_lt').text(index+1);
//       if(row.length==1){
//         mdf.remove();
//       }
//       else{
//         mdf_new_row.eq(0).append(btn_del)
//       }
//     });
//   });
//
//   $(document).on('click', '.delete-lt', function(event) {
//     $(this).parent().parent().remove();
//     var $this = $('.lt');
//     $.each($this,function(index, el) {
//       var mdf_new_row = $(this).find('.form-group');
//       mdf_new_row.eq(0).find('.total_lt').text(index+1);
//       var mdf = $(this).find('.delete-lt');
//       if($this.length==1){
//         mdf.remove();
//       }
//     });
//   });
// });
</script>
@endpush
