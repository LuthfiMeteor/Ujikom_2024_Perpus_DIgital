<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BukuModel;
use App\Models\LogBukuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $buku = BukuModel::query();
            return DataTables::of($buku)
                ->addindexColumn()
                ->addColumn('judul', function ($buku) {
                    return $buku->judul;
                })->addColumn('kategori', function ($buku) {
                    return $buku->Kategori->kategori;
                })->addColumn('gambar', function ($buku) {
                    return "<img src='" . asset('storage/upload/cover/' . $buku->gambarCover) . "' alt='' style='width: 130px;'>";
                })
                ->addColumn('fileBuku', function ($buku) {
                    return "<a href='" . asset('storage/upload/isiBuku/' . $buku->isiBuku) . "' >$buku->isiBuku</a>";
                })
                ->addColumn('penulis', function ($buku) {
                    return $buku->penulis;
                })
                ->addColumn('penerbit',  function ($buku) {
                    return $buku->penerbit;
                })
                ->addColumn('tahunTerbit', function ($buku) {
                    return date('d-m-Y', strtotime($buku->tahunTerbit));
                })
                ->addColumn('aksi', function ($buku) {
                    return '<a href="' . route('editBuku', $buku->id) . '" class="btn btn-warning">Edit</a> <button id="deleteBuku" data-id="' . $buku->id . '" class="deleteBuku btn btn-danger">Hapus</button>';
                })
                ->rawColumns(['gambar', 'fileBuku', 'aksi'])
                ->make();
        }
        return view('dashboard.pages.Managemen-Buku.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required|date',
            'cover' => 'required|file|mimes:png,jpeg,webp,jpg',
            'isiBuku' => 'required|file|mimes:pdf',
        ]);

        DB::beginTransaction();
        try {
            $buku = new BukuModel();
            $buku->judul = $request->judul;
            $buku->slug = Str::slug($request->judul);
            $buku->deskripsi = $request->deskripsi;
            $buku->kategori = $request->kategori;
            $buku->penulis = $request->penulis;
            $buku->penerbit = $request->penerbit;
            $buku->tahunTerbit = $request->tahunTerbit;
            // dd($request->all());
            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
                $storeFile = $file->storeAs('upload/cover', $namaFile);
                $buku->gambarCover = $namaFile;
            }
            if ($request->hasFile('isiBuku')) {
                $file = $request->file('isiBuku');
                $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
                $storeFile = $file->storeAs('upload/isiBuku', $namaFile);
                $buku->isiBuku = $namaFile;
            }
            $buku->save();
            DB::commit();
            return redirect(route('managemenBuku'))->with('suksesTambah', 'ok');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $buku = BukuModel::find($id);
        return view('dashboard.pages.Managemen-Buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required|date',
            // 'cover' => 'nullable|file|mimes:png,jpeg,webp,jpg',
            // 'isiBuku' => 'nullable|file|mimes:pdf',
        ]);

        DB::beginTransaction();
        try {
            $buku = BukuModel::find($id);
            $buku->judul = $request->judul;
            $buku->slug = Str::slug($request->judul);
            $buku->deskripsi = $request->deskripsi;
            $buku->kategori = $request->kategori;
            $buku->penulis = $request->penulis;
            $buku->penerbit = $request->penerbit;
            $buku->tahunTerbit = $request->tahunTerbit;
            // dd($request->all());
            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
                $storeFile = $file->storeAs('upload/cover', $namaFile);
                $buku->gambarCover = $namaFile;
            }
            if ($request->hasFile('isiBuku')) {
                $file = $request->file('isiBuku');
                $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
                $storeFile = $file->storeAs('upload/isiBuku', $namaFile);
                $buku->isiBuku = $namaFile;
            }
            $buku->save();
            DB::commit();
            return redirect(route('managemenBuku'))->with('suksesEdit', 'ok');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $removeFavorit = DB::table('favorit')->where('buku_id', $request->id)->delete();
        $buku = DB::table('buku')->where('id', $request->id)->delete();
        return response(200);
    }


    public function excel(Request $request)
    {
        $data = BukuModel::with('Kategori')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul
        $sheet->setCellValue('A1', 'Data Daftar Buku');
        $sheet->mergeCells('A1:G3');
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('Poppins')->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('21CA16');

        // Menambahkan gambar
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath('image/171322.png');
        $drawing->setHeight(60);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($sheet);

        // Header
        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Judul');
        $sheet->setCellValue('C5', 'Penulis');
        $sheet->setCellValue('D5', 'Kategori');
        $sheet->setCellValue('E5', 'Cover');

        $sheet->getStyle('A5:E5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        $sheet->getStyle('A5:E5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A5:E5')->getFont()->setBold(true)->setName('Poppins')->setSize(9);
        $sheet->getStyle('A5:E5')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A5:E5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('f9d392');

        // Data
        $column = 6;
        $no = 1;
        $maxImageHeight = 0;
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A' . $column, $no);
            $sheet->setCellValue('B' . $column, $value->judul);
            $sheet->setCellValue('C' . $column, $value->penulis);
            $sheet->setCellValue('D' . $column, $value->Kategori->kategori);
            $frw = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $frw->setPath('storage/upload/cover/' . $value->gambarCover);
            $frw->setWidthAndHeight(100, 50);
            $frw->setCoordinates('E' . $column);
            $frw->setWorksheet($sheet);

            $imageHeight = $frw->getHeight();
            if ($imageHeight > $maxImageHeight) {
                $maxImageHeight = $imageHeight;
            }

            $sheet->getRowDimension($column)->setRowHeight($imageHeight);

            $sheet->getStyle('A' . $column . ':E' . $column)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A' . $column . ':E' . $column)->getFont()->setBold(false)->setName('Poppins')->setSize(9);
            $column++;
            $no++;
        }

        // Set row height for the "Cover" column based on the maximum image height
        $sheet->getColumnDimension('E')->setWidth($maxImageHeight / 7); // Adjust based on your desired scale

        // Auto size other columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        // Mengatur format output dan nama file
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=Data_buku.xlsx');
        header('Cache-Control: max-age=0');

        // Mengeluarkan file
        $writer->save('php://output');
        exit();
    }
    public function logBuku()
    {
        if (request()->ajax()) {
            $logBuku = LogBukuModel::with('kategoriRela')->get();
            return DataTables::of($logBuku)
                ->addindexColumn()
                ->addColumn('judul', function ($logBuku) {
                    return $logBuku->nama_buku;
                })
                ->addColumn('kategori', function ($logBuku) {
                    return $logBuku->kategoriRela->kategori;
                })
                ->addColumn('aksi', function ($logBuku) {
                    return $logBuku->aksi;
                })->addColumn('dilakukan', function ($logBuku) {
                    return date('d-m-Y', strtotime($logBuku->created_at));
                })
                ->make();
        }
        return view('dashboard.pages.Managemen-Buku.logbuku');
    }
}
