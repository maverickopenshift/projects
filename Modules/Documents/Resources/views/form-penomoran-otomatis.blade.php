@if($auto_numb=='off')
<div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;padding-bottom:0">
  <div id="penomoran-otomatis-form" class="form-group  formerror formerror-doc_no">
    <label class="col-sm-2 control-label"><span class="text-red">*</span> No. Kontrak</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="doc_no"  value="{{old('doc_no',Helper::prop_exists($doc,'doc_no'))}}"  placeholder="Masukan Nomor Kontrak" autocomplete="off">
      <div class="error error-doc_no"></div>
    </div>
  </div>
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
@endif