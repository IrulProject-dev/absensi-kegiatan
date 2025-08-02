<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles & Scripts (Managed by Vite) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">

    <style>
      :root {
        --primary-blue-sky: #38b6ff;
        --primary-blue-dark: #0096ff;
        --nav-shadow: 0 4px 12px rgba(56, 182, 255, 0.15);
      }

      /* Modern Navbar */
      .navbar {
        background: white !important;
        box-shadow: var(--nav-shadow);
        padding: 0.5rem 0;
      }

      .navbar-brand {
        font-weight: 700;
        color: var(--primary-blue-dark) !important;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
      }

      .navbar-brand::before {
        content: "";
        display: inline-block;
        width: 30px;
        height: 30px;
        background: var(--primary-blue-sky);
        border-radius: 50%;
        margin-right: 10px;
      }

      .nav-link {
        color: #555 !important;
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        margin: 0 0.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
      }

      .nav-link:hover, .nav-link.active {
        color: white !important;
        background: var(--primary-blue-sky);
      }

      .nav-link i {
        margin-right: 6px;
      }

      .nav-link.active::after {
        content: "";
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        background: var(--primary-blue-sky);
        border-radius: 50%;
      }

      .navbar-toggler {
        border: none;
        padding: 0.5rem;
      }

      .navbar-toggler:focus {
        box-shadow: 0 0 0 3px rgba(56, 182, 255, 0.3);
      }

      /* Dropdown Menu */
      .dropdown-menu {
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 0.5rem;
      }

      .dropdown-item {
        border-radius: 6px;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
      }

      .dropdown-item:hover {
        background: var(--primary-blue-sky);
        color: white !important;
      }

      /* Responsive adjustments */
      @media (max-width: 991.98px) {
        .navbar-collapse {
          padding: 1rem 0;
        }

        .nav-link {
          margin: 0.25rem 0;
        }
      }
    </style>

    @stack('styles')
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" {{ Route::is('home') ? 'aria-current=page' : '' }} href="{{ route('home') }}"><i class="bi bi-house-door"></i> Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::is('prasence.index') ? 'active' : '' }}" {{ Route::is('prasence.index') ? 'aria-current=page' : '' }} href="{{ route('prasence.index') }}"><i class="bi bi-calendar-check"></i> Daftar Absensi</a>
            </li>
          </ul>

          <!-- Right Side Of Navbar (Unchanged Profile Section) -->
          <ul class="navbar-nav ms-auto">
            @guest
              @if (Route::has('login'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> {{ __('Login') }}</a>
                </li>
              @endif

              @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> {{ __('Register') }}</a>
                </li>
              @endif
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- External JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

    @stack('js')
  </body>
</html>
