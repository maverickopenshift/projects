<div class="box">
  @php
    $doc_top_matauang=Helper::old_prop($doc,'doc_top_matauang');
    $doc_top_totalharga=Helper::old_prop($doc,'doc_top_totalharga');
  @endphp

  <div class="box-body">
    <div class="form-horizontal">

      <div class="form-horizontal" style="border: 1px solid #d2d6de;padding: 10px;position: relative;margin-top: 15px;margin-bottom: 33px;">
        <div class="form-group" style="position:relative;margin-bottom: 34px;">
          <div style="position: absolute;top: -36px;font-size: 19px;background-color: white;left: 22px;padding: 10px;">

          </div>
        </div>

        <div class="form-group ">
          <label class="col-sm-2 control-label">Nilai Kontrak </label>
          <div class="col-sm-10 text-me">{{$doc->doc_mtu}} {{number_format($doc->doc_value)}}</div>
        </div>

        <div class="form-group ">
          <label class="col-sm-2 control-label">Periode Kontrak </label>
          <div class="col-sm-10 text-me">{{Carbon\Carbon::parse($doc->doc_startdate)->format('d-m-Y')}} s.d {{Carbon\Carbon::parse($doc->doc_enddate)->format('d-m-Y')}}</div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-parent-top" width="100%">
            <thead>
              <tr>
                <th>Deskripsi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Harga</th>
                <th>Target BAPP</th>
              </tr>
            </thead>
            <tbody>
              @if(count($doc->doc_top)>0)
                @foreach ($doc->doc_top as $key=>$dt)
                  <tr>
                    <td>{{($dt->top_deskripsi)}}</td>
                    <td>{{($dt->top_tanggal_mulai)}}</td>
                    <td>{{($dt->top_tanggal_selesai)}}</td>
                    <td>{{($dt->top_matauang)}} {{number_format($dt->top_harga)}}</td>
                    <td>{{($dt->top_tanggal_bapp)}}</td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="5" align="center">-</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>

      </div>

      @include('documents::partials.buttons-view')
    </div>
  </div>
</div>
