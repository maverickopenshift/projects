@extends('layouts.app')

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
      <form class="" action="" method="get">
      <div class="form-inline">
          <div class="form-group">
            {!!Helper::select_month($month)!!}
          </div>
          <div class="form-group">
            {!!Helper::select_year($year)!!}
          </div>
          <button type="submit" class="btn btn-success">Submit</button>
      </div>
      </form>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
    </div>
<!-- /.box-body -->
</div>
{{-- <div class="box box-danger">
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
</div> --}}
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
      text: 'Data Bulan {!!Helper::month_name($month)!!} {!!$year!!}'
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
      pointFormat: 'Data di {!!Helper::month_name($month)!!} {!!$year!!}: <b>{point.y}</b>'
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
