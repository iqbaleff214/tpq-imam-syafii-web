<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Hafalan;
use App\Models\KehadiranSantri;
use App\Models\Kurikulum;
use App\Models\Pembelajaran;
use App\Models\Santri;
use App\Models\Spp;
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

        $santri = Auth::user()->santri;
        $presensi = $santri->kehadiran()->whereDate('created_at', Carbon::today())->first();
        $bulan = KehadiranSantri::selectRaw('bulan')->where('santri_id', $santri->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();
        $spp = Spp::where('santri_id', $santri->id)->where('status', 0)->count();

        return view('pages.santri.dashboard', ['title' => 'Beranda', 'santri' => $santri, 'presensi' => $presensi, 'bulan' => $bulan, 'spp' => $spp ]);
    }

    public function show_kehadiran(Request $request)
    {
        $santri = Auth::user()->santri;
        if ($request->ajax()) {
            $bulan = $request->get('bulan');
            $chart = $request->get('chart');
            $data = KehadiranSantri::where('bulan', $bulan)->where('santri_id', $santri->id);
            if ($chart) {
                if ($chart == 'doughnut') {
                    $data = $data->selectRaw('COUNT(keterangan) as data, keterangan as label')->groupBy('keterangan')->get();
                    return response()->json($data);
                } else {
                    $data = [];
                    $data['label'] = KehadiranSantri::selectRaw('bulan')->where('santri_id', $santri->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

                    $data['data'] = [];

                    foreach ($data['label'] as $item) {
                        $data['data'][] = KehadiranSantri::where('bulan', $item->bulan)->selectRaw("COUNT(CASE WHEN keterangan='Hadir' THEN 1 END) as hadir, COUNT(CASE WHEN keterangan='Izin' THEN 1 END) as izin, COUNT(CASE WHEN keterangan='Sakit' THEN 1 END) as sakit, COUNT(CASE WHEN keterangan='Absen' THEN 1 END) as absen")->where('santri_id', $santri->id)->first();
                    }
                    return response()->json($data);
                }
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.kehadiran.santri.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.kehadiran.santri.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.kehadiran.santri.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->addColumn('hari', function ($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function ($row) {
                    return Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->editColumn('nilai_adab', function ($row) {
                    return $row->nilai_adab ?: '-';
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return true;
    }

    public function show_hafalan(Request $request)
    {
        $santri = Auth::user()->santri;
        if ($request->ajax()) {
            $bulan = $request->get('bulan');
            $chart = $request->get('chart');
            $data = Hafalan::where('bulan', $bulan)->where('santri_id', $santri->id);

            if ($chart) {
                if ($chart == 'doughnut') {
                    $data = $data->selectRaw('COUNT(keterangan) as data, keterangan as label')->groupBy('keterangan')->get();
                    return response()->json($data);
                }
            }
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('hari', function ($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function ($row) {
                    return Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('ayat', function ($row) {
                    $jenis = $row->hafalan->jenis == 'QURAN' ? 'Q.S.' : ucfirst(strtolower($row->hafalan->jenis));
                    if ($row->mulai == $row->selesai)
                        return $jenis . ' ' . $row->hafalan->materi . ( $row->mulai ? ': ' . $row->mulai : '');
                    else
                        return $jenis . ' ' . $row->hafalan->materi . ': ' . $row->mulai . '-' . $row->selesai;
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->make(true);
        }
        return true;
    }

    public function show_pembelajaran(Request $request)
    {
        $santri = Auth::user()->santri;
        if ($request->ajax()) {
            $bulan = $request->get('bulan');
            $chart = $request->get('chart');
            $data = Pembelajaran::where('bulan', $bulan)->where('santri_id', $santri->id);

            if ($chart) {
                if ($chart == 'doughnut') {
                    $data = $data->selectRaw('COUNT(keterangan) as data, keterangan as label')->groupBy('keterangan')->get();
                    return response()->json($data);
                }
            }
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('hari', function ($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function ($row) {
                    return Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('ayat', function ($row) {
                    $jenis = $row->bacaan->jenis == 'QURAN' ? 'Q.S.' : ucfirst(strtolower($row->bacaan->jenis));
                    if ($row->mulai == $row->selesai)
                        return $jenis . ' ' . $row->bacaan->materi . ': ' . $row->mulai;
                    else
                        return $jenis . ' ' . $row->bacaan->materi . ': ' . $row->mulai . '-' . $row->selesai;
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->make(true);
        }
    }

    public function profil()
    {
        return view('pages.santri.pengaturan.profil', ['title' => 'Profil']);
    }

    public function akun()
    {
        return view('pages.santri.pengaturan.akun', ['title' => 'Akun']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => ['required','date'],
            'anak_ke' => 'required|integer',
            'jumlah_saudara' => 'required|integer',
            'alamat' => 'required',
            'foto' => 'image|max:2048'
        ]);

        try {

            $admin = Auth::user()->santri;

            $foto = $admin->foto;
            if ($request->hasFile('foto')) {

                if ($foto) Storage::delete("public/$foto");

                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $admin->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara' => $request->jumlah_saudara,
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
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)],
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
            if ($checkEmail)
                return redirect()->route('home')->with('success', 'Akun berhasil diperbarui!');
            else
                return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Akun gagal diperbarui!');
        }
    }

    public function unlink()
    {
        try {
            $profil = Auth::user()->santri;
            if ($profil->foto) Storage::delete("public/$profil->foto");
            $profil->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Foto profil gagal dihapus!');
        }
    }

    public function kelas()
    {
        $title = 'Kelas';
        $kelas = Auth::user()->santri->kelas ?? null;
        if (!$kelas) return redirect()->route('santri.dashboard');
        $kurikulum = Kurikulum::findOrFail($kelas->kurikulum_id);
        return view('pages.santri.kelas.index', compact('title', 'kurikulum', 'kelas'));
    }
}
