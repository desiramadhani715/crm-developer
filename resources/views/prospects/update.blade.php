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
      <h2 class="page-head-title">Prospects</h2>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb page-head-nav">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{url('/prospects')}}">Prospects</a></li>
          <li class="breadcrumb-item active">Update</li>
        </ol>
      </nav>
    </div>
    <div class="main-content container-fluid">
      <div class="row">
        <div class="col-md-12">
            @if (session('status'))
            <div class="alert alert-info alert-dismissible" role="alert">
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                <div class="icon"><span class="mdi mdi-info-outline"></span></div>
                <div class="message"><strong> {{ session('status') }} </strong></div>
            </div>
            @endif
          <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Update Prospects</div>
            <div class="card-body">
                @foreach($prospect2 as $p)
                <form action="{{url('/prospects/update/'.$p->ProspectID)}}" method="POST" role="form">
                    @csrf
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="NamaProspect">Nama</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" id="NamaProspect" type="text" name="NamaProspect" value="{{$p->NamaProspect}}">
                        <input type="hidden" name="KodeSales" value="{{$p->KodeSales}}">
                        @error('NamaProspect')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="EmailProspect">Email</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" id="EmailProspect" type="email" name="EmailProspect" value="{{$p->EmailProspect}}">
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Hp">Hp</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" id="Hp" type="text" name="Hp" value="{{$p->Hp}}">
                        @error('Hp')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Status">Status</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <select name="Status" id="Status" class="form-control" required>
                            <option value="{{$p->Status}}">{{$p->Status}}</option>
                            @foreach ($p->status as $item)
                                @if($item->KetStatus != $p->Status)
                                <option value="{{$item->KetStatus}}">{{$item->KetStatus}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div id="NotInterestedID" style="display: none" id="NotInterestedID">
                        <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="NotInterestedID">Not Interested</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <select name="NotInterestedID"  class="form-control" required>
                                <option value="0">Pilih Alasan</option>
                                @foreach ($p->notinterest as $item)
                                    <option value="{{$item->NotInterestedID}}">{{$item->Alasan}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                    <div id="Closing" style="display: none" id="Closing">
                        <div class="form-group row" >
                            <label class="col-12 col-sm-3 col-form-label text-sm-right" for="UnitID">Unit Type</label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <select name="UnitID"  class="form-control" required>
                                    <option value="0">Pilih Unit Type</option>
                                    @foreach ($p->unit as $item)
                                        <option value="{{$item->UnitID}}">{{$item->UnitName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Keterangan Unit</label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" class="form-control" value="" name="KetUnit">
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Harga Jual</label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="number" class="form-control" value="" id="ClosingAmount" name="HargaJual">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Message" >Pesan</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <textarea class="form-control" id="Message" name="Message" rows="5" value="{{$p->Message}}" disabled></textarea>
                        <input type="hidden" value="{{$p->Message}}" id="Message" name="Message">
                    </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="KodeAgent" >Agent</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <select name="KodeAgent" id="KodeAgent" class="form-control" required disabled>
                            @if ($p->KodeAgent != null)
                                <option value="{{$p->KodeAgent}}">{{$p->NamaAgent}}</option>
                            @else
                                <option value="">Pilih</option>
                            @endif
                            @foreach ($agent as $item)
                                @if($item->KodeAgent != $p->KodeAgent)
                                <option value="{{$item->KodeAgent}}">{{$item->NamaAgent}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('KodeAgent')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="KodeSales">Sales</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <select name="KodeSales" id="KodeSales" class="form-control" required disabled>
                            @if ($p->KodeSales != null)
                                <option value="{{$p->KodeSales}}">{{$p->NamaSales}}</option>
                            @else
                                <option value="">Pilih</option>
                            @endif
                        </select>
                        @error('KodeSales')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    @endforeach
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="GenderID" >Gender</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <select name="GenderID" id="GenderID" class="form-control">
                            @if ($p->JenisKelamin!=null)
                            <option value="{{$p->GenderID}}">{{$p->JenisKelamin}}</option>
                            @else
                            <option value="">Pilih</option>
                            @endif
                            @foreach ($p->gender as $g)
                                <option value="{{$g->GenderID}}">{{$g->JenisKelamin}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="UsiaID" >Usia</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <select name="UsiaID" id="UsiaID" class="form-control">
                            @if ($p->RangeUsia!=null)
                            <option value="{{$p->UsiaID}}">{{$p->RangeUsia}}</option>
                            @else
                            <option value="">Pilih</option>
                            @endif
                            @foreach ($p->usia as $u)
                                <option value="{{$u->UsiaID}}">{{$u->RangeUsia}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="TempatTinggalID" >Lokasi Tinggal</label>
                        <div class="col-6 col-sm-8 col-lg-3">
                            <select name="provinsi" id="provinsi" class="form-control">
                                @if ($p->namaProvTinggal!=null)
                                <option value="{{$p->provTinggalID}}">{{$p->namaProvTinggal}}</option>
                                @else
                                <option value="">Pilih Provinsi</option>
                                @endif
                                @foreach ($p->provinsi as $t)
                                    <option value="{{$t->id}}">{{$t->province}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-sm-8 col-lg-3">
                            <select name="TempatTinggalID" id="kota" class="form-control">
                                @if ($p->NamaTempatTinggal!=null)
                                <option value="{{$p->TempatTinggalID}}">{{$p->NamaTempatTinggal}}</option>
                                @else
                                <option value="">Pilih Kota</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="TempatKerjaID" >Lokasi Tempat Kerja</label>
                        <div class="col-6 col-sm-8 col-lg-3">
                            <select name="provinsiLokKerja" id="provinsiLokKerja" class="form-control">
                                @if ($p->namaProvKerja!=null)
                                <option value="{{$p->provKerjaID}}">{{$p->namaProvKerja}}</option>
                                @else
                                <option value="">Pilih Provinsi</option>
                                @endif
                                @foreach ($p->provinsi as $t)
                                    <option value="{{$t->id}}">{{$t->province}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-sm-8 col-lg-3">
                            <select name="TempatKerjaID" id="kotaKerja" class="form-control">
                                @if ($p->NamaTempatKerja!=null)
                                <option value="{{$p->TempatKerjaID}}">{{$p->NamaTempatKerja}}</option>
                                @else
                                <option value="">Pilih Kota</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="PekerjaanID" >Pekerjaan</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <select name="PekerjaanID" id="PekerjaanID" class="form-control">
                            @if ($p->TipePekerjaan!=null)
                            <option value="{{$p->PekerjaanID}}">{{$p->TipePekerjaan}}</option>
                            @else
                            <option value="">Pilih</option>
                            @endif
                            @foreach ($p->pekerjaan as $t)
                                <option value="{{$t->PekerjaanID}}">{{$t->TipePekerjaan}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="PenghasilanID" >Penghasilan</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <select name="PenghasilanID" id="PenghasilanID" class="form-control">
                            @if ($p->RangePenghasilan!=null)
                            <option value="{{$p->PenghasilanID}}">{{$p->RangePenghasilan}}</option>
                            @else
                            <option value="">Pilih</option>
                            @endif
                            @foreach ($p->penghasilan as $t)
                                <option value="{{$t->PenghasilanID}}">{{$t->RangePenghasilan}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="KodeProject">Project</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" id="KodeProject" type="text" name="KodeProject" value="{{$p->KodeProject}}" disabled>
                        <input type="hidden" name="KodeProject" value="{{$p->KodeProject}}" >
                        @error('KodeProject')
                            <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="SumberDataID" >Source</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <select name="SumberDataID" id="SumberDataID" class="form-control">
                            @if ($p->NamaSumber!=null)
                            <option value="{{$p->SumberDataID}}">{{$p->NamaSumber}}</option>
                            @else
                            <option value="">Pilih</option>
                            @endif
                            @foreach ($p->source as $item)
                                <option value="{{$item->SumberDataID}}">{{$item->NamaSumber}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="KodeAds" >Kode Iklan</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <select name="KodeAds" id="KodeAds" class="form-control">
                            @if ($p->JenisAds!=null)
                            <option value="{{$p->KodeAds}}">{{$p->JenisAds}}</option>
                            @else
                            <option value="">Pilih</option>
                            @endif
                            @foreach ($p->ads as $item)
                                <option value="{{$item->KodeAds}}">{{$item->KodeAds}} - {{$item->JenisAds}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="" ></label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <button class="btn btn-space btn-success active" type="submit"><i class="icon icon-left mdi mdi-cloud-done"></i>Save</button>
                        <a href="{{url('prospects')}}"><button class="btn btn-space btn-secondary active" type="button"></i>Cancel</button></a>
                    </div>
                    </div>
                </form>
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
        App.init();
        App.dataTables();
    });

    $('#provinsi').change(function(){
        var provinsi = $(this).val();
        if(provinsi){
            $.ajax({
            type:"GET",
            url:"/getkota?provinsi="+provinsi,
            dataType: 'JSON',
            success:function(res){
                if(res){
                    $("#kota").empty();
                    $("#kota").append('<option>Pilih Kota</option>');
                    $.each(res,function(id,city){
                        $("#kota").append('<option value="'+id+'">'+city+'</option>');
                    });
                }else{
                $("#kota").empty();
                }
            }
            });
        }else{
            $("#kota").empty();
        }
    });

    $('#provinsiLokKerja').change(function(){
        var provinsi = $(this).val();
        if(provinsi){
            $.ajax({
            type:"GET",
            url:"/getkota?provinsi="+provinsi,
            dataType: 'JSON',
            success:function(res){
                if(res){
                    $("#kotaKerja").empty();
                    $("#kotaKerja").append('<option>Pilih Kota</option>');
                    $.each(res,function(id,city){
                        $("#kotaKerja").append('<option value="'+id+'">'+city+'</option>');
                    });
                }else{
                $("#kotaKerja").empty();
                }
            }
            });
        }else{
            $("#kotaKerja").empty();
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

    $('#Status').change(function(){
        var st = $(this).val();
        if(st === 'Closing'){
            document.getElementById('NotInterestedID').style.display = 'none';
            document.getElementById('Closing').style.display = 'block';
        }
        if(st === 'Not Interested'){
            document.getElementById('Closing').style.display = 'none';
            document.getElementById('NotInterestedID').style.display = 'block';
        }
        if(st == 'Process'){
            document.getElementById('Closing').style.display = 'none';
            document.getElementById('NotInterestedID').style.display = 'none';
        }
    });
</script>
@endsection
