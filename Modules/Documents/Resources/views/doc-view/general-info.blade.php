<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group ">
            <label class="col-sm-2 control-label">No.Kontrak </label>
            <div class="col-sm-10 text-me">{{$doc->doc_no or '-'}}</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Judul {{$doc_type['title']}}</label>
            <div class="col-sm-10 text-me">{{$doc->doc_title}}</div>
          </div>
          <div class="form-group">
            <label for="deskripsi_kontrak" class="col-sm-2 control-label">Deskripsi {{$doc_type['title']}}</label>
            <div class="col-sm-10 text-me">{{$doc->doc_desc}}</div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label">Jenis {{$doc_type['title']}}</label>
            <div class="col-sm-10 text-me">{{$doc->jenis->category->title}}</div>
          </div>
          @if($doc_type->name=="sp" || $doc_type->name=="khs" || $doc_type->name=="turnkey")
            <div class="form-group">
              <label for="akte_awal_tg" class="col-sm-2 control-label">Tanggal Mulai {{$doc_type['title']}}</label>
              <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($doc->doc_startdate)->format('l, d F Y')}}</div>
            </div>
            <div class="form-group">
              <label for="akte_awal_tg" class="col-sm-2 control-label">Tanggal Akhir {{$doc_type['title']}}</label>
              <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($doc->doc_enddate)->format('l, d F Y')}}</div>
            </div>
          @else
            <div class="form-group">
              <label class="col-sm-2 control-label">Tanggal  {{$doc_type['title']}}</label>
              <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($doc->doc_date)->format('l, d F Y')}}</div>
            </div>
          @endif
          @include('documents::doc-view.general-info-right')
          <div class="form-group">
            <label class="col-sm-2 control-label">Pihak I </label>
            <div class="col-sm-10 text-me">{{$doc->doc_pihak1}}</div>
          </div>
          <div class="form-group">
            <label for="ttd_pihak1" class="col-sm-2 control-label">Penandatangan Pihak I</label>
            <div class="col-sm-10 text-me nama_ttd">{{$doc->doc_pihak1_nama}}</div>
          </div>
          <div class="form-group">
            <label for="akte_awal_tg" class="col-sm-2 control-label">Pihak II</label>
            <div class="col-sm-10 text-me">{{$doc->supplier->bdn_usaha.'.'.$doc->supplier->nm_vendor}}</div>
          </div>
          <div class="form-group">
            <label for="ttd_pihak2" class="col-sm-2 control-label">Penandatangan Pihak II</label>
            <div class="col-sm-10 text-me">{{$doc->doc_pihak2_nama}}</div>
          </div>
          <div class="form-group">
            <label for="ttd_pihak2" class="col-sm-2 control-label">Lampiran 1</label>
            <div class="col-sm-5">
              <div class="parent-pictable">
                  <table class="table table-condensed table-striped">
                      <thead>
                        <tr>
                          <th>Lampiran Ke</th>
                          <th>Lihat</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($doc->lampiran_ttd)>0)
                        @foreach ($doc->lampiran_ttd as $key=>$dt)
                          <tr>
                            <td>{{($key+1)}}</td>
                            <td>@if(!empty($dt->meta_file))<a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_lampiran_ttd'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
                            @else
                            -
                          @endif</td>
                          </tr>
                        @endforeach
                        @else
                          <tr>
                              <td colspan="2" align="center">-</td>
                          </tr>
                        @endif
                      </tbody>
                  </table>
                </div>
            </div>
          </div>
          @if($doc_type->name!="sp")
            <div class="form-group">
              <label for="prinsipal_st" class="col-sm-2 control-label">Cara Pengadaan</label>
              <div class="col-sm-10 text-me">
                {{($doc->doc_proc_process=='P')?'Pelelangan':''}}
                {{($doc->doc_proc_process=='PL')?'Pemilihan Langsung':''}}
                {{($doc->doc_proc_process=='TL')?'Penunjukan Langsung':''}}
              </div>
            </div>
          @endif
            <div class="form-group">
              <label class="col-sm-2 control-label">Mata Uang</label>
              <div class="col-sm-10 text-me">{{$doc->doc_mtu}}</div>
            </div>
          @if($doc_type->name!="sp" && $doc_type->name!="khs")
            <div class="form-group">
              <label for="bdn_usaha" class="col-sm-2 control-label">Nilai Kontrak</label>
              <div class="col-sm-10 text-me">{{$doc->doc_value}}</div>
            </div>
          @endif
          @if($doc_type->name=="sp")
            <div class="form-group">
              <label for="prinsipal_st" class="col-sm-2 control-label">Nilai SP</label>
              <div class="col-sm-10">
                <div class="parent-pictable">
                    <table class="table table-condensed table-striped">
                        <thead>
                          <tr>
                            <th>Material</th>
                            <th>Jasa</th>
                            <th>Total</th>
                            <th>PPN</th>
                            <th>Total PPN</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td>{{($doc->doc_nilai_material)}}</td>
                              <td>{{($doc->doc_nilai_jasa)}}</td>
                              <td>{{($doc->doc_nilai_total)}}</td>
                              <td>{{($doc->doc_nilai_ppn)}}</td>
                              <td>{{($doc->doc_nilai_total_ppn)}}</td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
              </div>
            </div>
          @endif
          <div class="form-group">
            <label for="prinsipal_st" class="col-sm-2 control-label">Unit Penanggungjawab PIC</label>
            <div class="col-sm-10">
              <div class="parent-pictable">
                  <table class="table table-condensed table-striped">
                      <thead>
                        <tr>
                          <th width="40">No.</th>
                          <th  width="200">Nama</th>
                          <th  width="250">Jabatan</th>
                          <th  width="150">Email</th>
                          <th  width="150">No.Telp</th>
                          <th>Posisi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($doc->pic as $key=>$dt)
                          <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{($dt->nama)}}</td>
                            <td>{{($dt->jabatan)}}</td>
                            <td>{{($dt->email)}}</td>
                            <td>{{($dt->telp)}}</td>
                            <td>{{($dt->posisi)}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                  </table>
                </div>
            </div>
          </div>

          @if($doc_type->name=="turnkey" || $doc_type->name=="sp")
            @if(count($doc->po)>0)
          <div class="form-group ">
            <label class="col-sm-2 control-label">No.PO</label>
            <div class="col-sm-10 text-me">{{$doc->po->po_no or '-'}}</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Tanggal Buat</label>
            <div class="col-sm-10 text-me">{{$doc->po->po_date or '-'}}</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Nama Vendor</label>
            <div class="col-sm-10 text-me">{{$doc->po->po_vendor or '-'}}</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Nama Pembuat</label>
            <div class="col-sm-10 text-me">{{$doc->po->po_pembuat or '-'}}</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Nama Approval</label>
            <div class="col-sm-10 text-me">{{$doc->po->po_approval or '-'}}</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Nama Penandatangan</label>
            <div class="col-sm-10 text-me">{{$doc->po->po_penandatangan or '-'}}</div>
          </div>
        @else
          <div class="form-group ">
            <label class="col-sm-2 control-label">No.PO</label>
            <div class="col-sm-10 text-me">-</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Tanggal Buat</label>
            <div class="col-sm-10 text-me">-</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Nama Vendor</label>
            <div class="col-sm-10 text-me">-</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Nama Pembuat</label>
            <div class="col-sm-10 text-me">-</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Nama Approval</label>
            <div class="col-sm-10 text-me">-</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Nama Penandatangan</label>
            <div class="col-sm-10 text-me">-</div>
          </div>
        @endif
          @endif
          @include('documents::partials.buttons-view')
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {

});
</script>
@endpush
