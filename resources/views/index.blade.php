@extends('Layout/layout')

@section('header')
    <script src="{{asset('css/charts.css')}}"></script>
    <style>
        div.sales-activity {
            height: 400px;
            width: 500;
            overflow-y: scroll;
        }
    </style>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

@endsection

@section('content')

<div class="be-content">

  <div class="main-content container-fluid">
    <div class="row">
      <div class="col-12 col-lg-6 col-xl-3">
        <a href="{{url('prospects')}}" style="color: black">
          <div class="widget widget-tile">
            {{-- <div class="chart sparkline" id="spark1"></div> --}}
            <div class="d-flex align-items-center justify-content-between">
                <div class="result" data-sparkline={{ json_encode($data_total2)}}></div>
                <div class="data-info">
                    <div class="desc" >Total Leads</div>
                    @foreach ($total_leads as $item)
                        <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span class="number"  data-toggle="counter" data-end="{{$item->total_leads}}">{{$item->total_leads}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-12 col-lg-6 col-xl-3">
        <a href="{{url('prospect/Process')}}" style="color: black">
          <div class="widget widget-tile">
              {{-- <div class="chart sparkline" id="spark2"></div> --}}
            <div class="d-flex align-items-center justify-content-between">
              <div class="result" data-sparkline="{{ json_encode($data_proses)}};column"></div>
              <div class="data-info">
                  <div class="desc" >In Process</div>
                  @foreach ($inprocess as $item)
                  <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span><span class="number"  data-toggle="counter" data-end="{{$item->inprocess}}"></span>
                  </div>
                  @endforeach
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-12 col-lg-6 col-xl-3">
        <a href="{{url('prospect/Closing')}}" style="color: black">
          <div class="widget widget-tile">
              {{-- <div class="chart sparkline" id="spark3"></div> --}}
            <div class="d-flex align-items-center justify-content-between">
                <div class="result" data-sparkline="{{ json_encode($data_closing)}}"></div>
                <div class="data-info">
                    <div class="desc" >Closing</div>
                    @foreach ($closing as $item)
                    <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span class="number" style="color:black" data-toggle="counter" data-end="{{$item->closing}}"></span>
                    </div>
                    @endforeach
                </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-12 col-lg-6 col-xl-3">
        <a href="{{url('prospect/NotInterested')}}" style="color: black">
          <div class="widget widget-tile">
              {{-- <div class="chart sparkline" id="spark4"></div> --}}
            <div class="d-flex align-items-center justify-content-between">
                <div class="result" data-sparkline="{{ json_encode($data_notInterested)}}"></div>
                <div class="data-info">
                    <div class="desc" >Not Interested</div>
                    @foreach ($notInterested as $item)
                    <div class="value"><span class="indicator indicator-negative mdi mdi-chevron-down"></span><span class="number" data-toggle="counter" data-end="{{$item->notinterested}}"></span>
                    </div>
                    @endforeach
                </div>
            </div>
          </div>
        </a>
      </div>
    </div>
     {{-- plugin  --}}
     <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header card-header-divider">
                <div class="d-flex justify-content-between">
                    <div class="col-4">
                        <div class="tools"></div><span class="title">Prospect Chart</span>
                        <span class="card-subtitle">This is a line chart of Prospect</span>

                    </div>
                    <div class="col-4">
                        <form action="{{url('/')}}" class="d-flex justify-content-between" method="POST" role="form">
                            @csrf
                            <select id="filter-chart" class="select2 form-control" name="bulan">
                                <option value="">Bulan</option>
                                {{-- <option value="this_month">This Month</option>
                                <option value="last_month">Last Month</option> --}}
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            @error('bulan')
                            <span class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</span>
                            @enderror
                            <select id="filter-chart" class="select2 form-control" name="tahun">
                                <option value="">Tahun</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                            </select>
                            @error('tahun')
                            <span class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="btn btn-space active " style="background-color: #2A3F54;color:#fff;padding:8px;">Send</button>
                        </form>
                    </div>
                  </div>

                </div>
            <div class="card-body mx-0">
              {{-- <canvas id="line-chart"></canvas> --}}
              {{-- <div class="card"> --}}
                  <div id="chartProspect" style="margin-right: 50px;"></div>

              {{-- </div> --}}
            </div>
          </div>
        </div>
      </div>
     <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header card-header-divider">
              <div class="tools"><span class="icon mdi mdi-chevron-down"></span><span class="icon mdi mdi-refresh-sync"></span><span class="icon mdi mdi-close"></span></div><span class="title">Platform Chart</span><span class="card-subtitle">This is a bar chart of Prospect by Platform</span>
            </div>
            <div class="card-body">
              {{-- <canvas id="line-chart"></canvas> --}}
              <div id="Platform">

               </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-header card-header-divider">
              <div class="tools"><span class="icon mdi mdi-chevron-down"></span><span class="icon mdi mdi-refresh-sync"></span><span class="icon mdi mdi-close"></span></div><span class="title">Source Chart</span><span class="card-subtitle">This is a bar chart of Prospect by Source</span>
            </div>
            <div class="card-body">
              {{-- <canvas id="line-chart"></canvas> --}}
              <div id="Source">

               </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card pb-5">
                <div class="card-header">Sales Activity</div><hr style="background-color: #f6c163" class="mx-4">
                <div class="card-body sales-activity">
                    <ul class="user-timeline user-timeline-compact">
                        @if (count($history) == 0)
                            <li>
                                <div class="user-timeline-description">Belum ada aktivitas terbaru dari Sales</div>
                            </li>
                        @endif
                        @foreach ($history as $item)
                        <li >
                            <div class="user-timeline-date" style="color: #f6c163">{{$item->day}} {{$item->month}}  {{$item->hour}}:{{$item->minute}} </div>
                            <div class="user-timeline-title">{{$item->SubjectDev}}</div>
                            <div class="user-timeline-description">{{$item->NotesDev}}</div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <hr style="background-color: #f6c163" class="mx-4">
            </div>
        </div>
    </div>
    @foreach ($data as $item)
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12">
          <div class="widget widget-fullwidth be-loading">
            <div class="widget-head">
              <div class="tools">
                <div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="icon mdi mdi-more-vert d-inline-block d-md-none"></span></a>
                  <div class="dropdown-menu" role="menu"><a class="dropdown-item" href="#">Week</a><a class="dropdown-item" href="#">Month</a><a class="dropdown-item" href="#">Year</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Today</a>
                  </div>
                </div><span class="icon mdi mdi-chevron-down"></span><span class="icon toggle-loading mdi mdi-refresh-sync"></span><span class="icon mdi mdi-close"></span>
              </div>
              <div class="button-toolbar d-none d-md-block">
              </div><span class="title">{{$item->NamaProject}}</span>
            </div>
            <div class="widget-chart-container">
                <div class="row">
                    <div class="col">
                      <div class="card">
                        <div class="card-body">
                          <table class="table table-sm table-hover table-bordered table-striped">
                            <thead>
                              <tr>
                                <th></th>
                                @foreach ($item->agent as $itemagent)
                                <th class="text-center">{{$itemagent->KodeAgent}}</th>
                                @endforeach
                                <th class="text-center">Total</th>
                                <th class="text-center">Persentase</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Total Leads</strong></td>
                                    @foreach ($item->agent as $itemagent)
                                        @foreach ($itemagent->leads as $leadstotal)
                                        <th class="text-center">{{$leadstotal->total}}</th>
                                        @endforeach
                                    @endforeach
                                    <td class="text-center">{{$item->leadsProject}}</td>
                                    <td class="text-center">100 %</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="text-left"><strong>New</strong></td>
                                    @foreach ($item->agent as $itemagent)
                                        @foreach ($itemagent->leadsNew as $leadstotal)
                                        <th class="text-center">{{$leadstotal->total}}</th>
                                        @endforeach
                                    @endforeach
                                    <td class="text-center">{{$item->leadsNewTotal}}</td>
                                    @if ($item->leadsNewTotal == 0)
                                        <td class="text-center">0 %</td>
                                    @else
                                    <td class="text-center">{{round($item->leadsNewTotal/$item->leadsProject * 100,2)}} %</td>
                                    @endif
                                </tr>
                                <tr class="text-center">
                                    <td class="text-left"><strong>Process</strong></td>
                                    @foreach ($item->agent as $itemagent)
                                        @foreach ($itemagent->leadsProcess as $leadstotal)
                                        <th class="text-center">{{$leadstotal->total}}</th>
                                        @endforeach
                                    @endforeach
                                    <td class="text-center">{{$item->leadsProcessTotal}}</td>
                                    @if ($item->leadsProcessTotal == 0)
                                        <td class="text-center">0 %</td>
                                    @else
                                        <td class="text-center">{{round($item->leadsProcessTotal/$item->leadsProject * 100,2)}} %</td>
                                    @endif
                                </tr>
                                <tr class="text-center">
                                    <td class="text-left"><strong>Closing</strong></td>
                                    @foreach ($item->agent as $itemagent)
                                        @foreach ($itemagent->leadsClosing as $leadstotal)
                                        <th class="text-center">{{$leadstotal->total}}</th>
                                        @endforeach
                                    @endforeach
                                    <td class="text-center">{{$item->leadsClosingTotal}}</td>
                                    @if ($item->leadsClosingTotal == 0)
                                        <td class="text-center">0 %</td>
                                    @else
                                        <td class="text-center">{{round($item->leadsClosingTotal/$item->leadsProject * 100,2)}} %</td>
                                    @endif
                                </tr>
                                <tr class="text-center">
                                    <td class="text-left"><strong>Not Interested</strong></td>
                                    @foreach ($item->agent as $itemagent)
                                        @foreach ($itemagent->leadsNotInterested as $leadstotal)
                                        <th class="text-center">{{$leadstotal->total}}</th>
                                        @endforeach
                                    @endforeach
                                    <td class="text-center">{{$item->leadsNotInterestedTotal}}</td>
                                    @if ($item->leadsNotInterestedTotal == 0)
                                        <td class="text-center">0 %</td>
                                    @else
                                        <td class="text-center">{{round($item->leadsNotInterestedTotal/$item->leadsProject * 100,2)}} %</td>
                                    @endif
                                </tr>
                                <tr class="text-center">
                                    <td class="text-left"><strong>Expired</strong></td>
                                    @foreach ($item->agent as $itemagent)
                                        @foreach ($itemagent->leadsExpired as $leadstotal)
                                        <th class="text-center">{{$leadstotal->total}}</th>
                                        @endforeach
                                    @endforeach
                                    <td class="text-center">{{$item->leadsExpiredTotal}}</td>
                                    @if ($item->leadsExpiredTotal == 0)
                                        <td class="text-center">0 %</td>
                                    @else
                                        <td class="text-center">{{round($item->leadsExpiredTotal/$item->leadsProject * 100,2)}} %</td>
                                    @endif
                                </tr>
                            </tbody>
                          </table>
  
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    @endforeach
    


  </div>
</div>
@endsection

@section('footer')
    <script src="{{asset('dist/html/assets/lib/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/js/app.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/chartjs/Chart.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/js/app-charts-chartjs.js')}}" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            -initialize the javascript
            App.init();
            // App.ChartJs();
            var  element = document.getElementById("menu");
            var paragraf = document.querySelectorAll(".left-sidebar-spacer .menu");
            element.onclick = function(){
                paragraf[1].classList.add("open");
            }
        });
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Day');
            data.addColumn('number', 'All Total {!!JSON_encode($total_all)!!} Prospect');
            data.addColumn('number', 'Digital Source Total {!!JSON_encode($total_mkt)!!} Prospect');
            data.addColumn('number', 'Sales Total {!!JSON_encode($total_sales)!!} Prospect');

            data.addRows(
                {!!JSON_encode($result)!!}
            );

            var options = {
                chart: {
                title: 'Leads',
                subtitle: '{{Auth::user()->NamaPT}}'
                },
                curveType: 'function',
                tooltip: {
                    isHtml: true,
                    valueSuffix: ' Prospect'
                },
                // width: 900,
                height: 500,
                // legend: { position: 'bottom' }
            };

            // var chart = new google.charts.Line(document.getElementById('chartProspect'));
            var chart = new google.visualization.LineChart(document.getElementById('chartProspect'));

            // chart.draw(data, google.charts.Line.convertOptions(options));
            chart.draw(data, options);
        }
    </script>

    <script >
         // Chart Platform
         Highcharts.chart('Platform', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Prospect by Platform'
            },
            subtitle: {
                text: '{{Auth::user()->NamaPT}}'
            },
            xAxis: {
                categories: {!!JSON_encode($namaPlatform)!!},
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Prospects'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Total Leads',
                data: {!!JSON_encode($total_platform)!!},
                color: '#f7a35c'
            }]
        });
    </script>

    <script>
      // Chart Source
        Highcharts.chart('Source', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Prospect by Source'
            },
            subtitle: {
                text: '{{Auth::user()->NamaPT}}'
            },
            xAxis: {
                categories: {!!JSON_encode($namasource)!!},
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Prospects'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Total Leads',
                data: {!!JSON_encode($total_source)!!},
                color: '#f7a35c'
            }]
        });
    </script>

    <script>
        Highcharts.SparkLine = function(a, b, c) {
            const hasRenderToArg = typeof a === 'string' || a.nodeName;
            let options = arguments[hasRenderToArg ? 1 : 0];
            const defaultOptions = {
                chart: {
                    renderTo: (options.chart && options.chart.renderTo) || (hasRenderToArg && a),
                    backgroundColor: null,
                    borderWidth: 0,
                    type: 'area',
                    margin: [2, 0, 2, 0],
                    width: 120,
                    height: 20,
                    style: {
                        overflow: 'visible'
                    },
                    // small optimalization, saves 1-2 ms each sparkline
                    skipClone: true
                },
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    title: {
                        text: null
                    },
                    startOnTick: false,
                    endOnTick: false,
                    tickPositions: []
                },
                yAxis: {
                    endOnTick: false,
                    startOnTick: false,
                    labels: {
                        enabled: false
                    },
                    title: {
                        text: null
                    },
                    tickPositions: [0]
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    hideDelay: 0,
                    outside: true,
                    shared: true
                },
                plotOptions: {
                    series: {
                        animation: false,
                        lineWidth: 1,
                        shadow: false,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        marker: {
                            radius: 1,
                            states: {
                                hover: {
                                    radius: 2
                                }
                            }
                        },
                        fillOpacity: 0.25
                    },
                    column: {
                        negativeColor: '#910000',
                        borderColor: 'silver'
                    }
                }
            };

            options = Highcharts.merge(defaultOptions, options);

            return hasRenderToArg ?
                new Highcharts.Chart(a, options, c) :
                new Highcharts.Chart(options, b);
        };

        const start = +new Date(),
            tds = Array.from(document.querySelectorAll('.result[data-sparkline]')),
            fullLen = tds.length;

        let n = 0;

        function doChunk() {
            const time = +new Date(),
                len = tds.length;

            for (let i = 0; i < len; i += 1) {
                const td = tds[i];
                const stringdata = td.dataset.sparkline;
                const arr = stringdata.split(';');
                const data = arr[0].split(',').map(parseFloat);
                const chart = {};

                if (arr[1]) {
                    chart.type = arr[1];
                    Highcharts.SparkLine(td, {
                        series: [{
                            data: data,
                            pointStart: 0,
                            color: 'rgb(214, 113, 201)',
                        }],
                        tooltip: {
                            headerFormat: '<span style="font-size: 10px">' + td.parentElement.querySelector('.result').innerText,
                            pointFormat: '<b>{point.y}</b> Prospects'
                        },
                        chart: chart
                    });

                }else{

                    Highcharts.SparkLine(td, {
                            series: [{
                                data: data,
                                pointStart: 0,
                                color: '#f7a35c',
                            }],
                            tooltip: {
                                headerFormat: '<span style="font-size: 10px">' + td.parentElement.querySelector('.result').innerText,
                                pointFormat: '<b>{point.y}</b> Prospects'
                            },
                            chart: chart
                        });


                }
                    n += 1;
            }
        }
        doChunk();
    </script>


@endsection
