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
            <h2 class="page-head-title">ROAS</h2>
            <div class="d-flex justify-content-between">
                <button class="btn btn-space md-trigger mr-1" style="background-color: #2A3F54;color:#fff;" data-modal="roascreate"><i class="icon icon-left mdi mdi-plus mb-1" ></i>Add New</i></button>
                <button onclick="print()" class="btn btn-space active " style="background-color: #2A3F54;color:#fff;"><i class="icon icon-left mdi mdi-print"></i>Print</button>
            </div>
        </div>
        {{-- Add Modal --}}
        <div class="modal-container colored-header colored-header-primary custom-width modal-effect-9" id="roascreate">
            <div class="modal-content" style="border-radius: 40px;">
                <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
                    <h2 class="modal-title" style="font-family: Montserrat ,
                    sans-serif Medium 500; font-size: 25px;"><strong>ROAS </strong><small> ( Return On Ad Spend )</small></h2>
                    <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                </div>
                <form action='roas/create' method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body pt-0">
                        <div class="form-group">
                            <h4 style="color: #6F9CD3;" class="mb-5">Masukkan Pemakaian Budget Ads</h4>
                            <label>Google Ads Spend</label>
                            <input class="form-control" style="border-radius: 50px;" type="text" id="rupiah" name="Google" placeholder="Input Budget...">
                        </div>
                        <div class="form-group">
                            <label>Social Media Spend</label>
                            <input class="form-control" style="border-radius: 50px;" type="text" id="rupiah2" name="Sosmed" placeholder="Input Budget...">
                        </div>
                        <div class="form-group">
                            <label>Detik Ads Spend</label>
                            <input class="form-control" style="border-radius: 50px;" type="text" id="rupiah3" name="Detik" placeholder="Input Budget...">
                        </div>
                        <div class="form-group">
                            <label>Project</label>
                            <select class="select2 form-control" name="KodeProject" style="border-radius: 50px;" required>
                                <option value="">Pilih Project</option>
                                @foreach ($project as $item)
                                    <option value="{{$item->KodeProject}}">{{$item->NamaProject}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bulan</label>
                            <select class="select2 form-control" name="bulan" style="border-radius: 50px;" required>
                                <option value="">Pilih Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="select2 form-control" name="tahun" style="border-radius: 50px;" required>
                                <option value="">Pilih Tahun</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
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
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/roas')}}">Return On Ad Spend </a></li>
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
        @foreach ($Roas as $item)
        <div class="row">
            <div class="col-sm-11">
                <div class="card card-table pb-5">
                    <div class="card-header text-center"><strong>{{$item->NamaProject}}</strong><hr>
                    </div>
                    <div class="card-body">
                        <div class="container py-2">
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 10px">No.</th>
                                        <th>Budget</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Project</th>
                                        <th>CPL <br><span><small>(Cost per Lead)</small></span></th>
                                        <th>CPA <br><span><small>(Cost per Acquisition)</small></span></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->roas as $roas)
                                    @php
                                        $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{$loop->iteration}}</td>
                                        @php
                                            if($roas->Budget == null)
                                                $budget = $roas->Google + $roas->Sosmed + $roas->Detik;
                                            else
                                                $budget = $roas->Budget;
                                        @endphp
                                        <td>Rp. {{number_format($budget,0, ',' , '.')}}</td>
                                        @php
                                            if ($roas->Bulan != "10" and $roas->Bulan != "11" and $roas->Bulan != "12")
                                                $idxBulan = str_replace('0','',$roas->Bulan);
                                            else
                                                $idxBulan = $roas->Bulan;
                                        @endphp
                                        <td>{{$bulan[$idxBulan-1]}}</td>
                                        <td>{{$roas->Tahun}}</td>
                                        <td>{{$roas->KodeProject}}</td>
                                        <td>Rp. {{number_format($roas->CPL,0, ',' , '.')}}</td>
                                        <td>Rp. {{number_format($roas->CPA,0, ',' , '.')}}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                            <button class="btn btn-rounded md-trigger mr-1" style="background-color: #2A3F54;color:#fff;" data-modal="detail-{{$roas->id}}"><i class="fa fa-eye"></i></button>

                                            <form action="{{url('roas/delete/'.$roas->id)}}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-rounded" style="background-color: #8A0512; color :#fff;" type="submit"><i class="fa fa-trash"></i></button>
                                            </form>
                                            </div>
                                        </td>

                                        {{-- Update Modal --}}
                                        <div class="modal-container colored-header colored-header-primary custom-width modal-effect-9" id="detail-{{$roas->id}}">
                                            <div class="modal-content" style="border-radius: 40px;">
                                                <div class="modal-header modal-header-colored" style="background-color: #6F9CD3; ">
                                                    <h2 class="modal-title" style="font-family: Montserrat ,
                                                    sans-serif Medium 500; font-size: 25px;"><strong>ROAS </strong><small> ( Return On Ad Spend )</small></h2>
                                                    <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
                                                </div>
                                                <form action={{url('roas/update/'.$roas->id)}} method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                <div class="modal-body pt-0">
                                                    <div class="form-group">
                                                        <h4 style="color: #6F9CD3;" class="mb-5">Update Pemakaian Budget Ads</h4>
                                                        <label>Google Ads Spend</label>
                                                        <input class="form-control mb-2" style="border-radius: 50px;" type="text"  name="Google" value="Rp. {{number_format($roas->Google,0, ',' , '.')}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Sosmed Ads Spend</label>
                                                        <input class="form-control mb-2" style="border-radius: 50px;" type="text"  name="Sosmed" value="Rp. {{number_format($roas->Sosmed,0, ',' , '.')}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Detik Ads Spend</label>
                                                        <input class="form-control mb-2" style="border-radius: 50px;" type="text"  name="Detik" value="Rp. {{number_format($roas->Detik,0, ',' , '.')}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Project</label>
                                                        <select class="select2 form-control" name="KodeProject" style="border-radius: 50px;" required>
                                                            <option value="{{$roas->KodeProject}}">{{$roas->KodeProject}}</option>
                                                            @foreach ($project as $item)
                                                            <option value="{{$item->KodeProject}}">{{$item->NamaProject}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bulan</label>
                                                        <select class="select2 form-control" name="bulan" style="border-radius: 50px;" required>
                                                            <option value="{{$roas->Bulan}}">{{$bulan[$idxBulan-1]}}</option>
                                                            <option value="01">Januari</option>
                                                            <option value="02">Februari</option>
                                                            <option value="03">Maret</option>
                                                            <option value="04">April</option>
                                                            <option value="05">Mei</option>
                                                            <option value="06">Juni</option>
                                                            <option value="07">Juli</option>
                                                            <option value="08">Agustus</option>
                                                            <option value="09">September</option>
                                                            <option value="10">Oktober</option>
                                                            <option value="11">November</option>
                                                            <option value="12">Desember</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tahun</label>
                                                        <select class="select2 form-control" name="tahun" style="border-radius: 50px;" required>
                                                            <option value="{{$roas->Tahun}}">{{$roas->Tahun}}</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2021">2021</option>
                                                            <option value="2020">2020</option>
                                                            <option value="2019">2019</option>
                                                            <option value="2018">2018</option>
                                                        </select>
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
        @endforeach
        <div class="row">
            <div class="col">
                <p style="color:gray">
                    <strong>Keterangan</strong> <br>
                    Cost : Total pembelanjaan google ads, social media ads, detik ads <br>
                    Leads: Total keseluruhan jumlah data propspect (tidak termasuk dari aplikasi sales dan website sales) <br>
                    Closing: Total data prospect yang closing (tidak termasuk dari aplikasi sales dan website sales) <br>
                </p>
            </div>
        </div>

    </div>
</div>
<script>
    var rupiah = document.getElementById("rupiah");
    rupiah.addEventListener("keyup", function(e) {
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value, "Rp. ");
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }

    var rupiah2 = document.getElementById("rupiah2");
    rupiah2.addEventListener("keyup", function(e) {
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah2.value = formatRupiah(this.value, "Rp. ");
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah2 = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah2 += separator + ribuan.join(".");
        }

        rupiah2 = split[1] != undefined ? rupiah2 + "," + split[1] : rupiah2;
        return prefix == undefined ? rupiah2 : rupiah2 ? "Rp. " + rupiah2 : "";
    }

    var rupiah3 = document.getElementById("rupiah3");
    rupiah3.addEventListener("keyup", function(e) {
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah3.value = formatRupiah(this.value, "Rp. ");
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah3 = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah3 += separator + ribuan.join(".");
        }

        rupiah3 = split[1] != undefined ? rupiah3 + "," + split[1] : rupiah3;
        return prefix == undefined ? rupiah3 : rupiah3 ? "Rp. " + rupiah3 : "";
    }

</script>


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

