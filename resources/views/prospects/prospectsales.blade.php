
@extends('Layout/layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css" />
    {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}" type="text/css" /> --}}
    <!-- Font Awesome -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    {{-- Data Filters --}}
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/select2/css/select2.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/bootstrap-slider/css/bootstrap-slider.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> --}}

@endsection

@section('content')

<div class="be-content">
    <div class="page-head mt-5 mt-lg-0">
        <div class="d-flex justify-content-between">
            <h2 class="page-head-title">Prospect Sales {{$NamaSales[0]->NamaSales}} </h2>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/prospects')}}">Prospects</a></li>
            </ol>
        </nav>

    </div>
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!--@if (session('status'))-->
                <!--<div class="alert alert-succsess alert-dismissible" role="alert">-->
                <!--    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>-->
                <!--    <div class="icon"><span class="mdi mdi-info-outline"></span></div>-->
                <!--    <div class="message"><strong> {{ session('status') }} </strong></div>-->
                <!--</div>-->
                <!--@endif-->
                @if (session('status'))
                  <div class="alert alert-contrast alert-success alert-dismissible" role="alert">
                    <div class="icon"><span class="mdi mdi-check"></span></div>
                    <div class="message">
                      <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button><strong>{{ session('status') }} </strong></div>
                    </div>
                  </div>
                @endif
                <div class="card card-table">
                    <div class="d-flex justify-content-between">
                        <div class="card-header">
                        </div>
                    </div>
                    <form action="{{url('prospects/sales')}}" method="POST" role="form">
                        @csrf
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-lg-4 table-filters pb-0 ">
                                                    <div class="filter-container">
                                                        <label class="control-label">Move to Sales :</label>
                                                        <div class="d-flex justify-content-between">
                                                            <input type="hidden" value="{{$KodeSales}}" name="KodeSalesPrev">
                                                            <select id="filter-Sales" class="select2 form-control" name="KodeSalesNext">
                                                                <option value="">All</option>
                                                                @foreach ($sales as $item)
                                                                <option value="{{$item->KodeSales}}">{{$item->NamaSales}}</option>
                                                                @endforeach
                                                            </select>
                                                            <button class="btn btn-space btn-secondary btn-big" style="background-color: #2A3F54;color:#fff;" type="submit" ><i class="fa fa-arrows"></i> Move </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="noSwipe">
                                <div class="container-fluid py-2 ">
                                    <table class="table table-striped table-hover be-table-responsive table-responsive " id="table1" border="1px">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="">
                                                    <div class="d-flex align-items-center">
                                                        <input class="form-check-input "  type="checkbox"  id="checkAll"><br>
                                                    </div>
                                                </th>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Nama & No. Hp</th>
                                                <th>Source</th>
                                                <th>Platform</th>
                                                <th>Campaign</th>
                                                <th>Project</th>
                                                <th>Agent & Sales</th>
                                                <th>Status</th>
                                                <th>Input Date</th>
                                                <th>Process Date</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prospect as $item)
                                            @if ($item->Status == 'New')
                                            <tr style="border-left: rgb(71, 149, 238) solid 16px;">
                                            @elseif($item->Status == 'Closing')
                                            <tr style="border-left: rgb(2, 185, 57) solid 16px;">
                                            @elseif($item->Status == 'Expired')
                                            <tr style="border-left: rgb(233, 140, 34) solid 16px;">
                                            @elseif($item->Status == 'Process')
                                            <tr style="border-left: rgb(214, 113, 201) solid 16px;">
                                            @elseif($item->Status == 'Not Interested')
                                            <tr style="border-left: red solid 16px;">
                                            @endif
                                                <td><input class="form-check-input" type="checkbox" value="{{$item->ProspectID}}" name="prospect[]" ><br></td>
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td class="text-center">{{$item->ProspectID}}</td>
                                                <td class="text-left">
                                                    <span style="color:#6F9CD3">{{$item->NamaProspect}}</span><br><span class="card-subtitle">{{$item->Hp}}</span>
                                                </td>
                                                <td class="text-center">{{$item->NamaSumber}}</td>
                                                <td class="text-center">{{$item->NamaPlatform}}</td>
                                                <td class="text-center"></td>
                                                <td class="text-center" data-project="{{$item->KodeProject}}">{{$item->KodeProject}}</td>
                                                <td class="text-left">
                                                    <span style="color:#6F9CD3">{{$item->KodeAgent}}</span><br><span class="card-subtitle">{{$item->NamaSales}}</span>
                                                </td>
                                                <td class="text-center">{{$item->Status}}</td>
                                                <td class="text-center">{{date('d-m-Y', strtotime($item->AddDate))}}</td>
                                                <td class="text-center">{{$item->Status == "New" ? "" : date('d-m-Y', strtotime($item->AcceptDate))}}</td>
                                                {{-- <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{url('prospects/edit/'.$item->ProspectID)}}"><button class="btn btn-rounded md-trigger mr-1" style="background-color: #2A3F54;color:#fff;"><i class="fa fa-eye"></i></button></a>
                                                        <form action="{{url('prospects/'.$item->ProspectID)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                            @method('delete')
                                                            @csrf
                                                            <button class="btn btn-rounded mr-1" style="background-color: #8A0512; color :#fff;" type="submit" name="del"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="container-fluid py-5">
                                <table style="margin-top: 30px;">
                                <tr><td style="background-color: rgb(71, 149, 238); width: 50px;"></td> <td>: New</td></tr>
                                <tr><td style="background-color: rgb(214, 113, 201); width: 50px;"></td> <td>: Process</td></tr>
                                <tr><td style="background-color: rgb(233, 140, 34);width: 50px;"></td> <td>: Expired</td></tr>
                                <tr><td style="background-color: rgb(2, 185, 57); width: 50px;"></td> <td>: Closing</td></tr>
                                <tr><td style="background-color: red; width: 50px;"></td> <td>: Not Interested</td></tr>
                                </table>
                            </div>
                        </div>
                    </form>
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
    <script src="{{asset('dist/html/assets/js/datatables-prospect.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //-initialize the javascript
            // App.init();
            App.dataTables();
        });
    </script>


    <script src="{{asset('dist/html/assets/lib/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/select2/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/bootstrap-slider/bootstrap-slider.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
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
    <script src="{{asset('dist/html/assets/js/app-table-filters.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/bs-custom-file-input/bs-custom-file-input.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/js/app-form-elements.js')}}" type="text/javascript"></script>
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            //-initialize the javascript
            App.init();
            App.tableFilters();
        });
    </script> --}}

    <script src="{{asset('dist/html/assets/lib/jquery.niftymodals/js/jquery.niftymodals.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $.fn.niftyModal('setDefaults',{
            overlaySelector: '.modal-overlay',
            contentSelector: '.modal-content',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show'
        });
        $("#checkAll").change(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection

