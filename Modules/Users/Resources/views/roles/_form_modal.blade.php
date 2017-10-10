<div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="form-me" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Roles And Permissions</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="error-global"></div>
                        <input type="hidden" id="id" name="id" />
                        <label>Name</label>
                        <input type="text" id="display_name" name="display_name" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">
                        <div class="error-display_name"></div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" id="description" name="description" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">
                        <div class="error-description"></div>
                    </div>
                    <div class="form-group">
                    <label>Permissions</label>
                      @foreach ($permissions as $perm)
                        <div class="form-group">
                          <div class="checkbox">
                            <label>
                              <input id="permissions{{$perm->id}}" class="check-me" type="checkbox" name="permissions[]" value="{{$perm->id}}"> {{$perm->display_name}}
                            </label>
                          </div>
                        </div>
                      @endforeach
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
<div class="modal modal-danger fade" id="modal-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this data</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline btn-delete" data-loading-text="Please wait..."><i class="glyphicon glyphicon-trash"></i> Delete</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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
            $('input').iCheck('uncheck');
            btnSave.button('reset')
            modal.find('.modal-title').text(title+' Roles')
            if(title=='Edit'){
                var data = button.data('data');
                var perm = data.permissions;
                console.log(JSON.stringify(perm.length));
                if(perm.length>0){
                  $.each(perm, function( index, p ) {
                    $('#permissions'+p.id).iCheck('check');
                  });
                }
                //data = JSON.parse(data);
                modal.find('.modal-body input#id').val(data.id)
                modal.find('.modal-body input#display_name').val(data.display_name)
                modal.find('.modal-body input#description').val(data.display_name)
                modal.find('form').attr('action','{!! route('users.roles.update') !!}')
            }
            else{
                modal.find('.modal-body input#display_name').val('')
                modal.find('.modal-body input#description').val('')
                modal.find('form').attr('action','{!! route('users.roles.add') !!}')
            }
        })
        $(document).on('submit','#form-me',function (event) {
            event.preventDefault();
            var formMe = $(this)
            var attErrorName = formMe.find('.error-display_name')
            var attErrorDesc = formMe.find('.error-description')
            attErrorName.html('')
            attErrorDesc.html('')
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
                        if(_response.errors.display_name){
                            attErrorName.html('<span class="text-danger">'+_response.errors.display_name+'</span>');
                        }
                        if(_response.errors.description){
                            attErrorDesc.html('<span class="text-danger">'+_response.errors.description+'</span>');
                        }
                    }
                    else{
                        $('#form-modal').modal('hide')
                        alertBS('Data successfully updated','success')
                        var table = $('#datatables').dataTable();
                            table.fnStandingRedraw();
                    }
                    btnSave.button('reset')
                },
                error: function( _response ){
                    // Handle error
                    btnSave.button('reset')
                    $('#form-modal').modal('hide')
                    alertBS('Something wrong, please try again','danger')
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
                url: '{!! route('users.roles.delete') !!}',
                type: 'delete',
                chache:false,
                data: {_token:'{!! csrf_token() !!}',id:$(this).attr('data-id')}, // Remember that you need to have your csrf token included
                dataType: 'json',
                success: function( _response ){
                    // Handle your response..
                    console.log(_response)
                    alertBS('Data successfully deleted','success')
                    var table = $('#datatables').dataTable();
                    table.fnStandingRedraw();
                    btnDelete.button('reset')
                    btnDelete.attr('data-is','');
                    modalDelete.modal('hide')
                },
                error: function( _response ){
                    // Handle error
                    btnSave.button('reset')
                    alertBS('Something wrong, please try again','danger')
                    modalDelete.modal('hide')
                    btnDelete.attr('data-is','');
                }
            });
        })
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
    });
</script>
@endpush
