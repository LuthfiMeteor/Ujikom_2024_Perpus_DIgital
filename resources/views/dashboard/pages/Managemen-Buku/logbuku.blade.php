@extends('dashboard.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('sweetalert2.min/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatables/datatables.css') }}">
@endpush
@section('content')
    <div class="container">
        <div class="">
            <h2>Edit Kategori</h2>
            <p> <a href="{{ route('home') }}" class="link-underline-secondary">Dashboard</a> / <a
                    href="{{ route('managemenBuku') }}" class="link-underline-secondary">Managemen Buku</a> / <a
                    href="" class="link-underline-secondary">Log Buku</a></p>
        </div>
        @php
            $logBuku = App\Models\LogBukuModel::with('kategoriRela')->get();
        @endphp
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body table-responsive">
                <table class="table" id="table">
                    <thead class="fw-bold">
                        <tr>
                            <td>NO</td>
                            <td>Judul</td>
                            <td>kategori</td>
                            <td>Aksi</td>
                            <td>Dilakukan Pada</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('datatables/datatables.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    name: 'judul',
                    data: 'judul',
                }, {
                    name: 'kategori',
                    data: 'kategori',
                }, {
                    data: "aksi",
                    name: "aksi",
                }, {
                    data: "dilakukan",
                    name: 'dilakukan'
                }]
            });
        });
    </script>
@endpush
