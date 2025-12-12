<head>
    <meta charset="UTF-8">
    <title>@yield('tittle')</title>

    <!-- Bootstrap 5.3 (single version) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/vendor/penawaran.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebaradmin.css') }}">

    @stack('styles')
</head>

<style>
    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        list-style: none;
        padding-left: 40px;
    }

    .submenu.show {
        max-height: 500px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .sidebar-menu a.active {
        background-color: #fff;
        color: #000 !important;
        border-radius: 5px;
        margin-left: 3%;
        margin-right: 3%;
    }
</style>

<body>
    <div class="container-me">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('img/iconvendor.jpg') }}" alt="Logo" class="sidebar-logo">
                <span class="user-info">ADMIN</span>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.beranda') }}" class="sidebar-link" id="berandaadmin"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="{{ route('vendor.index') }}" class="sidebar-link" id="daftarvendor"><i class="fas fa-users"></i> Daftar Vendor</a></li>
                <li><a href="{{ route('dcr.index') }}" class="sidebar-link" id="daftarcalonrekanan"><i class="fas fa-users"></i> Daftar Calon Rekanan</a></li>
                <li><a href="{{ route('admin.inbox') }}" class="sidebar-link" id="inboxadmin"><i class="fas fa-inbox"></i> Inbox</a></li>

                <!-- Data Master -->
                <li class="has-submenu">
                    <a href="javascript:void(0);" class="sidebar-link">
                        <i class="fas fa-box"></i> Data Master
                        <i class="fas fa-chevron-down" style="margin-left:auto;"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('masterbarang.index') }}" class="sidebar-link"><i class="fas fa-cube"></i> Master Barang</a></li>
                        <li><a href="{{ route('masterklasifikasi') }}" class="sidebar-link"><i class="fas fa-tags"></i> Master Klasifikasi</a></li>
                        <li><a href="{{ route('masterstatus.index') }}" class="sidebar-link"><i class="fas fa-times"></i> Master Status</a></li>
                    </ul>
                </li>

                <!-- Kontrak -->
                <li class="has-submenu">
                    <a href="javascript:void(0);" class="sidebar-link">
                        <i class="fas fa-file-contract"></i> Kontrak
                        <i class="fas fa-chevron-down" style="margin-left:auto;"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('buatkontrak.create') }}" class="sidebar-link"><i class="fas fa-cube"></i> Buat Kontrak</a></li>
                        <li><a href="{{ route('buatkontrak.index') }}" class="sidebar-link"><i class="fas fa-cube"></i> Klasifikasi Kontrak</a></li>
                        <li><a href="{{ route('datakontrak.index') }}" class="sidebar-link"><i class="fas fa-database"></i> Data Kontrak</a></li>
                    </ul>
                </li>

<li>
    <a href="{{ route('admin.pengiriman.index') }}" class="sidebar-link" id="pengiriman">
        <i class="fas fa-truck"></i> Pengiriman
    </a>
</li>

                
                <!-- Riwayat -->
                <li class="has-submenu">
                    <a href="javascript:void(0);" class="sidebar-link">
                        <i class="fas fa-history"></i> Riwayat
                        <i class="fas fa-chevron-down" style="margin-left:auto;"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('admin.riwayatmasuk') }}" class="sidebar-link" id="riwayatmasuk"><i class="fas fa-sign-in-alt"></i> Riwayat Masuk</a></li>
                        <li><a href="{{ route('admin.riwayatkeluar') }}" class="sidebar-link" id="riwayatkeluar"><i class="fas fa-sign-out-alt"></i> Riwayat Keluar</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('profiladmin') }}" class="sidebar-link" id="berandaadmin"><i class="fas fa-user"></i> Profil</a></li>

                <li>
                    <a href="{{ route('logout') }}" class="sidebar-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </li>

            </ul>

            <div class="collapse-button" onclick="toggleSidebar()">
                <i class="fas fa-chevron-left"></i>
            </div>
        </div>

        <div class="main-container">
            <div class="header">
                <div class="menu" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </div>
            </div>

            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContainer = document.querySelector('.main-container');

            sidebar.classList.toggle('collapsed');
            mainContainer.style.marginLeft = sidebar.classList.contains('collapsed') ? '80px' : '220px';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const current = window.location.href;
            const menuItems = document.querySelectorAll('.sidebar-menu a');

            // Highlight active menu
            menuItems.forEach(item => {
                if (item.href === current) {
                    item.classList.add('active');
                    const submenu = item.closest('.submenu');
                    if (submenu) submenu.classList.add('show');
                }
            });

            // Toggle submenu
            document.querySelectorAll('.has-submenu > a').forEach(parent => {
                parent.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenu = parent.nextElementSibling;
                    submenu.classList.toggle('show');
                });
            });
        });
    </script>

@stack('scripts')
