'use strict';
var aktivitasTahunChart   = dc.pieChart("#aktivitastahun");
var layananSubjekChart    = dc.rowChart("#layanansubjek");
		// var dataAll = dc.dataCount('.dataAll');

		var links = [];
		d3.json("http://localhost:8000/layan").then(function(json) {
			console.log(json);
			var numberFormat = d3.format('.2f');

			// json.forEach(function(d) {
			// 	d.jurnal = +d.jurnal;
			// 	d.tahun = +d.tahun;
			// 	d.jumlah = +d.jumlah;
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
			.width(450)
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
			.ordinalColors(['#2c3258','#363244','#7e7a80'])
			.elasticX(true);


			// dataAll /* dc.dataCount('.dc-data-count', 'chartGroup'); */
			// .dimension(ndx)
			// .group(all)
   //      // (_optional_) `.html` sets different html when some records or all records are selected.
   //      // `.html` replaces everything in the anchor with the html given using the following function.
   //      // `%filter-count` and `%total-count` are replaced with the values obtained.
   //      .html({
   //      	some: '<strong>%filter-count</strong> selected out of <strong>%total-count</strong> records' +
   //      	' | <a href=\'javascript:dc.filterAll(); dc.renderAll();\'>Reset All</a>',
   //      	all: 'All records selected. Please click on the graph to apply filters.'
   //      });

   dc.renderAll();

});