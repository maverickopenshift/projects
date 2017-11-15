<div class="modal fade" role="dialog" id="form-modal-edit">
    <div class="modal-dialog modal-lg" role="document" style="position:relative;">
      <div class="loading-modal" style="background-image: url(images/loader.gif);background-color: rgba(255,255,255,0.6);position: absolute;width: 100%;height: 100%;z-index: 1;background-repeat: no-repeat;background-position: center center;"></div>
        <div class="modal-content">
            <form id="form-me-edit" action="#" method="post">
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
                    <div class="content-edit"></div>
                    <div class="content-atasan"></div>
                    <div class="table-atasan-edit table-responsive" style="display:none;">
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
                    <div class="error-roles"></div>
                      @foreach ($roles as $role)
                        <div class="form-group">
                          <div class="checkbox">
                            <label>
                              <input id="roles_edit{{$role->id}}" class="check-me" type="checkbox" name="roles_edit[]" value="{{$role->id}}"> {{$role->display_name}}
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
      var formModalEdit = $('#form-modal-edit');
      // var titleForm = button.data('title');
      // if(titleForm=='Edit'){
      //   alert("hai");
      // }
      formModalEdit.on('show.bs.modal', function (event) {
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
          var data = button.data('data');
          var role = data.roles;
          if(role.length>0){
            $.each(role, function( index, p ) {
              $('#roles_edit'+p.id).iCheck('check');
            });
          }
          var a_id = modal.find('.modal-body input#id');
          var a_name = modal.find('.modal-body input#name');
          var a_username = modal.find('.modal-body input#username');
          var a_email = modal.find('.modal-body input#email');
          var a_phone = modal.find('.modal-body input#phone');
          // data = JSON.parse(data);
           //console.log(JSON.stringify(data));
          a_id.val(data.id)
          a_name.val(data.name)
          a_username.val(data.username)
          a_email.val(data.email)
          a_phone.val(data.phone)
          modal.find('.content-edit').html('')
          modal.find('.content-atasan').html('')
          modal.find('.table-atasan-edit').hide().find('table>tbody').html('')
          $('.table-atasan').hide().find('table>tbody').html('')
          a_id.removeAttr('readonly');
          a_name.removeAttr('readonly');
          a_username.removeAttr('readonly');
          a_email.removeAttr('readonly');
          a_phone.removeAttr('readonly');
          modal.find('form').attr('action','{!! route('users.update') !!}');
          modal.find('.loading-modal').show();
          $.ajax({
            url: '{!!route('users.get-atasan-by-userid')!!}',
            type: 'GET',
            dataType: 'JSON',
            data: {id: data.id}
          })
          .done(function(data) {
            //console.log(JSON.stringify(data));
            if(data.is_pegawai){
              a_id.attr('readonly','readonly');
              a_name.attr('readonly','readonly');
              a_username.attr('readonly','readonly');
              a_email.attr('readonly','readonly');
              a_phone.attr('readonly','readonly');
              modal.find('.content-edit').html(contentEdit())
              $('#user_atasan').remove();
              modal.find('.content-atasan').html(contentAtasan('atasan-edit'))
              modal.find('#divisi').val(data.pegawai.v_short_divisi);
              modal.find('#loker').val(data.pegawai.v_short_unit);
              modal.find('#jabatan').val(data.pegawai.v_short_posisi);
              selectUser("#user_atasan",data.pegawai.objiddivisi,data.pegawai.v_band_posisi)
              var atasan=data.atasan;
              if(atasan.length>0){
                var $this = modal.find('.table-atasan-edit');
                $this.show();
                $.each(atasan,function(index, el) {
                  var new_row = $(templateAtasan(this)).clone();
                  var mdf_new_row = new_row.find('td');
                  mdf_new_row.eq(0).html(index+1);
                  mdf_new_row.eq(1).find('input').val(this.nik);
                  mdf_new_row.eq(2).text(this.name);
                  mdf_new_row.eq(3).text(this.email);
                  mdf_new_row.eq(4).text(this.jabatan);
                  $this.find('table>tbody').append(new_row);
                });
              }
            }
            modal.find('.loading-modal').hide();
          });
      })
    });
    $(document).on('submit','#form-me-edit',function (event) {
        event.preventDefault();
        var formMe = $(this)
        var modal = formMe.parent().parent().parent();
        modal.find('.loading-modal').show();
        var attError = {
                name     : formMe.find('.error-display_name'),
                username : formMe.find('.error-username'),
                phone    : formMe.find('.error-phone'),
                email    : formMe.find('.error-email'),
                password : formMe.find('.error-password'),
                roles : formMe.find('.error-roles'),
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
                    if(_response.errors.roles_edit){
                        attError.roles_edit.html('<span class="text-danger">'+_response.errors.roles_edit+'</span>');
                        //attError.roles.parent().addClass('has-error')
                    }
                }
                else{
                    modal.modal('hide')
                    alertBS('Data successfully updated','success')
                    var table = $('#datatables').dataTable();
                        table.fnStandingRedraw();
                }
                modal.find('.loading-modal').hide();
                btnSave.button('reset')
            },
            error: function( _response ){
                // Handle error
                btnSave.button('reset')
                modal.modal('hide')
                alertBS('Something wrong, please try again','danger')
            }
        });
    })
</script>
@endpush
