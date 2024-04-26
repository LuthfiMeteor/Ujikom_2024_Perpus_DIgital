<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BukuModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $buku = BukuModel::all();
        $render = pdf::loadView('dashboard.pages.laporan.index', compact('buku'));
        return $render->download('laporan daftar buku.pdf');
    }
}
