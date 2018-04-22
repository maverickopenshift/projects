<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Legal Aspek
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-akte_awal_no">
              <label for="akte_awal_no" class="col-sm-5 control-label"><span class="text-red">*</span> No Akte Pendirian</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="akte_awal_no" value="{{ old('akte_awal_no',Helper::prop_exists($data,'akte_awal_no')) }}" autocomplete="off">
                <div class="error error-akte_awal_no"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-akte_awal_tg">
              <label for="akte_awal_tg" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="akte_awal_tg" value="{{ old('akte_awal_tg',Helper::prop_exists($data,'akte_awal_tg')) }}" autocomplete="off">
                </div>
                <div class="error error-akte_awal_tg"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-akte_awal_notaris">
              <label for="akte_awal_notaris" class="col-sm-4 control-label"><span class="text-red">*</span> Notaris</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="akte_awal_notaris" value="{{ old('akte_awal_notaris',Helper::prop_exists($data,'akte_awal_notaris')) }}" autocomplete="off">
                <div class="error error-akte_awal_notaris"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-akte_akhir_no">
              <label for="akte_akhir_no" class="col-sm-5 control-label">No Akte Perubahan</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="akte_akhir_no" value="{{ old('akte_akhir_no',Helper::prop_exists($data,'akte_akhir_no')) }}" autocomplete="off">
                <div class="error error-akte_akhir_no"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-akte_akhir_tg">
              <label for="akte_akhir_tg" class="col-sm-4 control-label">Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="akte_akhir_tg" value="{{ old('akte_akhir_tg',Helper::prop_exists($data,'akte_akhir_tg')) }}" autocomplete="off">
                </div>
                <div class="error error-akte_akhir_tg"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-akte_akhir_notaris">
              <label for="akte_akhir_notaris" class="col-sm-4 control-label">Notaris</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="akte_akhir_notaris" value="{{ old('akte_akhir_notaris',Helper::prop_exists($data,'akte_akhir_notaris')) }}" autocomplete="off">
                <div class="error error-akte_akhir_notaris"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-siup_no">
              <label for="siup_no" class="col-sm-5 control-label"><span class="text-red">*</span> No SIUP</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="siup_no" value="{{ old('siup_tg_terbit',Helper::prop_exists($data,'siup_no')) }}" autocomplete="off">
                <div class="error error-siup_no"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-siup_tg_terbit">
              <label for="siup_tg_terbit" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="siup_tg_terbit" value="{{ old('siup_tg_expired',Helper::prop_exists($data,'siup_tg_terbit')) }}" autocomplete="off">
                </div>
                <div class="error error-siup_tg_terbit"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-siup_tg_expired">
              <label for="siup_tg_expired" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Expired</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="siup_tg_expired" value="{{ old('siup_tg_expired',Helper::prop_exists($data,'siup_tg_expired')) }}" autocomplete="off">
                </div>
                <div class="error error-siup_tg_expired"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-siup_kualifikasi">
              <label for="siup_kualifikasi" class="col-sm-2 control-label"><span class="text-red">*</span> Kualifikasi SIUP</label>
              <div class="col-sm-10">
                <label class="radio-inline" style="padding-left:7px">
                  <input class="check-me" type="radio" value="1" name="siup_kualifikasi" {{!old('siup_kualifikasi',Helper::prop_exists($data,'siup_kualifikasi'))?'checked':''}} {{old('siup_kualifikasi',Helper::prop_exists($data,'siup_kualifikasi'))=='1'?'checked':''}}> Besar
                </label>
                <label class="radio-inline">
                  <input class="check-me" type="radio" value="2" name="siup_kualifikasi" {{old('siup_kualifikasi',Helper::prop_exists($data,'siup_kualifikasi'))=='2'?'checked':''}}> Menengah
                </label>
                <label class="radio-inline">
                  <input class="check-me" type="radio" value="3" name="siup_kualifikasi" {{old('siup_kualifikasi',Helper::prop_exists($data,'siup_kualifikasi'))=='3'?'checked':''}}> Kecil
                </label>
                <div class="error error-siup_kualifikasi"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-pkp">
              <label for="pkp" class="col-sm-5 control-label"><span class="text-red">*</span> Perusahaan Kena Pajak</label>
              <div class="col-sm-7">
                <select class="form-control" name="pkp" id="pkp">
                  <option value="0" {{ old('pkp',Helper::prop_exists($data,'pkp'))=='0'?"selected='selected'":"" }}>Ya</option>
                  <option value="1" {{ old('pkp',Helper::prop_exists($data,'pkp'))=='1'?"selected='selected'":"" }}>Tidak</option>
                </select>
                <div class="error error-pkp"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
              <div class="col-sm-12 text-info"> Jika Ya maka NPWP wajib diisi</div>
        </div>
        <div class="col-sm-4"></div>
      </div>

      <div class="row" id="nonpwp">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-npwp_no">
              <label for="npwp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No NPWP</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="npwp_no" value="{{ old('npwp_no',Helper::prop_exists($data,'npwp_no')) }}" autocomplete="off">
                <div class="error error-npwp_no"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-npwp_tg">
              <label for="npwp_tg" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="npwp_tg" value="{{ old('npwp_tg',Helper::prop_exists($data,'npwp_tg')) }}" autocomplete="off">
                </div>
                <div class="error error-npwp_tg"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>

      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-tdp_no">
              <label for="tdp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No TDP (Pemda)</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="tdp_no" value="{{ old('tdp_no',Helper::prop_exists($data,'tdp_no')) }}" autocomplete="off">
                <div class="error error-tdp_no"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-tdp_tg_terbit">
              <label for="tdp_tg_terbit" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="tdp_tg_terbit" value="{{ old('tdp_tg_terbit',Helper::prop_exists($data,'tdp_tg_terbit')) }}" autocomplete="off">
                </div>
                <div class="error error-tdp_tg_terbit"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
              <div class="form-group formerror formerror-tdp_tg_expired">
                <label for="tdp_tg_expired" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Expired</label>
                <div class="col-sm-8">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control" name="tdp_tg_expired" value="{{ old('tdp_tg_expired',Helper::prop_exists($data,'tdp_tg_expired')) }}" autocomplete="off">
                  </div>
                  <div class="error error-tdp_tg_expired"></div>
                </div>
              </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-5">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-idp_no">
              <label for="idp_no" class="col-sm-5 control-label"><span class="text-red">*</span> No IDP/SITU (Pemda)</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="idp_no" value="{{ old('idp_no',Helper::prop_exists($data,'idp_no')) }}" autocomplete="off">
                <div class="error error-idp_no"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-horizontal">
            <div class="form-group formerror formerror-idp_tg_terbit">
              <label for="idp_tg_terbit" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Terbit</label>
              <div class="col-sm-8">
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                    <input type="text" class="form-control" name="idp_tg_terbit" value="{{ old('idp_tg_terbit',Helper::prop_exists($data,'idp_tg_terbit')) }}" autocomplete="off">
                </div>
                <div class="error error-idp_tg_terbit"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-horizontal">
              <div class="form-group formerror formerror-idp_tg_expired">
                <label for="idp_tg_expired" class="col-sm-4 control-label"><span class="text-red">*</span> Tgl Expired</label>
                <div class="col-sm-8">
                  <div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                      </div>
                      <input type="text" class="form-control" name="idp_tg_expired" value="{{ old('idp_tg_expired',Helper::prop_exists($data,'idp_tg_expired')) }}" autocomplete="off">
                  </div>
                  <div class="error error-idp_tg_expired"></div>
                </div>
              </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="clearfix"></div>
        <hr  />
      </div>

      <div class="form-horizontal">
      @include('usersupplier::add.__part-legal-dokumen')
      </div>


      <div class="form-group">
        <div class="clearfix"></div>
        <hr  />
      </div>

      @include('usersupplier::add.sertifikat')
      @if($action_type=='edit')
      @include('usersupplier::partials.buttons')
      @endif
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function(){
  //$('input').iCheck('uncheck');
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });
  /*
  add_field_x('legal-dokumen');
  delete_field_x('legal-dokumen');
  add_field_x('sertifikat-dokumen');
  delete_field_x('sertifikat-dokumen');
  */
});
/*
function delete_field_x(attr) {
  $(document).on('click', '.delete-'+attr, function(event) {
    var $parent = $(this).parent().parent();
    $parent.remove();
    var row_p = $('.row-'+attr);
    row_p.find('.add-'+attr).remove();
    var btn_cl = '<button type="button" class="btn btn-danger add-'+attr+'"><i class="glyphicon glyphicon-plus"></i></button>';
    if(row_p.length==1){
      row_p.find('.delete-'+attr).remove();
    }
    row_p.eq(row_p.length-1).find('.attr-btn').append(btn_cl);
  });
}
function add_field_x(attr) {
  $(document).on('click', '.add-'+attr, function(event) {
    event.preventDefault();

    var $this = $(this);
    var $clone_btn = $this.clone();
    var $parent = $(this).parent().parent().parent();
    var $clone = $(this).parent().parent();
    var btn_del = '<button style="margin-right:15px;" type="button" class="btn btn-default delete-'+attr+'"><i class="glyphicon glyphicon-remove"></i></button>';
    $this.remove();
    var $new_clone = $($clone).clone();
    $new_clone.find('input[type="file"]').val('');
    $new_clone.find('input[type="text"]').val('');
    $new_clone.find('.help-block').remove();
    $new_clone.find('.attr-btn').append($clone_btn);
    $new_clone.appendTo($parent);

    var row_p = $('.row-'+attr);
    if(row_p.length>1){
      $.each( row_p, function( key, value ) {
        var l_btn = $(this).find('.delete-'+attr);
        if(l_btn.length==0){
          $(this).find('.attr-btn').prepend(btn_del)
        }
      });
    }
    else{
      $new_clone.find('.delete-'+attr).remove()
    }
  });
}
*/

var isi=$("#pkp").val();
if(isi == "0"){
  $("#nonpwp").show();
}else{
  $("#nonpwp").hide();
}

$("#pkp").change(function () {
  var pkp = this.value;
  if(pkp == "0"){
    $("#nonpwp").show();
  }else{
    $("#nonpwp").hide();
  }
});


</script>
@endpush
