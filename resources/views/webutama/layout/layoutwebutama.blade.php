<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/webutama/beranda.css') }}">
    @stack('styles')

    <!-- ================= ANIMASI TRANSISI HALAMAN ================= -->
    <style>
        /* Fade page transition */
        .fade-page {
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
        }
        .fade-page.show {
            opacity: 1;
        }
    </style>
</head>

<body>

    {{-- ================= NAVBAR ================= --}}
    <nav class="header">
        <div class="logo">
            <img src="{{ asset('img/rxyz.png') }}" alt="Logo">
        </div>

        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="/beranda" class="link">Beranda</a></li>
                <li><a href="/syarat" class="link">Aturan & Syarat</a></li>
                <li><a href="/tentang" class="link">Tentang Kami</a></li>
            </ul>
        </div>

        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="location.href='/halamanlogin'">Masuk</button>
        </div>

        <div class="nav-menu-btn">
            <i class='bx bx-menu' onclick="myMenuFunction()"></i>
        </div>
    </nav>

    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");
            if (i.className === "nav-menu") {
                i.className += " responsive";
            } else {
                i.className = "nav-menu";
            }
        }
    </script>

    {{-- ================= CONTENT ================= --}}
    <div class="main-content fade-page" id="pageContent">
        @yield('content')
    </div>

    {{-- ================= FOOTER ================= --}}
    @if (!View::hasSection('no-footer'))
    <footer class="footer">
        <div class="footer-content">

            <div class="footer-column">
                <h4>PT.XYZ Kantor Pusat</h4>
                <address>
                    Jalan Raya Surabaya - Madiun<br>
                    Km. 161 No. 1 Desa Bagi,<br>
                    Kec. Madiun, Madiun, Jawa Timur 63151<br>
                    <span class="footer-contact">
                        <i class="bx bx-phone"></i> +62 351 281205 / +62 351 281256
                    </span>
                    <span class="footer-contact">
                        <i class="bx bx-envelope"></i>
                        <a href="mailto:sekretariat@inkamultisolusi.co.id">
                            sekretariat@inkamultisolusi.co.id
                        </a>
                    </span>
                </address>
            </div>

            <div class="footer-column social-media-column">
                <h4>Sosial Media</h4>
                <ul class="social-media">
                    <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                    <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                    <li><a href="#"><i class="bx bxl-instagram"></i></a></li>
                    <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                    <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Kebijakan & Informasi</h4>
                <ul class="footer-links">
                    <li><a href="/beranda" class="link">Beranda</a></li>
                    <li><a href="/syarat" class="link">Aturan & Syarat</a></li>
                    <li><a href="/tentang" class="link">Tentang Kami</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Navigasi Cepat</h4>
                <ul class="footer-links">
                    <li><a href="/tentang">Tentang E-Proc IMS</a></li>
                    <li><a href="/tentang">Visi Misi E-Proc IMS</a></li>
                </ul>
            </div>

        </div>
    </footer>
    @endif

    @stack('scripts')

    <!-- ================= SCRIPT TRANSISI HALAMAN ================= -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const page = document.getElementById("pageContent");
            
            // Fade-in saat halaman dimuat
            page.classList.add("show");

            // Fade-out saat klik link
            const links = document.querySelectorAll("a:not([target='_blank'])");

            links.forEach(link => {
                link.addEventListener("click", function (e) {
                    const href = this.getAttribute("href");

                    if (!href || href.startsWith("#") || href.startsWith("javascript")) return;

                    e.preventDefault();
                    page.classList.remove("show");

                    setTimeout(() => {
                        window.location.href = href;
                    }, 350);
                });
            });
        });
    </script>

</body>
</html>
