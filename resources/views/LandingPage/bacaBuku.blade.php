<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Baca Buku {{ $buku->judul }}</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('sweetalert2.min/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('sweetalert2.min/sweetalert2.min.css') }}">
    <script src="{{ asset('bootstrap-5.3.3-dist/js/bootstrap.min.js') }}"></script>
    <style>
        .scaling-squares-spinner,
        .scaling-squares-spinner * {
            box-sizing: border-box;
        }

        .scaling-squares-spinner {
            height: 65px;
            width: 65px;
            position: relative;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            animation: scaling-squares-animation 1250ms;
            animation-iteration-count: infinite;
            transform: rotate(0deg);
        }

        .scaling-squares-spinner .square {
            height: calc(65px * 0.25 / 1.3);
            width: calc(65px * 0.25 / 1.3);
            margin-right: auto;
            margin-left: auto;
            border: calc(65px * 0.04 / 1.3) solid #ff1d5e;
            position: absolute;
            animation-duration: 1250ms;
            animation-iteration-count: infinite;
        }

        .scaling-squares-spinner .square:nth-child(1) {
            animation-name: scaling-squares-spinner-animation-child-1;
        }

        .scaling-squares-spinner .square:nth-child(2) {
            animation-name: scaling-squares-spinner-animation-child-2;
        }

        .scaling-squares-spinner .square:nth-child(3) {
            animation-name: scaling-squares-spinner-animation-child-3;
        }

        .scaling-squares-spinner .square:nth-child(4) {
            animation-name: scaling-squares-spinner-animation-child-4;
        }


        @keyframes scaling-squares-animation {

            50% {
                transform: rotate(90deg);
            }

            100% {
                transform: rotate(180deg);
            }
        }

        @keyframes scaling-squares-spinner-animation-child-1 {
            50% {
                transform: translate(150%, 150%) scale(2, 2);
            }
        }

        @keyframes scaling-squares-spinner-animation-child-2 {
            50% {
                transform: translate(-150%, 150%) scale(2, 2);
            }
        }

        @keyframes scaling-squares-spinner-animation-child-3 {
            50% {
                transform: translate(-150%, -150%) scale(2, 2);
            }
        }

        @keyframes scaling-squares-spinner-animation-child-4 {
            50% {
                transform: translate(150%, -150%) scale(2, 2);
            }
        }
    </style>
</head>

<body style="background-color: black">
    <div class="position-absolute top-50 start-50 translate-middle" id="loader">
        <div class="scaling-squares-spinner" :style="spinnerStyle">
            <div class="square"></div>
            <div class="square"></div>
            <div class="square"></div>
            <div class="square"></div>
        </div>
    </div>

    <div class="container">
        <center>
            <div class="pdf-viewer"></div>
        </center>
    </div>
    <input type="hidden" name="" id="member" value="{{ $checkMember }}">

    @if ($checkMember == 0)
        <script>
            Swal.fire({
                title: "Kamu Bukan Member!",
                text: "Kamu Saaat Ini Bukan Member. Buku Akan Ditampilkan Setengah Total Halaman, jika ingin membuka semua halaman harap untuk daftar member dengan mengklik Daftar",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Daftar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });
                    $('#exampleModal').modal('show');
                }
            });
        </script>
    @endif

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

    @if (session('suksesDaftar'))
        <script>
            swal.fire({
                icon: 'success',
                text: 'Berhasil Daftar Member',
            })
        </script>
    @endif

    <script src="{{ asset('pdf.worker.js') }}"></script>
    <script src="{{ asset('pdf.min.js') }}"></script>
    <script>
        // PDF BACA
        var pdfUrl = "{{ asset('storage/upload/isiBuku/' . $buku->isiBuku) }}";
        const member = document.getElementById("member").value;
        var pdfViewer = document.querySelector('.pdf-viewer');

        function showLoader() {
            var loader = document.getElementById('loader');
            loader.style.display = 'block';
        }

        // Hide loader function
        function hideLoader() {
            var loader = document.getElementById('loader');
            loader.style.display = 'none';
        }

        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
            if (member == 0) {
                var pageCount = Math.ceil(pdf.numPages / 3);
            } else {
                var pageCount = pdf.numPages;
            }
            console.log(pageCount);

            var scale = 1.2;
            var numVisiblePages = 5;
            var renderedPages = {};

            function renderPage(pageNum) {
                if (!renderedPages[pageNum]) {
                    showLoader(); // Show loader before rendering

                    pdf.getPage(pageNum).then(function(page) {
                        var viewport = page.getViewport({
                            scale: scale
                        });
                        var canvas = document.createElement('canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        page.render(renderContext).promise.then(function() {
                            var pdfPage = document.createElement('div');
                            pdfPage.classList.add('pdf-page');
                            pdfPage.appendChild(canvas);
                            pdfViewer.appendChild(pdfPage);

                            renderedPages[pageNum] = true;
                            hideLoader(); // Hide loader after rendering
                        });
                    });
                }
            }

            for (var i = 1; i <= numVisiblePages; i++) {
                renderPage(i);
            } // scroll Macam Web Manga Ini
            window.addEventListener('scroll', function() {
                var scrollTop = window.scrollY;
                var
                    scrollHeight = document.body.scrollHeight;
                var clientHeight = window.innerHeight;
                var scrollPercentage = (scrollTop /
                    (scrollHeight - clientHeight)) * 100;
                if (scrollPercentage > 70) {
                    var nextPage = Object.keys(renderedPages).length + 1;
                    if (nextPage <= pageCount) {
                        renderPage(nextPage);
                    }
                }
            });
        });
    </script>
</body>

</html>
