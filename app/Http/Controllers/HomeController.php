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
use App\Models\SppOpsi;
use Carbon\Carbon;
use GeniusTS\HijriDate\Hijri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        echo view('pages.frontend.index', compact('count', 'pengumuman', 'profil', 'title', 'fasilitas'));
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

        echo view('pages.frontend.pengumuman', compact('pengumuman', 'newest', 'title', 'profil'));
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

        echo view('pages.frontend.pengumuman-lihat', compact('pengumuman', 'newest', 'prev', 'next', 'profil', 'title'));
    }

    public function galeri()
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Galeri';

        $galeri = Galeri::all();
        $kategori = KategoriGaleri::all();
        echo view('pages.frontend.galeri', compact('galeri', 'kategori', 'profil', 'title'));
    }

    public function donasi(Request $request)
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Donasi';

        $donasi = $request->get('donasi');

        echo view('pages.frontend.donasi', compact('profil', 'title', 'donasi'));
    }

    public function store_donasi(Request $request)
    {
        try {
            Donasi::create([
                'nama' => $request->input('nama'),
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
        echo view('pages.frontend.pendaftaran', compact('spp', 'class_spp', 'profil', 'title'));
    }

    public function struktur()
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Struktur Organisasi';

        $pengelola = Administrator::all();
        $ustaz = Pengajar::where('jenis_kelamin', 'L')->where('status', 'Aktif')->get();
        $ustazah = Pengajar::where('jenis_kelamin', 'P')->where('status', 'Aktif')->get();
        echo view('pages.frontend.struktur', compact('pengelola', 'ustaz', 'ustazah', 'profil', 'title'));
    }

    public function hubungi()
    {
        $profil = Lembaga::where('is_active', true)->firstOrFail();
        $title = 'Hubungi Kami';

        echo view('pages.frontend.hubungi', compact('profil', 'title'));
    }

    public function store_hubungi(Request $request)
    {
        try {
            Kontak::create([
                'nama' => $request->input('nama'),
                'no_telp' => $request->input('no_telp'),
                'email' => $request->input('email'),
                'subyek' => $request->input('subyek'),
                'pesan' => $request->input('pesan'),
            ]);
            return redirect()->back()->with('success', 'Berhasil mengirimkan pesan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal mengirimkan pesan!');
        }
    }
}
