<div class="box">
  <div class="box-body">
    @if($doc->lampiran_bast)
        <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
                BAST
              </div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan" class="col-sm-2 control-label">Judul Lampiran</label>
              <div class="col-sm-10 text-me">{{$doc->lampiran_bast->meta_name}}</div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal Lampiran</label>
              <div class="col-sm-10 text-me">
                @if(isset($doc->lampiran_bast->meta_desc))
                  {{Carbon\Carbon::parse($doc->lampiran_bast->meta_desc)->format('l, d F Y')}}
                @else
                -
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Lampiran</label>
              <div class="col-sm-10 text-me">
                @if(!empty($doc->lampiran_bast->meta_file))
                  <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$doc->lampiran_bast->meta_file,'type'=>'lampiran_bast'])}}">
                    <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                  </a>
                  <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$doc->lampiran_bast->meta_file,'type'=>'lampiran_bast'])}}">
                    <i class="glyphicon glyphicon-download-alt"></i>  Download
                  </a>
                @else
                  -
                @endif
              </div>
            </div>
        </div>
    @endif
    @if($doc->lampiran_baut)
        <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
                BAUT
              </div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan" class="col-sm-2 control-label">Judul Lampiran</label>
              <div class="col-sm-10 text-me">{{$doc->lampiran_baut->meta_name}}</div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-10 text-me">
                @if(isset($doc->lampiran_baut->meta_desc))
                  {{Carbon\Carbon::parse($doc->lampiran_baut->meta_desc)->format('l, d F Y')}}
                @else
                -
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Lampiran</label>
              <div class="col-sm-10 text-me">
                @if(!empty($doc->lampiran_baut->meta_file))
                  <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$doc->lampiran_baut->meta_file,'type'=>'lampiran_baut'])}}">
                    <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                  </a>
                  <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$doc->lampiran_baut->meta_file,'type'=>'lampiran_baut'])}}">
                    <i class="glyphicon glyphicon-download-alt"></i>  Download
                  </a>
                @else
                  -
                @endif
              </div>
            </div>
        </div>
    @endif
    @if(count($doc->lampiran_lain)>0)
      @foreach ($doc->lampiran_lain as $key=>$dt)
        <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
                {{$dt->meta_name}}
              </div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-10 text-me">
                @if(isset($dt->meta_desc))
                  {{Carbon\Carbon::parse($dt->meta_desc)->format('l, d F Y')}}
                @else
                -
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Lampiran</label>
              <div class="col-sm-10 text-me">
                @if(!empty($dt->meta_file))
                  <a class="btn btn-primary btn-lihat" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('doc.file',['filename'=>$dt->meta_file,'type'=>'lampiran_lain'])}}">
                    <i class="glyphicon glyphicon-paperclip"></i>  Lihat Lampiran
                  </a>
                  <a class="btn btn-info btn-lihat" target="_blank" href="{{route('doc.download',['filename'=>$dt->meta_file,'type'=>'lampiran_lain'])}}">
                    <i class="glyphicon glyphicon-download-alt"></i>  Download
                  </a>
                @else
                  -
                @endif
              </div>
            </div>
        </div>
      @endforeach
    @endif
    @if(count($doc->gr)>0)
      @foreach ($doc->gr as $key=>$dt)
        <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
            <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
              <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
                GR #{{($key+1)}}
              </div>
            </div>

            <div class="form-group">
              <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Nomor GR</label>
              <div class="col-sm-10 text-me">{{($dt->meta_name)}}</div>
            </div>
            <div class="form-group">
              <label for="doc_jaminan_startdate" class="col-sm-2 control-label">Nilai GR</label>
              <div class="col-sm-10 text-me">{{number_format($dt->meta_desc)}}</div>
            </div>
        </div>
      @endforeach
    @endif
  </div>
</div>
@push('scripts')
<script>
$(function() {
  
});
</script>
@endpush
