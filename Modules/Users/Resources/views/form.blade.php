@extends('layouts.app')

@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">
          <div class="btn-group" role="group" aria-label="...">
              <a href="{{route('users')}}" class="btn btn-default">
                  <i class="glyphicon glyphicon-th-list"></i> List Users 
              </a>
              @if($type=='organik')
                <a href="{{route('users.form',['type'=>'nonorganik'])}}" class="btn btn-default">
                    <i class="glyphicon glyphicon-plus"></i> Tambah User Non-Organik 
                </a>
              @else
                <a href="{{route('users.form',['type'=>'organik'])}}" class="btn btn-default">
                    <i class="glyphicon glyphicon-plus"></i> Tambah User Organik 
                </a>
              @endif
          </div>
      </h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <form action="{{route('users.store',['type'=>$type])}}" method="post" enctype="multipart/form-data" id="form-user">
      {{ csrf_field() }}
      @if($type=='organik')
        @include('users::form_organik')
      @else
        @include('users::form_nonorganik')
      @endif
      </form>
    </div>
<!-- /.box-body -->
</div>
@endsection
@push('scripts')
<script>
var formModal
$(function() {
  formModal = $('#form-user');
});
function selectUser(attr,title,divisi,v_band_posisi) {
  $(attr).select2({
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
      templateResult: function (state) {
          if (state.id === undefined || state.id === "") { return '<img src="/images/loader.gif" style="width:20px;"/> Searching....' ;  }
          var $state = $(
              '<span>' +  state.v_nama_karyawan +' <i>('+  state.n_nik + ')</i></span>'
          );
          return $state;
      } ,
      templateSelection: function (data){
          if (data.id === undefined || data.id === "") { // adjust for custom placeholder values
              return 'Pilih '+title;
          }
          return data.v_nama_karyawan +' - '+  data.n_nik ;
      }
  });
}
</script>
@endpush
