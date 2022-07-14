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
          <li class="breadcrumb-item active">Add New</li>
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
            <div class="card-header card-header-divider">Add New Prospects</div>
            <div class="card-body">
              <form action="{{url('/prospects/create')}}" method="POST" role="form">
                  @csrf
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="NamaProspect">Nama</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="NamaProspect" type="text" name="NamaProspect" value="{{old('NamaProspect')}}">
                    @error('NamaProspect')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="EmailProspect">Email</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="EmailProspect" type="email" name="EmailProspect" placeholder="you@example.com" value="{{old('EmailProspect')}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Hp">Hp</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <div class="row">
                          <div class="col-4 col-sm-3 col-lg-2">
                              <select name="KodeNegara" class="form-control">
                                  <option value="+62">+62</option>
                                  <option value="+60">+60</option>
                                  <option value="+63">+63</option>
                                  <option value="+65">+65</option>
                                  <option value="+66">+66</option>
                                  <option value="+81">+81</option>
                                  <option value="+82">+82</option>
                                  <option value="+84">+84</option>
                                  <option value="+86">+86</option>
                                  <option value="+91">+91</option>
                                  <option value="+358">+358</option>
                                  <option value="+61">+61</option>
                                  <option value="+234">+234</option>
                                  <option value="+49">+49</option>
                                  <option value="+974">+974</option>
                                  <option value="+966">+966</option>
                                  <option value="+886">+886</option>
                              </select>
                          </div>
                          <div class="col-8 col-sm-5 col-lg-10 ">
                              <input class="form-control" id="Hp" type="number" placeholder="cth : 08123456789" name="Hp" value="{{ old('Hp')}}">
                          </div>
                      </div>
                    @error('Hp')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Message" >Pesan</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <textarea class="form-control" id="Message" name="Message" rows="5" value="{{ old('Message')}}"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="KodeProject" >Project</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <select name="KodeProject" id="KodeProject" class="form-control">
                        <option value="">Pilih</option>
                        @foreach ($project as $item)
                            <option value="{{$item->KodeProject}}">{{$item->NamaProject}}</option>
                        @endforeach
                    </select>
                    @error('KodeProject')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="KodePlatform" >Platform</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <select name="KodePlatform" id="KodePlatform" class="form-control">
                        <option value="">Pilih</option>
                        @foreach ($platform as $item)
                            <option value="{{$item->KodePlatform}}">{{$item->NamaPlatform}}</option>
                        @endforeach
                    </select>
                    @error('KodePlatform')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="SumberDataID" >Source</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                      <div class="row">
                          <div class="col-6 col-md-12 col-lg-6">
                              <select name="SumberDataID" id="SumberDataID" class="form-control">
                                  <option value="">Pilih</option>
                                  @foreach ($source as $item)
                                      <option value="{{$item->SumberDataID}}">{{$item->NamaSumber}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-6 col-md-12 col-lg-6">
                              <input class="form-control" id="NoteSumberData" type="text" name="NoteSumberData" value="{{old('NoteSumberData')}}" placeholder="Source Note">
                          </div>
                      </div>
                  </div>
                </div>
                 <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Campaign" >Campaign</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                      <select name="Campaign" class="form-control">
                          <option value="">Pilih</option>
                          @foreach ($campaign as $item)
                              <option value="{{$item->NamaCampaign}}">{{$item->NamaCampaign}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="KodeAds" >Kode Iklan</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <select name="KodeAds" id="KodeAds" class="form-control">
                        <option value="">Pilih</option>
                        @foreach ($kode_iklan as $item)
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
</script>
@endsection
