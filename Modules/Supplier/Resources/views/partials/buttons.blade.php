<div class="form-group text-center top50 btn_smpn" style="display:none">
  <a href="{{route('supplier')}}" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">BACK</a>
  <button type="submit" class="btn btn-success btn-sbm" style="padding:5px 20px;font-weight:bold;font-size:16px;">SIMPAN</button>
</div>

@if($action_type=='lihat')
  <div class="form-group text-center top50 btn_apprv">
    <a href="{{route('supplier')}}" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">BACK</a>
    @if($supplier->vendor_status==0)
    <button type="submit" class="btn btn-success btn-approve" style="padding:5px 20px;font-weight:bold;font-size:16px;">APPROVE</button>
    <button type="submit" class="btn btn-danger btn-return" style="padding:5px 20px;font-weight:bold;font-size:16px;">RETURN</button>
    @endif
  </div>
@endif
