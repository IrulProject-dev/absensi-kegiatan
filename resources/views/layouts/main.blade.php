<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles & Scripts (Managed by Vite) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- External CSS (if any, e.g., Bootstrap Icons, DataTables CSS) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">

    @stack('styles')
  </head>
  <body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
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
            {{-- <li class="nav-item">
              <a class="nav-link {{ Route::is('absen.index') ? 'active' : '' }}" {{ Route::is('absen.index') ? 'aria-current=page' : '' }} href="{{ route('absen.index', ['slug' => 'your-slug']) }}"><i class="bi bi-card-checklist"></i> Absen</a>
            </li> --}}
            <li class="nav-item">
              <a class="nav-link {{ Route::is('prasence.index') ? 'active' : '' }}" {{ Route::is('prasence.index') ? 'aria-current=page' : '' }} href="{{ route('prasence.index') }}"><i class="bi bi-calendar-check"></i> Daftar Absensi</a>
            </li>
          </ul>
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
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
                  {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <i class="bi bi-pencil-square"></i> {{ __('Edit Profile') }}
                  </a> --}}
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

    <!-- External JS (if any, e.g., jQuery, DataTables JS) -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

    @stack('js')
  </body>
</html>
