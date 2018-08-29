'use strict';
var jurnalChart   = dc.pieChart("#jurnal");
var tahunChart    = dc.barChart("#tahun");
		// var dataAll = dc.dataCount('.dataAll');

		var links = [];
		d3.json("http://localhost:8000/koleks").then(function(json) {
			console.log(json);
			var numberFormat = d3.format('.2f');

			// json.forEach(function(d) {
			// 	d.jurnal = +d.jurnal;
			// 	d.tahun = +d.tahun;
			// 	d.jumlah = +d.jumlah;
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
   //      	some: '<strong>%filter-count</strong> selected out of <strong>%total-count</strong> records' +
   //      	' | <a href=\'javascript:dc.filterAll(); dc.renderAll();\'>Reset All</a>',
   //      	all: 'All records selected. Please click on the graph to apply filters.'
   //      });

   dc.renderAll();

});