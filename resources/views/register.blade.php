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
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css" />
</head>

<body class="be-splash-screen">
    <div class="be-wrapper be-login be-signup">
        <div class="be-content">
            <div class="main-content container-fluid">
                <div class="splash-container sign-up">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header"><img class="logo-img img-rounded" src="{{asset('images/logo_makutapro2.png')}}" alt="logo" width="150" height="150" style="border-radius: 75px; border :1px solid #ccc;"><span class="splash-description"><h3 class="mb-0">Developer</h3></span></div>
                        <div class="card-body">
                            <form action="register/create" method="post"><span class="splash-title pb-4">Sign Up</span>
                                @csrf
                                <div class="form-group">
                                    <input class="form-control" type="text" name="UsernameKP" required="" placeholder="Username" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="email" name="Email" required="" placeholder="E-mail" autocomplete="off">
                                </div>
                                <div class="form-group row signup-password">
                                    <div class="col-6">
                                        <input class="form-control" id="" name="PasswordKP" type="password" required="" placeholder="Password">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control" required="" type="password" placeholder="Confirm">
                                    </div>
                                </div>
                                <div class="form-group pt-2">
                                    <button class="btn btn-block btn-primary btn-xl" type="submit">Sign Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="splash-footer"><span>have an account? <a href="{{url('login')}}">Sign In</a></span></div><br>
                    <div class="splash-footer">&copy; 2021 Makuta</div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('dist/html/assets/lib/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/html/assets/js/app.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //-initialize the javascript
            App.init();
        });
    </script>
</body>

</html>
