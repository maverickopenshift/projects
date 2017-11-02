<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Latar Belakang
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Latar Belakang</label>
            <div class="col-sm-10">
              <div class="row row-legal-dokumen bottom15">
                  <div class="col-sm-4">
                      <input type="text" class="form-control" name="legal_dokumen[][name]" placeholder="Latar Belakang" value="" autocomplete="off">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="file" class="hide" name="legal_dokumen[][file]">
                      <input class="form-control" type="text" disabled>
                      <span class="input-group-btn">
                        <button class="btn btn-default click-upload" type="button">Browse</button>
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-4 attr-btn">
                      <button type="button" class="btn btn-danger add-legal-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
                  </div>
                </div>
            </div>
          </div>
          {{-- @include('documents::partials.buttons') --}}
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
