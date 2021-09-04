// member calculate
      Highcharts.chart('districts', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'Anggota Terdaftar'
          },
          xAxis: {
              categories: {!! json_encode($cat_regency) !!},
              crosshair: true,
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
              data: {!! json_encode($cat_regency_data) !!},

          }]
      });

      // Gender
      var donut_chart = Morris.Donut({
          element: 'gender',
          data: {!! json_encode($cat_gender) !!},
          colors: ["#063df7","#EC407A"],
          resize: true,
          formatter: function (x) { return x + "%"}
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

      // age group
       Highcharts.chart('ageGroup', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'Anggota Berdasarkan Kelompok Umur'
          },
          xAxis: {
              categories: {!! json_encode($cat_range_age) !!},
              crosshair: true,
          },
          yAxis: {
              min: 0,
              title: false
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
                }
          },
          series: [{
              name:"Umur",
              data: {!! json_encode($cat_range_age_data) !!},

          }]
      });

      // grafik anggota referal terbanyak
      Highcharts.chart('referal', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'Anggota Dengan Referal Terbanyak'
          },
          xAxis: {
              categories: {!! json_encode($cat_referal) !!},
              crosshair: true,
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
              name:"Referal",
              data: {!! json_encode($cat_referal_data) !!},

          }]
      });