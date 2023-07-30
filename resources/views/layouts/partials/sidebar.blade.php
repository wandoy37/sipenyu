<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('assets2/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="{{ route('dashboard.index') }}" aria-expanded="true">
                        <span class="text-capitalize">
                            {{ Auth::user()->name }}
                            <span class="user-level">{{ Auth::user()->role }}</span>
                            {{-- <span class="caret"></span> --}}
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">MENU NAVIGATION</h4>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'kabupaten-kota' ? 'active' : '' }}">
                    <a href="{{ route('kabkota.index') }}">
                        <i class="fas fa-file-contract"></i>
                        <p>Kab Kota</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'kecamatan' ? 'active' : '' }}">
                    <a href="{{ route('kecamatan.index') }}">
                        <i class="fas fa-file-alt"></i>
                        <p>Kecamatan</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'kantor' ? 'active' : '' }}">
                    <a href="{{ route('kantor.index') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Kantor BPP</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'tenaga-kerja' ? 'active' : '' }}">
                    <a href="{{ route('pegawai.index') }}">
                        <i class="fas fa-users"></i>
                        <p>Tenaga Kerja</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'api-token' ? 'active' : '' }}">
                    <a href="{{ route('api-token.index') }}">
                        <i class="fas fa-key"></i>
                        <p>API Token</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
