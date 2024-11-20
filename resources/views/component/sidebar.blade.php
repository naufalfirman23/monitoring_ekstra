

@if(Auth::check() && Auth::user()->role === 'guru')
<div id="layoutSidenav_nav">
    <nav class="sidenav bg-primary shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading d-sm-none">Account</div>
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Alerts
                    <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                </a>
                <a class="nav-link d-sm-none" href="/guru">
                    <div class="nav-link-icon"><i data-feather="mail"></i></div>
                    Messages
                    <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                </a>
                <a href="/guru">
                    <div class="sidenav-menu-heading fs-3 text-center text-white">{{ Auth::user()->name }} </div>
                </a>
                
                <!-- Menu Item Kelola Ekstrakurikuler -->
                <a class="nav-link collapsed text-white bg-light-hover" href="/guru/kelas" data-bs-toggle="collapse" data-bs-target="#collapseEkstrakurikuler" aria-expanded="false" aria-controls="collapseEkstrakurikuler">
                    <div class="nav-link-icon"><i class="fas fa-folder text-white"></i></div>
                    Kelas/Ekskul
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                </a>
                <!-- Menu Item Kelola Ekstrakurikuler -->
                <a class="nav-link collapsed text-white bg-light-hover" href="/guru/absen" data-bs-toggle="collapse" data-bs-target="#collapseEkstrakurikuler" aria-expanded="false" aria-controls="collapseEkstrakurikuler">
                    <div class="nav-link-icon"><i class="fas fa-folder text-white"></i></div>
                    Buat Absen
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                </a>
                <a class="nav-link collapsed text-white bg-light-hover" href="/guru/absen/rekap" data-bs-toggle="collapse" data-bs-target="#collapseEkstrakurikuler" aria-expanded="false" aria-controls="collapseEkstrakurikuler">
                    <div class="nav-link-icon"><i class="fas fa-folder text-white"></i></div>
                    Rekap Nilai
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                </a>
                
            </div>
        </div>
    </nav>
</div>
@elseif(Auth::check() && Auth::user()->role === 'admin')
<div id="layoutSidenav_nav">
    <nav class="sidenav bg-primary shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading d-sm-none">Account</div>
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Alerts
                    <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                </a>
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="mail"></i></div>
                    Messages
                    <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                </a>
                <a class="nav-link d-sm-none" href="/admin">
                    <div class="sidenav-menu-heading fs-3 text-center text-white">Admin</div>
                </a>
                
                <!-- Menu Item Kelola Ekstrakurikuler -->
                <a class="nav-link collapsed text-white bg-light-hover" href="/admin/ekstrakurikuler" data-bs-toggle="collapse" data-bs-target="#collapseEkstrakurikuler" aria-expanded="false" aria-controls="collapseEkstrakurikuler">
                    <div class="nav-link-icon"><i class="fas fa-folder text-white"></i></div>
                    Kelola Ekstrakurikuler
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                </a>
                
                <!-- Menu Item Kelola Siswa -->
                <a class="nav-link collapsed text-white bg-light-hover" href="/admin/siswa" data-bs-toggle="collapse" data-bs-target="#collapseSiswa" aria-expanded="false" aria-controls="collapseSiswa">
                    <div class="nav-link-icon"><i class="fas fa-folder text-white"></i></div>
                    Kelola Siswa
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                </a>

                <!-- Menu Item Kelola Akun -->
                <a class="nav-link collapsed text-white bg-light-hover" href="/admin/gurus" data-bs-toggle="collapse" data-bs-target="#collapseAkun" aria-expanded="false" aria-controls="collapseAkun">
                    <div class="nav-link-icon"><i class="fas fa-folder text-white"></i></div>
                    Kelola Guru
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                </a>

                <!-- Menu Item Kelola Guru -->
                <a class="nav-link collapsed text-white bg-light-hover" href="/admin/users" data-bs-toggle="collapse" data-bs-target="#collapsePengumuman" aria-expanded="false" aria-controls="collapsePengumuman">
                    <div class="nav-link-icon"><i class="fas fa-folder text-white"></i>
                    </div>
                    Kelola Akun
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                </a>
                <!-- Menu Item Kelola Pengumuman -->
                <a class="nav-link collapsed text-white bg-light-hover" href="/admin/pengumuman" data-bs-toggle="collapse" data-bs-target="#collapsePengumuman" aria-expanded="false" aria-controls="collapsePengumuman">
                    <div class="nav-link-icon"><i class="fas fa-folder text-white"></i>
                    </div>
                    Kelola Pengumuman
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                </a>
                
            </div>
        </div>
    </nav>
</div>
@endif