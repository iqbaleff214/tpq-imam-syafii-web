<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPengajar;
use App\Models\KehadiranSantri;
use App\Models\Pengajar;
use App\Models\Santri;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KehadiranController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
    }

    public function pengajar(Request $request)
    {
        if ($request->ajax()) {

            $bulan = $request->get('bulan');
            $chart = $request->get('chart');
            $pengajar_id = $request->get('pengajar_id');
            $keterangan = $request->get('keterangan');
            $hari = $request->get('hari');

            $data = KehadiranPengajar::where('bulan', $bulan);

            if ($pengajar_id) {
                $data = $data->where('pengajar_id', $pengajar_id);
            }

            if ($chart) {
                $data = [];
                $data['label'] = KehadiranPengajar::selectRaw('bulan')->where('pengajar_id', $pengajar_id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();
                $data['data'] = [];

                foreach ($data['label'] as $item) {
                    $data['data'][] = KehadiranPengajar::where('bulan', $item->bulan)->selectRaw("COUNT(CASE WHEN keterangan='Hadir' THEN 1 END) as hadir, COUNT(CASE WHEN keterangan='Izin' THEN 1 END) as izin, COUNT(CASE WHEN keterangan='Sakit' THEN 1 END) as sakit")->where('pengajar_id', $pengajar_id)->first();
                }
                return response()->json($data);
            }

            if ($hari !== null) {
                $data = $data->whereRaw('WEEKDAY(created_at) = ?', [$hari]);
            }

            if ($keterangan) {
                $data = $data->where('keterangan', $keterangan);
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
                ->addColumn('pengajar', function ($row) {
                    return $row->pengajar->nama;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = 'Kehadiran Pengajar';
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $pengajar = Pengajar::all();
        $bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        echo view('pages.kepala.kehadiran.pengajar', compact('title', 'bulan', 'pengajar', 'hari'));
    }

    public function santri(Request $request)
    {
        if ($request->ajax()) {

            $bulan = $request->get('bulan');
            $chart = $request->get('chart');
            $santri_id = $request->get('santri_id');
            $keterangan = $request->get('keterangan');
            $hari = $request->get('hari');

            $data = KehadiranSantri::where('bulan', $bulan);

            if ($santri_id) {
                $data = $data->where('santri_id', $santri_id);
            }

            if ($chart) {
                if ($chart == 'doughnut') {
                    $data = $data->selectRaw('COUNT(keterangan) as data, keterangan as label')->groupBy('keterangan')->get();
                    return response()->json($data);
                } else {
                    $data = [];
                    $data['label'] = KehadiranSantri::selectRaw('bulan')->where('santri_id', $santri_id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

                    $data['data'] = [];

                    foreach ($data['label'] as $item) {
                        $data['data'][] = KehadiranSantri::where('bulan', $item->bulan)->selectRaw("COUNT(CASE WHEN keterangan='Hadir' THEN 1 END) as hadir, COUNT(CASE WHEN keterangan='Izin' THEN 1 END) as izin, COUNT(CASE WHEN keterangan='Sakit' THEN 1 END) as sakit, COUNT(CASE WHEN keterangan='Absen' THEN 1 END) as absen")->where('santri_id', $santri_id)->first();
                    }
                    return response()->json($data);
                }
            }


            if ($hari !== null) {
                $data = $data->whereRaw('WEEKDAY(created_at) = ?', [$hari]);
            }

            if ($keterangan) {
                $data = $data->where('keterangan', $keterangan);
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
                ->editColumn('nilai_adab', function ($row) {
                    return $row->nilai_adab ?: '-';
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = 'Kehadiran Santri';
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $santri = Santri::all();
        $bulan = KehadiranSantri::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        echo view('pages.kepala.kehadiran.santri', compact('title', 'bulan', 'santri', 'hari'));
    }
}
