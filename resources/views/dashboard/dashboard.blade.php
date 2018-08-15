<!DOCTYPE html>
<html>
<head>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
	<link href="/dc/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="./dc/css/dc.css"/>
	<link href="navbar-top-fixed.css" rel="stylesheet">


	<title>Dashboard Library</title>
</head>
<body>


	<main class="container">

		<div class="row">
			<div class="col-sm-6">
				<div class="card border-primary mb-3">
					<div class="card-body">
						<h5 class="card-title text-center">Jumlah koleksi per jurnal</h5>

						<div id="jurnal" class="center-block">
							<div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
								<a href="javascript:jurnalChart.filterAll();dc.redrawAll();">reset</a>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card border-primary mb-3">
					<div class="card-body">
						<h5 class="card-title text-center">Jumlah koleksi jurnal per tahun</h5>

						<div id="tahun" class="row justify-content-center">
							<div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
								<a href="javascript:tahunChart.filterAll();dc.redrawAll();">reset</a>
							</div>

						</div>

					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="card border-primary mb-3">
					<div class="card-body">
						<h5 class="card-title text-center">Jumlah koleksi jurnal per tahun</h5>
						
						<div id="judul" class="row justify-content-center">
							<div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
								<a href="javascript:judulChart.filterAll();dc.redrawAll();">reset</a>
							</div>

						</div>
						
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="card border-primary mb-3">
					<div class="card-body">
						<h5 class="card-title text-center">Jumlah koleksi jurnal per tahun</h5>
						
						<div id="eksemplar" class="row justify-content-center">
							<div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
								<a href="javascript:eksemplarChart.filterAll();dc.redrawAll();">reset</a>
							</div>

						</div>
						
					</div>
				</div>
			</div>

		</div>
	</main>

	<script type="text/javascript" src="./dc/src/jquery.min.js"></script>
	<script type="text/javascript" src="./dc/src/bootstrap.min.js"></script>
	<script type="text/javascript" src="./dc/js/d3.js"></script>
	<script type="text/javascript" src="./dc/js/crossfilter.js"></script>
	<script type="text/javascript" src="./dc/js/dc.js"></script>
	<script type="text/javascript" src="./dc/chart/koleksi.js"></script>
	<script type="text/javascript" src="./dc/chart/inventori.js"></script>


</body>
</html>