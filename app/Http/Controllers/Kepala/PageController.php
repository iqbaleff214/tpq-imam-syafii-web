<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Donasi;
use App\Models\Honor;
use App\Models\Inventaris;
use App\Models\Kas;
use App\Models\KehadiranPengajar;
use App\Models\KehadiranSantri;
use App\Models\Kelas;
use App\Models\Lembaga;
use App\Models\Pengajar;
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
    public function __construct()
    {
        parent::__construct();
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->get('bulan');
            $calon = $request->get('calon');
            if ($calon) {
                $data = Santri::where('status', $calon == 2 ? 'Ditolak' : 'Calon');
                return DataTables::of($data->get())
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) use ($calon) {
                        $col = '';
                        $col .= '<form class="d-inline" method="POST" action="' . route('admin.santri.accept', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="status" value="Aktif">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <button type="submit" class="btn bg-maroon btn-xs px-2 btn-confirm"> Terima </button>
                                </form>';
                        if ($calon == 1) {
                            $col .= '<form class="d-inline" method="POST" action="' . route('admin.santri.accept', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="status" value="Ditolak">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <button type="submit" class="btn btn-outline-danger btn-xs px-2 btn-confirm"> Tolak </button>
                                </form>';
                        }
                        return $col;
                    })
                    ->editColumn('jenis_kelamin', function ($row) {
                        return $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                    })
                    ->editColumn('nis', function ($row) {
                        return '<a href="' . route('admin.santri.show', $row) . '">' . $row->nis . '</a>';
                    })
                    ->addColumn('umur', function ($row) {
                        return Carbon::parse($row->tanggal_lahir)->age . ' tahun';
                    })
                    ->addColumn('kelas', function ($row) {
                        return $row->kelas ? $row->kelas->nama_kelas : 'Belum Masuk';
                    })
                    ->rawColumns(['action', 'nis'])
                    ->make(true);
            }
            if ($request->get('kehadiran_semua')) {
                $data = [];
                $kelas = Kelas::all();
                foreach ($kelas as $item) {
                    if ($item->santri) {
                        $data['label'][] = $item->nama_kelas . ' (' . $item->jenis_kelas . ')';
                        $ids = collect($item->santri()->select('id')->get()->toArray())->flatten()->all();
                        if ($bulan) {
                            $data['data'][] = KehadiranSantri::selectRaw("COUNT(CASE WHEN keterangan='Hadir' THEN 1 END) as hadir, COUNT(CASE WHEN keterangan='Izin' THEN 1 END) as izin, COUNT(CASE WHEN keterangan='Sakit' THEN 1 END) as sakit, COUNT(CASE WHEN keterangan='Absen' THEN 1 END) as absen")->whereIn('santri_id', $ids)->where('bulan', $bulan)->first();
                        } else {
                            $data['data'][] = KehadiranSantri::selectRaw("COUNT(CASE WHEN keterangan='Hadir' THEN 1 END) as hadir, COUNT(CASE WHEN keterangan='Izin' THEN 1 END) as izin, COUNT(CASE WHEN keterangan='Sakit' THEN 1 END) as sakit, COUNT(CASE WHEN keterangan='Absen' THEN 1 END) as absen")->whereIn('santri_id', $ids)->first();
                        }
                    }
                }

                return response()->json($data);
            }
        }
        $count = [
            'santri' => Santri::where('status', 'Aktif')->count(),
            'pengajar' => Pengajar::where('status', 'Aktif')->count(),
            'saldo' => Kas::selectRaw('SUM(pemasukan) - SUM(pengeluaran) as saldo')->first()->saldo,
            'donasi' => Donasi::selectRaw('SUM(jumlah) as jumlah')->where('status', 1)->first()->jumlah,
        ];

        $rasio = [
            'santri' => Santri::where('status', 'Aktif')->selectRaw("COUNT(CASE WHEN jenis_kelamin='L' THEN 1 END) as cowok,COUNT(CASE WHEN jenis_kelamin='P' THEN 1 END) as cewek")->first(),
            'pengajar' => Pengajar::where('status', 'Aktif')->selectRaw("COUNT(CASE WHEN jenis_kelamin='L' THEN 1 END) as cowok,COUNT(CASE WHEN jenis_kelamin='P' THEN 1 END) as cewek")->first(),
        ];

        $title = 'Dasbor';
        $profil = Lembaga::where('is_active', 1)->first();
        $bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        $spp = Spp::where('bulan', Date::today()->format('F o'))->count();
        $honor = Honor::where('bulan', Date::today()->format('F o'))->count();

        return view('pages.kepala.dashboard', compact('count', 'title', 'profil', 'rasio', 'bulan', 'spp', 'honor'));
    }

    public function profil()
    {
        $title = 'Profil';
        return view('pages.kepala.pengaturan.profil', compact('title'));
    }

    public function akun()
    {
        return view('pages.kepala.pengaturan.akun', ['title' => 'Akun']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        $admin = Auth::user()->administrator;

        try {

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

    public function inventaris(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Inventaris::all())
                ->addIndexColumn()
                ->addColumn('total', function($row) {
                    return $row->jumlah_baik + $row->jumlah_rusak;
                })
                ->rawColumns(['action', 'total'])
                ->make(true);
        }
        $title = 'Inventaris';
        return view('pages.kepala.laporan.inventaris', ['title' => $title]);
    }

}
