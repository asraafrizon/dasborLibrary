<!DOCTYPE html>
<html lang="en">
<head>
  <title>dc.js - Stacked Bar Example</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/d3/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./d3/css/dc.css"/>
  <style>
  .dc-chart g.chart-body {
    clip-path: none;
  }
  .dc-chart rect.stack-deselected {
    opacity: 0.2;
  }
</style>
</head>
<body>

  <div class="container">
    <div id="test">
      <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
        <a href="javascript:chart.filterAll();dc.redrawAll();">reset</a>
      </div>
    </div>
    <div id="pie">
      <div class="reset" style="visibility: hidden;">range: <span class="filter"></span>
        <a href="javascript:pie.filterAll();dc.redrawAll();">reset</a>
      </div>
    </div>

    <script type="text/javascript" src="./d3/js/d3.js"></script>
    <script type="text/javascript" src="./d3/js/crossfilter.js"></script>
    <script type="text/javascript" src="./d3/js/dc.js"></script>
    <script type="text/javascript">

      var chart = dc.barChart("#test"), 
      pie = dc.pieChart('#pie');
      d3.json("http://localhost:8000/inven").then(function(experiments) {
        console.log(experiments);

        experiments.forEach(function(x) {
          x.judul_qty = +x.judul_qty;
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

                var ndx = crossfilter(experiments),
                  tahunfakultasDim = ndx.dimension(function(d) { return multikey(d.tahun, d.fakultas_id); }),
                  tahunfakultasGroup = tahunfakultasDim.group().reduceSum(function(d) {
                    return d.judul_qty;
                  }),
                  stackedGroup = stack_second(tahunfakultasGroup);
                    var quantizejumlah = d3.scaleQuantize().domain(d3.extent(experiments, function(d) {
                      return d.judul_qty;
                    })).range(['lowest', 'low', 'medium', 'high', 'highest']);


                    var quantizejumlahDim = ndx.dimension(function(d) {
                      return quantizejumlah(d.judul_qty);
                    }), quantizejumlahGroup = quantizejumlahDim.group();

                    function sel_stack(i) {
                      return function(d) {
                        return d.value[i];
                      };
                    }

                    chart
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
                    .renderLabel(true);

                    chart.legend(dc.legend());





                    for(var i = 2; i<9; ++i)
                      chart.stack(stackedGroup, ''+i, sel_stack(i));

                    chart.on('pretransition', function(chart) {
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
                          case 0: return "FTSP";
                          case 1: return "FH";
                          case 2: return "FMIPA";
                          case 3: return "FTI";
                          case 4: return "FPSB";
                          case 5: return "FK";
                          case 6: return "FIAI";
                          case 7: return "FE";
                        }
                      })
                      .append('tspan')
                      .attr('x', 100)
                      .attr('text-anchor', 'end')
                      .text(function(d) { return d.data; });
                    });


                    pie
                    .width(300)
                    .height(300)
                    .controlsUseVisibility(true)
                    .dimension(quantizejumlahDim)
                    .group(quantizejumlahGroup);

                    dc.renderAll();
                  });

                </script>

              </div>
            </body>
            </html>
