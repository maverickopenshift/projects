<div class="form-horizontal">
  @include('documents::form-penomoran-otomatis')
  <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
    
    @if(!in_array($doc_type->name,['khs','turnkey','surat_pengikatan','mou']))
      @include('documents::doc-form-edit.no-kontrak')
    @else
      <div class="form-group formerror formerror-doc_title">
        <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Judul {{$doc_type['title']}}</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="doc_title"  value="{{old('doc_title',Helper::prop_exists($doc,'doc_title'))}}"  placeholder="Masukan Judul Kontrak" autocomplete="off">
          <div class="error error-doc_title"></div>
        </div>
      </div>
    @endif

    <div class="form-group formerror formerror-doc_desc">
      <label for="deskripsi_kontrak" class="col-sm-2 control-label">Deskripsi {{$doc_type['title']}}</label>
      <div class="col-sm-10">
        <textarea class="form-control" rows="4" name="doc_desc" placeholder="Masukan Deskripsi Kontrak">{{old('doc_desc',Helper::prop_exists($doc,'doc_desc'))}}</textarea>
        <div class="error error-doc_desc"></div>
      </div>
    </div>

    @if(in_array($doc_type->name,['khs','turnkey']))
      <div class="form-group formerror formerror-doc_template_id">
        <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Jenis {{$doc_type['title']}}</label>
        <div class="col-sm-6">
          {!!Helper::select_jenis($doc_type->name,old('doc_template_id',Helper::prop_exists($doc,'doc_template_id')),'doc_template_id')!!}
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          <div class="error error-doc_template_id"></div>
        </div>
      </div>
    @endif

    @if($doc_type->name=="sp" || $doc_type->name=="khs" || $doc_type->name=="turnkey" || $doc_type->name=="surat_pengikatan" || $doc_type->name=="mou")
      <div class="form-group formerror formerror-doc_startdate">
        <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Mulai {{$doc_type['title']}}</label>
        <div class="col-sm-6">
          <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" name="doc_startdate" value="{{old('doc_startdate',Helper::prop_exists($doc,'doc_startdate'))}}" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          <div class="error error-doc_startdate"></div>
        </div>
      </div>

      <div class="form-group formerror formerror-doc_enddate">
        <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal Akhir {{$doc_type['title']}}</label>
        <div class="col-sm-6">
          <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" name="doc_enddate" value="{{old('doc_enddate',Helper::prop_exists($doc,'doc_enddate'))}}" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          <div class="error error-doc_enddate"></div>
        </div>
      </div>
    @else
      <div class="form-group formerror formerror-doc_date">
        <label for="akte_awal_tg" class="col-sm-2 control-label"><span class="text-red">*</span> Tanggal {{$doc_type['title']}}</label>
        <div class="col-sm-6">
          <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" name="doc_date" value="{{old('doc_date',Helper::prop_exists($doc,'doc_date'))}}" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          <div class="error error-doc_date"></div>
        </div>
      </div>
    @endif

  </div>

  <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
    @include('documents::doc-form-edit.general-info-right')
    @include('documents::doc-form-edit.lampiran-1')
  </div>

  @if($doc_type->name!="mou" && $doc_type->name!="surat_pengikatan")
  <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
    @if($doc_type->name!="sp")
      <div class="form-group formerror formerror-doc_proc_process">
        <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Cara Pengadaan</label>
        <div class="col-sm-6">
          <select class="form-control" name="doc_proc_process">
            <option value="P" {!!Helper::old_prop_selected($doc,'doc_proc_process','P')!!}>Pelelangan</option>
            <option value="PL" {!!Helper::old_prop_selected($doc,'doc_proc_process','PL')!!}>Pemilihan Langsung</option>
            <option value="TL" {!!Helper::old_prop_selected($doc,'doc_proc_process','TL')!!}>Penunjukan Langsung</option>
          </select>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          <div class="error error-doc_proc_process"></div>
        </div>
      </div>
    @endif
      <div class="form-group formerror formerror-doc_mtu">
        <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Mata Uang</label>
        <div class="col-sm-3">
          <select class="form-control mata-uang" name="doc_mtu">
            <option value="RP" {!!Helper::old_prop_selected($doc,'doc_mtu','RP')!!}>Rp.</option>
            <option value="USD" {!!Helper::old_prop_selected($doc,'doc_mtu','USD')!!}>USD</option>
          </select>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          <div class="error error-doc_mtu"></div>
        </div>
      </div>
    @if($doc_type->name!="sp" && $doc_type->name!="khs")
      <div class="form-group formerror formerror-doc_value">
        <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Nilai Kontrak</label>
        <div class="col-sm-3">
          <div class="input-group">
            <div class="input-group-addon mtu-set">
            </div>
            <input type="text" class="form-control input-rupiah" name="doc_value" value="{{Helper::old_prop($doc,'doc_value')}}" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-10 col-sm-offset-2">
          <div class="error error-doc_value"></div>
        </div>
      </div>
    @endif

    @if($doc_type->name=="sp")
      <div class="form-group">
        <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Nilai SP</label>
        <div class="col-sm-10">
          <table class="table table-bordered table-sp">
            <thead>
            <tr>
              <th style="width:250px">Material</th>
              <th style="width:250px">Jasa</th>
              <th>Total</th>
              <th  style="width:100px">PPN</th>
              <th>Total PPN</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td>
                  <div class="input-group formerror formerror-doc_nilai_material">
                    <span class="input-group-addon mtu-set"></span>
                    <input type="text" class="form-control input-rupiah hitung_sp" name="doc_nilai_material" value="{{Helper::old_prop($doc,'doc_nilai_material')}}" autocomplete="off">
                  </div>
                  <div class="error error-doc_nilai_material"></div>
                </td>
                <td>
                  <div class="input-group formerror formerror-doc_nilai_jasa">
                    <span class="input-group-addon mtu-set"></span>
                    <input type="text" class="form-control input-rupiah hitung_sp" name="doc_nilai_jasa" value="{{Helper::old_prop($doc,'doc_nilai_jasa')}}"  autocomplete="off">
                  </div>
                  <div class="error error-doc_nilai_jasa"></div>
                </td>
                <td class="text-right" style="vertical-align: middle;"><span class="doc_nilai_total">{{Helper::old_prop($doc,'doc_nilai_total')}}</span>
                  <input type="hidden" class="form-control" name="doc_nilai_total" value="{{Helper::old_prop($doc,'doc_nilai_total')}}" autocomplete="off">
                </td>
                <td class="text-right" style="vertical-align: middle;">
                  <div class="input-group formerror formerror-ppn">
                    <input type="hidden" class="form-control" name="ppn" value="{{Helper::old_prop($doc,'doc_nilai_ppn')}}" autocomplete="off">
                    <input type="text" class="form-control ppn_sp" name="ppn" value="{{Helper::old_prop($doc,'doc_nilai_ppn')}}" autocomplete="off" disabled>
                    <span class="input-group-addon">%</span>
                  </div>
                  <div class="error error-ppn"></div>
                </td>
                <td class="text-right" style="vertical-align: middle;"><span class="doc_nilai_total_ppn">{{Helper::old_prop($doc,'doc_nilai_total_ppn')}}</span>
                  <input type="hidden" class="form-control" name="doc_nilai_total_ppn" value="{{Helper::old_prop($doc,'doc_nilai_total_ppn')}}" autocomplete="off">
                </td>
              </tr>
          </tbody>
          </table>
        </div>
      </div>
    @endif
  </div>
  @endif


  @if($doc_type->name!="surat_pengikatan" and $doc_type->name!="mou")
  <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
    @include('documents::doc-form-edit.pic')
  </div>
  @endif

    @if($doc_type->name=="turnkey" || $doc_type->name=="sp")
  <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
    <div class="form-group formerror formerror-doc_po">
      <label for="prinsipal_st" class="col-sm-2 control-label"> PO</label>
      <div class="col-sm-3">
        <div class="input-group">
          <input class="form-control no_po" type="text" name="doc_po" value="{{Helper::old_prop($doc,'doc_po')}}" placeholder="Masukan No.PO">
          <span class="input-group-btn">
            <button class="btn btn-success cari-po" type="button"><i class="glyphicon glyphicon-search"></i></button>
          </span>
        </div>
      </div>
      <span class="error error-po text-danger"></span>
      <div class="col-sm-10 col-sm-offset-2">
        <div class="error error-doc_po"></div>
      </div>
    </div>
    <div class="parent-potables" style="display:none;">
      <table class="table" id="parentPO">
        <tbody>
        </tbody>
      </table>
      <table class="table table-condensed table-striped" id="potables">
          <thead>
          <tr>
              <th>No.</th>
              <th>Kode Item</th>
              <th>Item</th>
              <th>Qty</th>
              <th>Satuan</th>
              <th>Currency</th>
              <th>Harga Total</th>
              <th>Delivery Date</th>
              <th>No PR</th>
              <th>Keterangan</th>
          </tr>
          </thead>
          <tbody>
            <tr class="loading-tr">
              <td colspan="10" class="text-center"><img src="{{asset('/images/loader.gif')}}" title="please wait..."/></td>
            </tr>
          </tbody>
      </table>
    </div>
  </div>
    @endif
</div>
