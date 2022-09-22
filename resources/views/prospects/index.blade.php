
@extends('Layout/layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css" />
    <!-- Font Awesome -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    {{-- Data Filters --}}
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/select2/css/select2.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/bootstrap-slider/css/bootstrap-slider.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> --}}
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
    <div class="page-head mt-5 mt-lg-0">
        <div class="d-flex justify-content-between">
            <h2 class="page-head-title">Prospect Table</h2>
            <div class="d-flex justify-content-end">
                @foreach ($project as $item)
                    @if ($item->KodeProject == "PPR")
                    <a href="{{url('prospects/sewa/create')}}"><button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus-circle-o mb-1"></i>Add Rent</button></a>
                    @endif
                @endforeach
                <a href="{{url('prospects/create')}}"><button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus-circle-o mb-1"></i>Add New</button></a>
                <a href="{{route('prospect.create-manual')}}"><button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus-circle-o mb-1"></i>Add Manual</button></a>
                <a href="{{url('prospects/download')}}"><button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-download"></i>Download</button></a>
            </div>
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
                @if (session('alert'))
                  <div class="alert alert-contrast alert-success alert-dismissible" role="alert">
                    <div class="icon"><span class="mdi mdi-check"></span></div>
                    <div class="message">
                      <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button><strong>{{ session('alert') }} </strong></div>
                    </div>
                  </div>
                @endif
                <div class="card card-table">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-end d-block d-sm-none mt-4 mr-1">
                            @foreach ($project as $item)
                                @if ($item->KodeProject == "PPR")
                                <a href="{{url('prospects/create')}}"><button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus-circle-o mb-1"></i>Add Sewa</button></a>
                                @endif
                            @endforeach
                            <a href="{{url('prospects/create')}}"><button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus-circle-o mb-1"></i>Add New</button></a>
                            <a href="{{route('prospect.create-manual')}}"><button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus-circle-o mb-1"></i>Add Manual</button></a>
                            <a href="{{url('prospects/download')}}"><button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-download"></i>Download</button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{url('prospects')}}" method="POST" role="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-lg-3 table-filters pb-0 ">
                                                <div class="filter-container">
                                                    <label class="control-label">Project</label>
                                                    <select id="KodeProject" class="select2 form-control" name="project">
                                                        <option value="">All</option>
                                                        @foreach ($project as $item)
                                                        <option value="{{$item->KodeProject}}">{{$item->KodeProject}} - {{$item->NamaProject}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 table-filters ">
                                                <div class="filter-container">
                                                    <label class="control-label">Agent</label>
                                                    <select id="KodeAgent" class="select2 form-control" name="agent">
                                                        <option value="">All</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 table-filters ">
                                                <div class="filter-container">
                                                    <label class="control-label">Sales</label>
                                                    <select id="KodeSales" class="select2 form-control" name="sales">
                                                        <option value="">All</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 table-filters ">
                                                <div class="filter-container">
                                                    <label class="control-label">Platform</label>
                                                    <select id="filter-Platform" class="select2 form-control" name="Platform">
                                                        <option value="">All</option>
                                                        @foreach ($platform as $item)
                                                        <option value="{{$item->KodePlatform}}">{{$item->NamaPlatform}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-3 table-filters pb-0 ">
                                                <div class="filter-container">
                                                    <label class="control-label">Source</label>
                                                    <select id="filter-Source" class="select2 form-control" name="Source">
                                                        <option value="">All</option>
                                                        @foreach ($source as $item)
                                                        <option value="{{$item->SumberDataID}}">{{$item->NamaSumber}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2 table-filters pb-0 ">
                                                <div class="filter-container">
                                                    <label class="control-label">Status</label>
                                                    <select id="filter-status" class="select2 form-control" name="status">
                                                        <option value="{{old('status')}}">All</option>
                                                        @foreach ($status as $item)
                                                        <option value="{{$item->KetStatus}}">{{$item->KetStatus}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2 table-filters pb-0 ">
                                                <div class="filter-container">
                                                    <label class="control-label">Level</label>
                                                    <select id="filter-level" class="select2 form-control" name="level">
                                                        <option value="">All</option>
                                                        <option value="Auto System">Makuta</option>
                                                        <option value="Sales">Sales</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2 table-filters ">
                                                <div class="filter-container">
                                                    <label class="control-label">Prospect Hot</label>
                                                    <select id="filter-Source" class="select2 form-control" name="Hot">
                                                        <option value="">All</option>
                                                        <option value="1">Hot</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 table-filters pb-0 ">
                                                <div class="filter-container">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="control-label">Since:</label>
                                                            <input class="form-control form-control-sm datetimepicker" name="dateSince" data-min-view="2" data-date-format="yyyy-mm-dd" autocomplete="off">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="control-label">To:</label>
                                                            <input class="form-control form-control-sm datetimepicker" name="dateTo" data-min-view="2" data-date-format="yyyy-mm-dd" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button class="btn btn-space btn-block btn-secondary btn-big" style="background-color: #2A3F54;color:#fff;"><i class="fa fa-filter"></i> Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="noSwipe">
                            <div class="container-fluid py-2 ">
                                {{-- <form action="{{url('prospects/delete')}}" method="post">
                                    @csrf --}}
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
                                            <th>Closing</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($prospect as $item)
                                            @if ($item->Status == 'New')
                                                @if ($item->VerifiedStatus == 0)
                                                <tr style="background-color:rgb(71, 149, 238, 0.5);">
                                                @else
                                                <tr style="border-left: rgb(71, 149, 238) solid 16px;">
    
                                                @endif
                                            @elseif($item->Status == 'Closing')
                                            <tr style="border-left: rgb(2, 185, 57) solid 16px;">
                                            @elseif($item->Status == 'Expired')
                                            <tr style="border-left: rgb(233, 140, 34) solid 16px;">
                                            @elseif($item->Status == 'Process' and $item->Hot == 0)
                                            <tr style="border-left: rgb(214, 113, 201) solid 16px;">
                                            @elseif($item->Status == 'Process' and $item->Hot == 1)
                                            <tr style="border-left: #4B0082 solid 16px;">
                                            @elseif($item->Status == 'Not Interested')
                                            <tr style="border-left: red solid 16px;">
                                            @endif
                                                <td><input class="form-check-input" type="checkbox" value="{{$item->ProspectID}}" name="prospect[]" ><br></td>
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td class="text-center">{{$item->ProspectID}}</td>
                                                <td class="text-left">
                                                    <span>{{$item->NamaProspect}}</span><br><a href="https://api.whatsapp.com/send?phone={{substr($item->KodeNegara, 1)}}{{substr($item->Hp, 1)}}" target="_blank"><span class="card-subtitle" style="color:#6F9CD3">{{$item->Hp}}</span></a>
                                                </td>
                                                <td class="text-center">
                                                    <span>{{$item->NamaSumber}}</span><br><span class="card-subtitle">{{$item->NoteSumberData}}</span>
                                                </td>
                                                <td class="text-center">{{$item->NamaPlatform}}</td>
                                                <td class="text-center">{{$item->Campaign}}</td>
                                                <td class="text-center" data-project="{{$item->KodeProject}}">{{$item->KodeProject}}</td>
                                                <td class="text-left">
                                                    <span style="color:#6F9CD3">{{$item->KodeAgent}}</span><br><span class="card-subtitle">{{$item->NamaSales}}</span>
                                                </td>
                                                <td class="text-center">{{$item->Status}} <br><small class="card-subtitle" style="font-size: 11px;">{{!empty($item->Alasan) ? $item->Alasan : ''}}</small></td>
                                                <td class="text-center">{{date_format(date_create($item->AddDate), "d/m/Y H:i:s")}}</td>
                                                <td class="text-center">{{$item->Status == "New" || $item->Status == "Expired" ? "" : date('d-m-Y', strtotime($item->AcceptDate))}}</td>
                                                <td class="text-center">
                                                    <span style="color:#6F9CD3">{{$item->UnitName}}</span><br><span class="card-subtitle">{{$item->ClosingDate == "0000-00-00 00:00:00" || $item->ClosingDate == null ? "" : date('d-m-Y', strtotime($item->ClosingDate))}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-start">
                                                        <a href="{{url('prospects/edit/'.$item->ProspectID)}}"><button class="btn btn-rounded md-trigger mr-1" style="background-color: #2A3F54;color:#fff;"><i class="fa fa-eye"></i></button></a>
                                                        <form action="{{url('prospects/'.$item->ProspectID)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                            @method('delete')
                                                            @csrf
                                                            <button class="btn btn-rounded mr-1" style="background-color: #8A0512; color :#fff;" type="submit"><i class="fa fa-trash"></i></button>
                                                        </form>
    
                                                        <a href="{{url('prospect/history?ProspectID='.$item->ProspectID)}}"><button class="btn btn-rounded md-trigger mr-1 history" style="background-color: #fb8c2e;color:#fff;" data-modal="{{$item->ProspectID}}" id="{{$item->ProspectID}}" ><i class="fa fa-history"></i></button></a>
    
                                                        @if ($item->CatatanSales != null)
                                                        <button class="btn btn-rounded md-trigger mr-1" style="background-color: #FB8C2E;color:#fff;" data-modal="Catatan-{{$item->ProspectID}}"><i class="fa fa-sticky-note"></i></button>
                                                        @endif
    
                                                        @if ($item->VerifiedStatus == 0)
                                                        <form action="{{url('prospect/verifikasi/'.$item->ProspectID)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                            @csrf
                                                            <button class="btn btn-rounded md-trigger mr-1" style="background-color: #fff;color:#588ac7;font-size:18px;" title="Verifikasi Prospect"><i class="fa fa-check-circle-o"></i></button>
                                                        </form>
                                                        @endif
                                                    </div>
    
                                                    {{-- Catatan Sales Modal --}}
                                                    <div class=" modal-container colored-header colored-header-primary custom-width modal-effect-9" id="Catatan-{{$item->ProspectID}}">
                                                        <div class="modal-content" style="border-radius: 40px;">
                                                            <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
                                                                <h2 class="modal-title" style="font-family: Montserrat ,
                                                                sans-serif Medium 500; font-size: 25px;"><strong>MAKUTA</strong> Pro</h2>
                                                                <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                                                            </div>
                                                            <div class="row" style="background-color: #EEE">
                                                                <div class="col">
                                                                    <h4 class="text-left ml-3" style="color: #FB8C2E"><strong>Catatan Sales</strong></h4>
                                                                </div>
                                                            </div>
                                                            <textarea class="form-control" cols="30" rows="8" disabled>{{$item->CatatanSales}}</textarea>
                                                        </div>
                                                    </div>
                                                    {{-- End Catatan Sales Modal --}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- <button class="btn btn-space btn-secondary" style="background-color: #2A3F54;color:#fff;" type="submit" ><i class="fa fa-trash"></i> </button>

                                </form> --}}
                            </div>
                        </div>

                        <div class="container-fluid py-5">
                            <table style="margin-top: 30px;">
                              <tr><td style="background-color: rgb(71, 149, 238); width: 50px;"></td> <td>: New</td></tr>
                              <tr><td style="background-color: #4B0082; width: 50px;"></td> <td>: Hot</td></tr>
                              <tr><td style="background-color: rgb(214, 113, 201); width: 50px;"></td> <td>: Process</td></tr>
                              <tr><td style="background-color: rgb(233, 140, 34);width: 50px;"></td> <td>: Expired</td></tr>
                              <tr><td style="background-color: rgb(2, 185, 57); width: 50px;"></td> <td>: Closing</td></tr>
                              <tr><td style="background-color: red; width: 50px;"></td> <td>: Not Interested</td></tr>
                            </table>
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
    <script src="{{asset('dist/html/assets/js/datatables-prospect.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/jquery.niftymodals/js/jquery.niftymodals.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            //-initialize the javascript
            // App.init();
            App.dataTables();

        });
        
        $.fn.niftyModal('setDefaults',{
            overlaySelector: '.modal-overlay',
            contentSelector: '.modal-content',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show'
        });

        $('#KodeProject').change(function(){
            var KodeProject = $(this).val();
            if(KodeProject){
                $.ajax({
                type:"GET",
                url:"/get_agent?KodeProject="+KodeProject,
                dataType: 'JSON',
                success:function(res){
                    if(res){
                        $("#KodeAgent").empty();
                        $("#KodeAgent").append('<option value="">All</option>');
                        $.each(res,function(KodeAgent,NamaAgent){
                            $("#KodeAgent").append('<option value="'+KodeAgent+'">'+NamaAgent+'</option>');
                        });
                    }else{
                    $("#KodeAgent").empty();
                    }
                }
                });
            }else{
                $("#KodeAgent").empty();
            }
        });

        $('#KodeAgent').change(function(){
            var KodeAgent = $(this).val();
            if(KodeAgent){
                $.ajax({
                type:"GET",
                url:"/getsales?KodeAgent="+KodeAgent,
                dataType: 'JSON',
                success:function(res){
                    if(res){
                        $("#KodeSales").empty();
                        $("#KodeSales").append('<option value="">All</option>');
                        $.each(res,function(KodeSales,NamaSales){
                            $("#KodeSales").append('<option value="'+KodeSales+'">'+NamaSales+'</option>');
                        });
                    }else{
                    $("#KodeSales").empty();
                    }
                }
                });
            }else{
                $("#KodeSales").empty();
            }
        });
        
        $("#checkAll").change(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
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

@endsection

