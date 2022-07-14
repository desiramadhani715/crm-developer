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
      <h3 class="text-center">No Data Available</h3>
    </div>
  </div>
  @endsection

  @section('footer')
      <script src="{{asset('dist/html/assets/lib/jquery/jquery.min.js')}}" type="text/javascript"></script>
      <script src="{{asset('dist/html/assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js')}}" type="text/javascript"></script>
      <script src="{{asset('dist/html/assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
      <script src="{{asset('dist/html/assets/js/app.js')}}" type="text/javascript"></script>
  @endsection
