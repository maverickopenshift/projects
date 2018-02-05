 <div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog modal-lg" role="document" style="position:relative;">
      <div class="loading-modal"></div>
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
                      <label>Pilih Pegawai</label>
                      <select class="form-control select-user-telkom" style="width: 100%;" name="user_search" id="user_search">
                          <option value="">Pilih Pegawai</option>
                      </select>
                      <div class="error-user_search"></div>
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
                    <div class="form-group">
                        <div class="error-global"></div>
                        <input type="hidden" id="id" name="id" />
                        <label>Name</label>
                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter ..." required autocomplete="off"  disabled="disabled">
                        <div class="error-name"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Username</label>
                        <input type="text" id="username" name="username" value="" class="form-control" placeholder="Enter ..." required autocomplete="off" disabled="disabled">
                        <div class="error-username"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Email</label>
                        <input type="email" id="email" name="email" value="" class="form-control" placeholder="Enter ..." required autocomplete="off" disabled="disabled">
                        <div class="error-email"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Phone</label>
                        <input type="text" id="phone" name="phone" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-phone"></div>
                    </div>
                    <div class="form-group">
                      <label>User Type</label>
                      <select class="form-control" style="width: 100%;" name="user_type" id="user_type">
                        <option value="ubis">Ubis</option>
                        <option value="witel">Witel</option>
                      </select>
                      <div class="error-user_type"></div>
                    </div>
                    <div class="form-group">
                      <label>Pilih Approver</label>
                      <select class="form-control select-user-approver" style="width: 100%;" name="or_user_approver" id="or_user_approver" data-action="or_approver">
                          <option value="">Pilih Approver</option>
                      </select>
                      <div class="error-or_user_approver"></div>
                    </div>
                    <div class="table-or_approver table-responsive" style="display:none;">
                      <table class="table table-bordered">
                            <thead>
                            <tr>
                              <th width="40">No.</th>
                              <th class="hide"></th>
                              <th width="200">Nama</th>
                              <th width="150">Email</th>
                              <th width="250">Jabatan</th>
                              <th width="60">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                    </div>
                    <div class="form-group">
                      <label>Pilih Atasan</label>
                      <select class="form-control select-user-atasan" style="width: 100%;" name="or_user_atasan" id="or_user_atasan" data-action="or_atasan">
                          <option value="">Pilih Atasan</option>
                      </select>
                      <div class="error-or_user_atasan"></div>
                    </div>
                    <div class="table-or_atasan table-responsive" style="display:none;">
                      <table class="table table-bordered">
                            <thead>
                            <tr>
                              <th width="40">No.</th>
                              <th class="hide"></th>
                              <th width="200">Nama</th>
                              <th width="150">Email</th>
                              <th width="250">Jabatan</th>
                              <th width="60">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                    </div>
                    <div class="form-group">
                      <label>Roles</label>
                      <select class="form-control" style="width: 100%;" name="roles" id="roles">
                        <option value="">Pilih Roles</option>
                        @foreach ($roles as $role)
                          <option value="{{$role->id}}">{{$role->display_name}}</option>
                        @endforeach
                      </select>
                      <div class="error-roles"></div>
                    </div>
                    <div class="form-group">
                      <label>User PGS</label>
                      <select class="form-control user_pgs" style="width: 100%;" name="user_pgs" id="user_pgs">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                      </select>
                    </div>
                    <div class="table-pgs" style="display:none;border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
                      <div class="form-group">
                        <label>PGS Divisi</label>
                          <select class="form-control" style="width: 100%;" name="pgs_divisi_or" id="pgs_divisi_or">
                              <option value="">Pilih Divisi</option>
                          </select>
                          <div class="error-pgs_divisi_or"></div>
                      </div>
                      <div class="form-group">
                        <label>PGS Unit</label>
                          <select class="form-control" style="width: 100%;" name="pgs_unit_or" id="pgs_unit_or">
                              <option value="">Pilih Unit</option>
                          </select>
                          <div class="error-pgs_unit_or"></div>
                      </div>
                      <div class="form-group">
                        <label>PGS Jabatan</label>
                          <select class="form-control" style="width: 100%;" name="pgs_jabatan_or" id="pgs_jabatan_or">
                              <option value="">Pilih Jabatan</option>
                          </select>
                          <div class="error-pgs_jabatan_or"></div>
                      </div>
                      <div class="form-group">
                        <label>PGS Roles</label>
                          <select class="form-control" style="width: 100%;" name="pgs_roles_or" id="pgs_roles_or">
                            <option value="">Pilih Roles</option>
                            @foreach ($roles as $role)
                              <option value="{{$role->id}}">{{$role->display_name}}</option>
                            @endforeach
                          </select>
                          <div class="error-pgs_roles_or"></div>
                      </div>
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
<div class="modal fade" role="dialog" id="modal-reset">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-reset" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reset Password User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="error-global"></div>
                        <input type="hidden" id="id" name="id" />
                        <label>Password Baru</label>
                        <input type="password" id="reset_password" name="reset_password" class="form-control" placeholder="Enter ..." required autocomplete="off">
                        <div class="error-reset_password"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Konfirmasi Password</label>
                        <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="form-control" placeholder="Enter ..." required autocomplete="off">
                        <div class="error-konfirmasi_password"></div>
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
@push('css')
  <style>
  span.select2-container {
    z-index:auto !important;
  }
  </style>
