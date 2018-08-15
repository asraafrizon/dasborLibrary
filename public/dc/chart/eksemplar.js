      var eksemplarchart = dc.barChart("#eksemplarchart"), 
      eksemplarpie = dc.pieChart('#eksemplarpie');
      d3.json("http://localhost:8000/inven").then(function(experiments) {
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
                  }
                };

                var ndx = crossfilter(experiments);

                var tahunfakultasDim = ndx.dimension(function(d) { return multikey(d.tahun, ubah(d.fakultas)); });
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
                .margins({left: 80, top: 0, right: 10, bottom: 20})
                .brushOn(false)
                .clipPadding(10)
                .title(function(d) {
                  return d.key + '[' + this.layer + ']: ' + d.value[this.layer];
                })
                .dimension(tahunfakultasDim)
                .group(stackedGroup, "1", sel_stack('1'))
                .renderLabel(true);

                eksemplarchart.legend(dc.legend());





                for(var i = 2; i<9; ++i)
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
                    }
                  })
                  .append('tspan')
                  .attr('x', 100)
                  .attr('text-anchor', 'end')
                  .text(function(d) { return d.data; });
                });


                eksemplarpie
                .width(300)
                .height(300)
                .controlsUseVisibility(true)
                .dimension(quantizejumlahDim)
                .innerRadius(60)
                .ordinalColors(['#011f4b','#03396c','#005b96','#6497b1','#b3cde0'])
                .group(quantizejumlahGroup);

                dc.renderAll();
              });
