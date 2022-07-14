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
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/select2/css/select2.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/bootstrap-slider/css/bootstrap-slider.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css" /> --}}
@endsection

@section('content')

<div class="be-content">
    <div class="page-head">
        <div class="d-flex justify-content-between">
            <h2 class="page-head-title">Data Agent</h2>
            <a href="{{url('agent/create')}}" class="mt-2">
                <button class="btn btn-space active" style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus mb-1" ></i>Add New Agent</button>
            </a>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/agent')}}">Agent</a></li>
            </ol>
        </nav>
    </div>
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if (session('status'))
                  <div class="alert alert-contrast alert-success alert-dismissible" role="alert">
                    <div class="icon"><span class="mdi mdi-check"></span></div>
                    <div class="message">
                      <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button><strong>{{ session('status') }} </strong></div>
                    </div>
                  </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                    <div class="icon"><span class="mdi mdi-info-outline"></span></div>
                    <div class="message"><strong> {{ session('error') }} </strong></div>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-table">
                    <div class="d-flex justify-content-between">
                        <div class="card-header">Data Agent
                        </div>
                        <a href="{{url('agent/create')}}" class="mt-4 mr-2 d-block d-sm-none">
                            <button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus mb-1" ></i>Add New Agent</button>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{url('agent')}}" method="POST" role="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-lg-8 table-filters pb-0 "><span class="table-filter-title">Date</span>
                                                <div class="filter-container">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label class="control-label">Since:</label>
                                                            <input class="form-control form-control-sm datetimepicker" name="dateSince" data-min-view="2" data-date-format="yyyy-mm-dd">
                                                        </div>
                                                        <div class="col">
                                                            <label class="control-label">To:</label>
                                                            <input class="form-control form-control-sm datetimepicker" name="dateTo" data-min-view="2" data-date-format="yyyy-mm-dd">
                                                        </div>
                                                        <div class="col">
                                                            <button class="btn btn-space btn-secondary btn-big mt-5" style="background-color: #2A3F54;color:#fff;"><i class="fa fa-filter"></i> Filter </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="noSwipe">
                            <div class="container">
                                <table class="table table-striped table-hover table-fw-widget be-table-responsive " id="table1" >
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 10px">No.</th>
                                            <th>Kode Agent</th>
                                            <th>Nama Agent</th>
                                            <th>No Urut Agent</th>
                                            <th>Project</th>
                                            <th>Closing Amount</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($object as $item)
                                        <tr class="text-center {{$item->Active == 1 ? 'success done' :  'danger in-review' }}">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->KodeAgent}}</td>
                                            <td>
                                                <span>{{$item->NamaAgent}}</span><br><span class="card-subtitle"  style="color:#6F9CD3">PIC : {{$item->Pic}}</span>
                                            </td>
                                            <td>{{$item->UrutAgent}}</td>
                                            <td>{{$item->NamaProject}}</td>
                                            <td>Rp. {{number_format($item->total,0, ',' , '.')}}</td>
                                            <td >
                                                @if ($item->Active == 1)
                                                    <form action={{route('agent.nonactive',$item->KodeAgent)}} method="POST" onsubmit="return confirm('Non aktifkan Agent {{$item->NamaAgent}} ?')">
                                                        @method('post')
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success"">Active</button>
                                                    </form>
                                                @else
                                                    <form action={{route('agent.active',$item->KodeAgent)}} method="POST" onsubmit="return confirm('Aktifkan Agent {{$item->NamaAgent}} ?')">
                                                        @method('post')
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger" >Non Active</button>
                                                    </form>
                                                @endif

                                            </td>
                                            <td class="text-left" >
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn md-trigger" style="border: none;background-color: transparent;" data-modal="detail-{{$item->KodeAgent}}"><img src="{{asset('button/eye.png')}}" class="mb-2"  title="Detail"></button>
                                                    <a href="agent/sales/{{$item->KodeAgent}}">
                                                        <img src="{{asset('button/Prospect.png')}}" class="mr-1"  title="Sales List">
                                                    </a>
                                                    <a href="agent/prospect/{{$item->KodeAgent}}">
                                                        <img src="{{asset('button/list.png')}}" class="mx-1"  title="Prospect List">
                                                    </a>
                                                    <form action="{{url('agent/'.$item->KodeAgent.'/'.$item->UsernameKP)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn=" type="submit" style="border: none;background-color: transparent;"><img src="{{asset('button/trash.png')}}" class="mb-2"  title="Hapus"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
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

