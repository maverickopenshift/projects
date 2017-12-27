<div class="form-group {{ $errors->has('sertifikat_dokumen.*') ? ' has-error' : '' }}">
  <label for="sertifikat-dokumen" class="col-sm-2 control-label"></label>
  <div class="col-sm-10">
    @if(count(old('sertifikat_dokumen',Helper::prop_exists($supplier,'sertifikat_dokumen','array')))>0)
      @php
        $i=1;
      @endphp
      @foreach (old('sertifikat_dokumen',Helper::prop_exists($supplier,'sertifikat_dokumen','array')) as $k => $d)
        <div class="row row-sertifikat-dokumen bottom15">
            <div class="col-sm-4">
                <input type="text" class="form-control" name="sertifikat_dokumen[][name]" placeholder="Nama Dokumen" value="{{$d['name']}}" autocomplete="off">
                @if ($errors->has('sertifikat_dokumen.'.($k).'.name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sertifikat_dokumen.'.($k).'.name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="sertifikat_dokumen[][file]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                </span>
              </div>
              @if($action_type=='lihat' || $action_type=='edit')
                @php
                  $old_file_sd = old('file_old_sd',Helper::prop_exists($supplier,'file_old_sd','array'));
                @endphp
                @if(!empty($old_file_sd[$k]))
                  <span class="help-block">
                  <!--
                    <a target="_blank" href="{{route('supplier.sertifikat.file',['filename'=>$old_file_sd[$k]])}}"><i class="glyphicon glyphicon-paperclip"></i> {{$old_file_sd[$k]}}</a>
                  -->

                    <a href="#" data-toggle="modal" data-target="#ModalPDF" data-load-url="{{route('supplier.sertifikat.file',['filename'=>$old_file_sd[$k]])}}">
                    <i class="glyphicon glyphicon-paperclip"></i>{{$old_file_sd[$k]}}</a>

                    <input type="hidden" class="hide" name="file_old_sd[]" value="{{$old_file_sd[$k]}}">
                  </span>
                @endif
              @endif
              @if ($errors->has('sertifikat_dokumen.'.($k).'.file'))
                  <span class="help-block">
                      <strong>{{ $errors->first('sertifikat_dokumen.'.($k).'.file') }}</strong>
                  </span>
              @endif
            </div>
            <div class="col-sm-4 attr-btn">
                @if(count(old('sertifikat_dokumen',Helper::prop_exists($supplier,'sertifikat_dokumen','array')))>1)
                  <button style="margin-right:15px;" type="button" class="btn btn-default delete-sertifikat-dokumen"><i class="glyphicon glyphicon-remove"></i></button>
                @endif
                @if(count(old('sertifikat_dokumen',Helper::prop_exists($supplier,'sertifikat_dokumen','array')))==$i )
                  <button type="button" class="btn btn-danger add-sertifikat-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
                @endif
            </div>
        </div>
        @php
          $i++;
        @endphp
      @endforeach
    @else
      <div class="row row-sertifikat-dokumen bottom15">
          <div class="col-sm-4">
              <input type="text" class="form-control" name="sertifikat_dokumen[][name]" placeholder="Nama Dokumen" autocomplete="off">
          </div>
          <div class="col-sm-4">
            <div class="input-group">
              <input type="file" class="hide" name="sertifikat_dokumen[][file]" autocomplete="off">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
              </span>
            </div>
          </div>
          <div class="col-sm-4 attr-btn">
              <button type="button" class="btn btn-danger add-sertifikat-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
          </div>
      </div>
    @endif
  </div>
</div>
