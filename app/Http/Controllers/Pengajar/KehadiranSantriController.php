<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\KehadiranSantri;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KehadiranSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        Date::setTranslation(new Indonesian());
        try {
            $data = [
                'santri_id' => $request->input('santri_id'),
                'nilai_adab' => $request->input('nilai_adab'),
                'keterangan' => $request->input('keterangan'),
                'bulan' => Date::today()->format('F o')
            ];

            KehadiranSantri::create($data);

            return redirect()->back()->with('success', 'Berhasil mengisi presensi');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal melakukan presensi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->ajax()) {

            $bulan = $request->get('bulan');
            $chart = $request->get('chart');

            $data = KehadiranSantri::where('bulan', $bulan)->where('santri_id', $id);

            if ($chart) {
                if ($chart == 'doughnut') {
                    $data = $data->selectRaw('COUNT(keterangan) as data, keterangan as label')->groupBy('keterangan')->get();
                    return response()->json($data);
                } else {
                    $data = KehadiranSantri::where('santri_id', $id)->groupBy('bulan')->selectRaw('COUNT(CASE WHEN keterangan="Hadir" THEN 1 ELSE NULL END) as data, bulan as label')->get();
                    return response()->json($data);
                }
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('hari', function ($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function ($row) {
                    return \Alkoumi\LaravelHijriDate\Hijri::Date('d-m-Y', $row->created_at);
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->editColumn('nilai_adab', function ($row) {
                    return $row->nilai_adab ?? '-';
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @pa$id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\KehadiranSantri  $kehadiranSantri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KehadiranSantri $kehadiranSantri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KehadiranSantri  $kehadiranSantri
     * @return \Illuminate\Http\Response
     */
    public function destroy(KehadiranSantri $kehadiranSantri)
    {
        //
    }
}