@foreach ($object as $item)
{{-- Start details and update Modal --}}
<div class="modal-container colored-header colored-header-primary custom-width modal-effect-9" id="detail-{{$item->KodeAgent}}">
    <div class="modal-content" style="border-radius: 40px;">
        <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
            <h2 class="modal-title" style="font-family: Montserrat ,
            sans-serif Medium 500; font-size: 25px;"><strong>MAKUTA</strong> Pro</h2>
            <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav" style="color :gray; font-family: Montserrat Thin 100; font-size: 15px;">
                <li class="breadcrumb-item">{{$item->NamaProject}}</li>
                <li class="breadcrumb-item">{{$item->KodeAgent}}</li>
                <li class="breadcrumb-item">{{$item->UsernameKP}}</li>
            </ol>
        </nav>
        <form action='{{url('agent/update/'.$item->KodeAgent)}}' method="POST" enctype="multipart/form-data">
            @csrf
        <div class="modal-body form">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <img src="{{$item->PhotoUser != null ? asset('storage/uploaded/'.$item->PhotoUser) : asset('storage/uploaded/user.jpg')}}" alt="" class="img-fluid rounded-circle mb-2" style="border: 1px solid #6F9CD3;">
                                <input type="hidden" name="PhotoUser" id="" value="{{$item->PhotoUser}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <input type="file" class="form-control" name="PhotoUser" value="{{$item->PhotoUser}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="form-group">
                        <div class="row">
                            <div class="col"><label>Username</label><input class="form-control mb-2" style="border-radius: 50px;" type="text" value="{{$item->UsernameKP}}" name="UsernameKP" disabled></div>
                            <input class="form-control mb-2" style="border-radius: 50px;" type="hidden" value="{{$item->UsernameKP}}" name="UsernameKP" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col"><label>Nama Agent</label><input class="form-control mb-2" style="border-radius: 50px;" type="text" value="{{$item->NamaAgent}}" name="NamaAgent"></div>
                            @error('NamaAgent')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col"><label>Nama Koordinator</label><input class="form-control mb-2" style="border-radius: 50px;" type="text"  value="{{$item->Pic}}" name="Pic"></div>
                            @error('Pic')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col"><label>Email</label><input class="form-control mb-2" style="border-radius: 50px;" type="email" value="{{$item->Email}}" name="Email"></div>
                            @error('Email')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6"><label>Hp</label><input class="form-control" style="border-radius: 50px;" type="text" value="{{$item->Hp}}" name="Hp"></div>
                            <div class="col-12 col-md-6 col-lg-6"><label>Sort</label><input class="form-control" style="border-radius: 50px;" type="text" value="{{$item->Sort}}" name="UrutAgent"></div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <div class="row">
                            <div class="col"><label>Password</label><input class="form-control mb-2" style="border-radius: 50px;" type="password" value="" placeholder="Change Password" name="PasswordKP"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <form action="{{url('agent/'.$item->KodeAgent)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-space btn-rounded btn-danger btn-s">Delete</button>
                <button class="btn btn-danger modal-close" type="submit" >Delete</button>
            </form> --}}
            <button class="btn  modal-close " style="background-color: #6F9CD3; border-radius: 50px; color: #fff;" type="submit">Save Change</button>
        </div>
        </form>
    </div>
</div>
@endforeach
{{-- End details and update Modal --}}

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

    <script src="{{asset('dist/html/assets/lib/jquery.niftymodals/js/jquery.niftymodals.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $.fn.niftyModal('setDefaults',{
            overlaySelector: '.modal-overlay',
            contentSelector: '.modal-content',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show'
        });

        $(document).ready(function(){
            //-initialize the javascript
            // App.init();
        });
    </script>
@endsection
