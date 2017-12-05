<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          General Info
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
        <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          @if(!in_array($doc_type->name,['turnkey','khs','surat_pengikatan','mou']))
          <div class="form-group ">
            <label class="col-sm-2 control-label">No.Kontrak Induk </label>
            <div class="col-sm-10 text-me">{{$doc_parent->doc_no or '-'}}</div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label">Judul Kontrak Induk </label>
            <div class="col-sm-10 text-me">{{$doc_parent->doc_title or '-'}}</div>
          </div>
          @endif
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
          @if($doc_type->name=="sp" || $doc_type->name=="khs" || $doc_type->name=="turnkey" || $doc_type->name=="surat_pengikatan" || $doc_type->name=="mou")
            <div class="form-group">
              <label for="akte_awal_tg" class="col-sm-2 control-label">Tanggal Mulai {{$doc_type['title']}}</label>
              <div class="col-sm-10 text-me">
                @if(isset($doc->doc_startdate))
                {{Carbon\Carbon::parse($doc->doc_startdate)->format('l, d F Y')}}
                @else - @endif
              </div>
            </div>
            <div class="form-group">
              <label for="akte_awal_tg" class="col-sm-2 control-label">Tanggal Akhir {{$doc_type['title']}}</label>
              <div class="col-sm-10 text-me">
                @if(isset($doc->doc_enddate))
                  {{Carbon\Carbon::parse($doc->doc_enddate)->format('l, d F Y')}}
                @else - @endif
              </div>
            </div>
          @else
            <div class="form-group">
              <label class="col-sm-2 control-label">Tanggal  {{$doc_type['title']}}</label>
              <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($doc->doc_date)->format('l, d F Y')}}</div>
            </div>
          @endif
        </div>
        <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Konseptor</label>
            <div class="col-sm-10 text-me">{{$pegawai_konseptor->n_nik}} - {{$pegawai_konseptor->v_nama_karyawan}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Divisi</label>
            <div class="col-sm-10 text-me">{{$pegawai_konseptor->v_short_divisi}}</div>
          </div>
          @include('documents::doc-view.general-info-right')
          <div class="form-group">
            <label class="col-sm-2 control-label">Approver</label>
            <div class="col-sm-10 text-me">{{Helper::get_approver_by_id($doc->user_id)}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Pihak I </label>
            <div class="col-sm-10 text-me">{{$doc->doc_pihak1}}</div>
          </div>          
          <div class="form-group">
            <label for="ttd_pihak1" class="col-sm-2 control-label">Penandatangan Pihak I</label>
            <div class="col-sm-10 text-me">{{$pegawai_pihak1->n_nik}} - {{$pegawai_pihak1->v_nama_karyawan}} - {{$pegawai_pihak1->v_short_posisi}}</div>
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
                            <td>@if(!empty($dt->meta_file))
                            <!--  
                            <a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_lampiran_ttd'])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
                            -->
                            <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_lampiran_ttd'])}}">
                            <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                            </a>
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
        </div>
        @if($doc_type->name!="mou" && $doc_type->name!="surat_pengikatan")
        <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
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
        </div>
        @endif

        @if($doc_type->name=="surat_pengikatan" and $doc_type->name=="mou")        
        <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
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
        </div>
        @endif



          @if($doc_type->name=="turnkey" || $doc_type->name=="sp")
          <input type="hidden" id="view_po_val" name="po_no" value="{{$doc->doc_po_no}}">
          <div class="form-horizontal parent-potables" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;display:none;">
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
          @endif
          @include('documents::partials.buttons-view')
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  var view_po_val = $('#view_po_val').val();
  if(view_po_val!=""){
    render_po(view_po_val);
  }
});
function render_po(po){
  var error_po = $('.error-po');
  var table = $('#potables');
  var parentPO = $('#parentPO');
  var loading = table.find('.loading-tr');
  loading.show();
  var tr_count = table.find('tbody>tr').not('tbody>tr.loading-tr');
  table.parent().hide();
    $.ajax({
      url: '{!! route('doc.get-po') !!}',
      type: 'GET',
      dataType: 'json',
      data: {po: po}
    })
    .done(function(response) {
      if(response.status){
        if(response.length==0){
          error_po.html('No.PO tidak ditemukan!');
        }
        else{
          var data = response.data.POITEM;
          var dataHeader = response.data.POHEADER[0];
          loading.hide();
          table.parent().show();
          var tr;
          $.each(data,function(index, el) {
            var hargaTotal = this.QUANTITY*this.NET_PRICE;
            var po_data = {
              no         : (index+1),
              kode_item  : this.PO_ITEM,
              item       : this.SHORT_TEXT,
              qty        : formatRupiah(this.QUANTITY),
              satuan     : this.PO_UNIT,
              mtu        : dataHeader.CURRENCY,
              harga      : formatRupiah(this.NET_PRICE),
              harga_total: formatRupiah(hargaTotal),
              keterangan : this.TRACKINGNO,
              date       : this.PRICE_DATE,
              no_pr      : this.PREQ_NO,
            }
            var tr = templatePO(po_data);
            table.find('tbody').append(tr);
          });
          var td = ParentPO(response.data);
          parentPO.find('tbody').append(td);
          error_po.html('');
        }
      }
    });
}
function templatePO(data) {
  var dates = data.date;
  var hDate_year = dates.substr(0, 4); 
  var hDate_month = dates.substr(4, 2); 
  var hDate_day = dates.substr(6, 2); 
  return '<tr>\
              <td>'+data.no+'</th>\
              <td>'+data.kode_item+'</th>\
              <td>'+data.item+'</th>\
              <td>'+data.qty+'</th>\
              <td>'+data.satuan+'</th>\
              <td>'+data.mtu+'</th>\
              <td>'+data.harga_total+'</th>\
              <td>'+hDate_day+'-'+hDate_month+'-'+hDate_year+'</th>\
              <td>'+data.no_pr+'</th>\
              <td>'+data.keterangan+'</th>\
          </tr>';
}

