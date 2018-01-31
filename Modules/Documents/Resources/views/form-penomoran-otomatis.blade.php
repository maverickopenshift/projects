@if($auto_numb=='off')
<div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
  <div class="form-group">
    <label class="col-sm-2 control-label">Penomoran Otomatis</label>
    <div class="col-sm-10">
      <input type="hidden" class="form-control" id="penomoran_otomatis" name="penomoran_otomatis" value="{{old('penomoran_otomatis',Helper::prop_exists($doc,'penomoran_otomatis'))=='yes'?'yes':'no'}}">
        <input type="checkbox" class="checkbox_penomoran_otomatis" name="checkbox_penomoran_otomatis">
    </div>
  </div>
  <div id="penomoran-otomatis-form" class="form-group {{ $errors->has('doc_no') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label"><span class="text-red">*</span> No. Kontrak</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="doc_no"  value="{{old('doc_no',Helper::prop_exists($doc,'doc_no'))}}"  placeholder="Masukan Nomor Kontrak" autocomplete="off">
      @if ($errors->has('doc_no'))
          <span class="help-block">
              <strong>{{ $errors->first('doc_no') }}</strong>
          </span>
      @endif
    </div>
  </div>
</div>
@push('scripts')
<script>
$(function() {
  if($('#penomoran_otomatis').val()=='yes'){
    var b_state = {state:true};
    $('#penomoran-otomatis-form').hide();
  }
  else{
    var b_state = {state:false};
    $('#penomoran-otomatis-form').show();
  }
  $(".checkbox_penomoran_otomatis").bootstrapSwitch(b_state);
  $('.checkbox_penomoran_otomatis').on('switchChange.bootstrapSwitch', function(event, state) {
    console.log(this); // DOM element
    console.log(event); // jQuery event
    console.log(state); // true | false
    if(state===false){
      $('#penomoran-otomatis-form').show();
      $('#penomoran_otomatis').val('no')
      // $('#penomoran-otomatis-form').find('input[name="doc_no"]').removeAttr('disabled');
    }
    else{
      $('#penomoran-otomatis-form').hide();
      $('#penomoran_otomatis').val('yes')
      $('#penomoran-otomatis-form').find('input[name="doc_no"]').val('');
    }
  });
});
</script>
@endpush
@endif