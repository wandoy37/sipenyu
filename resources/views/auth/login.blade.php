<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('assets2') }}/img/logo-pemprov.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets2') }}/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('assets2') }}/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets2') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets2') }}/css/atlantis.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://bppsdmsempaja.kaltimprov.go.id/img/landscape-green-color.png'); height: 100vh; background-repeat: no-repeat;background-position: center; background-repeat: no-repeat; background-size: cover;">
        <div class="container container-login animated fadeIn"
            style="background: rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px);">
            <h3 class="text-center text-white">Sign In</h3>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="login-form">
                    <div class="form-group">
                        <label for="username" class="placeholder text-white"><b>Username</b></label>
                        <br>
                        @error('username')
                            <span class="text-danger">
                                <i class="fas fa-exclamation"></i>
                                {{ $message }}
                            </span>
                        @enderror
                        <input id="username" name="username" type="text" class="form-control"
                            style="border-radius: 15px;" placeholder="username..." required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="placeholder text-white"><b>Password</b></label>
                        <br>
                        @error('password')
                            <span class="text-danger">
                                <i class="fas fa-exclamation"></i>
                                {{ $message }}
                            </span>
                        @enderror
                        {{-- <a href="#" class="link float-right">Forget Password ?</a> --}}
                        <div class="position-relative">
                            <input id="password" name="password" type="password" class="form-control"
                                style="border-radius: 15px;" placeholder="password..." required>
                            <div class="show-password">
                                <i class="icon-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-lg btn-block btn-round"
                            style="background-color: #54937c; color: white">Masuk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('assets2') }}/js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ asset('assets2') }}/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{ asset('assets2') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets2') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets2') }}/js/atlantis.min.js"></script>
</body>

</html>
