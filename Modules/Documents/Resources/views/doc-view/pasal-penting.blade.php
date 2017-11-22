<div class="box">

    <div class="box-body form-asr">
    @if(count($doc->pasal)>0)
@foreach ($doc->pasal as $key=>$dt)
  <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
      <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
        <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Pasal Khusus <span class="total_asu">{{$key+1}}</span></div>
      </div>
      <div class="form-group">
        <label for="doc_jaminan" class="col-sm-2 control-label">Judul Pasal</label>
        <div class="col-sm-10 text-me">
          {{$dt->meta_title or '-'}}
        </div>
      </div>
      <div class="form-group">
        <label for="doc_asuransi" class="col-sm-2 control-label">Isi Pasal</label>
        <div class="col-sm-10 text-me">{{$dt->meta_desc or '-'}}</div>
      </div>
  </div>
    @endforeach
  @else
    <div class="form-horizontal ao-jas" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">Pasal Khusus</div>
        </div>
        <div class="form-group">
          <label for="doc_jaminan" class="col-sm-2 control-label">Judul Pasal</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
        <div class="form-group">
          <label for="doc_asuransi" class="col-sm-2 control-label">Isi Pasal</label>
          <div class="col-sm-10 text-me">-</div>
        </div>
    </div>
  @endif
      @include('documents::partials.buttons-view')
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
</script>
@endpush
