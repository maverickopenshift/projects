 <div class="modal fade" role="dialog" id="form-modal-nonorganik">
    <div class="modal-dialog modal-lg" role="document" style="position:relative;">
      <div class="loading-modal"></div>
        <div class="modal-content">
            <form id="form-nonorganik" action="#" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit User Non-Organik</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group formerror formerror-name">
                        <div class="error error-global"></div>
                        <input type="hidden" id="id" name="id" />
                        <label>Name</label>
                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error-name"></div>
                    </div>
                    <div class="form-group formerror formerror-username">
                        <div class="error-global"></div>
                        <label>Username</label>
                        <input type="text" id="username" name="username" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error error-username"></div>
                    </div>
                    <div class="form-group formerror formerror-email">
                        <div class="error-global"></div>
                        <label>Email</label>
                        <input type="text" id="email" name="email" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error error-email"></div>
                    </div>
                    <div class="form-group formerror formerror-phone">
                        <div class="error-global"></div>
                        <label>Phone</label>
                        <input type="text" id="phone" name="phone" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error error-phone"></div>
                    </div>
                    <div class="form-group formerror formerror-user_type">
                      <label>User Type</label>
                      <select class="form-control user_type_non" style="width: 100%;" name="user_type" id="user_type">
                        <option value="ubis">Ubis</option>
                        <option value="witel">Witel</option>
                        {{-- <option value="subsidiary">Subsidiary</option> --}}
                      </select>
                      <div class="error error-user_type"></div>
                    </div>
                    <div class="form-group subsidiary_oke formerror formerror-select_divisi">
                        <label>Pilih Divisi</label>
                        <select class="form-control" style="width: 100%;" name="select_divisi" id="select_divisi">
                            <option value="">Pilih Divisi</option>
                        </select>
                        <div class="error error-select_divisi"></div>
                    </div>
                    <div class="form-group subsidiary_oke formerror formerror-select_unit_bisnis">
                        <label>Pilih Unit Bisnis</label>
                        <select class="form-control" style="width: 100%;" name="select_unit_bisnis" id="select_unit_bisnis">
                            <option value="">Pilih Unit Bisnis</option>
                        </select>
                        <div class="error error-select_unit_bisnis"></div>
                    </div>
                    <div class="form-group subsidiary_oke formerror formerror-select_unit_kerja">
                        <label>Pilih Unit Kerja</label>
                        <select class="form-control" style="width: 100%;" name="select_unit_kerja" id="select_unit_kerja">
                            <option value="">Pilih Unit Kerja</option>
                        </select>
                        <div class="error error-select_unit_kerja"></div>
                    </div>
                    <div class="form-group formerror formerror-select_loker">
                      <label>Pilih Loker</label>
                        <select class="form-control" style="width: 100%;" name="select_loker" id="select_loker">
                            <option value="">Pilih Loker</option>
                        </select>
                        <div class="error error-select_loker"></div>
                    </div>
                    <div class="form-group subsidiary_oke formerror formerror-jabatan">
                        <label>Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" value="" class="form-control" placeholder="Enter Jabatan..." autocomplete="off">
                        <div class="error error-jabatan"></div>
                    </div>
                    <div class="form-group formerror formerror-password">
                        <div class="error-global"></div>
                        <label>Password</label>
                        <input type="password" id="password" name="password" value="" class="form-control" placeholder="Enter ..." autocomplete="off">
                        <div class="error error-password"></div>
                    </div>
                    <div class="form-group formerror formerror-password_confirmation">
                        <div class="error-global"></div>
                        <label>Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control" placeholder="Enter ..."  autocomplete="off">
                        <div class="error error-password_confirmation"></div>
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
                    <div class="form-group formerror formerror-non_user_atasan">
                      <label>Pilih Penandatangan Kontrak</label>
                      <select class="form-control select-user-atasan" style="width: 100%;" name="non_user_atasan" id="non_user_atasan" data-action="non_atasan">
                          <option value="">Pilih Penandatangan Kontrak</option>
                      </select>
                      <div class="error error-non_user_atasan"></div>
                    </div>
                    <div class="table-non_atasan table-responsive" style="display:none;">
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
        var formModal = $('#form-modal-nonorganik');
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
            modal.find('.modal-title').text(title+' User Non-Organik')
            modal.find('.content-password').html('');
            $(this).val('');
            selectUser("#non_user_atasan")
            selectUser("#non_user_approver")
            selectMe__('#select_divisi','divisi')
            selectMe__('#select_unit_bisnis','unit_bisnis','#select_divisi')
            selectMe__('#select_unit_kerja','unit_kerja','#select_unit_bisnis')
            selectMe__('#select_loker','loker','#select_unit_kerja')
            selectMe__('#select_posisi','posisi','#select_unit_kerja')
            $('#select2-pic_search-container').html('');
            if(title=='Edit'){
                var data = button.data('data');
                var data_other = button.data('other');
                var role = data.roles;
                var data_other_atasan = data_other.atasan;
                var data_other_pegawai = data_other.pegawai;
                // data = JSON.parse(data);
                // console.log(data);
                modal.find('.modal-body input#id').val(data.id)
                modal.find('.modal-body input#name').val(data.name)
                modal.find('.modal-body input#username').val(data.username)
                modal.find('.modal-body input#email').val(data.email)
                modal.find('.modal-body input#phone').val(data.phone)
                modal.find('.modal-body select#roles').val(role[0].id)
                modal.find('.modal-body select#user_type').val(data.user_type)
                modal.find('.modal-body input#password_confirmation').parent().hide()
                modal.find('.modal-body input#password').parent().hide()
                reset_select2('select_divisi')
                reset_select2('select_posisi')
                reset_select2('select_unit_kerja')
                reset_select2('select_unit_bisnis')
                reset_select2('select_loker')
                if(data.user_type !== 'subsidiary'){
                  set_select2(modal.find('.modal-body select#select_divisi'),{id:data_other_pegawai.divisi,text:data_other_pegawai.divisi});
                  set_select2(modal.find('.modal-body select#select_posisi'),{id:data_other_pegawai.objidposisi,text:data_other_pegawai.v_short_posisi});
                  set_select2(modal.find('.modal-body select#select_unit_bisnis'),{id:data_other_pegawai.unit_bisnis,text:data_other_pegawai.unit_bisnis});
                  set_select2(modal.find('.modal-body select#select_unit_kerja'),{id:data_other_pegawai.unit_kerja,text:data_other_pegawai.unit_kerja});
                  set_select2(modal.find('.modal-body select#select_loker'),{id:data_other_pegawai.objidunit,text:data_other_pegawai.v_short_unit});
                  modal.find('.modal-body input#jabatan').val(data_other_pegawai.v_short_posisi)
                }
                else{
                  $('.subsidiary_oke').hide();
                }
                if(data_other_atasan.length>0){
                  set_content('non_user_atasan','atasan',data_other_atasan,'non_atasan');
                }
                else{
                  modal.find('.table-non_atasan').hide().find('table>tbody').html('')
                }
                modal.find('.content-atasan').html('')
                modal.find('form').attr('action','{!! route('users.update-nonorganik') !!}')
            }
            else{
                modal.find('.modal-body input#id').val('')
                modal.find('.modal-body input#name').val('')
                modal.find('.modal-body input#username').val('')
                modal.find('.modal-body input#email').val('')
                modal.find('.modal-body input#phone').val('')
                modal.find('.modal-body input#jabatan').val('')
                modal.find('.modal-body select#roles').val('')
                modal.find('.modal-body select#user_pgs').val('no')
                modal.find('.modal-body select#pgs_roles').val('')
                modal.find('.modal-body select#user_type').val('ubis')
                modal.find('.modal-body input#password_confirmation').parent().show()
                modal.find('.modal-body input#password').parent().show()
                modal.find('.content-atasan').hide();
                modal.find('.table-non_atasan').hide().find('table>tbody').html('')
                $('.subsidiary_oke').show();
                reset_select2('select_divisi')
                reset_select2('select_posisi')
                reset_select2('select_unit_bisnis')
                reset_select2('select_unit_kerja')
                reset_select2('select_loker')
                reset_select2('pgs_divisi')
                reset_select2('pgs_jabatan')
                reset_select2('pgs_unit')
                modal.find('.modal-body .table-pgs').hide();
                selectUser("#user_search")
                modal.find('form').attr('action','{!! route('users.addnonorganik') !!}')
            }
        })
        $(document).on('change', '.user_pgs', function(event) {
          event.preventDefault();
          /* Act on the event */
          // $(".pgs_jabatan").val("");
          // $("#select2-select_unit-container").html('');
          if($(this).val()=='yes'){
            $('.table-pgs').show();
          }else{
            $('.table-pgs').hide();
          }

        });
        $(document).on('submit','#form-nonorganik',function (event) {
            event.preventDefault();
            var modal = $('#form-modal-nonorganik');
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
                        $('#form-modal-nonorganik').modal('hide')
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
                    $('#form-modal-nonorganik').modal('hide')
                    alertBS('Something wrong, please try again','danger')
                    loading.hide()
                }
            });
        })
    });
    function selectMe__(attr,type,parent) {

      $(attr).select2().select2({
          dropdownParent: $(attr).parent(),
          ajax: {
              url: '{!! route('users.get-select') !!}',
              dataType: 'json',
              delay: 350,
              data: function (params) {
                  var datas =  {
                      q: params.term, // search term
                      page: params.page
                  };
                  if(type=='divisi'){
                    datas.type = 'divisi';
                    reset_select2('pgs_unit_bisnis_or');
                    reset_select2('pgs_unit_kerja_or');
                    reset_select2('pgs_jabatan_or');
                    reset_select2('pgs_loker_or');
                    reset_select2('select_unit_bisnis');
                    reset_select2('select_unit_kerja');
                    reset_select2('select_jabatan');
                    reset_select2('select_loker');
                  }
                  if(type=='unit_bisnis'){
                    datas.type = 'unit_bisnis';
                    reset_select2('pgs_unit_kerja_or');
                    reset_select2('pgs_jabatan_or');
                    reset_select2('pgs_loker_or');
                    reset_select2('select_unit_kerja');
                    reset_select2('select_jabatan');
                    reset_select2('select_loker');
                    datas.divisi = encodeURI($(parent).val());
                  }
                  if(type=='unit_kerja'){
                    datas.type = 'unit_kerja';
                    reset_select2('pgs_jabatan_or');
                    reset_select2('select_jabatan');
                    reset_select2('pgs_loker_or');
                    reset_select2('select_loker');
                    datas.unit_bisnis = encodeURI($(parent).val());
                  }
                  if(type=='posisi'){
                    datas.type = 'posisi';
                    reset_select2('pgs_loker_or');
                    reset_select2('select_loker');
                    datas.unit_kerja = encodeURI($(parent).val());
                  }
                  if(type=='loker'){
                    datas.type = 'loker';
                    datas.unit_kerja = encodeURI($(parent).val());
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
                      o.id = v.id;
                      o.title = v.title;
                      o.value = v.id;
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
              cache: false
          },
          escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
          minimumInputLength: 0,
          templateResult: aoTempResult__ ,
          templateSelection: aoTempSelect__
      });
    }
    function aoTempResult__(state) {
        if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ;  }
        var $state = $(
            '<span>' +  state.title +'</span>'
        );
        return $state;
    }
    function aoTempSelect__(data){
        if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
            return ;
        }
        if(data.title === undefined || data.title === ""){
          return data.text;
        }
        return data.title;
    }
    $(document).on('select2:select', '#select_divisi', function(e) {
        e.preventDefault();
        var data = e.params.data;
        reset_select2('select_posisi');
        reset_select2('select_unit');
    });
    $(document).on('select2:select', '#select_unit', function(e) {
        e.preventDefault();
        var data = e.params.data;
        reset_select2('select_posisi');
    });
    $(document).on('change', '.user_type_non', function(event) {
      /* Act on the event */
      console.log('oke');
      if($(this).val()=='subsidiary'){
        $('.subsidiary_oke').hide();
      }
      else{
        $('.subsidiary_oke').show();
      }
    });
    $(document).on('select2:select', '#pgs_divisi', function(e) {
        e.preventDefault();
        var data = e.params.data;
        reset_select2('pgs_jabatan');
        reset_select2('pgs_unit');
    });
    $(document).on('select2:select', '#pgs_unit', function(e) {
        e.preventDefault();
        var data = e.params.data;
        reset_select2('pgs_jabatan');
    });
    function reset_select2(attr){
      $('#'+attr).val("");
      $('#select2-'+attr+'-container').html('');
    }
    onSelect2('non_user_approver','approver');
    onSelect2('non_user_atasan','atasan');
    function onSelect2(attr,type){
      $(document).on('select2:select', '#'+attr, function(event) {
        event.preventDefault();
        /* Act on the event */
        var data = event.params.data;
        $(this).val('');
        $('#select2-'+attr+'-container').html('');
        console.log(data);
        var $this = $('.table-'+$(this).data('action'));
        $this.show();
        var row = $this.find('table>tbody>tr');
        if(type=='approver'){
          var new_row = $(templateApprover(data)).clone();
        }
        else {
          var new_row = $(templateAtasan(data)).clone();
        }
        var mdf_new_row = new_row.find('td');
        mdf_new_row.eq(0).html(row.length+1);
        mdf_new_row.eq(1).find('input').val(data.n_nik);
        mdf_new_row.eq(2).text(data.v_nama_karyawan);
        mdf_new_row.eq(3).text(data.n_nik+'@telkom.co.id');
        mdf_new_row.eq(4).text(data.v_short_posisi);
        $this.find('table>tbody').append(new_row);
      });
    }
</script>
@endpush
