<div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog modal-lg" role="document" style="position:relative;">
      <div class="loading-modal"></div>
        <div class="modal-content">
            <form id="form-me" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit User xx</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group formerror formerror-user_search">
                      <div class="error-global"></div>
                      <label>Pilih Pegawai</label>
                      <select class="form-control select-user-telkom" style="width: 100%;" name="user_search" id="user_search">
                          <option value="">Pilih Pegawai</option>
                      </select>
                      <div class="error error-user_search"></div>
                    </div>
                    <div class="form-group ready-select" style="display:none;">
                      <span class="span-oke">Nama</span> <span id="name"></span></br>
                      <span class="span-oke">Username</span> <span id="username"></span></br>
                      <span class="span-oke">Email</span> <span id="email"></span></br>
                      <span class="span-oke">Divisi</span> <span id="divisi"></span></br>
                      <span class="span-oke">Unit Bisnis</span> <span id="unit_bisnis"></span> </br>
                      <span class="span-oke">Unit Kerja</span> <span id="unit_kerja"></span> </br>
                      <span class="span-oke">Jabatan</span> <span id="jabatan"></span> </br>
                      <input type="hidden" id="id_edit" name="id" />
                    </div>
                    <div class="form-group  formerror formerror-phone">
                        <div class="error-global"></div>
                        <label>Phone</label>
                        <input type="text" id="phone" name="phone" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error error-phone"></div>
                    </div>
                    <div class="form-group formerror formerror-user_type">
                      <label>User Type</label>
                      <select class="form-control" style="width: 100%;" name="user_type" id="user_type">
                        <option value="ubis">Ubis</option>
                        <option value="witel">Witel</option>
                      </select>
                      <div class="error error-user_type"></div>
                    </div>
                    <div class="form-group formerror formerror-or_user_approver hide">
                      <label>Pilih Approver</label>
                      <select class="form-control select-user-approver" style="width: 100%;" name="or_user_approver" id="or_user_approver" data-action="or_approver">
                          <option value="">Pilih Approver</option>
                      </select>
                      <div class="error error-or_user_approver"></div>
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
                    <div class="form-group formerror formerror-or_user_atasan">
                      <label>Pilih Penandatangan Kontrak</label>
                      <select class="form-control select-user-atasan" style="width: 100%;" name="or_user_atasan" id="or_user_atasan" data-action="or_atasan">
                          <option value="">Pilih Penandatangan Kontrak</option>
                      </select>
                      <div class="error error-or_user_atasan"></div>
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
                    <div class="form-group formerror formerror-roles">
                      <label>Roles</label>
                      <select class="form-control" style="width: 100%;" name="roles" id="roles">
                        <option value="">Pilih Roles</option>
                        @foreach ($roles as $role)
                          <option value="{{$role->id}}">{{$role->display_name}}</option>
                        @endforeach
                      </select>
                      <div class="error error-roles"></div>
                    </div>
                    <div class="form-group">
                      <label>User PGS</label>
                      <select class="form-control user_pgs" style="width: 100%;" name="user_pgs" id="user_pgs">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                      </select>
                    </div>
                    <div class="table-pgs" style="display:none;border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
                      <div class="form-group formerror formerror-pgs_divisi_or">
                        <label>PGS Divisi</label>
                          <select class="form-control" style="width: 100%;" name="pgs_divisi_or" id="pgs_divisi_or">
                              <option value="">Pilih Divisi</option>
                          </select>
                          <div class="error error-pgs_divisi_or"></div>
                      </div>
                      <div class="form-group formerror formerror-pgs_unit_bisnis_or">
                        <label>PGS Unit Bisnis</label>
                          <select class="form-control" style="width: 100%;" name="pgs_unit_bisnis_or" id="pgs_unit_bisnis_or">
                              <option value="">Pilih Unit Bisnis</option>
                          </select>
                          <div class="error error-pgs_unit_bisnis_or"></div>
                      </div>
                      <div class="form-group formerror formerror-pgs_unit_kerja_or">
                        <label>PGS Unit Kerja</label>
                          <select class="form-control" style="width: 100%;" name="pgs_unit_kerja_or" id="pgs_unit_kerja_or">
                              <option value="">Pilih Unit Kerja</option>
                          </select>
                          <div class="error error-pgs_unit_kerja_or"></div>
                      </div>
                      <div class="form-group formerror formerror-pgs_jabatan_or">
                        <label>PGS Jabatan</label>
                          <select class="form-control" style="width: 100%;" name="pgs_jabatan_or" id="pgs_jabatan_or">
                              <option value="">Pilih Jabatan</option>
                          </select>
                          <div class="error error-pgs_jabatan_or"></div>
                      </div>
                      <div class="form-group formerror formerror-pgs_loker_or hide">
                        <label>PGS Loker</label>
                          <select class="form-control" style="width: 100%;" name="pgs_loker_or" id="pgs_loker_or">
                              <option value="">Pilih Loker</option>
                          </select>
                          <div class="error error-pgs_loker_or"></div>
                      </div>
                      <div class="form-group formerror formerror-pgs_roles_or">
                        <label>PGS Roles</label>
                          <select class="form-control" style="width: 100%;" name="pgs_roles_or" id="pgs_roles_or">
                            <option value="">Pilih Roles</option>
                            @foreach ($roles as $role)
                              <option value="{{$role->id}}">{{$role->display_name}}</option>
                            @endforeach
                          </select>
                          <div class="error error-pgs_roles_or"></div>
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
            reset_error();
            $('#select2-pic_search-container').html('');
            selectUser("#or_user_approver")
            selectMe__('#pgs_divisi_or','divisi')
            selectMe__('#pgs_unit_bisnis_or','unit_bisnis','#pgs_divisi_or')
            selectMe__('#pgs_unit_kerja_or','unit_kerja','#pgs_unit_bisnis_or')
            selectMe__('#pgs_jabatan_or','posisi','#pgs_unit_kerja_or')
            selectMe__('#pgs_loker_or','loker',['#pgs_divisi_or','#pgs_unit_bisnis_or','#pgs_unit_kerja_or','#pgs_jabatan_or'])
            selectUser("#user_search")
            if(title=='Edit'){
                var data = button.data('data');
                var data_other = button.data('other');
                var data_other_pegawai = data_other.pegawai;
                var data_other_atasan = data_other.atasan;
                var data_other_approver = data_other.approver;
                var role = data.roles;
                // data = JSON.parse(data);
                var user_search = modal.find('.modal-body #user_search');
                user_search.find('option').remove();
                var newOption = new Option(data_other_pegawai.v_nama_karyawan+' - '+data_other_pegawai.n_nik, data_other_pegawai.id, false, true);
                user_search.append(newOption);
                user_search.val(data_other_pegawai.id).change();
                
                modal.find('.modal-body input#id_edit').val(data.id)
                modal.find('.modal-body #name').text(data.name)
                modal.find('.modal-body #username').text(data.username)
                modal.find('.modal-body #email').text(data.email)
                modal.find('.modal-body #divisi').text(data_other_pegawai.divisi)
                modal.find('.modal-body #unit_bisnis').text(data_other_pegawai.unit_bisnis)
                modal.find('.modal-body #unit_kerja').text(data_other_pegawai.unit_kerja)
                modal.find('.modal-body #jabatan').text(data_other_pegawai.v_short_posisi)
                modal.find('.modal-body input#phone').val(data.phone)
                modal.find('.modal-body select#roles').val(role[0].id)
                modal.find('.modal-body select#user_type').val(data.user_type)
                reset_select2('pgs_divisi_or')
                reset_select2('pgs_jabatan_or')
                reset_select2('pgs_unit_bisnis_or')
                reset_select2('pgs_unit_kerja_or')
                reset_select2('pgs_loker_or')
                if(data_other.is_pgs){
                  var data_pgs = data_other.pgs;
                  var data_pgs2 = data_other.pgs_2;
                  modal.find('.modal-body select#roles').val(data_pgs2.role_id)
                  modal.find('.modal-body select#user_pgs').val('yes');
                  modal.find('.modal-body select#user_pgs').change();
                  set_select2(modal.find('.modal-body select#pgs_divisi_or'),{id:data_pgs.divisi,text:data_pgs.divisi});
                  set_select2(modal.find('.modal-body select#pgs_jabatan_or'),{id:data_pgs.objidposisi,text:data_pgs.v_short_posisi});
                  set_select2(modal.find('.modal-body select#pgs_unit_bisnis_or'),{id:data_pgs.unit_bisnis,text:data_pgs.unit_bisnis});
                  set_select2(modal.find('.modal-body select#pgs_unit_kerja_or'),{id:data_pgs.unit_kerja,text:data_pgs.unit_kerja});
                  set_select2(modal.find('.modal-body select#pgs_loker_or'),{id:data_pgs.objidunit,text:data_pgs.v_short_unit});
                  modal.find('.modal-body select#pgs_roles_or').val(data_pgs.role_id)
                  
                  
                  
                }
                else{
                  modal.find('.modal-body select#user_pgs').val('no');
                  modal.find('.modal-body select#user_pgs').change();
                }
                modal.find('.modal-body select#user_type').val(data.user_type)
                modal.find('.modal-body input#divisi').val(data_other_pegawai.v_short_divisi)
                modal.find('.modal-body input#loker').val(data_other_pegawai.v_short_unit)
                modal.find('.modal-body input#jabatan').val(data_other_pegawai.v_short_posisi)
                selectUser("#or_user_atasan",data_other_pegawai.objiddivisi,data_other_pegawai.v_band_posisi)
                // modal.find('.content-add').html('')
                if(data_other_atasan.length>0){
                  set_content('or_user_atasan','atasan',data_other_atasan,'or_atasan');
                }
                else{
                  modal.find('.table-atasan').hide().find('table>tbody').html('')
                }
                // if(data_other_approver.length>0){
                //   set_content('or_user_approver','approver',data_other_atasan,'or_approver');
                // }
                // else{
                //   modal.find('.table-approver').hide().find('table>tbody').html('')
                // }
                modal.find('.modal-body .ready-select').show()
                modal.find('form').attr('action','{!! route('users.update') !!}')
            }
            else{
                selectUser("#or_user_atasan")
                modal.find('.modal-body input#id').val('')
                modal.find('.modal-body #name').text('')
                modal.find('.modal-body #username').text('')
                modal.find('.modal-body #email').text('')
                modal.find('.modal-body input#phone').text('')
                modal.find('.modal-body #divisi').text('')
                modal.find('.modal-body #unit_bisnis').text('')
                modal.find('.modal-body #unit_kerja').text('')
                modal.find('.modal-body #jabatan').text('')
                modal.find('.modal-body .ready-select').hide()
                
                modal.find('.modal-body select#roles').val('')
                modal.find('.modal-body select#user_pgs').val('no')
                modal.find('.modal-body select#pgs_roles').val('')
                modal.find('.modal-body select#user_type').val('ubis')
                
                modal.find('.table-atasan').hide().find('table>tbody').html('')
                reset_select2('pgs_divisi_or')
                reset_select2('pgs_jabatan_or')
                reset_select2('pgs_unit_bisnis_or')
                reset_select2('pgs_unit_kerja_or')
                reset_select2('pgs_loker_or')
                reset_select2('user_search')
                modal.find('.modal-body select#pgs_roles_or').val('')
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
            var formError = formMe.find(".formerror")
            formError.removeClass("has-error")
            formMe.find(".error").html('')
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
                      $.each(_response.errors, function(index, value){
                          if (value.length !== 0){
                            index = index.replace(".", "-");
                            formMe.find(".formerror-"+ index).removeClass("has-error");
                            formMe.find(".error-"+ index).html('');

                            formMe.find(".formerror-"+ index).addClass("has-error");
                            formMe.find(".error-"+ index).html('<span class="help-block">'+ value +'</span>');
                          }
                      });
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
                    alertBS('Something wrong, please try again','danger')
                    modalDelete.modal('hide')
                    btnDelete.attr('data-id','');
                }
            });
        })
        $(document).on('select2:select', '#user_search', function(event) {
          event.preventDefault();
          /* Act on the event */
          var data = event.params.data;
          // console.log(data);
          formModal.find('#name').text(data.v_nama_karyawan);
          formModal.find('#username').text(data.n_nik);
          formModal.find('#divisi').text(data.divisi);
          formModal.find('#unit_kerja').text(data.unit_kerja);
          formModal.find('#unit_bisnis').text(data.unit_bisnis);
          formModal.find('#jabatan').text(data.v_short_posisi);
          formModal.find('#password').val('{!!config('app.password_default')!!}').parent().find('.info-default').remove();
          formModal.find('#password').after('<span class="text-info info-default">Default password {!!config('app.password_default')!!}')
          formModal.find('#password_confirmation').val('{!!config('app.password_default')!!}');
          formModal.find('#email').text(data.n_nik+'@telkom.co.id');
          formModal.find('.table-or_atasan').find('table>tbody').html('');
          formModal.find('.table-or_atasan').hide();
          formModal.find('.content-atasan').show();
          // formModal.find('.table-approver').find('table>tbody').html('');
          // formModal.find('.table-approver').hide();
          formModal.find('.content-approver').show();
          formModal.find('.ready-select').show();
          selectUser("#or_user_atasan",data.objiddivisi,data.v_band_posisi)
          selectUser("#or_user_approver")
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
      var urlnya = '{!! route('users.get-select-user-telkom') !!}';
      var others = '';
      if(attr == '#subsidiary_user_atasan'){
        urlnya = '{!! route('users.get-select-user-subsidiary') !!}';
        others = divisi;
      }
      $(attr).select2().select2({
          placeholder : "Pilih PIC....",
          dropdownParent: $(attr).parent(),
          ajax: {
              url: urlnya,
              dataType: 'json',
              delay: 350,
              data: function (params) {
                  var datas =  {
                      q: params.term, // search term
                      page: params.page,
                      subsidiary_id:others
                  };
                  console.log(divisi+v_band_posisi);
                  // if(divisi!==undefined && v_band_posisi!==undefined){
                  //   var datas =  {
                  //       q: params.term, // search term
                  //       page: params.page,
                  //       type:divisi,
                  //       posisi:v_band_posisi
                  //   };
                  // }
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
        if(data.v_nama_karyawan === undefined || data.v_nama_karyawan === "" || data.n_nik === undefined || data.n_nik === ""){
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
    function set_content(attr,type,data,attr_table){
        $(this).val('');
        $('#select2-'+attr+'-container').html('');
        var $this = $('.table-'+attr_table);
        $this.show();
        $this.find('table>tbody>tr').remove();
        $.each(data,function(index, el) {
          var row = $this.find('table>tbody>tr');
          if(type=='approver'){
            var new_row = $(templateApprover(this)).clone();
          }
          else {
            var new_row = $(templateAtasan(this)).clone();
          }
          var mdf_new_row = new_row.find('td');
          mdf_new_row.eq(0).html(row.length+1);
          mdf_new_row.eq(1).find('input').val(this.nik);
          mdf_new_row.eq(2).text(this.name);
          mdf_new_row.eq(3).text(this.email);
          mdf_new_row.eq(4).text(this.jabatan);
          $this.find('table>tbody').append(new_row);
        });
    }
    function set_select2(attr_obj,data) {
      attr_obj.find('option').remove();
      var newOption = new Option(data.text, data.id, false, true);
      attr_obj.append(newOption);
      attr_obj.val(data.id).change();
      var id_name = attr_obj.attr('id');
      // console.log(id_name);
      // $('#select2-'+id_name+'-container').html(data.text);
      
    }
    function reset_error(){
      $('[class*=error-]').find('span').remove();
      $('.form-group.has-error').removeClass('has-error');
    }
</script>
@endpush
