<div class="form-group text-center top50">
  <a href="{{route('doc',['status'=>'selesai'])}}" class="btn btn-danger" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">BATAL</a>
  <button type="submit" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;" id="btn-draft">SIMPAN DRAFT</button>
  <button type="submit" class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;" id="btn-submit">SUBMIT</button>
  <input type="hidden" id="statusButton" name="statusButton">
</div>
@push('scripts')
<script>
$(function() {
  // $('.formatTanggal').datepicker({
  //       dateFormat: 'Y-m-d'
  //   });

  $(document).on('click', '#btn-draft', function(event) {
    $('#statusButton').val('2');
  });

  $(document).on('click', '#btn-submit', function(event) {
    $('#statusButton').val('0');
  });

});
</script>
@endpush
