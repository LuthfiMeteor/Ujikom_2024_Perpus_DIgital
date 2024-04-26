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
                    href="{{ route('managemenBuku') }}" class="link-underline-secondary">Managemen Buku</a></p>
        </div>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="tambahBuku">+</button>
                <a href="{{ route('exportExcel') }}" class="btn btn-success">Export Excel</a>
                <a href="{{ route('laporan') }}" class="btn btn-danger">Export PDF</a>
                <a href="{{ route('logBuku') }}" class="float-end"><img
                        src="{{ asset('tabler-icons-2.45.0/png/message-circle.png') }}" width="30px" alt=""></a>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead class="fw-bold">
                        <tr>
                            <td>NO</td>
                            <td>Judul</td>
                            <td>kategori</td>
                            <td>cover</td>
                            <td>file Buku</td>
                            <td>penulis</td>
                            <td>penerbit</td>
                            <td>tahun terbit</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahBuku') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="">Judul</label>
                                <input type="text" name="judul" id="" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">deskripsi</label>
                                <textarea name="deskripsi" id="editor" cols="30" rows="10"></textarea>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">kategori</label>
                                @php
                                    $buku = App\Models\KategoriModel::all();
                                @endphp
                                <select name="kategori" class="form-select" id="">
                                    @foreach ($buku as $item)
                                        <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">Cover</label>
                                <input type="file" name="cover" id="" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">File Buku <small class="text-danger">*File Dengan Extension
                                        .pdf</small></label>
                                <input name="isiBuku" class="form-control" type="file"></input>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">penulis</label>
                                <input type="text" name="penulis" id="" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">penerbit</label>
                                <input type="text" name="penerbit" id="" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">tahun terbit</label>
                                <input type="date" name="tahunTerbit" id="" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('datatables/datatables.js') }}"></script>
    <script src="{{ asset('sweetalert2.min/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('ckeditor5-build-classic/ckeditor.js') }}"></script>
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
            $('.table').DataTable({
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
                    name: 'gambar',
                    data: 'gambar'
                }, {
                    name: 'fileBuku',
                    data: 'fileBuku'
                }, {
                    name: 'penulis',
                    data: 'penulis'
                }, {
                    name: 'penerbit',
                    data: 'penerbit'
                }, {
                    name: 'tahunTerbit',
                    data: 'tahunTerbit'
                }, {
                    name: 'aksi',
                    data: 'aksi'
                }]
            });
            $('#tambahBuku').click(function() {
                // console.log(1);
                $('#modalTambah').modal('show');
            })
            $('.table').on('click', '.deleteBuku', function() {
                const id = $(this).data('id');
                // console.log(id);
                Swal.fire({
                    title: "Hapus Buku?",
                    text: "Tidak Bisa Dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Swal.fire({
                        //     title: "Deleted!",
                        //     text: "Your file has been deleted.",
                        //     icon: "success"
                        // });
                        $.ajax({
                            url: '{{ route('deleteBuku') }}',
                            type: 'post',
                            data: {
                                id: id,
                            },
                            success: function(res) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Buku Berhasil Dihapus.",
                                    icon: "success"
                                });
                                window.location.reload();
                            },
                            error: function(err) {
                                Swal.fire({
                                    title: "Not Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "error"
                                });
                            }
                        })
                    }
                });
            })
        });
    </script>
@endpush
