<div class="form-group text-center top50">
  <a href="{{route('doc',['status'=>'selesai'])}}" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">{{($doc->doc_signing==0)?'BATAL':'KEMBALI'}}</a>
  @if($doc->doc_signing==0 && Laratrust::can('approve-kontrak'))
    <button type="button" class="btn btn-success btn-setuju" style="padding:5px 20px;font-weight:bold;font-size:16px;">SETUJUI</button>
  @endif
</div>