<div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-me" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="error-global"></div>
                        <input type="hidden" id="id" name="id" />
                        <label>Name</label>
                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">
                        <div class="error-name"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Username</label>
                        <input type="text" id="username" name="username" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">
                        <div class="error-username"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Email</label>
                        <input type="email" id="email" name="email" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">
                        <div class="error-email"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Phone</label>
                        <input type="text" id="phone" name="phone" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">
                        <div class="error-phone"></div>
                    </div>
                    <div class="content-password"></div>
                    <div class="form-group">
                    <label>Roles</label>
                      @foreach ($roles as $role)
                        <div class="form-group">
                          <div class="checkbox">
                            <label>
                              <input id="roles{{$role->id}}" class="check-me" type="checkbox" name="roles[]" value="{{$role->id}}"> {{$role->display_name}}
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
            btnSave.button('reset')
            $('input').iCheck('uncheck');
            modal.find('.modal-title').text(title+' User')
            modal.find('.content-password').html('');
            if(title=='Edit'){
                var data = button.data('data');
                var role = data.roles;
                if(role.length>0){
                  $.each(role, function( index, p ) {
                    $('#roles'+p.id).iCheck('check');
                  });
                }
                //data = JSON.parse(data);
                modal.find('.modal-body input#id').val(data.id)
                modal.find('.modal-body input#name').val(data.name)
                modal.find('.modal-body input#username').val(data.username)
                modal.find('.modal-body input#email').val(data.email)
                modal.find('.modal-body input#phone').val(data.phone)
                modal.find('form').attr('action','{!! route('users.update') !!}')
            }
            else{
                modal.find('.modal-body input#id').val('')
                modal.find('.modal-body input#name').val('')
                modal.find('.modal-body input#username').val('')
                modal.find('.modal-body input#email').val('')
                modal.find('.modal-body input#phone').val('')
                modal.find('.content-password').html(content_password())
                modal.find('form').attr('action','{!! route('users.add') !!}')
            }
        })
        $(document).on('submit','#form-me',function (event) {
            event.preventDefault();
            var formMe = $(this)
            var attError = {
                    name     : formMe.find('.error-display_name'),
                    username : formMe.find('.error-username'),
                    phone    : formMe.find('.error-phone'),
                    email    : formMe.find('.error-email'),
                    password : formMe.find('.error-password'),
              };
            attError.name.html('')
            attError.name.parent().removeClass('has-error')
            attError.username.html('')
            attError.username.parent().removeClass('has-error')
            attError.phone.html('')
            attError.phone.parent().removeClass('has-error')
            attError.email.html('')
            attError.email.parent().removeClass('has-error')
            attError.password.html('')
            attError.password.parent().removeClass('has-error')
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
                        if(_response.errors.username){
                            attError.username.html('<span class="text-danger">'+_response.errors.username+'</span>');
                            attError.username.parent().addClass('has-error')
                        }
                        if(_response.errors.email){
                            attError.email.html('<span class="text-danger">'+_response.errors.email+'</span>');
                            attError.email.parent().addClass('has-error')
                        }
                        if(_response.errors.phone){
                            attError.phone.html('<span class="text-danger">'+_response.errors.phone+'</span>');
                            attError.phone.parent().addClass('has-error')
                        }
                        if(_response.errors.password){
                            attError.password.html('<span class="text-danger">'+_response.errors.password+'</span>');
                            attError.password.parent().addClass('has-error')
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
                url: '{!! route('users.delete') !!}',
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
    });
    function content_password() {
      return '<div class="form-group">\
          <div class="error-global"></div>\
          <label>Password</label>\
          <input type="password" id="password" name="password" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">\
          <div class="error-password"></div>\
      </div>\
      <div class="form-group">\
          <div class="error-global"></div>\
          <label>Confirm Password</label>\
          <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">\
          <div class="error-password_confirmation"></div>\
      </div>';
    }
</script>
@endpush
