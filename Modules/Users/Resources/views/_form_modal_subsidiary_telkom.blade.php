 <div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog modal-lg" role="document" style="position:relative;">
      <div class="loading-modal"></div>
        <div class="modal-content">
            <form id="form-subsidiary" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Subsidiary Telkom</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="error-global"></div>
                        <input type="hidden" id="id" name="id" />
                        <label>Name</label>
                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-name"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Address</label>
                        <textarea id="address" name="address" value="" class="form-control" placeholder="Enter ..."></textarea>
                        <div class="error-address"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Phone</label>
                        <input type="text" id="phone" name="phone" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-phone"></div>
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
        // var titleForm = button.data('title');
        // if(titleForm=='Edit'){
        //   alert("hai");
        // }
        formModal.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            var btnSave = modal.find('.btn-save')
            btnSave.button('reset')
            modal.find('.modal-title').text(title+' Subsidiary Telkom')
            if(title=='Edit'){
                var data = button.data('data');
                // data = JSON.parse(data);
                // console.log(data);
                modal.find('.modal-body input#id').val(data.id)
                modal.find('.modal-body input#name').val(data.name)
                modal.find('.modal-body textarea#address').val(data.address)
                modal.find('.modal-body input#phone').val(data.phone)
                modal.find('.content-atasan').html('')
                modal.find('form').attr('action','{!! route('users.subsidiary-telkom.update') !!}')
            }
            else{
                modal.find('.modal-body input#id').val('')
                modal.find('.modal-body input#name').val('')
                modal.find('.modal-body textarea#address').val('')
                modal.find('.modal-body input#phone').val('')
                modal.find('form').attr('action','{!! route('users.subsidiary-telkom.add') !!}')
            }
        })
        $(document).on('submit','#form-subsidiary',function (event) {
            event.preventDefault();
            var modal = $('#form-modal');
            var loading = modal.find('.loading-modal');
            loading.show();
            var formMe = $(this)
            var attError = {
                    name     : formMe.find('.error-name'),
                    address : formMe.find('.error-address'),
                    phone    : formMe.find('.error-phone'),
              };
            attError.name.html('')
            attError.name.parent().removeClass('has-error')
            attError.address.html('')
            attError.address.parent().removeClass('has-error')
            attError.phone.html('')
            attError.phone.parent().removeClass('has-error')
            var btnSave = formMe.find('.btn-save')
            btnSave.button('loading')
            $.ajax({
                url: formMe.attr('action'),
                type: 'post',
                data: formMe.serialize(), // Remember that you need to have your csrf token included
                dataType: 'json',
                success: function( _response ){
                    // Handle your response..
                    console.log(_response)
                    if(_response.errors){
                        if(_response.errors.name){
                            attError.name.html('<span class="text-danger">'+_response.errors.name+'</span>');
                            attError.name.parent().addClass('has-error')
                        }
                        if(_response.errors.address){
                            attError.address.html('<span class="text-danger">'+_response.errors.address+'</span>');
                            attError.address.parent().addClass('has-error')
                        }
                        if(_response.errors.phone){
                            attError.phone.html('<span class="text-danger">'+_response.errors.phone+'</span>');
                            attError.phone.parent().addClass('has-error')
                        }
                        modal.scrollTop(0);
                    }
                    else{
                        $('#form-modal').modal('hide')
                        alertBS('Data successfully updated','success')
                        var table = $('#datatables').dataTable();
                            table.fnStandingRedraw();
                    }
                    btnSave.button('reset')
                    loading.hide()
                },
                error: function( _response ){
                    // Handle error
                    btnSave.button('reset')
                    $('#form-modal').modal('hide')
                    alertBS('Something wrong, please try again','danger')
                    loading.hide()
                }
            });
        })
        var modalDelete = $('#modal-delete');
        modalDelete.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id')
            var modal = $(this)
            var btnDelete = modal.find('.btn-delete')
            btnDelete.attr('data-id',button.data('id'))
            btnDelete.attr('data-token',button.data('token'))
            btnDelete.button('reset')
        })

        $(document).on('click','.btn-delete',function (event) {
            event.preventDefault();
            var btnDelete = $(this)
            btnDelete.button('loading')
            $.ajax({
                url: '{!! route('users.subsidiary-telkom.delete') !!}',
                type: 'delete',
                chache:false,
                data: {_token:'{!! csrf_token() !!}',id:$(this).attr('data-id')}, // Remember that you need to have your csrf token included
                dataType: 'json',
                success: function( _response ){
                    // Handle your response..
                    console.log(_response)
                    if(_response.status){
                      alertBS(_response.msg,'success')
                      var table = $('#datatables').dataTable();
                      table.fnStandingRedraw();
                    }
                    else{
                      alertBS(_response.msg,'danger')
                    }
                    btnDelete.button('reset')
                    btnDelete.attr('data-id','');
                    modalDelete.modal('hide')
                },
                error: function( _response ){
                    // Handle error
                    btnDelete.button('reset')
                    alertBS('Data yang Anda pilih tidak dapat dihapus','danger')
                    modalDelete.modal('hide')
                    btnDelete.attr('data-id','');
                }
            });
        })
    });
</script>
@endpush
