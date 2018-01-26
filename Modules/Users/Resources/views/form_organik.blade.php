<div class="form-group">
  <div class="error-global"></div>
  <label>Pilih Pegawai</label>
  <select class="form-control select-user-telkom" style="width: 100%;" name="user_search" id="user_search">
      <option value="">Pilih Pegawai</option>
  </select>
</div>
<div class="form-group">
    <label>Divisi</label>
    <input type="text" id="divisi" name="divisi" class="form-control" disabled="disabled">
</div>
<div class="form-group">
    <label>Loker</label>
    <input type="text" id="loker" name="loker" class="form-control" disabled="disabled">
</div>
<div class="form-group">
    <label>Jabatan</label>
    <input type="text" id="jabatan" name="jabatan" class="form-control" disabled="disabled">
</div>
@push('scripts')
<script>
$(function() {
  selectUser('#user_search','Pegawai');
});
$(document).on('select2:select', '#user_search', function(event) {
  event.preventDefault();
  /* Act on the event */
  var data = event.params.data;
  // console.log(data);
  formModal.find('#name').val(data.v_nama_karyawan);
  formModal.find('#username').val(data.n_nik);
  formModal.find('#divisi').val(data.v_short_divisi);
  formModal.find('#loker').val(data.v_short_unit);
  formModal.find('#jabatan').val(data.v_short_posisi);
  formModal.find('#password').val('{!!config('app.password_default')!!}').parent().find('.info-default').remove();
  formModal.find('#password').after('<span class="text-info info-default">Default password {!!config('app.password_default')!!}')
  formModal.find('#password_confirmation').val('{!!config('app.password_default')!!}');
  formModal.find('#email').val(data.n_nik+'@telkom.co.id');
  formModal.find('.table-atasan').find('table>tbody').html('');
  formModal.find('.table-atasan').hide();
  formModal.find('.content-atasan').show();
  selectUser("#user_atasan",data.objiddivisi,data.v_band_posisi)
});
</script>
@endpush