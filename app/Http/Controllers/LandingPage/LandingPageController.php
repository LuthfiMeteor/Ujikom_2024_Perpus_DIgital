<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\BukuModel;
use App\Models\FavoritModel;
use App\Models\KomentarModel;
use App\Models\MemberModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function buku()
    {
        $buku = BukuModel::all();
        return view('LandingPage.Buku', compact('buku'));
    }
    public function detailBuku($slug)
    {
        $buku = BukuModel::where('slug', $slug)->first();
        return view('LandingPage.detailBuku', compact('buku'));
    }
    public function favorit(Request $request)
    {
        try {
            $decrypted = Crypt::decrypt($request->id);
            $favorit = FavoritModel::where('buku_id', $decrypted)->where('user_id', Auth::id())
                ->count();
            if ($favorit == 0) {
                // dd('awd');
                $Makefavorit = new FavoritModel();
                $Makefavorit->user_id = Auth::id();
                $Makefavorit->buku_id = $decrypted;
                $Makefavorit->save();
                return response(200);
            } else {
                $removeFavorit = FavoritModel::where('buku_id', $decrypted)->where('user_id', Auth::id())->delete();
                return response(200);
            }
        } catch (\Throwable $th) {
        }
    }
    public function kirimKomentar(Request $request)
    {
        // dd($request->all());
        try {
            $buku_id = Crypt::decrypt($request->buku_id);
            // dd($buku_id);
            $tambahKomentar = new KomentarModel();
            $tambahKomentar->buku_id = $buku_id;
            $tambahKomentar->user_id = Auth::id();
            $tambahKomentar->komentar = $request->komentar;
            $tambahKomentar->rating = $request->rating;
            $tambahKomentar->save();

            $comments = KomentarModel::where('buku_id', $buku_id)->get();
            $totalRating = 0;
            $jumlahRating = $comments->count();
            foreach ($comments as $comment) {
                $totalRating += $comment->rating;
            }

            $newAverageRating = $totalRating / $jumlahRating;

            $book = BukuModel::find($buku_id);
            $book->rating = $newAverageRating;
            $book->save();

            return back();
        } catch (\Throwable $th) {
        }
    }
    public function bacaBuku($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $buku = BukuModel::find($decrypted);

            $checkMember =  MemberModel::where('user_id', Auth::id())->count();
            // dd($checkMember);
            return view('LandingPage.bacaBuku', compact('buku', 'checkMember'));
        } catch (\Throwable $th) {
        }
    }

    public function daftarMember(Request $request)
    {
        $request->validate([
            'noTelp' => 'required',
            'lahir' => 'required|date',
            'alamat' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $userUpdate = User::find(Auth::id());
            $userUpdate->noTelp = $request->noTelp;
            $userUpdate->tglLahir = $request->lahir;
            $userUpdate->alamat = $request->alamat;
            $userUpdate->save();

            $insertMember = new MemberModel();
            $insertMember->user_id = Auth::id();
            $insertMember->save();
            DB::commit();
            return back()->with('suksesDaftar', 'ok');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function favoritList()
    {
        $bukuFvorit = DB::table('favorit')
            ->join('buku', 'favorit.buku_id', '=', 'buku.id')
            ->where('favorit.user_id', Auth::id())
            ->get();
        // dd($bukuFvorit);
        return view('LandingPage.favorit', compact('bukuFvorit'));
    }
    public function addPassword()
    {
        return view('LandingPage.IsiPasswordGoogleUser');
    }
    public function addPasswordSubmit(Request $request)
    {
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/');
    }
    public function profileUser()
    {
        return view('LandingPage.profile');
    }
    public function updateProfileUser(Request $request)
    {
        if (Auth::user()->HasMember) {
            $update = User::find(Auth::id());
            $update->name = $request->nama;
            $update->email = $request->email;
            $update->noTelp = $request->noTelp;
            $update->alamat = $request->alamat;
            $update->tglLahir = $request->tglLahir;
            $update->save();
            return back()->with('suksesUpdate', 'ok');
        } else {
            $update = User::find(Auth::id());
            $update->name = $request->nama;
            $update->email = $request->email;
            $update->save();
            return back()->with('suksesUpdate', 'ok');
        }
    }
}
