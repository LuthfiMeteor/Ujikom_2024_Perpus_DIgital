@extends('dashboard.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2.min/sweetalert2.min.css') }}">
@endpush
@section('content')
    <div class="container">
        <div class="">
            <h2>Managemen Kategori</h2>
            <p> <a href="{{ route('home') }}" class="link-underline-secondary">Dashboard</a> / <a href="#"
                    class="link-underline-secondary">Managemen Kategori</a></p>
        </div>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="tambahKategori">+</button>

            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="fw-bold">
                        <tr>
                            <td>NO</td>
                            <td>Nama Kategori</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Tambah Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambahKategori') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="kategori">Nama Kategori</label>
                                    <input type="text" name="kategori" id="kategori" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
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
                    name: 'kategori',
                    data: 'kategori',
                }, {
                    name: 'aksi',
                    data: 'aksi',
                }]
            });
            $('#tambahKategori').click(function() {
                $('#modalEdit').modal('show');
            });
            $('.table').on('click', '.hapusKategori', function() {
                const id = $(this).data('id');
                // console.log(id);
                Swal.fire({
                    title: "Hapus Kategori?",
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
                            url: '{{ route('deleteKategori') }}',
                            type: 'post',
                            data: {
                                id: id,
                            },
                            success: function(res) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Kategori Berhasil Dihapus.",
                                    icon: "success"
                                });
                                window.location.reload();
                            },
                            error: function(err) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Masih Ada Buku Yang Terkait Dengan Kategori Ini.",
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
