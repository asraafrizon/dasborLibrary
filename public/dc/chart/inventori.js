'use strict';
var judulChart   = dc.barChart("#judul");
var eksemplarChart    = dc.pieChart("#eksemplar");
		// var dataAll = dc.dataCount('.dataAll');

		var links = [];
		d3.json("http://localhost:8000/inven").then(function(json) {
			// if(error) return console.warn(error);
			links = json;
			console.log(links);
			var numberFormat = d3.format('.2f');

			// json.forEach(function(x) {
			// 	x.data_judul = +x.data_judul;
			// 	x.data_eksemplar = +x.data_eksemplar;
			// });

			var ndx = crossfilter(links);
			var all = ndx.groupAll();
			var fakultasDim = ndx.dimension(function(d) {return d.fakultas;});
			var fakultasGroup = fakultasDim.group().reduceSum(function(d) {return d.data_judul;});
			var tahunDim = ndx.dimension(function(d) {return d.tahun;});
			var tahunGroup = tahunDim.group().reduceSum(function(d) {return d.data_judul;});

			judulChart
			.width(480)
			.height(340)
			.dimension(tahunDim)
			.group(tahunGroup)
			.controlsUseVisibility(true)
			.x(d3.scaleOrdinal())
			.xUnits(dc.units.ordinal)
			.elasticY(true)
			.brushOn (true)
			.renderLabel(true)
			.yAxisLabel(" ");


			eksemplarChart
			.width(550)
			.height(380)
			.slicesCap(8)
			.innerRadius(60)

			// .externalLabels(35)
			.externalRadiusPadding(60)
			.drawPaths(true)
			.dimension(fakultasDim)
			.group(fakultasGroup)
			.legend(dc.legend());


			eksemplarChart.on('pretransition', function(chart) {
				chart.selectAll('.dc-legend-item text')
				.text('')
				.append('tspan')
				.text(function(d) { return d.name; })
				.append('tspan')
				.attr('x', 150)
				.attr('text-anchor', 'end')
				.text(function(d) { return d.data; });
			});


			// eksemplarChart
			// .width(480)
			// .height(340)
			// .dimension(fakultasDim)
			// .group(judulGroup)
			// .controlsUseVisibility(true)
			// .x(d3.scale.ordinal())
			// .xUnits(dc.units.ordinal)
			// .elasticY(true)
			// .brushOn (true)
			// .renderLabel(true)
			// .yAxisLabel(" ");

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