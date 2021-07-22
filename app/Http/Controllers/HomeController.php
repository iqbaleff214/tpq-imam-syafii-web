<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Galeri;
use App\Models\KategoriGaleri;
use App\Models\Kelas;
use App\Models\Lembaga;
use App\Models\Pengajar;
use App\Models\Pengumuman;
use App\Models\Santri;
use App\Models\SppOpsi;
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
        }
    }

    public function beranda()
    {
        $profil = Lembaga::where('is_active', true)->first();
        $title = 'Beranda';

        $count = [
            'pengajar' => Pengajar::where('status', 'Aktif')->count(),
            'kelas' => Kelas::count(),
            'santri' => Santri::where('jenis_kelamin', 'L')->count(),
            'santriwati' => Santri::where('jenis_kelamin', 'P')->count(),
        ];

        $pengumuman = Pengumuman::limit(3)->get();

        echo view('pages.frontend.index', compact('count', 'pengumuman', 'profil', 'title'));
    }

    public function pengumuman(Request $request)
    {
        $profil = Lembaga::where('is_active', true)->first();
        $title = 'Pengumuman';

        if (isset($request->q)) {
            $pengumuman = Pengumuman::where("judul", 'like', '%'.$request->query('q').'%')->paginate(6);
        } else {
            $pengumuman = Pengumuman::paginate(6);
        }

        $newest = Pengumuman::limit(3)->get();

        echo view('pages.frontend.pengumuman', compact('pengumuman', 'newest', 'title', 'profil'));
    }

    public function pengumuman_lihat($slug)
    {
        $profil = Lembaga::where('is_active', true)->first();

        $pengumuman = Pengumuman::where('slug', $slug)->firstOrFail();
        $title = $pengumuman->judul;
        $prev = Pengumuman::where('id', '<', $pengumuman->id)->orderBy('id', 'desc')->first();
        $next = Pengumuman::where('id', '>', $pengumuman->id)->orderBy('id')->first();
        $newest = Pengumuman::limit(3)->get();

        echo view('pages.frontend.pengumuman-lihat', compact('pengumuman', 'newest', 'prev', 'next', 'profil', 'title'));
    }

    public function galeri()
    {
        $profil = Lembaga::where('is_active', true)->first();
        $title = 'Galeri';

        $galeri = Galeri::all();
        $kategori = KategoriGaleri::all();
        echo view('pages.frontend.galeri', compact('galeri', 'kategori', 'profil', 'title'));
    }

    public function donasi()
    {
        $profil = Lembaga::where('is_active', true)->first();
        $title = 'Donasi';

        echo view('pages.frontend.donasi', compact('profil', 'title'));
    }

    public function pendaftaran()
    {
        $profil = Lembaga::where('is_active', true)->first();
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
        $profil = Lembaga::where('is_active', true)->first();
        $title = 'Struktur Organisasi';

        $pengelola = Administrator::all();
        $ustaz = Pengajar::where('jenis_kelamin', 'L')->where('status', 'Aktif')->get();
        $ustazah = Pengajar::where('jenis_kelamin', 'P')->where('status', 'Aktif')->get();
        echo view('pages.frontend.struktur', compact('pengelola', 'ustaz', 'ustazah', 'profil', 'title'));
    }

    public function hubungi()
    {
        $profil = Lembaga::where('is_active', true)->first();
        $title = 'Hubungi Kami';

        echo view('pages.frontend.hubungi', compact('profil', 'title'));
    }
}
