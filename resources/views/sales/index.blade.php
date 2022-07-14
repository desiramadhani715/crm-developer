@extends('Layout/layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css" />
    <!-- Font Awesome -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> --}}
@endsection

@section('content')

<div class="be-content">
    <div class="page-head">
        <div class="d-flex justify-content-between">
            <h2 class="page-head-title">Data Sales {{$KodeAgent}}</h2>
            <a href="{{url('sales/create/'.$KodeAgent)}}" class="mt-2">
                <button class="btn btn-space active" style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus mb-1" ></i>Add New Sales</button>
            </a>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/agent')}}">Agent</a></li>
                <li class="breadcrumb-item"><a href="">Sales</a></li>
            </ol>
        </nav>
    </div>
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
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
                <div class="card card-table">
                    <div class="d-flex justify-content-between">
                        <div class="card-header">Data Sales
                        </div>
                        <a href="{{url('sales/create/'.$KodeAgent)}}" class="mt-4 mr-2 d-block d-sm-none">
                            <button class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus mb-1" ></i>Add New Sales</button>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="noSwipe">
                            <div class="container">
                                <table class="table table-striped table-hover table-fw-widget be-table-responsive" id="table1" >
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 10px">No.</th>
                                            <th>Sales Code</th>
                                            <th>Name</th>
                                            <th>Sort</th>
                                            <th>Telp</th>
                                            <th>Prospect</th>
                                            <th>Closing Amount</th>
                                            <th>Join Date</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($object as $item)
                                        <tr class="text-center {{$item->Active == 1 ? 'success done' :  'danger in-review' }}">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->KodeSales}}</td>
                                            <td>
                                                <span>{{$item->NamaSales}}</span><br>
                                                <a href="https://api.whatsapp.com/send?phone=62{{substr($item->Hp, 1)}}" target="_blank"><span class="card-subtitle" style="color:#6F9CD3"><img src="{{asset('images/icon_wa.png')}}" width="20px" class="p-0" alt="">{{$item->Hp}}</span></a>
                                            </td>
                                            <td>{{$item->UrutAgentSales}}</td>
                                            <td>{{$item->Hp}}</td>
                                            <td>{{$item->prospect}}</td>
                                            <td>Rp. {{number_format($item->ClosingAmount,0, ',' , '.')}}</td>
                                            <td>{{$item->JoinDate}}</td>
                                            <td >
                                                @if ($item->Active == 1)
                                                    <form action={{url('/sales/'.$KodeAgent.'/'.$item->KodeSales.'/'.$item->UrutAgentSales)}} method="POST" onsubmit="return confirm('Non aktifkan sales {{$item->NamaSales}} ?')">
                                                        @method('post')
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success">Active</button>
                                                    </form>
                                                @else
                                                    <form action={{url('/sales/'.$KodeAgent.'/'.$item->KodeSales)}} method="POST" onsubmit="return confirm('Aktifkan sales {{$item->NamaSales}} ?')">
                                                        @method('post')
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger" >Non Active</button>
                                                    </form>
                                                @endif

                                            </td>
                                            <td class="text-left">
                                                <div class="d-flex justify-content-center">
                                                    {{-- <button class="btn btn-rounded md-trigger mr-1" style="background-color: #2A3F54;color:#fff;" data-modal="detail-{{$item->KodeSales}}"><i class="fa fa-eye"></i></button> --}}
                                                    <button class="btn md-trigger" style="border: none;background-color: transparent;" data-modal="detail-{{$item->KodeSales}}"><img src="{{asset('button/eye.png')}}" class="mb-2"  title="Detail"></button>
                                                    <a href="{{url('history/'.$item->KodeSales)}}">
                                                        <img src="{{asset('button/history.png')}}" class="mr-1"  title="History Sales">
                                                        {{-- <button class="btn btn-rounded md-trigger mr-1" style="background-color: #fb8c2e;color:#fff;"><i class="fa fa-history"></i></button> --}}
                                                    </a>
                                                    <a href={{url('prospects/'.$KodeAgent.'/'.$item->KodeSales)}}>
                                                        <img src="{{asset('button/list.png')}}" class="mx-1"  title="Prospect List">
                                                        {{-- <button class="btn btn-rounded mr-1" style="background-color: #335F70;color:#fff;"><i class="fa fa-list"></i></button> --}}
                                                        {{-- <button class="btn btn-rounded btn-space btn-success">Sales list</button> --}}
                                                    </a>
                                                    <form action="{{url('sales/'.$item->KodeSales)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                        @method('delete')
                                                        @csrf
                                                        {{-- <button class="btn btn-danger btn-rounded" type="submit"><i class="fa fa-trash"></i></button> --}}<button class="btn=" type="submit" style="border: none;background-color: transparent;"><img src="{{asset('button/trash.png')}}" class="mb-2"  title="Hapus"></button>
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
<div class="modal-container colored-header colored-header-primary custom-width modal-effect-9" id="detail-{{$item->KodeSales}}" >
    <div class="modal-content" style="border-radius: 40px;">
        <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
            <h2 class="modal-title" style="font-family: Montserrat Medium 500,
            sans-serif; font-size: 25px;"><strong>MAKUTA</strong> Pro</h2>
            <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
        </div>
        <nav aria-label="breadcrumb" role="navigation" >
            <ol class="breadcrumb page-head-nav" style="color : grey; font-family: Montserrat Thin 100;">
                <li class="breadcrumb-item">{{$item->KodeProject}}</li>
                <li class="breadcrumb-item">{{$item->KodeSales}}</li>
                <li class="breadcrumb-item">{{$item->UsernameKP}}</li>
            </ol>
        </nav>
        <form action='{{url('sales/update/'.$item->KodeSales)}}' method="POST" enctype="multipart/form-data">
            @csrf
        <div class="modal-body form">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="form-group">
                        <label for="">Photo User</label>
                        <div class="row">
                            <div class="col">
                                <div class="d-flex justify-content-center">
                                    <img src="{{$item->PhotoUser != null ? 'https://api.makutapro.id/storage/photo/'.$item->PhotoUser : asset('storage/uploaded/user.jpg')}}" alt="" class="img-fluid img-thumbnail rounded-circle mb-2"  width="150px">
                                    <input type="hidden" name="PhotoUser" id="" value="{{$item->PhotoUser}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <input type="file" class="form-control mb-2" name="PhotoUser" value="{{$item->Ktp}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Photo Ktp</label>
                        <div class="row">
                            <div class="col">
                                <div class="d-flex justify-content-center">
                                    <img src="{{asset('storage/uploaded/'.$item->Ktp)}}" alt="" class="img-fluid img-thumbnail mb-2 mt-2" style="width: 150px; height: 90px;" width="100%">
                                    <input type="hidden" name="Ktp" id="" value="{{$item->Ktp}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <input type="file" class="form-control mb-2" name="Ktp" value="{{$item->Ktp}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="form-group">
                        <div class="row">
                            <div class="col"><label>Nama Sales</label><input class="form-control mb-2" style="border-radius: 50px;" type="text" value="{{$item->NamaSales}}" name="NamaSales"></div>
                            @error('NamaSales')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col"><label>Email</label><input class="form-control mb-2" style="border-radius: 50px;" type="email" value="{{$item->Email}}" name="Email"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6"><label>Hp</label><input class="form-control" style="border-radius: 50px;" type="text" value="{{$item->Hp}}" name="Hp"></div>
                            <div class="col-12 col-md-6 col-lg-6"><label>Sort</label><input class="form-control" style="border-radius: 50px;" type="text" value="{{$item->UrutAgentSales}}" name="UrutAgentSales"></div>
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
            <button class="btn  modal-close " style="background-color: #FB8C2E; border-radius: 50px; color: #fff;" type="submit">Save Change</button>
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
            App.init();
        });
    </script>
@endsection
