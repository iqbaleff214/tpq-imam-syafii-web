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
    private $title = 'Kehadiran';

    public function __construct()
    {
        parent::__construct();
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
    }

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
            $keterangan = $request->get('keterangan');
            $hari = $request->get('hari');

            if ($bulan) {
                $data = $data->where('bulan', $bulan);
            }

            if ($hari !== null) {
                $data = $data->whereRaw('WEEKDAY(created_at) = ?', [$hari]);
            }

            if ($keterangan) {
                $data = $data->where('keterangan', $keterangan);
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="'.route('pengajar.kehadiran.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('pengajar.kehadiran.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>';
                })
                ->addColumn('hari', function($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function($row) {
                    return Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->isoFormat('D-MM-Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = $this->title;
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        echo view('pages.pengajar.kehadiran.index', compact('title', 'bulan', 'hari'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
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
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $presensi = KehadiranPengajar::findOrFail($id);
        $title = $this->title;

        echo view('pages.pengajar.kehadiran.show', compact('title', 'presensi'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $presensi = KehadiranPengajar::findOrFail($id);
        $title = $this->title;

        echo view('pages.pengajar.kehadiran.edit', compact('title', 'presensi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $kehadiranPengajar = KehadiranPengajar::findOrFail($id);
        try {
            if ($request->input('keterangan')) {
                $kehadiranPengajar->update([
                    'keterangan' => $request->input('keterangan'),
                    'datang' => $request->input('datang'),
                    'pulang' => $request->input('pulang'),
                ]);
            } else {
                $kehadiranPengajar->update(['pulang' => Carbon::now()]);
            }
            return redirect()->back()->with('success', 'Berhasil mengisi presensi');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal melakukan presensi');
        }
    }
}
