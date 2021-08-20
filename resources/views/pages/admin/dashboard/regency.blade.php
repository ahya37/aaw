@extends('layouts.admin')
@push('addon-style')
    <link
      href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"
      rel="stylesheet"
    />
    <link
      href="{{ asset('assets/style/style.css') }}"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('title','Dashboard - Kab/Kot')
@section('content')
<!-- Section Content -->
 <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title mb-4">Dashboard</h2>
                <nav aria-label="breadcrumb mt-4">
                  <ol class="breadcrumb">
                    
                    <div class="col-12">
                      <div class="row">
                        <div class="col-md-10 col-sm-10">
                          <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Provinsi</a></li>
                          <li class="breadcrumb-item active" aria-current="page">{{ $regency->name }}</li>
                        </div>
                        <div class="col-md-2 col-sm-2">
                          <li class="breadcrumb-item">
                            <a href="{{ route('report-member-regency-excel', $regency->id) }}" class="btn btn-sm btn-sc-primary text-white"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                          </li>
                        </div>
                      </div>
                    </div>

                  </ol>
                </nav>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card mb-2 bg-info">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          Jumlah Anggota
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white">{{ $gF->decimalFormat($total_member)}}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2 text-white cd-card-primary">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          % Jumlah Anggota
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white">{{ $gF->persen($persentage_target_member)}}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2 text-white cs-card-danger">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          Target Anggota
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white">{{ $gF->decimalFormat($target_member)}}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="card mb-2 bg-info">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          Jumlah Desa Terisi
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white">{{ $gF->decimalFormat($total_village_filled) }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2 text-white cd-card-primary">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          % Desa
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white">{{ $gF->persen($presentage_village_filled)}}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2 text-white cs-card-danger">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          Todal Desa
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white">{{ $gF->decimalFormat($total_village) }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="dashboard-content mt-3">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div id="districts"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dashboard-content mt-3">
                <div class="row">
                  <div class="col-md-6">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div id="gender"></div>
                      </div>
                      {{-- <div class="card-footer bg-white">
                        <div class="row">
                          @foreach ($gender as $val)
                          <div class="col-6 text-center">
                            <h5>{{ $val->gender == 0 ? 'Pria' : 'Wanita' }}</h5>
                            <small>{{ $val->total }}</small>
                          </div>
                          @endforeach
                        </div>
                      </div> --}}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div id="job"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@push('addon-script')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/highcharts/highcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/highcharts/venn.js') }}"></script>
<script src="{{ asset('assets/vendor/highcharts/exporting.js') }}"></script>
<script src="{{ asset('assets/vendor/highcharts/export-data.js') }}"></script>
<script src="{{ asset('assets/vendor/highcharts/accessibility.js') }}"></script>
<script>
      $(document).ready(function () {
        $("#data").DataTable();
      });
</script>
 <script>
      // member calculate
      Highcharts.chart('districts', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'Anggota Terdaftar'
          },
          xAxis: {
              categories: {!! json_encode($cat_districts) !!},
              crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Jumlah'
              }
          },
          tooltip: {
              headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0
              },
              series: {
                    stacking: 'normal',
                    borderRadius: 3,
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function(event) {
                            // console.log(this.url);
                            window.open(this.url);
                            }
                        }
                    }
                }
          },
          series: [{
              colorByPoint: true,
              name:"Anggota",
              data: {!! json_encode($cat_districts_data) !!}

          }]
      });

      // Gender
     Highcharts.chart('gender', {
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: 0,
              plotShadow: false
          },
          title: {
              text: 'Anggota Berdasarkan Gender',
              align: 'center',
              // verticalAlign: 'middle',
              // y: 60
          },
          tooltip: {
              // pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
          },
          accessibility: {
              point: {
                  valueSuffix: ''
              }
          },
          plotOptions: {
              pie: {
                  dataLabels: {
                      enabled: true,
                      distance: -50,
                      style: {
                          fontWeight: 'bold',
                          color: 'white'
                      }
                  },
                  startAngle: -90,
                  endAngle: 90,
                  center: ['50%', '75%'],
                  size: '110%'
              }
          },
          series: [{
              type: 'pie',
              name: 'Jumlah',
              innerSize: '50%',
              data: {!! json_encode($cat_gender) !!},
          }]
      });

      // Job
      Highcharts.setOptions({
        colors: Highcharts.map(
          Highcharts.getOptions().colors,
          function (color) {
            return {
              radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7,
              },
              stops: [
                [0, color],
                [1, Highcharts.color(color).brighten(-0.3).get("rgb")], // darken
              ],
            };
          }
        ),
      });

      // Build the chart
      Highcharts.chart("job", {
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: "pie",
        },
        title: {
          text: "Anggota Berdasarkan Pekerjaan",
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: "pointer",
            dataLabels: {
              enabled: true,
              format: "<b>{point.name}</b>",
              connectorColor: "silver",
            },
          },
        },
        series: [
          {
            name: "Jumlah",
            colorByPoint: true,
            data: {!! json_encode($cat_jobs) !!},
          },
        ],
      });
    </script>
@endpush