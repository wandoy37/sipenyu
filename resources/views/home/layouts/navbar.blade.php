<section>
    <nav class="navbar navbar-expand-lg navbar-dark nav-bg-green">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="{{ asset('assets') }}/img/logo.png" alt="Logo" width="40"
                    class="d-inline-block align-text-top img-navbar">
                SIPP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->segment(1) == '' ? 'active' : '' }}" aria-current="page"
                            href="{{ route('index') }}">
                            <i class="fas fa-home"></i>
                            Home
                        </a>
                    </li>

                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->segment(1) == 'layanan' ? 'active' : '' }}"
                            href="{{ route('layanan') }}">
                            Layanan
                        </a>
                    </li>
                </ul>
                <div class="d-flex ms-4">
                    <a href="{{ route('login') }}" class="btn btn-warning">Oprator</a>
                </div>
            </div>
        </div>
    </nav>
</section>
