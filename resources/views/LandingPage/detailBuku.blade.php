@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('sweetalert2.min\sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('rateYO/jquery.rateyo.min.css') }}">
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('rateYO/jquery.rateyo.min.js') }}"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="{{ asset('storage/upload/cover/' . $buku->gambarCover) }}" alt="" class="img-fluid"
                            style="width: 300px" />
                        <div class="bg-dark rounded-3 mt-2 p-2 d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div id="rateYo"></div>
                            </div>
                            <div>
                                <p class="mb-0 text-light">{{ $buku->rating }}</p>
                            </div>
                        </div>
                        @php
                            $date = Carbon\Carbon::createFromFormat(
                                'd-m-Y',
                                date('d-m-Y', strtotime($buku->tahunTerbit)),
                            );
                            $formattedDate = $date->format('d F Y');
                        @endphp
                    </div>
                    <div class="col-lg-8 mt-4 mt-lg-0 text-break">
                        <div class="fs-2 fw-bold mb-1 ">{{ $buku->judul }}</div>
                        <ul class=" fs-5">
                            <li style="list-style: square">Penulis &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                {{ $buku->penulis }}
                            </li>
                            <li style="list-style: square">Penerbit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                {{ $buku->penerbit }} </li>
                            <li style="list-style: square">kategori &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                {{ $buku->Kategori->kategori }} </li>
                            <li style="list-style: square">Tahun Terbit :
                                {{ $formattedDate }}</li>
                        </ul>
                        <small>
                            {!! $buku->deskripsi !!}
                        </small>
                        <br>
                        <br>
                        <br>
                        <div class="fs-5 mb-4">
                            <!-- Empty heart icon -->
                            @php
                                $user = Auth::user();

                                if ($user) {
                                    $kaloFav = $user
                                        ->favoritBy()
                                        ->where('buku_id', $buku->id)
                                        ->exists();
                                } else {
                                    $kaloFav = false;
                                }
                            @endphp

                            @if (!$kaloFav)
                                <a href="#" id="tambahFavorit" class="btn btn-primary heart-icon like"
                                    data-id="{{ Crypt::encrypt($buku->id) }}">
                                    <img src="{{ asset('tabler-icons-2.45.0/png/heart.png') }}" width="20px"
                                        alt="">
                                </a>
                            @else
                                <!-- Filled heart icon (hidden by default) -->
                                <a href="#" class="btn btn-primary heart-icon unlike"
                                    data-id="{{ Crypt::encrypt($buku->id) }}">
                                    <img src="{{ asset('tabler-icons-2.45.0/png/heart-filled.png') }}" width="20px"
                                        alt="">
                                </a>
                            @endif
                            @if (Auth::check())
                                <a target="_blank" href="{{ route('BacaBuku', [Crypt::encrypt($buku->id)]) }}"
                                    class="btn btn-primary">baca
                                    sekarang</a>
                            @else
                                <a id="suruhLoginDulu" class="btn btn-primary">baca
                                    sekarang</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            @php
                if (Auth::user()) {
                    $komentarCheck = Auth::user()
                        ->komentarBy()
                        ->where('buku_id', $buku->id)
                        ->first();
                } else {
                    $komentarCheck = false;
                }
                // dd($komentarCheck);
            @endphp
            @role('user')
                @if (!$komentarCheck)
                    <div class="fs-4">
                        ULASAN
                    </div>
                    @if (Auth::user())
                        <form id="commentForm" action="{{ route('kirimKomentar') }}" method="post">
                            @csrf
                            <div class="row p-0">
                                <div class="col-12 col-sm-9 col-md-8 col-xl-9">
                                    <input class="form-control" type="text" required name="komentar" id=""
                                        placeholder="tulis komentarmu">
                                    <input type="hidden" name="buku_id" value="{{ Crypt::encrypt($buku->id) }}">
                                </div>
                                <div class="col-12 col-sm-2 col-md-3 col-xl-2">
                                    <div id="rateYo2"></div>
                                </div>
                                <div class="col-1">
                                    <button type="button" id="submitBtn" class="btn btn-primary">kirim</button>
                                </div>
                            </div>
                        </form>
                    @endif
                @else
                    <div class="fs-4">
                        ULASAN SAYA
                    </div>
                    {{-- <form action="{{ route('kirimKomentar') }}" method="post">
                        @csrf
                        <div class="row p-0">
                            <div class="col-10">
                                <input class="form-control" type="text" name="komentar" id=""
                                    placeholder="tulis komentarmu">
                                <input type="hidden" name="buku_id" value="{{ Crypt::encrypt($buku->id) }}">
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">kirim</button>
                            </div>
                        </div>
                    </form> --}}
                    <div class="row mb-4">
                        <div class="col-2 col-md-1 mt-2">
                            <img src="{{ asset('blank-profile-picture-973460_640.webp') }}" alt=""
                                class="img-fluid rounded-circle" width="70px">
                        </div>
                        <div class="col-10 col-md-11 mt-2">
                            <div class="row">
                                {{-- <div class="col-md-1 d-none d-md-block"> <!-- Added column for spacing on larger screens -->
                                </div> --}}
                                <div class="col-12 col-md-11">
                                    <div id="rateYosudah"></div>
                                    <textarea style="resize: none;" readonly class="form-control mt-2" name="" id="" cols="2"
                                        rows="3">{{ $komentarCheck->komentar }}</textarea>
                                </div>
                            </div>
                        </div>
                        <script>
                            $("#rateYosudah").rateYo({
                                starWidth: "20px",
                                rating: {{ $komentarCheck->rating }},
                                readOnly: true
                            });
                        </script>
                    </div>
                @endif
            @endrole

            <div class="fs-4 mt-2">SEMUA ULASAN</div>
            <hr>
            @php
                if (Auth::user()) {
                    $allKomentar = \App\Models\KomentarModel::where('buku_id', $buku->id)
                        ->where('user_id', '!=', Auth::id())
                        ->paginate(5);
                } else {
                    $allKomentar = \App\Models\KomentarModel::where('buku_id', $buku->id)->paginate(5);
                }
            @endphp
            @foreach ($allKomentar as $key => $item)
                <div class="row">
                    <div class="col-1 col-md-1  mt-4">
                        <img src="{{ asset('blank-profile-picture-973460_640.webp') }}" alt=""
                            class="img-fluid rounded-2" srcset="" width="70px">
                    </div>
                    <div class="col-11 mt-3">
                        <div class="card">
                            <div class="fs-5 p-2">
                                {{ $item->komentarOleh->name }}
                            </div>
                            <p class="text-break p-2">
                                {{ $item->komentar }}
                            </p>
                            <div class="rateYoAll_{{ $key }}"></div>
                        </div>
                    </div>
                </div>
                <script>
                    $(".rateYoAll_{{ $key }}").rateYo({
                        starWidth: "20px",
                        rating: {{ $item->rating }},
                        readOnly: true
                    });
                </script>
            @endforeach
            <div class="mt-2">
                {{ $allKomentar->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script src="{{ asset('sweetalert2.min\sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(function() {
                $("#rateYo").rateYo({
                    starWidth: "25px",
                    rating: {{ $buku->rating }},
                    readOnly: true
                });
            });

            /* Javascript */

            $(function() {

                $("#rateYo2").rateYo({
                    starWidth: "30px"
                });

            });
            $('#submitBtn').click(function() {
                var rating = $('#rateYo2').rateYo("rating");

                // Prepare form data
                var formData = $('#commentForm').serializeArray();
                formData.push({
                    name: "rating",
                    value: rating
                });
                // console.log(rating);

                $.ajax({
                    url: "{{ route('kirimKomentar') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                    }
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.like').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    url: '{{ route('favorit') }}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        $this.addClass('d-none');
                        $this.siblings('.like').removeClass('d-none');
                        window.location.reload();
                    },
                    error: function(err) {
                        swal.fire({
                            icon: 'error',
                            text: 'silahkan login dahulu',
                        });
                    },
                });
            });
            $('.unlike').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var $this = $(this);
                $.ajax({
                    url: '{{ route('favorit') }}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        $this.addClass('d-none');
                        $this.siblings('.unlike').removeClass('d-none');
                        window.location.reload();
                    },
                    error: function(err) {

                    },
                });
            });
            $('#suruhLoginDulu').click(function() {
                swal.fire({
                    icon: 'error',
                    text: 'Silahkan Login Dulu'
                })
            });
        });
    </script>
@endsection
