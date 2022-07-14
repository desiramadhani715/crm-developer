<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{asset('images/logo_makutapro2.png')}}">
    <title>Makuta CRM</title>
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css"/>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-login">
      <div class="be-content">
          <div class="main-content container-fluid">
              <div class="splash-container">
              @if(session('status'))
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <div class="alert alert-contrast alert-success alert-dismissible" role="alert">
                      <div class="icon"><span class="mdi mdi-check"></span></div>
                      <div class="message">
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button><strong>Good!</strong> {{session('status')}}
                      </div>
                    </div>
              @endif
              @if(session('error'))
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <div class="alert alert-contrast alert-danger alert-dismissible" role="alert">
                    <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                    <div class="message">
                      <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button><strong></strong> {{session('error')}}
                    </div>
                  </div>
              @endif
            <div class="card card-border-color card-border-color-primary">
              <div class="card-header"><img class="logo-img img-rounded" src="{{asset('images/logo_makutapro2.png')}}" alt="logo" width="150" height="150" style="border-radius: 75px; border :1px solid #ccc;"><span class="splash-description"><h3 class="mb-0">Developer</h3></span></div>
              <div class="card-body">
                <form action="postLogin" method="POST" role="form">
                    @csrf
                  <div class="form-group">
                    <input class="form-control" id="username" type="text" placeholder="Username" autocomplete="off" name="UsernameKP">
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="password" type="password" placeholder="Password" name="PasswordKP">
                  </div>
                  <div class="form-group row login-tools">
                    <div class="col-6 login-remember">
                      {{-- <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="checkbox1">
                        <label class="custom-control-label" for="checkbox1">Remember Me</label>
                      </div> --}}
                    </div>
                    <div class="col-6 login-forgot-password"><a href="pages-forgot-password.html">Forgot Password?</a></div>
                  </div>
                  <div class="form-group login-submit"><button type="submit" class="btn btn-primary btn-xl" data-dismiss="modal">Sign me in</button></div>
                </form>
              </div>
            </div>
            <div class="splash-footer"><span>Don't have an account? <a href="{{url('register')}}">Sign Up</a></span></div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{asset('dist/html/assets/lib/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/js/app.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//-initialize the javascript
      	App.init();
      });

    </script>
  </body>
</html>
