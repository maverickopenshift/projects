<div class="form-group text-center top50">
  <a href="{{route('doc',['status'=>Helper::doc_status($doc->doc_signing)])}}" class="btn btn-danger" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">BATAL</a>
  @if($doc->doc_signing!=1)
    <button type="submit" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px;" id="btn-draft">SIMPAN DRAFT</button>
  @endif
  {{-- @if($doc->doc_signing==0)
    <button type="submit" class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;" id="btn-submit">SUBMIT</button>
  @endif
  @if($doc->doc_signing==1)
    <button type="submit" class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;" id="btn-simpan">SIMPAN</button>
  @endif --}}
  <button type="submit" class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;">SUBMIT</button>
</div>
@push('scripts')
<script>
// $(function() {
//   // $('.formatTanggal').datepicker({
//   //       dateFormat: 'Y-m-d'
//   //   });
//
//   $(document).on('click', '#btn-draft', function(event) {
//     $('#statusButton2').val('2');
//   });
//
//   $(document).on('click', '#btn-submit', function(event) {
//     $('#statusButton2').val('0');
//   });
//   $(document).on('click', '#btn-simpan', function(event) {
//     $('#statusButton2').val('1');
//   });
//
// });
</script>
@endpush
