<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login | SIPP</title>
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
    <div class="wrapper wrapper-login wrapper-login-full p-0">
        <div
            class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-secondary-gradient">
            <h1 class="title fw-bold text-white mb-3">SIPP</h1>
            <p class="subtitle text-white op-7">Sistem Informasi Penyuluh dan Teknis Pertanian</p>
        </div>
        <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
            <div class="container container-login container-transparent animated fadeIn">
                <h3 class="text-center">Sign In To Admin</h3>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="login-form">
                        <div class="form-group">
                            <label for="username" class="placeholder"><b>Username</b></label>
                            <input id="username" name="username" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="placeholder"><b>Password</b></label>
                            <div class="position-relative">
                                <input id="password" name="password" type="password" class="form-control" required>
                                <div class="show-password">
                                    <i class="icon-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-action-d-flex mb-3">
                            <div class="custom-control custom-checkbox">
                                <a href="#" class="link float-right">Forget Password ?</a>
                            </div>
                            <button type="submit"
                                class="btn btn-secondary btn-round col-md-5 float-right mt-3 mt-sm-0 fw-bold">Sign
                                In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets2') }}/js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ asset('assets2') }}/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{ asset('assets2') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets2') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets2') }}/js/atlantis.min.js"></script>
</body>

</html>
