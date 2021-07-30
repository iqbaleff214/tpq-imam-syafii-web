<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPengajar;
use App\Models\Kurikulum;
use App\Models\Santri;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {
        Date::setTranslation(new Indonesian());

        $title = 'Dasbor';

        # Mengecek hari libur
        $libur = [Carbon::FRIDAY, Carbon::SATURDAY, Carbon::SUNDAY];
        $ngaji = !in_array(Carbon::today()->dayOfWeek, $libur);

        # Presensi Pengajar
        $presensi = KehadiranPengajar::where('pengajar_id', Auth::user()->pengajar->id)->whereDate('created_at', Carbon::today())->first();
        $presensi_bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->where('pengajar_id', Auth::user()->pengajar->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();


        # Data santri
        $kelas_id = Auth::user()->pengajar->kelas->id ?? null;
        $santri = Santri::where('kelas_id', $kelas_id)->get();



        return view('pages.pengajar.dashboard', compact('title', 'ngaji', 'presensi', 'presensi_bulan'));
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
