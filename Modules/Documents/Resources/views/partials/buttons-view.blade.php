<div class="form-group text-center top50 button-view">
  @if($doc->doc_signing==0 && Laratrust::can('approve-kontrak'))
    <a href="#" onclick="return window.history.back();" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">CANCEL</a>
    <button type="button" class="btn btn-success btn-setuju" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">APPROVE</button>
    <button type="button" class="btn btn-danger btn-reject" style="padding:5px 20px;font-weight:bold;font-size:16px;">RETURN</button>
  @else
    <a href="#" onclick="return window.history.back();" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">Back</a>
  @endif
</div>
