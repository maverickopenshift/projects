@if($doc->doc_signing==0 && Laratrust::can('approve-kontrak'))
<div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
  <div class="form-group ">
    <label class="col-sm-2 control-label">Disclaimer</label>
    <div class="col-sm-10 text-me">
    	<input type="checkbox" class="disclaimer"> Saya sudah membaca seluruh isi dan dokumen terlampir. Semua sudah sesuai<br>
    </div>
  </div>
</div>
@endif

<div class="form-group text-center top50">
  @if($doc->doc_signing==0 && Laratrust::can('approve-kontrak'))
    <a href="#" onclick="return window.history.back();" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">CANCEL</a>
    <button type="button" class="btn btn-success btn-setuju" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">APPROVE</button>
    <button type="button" class="btn btn-danger btn-reject" style="padding:5px 20px;font-weight:bold;font-size:16px;">RETURN</button>
  @else
    <a href="#" onclick="return window.history.back();" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">Back</a>
  @endif
</div>
