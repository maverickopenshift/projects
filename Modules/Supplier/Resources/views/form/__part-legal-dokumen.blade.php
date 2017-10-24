<div class="form-group {{ $errors->has('legal_dokumen.*') ? ' has-error' : '' }}">
  <label for="legal_dokumen" class="col-sm-2 control-label"><span class="text-red">*</span> Legal Dokumen</label>
  <div class="col-sm-10">
    @if(count(old('legal_dokumen',Helper::prop_exists($supplier,'legal_dokumen','array')))>0)
      @php 
        $i=1;
      @endphp
      @foreach (old('legal_dokumen',Helper::prop_exists($supplier,'legal_dokumen','array')) as $k => $d)
        <div class="row row-legal-dokumen bottom15">
            <div class="col-sm-4">
                <input type="text" class="form-control" name="legal_dokumen[][name]" placeholder="Nama Dokumen" value="{{$d['name']}}" autocomplete="off">
                @if ($errors->has('legal_dokumen.'.($k).'.name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('legal_dokumen.'.($k).'.name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="legal_dokumen[][file]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                </span>
              </div>
              @if($action_type=='edit')
                @php
                  $old_file = old('file_old_ld',Helper::prop_exists($supplier,'file_old_ld','array'));
                @endphp
                @if(!empty($old_file[$k]))
                  <span class="help-block">
                    <a target="_blank" href="{{route('supplier.legaldokumen.file',['filename'=>$old_file[$k]])}}"><i class="glyphicon glyphicon-paperclip"></i> {{$old_file[$k]}}</a>
                    <input type="hidden" class="hide" name="file_old_ld[]" value="{{$old_file[$k]}}">
                  </span>
                @endif
              @endif
              @if ($errors->has('legal_dokumen.'.($k).'.file'))
                  <span class="help-block">
                      <strong>{{ $errors->first('legal_dokumen.'.($k).'.file') }}</strong>
                  </span>
              @endif
            </div>
            <div class="col-sm-4 attr-btn">
                @if(count(old('legal_dokumen',Helper::prop_exists($supplier,'legal_dokumen','array')))>1)
                  <button style="margin-right:15px;" type="button" class="btn btn-default delete-legal-dokumen"><i class="glyphicon glyphicon-remove"></i></button>
                @endif
                @if(count(old('legal_dokumen',Helper::prop_exists($supplier,'legal_dokumen','array')))==$i )
                  <button type="button" class="btn btn-danger add-legal-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
                @endif
            </div>
        </div>
        @php 
          $i++;
        @endphp
      @endforeach
    @else
      <div class="row row-legal-dokumen bottom15">
          <div class="col-sm-4">
              <input type="text" class="form-control" name="legal_dokumen[][name]" placeholder="Nama Dokumen" autocomplete="off">
          </div>
          <div class="col-sm-4">
            <div class="input-group">
              <input type="file" class="hide" name="legal_dokumen[][file]">
              <input class="form-control" type="text" disabled>
              <span class="input-group-btn">
                <button class="btn btn-default click-upload" type="button">Browse</button>
              </span>
            </div>
          </div>
          <div class="col-sm-4 attr-btn">
              <button type="button" class="btn btn-danger add-legal-dokumen"><i class="glyphicon glyphicon-plus"></i></button>
          </div>
      </div>
    @endif
  </div>
</div>