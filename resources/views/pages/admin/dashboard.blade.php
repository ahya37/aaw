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
@endpush
@section('title','Dashboard')
@section('content')
<!-- Section Content -->
 <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Dashboard</h2>
                <p class="dashboard-subtitle">Sitem Keanggotaan AAW</p>
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
                          <h4 class="text-white">20</h4>
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
                          <h4 class="text-white">80 %</h4>
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
                          <h4 class="text-white">80.000</h4>
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
                          <h4 class="text-white">20</h4>
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
                          <h4 class="text-white">80 %</h4>
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
                          <h4 class="text-white">20</h4>
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
                        <div id="member"></div>
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
                      <div class="card-footer bg-white">
                        <div class="row">
                          <div class="col-6 text-center">
                            <h5>10.000</h5>
                            <small>Pria</small>
                          </div>
                          <div class="col-6 text-center">
                            <h5>20.000</h5>
                            <small>Wanita</small>
                          </div>
                        </div>
                      </div>
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
      Highcharts.chart("member", {
        chart: {
          type: "column",
        },
        title: {
          text: "Anggota Terdaftar",
        },

        xAxis: {
          type: "category",
          labels: {
            rotation: -45,
            style: {
              fontSize: "13px",
              fontFamily: "Verdana, sans-serif",
            },
          },
        },
        yAxis: {
          min: 0,
        },
        legend: {
          enabled: false,
        },
        tooltip: {
          pointFormat: "Terdata: <b>{point.y:.1f} anggota</b>",
        },
        series: [
          {
            colorByPoint: true,
            name: "Population",
            data: [
              ["BANJARSARI", 40],
              ["BAYAH", 35],
              ["BOJONGMANIK", 37],
              ["CIBADAK", 29],
              ["CIBEBER", 45],
              ["CIGEMBLONG", 50],
              ["CIHARA", 39],
              ["CIKULUR", 38],
              ["CILELER", 44],
              ["CILOGRANG", 33],
              ["CIMARGA", 33],
              ["CIPANAS", 33],
              ["CIRINTEN", 33],
              ["CURUGBITUNG", 33],
              ["GUNUNG KENCANA", 33],
              ["KALANGANYAR", 33],
              ["LEBAKGEDONG", 33],
              ["LEUWIDAMAR", 33],
              ["MAJA", 33],
              ["MALINGPING", 33],
              ["MUNCANG", 33],
              ["PANGGARANGAN", 33],
              ["RANGKASBITUNG", 33],
              ["SAJIRA", 33],
              ["SOBANG", 33],
              ["WANASALAM", 33],
              ["WARUNGGUNUNG", 33],
            ],
            dataLabels: {
              enabled: true,
              rotation: -360,
              color: "#FFFFFF",
              align: "right",
              format: "{point.y:.1f}", // one decimal
              y: 10, // 10 pixels down from the top
              style: {
                fontSize: "12px",
                fontFamily: "Verdana, sans-serif",
              },
            },
          },
        ],
      });

      // Gender
      Highcharts.chart("gender", {
        accessibility: {
          point: {
            valueDescriptionFormat: "{point.name}",
          },
        },
        series: [
          {
            type: "venn",
            data: [
              {
                sets: ["A"],
                value: 4,
                name: "Pria",
              },
              {
                sets: ["B"],
                value: 1,
                name: "Wanita",
              },
              {
                sets: ["A", "B"],
                value: 1,
              },
            ],
          },
        ],
        tooltip: {
          headerFormat:
            '<span style="color:{point.color}">\u2022</span> ' +
            '<span style="font-size: 14px"> {point.point.name}</span><br/>',
        },
        title: {
          text: "Anggota Berdasarkan Gender",
        },
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
            name: "Share",
            data: [
              { name: "Mengurus Rumah Tangga", y: 70 },
              { name: "Nelayan", y: 30 },
              { name: "Petani", y: 35 },
              { name: "Wiraswasta", y: 40 },
              { name: "Buruh", y: 15 },
              { name: "Belum Bekerja", y: 20 },
            ],
          },
        ],
      });
    </script>
@endpush