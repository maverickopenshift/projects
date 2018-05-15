@extends('layouts.app')

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
      <form class="" action="" method="get">
      {{--
      <div class="form-inline">
          <div class="form-group">
            {!!Helper::select_month($month)!!}
          </div>
          <div class="form-group">
            {!!Helper::select_year($year)!!}
          </div>
          <button type="submit" class="btn btn-success">Submit</button>
      </div>
      --}}
      <div class="form-inline">
          <div class="form-group top10">
            <select class="form-control" id="doc_range" name="doc_range">
              @php
                if($range==1){
                  $a="";
                  $b="selected";
                  $c="";
                  $d="";
                }elseif($range==3){
                  $a="";
                  $b="";
                  $c="selected";
                  $d="";
                }elseif($range==6){
                  $a="";
                  $b="";
                  $c="";
                  $d="selected";
                }else{
                  $a="selected";
                  $b="";
                  $c="";
                  $d="";
                }
              @endphp
              <option value="" {{$a}}>Pilih Range</option>
              <option value="1" {{$b}}>Bulan Ini</option>
              <option value="3" {{$c}}>3 Bulan</option>
              <option value="6" {{$d}}>6 Bulan</option>
            </select>
          </div>

          <div class="form-group top10">
            <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" id="doc_daritanggal" name="doc_daritanggal" placeholder="Dari Tanggal.." value="{{$dari}}" autocomplete="off">
            </div>
          </div>

          <div class="form-group top10">
            <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" id="doc_sampaitanggal" name="doc_sampaitanggal" placeholder="Sampai Tanggal.." value="{{$sampai}}" autocomplete="off">
            </div>
          </div>

          <button type="submit" class="btn btn-success top10">Submit</button>
      </div>
      </form>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
    </div>
<!-- /.box-body -->
</div>
{{-- 
<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">Box Danger</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        Test Box danger
    </div>
<!-- /.box-body -->
</div> 
--}}
@endsection
@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
Highcharts.chart('container', {
  chart: {
      type: 'column'
  },
  title: {
      text: '{{$title}}'
  },
  xAxis: {
      type: 'category',
      labels: {
          rotation: -45,
          style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
          }
      }
  },
  yAxis: {
      min: 0,
      title: {
          text: 'Jumlah Data'
      }
  },
  legend: {
      enabled: false
  },
  tooltip: {
      pointFormat: '{{$title}}: <b>{point.y}</b>'
  },
  series: [{
      name: 'Population',
      data: [
          ['Surat Pengikatan', {!!$doc['surat_pengikatan']!!}],
          ['KHS', {!!$doc['khs']!!}],
          ['Turnkey', {!!$doc['turnkey']!!}],
          ['Surat Pesanan (SP)', {!!$doc['sp']!!}],
          ['Amandemen SP', {!!$doc['amandemen_sp']!!}],
          ['Amandemen Kontrak', {!!$doc['amandemen_kontrak']!!}],
          ['Addendum', {!!$doc['addendum']!!}],
          ['Side Letter', {!!$doc['side_letter']!!}],
          ['Mou', {!!$doc['mou']!!}]
      ],
      dataLabels: {
          enabled: true,
          rotation: -90,
          color: '#FFFFFF',
          align: 'right',
          // format: '{point.y:.1f}', // one decimal
          y: 10, // 10 pixels down from the top
          style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
          }
      }
  }]
});
</script>
@endpush
