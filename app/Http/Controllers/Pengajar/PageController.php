<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\Honor;
use App\Models\KehadiranPengajar;
use App\Models\Kurikulum;
use App\Models\Santri;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{

    public function index(Request $request)
    {
        Date::setTranslation(new Indonesian());
        Hijri::setDefaultAdjustment(-1);

        $title = 'Beranda';
        $presensi = KehadiranPengajar::where('pengajar_id', Auth::user()->pengajar->id)->whereDate('created_at', Carbon::today());
        $presensi = $presensi->first();
        $ngaji = KehadiranPengajar::where('pengajar_id', Auth::user()->pengajar->id)->whereDate('created_at', Carbon::today())->where('keterangan', 'Hadir')->first();
        $presensi_bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->where('pengajar_id', Auth::user()->pengajar->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->limit(3)->get();

        if ($request->ajax()) {
            # Data santri
            $kelas_id = Auth::user()->pengajar->kelas->id ?? null;
            $santri = Santri::where('kelas_id', $kelas_id)->where('status', 'Aktif')->get();

            return DataTables::of($santri)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($ngaji) {
                    if ($ngaji) {
                        $kehadiran = $row->kehadiran()->whereDate('created_at', Carbon::today())->first();
                        if ($kehadiran) {
                            return $kehadiran->keterangan;
                        } else {
                            $column = '';

                            $ket = ['Hadir' => 'btn-success', 'Izin' => 'btn-primary', 'Sakit' => 'btn-warning', 'Absen' => 'btn-danger'];

                            foreach ($ket as $key => $val) {
                                $class = $key == 'Hadir' ? 'confirm-attendance' : '';
                                $column .= '
                            <form class="d-inline" method="POST" action="' . route('pengajar.kehadiran.santri.store') . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <input type="hidden" name="nilai_adab">
                                <input type="hidden" name="santri_id" value="' . $row->id . '">
                                <input type="hidden" name="keterangan" value="' . $key . '">
                                <button type="submit" class="btn ' . $val . ' btn-xs px-2 ' . $class . '"> ' . $key . ' </button>
                            </form>';
                            }
                            return $column;
                        }
                    } else {
                        return 'Belum ada keterangan';
                    }
                })
                ->editColumn('nama_panggilan', function($row) {
                    return "<a href='". route('pengajar.santri.show', $row) ."'>" . $row->nama_panggilan . "</a>";
                })
                ->rawColumns(['action', 'nama_panggilan'])
                ->make(true);
        }

        $honor = Honor::where('pengajar_id', Auth::user()->pengajar->id)->where('status', 0)->count();

        return view('pages.pengajar.dashboard', compact('title', 'ngaji', 'presensi', 'presensi_bulan', 'honor'));
    }

    public function profil()
    {
        return view('pages.pengajar.pengaturan.profil', ['title' => 'Profil']);
    }

    public function akun()
    {
        return view('pages.pengajar.pengaturan.akun', ['title' => 'Akun']);
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

            $admin = Auth::user()->pengajar;

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
            'email' => ['required', 'email:dns', Rule::unique('users')->ignore(Auth::user()->id)],
            'password_lama' => 'required',
            'password' => 'nullable|confirmed',
        ]);

        try {
            if (!password_verify($request->input('password_lama'), Auth::user()->getAuthPassword())) return redirect()->back()->with('error', 'Kata sandi salah!');

            $data = [
                'username' => $request->input('username'),
            ];

            $checkEmail = Auth::user()->email != $request->email;

            if ($checkEmail) {
                $data['email'] = $request->email;
                $data['email_verified_at'] = null;
            }

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
            $profil = Auth::user()->pengajar;
            if ($profil->foto) Storage::delete("public/$profil->foto");
            $profil->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Foto profil gagal dihapus!');
        }
    }

    public function kurikulum()
    {
        $title = 'Kurikulum';
        $kelas = Auth::user()->pengajar->kelas ?? null;
        if (!$kelas) return redirect()->route('pengajar.dashboard');
        $kurikulum = Kurikulum::findOrFail($kelas->kurikulum_id);
        return view('pages.pengajar.kurikulum.index', compact('title', 'kurikulum'));
    }
}
