@extends('layouts.app')

@section('content')
    <div class="container position-absolute top-50 start-50 translate-middle">
        <H2 class="text-center">LOGIN</H2>
        <div class="d-flex justify-content-center">
            <div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row mb-3">

                        <div class="col-md-12">
                            <label for="email" class="col-form-label">EMAIL</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="password" class=" col-form-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <center>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a href="{{ route('password.request') }}" class="">Reset Pasword</a>

                                <hr>
                                <a href="{{ route('googleLogin') }}" class="btn btn-dark"><img
                                        src="{{ asset('image/7123025_logo_google_g_icon.png') }}" alt=""
                                        width="40px"></a>

                                @if ($errors->has('google'))
                                    <div class="alert alert-danger mt-1">
                                        {{ $errors->first('google') }}
                                    </div>
                                @endif

                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="card col-12">
            <H2 class="text-center">LOGIN</H2>

        </div> --}}
    </div>
@endsection
