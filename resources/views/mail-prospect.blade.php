<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Makutapro</title>
    <style>
        p{
            font-family: raleway;
            font-weight: 700;
            text-align: center;
            color: black;
            opacity: 0.4;
            text-align: center;
        }
        #nav{
            background-color: #FE9800;
        }
    </style>
</head>
<body>
    <nav id="nav" class=" navbar navbar-expand-lg navbar-light fixed-top">  
        <div class="container">
            <a class="navbar-brand"  href="https://makutacommunication.co.id" target="blank">
                <img class="logo img-fluid " style="width : 150px; height : 50px;" src="https://developer.makutapro.id/storage/uploaded/logo.png" >
            </a>
        </div>
    </nav>
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 col-md-12 col-lg-8 ml-5">
                <p>Hallo {{$data['namaprospect']}} anda menerima database baru an. {{$data['namaprospect']}} untuk project {{$data['namaproject']}}. Harap segera Follow Up database tersebut. Klik link dibawah ini untuk login :</p>
                <p>Link Aplikasi : <a href="{{$data['link_apps']}}">{{$data['link_apps']}}</a></p>
                <p>Link Website  : <a href="{{$data['link_web']}}">{{$data['link_web']}}</a> </p> 
            </div>
        </div>
    </div>
</body>
</html>