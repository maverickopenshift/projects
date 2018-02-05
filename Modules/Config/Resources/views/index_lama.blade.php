@extends('layouts.app')

@section('content')
  <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">
            <div class="btn-group" role="group" aria-label="...">
              @if(\Auth::user()->hasPermission('tambah-config'))
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form-modal" data-title="Add">
                    <i class="glyphicon glyphicon-plus"></i> Add Config
                </button>
              @endif
            </div>
        </h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="position:relative">
          @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
          @endif
          <div id="alertBS"></div>
          <form action="{!! route('config.editstore') !!}" class="form-horizontal form-config" method="post">
            {{ csrf_field() }}
            <div class="loading-modal"></div>
          @foreach ($data as $dt)
              <div class="form-group {{ $errors->has($dt->object_key) ? ' has-error' : '' }}">
                <label class="col-sm-2 control-label">{{$dt->object_text}}</label>
                <div class="col-sm-10">
                  @if($dt->object_key=='auto-numb')
                    <input type="hidden" class="hidden{{$dt->object_key}}" name="form[{{$dt->object_key}}]" value="{{$dt->object_value}}">
                    <input type="checkbox" checkbox-for="hidden{{$dt->object_key}}" class="checkbox-me" name="{{$dt->object_key}}" {{$dt->object_value=='off'?'':'checked'}}>
                  @else
                    <input type="text" class="form-control" name="form[{{$dt->object_key}}]"  value="{{old($dt->object_key,$dt->object_value)}}">
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
              <button type="submit" class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;">SUBMIT</button>
            </div>
          </form>
          <div id="alertBS"></div>
          <table class="table table-condensed table-striped" id="datatables" style="width:100%">
              <thead>
              <tr>
                  <th>No.</th>
                  <th>Config Name</th>
                  <th>Description</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Action</th>
              </tr>
              </thead>
          </table>
      </div>
  <!-- /.box-body -->
  </div>
@include('config::form_modal')
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
var datatablesMe;
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
  datatablesMe = $('#datatables').on('xhr.dt', function ( e, settings, json, xhr ) {
      //console.log(JSON.stringify(xhr));
      if(xhr.responseText=='Unauthorized.'){
        location.reload();
      }
      }).DataTable({
      processing: true,
      serverSide: true,
      // autoWidth : true,
      // scrollX   : true,
      // fixedColumns:   {
      //       leftColumns: 2,
      //       rightColumns:1
      // },
      order : [[ 1, 'desc' ]],
      pageLength: 50,
      ajax: '{!! route('config.data') !!}',
      columns: [
          {data : 'DT_Row_Index',orderable:false,searchable:false},
          { data: 'object_key', name: 'object_key' },
          { data: 'object_value', name: 'object_value' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
          { data: 'action', name: 'action',orderable:false,searchable:false }
      ]
  });
});
</script>
@endpush
