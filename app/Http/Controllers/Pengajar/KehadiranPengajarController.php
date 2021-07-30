<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPengajar;
use Carbon\Carbon;
use Exception;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class KehadiranPengajarController extends Controller
{
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
            $data = KehadiranPengajar::where('pengajar_id', Auth::user()->pengajar->id)->orderBy('created_at');

            $bulan = $request->get('bulan');
            if ($bulan) {
                $data = $data->where('bulan', $bulan);
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('hari', function($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function($row) {
                    return \Alkoumi\LaravelHijriDate\Hijri::Date('d-m-Y', $row->created_at);
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->isoFormat('D-MM-Y');
                })
                ->make(true);
        }
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
                'pengajar_id' => Auth::user()->pengajar->id,
                'keterangan' => $request->input('keterangan'),
                'bulan' => Date::today()->format('F o')
            ];

            if ($request->input('keterangan') == 'Hadir')
                $data['datang'] = Carbon::now();

            KehadiranPengajar::create($data);

            return redirect()->route('pengajar.dashboard')->with('success', 'Berhasil mengisi presensi');
        } catch (\Throwable $e) {
            return redirect()->route('pengajar.dashboard')->with('error', 'Gagal melakukan presensi');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function update($id)
    {
        $kehadiranPengajar = KehadiranPengajar::findOrFail($id);
        try {
            $kehadiranPengajar->update([ 'pulang' => Carbon::now() ]);
            return redirect()->route('pengajar.dashboard')->with('success', 'Berhasil mengisi presensi');
        } catch (\Throwable $e) {
            return redirect()->route('pengajar.dashboard')->with('error', 'Gagal melakukan presensi');
        }
    }
}
