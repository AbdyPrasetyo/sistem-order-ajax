<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">




    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">Sistem Order</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link {{ Request::is('barang') ? 'active' : '' }}" aria-current="page" href="{{ url('barang') }}">Daftar barang</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link {{ Request::is('suplier') ? 'active' : '' }}" href="{{ url('suplier') }}">Daftar Suplier</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link {{ Request::is('transaksi') ? 'active' : '' }}" href="{{ url('transaksi') }}">Daftar Pembelian</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link {{ Request::is('stok') ? 'active' : '' }}" href="{{ url('stok') }}">Daftar Stock</a>
                  </li>

                </ul>
              </div>
            </div>
          </nav>

            @yield('content')
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    </body>
</html>
