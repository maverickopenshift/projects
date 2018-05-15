
@if(isset($latar_belakang_surat_pengikatan)>0)
  <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
          Surat Pengikatan <span class=""></span>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-2 control-label">No. Surat Pengikatan</label>
        <div class="col-sm-10 text-me">{{$latar_belakang_surat_pengikatan->doc_no or '-'}}</div>
      </div>

      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
        <div class="col-sm-10 text-me">{{$latar_belakang_surat_pengikatan->doc_title or '-'}}</div>
      </div>

      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">Tanggal</label>
        <div class="col-sm-10 text-me">{{$latar_belakang_surat_pengikatan->doc_startdate}} - {{$latar_belakang_surat_pengikatan->doc_enddate}}</div>
      </div>
      
      <div class="form-group">
        <label for="doc_jaminan_startdate" class="col-sm-2 control-label">File</label>
        <div class="col-sm-10 text-me">
          @if(count($latar_belakang_surat_pengikatan->lampiran_ttd)>0)
            @foreach ($latar_belakang_surat_pengikatan->lampiran_ttd as $key=>$dt)
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>'surat_pengikatan_lampiran_ttd'])}}">
                <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                </a>
                <input name="disclaimer[]" class="disclaimer hide" autocomplete="off" type="checkbox">
            @endforeach
          @else
           -
          @endif
        </div>
      </div>
  </div>
@else
  <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Surat Pengikatan</div>
      </div>
      {{--
      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">No. Surat Pengikatan</label>
        <div class="col-sm-10 text-me">-</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
        <div class="col-sm-10 text-me">-</div>
      </div>
      <div class="form-group">
        <label for="doc_asuransi" class="col-sm-2 control-label">Tanggal</label>
        <div class="col-sm-10 text-me">-</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan_nilai" class="col-sm-2 control-label">File</label>
        <div class="col-sm-10 text-me">-</div>
      </div>
      --}}
  </div>
@endif

{{--
@if(isset($latar_belakang_mou)>0)
  <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
          MoU <span class=""></span>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-2 control-label">No. Mou</label>
        <div class="col-sm-10 text-me">{{$latar_belakang_mou->doc_no or '-'}}</div>
      </div>

      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
        <div class="col-sm-10 text-me">{{$latar_belakang_mou->doc_title or '-'}}</div>
      </div>

      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">Tanggal</label>
        <div class="col-sm-10 text-me">{{$latar_belakang_mou->doc_startdate}} - {{$latar_belakang_mou->doc_enddate}}</div>
      </div>
      
      <div class="form-group">
        <label for="doc_jaminan_startdate" class="col-sm-2 control-label">File</label>
        <div class="col-sm-10 text-me">
          @if(count($latar_belakang_mou->lampiran_ttd)>0)
            @foreach ($latar_belakang_mou->lampiran_ttd as $key=>$dt)
                <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>'mou_lampiran_ttd'])}}">
                <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                </a>
            @endforeach
          @else
           -
          @endif
        </div>
      </div>
  </div>
@else
  <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Surat Pengikatan</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">No. Surat Pengikatan</label>
        <div class="col-sm-10 text-me">-</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">Judul</label>
        <div class="col-sm-10 text-me">-</div>
      </div>
      <div class="form-group">
        <label for="doc_asuransi" class="col-sm-2 control-label">Tanggal</label>
        <div class="col-sm-10 text-me">-</div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan_nilai" class="col-sm-2 control-label">File</label>
        <div class="col-sm-10 text-me">-</div>
      </div>
  </div>
@endif
--}}