<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Hafalan;
use App\Models\KehadiranSantri;
use App\Models\Pembelajaran;
use App\Models\Santri;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class SantriController extends Controller
{
    private $title = 'Santri';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Santri::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('kepala.santri.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>';
                })
                ->editColumn('jenis_kelamin', function ($row) {
                    return $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->addColumn('umur', function ($row) {
                    return Carbon::parse($row->tanggal_lahir)->age . ' tahun';
                })
                ->addColumn('kelas', function ($row) {
                    return $row->kelas ? $row->kelas->nama_kelas : 'Belum Masuk';
                })
                ->rawColumns(['action', 'kelas', 'umur'])
                ->make(true);
        }

        echo view('pages.kepala.santri.index', ['title' => $this->title]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Santri  $santri
     * @return Response
     */
    public function show(Santri $santri)
    {
        $bulan = KehadiranSantri::selectRaw('bulan')->where('santri_id', $santri->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();
        echo view('pages.kepala.santri.show', ['title' => $this->title, 'santri' => $santri, 'bulan' => $bulan]);
    }

    public function show_hafalan(Request $request, Santri $santri)
    {
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
                    return \GeniusTS\HijriDate\Hijri::convertToHijri($row->created_at)->format('d-m-Y');
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
    }

    public function show_pembelajaran(Request $request, Santri $santri)
    {
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
                    return \GeniusTS\HijriDate\Hijri::convertToHijri($row->created_at)->format('d-m-Y');
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

    public function show_kehadiran(Request $request, Santri $santri)
    {
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
        }
    }
}
