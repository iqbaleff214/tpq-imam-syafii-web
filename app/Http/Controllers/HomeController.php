<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Donasi;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\KategoriGaleri;
use App\Models\Kelas;
use App\Models\Kontak;
use App\Models\Lembaga;
use App\Models\Pengajar;
use App\Models\Pengumuman;
use App\Models\Santri;
use App\Models\SantriWali;
use App\Models\SppOpsi;
use App\Models\User;
use App\Rules\CheckAge;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return RedirectResponse
     */
    public function index()
    {
        $this->middleware('auth');
        switch (Auth::user()->peran) {
            case 'Kepala':
                return redirect()->to('/kepala');
                break;
            case 'Admin':
                return redirect()->to('/admin');
                break;
            case 'Pengajar':
                return redirect()->to('/pengajar');
                break;
            case 'Santri':
                return redirect()->to('/santri');
                break;
            default:
                Auth::logout();
                return redirect()->to('/logout');
                break;
        }
    }

    public function beranda()
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Beranda';

        $count = [
            'pengajar' => Pengajar::where('status', 'Aktif')->count(),
            'kelas' => Kelas::count(),
            'santri' => Santri::where('jenis_kelamin', 'L')->count(),
            'santriwati' => Santri::where('jenis_kelamin', 'P')->count(),
        ];

        $pengumuman = Pengumuman::limit(3)->orderBy('created_at', 'desc')->get();
        $fasilitas = Fasilitas::all();

        return view('pages.frontend.index', compact('count', 'pengumuman', 'profil', 'title', 'fasilitas'));
    }

    public function pengumuman(Request $request)
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Pengumuman';

        if (isset($request->q)) {
            $pengumuman = Pengumuman::where("judul", 'like', '%'.$request->query('q').'%')->orderBy('created_at', 'desc')->paginate(6);
        } else {
            $pengumuman = Pengumuman::orderBy('created_at', 'desc')->paginate(6);
        }

        $newest = Pengumuman::limit(3)->orderBy('created_at', 'desc')->get();

        return view('pages.frontend.pengumuman', compact('pengumuman', 'newest', 'title', 'profil'));
    }

    public function show_pengumuman($slug)
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();

        $pengumuman = Pengumuman::where('slug', $slug)->firstOrFail();
        $pengumuman->increment('seen');
        $title = $pengumuman->judul;
        $prev = Pengumuman::where('id', '<', $pengumuman->id)->orderBy('id', 'desc')->first();
        $next = Pengumuman::where('id', '>', $pengumuman->id)->orderBy('id')->first();
        $newest = Pengumuman::limit(3)->orderBy('created_at', 'desc')->get();

        return view('pages.frontend.pengumuman-lihat', compact('pengumuman', 'newest', 'prev', 'next', 'profil', 'title'));
    }

    public function galeri()
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Galeri';

        $galeri = Galeri::all();
        $kategori = KategoriGaleri::all();
        return view('pages.frontend.galeri', compact('galeri', 'kategori', 'profil', 'title'));
    }

    public function donasi(Request $request)
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Donasi';

        $donasi = $request->get('jumlah');

        return view('pages.frontend.donasi', compact('profil', 'title', 'donasi'));
    }

    public function store_donasi(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required|max:15',
            'jumlah' => 'required|numeric|integer|min:0'
        ]);
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
        try {
            Donasi::create([
                'nama' => $request->input('nama') ?: 'Hamba Allah',
                'no_telp' => $request->input('no_telp'),
                'jumlah' => $request->input('jumlah'),
                'keterangan' => $request->input('keterangan'),
                'bulan' => Hijri::convertToHijri(Carbon::today())->format('F o')
            ]);
            return redirect()->back()->with('success', 'Berhasil konfirmasi donasi!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal konfirmasi donasi!');
        }
    }

    public function pendaftaran()
    {
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());

        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Pendaftaran Santri';

        $spp = SppOpsi::all();
        $class_spp = null;
        switch ($spp->count()) {
            case 1: $class_spp = 'col-lg-4 col-md-6 col-12 offset-md-4'; break;
            case 2: $class_spp = 'col-lg-4 col-md-6 col-12 offset-md-1'; break;
            case 4: $class_spp = 'col-lg-3 col-md-6 col-12'; break;
            default: $class_spp = 'col-lg-4 col-md-6 col-12'; break;
        }
        return view('pages.frontend.pendaftaran', compact('spp', 'class_spp', 'profil', 'title'));
    }

    public function next_pendaftaran(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => ['required', 'date', new CheckAge()],
            'alamat' => 'required',
            'anak_ke' => 'required|numeric',
            'jumlah_saudara' => 'required|numeric',
            'nama_wali' => 'required',
            'no_telp' => 'required|max:15',
            'spp_opsi_id' => 'required',
        ]);

        $newNis = $request->jenis_kelamin == 'L' ? 'I' : 'A';
        # $newNis .= '-';
        $newNis .= \Alkoumi\LaravelHijriDate\Hijri::Date('ym');
        $no = Santri::withTrashed()->where('nis', 'like', '%' . $newNis . '%')->count() + 1;
        $nis = sprintf("$newNis%02d", $no);

        return redirect()->back()->with('nis', $nis)->withInput();
    }

    public function post_pendaftaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => ['required', Rule::unique('santri')],
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => ['required', 'date', new CheckAge()],
            'alamat' => 'required',
            'anak_ke' => 'required|numeric',
            'jumlah_saudara' => 'required|numeric',
            'nama_wali' => 'required',
            'no_telp' => 'required|max:15',
            'spp_opsi_id' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);
        if ($validator->fails()) return redirect()->back()->with('nis', $request->nis)->withInput()->withErrors($validator);

        try {
            $akun = User::create([
                'username' => $request->nis,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'peran' => 'Santri',
            ]);
            $santri = Santri::create([
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan ?: $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'anak_ke' => $request->anak_ke ?: 1,
                'jumlah_saudara' => $request->jumlah_saudara ?: 1,
                'alamat' => $request->alamat,
                'status' => "Calon",
                'user_id' => $akun->id,
                'spp_opsi_id' => $request->spp_opsi_id,
            ]);
            SantriWali::create([
                'nama_wali' => $request->nama_wali,
                'hubungan' => "Ayah",
                'no_telp' => $request->no_telp,
                'santri_id' => $santri->id
            ]);

            return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil!');
        } catch (\Throwable $e) {
            return redirect()->route('pendaftaran')->with('error', 'Pendaftaran gagal!');
        }
    }

    public function struktur()
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Struktur Organisasi';

        $pengelola = Administrator::all();
        $ustaz = Pengajar::where('jenis_kelamin', 'L')->where('status', 'Aktif')->get();
        $ustazah = Pengajar::where('jenis_kelamin', 'P')->where('status', 'Aktif')->get();
        return view('pages.frontend.struktur', compact('pengelola', 'ustaz', 'ustazah', 'profil', 'title'));
    }

    public function hubungi()
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Hubungi Kami';

        return view('pages.frontend.hubungi', compact('profil', 'title'));
    }

    public function store_hubungi(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required|max:15',
            'subjek' => 'required',
            'email' => 'required|email',
            'pesan' => 'required'
        ]);
        try {
            Kontak::create([
                'nama' => $request->input('nama'),
                'no_telp' => $request->input('no_telp'),
                'email' => $request->input('email'),
                'subyek' => $request->input('subjek'),
                'pesan' => $request->input('pesan'),
            ]);
            return redirect()->back()->with('success', 'Berhasil mengirimkan pesan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal mengirimkan pesan!');
        }
    }
}
