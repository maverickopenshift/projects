<div class="form-group text-center top50">
  <textarea class="form-control komentar hide" rows="4" name="komentar">{{old('komentar')}}</textarea>
  <a href="{{route('doc',['status'=>'selesai'])}}" class="btn btn-danger" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">CANCEL</a>
  <button type="submit" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px;" id="btn-draft">DRAFT</button>
  <button class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;" id="btn-submit">SUBMIT</button>
  <button class="btn btn-primary btn-sm btn_submit hide" type="submit"></button>
</div>
@push('scripts')
<script>
$(function() {
  // $('.formatTanggal').datepicker({
  //       dateFormat: 'Y-m-d'
  //   });
});
</script>
@endpush
