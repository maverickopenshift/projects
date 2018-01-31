@extends('layouts.app')

@section('content')
  <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">
            <div class="btn-group" role="group" aria-label="...">
              
            </div>
        </h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="position:relative">
          <div id="alertBS"></div>
          <form action="{!! route('config.editstore') !!}" class="form-horizontal form-config" method="post">
            {{ csrf_field() }}
            <div class="loading-modal"></div>
          @foreach ($data as $dt)
              <div class="form-group {{ $errors->has($dt->object_key) ? ' has-error' : '' }}">
                <label class="col-sm-2 control-label">{{$dt->object_text}}</label>
                <div class="col-sm-10">
                  @if($dt->object_type=='switch')
                    <input type="hidden" class="hidden{{$dt->object_key}}" name="form[{{$dt->object_key}}]" value="{{$dt->object_value}}">
                    <input type="checkbox" checkbox-for="hidden{{$dt->object_key}}" class="checkbox-me" name="{{$dt->object_key}}" {{$dt->object_value=='off'?'':'checked'}}>
                  @else
                    @if($dt->object_key=='ppn-sp')
                      <div class="input-group" style="width:100px;">
                        <input type="text" class="form-control" name="form[{{$dt->object_key}}]"  value="{{old($dt->object_key,$dt->object_value)}}">
                        <span class="input-group-addon">%</span>
                      </div>
                    @else
                      <input type="text" class="form-control" name="form[{{$dt->object_key}}]"  value="{{old($dt->object_key,$dt->object_value)}}">
                    @endif
                  @endif
                  @if(!empty($dt->object_desc))
                    {{-- <span class="text-info">
                      {{$dt->object_desc}}
                    </span> --}}
                  @endif
                  @if ($errors->has($dt->object_key))
                      <span class="help-block">
                          <strong>{{ $errors->first($dt->object_key) }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            @endforeach
            <div class="form-group text-center top50">
              <button type="submit" class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;">SIMPAN</button>
            </div>
          </form>
      </div>
  <!-- /.box-body -->
  </div>
@endsection
@push('css')
  <style>
    .loading-modal{
      background-image: url(images/loader.gif);background-color: rgba(255,255,255,0.6);position: absolute;width: 100%;height: 100%;z-index: 1;background-repeat: no-repeat;background-position: center center;display: none;top:0;left: 0;
    }
  </style>
@endpush
@push('scripts')
<script>
$(document).on('submit','.form-config',function (event) {
    event.preventDefault();
    var formMe = $(this);
    var loading = formMe.find('.loading-modal');
    loading.show();
    $.ajax({
        url: formMe.attr('action'),
        type: 'post',
        data: formMe.serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
            alertBS('Data successfully updated','success')
            loading.hide();
        }
    });
});
$(function() {
  $('.checkbox-me').each(function(index, el) {
    var def_state = $('.'+$(this).attr('checkbox-for')).val();
    def_state = (def_state=='off')?false:true;
    $(this).bootstrapSwitch({state:def_state});
    $(this).on('switchChange.bootstrapSwitch', function(event, state) {
      console.log(this); // DOM element
      console.log(event); // jQuery event
      console.log(state); // true | false
      if(state===false){
        $('.'+$(this).attr('checkbox-for')).val('off');
      }
      else{
        $('.'+$(this).attr('checkbox-for')).val('on');
      }
    });
  });
});
</script>
@endpush
