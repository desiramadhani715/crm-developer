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
        <h2 class="page-head-title">Analisis : Not Interested</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Not Interested</a></li>
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
