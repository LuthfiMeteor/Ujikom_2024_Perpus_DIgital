@extends('dashboard.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('datatables/datatables.css') }}">
@endpush
@section('content')
    <div class="container">
        <div class="">
            <h2>Edit Kategori</h2>
            <p> <a href="{{ route('home') }}" class="link-underline-secondary">Dashboard</a> / <a
                    href="{{ route('managemenKategori') }}" class="link-underline-secondary">Managemen Kategori</a> / <a
                    href="#" class="link-underline-secondary">Edit Kategori</a></p>
        </div>

        <div class="">
            <form action="{{ route('updateKategori', $kategori->id) }}" method="post">
                @csrf
                <div class="row p-2">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="kategori">Nama Kategori</label>
                            <input type="text" name="kategori" id="kategori" value="{{ $kategori->kategori }}"
                                class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-end">Save</button>
            </form>
        </div>
    </div>
@endsection
