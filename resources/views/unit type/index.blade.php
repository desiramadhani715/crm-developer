@extends('Layout/layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css" />
    <!-- Font Awesome -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
@endsection

@section('content')

<div class="be-content">
    <div class="page-head">
        <div class="d-flex justify-content-between">
            <h2 class="page-head-title">Unit Type</h2>
            <div class="d-flex justify-content-between">
                <button class="btn btn-space md-trigger mr-1" style="background-color: #2A3F54;color:#fff;" data-modal="roascreate"><i class="icon icon-left mdi mdi-plus mb-1" ></i>Add New</i></button>
            </div>
        </div>
        {{-- Add Modal --}}
        <div class="modal-container colored-header colored-header-primary custom-width modal-effect-9" id="roascreate">
            <div class="modal-content" style="border-radius: 40px;">
                <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
                    <h2 class="modal-title" style="font-family: Montserrat ,
                    sans-serif Medium 500; font-size: 25px;"><strong>MAKUTA</strong> Pro</h2>
                    <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                </div>
                <form action="{{route('unit.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body form">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Project</label>
                                        <select class="select2 form-control" name="ProjectCode" style="border-radius: 50px;" required>
                                            <option value=" ">Pilih Project</option>
                                            @foreach ($project as $item)
                                               <option value="{{$item->KodeProject}}">{{$item->NamaProject}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group my-2">
                                <div class="row">
                                    <div class="col">
                                        <label>Nama Unit</label>
                                        <input class="form-control" required style="border-radius: 50px;" type="text"  name="UnitName">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  modal-close " style="background-color: #6F9CD3; border-radius: 50px; color: #fff;" type="submit">Save</button>
                </div>
                </form>
            </div>
        </div>
        {{-- End Add Modal --}}
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('unit.index')}}">Unit Type </a></li>
            </ol>
        </nav>
    </div>
    <div class="main-content container-fluid">
        @if (session('status'))
        <div class="alert alert-contrast alert-success alert-dismissible" role="alert">
          <div class="icon"><span class="mdi mdi-check"></span></div>
          <div class="message">
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button><strong>{{ session('status') }} </strong></div>
          </div>
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-header text-center"><strong>{{Auth::user()->NamaPT}}</strong>
                    </div>
                    <div class="card-body">
                        <div class="container py-2">
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 10px">No.</th>
                                        <th>Nama Unit</th>
                                        <th>Project</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unit as $item)
                                    <tr class="text-center">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->UnitName}}</td>
                                        <td>{{$item->NamaProject}}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                            <button class="btn btn-rounded md-trigger mr-1" style="background-color: #2A3F54;color:#fff;" data-modal="detail-{{$item->UnitID}}"><i class="fa fa-eye"></i></button>

                                            <form action="{{route('unit.destroy', $item->UnitID)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-rounded" style="background-color: #8A0512; color :#fff;" type="submit"><i class="fa fa-trash"></i></button>
                                            </form>
                                            </div>
                                        </td>

                                        {{-- Update Modal --}}
                                        <div class="modal-container colored-header colored-header-primary custom-width modal-effect-9" id="detail-{{$item->UnitID}}">
                                            <div class="modal-content" style="border-radius: 40px;">
                                                <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
                                                    <h2 class="modal-title" style="font-family: Montserrat ,
                                                    sans-serif Medium 500; font-size: 25px;"><strong>MAKUTA</strong> Pro</h2>
                                                    <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                                                </div>
                                                <form action={{route('unit.update', $item->UnitID)}} method="POST" enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                <div class="modal-body form">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label>Project</label>
                                                                        <select class="select2 form-control" name="ProjectCode" style="border-radius: 50px;" required>
                                                                            <option value="{{$item->ProjectCode}}">{{$item->NamaProject}}</option>
                                                                            @foreach ($project as $projectItem)
                                                                                @if ($projectItem->KodeProject != $item->ProjectCode)
                                                                                    <option value="{{$projectItem->KodeProject}}">{{$projectItem->NamaProject}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group my-2">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label>Nama Unit</label>
                                                                        <input class="form-control" style="border-radius: 50px;" type="text" value="{{$item->UnitName}}"  name="UnitName">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn  modal-close " style="background-color: #6F9CD3; border-radius: 50px; color: #fff;" type="submit">Save</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- End Update Modal --}}
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

