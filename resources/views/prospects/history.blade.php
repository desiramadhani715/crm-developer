@extends('Layout/layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css" />
    <style>
        div.sales-activity {
            height: 400px;
            width: 500;
            overflow-y: scroll;
        }
    </style>
@endsection

@section('content')

<div class="be-content">
    <div class="page-head">
      <h2 class="page-head-title">History Prospect a.n {{$NamaProspect}}</h2>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb page-head-nav">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/prospects')}}">Prospect</a></li>
        </ol>
      </nav>
    </div>
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-lg-6">
              <div class="card card-contrast">
                <div class="card-header card-header-contrast card-header-featured">History Follow Up</div>
                <div class="card-body">
                  {{-- <div class="card-title">Prospect a.n {{$NamaProspect}}</div> --}}
                  <div class="card-body sales-activity">
                        <ul class="user-timeline user-timeline-compact">
                            @if (count($history) == 0)
                                <li>
                                    <div class="user-timeline-description">Belum ada aktivitas terbaru dari Sales</div>
                                </li>
                            @endif
                            @foreach ($history as $item)
                            <li>
                                <div class="user-timeline-date">{{$item->day}} {{$item->month}}  {{$item->hour}}:{{$item->minute}} </div>
                                <div class="user-timeline-title">{{$item->NamaSales}} Follow Up melalui {{$item->NamaMedia}}</div>
                            </li>
                            @endforeach
                        </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card card-contrast">
                <div class="card-header card-header-contrast card-header-featured">History Move</div>
                <div class="card-body">
                  <div class="card-body sales-activity">
                        <ul class="user-timeline user-timeline-compact">
                            @if (count($historyMove) == 0)
                                <li>
                                    <div class="user-timeline-description">Belum ada aktivitas Move dari Sistem</div>
                                </li>
                            @endif
                            @foreach ($historyMove as $item)
                            <li>
                                <div class="user-timeline-date">{{$item->day}} {{$item->month}}  {{$item->hour}}:{{$item->minute}} </div>
                                <div class="user-timeline-title">Prospect Move From Sales a.n {{$item->NamaSales}}</div>
                            </li>
                            @endforeach
                        </ul>
                  </div>
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
            App.init();
            App.dataTables();
        });
    </script>

@endsection
