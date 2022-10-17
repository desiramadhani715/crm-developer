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
            <h2 class="page-head-title">Data Campaign</h2>
            {{-- @if (Auth::user()->UsernameKP != 'panenproperty') --}}
            <button class="btn btn-space  md-trigger" data-modal="addnew" style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-plus-circle-o"></i>Add New</button>
            {{-- @endif --}}

            {{-- Add Modal --}}
            <div class="modal-container colored-header colored-header-primary custom-width modal-effect-9" id="addnew">
                <div class="modal-content" style="border-radius: 40px;">
                    <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
                        <h2 class="modal-title" style="font-family: Montserrat ,
                        sans-serif Medium 500; font-size: 25px;"><strong>Campaign </strong></h2>
                        <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                    </div>
                    <form action={{route('campaign.store')}} method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body pt-0">
                        <div class="form-group mt-5">
                            <label>Nama Campaign</label>
                            <input class="form-control" name="NamaCampaign" style="border-radius: 50px;" type="text"  name="NamaCampaign" value="" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select Project :</label>
                            <select class="select2 form-control" name="KodeProject" style="border-radius: 50px;" required>
                                <option value="">Pilih Project</option>
                                @foreach ($project as $item)
                                <option value="{{$item->KodeProject}}">{{$item->NamaProject}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn  modal-close " style="background-color: #6F9CD3; border-radius: 50px; color: #fff;" type="submit">Save</button>
                    </div>
                    </form>
                </div>
            </div>
            {{-- End Add Modal --}}
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/campaign')}}">Campaign</a></li>
            </ol>
        </nav>
    </div>
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-header">Data Campaign
                    </div>
                    <div class="card-body">
                        <div class="container py-2">
                            <table class="table table-striped table-hover table-fw-widget" id="table1">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 10px">No.</th>
                                        <th>Kode Project</th>
                                        <th>Nama Campaign</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($campaign as $item)
                                    <tr class="text-center">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->KodeProject}}</td>
                                        <td>{{$item->NamaCampaign}}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn md-trigger" style="border: none;background-color: transparent;" data-modal="detail-{{$item->CampaignID}}"><img src="{{asset('button/eye.png')}}" class="mb-2"  title="Detail"></button>

                                                <form action="{{route('campaign.destroy', $item->CampaignID)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-rounded" style="border: none;background-color: transparent;" type="submit"><img src="{{asset('button/trash.png')}}" class="mb-2"  title="Hapus"></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Update Modal --}}
                                    <div class="modal-container colored-header colored-header-primary custom-width modal-effect-9" id="detail-{{$item->CampaignID}}">
                                        <div class="modal-content" style="border-radius: 40px;">
                                            <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
                                                <h2 class="modal-title" style="font-family: Montserrat ,
                                                sans-serif Medium 500; font-size: 25px;"><strong>Campaign </strong></h2>
                                                <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                                            </div>
                                            <form action={{route('campaign.update',$item->CampaignID)}} method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                            <div class="modal-body pt-0">
                                                <div class="form-group mt-5">
                                                    <label>Nama Campaign</label>
                                                    <input class="form-control" style="border-radius: 50px;" type="text"  name="NamaCampaign" value="{{$item->NamaCampaign}}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn  modal-close " style="background-color: #6F9CD3; border-radius: 50px; color: #fff;" type="submit">Save</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    {{-- End Update Modal --}}
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
        // App.init();
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
            // App.init();
        });
    </script>
@endsection
