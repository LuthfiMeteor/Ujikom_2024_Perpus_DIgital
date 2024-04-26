@extends('dashboard.layouts.app')

@section('content')
    <div class="container">
        <div class="">
            <h2>Dashboard</h2>
            <p> <a href="#" class="link-underline-secondary">Dashboard /</a></p>
        </div>
        <div class="row mt-2">
            {{-- <div class="col-md-3">
                <div class="card">
                    <div class="card-header">{{ __('Total Buku') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @php
                            $buku = App\Models\BukuModel::count();
                        @endphp

                        <div class="btn btn-primary">{{ $buku }}</div>
                    </div>
                </div>
            </div>
            @role('addmin')
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">{{ __('Jumlah Petugas') }}</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @php
                                $ttlPetugas = App\Models\User::role('petugas')->count();
                            @endphp
                            <div class="btn btn-primary">{{ $ttlPetugas }}</div>
                        </div>
                    </div>
                </div>
            @endrole --}}

            <div class="col-6">
                <div id="chart">
                    {!! $chart->container() !!}
                </div>
            </div>
            <div class="col-6">
                <div id="rating">
                    {!! $rating->container() !!}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('Larapex/chart.js') }}"></script>
    {{-- <script src="{{ $rating->cdn() }}"></script> --}}
    {!! $chart->script() !!}
    {!! $rating->script() !!}
@endsection
