<div class="modal fade" role="dialog" id="form-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="form-me" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit User</h4>
                </div>
                <div class="modal-body">
                    <div class="content-add">
                    </div>
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
                        <input type="text" id="phone" name="phone" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-phone"></div>
                    </div>
                    <div class="content-password"></div>
                    <div class="content-atasan"></div>
                    <div class="table-atasan table-responsive" style="display:none;">
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
    z-index:10050 !important;
  }
  </style>
@endpush
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
            $(this).val('');
            $('#select2-pic_search-container').html('');
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
                modal.find('.content-add').html('')
                modal.find('.content-atasan').html('')
                modal.find('.table-atasan').hide().find('table>tbody').html('')
                modal.find('form').attr('action','{!! route('users.update') !!}')
            }
            else{
                modal.find('.modal-body input#id').val('')
                modal.find('.modal-body input#name').val('')
                modal.find('.modal-body input#username').val('')
                modal.find('.modal-body input#email').val('')
                modal.find('.modal-body input#phone').val('')
                // modal.find('.modal-footer').find('.btn-reset').remove()
                // modal.find('.modal-footer').append('<button type="reset" class="btn btn-danger btn-reset">Reset</button>')
                modal.find('.content-password').html(content_password())
                modal.find('.content-add').html(contentAdd())
                modal.find('.content-atasan').html(contentAtasan())
                modal.find('.content-atasan').hide();
                modal.find('.table-atasan').hide().find('table>tbody').html('')
                selectUser("#user_search")
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
              //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
              minimumInputLength: 0,
              templateResult: aoTempResult ,
              templateSelection: aoTempSelect
          });
        }
        function aoTempResult(state) {
            if (state.id === undefined || state.id === "") { return ; }
            var $state = $(
                '<span>' +  state.v_nama_karyawan +' <i>('+  state.n_nik + ')</i></span>'
            );
            return $state;
        }
        function aoTempSelect(data){
            if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
                return;
            }
            return data.v_nama_karyawan +' - '+  data.n_nik ;
        }
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
        $(document).on('select2:select', '#user_atasan', function(event) {
          event.preventDefault();
          /* Act on the event */
          var data = event.params.data;
          $(this).val('');
          $('#select2-user_atasan-container').html('');
          console.log(data);
          var $this = $('.table-atasan');
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
          var tbl_t = $(this).parent().parent();
          $(this).parent().parent().remove();
          var $this = $('.table-atasan');
          var row = $this.find('table>tbody>tr');
          if(row.length==0){
            //mdf.html('');
            $this.hide();
          }
        });
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
    function contentAdd() {
      return '<div class="form-group">\
                  <div class="error-global"></div>\
                  <label>Pilih Pegawai</label>\
                  <select class="form-control select-user-telkom" style="width: 100%;" name="user_search" id="user_search">\
                      <option value="">Pilih Pegawai</option>\
                  </select>\
                </div>\
                <div class="form-group">\
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
    function contentAtasan() {
      return '<div class="form-group">\
                  <label>Pilih Atasan</label>\
                  <select class="form-control select-user-atasan" style="width: 100%;" name="user_atasan" id="user_atasan">\
                      <option value="">Pilih Atasan</option>\
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
</script>
@endpush
