<div class="box box-danger">
  <div class="loading2"></div>
    <div class="box-header with-border">
      <i class="fa fa-search"></i>
      <h3 class="box-title">Search SAP</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <form action="{{route('supplier.mapping.sap',['id'=>$id_sup])}}" method="get" enctype="multipart/form-data">
        <div class="form-horizontal">
        <div class="form-group {{ $errors->has('asset') ? ' has-error' : '' }}">
          <label for="bdn_usaha" class="col-sm-2 control-label">NPWP</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" class="cb-npwp">
              </span>
              <input class="form-control txt-npwp" type="text" name="npwp">
            </div>
          </div>
        </div>
        <div class="form-group {{ $errors->has('asset') ? ' has-error' : '' }}">
          <label for="bdn_usaha" class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" class="cb-nama">
              </span>
              <input class="form-control txt-nama" type="text" name="nama" placeholder="masukkan Nama SAP">
            </div>
          </div>
        </div>
        <div class="form-group {{ $errors->has('asset') ? ' has-error' : '' }}">
          <label for="bdn_usaha" class="col-sm-2 control-label">Alamat</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" class="cb-alamat">
              </span>
              <input class="form-control txt-alamat" type="text" name="alamat">
            </div>
          </div>
        </div>
        <div class="form-group {{ $errors->has('asset') ? ' has-error' : '' }}">
          <label for="bdn_usaha" class="col-sm-2 control-label">Kota</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" class="cb-kota">
              </span>
              <input class="form-control txt-kota" type="text" name="kota">
            </div>
          </div>
        </div>
      </div>
      <div class="form-group text-center top btn_smpn">
          <button type="submit" class="btn btn-success" style="padding:5px 20px;font-weight:bold;font-size:16px;">SEARCH</button>
      </div>
    </form>
  </div>

<!-- /.box-body -->
</div>
@push('scripts')
  <script>
  $(function() {
    $('.form-control').attr('disabled',true);

    $('input').on('click',function () {
      if($('.cb-npwp').is(':checked')){
        $('.txt-npwp').attr('disabled',false);
      }else{
          $('.txt-npwp').val('');
          $('.txt-npwp').attr('disabled',true);
      }
      if($('.cb-nama').is(':checked')){
        $('.txt-nama').attr('disabled',false);
      }else{
          $('.txt-nama').val('');
          $('.txt-nama').attr('disabled',true);
      }
      if($('.cb-alamat').is(':checked')){
        $('.txt-alamat').attr('disabled',false);
      }else{
          $('.txt-alamat').val('');
          $('.txt-alamat').attr('disabled',true);
      }
      if($('.cb-kota').is(':checked')){
        $('.txt-kota').attr('disabled',false);
      }else{
          $('.txt-kota').val('');
          $('.txt-kota').attr('disabled',true);
      }
    });

  });
  </script>
@endpush
