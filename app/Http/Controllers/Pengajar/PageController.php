<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {
        $title = 'Dasbor';
        return view('pages.pengajar.dashboard', compact('title'));
    }

    public function kurikulum()
    {
        $title = 'Kurikulum';
        $kelas = Auth::user()->pengajar->kelas;
        $kurikulum = Kurikulum::find($kelas->kurikulum_id);
        return view('pages.pengajar.kurikulum.index', compact('title', 'kurikulum'));
    }
}
