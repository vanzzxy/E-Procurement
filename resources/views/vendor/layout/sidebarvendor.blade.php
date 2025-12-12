<head>
    <title> @yield('tittle') </title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/vendor/penawaran.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebarvendor.css') }}">
        @stack('styles')
</head>

<style>
        /* Tambahan submenu animasi */
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

        /* Highlight aktif */
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
                <span class="user-info">VENDOR</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('vendor.beranda') }}" class="sidebar-link" id="beranda"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="{{ route('vendor.penawaran') }}"><i class="fas fa-handshake"></i> Penawaran</a></li>
                <li><a href="{{ route('vendor.inbox') }}" class="sidebar-link" id="inboxvendor"><i class="fas fa-inbox"></i> Inbox</a></li>
                <li><a href="{{ route('vendor.kontrak') }}" class="sidebar-link" id="kontrakvendor"><i class="fas fa-file-contract"></i> Kontrak</a></li>
                <li><a href="{{ route('vendor.pengiriman') }}" class="sidebar-link" id="pengiriman"><i class="fas fa-truck"></i> Pengiriman</a></li>
                <li class="has-submenu" id="riwayat">
                    <a href="javascript:void(0);"><i class="fas fa-history"></i> Riwayat <i class="fas fa-chevron-down" style="margin-left:auto;"></i></a>
                    <ul class="submenu">
                        <li><a href="{{ route('vendor.riwayatmasuk') }}" class="sidebar-link" id="riwayatmasuk"><i class="fas fa-sign-in-alt"></i> Riwayat Masuk</a></li>
                        <li><a href="{{ route('vendor.riwayatkeluar') }}" class="sidebar-link" id="riwayatkeluar"><i class="fas fa-sign-out-alt"></i> Riwayat Keluar</a></li>
                    </ul>
                <li><a href="{{ route('vendor.profile', ['id' => auth()->user()->vendor->id_vendor]) }}" class="sidebar-link" id="profil"><i class="fas fa-user"></i> Profil</a></li>
                <li>
                    <a href="{{ route('logout') }}" class="sidebar-link" id="logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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


    <script>
        function toggleSidebar() {
            var sidebar = document.querySelector('.sidebar');
            var mainContainer = document.querySelector('.main-container');
            
            sidebar.classList.toggle('collapsed');
            mainContainer.style.marginLeft = sidebar.classList.contains('collapsed') ? '80px' : '220px';
        }
    
        document.addEventListener('DOMContentLoaded', function() {
            var currentLocation = window.location.href;
            var menuItems = document.querySelectorAll('.sidebar-menu a');

            // Highlight link aktif (tidak menutup submenu lain)
            menuItems.forEach(function(item) {
                if (item.href === currentLocation) {
                    item.classList.add('active');
                    let parentSubmenu = item.closest('.submenu');
                    if (parentSubmenu) {
                        parentSubmenu.classList.add('show');
                    }
                }
            });

            // Toggle submenu tanpa auto-close
            var submenuParents = document.querySelectorAll('.has-submenu > a');
            submenuParents.forEach(function(parent) {
                parent.addEventListener('click', function(e) {
                    e.preventDefault();
                    var submenu = parent.nextElementSibling;
                    submenu.classList.toggle('show');
                });
            });

            // Scroll effect sidebar
            var sidebar = document.querySelector('.sidebar');
            sidebar.addEventListener('mouseenter', function() {
                sidebar.style.overflowY = 'auto';
            });
            sidebar.addEventListener('mouseleave', function() {
                sidebar.style.overflowY = 'hidden';
            });
        });
    </script>

@stack('scripts')
