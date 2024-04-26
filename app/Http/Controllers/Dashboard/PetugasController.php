<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PetugasModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $petugas = User::role('petugas')->get();
            return DataTables::of($petugas)
                ->addIndexColumn()
                ->addColumn('tanggalLahir', function ($petugas) {
                    return $petugas->tglLahir;
                })
                ->addColumn('aksi', function ($petugas) {
                    return '<a href="' . route('editPetugas', Crypt::encrypt($petugas->id)) . '" class="btn btn-warning">Edit</a> <button id="deletepetugas" data-id="' . Crypt::encrypt($petugas->id) . '" class="deletepetugas btn btn-danger">Hapus</button>';
                })
                ->rawColumns(['aksi'])
                ->make();
        }
        return view('dashboard.pages.Managemen-Petugas.index');
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
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'tanggalLahir' => 'required|date',
            'password' => 'required',
            'alamat' => 'required',
            'noTelp' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $petugas  = new User();
            $petugas->name = $request->nama;
            $petugas->username = $request->nama;
            $petugas->alamat = $request->alamat;
            $petugas->noTelp = $request->noTelp;
            $petugas->email = $request->email;
            $petugas->tglLahir = $request->tanggalLahir;
            $petugas->password = Hash::make($request->password);
            $petugas->save();
            $petugas->assignRole('petugas');
            DB::commit();
            return redirect(route('managemenPetugas'))->with('suksesTambah', 'ok');
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
    public function edit(string $id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $petugas = User::find($decrypted);
            return view('dashboard.pages.Managemen-Petugas.edit', compact('petugas'));
        } catch (\Throwable $th) {
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required',
            'tanggalLahir' => 'required|date',
            'password' => 'nullable',
            'alamat' => 'required',
            'noTelp' => 'required|numeric',
        ]);

        try {
            $decrypted = Crypt::decrypt($id);
            DB::beginTransaction();
            try {
                $petugas  = User::find($decrypted);
                $petugas->name = $request->nama;
                $petugas->username = $request->nama;
                $petugas->alamat = $request->alamat;
                $petugas->noTelp = $request->noTelp;
                $petugas->email = $request->email;
                $petugas->tglLahir = $request->tanggalLahir;
                if ($request->password) {
                    $petugas->password = Hash::make($request->password);
                }
                $petugas->save();
                // $petugas->assignRole('petugas');
                DB::commit();
                return redirect(route('managemenPetugas'))->with('suksesTambah', 'ok');
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
            }
        } catch (\Throwable $th) {
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $decrypted = Crypt::decrypt($request->id);
            try {
                $petugas = User::find($decrypted);
                $petugas->delete();
                DB::commit();
                return response(200);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
            }
        } catch (\Throwable $th) {
        }
    }
}
