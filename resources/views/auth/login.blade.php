<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"
        integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <video autoplay muted loop id="myVideo" style="position: fixed;width:100%">
        <source src="{{ asset('videos/space.mov') }}" type="video/mp4">
    </video>
    <div class="login-box" style="width: 30%">

        <div class="card">

            <div class="card-header" align="center">
                <img src="{{ asset('img/lo_go.png') }}" class = "img-responsive center-block d-block "
                    style="width:50%;" alt="description of myimage">
            </div>

            <div class="card-body">

                @if ($errors->any())
                <div class="alert fade show"
                            style="background-color: #FFCCCB;color:#8B0000;font-family:arial;" role="alert" align="center">
                            {{ $errors->first() }}
                        </div>
                @endif
                <form action="{{ route('login.custom') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" placeholder="{{__('username')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                              <box-icon type='solid' name='user'></box-icon>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="{{__('password')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                              <box-icon name='lock-alt' type='solid' ></box-icon>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col justify-content-center">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
</body>

</html>
