<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Vendor
      </h3>
      @if($action_type=='lihat' || $action_type=='edit')
        @include('supplier::partials.buttons-edit')
      @endif
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
        <div class="form-group formerror formerror-alamat">
          <label class="col-sm-2 control-label"><span class="text-red">*</span> Alamat</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" name="alamat" placeholder="Masukan Alamat">{{ old('alamat',Helper::prop_exists($supplier,'alamat')) }}</textarea>
            <div class="error error-alamat"></div>
          </div>
        </div>
        <div class="form-group formerror formerror-kota formerror-kd_pos">
          <label class="col-sm-2 control-label"><span class="text-red">*</span> Kota -  Kode Pos</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="kota" value="{{ old('kota',Helper::prop_exists($supplier,'kota')) }}" placeholder="Masukan Kota" autocomplete="off">
            <div class="error error-kota"></div>
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="kd_pos" value="{{ old('kd_pos',Helper::prop_exists($supplier,'kd_pos')) }}"  placeholder="Masukan Kode Pos" autocomplete="off">
            <div class="error error-kd_pos"></div>
          </div>
        </div>
        <div class="form-group formerror formerror-telepon formerror-fax">
          <label class="col-sm-2 control-label"><span class="text-red">*</span> Telepon - Faximili</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="telepon" value="{{ old('telepon',Helper::prop_exists($supplier,'telepon')) }}" placeholder="Masukan Telepon" autocomplete="off">
            <div class="error error-telepon"></div>
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="fax" value="{{ old('fax',Helper::prop_exists($supplier,'fax')) }}"  placeholder="Masukan Faximili" autocomplete="off">
            <div class="error error-fax"></div>
          </div>
        </div>
        @if($action_type=='add')
          <div class="form-group formerror formerror-email">
            <label for="email" class="col-sm-2 control-label"><span class="text-red">*</span> Email Address</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="email" value="{{ old('email',Helper::prop_exists($supplier,'email')) }}"  placeholder="Masukan Email Address" autocomplete="off">
              <div class="error error-email"></div>
            </div>
          </div>
        @else
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email Address</label>
            <div class="col-sm-10">
              {{ Helper::prop_exists($supplier,'email') }}
            </div>
          </div>
        @endif
        @if($action_type=='add')
            <div class="form-group formerror formerror-password">
              <label for="password" class="col-sm-2 control-label"><span class="text-red">*</span> Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password" value="{{ old('password') }}"  placeholder="Masukan Password" autocomplete="off">
                <div class="error error-password"></div>
              </div>
            </div>
            <div class="form-group formerror formerror-password_confirmation">
              <label for="password_confirmation" class="col-sm-2 control-label"><span class="text-red">*</span> Konfirmasi Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}"  placeholder="Masukan Konfirmasi Password" autocomplete="off">
                <div class="error error-password_confirmation"></div>
              </div>
            </div>
        @endif
        <div class="form-group formerror formerror-web_site">
          <label for="web_site" class="col-sm-2 control-label">Websites</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="web_site" value="{{ old('web_site',Helper::prop_exists($supplier,'web_site')) }}"  placeholder="Masukan Websites" autocomplete="off">
            <div class="error error-web_site"></div>
          </div>
        </div>
        <div class="form-group formerror formerror-induk_perus">
          <label for="induk_perus" class="col-sm-2 control-label">Induk Perusahaan</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="induk_perus" value="{{ old('induk_perus',Helper::prop_exists($supplier,'induk_perus')) }}"  placeholder="Masukan Induk Perusahaan" autocomplete="off">
            <div class="error error-induk_perus"></div>
          </div>
        </div>

        <div class="form-group">
          <label for="anak_perusahaan" class="col-sm-2 control-label">Anak Perusahaan</label>
          <div class="col-sm-10">
            @if(count(old('anak_perusahaan',Helper::prop_exists($supplier,'anak_perusahaan','array')))>0)
              @foreach (old('anak_perusahaan',Helper::prop_exists($supplier,'anak_perusahaan','array')) as $key => $value)
              <div class="input-anak_perusahaan formerror formerror-anak_perusahaan-{{$key}}">
                <div class="input-group bottom15 col-sm-12">
                  <input type="text" class="form-control anak_perusahaan" name="anak_perusahaan[]" value="{{$value}}" autocomplete="off">
                  @if($action_type!='lihat')
                  <div class="input-group-btn">
                      <button type="button" class="btn btn-default add-anak_perusahaan"><i class="glyphicon glyphicon-plus"></i></button>
                      @if(count(old('anak_perusahaan',Helper::prop_exists($supplier,'anak_perusahaan','array')))>1)
                        <button type="button" class="btn btn-default delete-anak_perusahaan"><i class="glyphicon glyphicon-trash"></i></button>
                      @endif                    
                  </div>
                  @endif

                </div>
                <div class="error error-anak_perusahaan error-anak_perusahaan-{{$key}}"></div>
              </div>
              @endforeach
            @else
            <div class="input-anak_perusahaan formerror formerror-anak_perusahaan-0">
              <div class="input-group bottom15 col-sm-12">
                <input type="text" class="form-control anak_perusahaan" name="anak_perusahaan[]" autocomplete="off">
                <div class="input-group-btn">
                  @if($action_type!='lihat')
                    <button type="button" class="btn btn-default add-anak_perusahaan"><i class="glyphicon glyphicon-plus"></i></button>
                  @endif
                </div>
              </div>
              <div class="error error-anak_perusahaan error-anak_perusahaan-0"></div>
            </div>
            @endif
          </div>
        </div>

        @if($action_type=='lihat' || $action_type=='edit')
        @include('supplier::partials.buttons')
        @endif
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function(){
  /*
  $(document).on('click','.add-anak_perusahaan',function(){
    var _this = $(this);
    var content = _this.parent().parent();
    var btnDelete = content.find('.delete-'+attr);
    if(btnDelete.length==0){
      content.find('.input-group-btn').append('<button type="button" class="btn btn-default delete-anak_perusahaan"><i class="glyphicon glyphicon-trash"></i></button>');
    }
    content.after(create_content(attr));
  });

  function create_content(attr){
    var content = $('.'+attr),btnDelete;
    //console.log(content.length)
    if(content.length>0){
      btnDelete = '<button type="button" class="btn btn-default delete-'+attr+'"><i class="glyphicon glyphicon-trash"></i></button>'
    }
    return '<div class="input-group bottom15">\
          <input type="text" class="form-control '+attr+'" name="'+attr+'[]"  autocomplete="off">\
          <div class="input-group-btn">\
            <button type="button" class="btn btn-default add-'+attr+'"><i class="glyphicon glyphicon-plus"></i></button>\
            '+btnDelete+'\
          </div>\
        </div>';
  }
  /*
  add_select('anak_perusahaan');
  delete_select('anak_perusahaan');
  */
  
  $(document).on('click', '.add-anak_perusahaan', function(event) {
    event.preventDefault();
    var btn_del = '<button type="button" class="btn btn-default delete-anak_perusahaan"><i class="glyphicon glyphicon-trash"></i></button>';

    var $this = $('.input-anak_perusahaan');
    var new_row = $this.eq(0).clone();

    new_row.removeClass('has-error');
    new_row.find('input').val('');
    new_row.find('.error').html('');
    new_row.find('.btn-lihat').remove();
    new_row.find('.delete-anak_perusahaan').remove();
    
    $this.parent().append(new_row);

    var row = $('.input-anak_perusahaan');
    $.each(row,function(index, el) {
      if($(this).hasClass("has-error")){
        $(this).removeClass().addClass("input-anak_perusahaan has-error formerror formerror-anak_perusahaan-"+ index);
      }else{
        $(this).removeClass().addClass("input-anak_perusahaan formerror formerror-anak_perusahaan-"+ index);
      }
      
      $(this).find('.error-anak_perusahaan').removeClass().addClass("error error-anak_perusahaan error-anak_perusahaan-"+ index);

      if(row.length==1){
        $(this).find('.delete-anak_perusahaan').remove();
      }else{
        $(this).find('.delete-anak_perusahaan').remove();
        $(this).find('.input-group-btn').append(btn_del);
      }
    });
  });
  
  $(document).on('click', '.delete-anak_perusahaan', function(event) {
    $(this).parent().parent().parent().remove();
    var $this = $('.input-anak_perusahaan');
    $.each($this,function(index, el) {
      if($(this).hasClass("has-error")){
        $(this).removeClass().addClass("input-anak_perusahaan has-error formerror formerror-anak_perusahaan-"+ index);
      }else{
        $(this).removeClass().addClass("input-anak_perusahaan formerror formerror-anak_perusahaan-"+ index);
      }
      
      $(this).find('.error-anak_perusahaan').removeClass().addClass("error error-anak_perusahaan error-anak_perusahaan-"+ index);

      if($(this).length==1){
        $(this).find('.delete-anak_perusahaan').remove();
      }else{
        $(this).find('.delete-anak_perusahaan').remove();
        $(this).find('.input-group-btn').append(btn_del);
      }
    });
  });
  
});
</script>
@endpush
