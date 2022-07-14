@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makutapro</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  </head>

<body style="font-family: 'Montserrat',
sans-serif;">

    <div class="container-fluid  mt-md-5 mt-lg-0" >
        <div class="container pt-0 pt-md-5 pt-lg-5 d-flex align-self-center">
            <div class="row ">
                <div class="col-12 col-md-7 mb-0  mt-5" >
                    {{-- <img src="{{asset('images/makuta-01.png')}}" alt="" class="img-fluid pt-5"> --}}
                    {{-- <lottie-player id="firstLottie" src="https://lottiefiles.com/share/1l2kqjrh" style="width:100%; height: auto;"></lottie-player> --}}
                    <!--<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_p2puhbpy.json"  background="transparent"  speed="1"  style="width: 100%; height: auto;"  loop  autoplay></lottie-player>-->
                    
                    <img src="{{asset('Makuta-admin.png')}}" class="w-100 mt-5" alt="">

                </div>
                <div class="col-12 col-md-5 mt-md-5 mt-lg-5 pt-lg-5 pt-0 mt-0 ml-2 ml-lg-0" >
                  <div class="d-inline-flex p-2 bd-highlight mt-lg-5 mt-0" style="border-radius: 30px; background-color: #6F9CD3;">
                    <form action="{{ route('login') }}" method="POST" role="form" style="color: #fff;" class="py-3 mx-2">
                      @csrf
                        <h3 class="mb-3"><strong> CRM Makuta Pro</strong></h3>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-4 d-flex align-self-center">
                              <label for="">Category</label>
                            </div>
                            <div class="col-8">
                              <select name="category" id="" class="form-control" style="border-radius: 25px;" disabled>
                                <option value="">Developer</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-4 d-flex align-self-center">
                              <label for="">Username</label>
                            </div>
                            <div class="col-8">
                              <input class="form-control" id="username" type="text" autocomplete="off" name="UsernameKP" value="{{ old('username') }}" style="border-radius: 25px;">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-4 d-flex align-self-center">
                              <label for="">Password</label>
                            </div>
                            <div class="col-8">
                              <input class="form-control" id="password" type="password" name="password" style="border-radius: 25px;">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-4 d-flex align-self-center">
                            </div>
                            <div class="col-8">
                              <button type="submit" class="btn d-block w-100" style="background-color: #FB8C2E; color : #fff; border-radius:25px;">Submit</button>
                            </div>
                          </div>
                        </div>

                    </form>
                  </div>
                  <a href="http://makutadesign.com" target="blank"><img src="{{asset('images/makuta-03.png')}}" class="img-fluid mx-auto d-blox mx-lg-0" style="width: 50%;" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>



