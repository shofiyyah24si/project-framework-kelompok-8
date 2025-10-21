<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />

    <title>@yield('title', 'Sistem Kebencanaan - Dashboard')</title>

    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and Icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('assets/css/fonts.min.css') }}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    @stack('styles')
  </head>

  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
              <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20">
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
              <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
          </div>
        </div>

        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>

              <li class="nav-item {{ request()->is('kejadian*') ? 'active' : '' }}">
                <a href="{{ route('kejadian.index') }}">
                  <i class="fas fa-fire"></i>
                  <p>Kejadian Bencana</p>
                </a>
              </li>

              <li class="nav-item {{ request()->is('relawan*') ? 'active' : '' }}">
                <a href="{{ route('relawan.index') }}">
                  <i class="fas fa-users"></i>
                  <p>Data Relawan</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <!-- Main Panel -->
      <div class="main-panel">
        <!-- Navbar -->
        <div class="main-header">
          <nav class="navbar navbar-header navbar-expand-lg border-bottom fixed-top shadow-sm bg-white">
            <div class="container-fluid">
              <!-- Dihilangkan tulisan judul di navbar -->
            </div>
          </nav>
        </div>
        <!-- End Navbar -->

        <!-- Page Content -->
        <div class="container-fluid">
          <div class="page-inner mt-5 pt-4">
            @yield('content')
          </div>
        </div>

        <!-- Footer -->
        <footer class="footer mt-5">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Licenses</a></li>
              </ul>
            </nav>
            <div class="copyright">
              &copy; {{ date('Y') }} | Sistem Kebencanaan by 
              <a href="http://www.themekita.com" target="_blank">ThemeKita</a>
            </div>
          </div>
        </footer>
      </div>
      <!-- End Main Panel -->
    </div>

    <!-- JS Core -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

    <!-- Script tambahan agar tidak bisa scroll ke bawah -->
    <script>
      let lastScrollTop = 0;
      window.addEventListener("scroll", function() {
        let st = window.pageYOffset || document.documentElement.scrollTop;
        if (st > lastScrollTop) {
          // Cegah scroll ke bawah
          window.scrollTo(0, lastScrollTop);
        } else {
          // Boleh scroll ke atas
          lastScrollTop = st <= 0 ? 0 : st;
        }
      }, false);
    </script>

    @stack('scripts')
  </body>
</html>
