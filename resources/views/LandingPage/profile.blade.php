@extends('layouts.app')
@section('content')
    <section style="background-color: #eee;">
        <div class="container py-5">

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{ asset('blank-profile-picture-973460_640.webp') }}" alt="avatar"
                                class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3">{{ Auth::user()->name }}</h5>
                            <p class="text-muted mb-3">Bergabung Pada :
                                {{ date('d-m-Y', strtotime(Auth::user()->created_at)) }}</p>
                        </div>
                    </div>
                    @if ($errors->has('googlenotsame'))
                        <div class="alert alert-danger">
                            {{ $errors->first('googlenotsame') }}
                        </div>
                    @endif
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">

                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <img src="{{ asset('image/assets/media/svg/social-logos/google.svg') }}" alt=""
                                        srcset="">
                                    @if (Auth::user()->google_id)
                                        <small>Tersambung</small>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" id="triggerGoogle" type="checkbox"
                                                role="switch" id="flexSwitchCheckDefault" checked>
                                        </div>
                                    @else
                                        <small>Tidak Tersambung</small>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" id="triggerGoogle" type="checkbox"
                                                role="switch" id="flexSwitchCheckDefault">
                                        </div>
                                    @endif
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <form action="{{ route('updateProfileUser') }}" method="post">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nama</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama" required value="{{ Auth::user()->name }}"
                                            id="" class="form-control">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="email" value="{{ Auth::user()->email }}" readonly
                                            id="" class="form-control">
                                        <div id="emailHelp" class="form-text text-danger">Email Tidak Bisa Diubah.
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->HasMember)
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">No Telpon</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" name="noTelp" required value="{{ Auth::user()->noTelp }}"
                                                id="" class="form-control">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Alamat</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" required name="alamat" value="{{ Auth::user()->alamat }}"
                                                id="" class="form-control">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Tanggal Dan Tahun Lahir</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="date" required name="tglLahir"
                                                value="{{ Auth::user()->tglLahir }}" id="" class="form-control">
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <button type="submit" class="btn btn-primary float-end">Update data</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="fs-4">Member</p>
                                    @if (Auth::user()->HasMember)
                                        <div class="">
                                            <div class="alert alert-success" role="alert">
                                                Selamat Kamu Terdaftar Member! <br> Selamat Nikmati Benefitmu
                                            </div>
                                            <a href="{{ route('bukuPage') }}" class="btn btn-primary">Baca Buku
                                                Sekarang</a>
                                        </div>
                                    @else
                                        <div class="">
                                            <div class="alert alert-warning" role="alert">
                                                Kamu Bukan Member! Daftar Member Sekarang Untuk Mendapatkan Benefit Hanya
                                                Dengan
                                                Mengisi Biodata
                                            </div>
                                            <div class="btn btn-warning" id="daftarMember">Daftar Member</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Daftar Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dafatarMember') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">No Telp</label>
                            <input type="number" name="noTelp" id="" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Tahun Lahir</label>
                            <input type="date" name="lahir" id="" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Alamat</label>
                            <input type="text" name="alamat" id="" required class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#daftarMember').click(function() {
                // console.log(2);
                $('#exampleModal').modal('show');
            })
            $('#triggerGoogle').on('change', function() {
                window.location.href = "{{ route('googleConnect') }}";
                // console.log(1);
            });
        })
    </script>
@endpush
