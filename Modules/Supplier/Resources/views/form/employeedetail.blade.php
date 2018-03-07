<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
          Employee Detail
      </h3>
      @if($action_type=='lihat' || $action_type=='edit')
        @include('supplier::partials.buttons-edit')
      @endif
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group formerror formerror-nm_direktur_utama">
            <label for="nm_direktur_utama" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Direktur Utama</label>
            <div class="col-sm-10">
                <input type="text" name="nm_direktur_utama" value="{{old('nm_direktur_utama',Helper::prop_exists($supplier,'nm_direktur_utama'))}}" class="form-control" placeholder="" autocomplete="off">
                <div class="error error-nm_direktur_utama"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-nm_komisaris_utama">
            <label for="nm_komisaris_utama" class="col-sm-2 control-label"><span class="text-red">*</span> Nama Komisaris Utama</label>
            <div class="col-sm-10">
                <input type="text" name="nm_komisaris_utama" value="{{old('nm_komisaris_utama',Helper::prop_exists($supplier,'nm_komisaris_utama'))}}" class="form-control" placeholder="" autocomplete="off">
                <div class="error error-nm_komisaris_utama"></div>
            </div>
          </div>
          <div class="form-group">
            <div class="clearfix"></div>
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Contact Person</label><hr  />
          </div>
          <div class="form-group formerror formerror-cp1_nama">
            <label for="cp1_nama" class="col-sm-2 control-label"><span class="text-red">*</span> Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="cp1_nama" value="{{ old('cp1_nama',Helper::prop_exists($supplier,'cp1_nama')) }}" placeholder="" autocomplete="off">
              <div class="error error-cp1_nama"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-cp1_telp">
            <label for="cp1_telp" class="col-sm-2 control-label"><span class="text-red">*</span> No Telepon</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="cp1_telp" value="{{ old('cp1_telp',Helper::prop_exists($supplier,'cp1_telp')) }}" placeholder="" autocomplete="off">
              <div class="error error-cp1_telp"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-cp1_email">
            <label for="cp1_email" class="col-sm-2 control-label"><span class="text-red">*</span> Alamat Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="cp1_email" value="{{ old('cp1_email',Helper::prop_exists($supplier,'cp1_email')) }}" placeholder="" autocomplete="off">
              <div class="error error-cp1_email"></div>
            </div>
          </div>
          <div class="form-group">
            <hr  />
          </div>
          <div class="form-group formerror formerror-jml_peg_domestik">
            <label for="jml_peg_domestik" class="col-sm-2 control-label"><span class="text-red">*</span> Jumlah Pegawai Domestik</label>
            <div class="col-sm-10">
                <input type="text" name="jml_peg_domestik" value="{{old('jml_peg_domestik',Helper::prop_exists($supplier,'jml_peg_domestik'))}}" class="form-control" placeholder="" autocomplete="off">
                <div class="error error-jml_peg_domestik"></div>
            </div>
          </div>
          <div class="form-group formerror formerror-jml_peg_asing">
            <label for="jml_peg_asing" class="col-sm-2 control-label"><span class="text-red">*</span> Jumlah Pegawai Asing</label>
            <div class="col-sm-10">
                <input type="text" name="jml_peg_asing" value="{{old('jml_peg_asing',Helper::prop_exists($supplier,'jml_peg_asing'))}}" class="form-control" placeholder="" autocomplete="off">
                <div class="error error-jml_peg_asing"></div>
            </div>
          </div>
          @include('supplier::partials.buttons')
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>

</script>
@endpush
