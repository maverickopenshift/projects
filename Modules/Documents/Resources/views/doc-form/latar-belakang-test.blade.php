      <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">BAK <span class="total_lt"></span></div>
          </div>
          <div class="form-group">
            <label for="lt_name" class="col-sm-2 control-label"> Judul</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="" disabled="true" autocomplete="off" value="BAK">
              <input type="text" class="form-control" name="lt_name[]" style="Display:none" autocomplete="off" value="BAK">
            </div>

          </div>
          <div class="form-group">
            <label for="lt_desc" class="col-sm-2 control-label"> Tanggal</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="lt_desc[]" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="lt_file" class="col-sm-2 control-label"> File</label>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="lt_file[]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="lt_file_old[]">
                </span>
              </div>
            </div>
          </div>
      </div>


      <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">BAP <span class="total_lt"></span></div>
          </div>
          <div class="form-group">
            <label for="lt_name" class="col-sm-2 control-label"> Judul</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="" disabled="true" autocomplete="off" value="BAP">
              <input type="text" class="form-control" name="lt_name[]" style="Display:none" autocomplete="off" value="BAP">
            </div>

          </div>
          <div class="form-group">
            <label for="lt_desc" class="col-sm-2 control-label"> Tanggal</label>
            <div class="col-sm-4">
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input type="text" class="form-control" name="lt_desc[]" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="lt_file" class="col-sm-2 control-label"> File</label>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="file" class="hide" name="lt_file[]">
                <input class="form-control" type="text" disabled>
                <span class="input-group-btn">
                  <button class="btn btn-default click-upload" type="button">Browse</button>
                  <input type="hidden" name="lt_file_old[]">
                </span>
              </div>
            </div>
          </div>
      </div>

      <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">
            Surat Pengikatan <span class="total_lt"></span>
          </div>
        </div>
        
        <div class="form-group">
          <label for="lt_name" class="col-sm-2 control-label"> No. Surat Pengikatan</label>
          <div class="col-sm-4">
            <input type="hidden" class="text-surat-pengikatan" name="text_surat_pengikatan" value="{{$text_surat_pengikatan}}">
            <select class="form-control select-kontrak-surat-pengikatan" style="width: 100%;" name="f_no_surat_pengikatan" data-id="{{Helper::old_prop($doc,'f_no_surat_pengikatan')}}">
              <option value="">Pilih Surat Pengikatan</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label for="lt_name" class="col-sm-2 control-label"> Judul </label>
          <div class="col-sm-4 f_judul_surat_pengikatan">

          </div>
        </div>

        <div class="form-group">
          <label for="lt_desc" class="col-sm-2 control-label"> Tanggal</label>
          <div class="col-sm-4 f_tanggal_surat_pengikatan">
           
          </div>
        </div>

        <div class="form-group">
          <label for="lt_file" class="col-sm-2 control-label"> File</label>
          <div class="col-sm-8 f_file_surat_pengikatan">

          </div>
        </div>
      </div>

      <div class="form-horizontal lt" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
          <div class="form-group button-delete" style="position:relative;margin-bottom: 34px;">
            <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">MoU <span class="total_lt"></span>
            </div>
          </div>

          <div class="form-group">
            <label for="lt_name" class="col-sm-2 control-label"> No. MoU</label>
            <div class="col-sm-4">
              <input type="hidden" class="text-mou" name="text_mou" value="{{$text_mou}}">
              <select class="form-control select-kontrak-mou" style="width: 100%;" name="f_no_mou" data-id="{{Helper::old_prop($doc,'f_no_mou')}}">
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label for="lt_name" class="col-sm-2 control-label"> Judul</label>
            <div class="col-sm-4 f_judul_mou">
            </div>
          </div>

          <div class="form-group">
            <label for="lt_desc" class="col-sm-2 control-label"> Tanggal</label>
            <div class="col-sm-4 f_tanggal_mou">

            </div>
          </div>

          <div class="form-group">
            <label for="lt_file" class="col-sm-2 control-label"> File</label>
            <div class="col-sm-8 f_file_mou">

            </div>
          </div>
      </div>