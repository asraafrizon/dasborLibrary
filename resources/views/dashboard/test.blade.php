
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
          {{-- <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Register</a></li> --}}
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
            <H4><strong>Range</strong></H4>
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
            <H4><strong>Judul</strong></H4>
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


      <div class="col-lg-6">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Range Data Eksemplar</strong></H4>
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

      <div class="col-lg-6">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Eksemplar</strong></H4>
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


      <div class="col-lg-6">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Aktivitas</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="aktivitastahun">

            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="chart-wrapper">
          <div class="chart-title">
            <H4><strong>Layanan</strong></H4>
          </div>
          <div class="chart-stage">
            <div id="layanansubjek">
              
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

{{--   <div class="container">

    <div class="row">
      <div class="col-6 col-md-6 text-center">
        <div class="row justify-content-center align-items-center">

          <h5 class="text-center">Jumlah koleksi per jurnal</h5>

          <div id="jurnal" class="text-center">

          </div>


        </div>
      </div>
      <div class="col-6 col-md-6 text-center">
        <div class="row justify-content-center align-items-center">

          <h5 class="title text-center">Jumlah koleksi jurnal per tahun</h5>

          <div id="tahun" class="text-center">
            <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
              <a href="javascript:tahunChart.filterAll();dc.redrawAll();">reset</a>
            </div>
          </div>


        </div>
      </div>

      <div class="col-6 col-md-6 text-center">
        <div class="row justify-content-center align-items-center">

          <h5>Data Koleksi menurut judul per Fakultas</h5>

          <div id="test">
           <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
            <a href="javascript:chart.filterAll();dc.redrawAll();">reset</a>
          </div>
        </div>


      </div>
    </div>

    <div class="col-6 col-md-6 text-center">
      <div class="row justify-content-center align-items-center">
        <h5>Range</h5>
        <div class="reset" style="visibility: hidden;">selected: <span class="filter"></span>
          <a href="javascript:pie.filterAll();dc.redrawAll();">reset</a>
        </div>
        <div id="pie"></div>

      </div>
    </div>

    <div class="col-6 col-md-6 text-center">
      <div class="row justify-content-center align-items-center">
        <h5 class="text-center">Jumlah koleksi jurnal per tahun</h5>

        <div id="aktivitastahun"></div>

      </div>
    </div>

    <div class="col-6 col-md-6 text-center">
      <div class="row justify-content-center align-items-center">
        <h5 class="title text-center">Jumlah koleksi jurnal per tahun</h5>

        <div id="layanansubjek"></div>

      </div>
    </div>

  </div>
</div> --}}

<script type="text/javascript" src="./dc/src/jquery.min.js"></script>

<script type="text/javascript" src="./d3/js/d3.js"></script>
<script type="text/javascript" src="./d3/js/crossfilter.js"></script>
<script type="text/javascript" src="./d3/js/dc.js"></script>
<script type="text/javascript" src="./dc/chart/koleksi.js"></script>
{{-- <script type="text/javascript" src="./dc/chart/inventori.js"></script> --}}
<script type="text/javascript" src="./dc/chart/statistik.js"></script>
<script type="text/javascript" src="./dc/chart/layanan.js"></script>
<script type="text/javascript" src="./dc/chart/eksemplar.js"></script>

    <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
      {{--    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> --}}
      {{-- <script src="../../assets/js/vendor/popper.min.js"></script> --}}


      <script type="text/javascript" src="./dc/src/bootstrap.min.js"></script>
      
    </body>
    </html>
