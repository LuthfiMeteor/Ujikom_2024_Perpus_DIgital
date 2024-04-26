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

        <div class="card p-3">
            <form action="{{ route('updateBuku' , $buku->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="">Judul</label>
                        <input type="text" name="judul" id="" class="form-control"
                            value="{{ $buku->judul }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="">deskripsi</label>
                        <textarea name="deskripsi" id="editor" cols="30" rows="10">{{ $buku->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="">kategori</label>
                        @php
                            $kategori = App\Models\KategoriModel::all();
                        @endphp
                        <select name="kategori" class="form-select" id="">
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ $buku->kategori == $item->id ? 'selected' : '' }}>
                                    {{ $item->kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-6">
                        <label for="">penulis</label>
                        <input type="text" name="penulis" id="" class="form-control" value="{{ $buku->penulis }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="">penerbit</label>
                        <input type="text" name="penerbit" id="" class="form-control" value="{{ $buku->penerbit }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="">tahun terbit</label>
                        <input type="date" name="tahunTerbit" id="" class="form-control" value="{{ $buku->tahunTerbit }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="">File Buku <small class="text-danger">*File Dengan Extension
                                .pdf</small><br>
                            <small class="text-danger">*di isi saat ingin mengedit saja</small><br>
                            <small class="text-danger"><a
                                    href="{{ asset('storage/upload/isiBuku/' . $buku->isiBuku) }}">File
                                    Buku Saat ini</a></small></label>
                        <input name="isiBuku" class="form-control" type="file"></input>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="">Cover <small class="text-danger">*di isi saat ingin mengedit saja</small><br>
                            <small><a target="_blank"
                                    href="{{ asset('storage/upload/cover/' . $buku->gambarCover) }}">cover
                                    saat ini</a></small></label>
                        <input type="file" name="cover" id="" class="form-control">
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
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        $(document).ready(function() {});
    </script>
@endpush
