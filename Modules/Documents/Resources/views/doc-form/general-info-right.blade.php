@if($user_type=='subsidiary')
  @include('documents::doc-form.subsidiary.general-info-right')
@else
@role('admin')
  @include('documents::doc-form.general-info-right-admin')
@endrole
<div class="form-group">
  <label class="col-sm-2 control-label">Konseptor </label>
  {{-- <div class="col-sm-6 text-me text-uppercase">{{$pegawai->v_nama_karyawan.'/'.$pegawai->n_nik.' - '.$pegawai->v_short_posisi.' '.$pegawai->v_short_unit.'/'.$pegawai->v_short_divisi}}
  </div> --}}
  <div class="col-sm-6 text-me text-uppercase">{{$pegawai->v_nama_karyawan}} <i>({{$pegawai->n_nik}})</i> - {{$pegawai->v_short_posisi}}
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Divisi </label>
  <div class="col-sm-6 text-me text-uppercase">{{$pegawai->divisi}}</div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Unit Bisnis</label>
    <div class="col-sm-6 text-me text-uppercase">{{$pegawai->unit_bisnis}}</div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Unit Kerja</label>
    <div class="col-sm-6 text-me text-uppercase">{{$pegawai->unit_kerja}}</div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Approver</label>
  <div class="col-sm-6 text-me text-uppercase">{!!Helper::get_approver($pegawai)!!}
  </div>
</div>
<div class="form-group formerror formerror-divisi formerror-unit_bisnis">
  <label for="pemilik_kontrak" class="col-sm-2 control-label"><span class="text-red">*</span>Pemilik Kontrak</label>
  <div class="col-sm-6">
    <div class="form-group">
      <div class="col-sm-8">
        {!!Helper::select_all_divisi('divisi',$pegawai->divisi)!!}
        <div class="error error-divisi" style="margin-bottom:10px"></div>
        {!!Helper::select_unit_bisnis('unit_bisnis',$pegawai->unit_bisnis,$pegawai->divisi)!!}
        <div class="error error-unit_bisnis" style="margin-bottom:10px"></div>
        {!!Helper::select_unit_kerja('unit_kerja',$pegawai->unit_kerja,$pegawai->unit_bisnis)!!}
        <div class="error error-unit_kerja" style="margin-bottom:10px"></div>
      </div>
      <div class="col-sm-6">
          
      </div>
    </div>
  </div>
</div>
<div class="form-group formerror formerror-doc_pihak1">
  <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak I</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" name="doc_pihak1" id="pihak1" value="{{old('doc_pihak1',Helper::prop_exists($doc,'doc_pihak1'))}}" autocomplete="off">
  </div>
  <div class="col-sm-10 col-sm-offset-2">
    <div class="error error-doc_pihak1"></div>
  </div>
</div>

<div class="form-group formerror formerror-doc_pihak1_nama">
  <label class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak I</label>
  <div class="col-sm-6">
    @if(Laratrust::hasRole('admin'))
      <select class="form-control" id="doc_pihak1_nama" name="doc_pihak1_nama" data-val='{{old('doc_pihak1_nama',Helper::prop_exists($doc,'doc_pihak1_nama'))}}'>
        <option value="">Pilih Penandatangan Pihak 1</option>
      </select>
    @else
    {!!Helper::select_atasan($pegawai,old('doc_pihak1_nama',Helper::prop_exists($doc,'doc_pihak1_nama')))!!}
    @endif
  </div>
  <div class="col-sm-10 col-sm-offset-2">
    <div class="error error-doc_pihak1_nama"></div>
  </div>
</div>

<div class="form-group formerror formerror-supplier_id">
  <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak II</label>
  <div class="col-sm-6">

    @if(in_array($doc_type->name,['turnkey','khs','surat_pengikatan','mou']))
      <input type="hidden" class="select-user-vendor-text" name="supplier_text" value="{{old('supplier_text',Helper::prop_exists($doc,'supplier_text'))}}">
      <select class="form-control select-user-vendor" style="width: 100%;" name="supplier_id"  data-id="{{Helper::old_prop($doc,'supplier_id')}}">
          <option value="">Pilih Pihak II</option>
      </select>
    @else
      <input type="text" class="form-control" id="nama_supplier" disabled>
    @endif

  </div>
  <div class="col-sm-10 col-sm-offset-2">
    <div class="error error-supplier_id"></div>
  </div>
</div>

<div class="form-group formerror formerror-doc_pihak2_nama">
  <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak II</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" name="doc_pihak2_nama"  value="{{old('doc_pihak2_nama',Helper::prop_exists($doc,'doc_pihak2_nama'))}}"  placeholder="Masukan Nama Penandatanganan Pihak II" autocomplete="off">
  </div>
  <div class="col-sm-10 col-sm-offset-2">
    <div class="error error-doc_pihak2_nama"></div>
  </div>
</div>
@push('scripts')
  <script>
  $(document).on('change', '#divisi', function(event) {
    event.preventDefault();
    /* Act on the event */
    var divisi = this.value;
    //if(unit!==""){
    $('#unit_bisnis').find('option').not('option[value=""]').remove();
    var t_awal = $('#unit_bisnis').find('option[value=""]').text();
    $('#unit_bisnis').find('option[value=""]').text('Please wait.....');
    $('#unit_kerja').find('option').not('option[value=""]').remove();
      $.ajax({
        url: '{!!route('doc.get-unit-bisnis')!!}',
        type: 'GET',
        dataType: 'json',
        data: {divisi: encodeURIComponent(divisi)}
      })
      .done(function(data) {
        if(data.length>0){
          $.each(data,function(index, el) {
            $('#unit_bisnis').append('<option value="'+this.id+'">'+this.title+'</option>');
          });
          $('#unit_bisnis').find('option[value=""]').text('Pilih Unit Bisnis');
        }
        else{
          $('#unit_bisnis').find('option[value=""]').text('Tidak ada data');
        }
      });
    //}
  });
  $(document).on('change', '#unit_bisnis', function(event) {
    event.preventDefault();
    /* Act on the event */
    var unit_bisnis = this.value;
    //if(unit!==""){
    $('#unit_kerja').find('option').not('option[value=""]').remove();
    var t_awal = $('#unit_kerja').find('option[value=""]').text();
    $('#unit_kerja').find('option[value=""]').text('Please wait.....');
      $.ajax({
        url: '{!!route('doc.get-unit-kerja')!!}',
        type: 'GET',
        dataType: 'json',
        data: {unit_bisnis: encodeURIComponent(unit_bisnis)}
      })
      .done(function(data) {
        if(data.length>0){
          $.each(data,function(index, el) {
            $('#unit_kerja').append('<option value="'+this.id+'">'+this.title+'</option>');
          });
          $('#unit_kerja').find('option[value=""]').text('Pilih Unit Kerja');
        }
        else{
          $('#unit_kerja').find('option[value=""]').text('Tidak ada data');
        }
      });
    //}
  });
  // $(function(e){
  //   $('#unit_bisnis').find('option').not('option[value=""]').remove();
  //   if($('#divisi').val()!==""){
  //     $('#divisi').change();
  //   }
  // });
  </script>
@endpush
@endif
