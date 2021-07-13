<?php

namespace App\Http\Controllers;

use App\Models\Pengajar;
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
        $count = [
            'pengajar' => Pengajar::count()
        ];
        echo view('pages.frontend.index', compact('count'));
    }
    public function pengumuman()
    {
        echo view('pages.frontend.pengumuman');
    }

    public function galeri()
    {
        echo view('pages.frontend.galeri');
    }

    public function donasi()
    {
        echo view('pages.frontend.donasi');
    }

    public function pendaftaran()
    {
        echo view('pages.frontend.pendaftaran');
    }

    public function pengelola()
    {
        echo view('pages.frontend.pengelola');
    }

    public function hubungi()
    {
        echo view('pages.frontend.hubungi');
    }
}
