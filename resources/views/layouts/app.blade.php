<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    {{-- Select2 --}}
    
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>





    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<style>
/* =========================
   RETRO 90s AUTOMOTIVE THEME
========================= */

body {
    background: #cfcfcf;
    font-family: "Arial", "Helvetica", sans-serif;
}

/* NAVBAR */
.navbar {
    background: linear-gradient(#e5e5e5, #bdbdbd) !important;
    border-bottom: 4px solid #111;
}

.navbar-brand {
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* MAIN TITLE */
main h1 {
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #111;
    border-bottom: 4px solid #111;
    padding-bottom: 8px;
    margin-bottom: 20px;
}

/* CARD */
.card {
    border: 3px solid #111;
    box-shadow: 6px 6px 0 #000;
    background: #f2f2f2;
}

/* BUTTONS */
.btn {
    border-radius: 0;
    border: 2px solid #111;
    font-weight: bold;
    text-transform: uppercase;
}

.btn-primary {
    background: #3599b4ff;
    border-color: #111;
}



.btn-warning {
    background: #f0ad00;
}

.btn-danger {
    background: #900000;
}



/* DATATABLE PAGINATION */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border: 2px solid #111 !important;
    margin: 2px;
    background: #ddd !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #111 !important;
    color: #fff !important;
}

/* MODAL */
.modal-content {
    border: 4px solid #111;
    border-radius: 0;
    box-shadow: 8px 8px 0 #000;
}

.modal-header {
    background: #222;
    color: #fff;
    text-transform: uppercase;
}

/* INPUT */
.form-control, .form-select {
    border-radius: 0;
    border: 2px solid #111;
    background: #fff;
}

/* SELECT2 RETRO */
.select2-container--default .select2-selection--single {
    border-radius: 0;
    border: 2px solid #111;
    height: 38px;
}

/* MOBILE */
@media (max-width: 576px) {
    main h1 {
        font-size: 18px;
    }

    .btn {
        width: 100%;
    }
}
</style>

<body>
<div id="app">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                {{-- LEFT --}}
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cars') }}">
                            Data Mobil
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/brands') }}">
                            Data Merk Brand
                        </a>
                    </li>


               
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/owners') }}">
                            Data Pemilik Brand
                        </a>
                    </li>
                </ul>
                

                {{-- RIGHT --}}
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
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

    {{-- judul --}}
    

    {{-- CONTENT --}}
    <main class="py-4 container">
        <h1 class="text-left">Jovimaro Automotive</h1>
        @yield('content')
    </main>

</div>
</body>
</html>