function ParentPO(data) {
  var nopo = $('.no_po').val();
  var dataHeader = data.POHEADER[0];
  var dataVendor = data.VENDOR_INF[0];
  var dates = dataHeader.CREAT_DATE;
  var hDate_year = dates.substr(0, 4); 
  var hDate_month = dates.substr(4, 2); 
  var hDate_day = dates.substr(6, 2); 
  return '<tr>\
            <td width="150">No PO </td>\
            <td width="10">:</td>\
            <td>'+dataHeader.PO_NUMBER+'<input type="hidden" name="po_no" value="'+dataHeader.PO_NUMBER+'"></td>\
          </tr>\
          <tr>\
            <td>Tanggal PO</td>\
            <td> : </td>\
            <td>'+hDate_day+'-'+hDate_month+'-'+hDate_year+'<input type="hidden" name="po_date" value="'+hDate_year+'-'+hDate_month+'-'+hDate_day+'"></td>\
          </tr>\
          <tr>\
            <td>Nama Vendor</td>\
            <td> : </td>\
            <td>'+dataVendor.LIFNR+' - '+dataVendor.NAME1+' '+dataVendor.STRAS+' '+dataVendor.ORT01+' '+dataVendor.PSTLZ+'<input type="hidden" name="po_vendor" value="'+dataVendor.LIFNR+' - '+dataVendor.NAME1+' '+dataVendor.STREET+' '+dataVendor.ORT01+' '+dataVendor.PSTLZ+'"></td>\
          </tr>\
          <tr>\
            <td>Nama Pembuat/nik</td>\
            <td> : </td>\
            <td>'+dataHeader.CREATED_BY+'<input type="hidden" name="po_pembuat" value="'+dataHeader.CREATED_BY+'"><input type="hidden" name="po_nik" value="'+dataHeader.CREATED_BY+'"></td>\
          </tr>\
          <tr>\
            <td>Nama Approval PO</td>\
            <td> : </td>\
            <td>- <input type="hidden" name="po_approval" value=""></td>\
          </tr>\
          <tr>\
            <td>Nama Penandatangan PO</td>\
            <td> : </td>\
            <td>- <input type="hidden" name="po_penandatangan" value=""></td>\
          </tr>';
}
</script>
@endpush
