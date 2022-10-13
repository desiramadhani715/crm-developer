
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
            <h2 class="page-head-title">Leads Project</h2>
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
                <div class="card card-table">
                    <div class="d-flex justify-content-between">
                        <div class="card-header">
                        </div>
                    </div>
                    <form action="{{route('project.leads.filter')}}" method="POST" role="form">
                        @csrf
                        <div class="card-body">
                            <div class="container-fluid">
                                <input type="hidden" value="{{$KodeProject}}" name="KodeProject">
                                <div class="row">
                                    <div class="col-12 col-lg-4 table-filters pb-0 ">
                                        <div class="filter-container">
                                            <label class="control-label">Select Agent :</label>
                                            <div class="d-flex justify-content-between">
                                                <select class="select2 form-control" name="KodeAgent" id="KodeAgent">
                                                    <option value="">Pilih Agent</option>
                                                    @foreach ($agent as $item)
                                                    <option value="{{$item->KodeAgent}}">{{$item->NamaAgent}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 table-filters pb-0 ">
                                        <div class="filter-container">
                                            <label class="control-label">Select Sales :</label>
                                            <div class="d-flex justify-content-between">
                                                <select class="select2 form-control" name="KodeSales" id="sales">
                                                    <option value="">Pilih Sales</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 table-filters pb-0 ">
                                        <div class="filter-container">
                                            <label class="control-label">Status</label>
                                            <select id="filter-status" class="select2 form-control" name="status">
                                                <option value="">All</option>
                                                @foreach ($status as $item)
                                                <option value="{{$item->KetStatus}}">{{$item->KetStatus}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 pb-0">
                                        <button class="btn btn-space btn-block btn-secondary btn-big" type="submit" style="background-color: #2A3F54;color:#fff;"><i class="fa fa-filter"></i> Filter</button>
                                    </div>
                                </div>
                            </div>
                            <div class="noSwipe">
                                <div class="container-fluid py-2 ">
                                    <table class="table table-striped table-hover be-table-responsive table-responsive " id="table1" border="1px">
                                        <thead>
                                            <tr class="text-center">
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
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td class="text-center">{{$item->ProspectID}}</td>
                                                <td class="text-left">
                                                    @if ($item->NumberMove > 0)
                                                    <img src="{{asset('button/right.png')}}" style="width:20px;margin-top:8px;margin-right:5px;opacity: 0.3;" >
                                                    @endif
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
    <script src="{{asset('dist/html/assets/lib/jquery.niftymodals/js/jquery.niftymodals.js')}}" type="text/javascript"></script>
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

        // $("form").submit(function (event) {
        //     var formData = {
        //         KodeProjectNext: $("#name").val(),
        //         email: $("#email").val(),
        //         superheroAlias: $("#superheroAlias").val(),
        //     };

        //     $.ajax({
        //     type: "POST",
        //     url: "process.php",
        //     data: formData,
        //     dataType: "json",
        //     encode: true,
        //     }).done(function (data) {
        //         console.log(data);
        //     });

        //     event.preventDefault();
        // });

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
                        $("#sales").empty();
                        $("#sales").append('<option>Pilih Sales</option>');
                        $.each(res,function(KodeSales,NamaSales){
                            $("#sales").append('<option value="'+KodeSales+'">'+NamaSales+'</option>');
                        });
                    }else{
                    $("#sales").empty();
                    }
                }
                });
            }else{
                $("#sales").empty();
            }
        });
    </script>
@endsection

