<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link rel="shortcut icon" href="{{ asset('image/171322.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.3-dist\css\bootstrap.min.css') }}">
</head>

<body>
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="fs-5 fw-bold ">TAMBAHKAN PASSWORD</p>
                            <p class="text-break">Akunmu Login Dengan Google, Untuk Selanjutnya Mohon Tambahkan Password
                            </p>
                        </div>
                        <form action="{{ route('addPasswordSubmit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required
                                    id="exampleInputPassword1" placeholder="****">
                            </div>
                            <button type="submit" class="btn btn-primary float-end">Konfirmasi!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('popper/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap-5.3.3-dist/js/bootstrap.min.js') }}"></script>
    @stack('script')
</body>

</html>
