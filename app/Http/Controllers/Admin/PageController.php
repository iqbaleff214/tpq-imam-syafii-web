<?php

namespace App\Http\Controllers\Admin;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Models\Donasi;
use App\Models\Lembaga;
use GeniusTS\HijriDate as TSHijri;
use App\Http\Controllers\Controller;
use App\Models\Kalender;
use App\Models\Kas;
use App\Models\Pengajar;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('calon')) {
                $data = Santri::where('status', 'Calon');
                return DataTables::of($data->get())
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<form class="d-inline" method="POST" action="' . route('admin.santri.accept', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="status" value="Aktif">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <button type="submit" class="btn bg-maroon btn-xs px-2 btn-confirm"> Terima </button>
                                </form>
                                <form class="d-inline" method="POST" action="' . route('admin.santri.accept', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="status" value="Ditolak">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <button type="submit" class="btn btn-outline-danger btn-xs px-2 btn-confirm"> Tolak </button>
                                </form>';
                    })
                    ->editColumn('jenis_kelamin', function ($row) {
                        return $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                    })
                    ->addColumn('umur', function ($row) {
                        return Carbon::parse($row->tanggal_lahir)->age . ' tahun';
                    })
                    ->addColumn('kelas', function ($row) {
                        return $row->kelas ? $row->kelas->nama_kelas : 'Belum Masuk';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        $count = [
            'santri' => Santri::where('status', 'Aktif')->count(),
            'pengajar' => Pengajar::where('status', 'Aktif')->count(),
            'saldo' => Kas::selectRaw('SUM(pemasukan) - SUM(pengeluaran) as saldo')->first()->saldo,
            'donasi' => Donasi::selectRaw('SUM(jumlah) as jumlah')->where('status', 1)->first()->jumlah,
        ];

        $title = 'Dasbor';
        $profil = Lembaga::where('is_active', 1)->first();

        return view('pages.admin.dashboard', compact('count', 'title', 'profil'));
    }

    public function profil()
    {
        return view('pages.admin.pengaturan.profil', ['title' => 'Profil']);
    }

    public function akun()
    {
        return view('pages.admin.pengaturan.akun', ['title' => 'Akun']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required|max:15',
            'alamat' => 'required',
            'foto' => 'image|max:2048'
        ]);

        try {
            $admin = Auth::user()->administrator;
            $foto = $admin->foto;
            if ($request->hasFile('foto')) {
                if ($foto) Storage::delete("public/$foto");
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $admin->update([
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'foto' => $foto,
            ]);

            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Profil gagal diperbarui!');
        }
    }

    public function update_akun(Request $request)
    {
        $request->validate([
            'username' => ['required', Rule::unique('users')->ignore(Auth::user()->id)],
            'password_lama' => 'required',
            'password' => 'nullable|confirmed',
        ]);

        try {

            if (!password_verify($request->input('password_old'), Auth::user()->getAuthPassword())) return redirect()->back()->with('error', 'Kata sandi salah!');

            $data = [
                'username' => $request->input('username'),
            ];

            if ($request->input('password')) $data['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);

            Auth::user()->update($data);
            return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Akun gagal diperbarui!');
        }
    }

    public function unlink()
    {
        try {
            $profil = Auth::user()->administrator;
            if ($profil->foto) Storage::delete("public/$profil->foto");
            $profil->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Foto profil gagal dihapus!');
        }
    }

    public function kalender()
    {

        $data = Kalender::all();
        $title = 'Kelender';
        $kalender = [];
        foreach ($data as $item) {
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $kalender[] = [
                'title' => $item->keterangan,
                'start' => $item->mulai,
                'end' => $item->selesai,
                'backgroundColor' => $color,
                'borderColor' => $color,
            ];
        }

        $kalender = json_encode($kalender);
        echo view('pages.admin.kalender.index', compact('title', 'kalender'));
    }
}
