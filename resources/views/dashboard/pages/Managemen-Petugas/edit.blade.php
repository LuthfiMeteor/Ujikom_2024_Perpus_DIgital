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
                    href="{{ route('managemenPetugas') }}" class="link-underline-secondary">Managemen Petugas</a> /
                <a href="">Edit Petugas</a>
            </p>
        </div>
        <div class="card p-2">
            <form action="{{ route('updatePetugas', Crypt::encrypt($petugas->id)) }}" method="post">
                @csrf
                <div class="">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $petugas->name }}">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="">username</label>
                            <input type="text" name="username" value="{{ $petugas->username }}" class="form-control">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="">email</label>
                            <input type="email" name="email" value="{{ $petugas->email }}" class="form-control">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="">alamat</label>
                            <input type="text" name="alamat" value="{{ $petugas->alamat }}" class="form-control">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="">no Telpon</label>
                            <input type="number" name="noTelp" value="{{ $petugas->noTelp }}" class="form-control">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="">tanggal & tahun lahir</label>
                            <input type="date" name="tanggalLahir" value="{{ $petugas->tglLahir }}"
                                class="form-control">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="">password <smallc class="text-danger">*Hanya Diisi Saat Ingin Mengubah
                                    Password Saja</small></label>
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
