<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Buku</title>
</head>

<body>
    <h3 style="text-align: center">LAPORAN BUKU</h3>

    <table class="table" border="1" cellspacing='0' style="width: 100%">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>judul</th>
                <th>kategori</th>
                <th>penulis</th>
                <th>penerbit</th>
                <th>Tahun Terbit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buku as $num => $row)
                <tr>
                    <td>{{ $num + 1 }}</td>
                    <td>{{ $row->judul }}</td>
                    <td>{{ $row->Kategori->kategori }}</td>
                    <td>{{ $row->penulis }}</td>
                    <td>{{ $row->penerbit }}</td>
                    <td>{{ $row->tahunTerbit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
