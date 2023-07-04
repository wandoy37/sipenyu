<!DOCTYPE html>
<html>
<link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet">
<!-- Style (Custome UPTD BPPSDMP) -->
<link rel="stylesheet" href="{{ asset('assets') }}/style.css">
<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/5983388006.js" crossorigin="anonymous"></script>

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/img/logo.png">


<style>
    body,
    html {
        height: 100%;
        margin: 0;
    }

    .bgimg {
        background-image: url('https://www.w3schools.com/w3images/forestbridge.jpg');
        height: 100%;
        background-position: center;
        background-size: cover;
        position: relative;
        color: white;
        font-family: "Courier New", Courier, monospace;
        font-size: 25px;
    }

    .topleft {
        position: absolute;
        top: 0;
        left: 16px;
    }

    .bottomleft {
        position: absolute;
        bottom: 0;
        left: 16px;
    }

    .middle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    hr {
        margin: auto;
        width: 40%;
    }
</style>

<body>

    <div class="bgimg">
        <div class="middle">
            <h1 class="font-style-1"><i>COMING SOON</i></h1>
            <hr>
            <p>UPTD</p>
            <p>BALAI PENYULUHAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA PERTANIAN</p>
            </br>
            <a href="{{ route('index') }}" class="btn btn-outline-warning mb-4">
                <i class="fas fa-home"></i>
                BERANDA
            </a>
            </br>
            <b class="mt-4">SCAN HERE</p>
                <div class="mt-2">
                    {{ QrCode::size(200)->generate(route('index')) }}
                </div>
                <div class="mt-4">
                    <p>SISTEM INFORMASI PENYULUHAN DAN TEKNIS PERTANIAN</p>
                </div>
        </div>
    </div>

</body>

</html>
