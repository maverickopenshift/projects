<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          SOW,BOQ
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Lingkup Pekerjaan</label>
            <div class="col-sm-10">
              <textarea class="form-control" cols="4" rows="4"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> BOQ</label>
            <div class="col-sm-6">
              
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
