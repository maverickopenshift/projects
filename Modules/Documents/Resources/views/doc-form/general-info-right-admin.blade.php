<div class="form-group formerror  formerror-user_id">
  <label class="col-sm-2 control-label">Konseptor </label>
  <div class="col-sm-6">
    <input type="hidden" class="select-user-konseptor-text" name="konseptor_text" value="{{old('konseptor_text',Helper::prop_exists($doc,'konseptor_text'))}}">
    <select class="form-control select-user-konseptor" style="width: 100%;" name="user_id"  data-id="{{Helper::old_prop($doc,'user_id')}}">
    </select>
  </div>
  <div class="col-sm-10 col-sm-offset-2">
    <div class="error error-doc_enddate"></div>
  </div>
</div>
@push('scripts')
<script>
var a_divisi,a_loker,a_jabatan,a_approver,a_pihak1,a_pihak1_val,a_parent_doc1,a_parent_doc2,a_parent_doc='';
  $(function() {
    a_divisi = $('input[name="divisi"]');
    a_loker = $('input[name="loker"]');
    a_jabatan = $('input[name="jabatan"]');
    a_approver = $('textarea[name="approver"]');
    a_pihak1 = $('select[name="doc_pihak1_nama"]');
    a_pihak1_val = a_pihak1.data('val');
    a_divisi.val('');
    a_loker.val('');
    a_jabatan.val('');
    a_approver.val('');
    a_pihak1.find('option').not('option[value=""]').remove();
    var selectUserKonseptor = $(".select-user-konseptor").select2({
        placeholder : "Pilih Konseptor",
        ajax: {
            url: '{!! route('users.get-select-konseptor') !!}',
            dataType: 'json',
            delay: 350,
            data: function (params) {
              var a_parent_doc1 = $('.select-kontrak');
              var a_parent_doc2 = $('.select-sp');
              var a_parent_doc = '';
              if(a_parent_doc1.val()!==undefined){
                a_parent_doc = a_parent_doc1.val();
              }
              if(a_parent_doc2.val()!==undefined){
                a_parent_doc = a_parent_doc2.val();
              }
                return {
                    q: params.term, // search term
                    parent:a_parent_doc,
                    page: params.page
                };
            },
            //id: function(data){ return data.store_id; },
            processResults: function (data, params) {
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
        templateResult: templateResultKonseptor,
        templateSelection: templateSelectionKonseptor
    });
    function templateResultKonseptor(state) {
      if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ; }
      var $state = $(
          '<span>'+state.name +' <i>('+  state.nik + ')</i></span>'
      );
      return $state;
    }
    function templateSelectionKonseptor(data) {
      if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
          return "Pilih Konseptor....";
      }
      var render = data.name +' - '+  data.nik ;
      if(data.name === undefined){
        render = $('.select-user-konseptor :selected').text();
      }
      $('.select-user-konseptor-text').val(render);
      return render ;
    }
    var user_konseptor = $(".select-user-konseptor");
    if(user_konseptor.data('id')!==""){
      var newOption = new Option($(".select-user-konseptor-text").val(), user_konseptor.data('id'), false, true);
      user_konseptor.append(newOption);
      user_konseptor.val(user_konseptor.data('id')).change();
      console.log(a_pihak1_val);
      $.ajax({
        url: '{!! route('users.get-select-konseptor') !!}',
        type: 'GET',
        dataType: 'json',
        data: {id: user_konseptor.val(),parent : a_parent_doc}
      })
      .done(function(data) {
        set_content_admin(data);
      });
      
    }
    $(document).on('select2:select', '.select-user-konseptor', function(e) {
        e.preventDefault();
        var data = e.params.data;
        set_content_admin(data);
    });
  });
  function set_content_admin(data){
    a_divisi.val(data.divisi_name);
    a_loker.val(data.unit_name);
    a_jabatan.val(data.posisi_name);
    a_approver.val(data.approver);
    var pihak1 = data.pihak1;
    if(pihak1.length>0){
      a_pihak1.find('option').not('option[value=""]').remove();
      $.each(pihak1,function(index, el) {
        var selected = '';
        if(parseInt(a_pihak1_val)==parseInt(this.n_nik)){
          selected = 'selected="selected"';
        }
        a_pihak1.append('<option value="'+this.n_nik+'" '+selected+'>'+this.v_nama_karyawan+' - '+this.v_short_posisi+'</option>');
      });
    }
  }
  function set_content_reset(){
    a_pihak1_val = null;
    a_divisi.val('');
    a_loker.val('');
    a_jabatan.val('');
    a_approver.val('');
    a_pihak1.find('option').not('option[value=""]').remove();
    $(".select-user-konseptor").val("").change();
  }
</script>
@endpush