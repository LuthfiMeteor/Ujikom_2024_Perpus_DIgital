@extends('layouts.app')
@section('content')
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="{{ asset('image/books/image/theKingIsBlack/1.jpg') }}" class="d-block mx-lg-auto img-fluid"
                    alt="Bootstrap Themes" width="300px" height="500" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3">PERPUSTAKAAN DIGITAL</h1>
                <p class="lead">Baca Buku Secara Gratis Dan Online.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    @if (Auth::check())
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 me-md-2">Daftar</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
