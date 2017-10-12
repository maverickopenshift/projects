<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Informasi Vendor
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group {{ $errors->has('bdn_usaha') ? ' has-error' : '' }}">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Badan Usaha</label>
            <div class="col-sm-10">
              <select class="form-control" name="bdn_usaha">
                <option value="PT" {{ old('bdn_usaha')=='PT'?"selected='selected'":"" }}>PT</option>
                <option value="CV" {{ old('bdn_usaha')=='CV'?"selected='selected'":"" }}>CV</option>
              </select>
              @if ($errors->has('bdn_usaha'))
                  <span class="help-block">
                      <strong>{{ $errors->first('bdn_usaha') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('nm_vendor') ? ' has-error' : '' }}">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Perusahaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nm_vendor" value="{{ old('nm_vendor') }}">
              @if ($errors->has('nm_vendor'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nm_vendor') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('prinsipal_st') ? ' has-error' : '' }}">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Prinsipal</label>
            <div class="col-sm-10">
              <select class="form-control" name="prinsipal_st">
                <option value="1" {{ old('prinsipal_st')=='1'?"selected='selected'":"" }}>Ya</option>
                <option value="0" {{ old('prinsipal_st')!='1'?"selected='selected'":"" }}>Tidak</option>
              </select>
              @if ($errors->has('prinsipal_st'))
                  <span class="help-block">
                      <strong>{{ $errors->first('prinsipal_st') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('bdn_usaha') ? ' has-error' : '' }}">
            <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Badan Usaha</label>
            <div class="col-sm-10">
              <select class="form-control" name="bdn_usaha">
                <option value="PT" {{ old('bdn_usaha')=='PT'?"selected='selected'":"" }}>PT</option>
                <option value="CV" {{ old('bdn_usaha')=='CV'?"selected='selected'":"" }}>CV</option>
              </select>
              @if ($errors->has('bdn_usaha'))
                  <span class="help-block">
                      <strong>{{ $errors->first('bdn_usaha') }}</strong>
                  </span>
              @endif
            </div>
          </div>
      </div>
    </div>
<!-- /.box-body -->
</div>
