@if($doc->doc_signing==0 && Laratrust::can('approve-kontrak'))
{{-- <div class="well well-sm">
  <div class="form-group" style="margin-bottom:0px">
    <label class="col-sm-2 control-label">Disclaimer</label>
    <div class="col-sm-10 text-me">
      <div class="checkbox" style="padding-top:0px;">
        <label>
          <input type="checkbox" name="disclaimer[]" class="disclaimer" autocomplete="off"> Saya sudah membaca seluruh isi dan dokumen terlampir. Semua sudah sesuai
        </label>
      </div>
    </div>
  </div>
</div> --}}
@endif