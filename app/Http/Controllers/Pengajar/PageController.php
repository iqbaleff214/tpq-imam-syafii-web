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
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    public function index(Request $request)
    {
        Date::setTranslation(new Indonesian());

        $title = 'Beranda';

        # Mengecek hari libur
        $libur = [Carbon::FRIDAY, Carbon::SATURDAY, Carbon::SUNDAY];
        $ngaji = !in_array(Carbon::today()->dayOfWeek, $libur);

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
                        return 'Libur';
                    }
                })
                ->editColumn('nama_panggilan', function($row) {
                    return "<a href='". route('pengajar.santri.show', $row) ."'>" . $row->nama_panggilan . "</a>";
                })
                ->rawColumns(['action', 'nama_panggilan'])
                ->make(true);
        }

        # Presensi Pengajar
        $presensi = KehadiranPengajar::where('pengajar_id', Auth::user()->pengajar->id)->whereDate('created_at', Carbon::today())->first();
        $presensi_bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->where('pengajar_id', Auth::user()->pengajar->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();


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