@endpush
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
            $('input').iCheck('uncheck');
            modal.find('.modal-title').text(title+' User')
            modal.find('.content-password').html('');
            $(this).val('');
            $('#select2-pic_search-container').html('');
            selectUser("#or_user_atasan")
            selectUser("#or_user_approver")
            selectMe__('#pgs_divisi_or','divisi')
            selectMe__('#pgs_unit_or','unit','#pgs_divisi')
            selectMe__('#pgs_jabatan_or','posisi','#pgs_unit')
            selectUser("#user_search")
            if(title=='Edit'){
                var data = button.data('data');
                var data_other = button.data('other');
                var role = data.roles;
                // data = JSON.parse(data);
                console.log(data_other.v_nama_karyawan+' - '+data_other.n_nik);
                var user_search = modal.find('.modal-body #user_search');
                var newOption = new Option(data_other.v_nama_karyawan+' - '+data_other.n_nik, data_other.id, false, true);
                user_search.append(newOption);
                user_search.val(data_other.id).change();
                
                modal.find('.modal-body input#id').val(data.id)
                modal.find('.modal-body input#name').val(data.name)
                modal.find('.modal-body input#username').val(data.username)
                modal.find('.modal-body input#email').val(data.email)
                modal.find('.modal-body input#phone').val(data.phone)
                modal.find('.modal-body select#roles').val(role[0].id)
                modal.find('.modal-body select#user_type').val(data.user_type)
                modal.find('.modal-body input#divisi').val(data_other.v_short_divisi)
                modal.find('.modal-body input#loker').val(data_other.v_short_unit)
                modal.find('.modal-body input#jabatan').val(data_other.v_short_posisi)
                // modal.find('.content-add').html('')
                modal.find('.table-atasan').hide().find('table>tbody').html('')
                modal.find('.table-approver').hide().find('table>tbody').html('')
                modal.find('form').attr('action','{!! route('users.update') !!}')
            }
            else{
                modal.find('.modal-body input#id').val('')
                modal.find('.modal-body input#name').val('')
                modal.find('.modal-body input#username').val('')
                modal.find('.modal-body input#email').val('')
                modal.find('.modal-body input#phone').val('')
                modal.find('.modal-body input#divisi').val('')
                modal.find('.modal-body input#loker').val('')
                modal.find('.modal-body input#jabatan').val('')
                
                modal.find('.modal-body select#roles').val('')
                modal.find('.modal-body select#user_pgs').val('no')
                modal.find('.modal-body select#pgs_roles').val('')
                modal.find('.modal-body select#user_type').val('ubis')
                
                modal.find('.table-atasan').hide().find('table>tbody').html('')
                reset_select2('pgs_divisi_or')
                reset_select2('pgs_jabatan_or')
                reset_select2('pgs_unit_or')
                reset_select2('user_search')
                modal.find('form').attr('action','{!! route('users.add') !!}')
            }
        })
        onSelect2('or_user_approver','approver');
        onSelect2('or_user_atasan','atasan');
        $(document).on('submit','#form-me',function (event) {
            event.preventDefault();
            var modal = $('#form-modal');
            var loading = modal.find('.loading-modal');
            loading.show();
            var formMe = $(this)
            var attError = {
                    name     : formMe.find('.error-display_name'),
                    username : formMe.find('.error-username'),
                    phone    : formMe.find('.error-phone'),
                    email    : formMe.find('.error-email'),
                    password : formMe.find('.error-password'),
                    roles : formMe.find('.error-roles'),
                    user_type    : formMe.find('.error-user_type'),
                    non_user_approver    : formMe.find('.error-or_user_approver'),
                    non_user_atasan    : formMe.find('.error-or_user_atasan'),
                    pgs_divisi    : formMe.find('.error-pgs_divisi_or'),
                    pgs_unit    : formMe.find('.error-pgs_unit_or'),
                    pgs_jabatan    : formMe.find('.error-pgs_jabatan_or'),
                    pgs_roles    : formMe.find('.error-pgs_roles_or'),
                    user_search    : formMe.find('.error-user_search'),
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
            attError.roles.html('')
            attError.roles.parent().removeClass('has-error')
            attError.user_type.html('')
            attError.user_type.parent().removeClass('has-error')
            attError.user_search.html('')
            attError.user_search.parent().removeClass('has-error')
            attError.non_user_approver.html('')
            attError.non_user_approver.parent().removeClass('has-error')
            attError.non_user_atasan.html('')
            attError.non_user_atasan.parent().removeClass('has-error')
            attError.pgs_divisi.html('')
            attError.pgs_divisi.parent().removeClass('has-error')
            attError.pgs_unit.html('')
            attError.pgs_unit.parent().removeClass('has-error')
            attError.pgs_jabatan.html('')
            attError.pgs_jabatan.parent().removeClass('has-error')
            attError.pgs_roles.html('')
            attError.pgs_roles.parent().removeClass('has-error')
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
                            attError.user_search.html('<span class="text-danger">'+_response.errors.username+'</span>');
                            attError.user_search.parent().addClass('has-error')
                        }
                        if(_response.errors.email){
                            attError.user_search.html('<span class="text-danger">'+_response.errors.email+'</span>');
                            attError.user_search.parent().addClass('has-error')
                        }
                        if(_response.errors.phone){
                            attError.phone.html('<span class="text-danger">'+_response.errors.phone+'</span>');
                            attError.phone.parent().addClass('has-error')
                        }
                        if(_response.errors.password){
                            attError.password.html('<span class="text-danger">'+_response.errors.password+'</span>');
                            attError.password.parent().addClass('has-error')
                        }
                        if(_response.errors.roles){
                            attError.roles.html('<span class="text-danger">'+_response.errors.roles+'</span>');
                            //attError.roles.parent().addClass('has-error')
                        }
                        if(_response.errors.user_type){
                            attError.user_type.html('<span class="text-danger">'+_response.errors.user_type+'</span>');
                            attError.user_type.parent().addClass('has-error')
                        }
                        if(_response.errors.non_user_approver){
                            attError.non_user_approver.html('<span class="text-danger">'+_response.errors.non_user_approver+'</span>');
                            attError.non_user_approver.parent().addClass('has-error')
                        }
                        if(_response.errors.non_user_atasan){
                            attError.non_user_atasan.html('<span class="text-danger">'+_response.errors.non_user_atasan+'</span>');
                            attError.non_user_atasan.parent().addClass('has-error')
                        }
                        if(_response.errors.user_search){
                            attError.user_search.html('<span class="text-danger">'+_response.errors.user_search+'</span>');
                            attError.user_search.parent().addClass('has-error')
                        }
                        if(_response.errors.pgs_divisi){
                            attError.pgs_divisi.html('<span class="text-danger">'+_response.errors.pgs_divisi+'</span>');
                            attError.pgs_divisi.parent().addClass('has-error')
                        }
                        if(_response.errors.pgs_unit){
                            attError.pgs_unit.html('<span class="text-danger">'+_response.errors.pgs_unit+'</span>');
                            attError.pgs_unit.parent().addClass('has-error')
                        }
                        if(_response.errors.pgs_jabatan){
                            attError.pgs_jabatan.html('<span class="text-danger">'+_response.errors.pgs_jabatan+'</span>');
                            attError.pgs_jabatan.parent().addClass('has-error')
                        }
                        if(_response.errors.pgs_roles){
                            attError.pgs_roles.html('<span class="text-danger">'+_response.errors.pgs_roles+'</span>');
                            attError.pgs_roles.parent().addClass('has-error')
                        }
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
                }
            });
        })

        var modal_reset = $('#modal-reset');
        modal_reset.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
            var btnSave = modal.find('.btn-save')
            btnSave.button('reset')
                var data = button.data('data');
                modal.find('.modal-body input#id').val(data.id)
        })

        $(document).on('submit','#form-reset',function (event) {
          event.preventDefault();
          var formReset = $(this)
          var attError = {
                  reset_password     : formReset.find('.error-reset_password'),
                  konfirmasi_password : formReset.find('.error-konfirmasi_password'),
            };
          attError.reset_password.html('')
          attError.reset_password.parent().removeClass('has-error')
          attError.konfirmasi_password.html('')
          attError.konfirmasi_password.parent().removeClass('has-error')
          var btnSave = formReset.find('.btn-save')
          btnSave.button('loading')
          $.ajax({
              url: '{!! route('users.reset') !!}',
              type: 'get',
              data: formReset.serialize(), // Remember that you need to have your csrf token included
              dataType: 'json',
              success: function( _response ){
                  // Handle your response..
                  console.log(_response)
                  if(_response.errors){
                      if(_response.errors.reset_password){
                          attError.reset_password.html('<span class="text-danger">'+_response.errors.reset_password+'</span>');
                          attError.reset_password.parent().addClass('has-error')
                      }
                      if(_response.errors.konfirmasi_password){
                          attError.konfirmasi_password.html('<span class="text-danger">'+_response.errors.konfirmasi_password+'</span>');
                          attError.konfirmasi_password.parent().addClass('has-error')
                      }
                  }
                  else{
                      $('#modal-reset').modal('hide')
                      alertBS('Data successfully updated','success')
                      var table = $('#datatables').dataTable();
                          table.fnStandingRedraw();
                  }
                  btnSave.button('reset')
              },
              error: function( _response ){
                  // Handle error
                  btnSave.button('reset')
                  $('#modal-reset').modal('hide')
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
          // formModal.find('.table-approver').find('table>tbody').html('');
          // formModal.find('.table-approver').hide();
          formModal.find('.content-approver').show();
          selectUser("#user_atasan",data.objiddivisi,data.v_band_posisi)
          selectUser("#user_approver")
        });
        $(document).on('select2:select', '#user_atasan', function(event) {
          event.preventDefault();
          /* Act on the event */
          var data = event.params.data;
          $(this).val('');
          $('#select2-user_atasan-container').html('');
          console.log(data);
          var $this = $('.table-'+$(this).data('action'));
          $this.show();
          var row = $this.find('table>tbody>tr');
          var new_row = $(templateAtasan(data)).clone();
          var mdf_new_row = new_row.find('td');
          mdf_new_row.eq(0).html(row.length+1);
          mdf_new_row.eq(1).find('input').val(data.n_nik);
          mdf_new_row.eq(2).text(data.v_nama_karyawan);
          mdf_new_row.eq(3).text(data.n_nik+'@telkom.co.id');
          mdf_new_row.eq(4).text(data.v_short_posisi);
          $this.find('table>tbody').append(new_row);
        });
        $(document).on('click', '.delete-atasan', function(event) {
          var tbl_t = $(this).parent().parent().parent().parent().parent();
          $(this).parent().parent().remove();
          var $this = tbl_t.clone();
          var row = $this.find('table>tbody>tr');
          if(row.length==0){
            //mdf.html('');
            tbl_t.hide();
          }
        });
        $(document).on('select2:select', '#user_approver', function(event) {
          event.preventDefault();
          /* Act on the event */
          var data = event.params.data;
          $(this).val('');
          $('#select2-user_approver-container').html('');
          console.log(data);
          var $this = $('.table-'+$(this).data('action'));
          $this.show();
          var row = $this.find('table>tbody>tr');
          var new_row = $(templateApprover(data)).clone();
          var mdf_new_row = new_row.find('td');
          mdf_new_row.eq(0).html(row.length+1);
          mdf_new_row.eq(1).find('input').val(data.n_nik);
          mdf_new_row.eq(2).text(data.v_nama_karyawan);
          mdf_new_row.eq(3).text(data.n_nik+'@telkom.co.id');
          mdf_new_row.eq(4).text(data.v_short_posisi);
          $this.find('table>tbody').append(new_row);
        });
    });
    function selectUser(attr,divisi,v_band_posisi) {
      $(attr).select2({
          placeholder : "Pilih PIC....",
          dropdownParent: $(attr).parent(),
          ajax: {
              url: '{!! route('users.get-select-user-telkom') !!}',
              dataType: 'json',
              delay: 350,
              data: function (params) {
                  var datas =  {
                      q: params.term, // search term
                      page: params.page
                  };
                  if(divisi!==undefined && v_band_posisi!==undefined){
                    var datas =  {
                        q: params.term, // search term
                        page: params.page,
                        type:divisi,
                        posisi:v_band_posisi
                    };
                  }
                  return datas;

              },
              //id: function(data){ return data.store_id; },
              processResults: function (data, params) {
                  // parse the results into the format expected by Select2
                  // since we are using custom formatting functions we do not need to
                  // alter the remote JSON data, except to indicate that infinite
                  // scrolling can be used

                  var results = [];

                  $.each(data.data, function (i, v) {
                      var o = {};
                      o.id = v.n_nik;
                      o.name = v.v_nama_karyawan;
                      o.value = v.n_nik;
                      o.username = v.n_nik;
                      o.jabatan = v.v_short_posisi;
                      o.email = v.n_nik+'@telkom.co.id';
                      o.telp = '';
                      results.push(o);
                  })
                  params.page = params.page || 1;
                  return {
                      results: data.data,
                      pagination: {
                          more: (data.next_page_url ? true: false)
                      }
                  };
              },
              cache: true
          },
          escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
          minimumInputLength: 0,
          templateResult: aoTempResult ,
          templateSelection: aoTempSelect
      });
    }
    function aoTempResult(state) {
        if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ;  }
        var $state = $(
            '<span>' +  state.v_nama_karyawan +' <i>('+  state.n_nik + ')</i></span>'
        );
        return $state;
    }
    function aoTempSelect(data){
        if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
            return;
        }
        if(data.v_nama_karyawan === undefined || data.n_nik === undefined){
          return data.text;
        }
        return data.v_nama_karyawan +' - '+  data.n_nik ;
    }
    function content_password() {
      return '<div class="form-group hide">\
          <div class="error-global"></div>\
          <label>Password</label>\
          <input type="password" id="password" name="password" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">\
          <div class="error-password"></div>\
      </div>\
      <div class="form-group hide">\
          <div class="error-global"></div>\
          <label>Confirm Password</label>\
          <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control" placeholder="Enter ..." required autocomplete="off">\
          <div class="error-password_confirmation"></div>\
      </div>';
    }
    function contentEdit() {
      return '<div class="form-group">\
                <label>Divisi</label>\
                <input type="text" id="divisi" name="divisi" class="form-control" disabled="disabled">\
              </div>\
              <div class="form-group">\
                  <label>Loker</label>\
                  <input type="text" id="loker" name="loker" class="form-control" disabled="disabled">\
              </div>\
              <div class="form-group">\
                  <label>Jabatan</label>\
                  <input type="text" id="jabatan" name="jabatan" class="form-control" disabled="disabled">\
              </div>';
    }
    function contentAtasan(attr) {
      var attr = (attr===undefined)?'atasan':attr;
      return '<div class="form-group">\
                  <label>Pilih Atasan</label>\
                  <select class="form-control select-user-atasan" style="width: 100%;" name="user_atasan" id="user_atasan" data-action="'+attr+'">\
                      <option value="">Pilih Atasan</option>\
                  </select>\
                </div>';
    }
    function contentApprover(attr) {
      var attr = (attr===undefined)?'approver':attr;
      return '<div class="form-group">\
                  <label>Pilih Approver</label>\
                  <select class="form-control select-user-approver" style="width: 100%;" name="user_approver" id="user_approver" data-action="'+attr+'">\
                      <option value="">Pilih Approver</option>\
                  </select>\
                </div>';
    }
    function templateAtasan(){
      return '<tr>\
              <td>1</td>\
              <td class="hide"><input type="hidden" name="atasan_id[]"></td>\
              <td></td>\
              <td></td>\
              <td></td>\
              <td class="action"><button type="button" class="btn btn-danger btn-xs delete-atasan"><i class="glyphicon glyphicon-remove"></i> hapus</button></td>\
          </tr>';
    }
    function templateApprover(){
      return '<tr>\
              <td>1</td>\
              <td class="hide"><input type="hidden" name="approver_id[]"></td>\
              <td></td>\
              <td></td>\
              <td></td>\
              <td class="action"><button type="button" class="btn btn-danger btn-xs delete-atasan"><i class="glyphicon glyphicon-remove"></i> hapus</button></td>\
          </tr>';
    }
    $(document).on('select2:select', '#pgs_divisi_or', function(e) {
        e.preventDefault();
        var data = e.params.data;
        reset_select2('pgs_jabatan_or');
        reset_select2('pgs_unit_or');
    });
    $(document).on('select2:select', '#pgs_unit_or', function(e) {
        e.preventDefault();
        var data = e.params.data;
        reset_select2('pgs_jabatan_or');
    });
</script>
@endpush
