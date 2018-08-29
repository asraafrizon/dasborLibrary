
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('assets/bootstrap/uii.ico') }}">

  <title>Dashboard Library</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('dc/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./d3/css/dc.css"/>


  <!-- Custom styles for this template -->
  <link href=" {{ asset('assets/bootstrap/css/navbar-fixed-top.css') }}" rel="stylesheet">
  <link href=" {{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

  <style>
  .dc-chart g.chart-body {
    clip-path: none;
  }
  .dc-chart rect.stack-deselected {
    opacity: 0.5;
  }
  .basis {
    margin: 0 auto;
    width: 87%;
    padding: 4em 3em;
    object-position: center;

  }

/*  .container {
    display:grid;
    grid-template-columns:100%;
    padding: 4em 1em;
    }*/
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="/">Dashboard Library</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="flex-center position-ref full-height">
      <ul class="navbar-nav mr-auto">


        @if (Route::has('login'))
        <div class="top-right links">
          @auth
          <li class="nav-item"><a class="nav-link" href="{{ url('koleksi') }}"></i>Home</a></li>
          @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
          @endauth
        </div>
        @endif

      </ul>
    </div>
  </nav>
  <div class="basis justify-content-center">
    <div class="row">

      <div class="col-lg-6">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Jurnal</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="jurnal">
            </div>

          </div>

        </div>
      </div>


      <div class="col-lg-6">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Tahun</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="tahun">
              <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
                <a href="javascript:tahunChart.filterAll();dc.redrawAll();">reset</a>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div class="col-lg-6">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>data koleksi judul per Fakultas</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="judulpie">
              <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
                <a href="javascript:judulpie.filterAll();dc.redrawAll();">reset</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>data koleksi judul per Tahun</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="judulchart">
              <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
                <a href="javascript:judulchart.filterAll();dc.redrawAll();">reset</a>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-lg-6 my-5">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Data koleksi Eksemplar per Fakultas</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="eksemplarpie">
              <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
                <a href="javascript:eksemplarpie.filterAll();dc.redrawAll();">reset</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 my-5">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Data koleksi eksemplar per Fakultas</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="eksemplarchart">
              <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
                <a href="javascript:eksemplarchart.filterAll();dc.redrawAll();">reset</a>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-lg-6 mt-5">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Data Aktivitas per tahun</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="aktivitastahun">

            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 mt-5">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Data per Layanan</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="layanansubjek">

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script type="text/javascript" src="./dc/src/jquery.min.js"></script>

  <script type="text/javascript" src="./d3/js/d3.js"></script>
  <script type="text/javascript" src="./d3/js/crossfilter.js"></script>
  <script type="text/javascript" src="./d3/js/dc.js"></script>


  {{-- data koleksi --}}
  <script type="text/javascript">
    'use strict';
    var jurnalChart   = dc.pieChart("#jurnal");
    var tahunChart    = dc.barChart("#tahun");
    // var dataAll = dc.dataCount('.dataAll');

    var links = [];
    d3.json("{{url('koleks')}}").then(function(json) {
      console.log(json);
      var numberFormat = d3.format('.2f');

      // json.forEach(function(d) {
      //  d.jurnal = +d.jurnal;
      //  d.tahun = +d.tahun;
      //  d.jumlah = +d.jumlah;
      // });

      var ndx = crossfilter(json);
      var all = ndx.groupAll();
      var tahunDim = ndx.dimension(function(d) {return d.tahun;});
      var jurnalDim = ndx.dimension(function(d) {return d.jurnal;});
      var tahunGroup = tahunDim.group().reduceSum(function(d) {return d.jumlah;});
      var jurnalGroup = jurnalDim.group().reduceSum(function(d) {return d.jumlah;});

      // jurnalChart
      // .width(450)
      // .height(450)
      // .dimension(jurnalDim)
      // .group(jurnalGroup)
      // .controlsUseVisibility(true)
      // .x(d3.scale.ordinal())
      // .xUnits(dc.units.ordinal)
      // .elasticY(true)
      // .brushOn (true)
      // .renderLabel(true)
      // .yAxisLabel(" ");


      jurnalChart
      .width(550)
      .height(380)
      .slicesCap(10)
      .innerRadius(60)
      // .externalLabels(50)
      .externalRadiusPadding(60)
      .drawPaths(true)
      .dimension(jurnalDim)
      .group(jurnalGroup)
      .legend(dc.legend());


      jurnalChart.on('pretransition', function(chart) {
        chart.selectAll('.dc-legend-item text')
        .text('')
        .append('tspan')
        .text(function(d) { return d.name; })
        .append('tspan')
        .attr('x', 150)
        .attr('text-anchor', 'end')
        .text(function(d) { return d.data; });
      });


      tahunChart
      .width(350)
      .height(300)

      .margins({top:20,left:-30,right:10,bottom:30})
      .dimension(tahunDim)
      .group(tahunGroup)
      .controlsUseVisibility(true)
      .x(d3.scaleOrdinal())
      .xUnits(dc.units.ordinal)
      .elasticY(false)
      .brushOn (false)
      .renderLabel(true)
      .ordinalColors(['#005b96'])
      .yAxisLabel(" ");

      tahunChart.on('pretransition', function(chart) {
        chart.selectAll('.dc-legend-item text')
        .text('')
        .append('tspan')
        .text(function(d) { return d.name; })
        .append('tspan')
        .attr('x', 150)
        .attr('text-anchor', 'end')
        .text(function(d) { return d.data; });
      });


      // dataAll /* dc.dataCount('.dc-data-count', 'chartGroup'); */
      // .dimension(ndx)
      // .group(all)
   //      // (_optional_) `.html` sets different html when some records or all records are selected.
   //      // `.html` replaces everything in the anchor with the html given using the following function.
   //      // `%filter-count` and `%total-count` are replaced with the values obtained.
   //      .html({
   //       some: '<strong>%filter-count</strong> selected out of <strong>%total-count</strong> records' +
   //       ' | <a href=\'javascript:dc.filterAll(); dc.renderAll();\'>Reset All</a>',
   //       all: 'All records selected. Please click on the graph to apply filters.'
   //      });

   dc.renderAll();

 });

</script>

{{-- data inventori judul --}}
<script type="text/javascript">

  var judulchart = dc.barChart("#judulchart"), 
  judulpie = dc.pieChart('#judulpie');
  d3.json("{{url('inven')}}").then(function(experiments) {
    console.log(experiments);

    experiments.forEach(function(x) {
      x.data_judul = +x.data_judul;
    });

          // the way to combine multiple keys into one is domain-specific (and controversial)
          // array keys are risky but also valid sometimes, that would be
          // function multikey(x,y) {
          //     return [x,y];
          // }
          // function splitkey(k) {
          //     return k;
          // }
          function multikey(x,y) {
            return x + 'x' + y;
          }
          function splitkey(k) {
            return k.split('x');
          }
          function stack_second(group) {
            return {
              all: function() {
                var all = group.all(),
                m = {};
                      // build matrix from multikey/value pairs
                      all.forEach(function(kv) {
                        var ks = splitkey(kv.key);
                        m[ks[0]] = m[ks[0]] || {};
                        m[ks[0]][ks[1]] = kv.value;
                      });
                      // then produce multivalue key/value pairs
                      return Object.keys(m).map(function(k) {
                        return {key: k, value: m[k]};
                      });
                    }
                  };
                }
                
                function ubah (data) {

                  if (data == "FTI") {
                    return 1;
                  } else if (data == "MIPA") {
                    return 2;
                  } else if (data == "FH") {
                    return 3;
                  } else if (data == "FIAI") {
                    return 4;
                  } else if (data == "FK") {
                    return 5 ;
                  } else if (data == "FTSP") {
                    return 6;
                  } else if (data == "FE") {
                    return 7;
                  } else if (data == "FPSB") {
                    return 8;
                  } else if (data == "DP") {
                    return 9;
                  }
                };

                var ndx = crossfilter(experiments);

                var tahunfakultasDim = ndx.dimension(function(d) { return multikey(d.tahun, ubah(d.fakultas)); });
                var fakultasDim = ndx.dimension(function(d) {return d.fakultas;});
                var fakultasGroup = fakultasDim.group().reduceSum(function(d){return d.data_judul;});
                var tahunfakultasGroup = tahunfakultasDim.group().reduceSum(function(d) {
                  return d.data_judul;
                });
                var stackedGroup = stack_second(tahunfakultasGroup);
                var quantizejumlah = d3.scaleQuantize().domain(d3.extent(experiments, function(d) {
                  return d.data_judul;
                })).range(['lowest', 'low', 'medium', 'high', 'highest']);


                var quantizejumlahDim = ndx.dimension(function(d) {
                  return quantizejumlah(d.data_judul);
                }), quantizejumlahGroup = quantizejumlahDim.group();




                function sel_stack(i) {
                  return function(d) {
                    return d.value[i];
                  };
                }

                judulchart
                .width(600)
                .height(400)
                .controlsUseVisibility(true)
                .x(d3.scaleOrdinal())
                .xUnits(dc.units.ordinal)
                .margins({left: 80, top: 20, right: 10, bottom: 20})
                .brushOn(false)
                .clipPadding(10)
                .title(function(d) {
                  return d.key + '[' + this.layer + ']: ' + d.value[this.layer];
                })
                .dimension(tahunfakultasDim)
                .group(stackedGroup, "1", sel_stack('1'))
                .ordinalColors(['#ED403C','#F78125','#F8A51B','#FEF102','#6FBF45','#03A45E','#00ACAC','#0465B2','#21409A'])
                .renderLabel(true);

                judulchart.legend(dc.legend());

                dc.override(judulchart, 'legendables', function() {
                  var items = judulchart._legendables();
                  return items.reverse();
                });



                for(var i = 2; i<10; ++i)
                  judulchart.stack(stackedGroup, ''+i, sel_stack(i));

                judulchart.on('pretransition', function(chart) {
                  chart.selectAll('rect.bar')
                  .classed('stack-deselected', function(d) {
                      // display stack faded if the chart has filters AND
                      // the current stack is not one of them
                      var key = multikey(d.x, d.layer);
                      return chart.filter() && chart.filters().indexOf(key)===-1;
                    })
                  .on('click', function(d) {
                    chart.filter(multikey(d.x, d.layer));
                    dc.redrawAll();
                  });


                  chart.selectAll('.dc-legend-item text')
                  .text('')
                  .append('tspan')
                  .text(function(d, i) {
                    switch (i) {
                      case 0: return "FTI";
                      case 1: return "MIPA";
                      case 2: return "FH";
                      case 3: return "FIAI";
                      case 4: return "FK";
                      case 5: return "FTSP";
                      case 6: return "FE";
                      case 7: return "FPSB";
                      case 8: return "DP";
                    }
                  })
                  .append('tspan')
                  .attr('x', 100)
                  .attr('text-anchor', 'end')
                  .text(function(d) { return d.data; });
                });


                judulpie
                .width(550)
                .height(380)
                .controlsUseVisibility(true)
                .dimension(fakultasDim)
                .innerRadius(60)
                .externalRadiusPadding(60)
                .ordinalColors(['#21409A','#00ACAC','#ED403C','#03A45E','#F8A51B','#FEF102','#6FBF45','#0465B2','#F78125'])
                .group(fakultasGroup)
                .legend(dc.legend());

                judulpie.on('pretransition', function(chart) {
                  chart.selectAll('.dc-legend-item text')
                  .text('')
                  .append('tspan')
                  .text(function(d) { return d.name; })
                  .append('tspan')
                  .attr('x', 100)
                  .attr('text-anchor', 'end')
                  .text(function(d) { return d.data; });
                });

                dc.renderAll();
              });


            </script>

            {{-- data layanan --}}
            <script type="text/javascript">

              'use strict';
              var aktivitasTahunChart   = dc.pieChart("#aktivitastahun");
              var layananSubjekChart    = dc.rowChart("#layanansubjek");
    // var dataAll = dc.dataCount('.dataAll');

    var links = [];
    d3.json("{{url('layan')}}").then(function(json) {
      console.log(json);
      var numberFormat = d3.format('.2f');

      // json.forEach(function(d) {
      //  d.jurnal = +d.jurnal;
      //  d.tahun = +d.tahun;
      //  d.jumlah = +d.jumlah;
      // });
      function remove_empty_bins(source_group) {
        return {
          all:function () {
            return source_group.all().filter(function(d) {
              return d.value != 0;
            });
          }
        };
      }

      var ndx = crossfilter(json);
      var all = ndx.groupAll();
      var tahunDim = ndx.dimension(function(d) {return d.tahun;});
      var aktivitasDim = ndx.dimension(function(d) {return d.aktivitas;});
      var tahunGroup = tahunDim.group().reduceSum(function(d) {return d.data_layanan;});
      var aktivitasGroup = aktivitasDim.group().reduceSum(function(d) {return d.data_layanan;});

      // jurnalChart
      // .width(450)
      // .height(450)
      // .dimension(jurnalDim)
      // .group(jurnalGroup)
      // .controlsUseVisibility(true)
      // .x(d3.scale.ordinal())
      // .xUnits(dc.units.ordinal)
      // .elasticY(true)
      // .brushOn (true)
      // .renderLabel(true)
      // .yAxisLabel(" ");


      aktivitasTahunChart
      .width(550)
      .height(380)
      .slicesCap(10)
      .innerRadius(60)
      // .externalLabels(50)
      .externalRadiusPadding(60)
      .drawPaths(true)
      .dimension(tahunDim)
      .group(tahunGroup)
      .ordinalColors(['#011f4b','#03396c','#005b96','#6497b1','#b3cde0'])
      .legend(dc.legend());


      aktivitasTahunChart.on('pretransition', function(chart) {
        chart.selectAll('.dc-legend-item text')
        .text('')
        .append('tspan')
        .text(function(d) { return d.name; })
        .append('tspan')
        .attr('x', 150)
        .attr('text-anchor', 'end')
        .text(function(d) { return d.data; });
      });


      layananSubjekChart
      .width(500).height(200)
      .dimension(aktivitasDim)
      .group(aktivitasGroup)
      .ordinalColors(['#011f4b','#03396c','#005b96'])
      .elasticX(true);


      // dataAll /* dc.dataCount('.dc-data-count', 'chartGroup'); */
      // .dimension(ndx)
      // .group(all)
   //      // (_optional_) `.html` sets different html when some records or all records are selected.
   //      // `.html` replaces everything in the anchor with the html given using the following function.
   //      // `%filter-count` and `%total-count` are replaced with the values obtained.
   //      .html({
   //       some: '<strong>%filter-count</strong> selected out of <strong>%total-count</strong> records' +
   //       ' | <a href=\'javascript:dc.filterAll(); dc.renderAll();\'>Reset All</a>',
   //       all: 'All records selected. Please click on the graph to apply filters.'
   //      });

   dc.renderAll();

 });

</script>

{{-- data inventori eksemplar --}}
<script type="text/javascript">

  var eksemplarchart = dc.barChart("#eksemplarchart"), 
  eksemplarpie = dc.pieChart('#eksemplarpie');
  d3.json("{{url('inven')}}").then(function(experiments) {
    console.log(experiments);

    experiments.forEach(function(x) {
      x.data_eksemplar = +x.data_eksemplar;
    });

          // the way to combine multiple keys into one is domain-specific (and controversial)
          // array keys are risky but also valid sometimes, that would be
          // function multikey(x,y) {
          //     return [x,y];
          // }
          // function splitkey(k) {
          //     return k;
          // }
          function multikey(x,y) {
            return x + 'x' + y;
          }
          function splitkey(k) {
            return k.split('x');
          }
          function stack_second(group) {
            return {
              all: function() {
                var all = group.all(),
                m = {};
                      // build matrix from multikey/value pairs
                      all.forEach(function(kv) {
                        var ks = splitkey(kv.key);
                        m[ks[0]] = m[ks[0]] || {};
                        m[ks[0]][ks[1]] = kv.value;
                      });
                      // then produce multivalue key/value pairs
                      return Object.keys(m).map(function(k) {
                        return {key: k, value: m[k]};
                      });
                    }
                  };
                }
                
                function ubah (data) {

                  if (data == "FTI") {
                    return 1;
                  } else if (data == "MIPA") {
                    return 2;
                  } else if (data == "FH") {
                    return 3;
                  } else if (data == "FIAI") {
                    return 4;
                  } else if (data == "FK") {
                    return 5 ;
                  } else if (data == "FTSP") {
                    return 6;
                  } else if (data == "FE") {
                    return 7;
                  } else if (data == "FPSB") {
                    return 8;
                  } else if (data == "DP") {
                    return 9;
                  }
                };

                var ndx = crossfilter(experiments);

                var tahunfakultasDim = ndx.dimension(function(d) { return multikey(d.tahun, ubah(d.fakultas)); });
                var fakultasDim = ndx.dimension(function(d) {return d.fakultas;});
                var fakultasGroup = fakultasDim.group().reduceSum(function(d){return d.data_eksemplar;});
                var tahunfakultasGroup = tahunfakultasDim.group().reduceSum(function(d) {
                  return d.data_eksemplar;
                });
                var stackedGroup = stack_second(tahunfakultasGroup);
                var quantizejumlah = d3.scaleQuantize().domain(d3.extent(experiments, function(d) {
                  return d.data_eksemplar;
                })).range(['lowest', 'low', 'medium', 'high', 'highest']);


                var quantizejumlahDim = ndx.dimension(function(d) {
                  return quantizejumlah(d.data_eksemplar);
                }), quantizejumlahGroup = quantizejumlahDim.group();




                function sel_stack(i) {
                  return function(d) {
                    return d.value[i];
                  };
                }

                eksemplarchart
                .width(600)
                .height(400)
                .controlsUseVisibility(true)
                .x(d3.scaleOrdinal())
                .xUnits(dc.units.ordinal)
                .margins({left: 80, top: 20, right: 10, bottom: 20})
                .brushOn(false)
                .clipPadding(10)
                .title(function(d) {
                  return d.key + '[' + this.layer + ']: ' + d.value[this.layer];
                })
                .dimension(tahunfakultasDim)
                .group(stackedGroup, "1", sel_stack('1'))
                .ordinalColors(['#ED403C','#F78125','#F8A51B','#FEF102','#6FBF45','#03A45E','#00ACAC','#0465B2','#21409A'])
                .renderLabel(true);

                eksemplarchart.legend(dc.legend());

                dc.override(eksemplarchart, 'legendables', function() {
                  var items = eksemplarchart._legendables();
                  return items.reverse();
                });



                for(var i = 2; i<10; ++i)
                  eksemplarchart.stack(stackedGroup, ''+i, sel_stack(i));

                eksemplarchart.on('pretransition', function(chart) {
                  chart.selectAll('rect.bar')
                  .classed('stack-deselected', function(d) {
                      // display stack faded if the chart has filters AND
                      // the current stack is not one of them
                      var key = multikey(d.x, d.layer);
                      return chart.filter() && chart.filters().indexOf(key)===-1;
                    })
                  .on('click', function(d) {
                    chart.filter(multikey(d.x, d.layer));
                    dc.redrawAll();
                  });



                  chart.selectAll('.dc-legend-item text')
                  .text('')
                  .append('tspan')
                  .text(function(d, i) {
                    switch (i) {
                      case 0: return "FTI";
                      case 1: return "MIPA";
                      case 2: return "FH";
                      case 3: return "FIAI";
                      case 4: return "FK";
                      case 5: return "FTSP";
                      case 6: return "FE";
                      case 7: return "FPSB";
                      case 8: return "DP";
                    }
                  })
                  .append('tspan')
                  .attr('x', 100)
                  .attr('text-anchor', 'end')
                  .text(function(d) { return d.data; });

                  
                });


                eksemplarpie
                .width(550)
                .height(380)
                .controlsUseVisibility(true)
                .dimension(fakultasDim)
                .innerRadius(60)
                .externalRadiusPadding(60)
                .ordinalColors(['#21409A','#00ACAC','#ED403C','#F8A51B','#03A45E','#6FBF45','#FEF102','#0465B2','#F78125'])
                .group(fakultasGroup)
                .legend(dc.legend());

                eksemplarpie.on('pretransition', function(chart) {
                  chart.selectAll('.dc-legend-item text')
                  .text('')
                  .append('tspan')
                  .text(function(d) { return d.name; })
                  .append('tspan')
                  .attr('x', 100)
                  .attr('text-anchor', 'end')
                  .text(function(d) { return d.data; });
                });

                dc.renderAll();
              });


            </script>

            <script type="text/javascript" src="./dc/src/bootstrap.min.js"></script>

          </body>
          </html>
