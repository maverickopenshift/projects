<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
        @if($doc_type['title']=="Turnkey" || $doc_type['title']=="SP")
          SOW,BOQ
        @else
          Daftar Harga satuan
        @endif
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
        @if($doc_type['title']!="SP")
          <div class="form-group ">
            <label class="col-sm-2 control-label">Lingkup Pekerjaan</label>
            <div class="col-sm-10 text-me">{{$doc->doc_sow or '-'}}</div>
          </div>
        @endif
            @php
              $kode_item = Helper::old_prop_each($doc,'hs_kode_item');
              $item = Helper::old_prop_each($doc,'hs_item');
              $satuan = Helper::old_prop_each($doc,'hs_satuan');
              $mtu = Helper::old_prop_each($doc,'hs_mtu');
              $harga = Helper::old_prop_each($doc,'hs_harga');
              $qty = Helper::old_prop_each($doc,'hs_qty');
              $keterangan = Helper::old_prop_each($doc,'hs_keterangan');
              if($doc_type->name=='khs'){
                $title_hs = 'Daftar Harga Satuan';
                $tm_download = 'harga_satuan';
              }
              else{
                $title_hs = 'BoQ';
                $tm_download = 'boq';
              }
            @endphp
            <div class="form-group">
              <label for="prinsipal_st" class="col-sm-2 control-label"> {{$title_hs}}</label>
            <div class="table-responsive">
              <table class="table table-condensed table-striped">
                  <thead>
                    <tr>
                        <th style="width:50px;">No.</th>
                        <th>Kode Item</th>
                        <th>Item</th>
                        @if($doc_type->name!='khs')
                          <th  style="width:70px;">Qty</th>
                        @endif
                        <th style="width:100px;">Satuan</th>
                        <th style="width:70px;">Currency</th>
                        <th>Harga</th>
                        @if($doc_type->name!='khs')
                          <th style="width:100px;">Harga Total</th>
                        @endif
                        <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($doc->boq)>0)
                      @foreach ($doc->boq as $key=>$dt)
                        <tr>
                          <td>{{($key+1)}}</td>
                          <td>{{($dt->kode_item)}}</td>
                          <td>{{($dt->item)}}</td>
                          @if($doc_type->name!='khs')
                          <td>{{($dt->qty)}}</td>
                          @endif
                          <td>{{($dt->satuan)}}</td>
                          <td>{{($dt->mtu)}}</td>
                          <td>{{($dt->harga)}}</td>
                          @if($doc_type->name!='khs')
                          <td>{{($dt->harga_total)}}</td>
                          @endif
                          <td>{{($dt->desc)}}</td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        @if($doc_type->name!='khs')
                          <td colspan="9" align="center">-</td>
                        @else
                          <td colspan="7" align="center">-</td>
                        @endif
                      </tr>
                    @endif
                  </tbody>
              </table>
          </div>
        </div>
          @if($doc_type['title']=="SP")
            <div class="form-group">
              <label for="ttd_pihak2" class="col-sm-2 control-label">Lampiran Teknis</label>
              <div class="col-sm-10 text-me">
                @if(!empty($doc->doc_lampiran_teknis))
                    <a class="btn btn-primary btn-sm" target="_blank" href="{{route('doc.file',['filename'=>$doc->doc_lampiran_teknis,'type'=>$doc_type['name']])}}"><i class="glyphicon glyphicon-paperclip"></i> Lihat Lampiran</a>
                @endif
              </div>
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

});
</script>
@endpush
