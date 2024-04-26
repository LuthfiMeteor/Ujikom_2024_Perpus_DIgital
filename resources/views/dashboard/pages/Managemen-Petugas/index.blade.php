@extends('dashboard.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('sweetalert2.min/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatables/datatables.css') }}">
@endpush
@section('content')
    <div class="container">
        <div class="">
            <h2>Managemen Petugas</h2>
            <p> <a href="{{ route('home') }}" class="link-underline-secondary">Dashboard</a> / <a
                    href="{{ route('managemenPetugas') }}" class="link-underline-secondary">Managemen Petugas</a></p>
        </div>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="tambahPetugas">+</button>

            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead class="fw-bold">
                        <tr>
                            <td>NO</td>
                            <td>Nama</td>
                            <td>username</td>
                            <td>Email</td>
                            <td>Tanggal & Tahun Lahir</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambahPetugas') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="">Nama</label>
                                <input type="text" name="nama" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">username</label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">alamat</label>
                                <input type="text" name="alamat" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">no Telpon</label>
                                <input type="number" name="noTelp" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">tanggal & tahun lahir</label>
                                <input type="date" name="tanggalLahir" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">password</label>
                                <input type="password" placeholder="****" name="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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
                        name: 'name',
                        data: 'name',
                    }, {
                        name: 'username',
                        data: 'username'
                    },
                    {
                        name: 'email',
                        data: 'email',
                    }, {
                        name: 'tanggalLahir',
                        data: 'tanggalLahir'
                    }, {
                        name: 'aksi',
                        data: 'aksi'
                    }
                ]
            });
            $('#tambahPetugas').click(function() {
                // console.log(1);
                $('#exampleModal').modal('show');
            })
            $('.table').on('click', '.deletepetugas', function() {
                const id = $(this).data('id');
                // console.log(id);
                Swal.fire({
                    title: "Hapus Petugas?",
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
                            url: '{{ route('hapusPetugas') }}',
                            type: 'post',
                            data: {
                                id: id,
                            },
                            success: function(res) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Petugas Berhasil Dihapus.",
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
