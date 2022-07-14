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
      <h2 class="page-head-title">Agent</h2>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb page-head-nav">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/agent')}}">Agent</a></li>
          <li class="breadcrumb-item active">Add New</li>
        </ol>
      </nav>
    </div>
    <div class="main-content container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Add New Agent</div>
            <div class="card-body">
              <form action="{{url('/agent/create')}}" method="POST" role="form" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="project" >Project</label>
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
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="KodeAgent">Kode Agent</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="KodeAgent" type="text" name="KodeAgent" value="{{old('KodeAgent')}}" onkeyup="this.value = this.value.toUpperCase()">
                    @error('KodeAgent')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="NamaAgent">Nama Agent</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="NamaAgent" type="text" name="NamaAgent" value="{{old('NamaAgent')}}">
                    @error('NamaAgent')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Pic">Nama Koordinator</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="Pic" type="text" name="Pic" value="{{old('Pic')}}">
                    @error('Pic')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="PhotoUser">Photo</label>
                    <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" id="inputGroupFile01" type="file" name="PhotoUser">
                        @error('PhotoUser')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Email">Email</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="Email" type="email" name="Email" value="{{old('Email')}}" placeholder="you@example.com">
                    @error('Email')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="Hp">Hp</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="Hp" type="text" name="Hp" value="{{old('Hp')}}">
                    @error('Hp')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="UsernameKP">Username</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="UsernameKP" type="text" name="UsernameKP" value="{{old('UsernameKP')}}">
                    @error('UsernameKP')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="PasswordKP">Password</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="PasswordKP" type="password" name="PasswordKP" value="{{old('PasswordKP')}}">
                    @error('PasswordKP')
                        <div class="card-subtitle mt-1 ml-1" style="color: red;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                {{-- <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="">Confirm Password</label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <input class="form-control" id="" type="text" name="">
                  </div>
                </div> --}}

                <div class="form-group row">
                  <label class="col-12 col-sm-3 col-form-label text-sm-right" for="" ></label>
                  <div class="col-12 col-sm-8 col-lg-6">
                    <button class="btn btn-space btn-success active" type="submit"><i class="icon icon-left mdi mdi-cloud-done"></i>Save</button>
                    <a href="{{url('agent')}}"><button class="btn btn-space btn-secondary active" type="button"></i>Cancel</button></a>
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
