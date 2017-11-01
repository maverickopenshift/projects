<div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-me" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Approval Data Vendor </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="error-global"></div>
                        <input type="hidden" id="id" name="id"  />
                        <label>No Vendor</label>
                        <input type="text" id="kd_vendor" name="kd_vendor" value="" class="form-control" required autocomplete="off" disabled="true">
                        <div class="error-name"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Status Vendor</label>
                        <select class="form-control" name="status" id="status">
                          <option value="1" {{ old('prinsipal_st')=='1'?"selected='selected'":"" }}>Data Sudah Disetujui</option>
                          <option value="0" {{ old('prinsipal_st')!='1'?"selected='selected'":"" }}>Data Belum Disetujui</option>
                        </select>
                        <div class="error-name"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-save" data-loading-text="Please wait..." autocomplete="off">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('scripts')
<script>
    $(function() {
        var formModal = $('#form-modal');
        formModal.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            var btnSave = modal.find('.btn-save')
            btnSave.button('reset')
            $('input').iCheck('uncheck');

                var data = button.data('data');
                var role = data.roles;

                //data = JSON.parse(data);
                modal.find('.modal-body input#id').val(data.id)
                modal.find('.modal-body input#kd_vendor').val(data.kd_vendor)
                $('#status').val(data.vendor_status)
                modal.find('form').attr('action','{!! route('supplier.editstatus') !!}')


        })
        $(document).on('submit','#form-me',function (event) {
            // event.preventDefault();
            var formMe = $(this)
            var btnSave = formMe.find('.btn-save')
            btnSave.button('loading')
            $.ajax({
                url: formMe.attr('action'),
                type: 'post',
                data: formMe.serialize(), // Remember that you need to have your csrf token included
                dataType: 'json',
                success: function(data){
                  // Handle your response..
                  console.log(data)

                  $('#form-modal').modal('hide')
                  var table = $('#datatables').dataTable();
                  table.fnStandingRedraw();
                  btnSave.button('reset')
                },
                error: function( data ){
                    // Handle error
                    btnSave.button('reset')
                    $('#form-modal').modal('hide')
                }
            });
        })
    });

</script>
@endpush
