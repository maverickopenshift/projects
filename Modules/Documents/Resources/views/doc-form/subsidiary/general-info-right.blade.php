<div class="form-group">
  <label class="col-sm-2 control-label">Konseptor </label>
  <div class="col-sm-6">
    <textarea class="form-control" name="konseptor" disabled="disabled">{{$pegawai->v_nama_karyawan.'/'.$pegawai->n_nik.' - '.$pegawai->v_short_posisi.' '.$pegawai->v_short_unit.'/'.$pegawai->v_short_divisi}}
    </textarea>
  </div>
</div>
<div class="form-group formerror formerror-doc_pihak1">
  <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Pihak I</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" name="doc_pihak1" id="pihak1" value="{{old('doc_pihak1',Helper::prop_exists($doc,'doc_pihak1'))}}" autocomplete="off" readonly>
  </div>
  <div class="col-sm-10 col-sm-offset-2">
    <div class="error error-doc_pihak1"></div>
  </div>
</div>
<div class="form-group formerror formerror-doc_pihak1_nama">
  <label class="col-sm-2 control-label"><span class="text-red">*</span>Penandatangan Pihak I</label>
  <div class="col-sm-6">
    {!!Helper::select_atasan($pegawai,old('doc_pihak1_nama',Helper::prop_exists($doc,'doc_pihak1_nama')))!!}
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