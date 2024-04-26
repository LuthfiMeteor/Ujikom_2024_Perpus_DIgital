<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BukuModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $kategori = KategoriModel::query();
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->addColumn('aksi', function ($kategori) {
                    return view('dashboard.pages.Managemen-Kategori.buttonKategori', compact('kategori'));
                })
                ->make();
        }
        return view('dashboard.pages.Managemen-Kategori.index');
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
        $request->validate([
            'kategori' => 'required|max:150|unique:kategori,kategori'
        ]);
        try {
            $kategori = new KategoriModel();
            $kategori->kategori = $request->kategori;
            $kategori->save();
            return redirect(route('managemenKategori'))->with('suksesTambah', 'OK');
        } catch (\Throwable $th) {
            //throw $th;
            return 'error';
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('dashboard.pages.Managemen-Kategori.edit', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|max:150'
        ]);
        DB::beginTransaction();
        try {
            $kategori = KategoriModel::find($id);
            $kategori->kategori = $request->kategori;
            $kategori->update();
            DB::commit();
            return redirect(route('managemenKategori'))->with('suksesEdit', 'OK');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return 'error';
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $checkBukuTerkait = DB::table('buku')->where('kategori', $request->id)->count();
        // dd($checkBukuTerkait);
        if ($checkBukuTerkait > 0) {
            return response()->json([
                'message' => 'masih ada buku yang menggunakan kategori ini'
            ], 501);
        }
        DB::beginTransaction();
        try {
            $delete =  KategoriModel::find($request->id);
            $delete->delete();
            DB::commit();
            return response(200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }
}
