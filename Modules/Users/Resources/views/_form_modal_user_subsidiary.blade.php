 <div class="modal fade" role="dialog" id="form-modal-subsidiary">
    <div class="modal-dialog modal-lg" role="document" style="position:relative;">
      <div class="loading-modal"></div>
        <div class="modal-content">
            <form id="form-subsidiary" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit User Subsidiary</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group subsidiary_oke">
                      <label>Pilih Subsidiary Telkom</label>
                      <select class="form-control" style="width: 100%;" name="subsidiary_telkom" id="subsidiary_telkom">
                          <option value="">Pilih Subsidiary Telkom</option>
                      </select>
                      <div class="error-subsidiary_telkom"></div>
                  </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <input type="hidden" id="id" name="id" />
                        <label>Name</label>
                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-name"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Username</label>
                        <input type="text" id="username" name="username" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-username"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Email</label>
                        <input type="text" id="email" name="email" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-email"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Phone</label>
                        <input type="text" id="phone" name="phone" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-phone"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Divisi</label>
                        <input type="text" id="divisi" name="divisi" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-divisi"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Unit / Loker</label>
                        <input type="text" id="unit" name="unit" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-unit"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-jabatan"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Password</label>
                        <input type="password" id="password" name="password" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-password"></div>
                    </div>
                    <div class="form-group">
                        <div class="error-global"></div>
                        <label>Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control" placeholder="Enter ..."  autocomplete="off">
                        <div class="error-password_confirmation"></div>
                    </div>
                    <div class="form-group">
                      <label>Pilih Penandatangan Kontrak</label>
                      <select class="form-control select-user-atasan" style="width: 100%;" name="subsidiary_user_atasan" id="subsidiary_user_atasan" data-action="subsidiary_atasan">
                          <option value="">Pilih Penandatangan Kontrak</option>
                      </select>
                      <div class="error-subsidiary_user_atasan"></div>
                    </div>
                    <div class="table-subsidiary_atasan table-responsive" style="display:none;">
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
        var formModal = $('#form-modal-subsidiary');
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
            modal.find('.modal-title').text(title+' User Subsidiary')
            selectSubsidiary('#subsidiary_telkom');
            if(title=='Edit'){
                var data = button.data('data');
                var data_other = button.data('other');
                var role = data.roles;
                var data_other_atasan = data_other.atasan;
                var data_other_pegawai = data_other.pegawai;
                var data_other_subsidiary = data_other.subsidiary;
                // data = JSON.parse(data);
                // console.log(data);
                
                var subsidiary = modal.find('.modal-body #subsidiary_telkom');
                subsidiary.find('option').remove();
                var newOption = new Option(data_other_subsidiary.name, data_other_subsidiary.id, false, true);
                subsidiary.append(newOption);
                subsidiary.val(data_other_subsidiary.id).change();
                
                modal.find('.modal-body input#id').val(data.id)
                modal.find('.modal-body input#name').val(data.name)
                modal.find('.modal-body input#username').val(data.username)
                modal.find('.modal-body input#email').val(data.email)
                modal.find('.modal-body input#phone').val(data.phone)
                modal.find('.modal-body select#roles').val(role[0].id)
                modal.find('.modal-body input#password_confirmation').parent().hide()
                modal.find('.modal-body input#password').parent().hide()
                modal.find('.modal-body input#divisi').val(data_other_pegawai.v_short_divisi)
                modal.find('.modal-body input#unit').val(data_other_pegawai.v_short_unit)
                modal.find('.modal-body input#jabatan').val(data_other_pegawai.v_short_posisi)
                if(data_other_atasan.length>0){
                  set_content('subsidiary_user_atasan','atasan',data_other_atasan,'subsidiary_atasan');
                }
                else{
                  modal.find('.table-subsidiary_atasan').hide().find('table>tbody').html('')
                }
                modal.find('.content-atasan').html('')
                modal.find('form').attr('action','{!! route('users.update-subsidiary') !!}')
            }
            else{
                modal.find('.modal-body input#id').val('')
                modal.find('.modal-body input#name').val('')
                modal.find('.modal-body input#username').val('')
                modal.find('.modal-body input#email').val('')
                modal.find('.modal-body input#phone').val('')
                modal.find('.modal-body select#roles').val('')
                modal.find('.modal-body input#password_confirmation').val('').parent().show()
                modal.find('.modal-body input#password').val('').parent().show()
                modal.find('.modal-body input#divisi').val('')
                modal.find('.modal-body input#unit').val('')
                modal.find('.modal-body input#jabatan').val('')
                modal.find('.table-subsidiary_atasan').hide().find('table>tbody').html('')
                reset_select2('subsidiary_telkom')
                selectSubsidiary('#subsidiary_telkom')
                modal.find('form').attr('action','{!! route('users.add-subsidiary') !!}')
            }
            selectUser("#subsidiary_user_atasan",modal.find('.modal-body #subsidiary_telkom').val());
        })
        $(document).on('submit','#form-subsidiary',function (event) {
            event.preventDefault();
            var modal = $('#form-modal-subsidiary');
            var loading = modal.find('.loading-modal');
            loading.show();
            var formMe = $(this)
            var attError = {
                    name     : formMe.find('.error-name'),
                    username : formMe.find('.error-username'),
                    phone    : formMe.find('.error-phone'),
                    email    : formMe.find('.error-email'),
                    password : formMe.find('.error-password'),
                    jabatan : formMe.find('.error-jabatan'),
                    divisi : formMe.find('.error-divisi'),
                    unit : formMe.find('.error-unit'),
                    password_confirmation : formMe.find('.error-password_confirmation'),
                    roles    : formMe.find('.error-roles'),
                    subsidiary_telkom    : formMe.find('.error-subsidiary_telkom'),
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
              attError.divisi.html('')
              attError.divisi.parent().removeClass('has-error')
              attError.unit.html('')
              attError.unit.parent().removeClass('has-error')
              attError.jabatan.html('')
              attError.jabatan.parent().removeClass('has-error')
              attError.subsidiary_telkom.html('')
              attError.subsidiary_telkom.parent().removeClass('has-error')
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
                        if(_response.errors.password_confirmation){
                            attError.password_confirmation.html('<span class="text-danger">'+_response.errors.password_confirmation+'</span>');
                            attError.password_confirmation.parent().addClass('has-error')
                        }
                        if(_response.errors.roles){
                            attError.roles.html('<span class="text-danger">'+_response.errors.roles+'</span>');
                            attError.roles.parent().addClass('has-error')
                        }
                        if(_response.errors.divisi){
                            attError.divisi.html('<span class="text-danger">'+_response.errors.divisi+'</span>');
                            attError.divisi.parent().addClass('has-error')
                        }
                        if(_response.errors.unit){
                            attError.unit.html('<span class="text-danger">'+_response.errors.unit+'</span>');
                            attError.unit.parent().addClass('has-error')
                        }
                        if(_response.errors.jabatan){
                            attError.jabatan.html('<span class="text-danger">'+_response.errors.jabatan+'</span>');
                            attError.jabatan.parent().addClass('has-error')
                        }
                        if(_response.errors.subsidiary_telkom){
                            attError.subsidiary_telkom.html('<span class="text-danger">'+_response.errors.subsidiary_telkom+'</span>');
                            attError.subsidiary_telkom.parent().addClass('has-error')
                        }
                        modal.scrollTop(0);
                    }
                    else{
                        $('#form-modal-subsidiary').modal('hide')
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
                    $('#form-modal-subsidiary').modal('hide')
                    alertBS('Something wrong, please try again','danger')
                    loading.hide()
                }
            });
        })
    });
    onSelect2('subsidiary_user_atasan','atasan');
    function selectSubsidiary(attr) {
      var urlnya = '{!! route('users.subsidiary-telkom.get-select') !!}';
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
                      page: params.page
                  };
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
                      o.id = v.id;
                      o.name = v.name;
                      o.value = v.id;
                      o.address = v.address;
                      o.phone = v.phone;
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
          templateResult: aoTempResultSub ,
          templateSelection: aoTempSelectSub
      });
    }
    function aoTempResultSub(state) {
        if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ;  }
        var $state = $(
            '<span>' +  state.name +'</span>'
        );
        return $state;
    }
    function aoTempSelectSub(data){
        if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
            return ;
        }
        if(data.address === undefined || data.address === ""){
          return data.text;
        }
        return data.name ;
    }
    $(document).on('select2:select', '#subsidiary_telkom', function(e) {
        e.preventDefault();
        var data = e.params.data;
        $('.table-subsidiary_atasan').hide().find('table>tbody').html('')
        selectUser("#subsidiary_user_atasan",data.id);
    });
</script>
@endpush
