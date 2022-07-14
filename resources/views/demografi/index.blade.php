@extends('Layout/layout')

@section('header')
<link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css" />
@endsection

@section('content')
<div class="be-content">
    <div class="page-head">
        <div class="d-flex justify-content-between">
            <h2 class="page-head-title">Data Demografi Konsumen</h2>
            <div class="d-flex justify-content-end"><button onclick="print()" class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-print"></i>Print</button>
            </div>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/demografi')}}">Demografi Konsumen</a></li>
            </ol>
        </nav>
    </div>
    <div class="main-content container-fluid">
        <div class="row d-block d-sm-none">
            <div class="col">
                <div class="d-flex justify-content-end"><button onclick="print()" class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-print"></i>Print</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
              <div class="card">
                <div class="card-header">Usia</div>
                <div class="card-body">
                    <div id="age"></div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                  <div class="card-header">Jenis Kelamin</div>
                  <div class="card-body">
                    <div id="gender"></div>
                  </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4 mb-5" style="background-color: #fff; border : 0 px;">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                          <div id="penghasilan"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-header">Tempat Tinggal
                  {{-- <div class="tools dropdown"><span class="icon mdi mdi-download"></span><a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"><span class="icon mdi mdi-more-vert"></span></a>
                    <div class="dropdown-menu" role="menu"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Separated link</a>
                    </div>
                  </div> --}}
                </div>
                <div class="card-body">
                  <table class="table table-sm table-hover table-bordered table-striped">
                    <thead>
                      <tr >
                        <th style="width: 10px">No</th>
                        <th >Tempat Tinggal</th>
                        <th>Total</th>
                        <th>Persentase</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($objectTempatTinggal as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->prospect}}</td>
                                <td>{{$item->persentasi}} %</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="font-size: 20px"><strong>{{$prospectTinggal}}</strong>
                                <small style='color:#999;'><br>% of Total:<br>{{$persentasiTempatTinggal}} % ({{$total_leads}})</small>
                            </td>
                            <td>100 %</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-header">Tempat Kerja
                  {{-- <div class="tools dropdown"><span class="icon mdi mdi-download"></span><a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"><span class="icon mdi mdi-more-vert"></span></a>
                    <div class="dropdown-menu" role="menu"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Separated link</a>
                    </div>
                  </div> --}}
                </div>
                <div class="card-body">
                  <table class="table table-sm table-hover table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th class="">Tempat Kerja</th>
                        <th>Total</th>
                        <th>Persentase</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($objectTempatKerja as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->prospect}}</td>
                                <td>{{$item->persentasi}} %</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="font-size: 20px"><strong>{{$prospectKerja}}</strong>
                                <small style='color:#999;'><br>% of Total:<br>{{$persentasiTempatKerja}} % ({{$total_leads}})</small>
                            </td>
                            <td>100 %</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-header">Pekerjaan
                  {{-- <div class="tools dropdown"><span class="icon mdi mdi-download"></span><a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"><span class="icon mdi mdi-more-vert"></span></a>
                    <div class="dropdown-menu" role="menu"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Separated link</a>
                    </div>
                  </div> --}}
                </div>
                <div class="card-body">
                  <table class="table table-sm table-hover table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Pekerjaan</th>
                        <th>Total</th>
                        <th>Persentase</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($objectTempatPekerjaan as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->prospect}}</td>
                                <td>{{$item->persentasi}} %</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="font-size: 20px"><strong>{{$prospectPekerjaan}}</strong>
                                <small style='color:#999;'><br>% of Total:<br>{{$persentasiTempatPekerjaan}} % ({{$total_leads}})</small>
                            </td>
                            <td>100 %</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script src="{{asset('dist/html/assets/lib/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/js/app.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net/js/jquery.dataTables.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-bs4/js/dataTables.bootstrap4.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-buttons/js/dataTables.buttons.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-buttons/js/buttons.flash.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/jszip/jszip.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/pdfmake/pdfmake.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/pdfmake/vfs_fonts.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-buttons/js/buttons.colVis.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-buttons/js/buttons.print.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-buttons/js/buttons.html5.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-responsive/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datatables/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/js/app-tables-datatables.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //-initialize the javascript
            // App.init();
            App.dataTables();
        });
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    {{-- <script src="https://code.highcharts.com/modules/exporting.js"></script> --}}
    {{-- <script src="https://code.highcharts.com/modules/export-data.js"></script> --}}
    {{-- <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
    <script>
        // Build the chart
        Highcharts.chart('age', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Prospect Berdasarkan Usia'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y} Orang</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: ''
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: {!!JSON_encode($usia)!!}
            }]
        });
    </script>
    <script>
        // Make monochrome colors
        var pieColors = (function () {
            var colors = [],
                base = Highcharts.getOptions().colors[0],
                i;

            for (i = 0; i < 10; i += 1) {
                // Start out with a darkened base color (negative brighten), and end
                // up with a much brighter color
                colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
            }
            return colors;
        }());

        // Build the chart
        Highcharts.chart('gender', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Prospect Berdasarkan Jenis Kelamin'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b> ({point.percentage:.1f})%'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors: pieColors,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                        distance: -50,
                        filter: {
                            property: 'percentage',
                            operator: '>',
                            value: 4
                        }
                    }
                }
            },
            series: [{
                name: 'Prospect ',
                data: {!!JSON_encode($gender)!!}
            }]
        });

    </script>
    <script>
        Highcharts.chart('penghasilan', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Rata-rata Penghasilan Prospect'
            },
            subtitle: {
                text: '{{Auth::user()->NamaPT}}'
            },
            xAxis: {
                categories:
                    {!!JSON_encode($range_penghasilan)!!}
                ,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Prospect'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">Prospect : </td>' +
                    '<td style="padding:0"><b>{point.y} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Penghasilan',
                data: {!!JSON_encode($data_total)!!}



            }]
        });
    </script>
@endsection
