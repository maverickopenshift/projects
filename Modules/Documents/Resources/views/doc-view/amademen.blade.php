<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
        <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nomer {{$doc_type['title']}} Induk</label>
          <div class="col-sm-10 text-me">{{$doc_parent->doc_no or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Judul {{$doc_type['title']}} Induk</label>
          <div class="col-sm-10 text-me">{{$doc_parent->doc_title or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Nomer {{$doc_type['title']}}</label>
          <div class="col-sm-10 text-me">{{$doc->doc_no or '-'}}</div>
        </div>
        <div class="form-group ">
          <label class="col-sm-2 control-label">Judul {{$doc_type['title']}}</label>
          <div class="col-sm-10 text-me">{{$doc->doc_title or '-'}}</div>
        </div>
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
      </div>
      <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group">
          <label class="col-sm-2 control-label">Konseptor</label>
          <div class="col-sm-10 text-me">{{$pegawai_konseptor->v_nama_karyawan.'/'.$pegawai_konseptor->n_nik.' - '.$pegawai_konseptor->v_short_posisi.' '.$pegawai_konseptor->v_short_unit.'/'.$pegawai_konseptor->v_short_divisi}}</div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Pemilik Kontrak</label>
          <div class="col-sm-10 text-me">Divisi: {{$divisi->v_short_divisi}} <br> Unit: {{$unit_bisnis->v_short_unit}}</div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Pihak I</label>
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
        @include('documents::doc-view.general-info-right')
        <div class="form-group">
          <label for="ttd_pihak2" class="col-sm-2 control-label">Lampiran 1</label>
          <div class="col-sm-8">
            <div class="parent-pictable">
                <table class="table table-condensed table-striped">
                    <thead>
                      <tr>
                        <th>Lampiran Ke</th>
                        <th>Nama Lampiran</th>
                        <th>Lihat</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($doc->lampiran_ttd)>0)
                      @foreach ($doc->lampiran_ttd as $key=>$dt)
                        <tr>
                          <td>{{($key+1)}}</td>
                          <td>{{($dt->meta_name)?$dt->meta_name:' - '}}</td>
                          <td>
                            @if(!empty($dt->meta_file))
                              <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_lampiran_ttd'])}}">
                              <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                              </a>
                              <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$dt->meta_file,'type'=>$doc_type['name'].'_lampiran_ttd'])}}">
                                  <i class="glyphicon glyphicon-download-alt"></i>  Download
                              </a>
                            @else
                            -
                            @endif
                          </td>
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
          @include('documents::partials.buttons-view')
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
})
</script>
@endpush
