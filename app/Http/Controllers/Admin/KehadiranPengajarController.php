<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPengajar;
use App\Models\Pengajar;
use Exception;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class KehadiranPengajarController extends Controller
{
    private $title = "Kehadiran Pengajar";

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
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.kehadiran.pengajar.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.kehadiran.pengajar.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.kehadiran.pengajar.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
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

        $title = $this->title;
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $pengajar = Pengajar::all();
        $bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        return view('pages.admin.kehadiran_pengajar.index', compact('title', 'bulan', 'pengajar', 'hari'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        $pengajar = Pengajar::all();

        return view('pages.admin.kehadiran_pengajar.create', compact('title', 'pengajar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'created_at' => 'required|date',
            'pengajar_id' => 'required',
            'keterangan' => 'required',
            'datang' => Rule::requiredIf($request->keterangan == 'Hadir'),
            'pulang' => Rule::requiredIf($request->keterangan == 'Hadir'),
        ]);

        try {
            KehadiranPengajar::create([
                'created_at' => $request->created_at,
                'keterangan' => $request->keterangan,
                'pengajar_id' => $request->pengajar_id,
                'datang' => $request->datang,
                'pulang' => $request->pulang,
                'bulan' => Hijri::convertToHijri($request->created_at)->format('F o')
            ]);

            return redirect()->route('admin.kehadiran.pengajar.index')->with('success', 'Data presensi berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data presensi gagal ditambahkan!');
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

        return view('pages.admin.kehadiran_pengajar.show', compact('title', 'presensi'));
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
        $pengajar = Pengajar::all();

        return view('pages.admin.kehadiran_pengajar.edit', compact('title', 'pengajar', 'presensi'));
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
        $request->validate([
            'created_at' => 'required|date',
            'keterangan' => 'required',
            'datang' => Rule::requiredIf($request->keterangan == 'Hadir'),
            'pulang' => Rule::requiredIf($request->keterangan == 'Hadir'),
        ]);

        try {
            $presensi = KehadiranPengajar::findOrFail($id);
            $presensi->update([
                'created_at' => $request->created_at,
                'keterangan' => $request->keterangan,
                'datang' => $request->datang,
                'pulang' => $request->pulang,
                'bulan' => Hijri::convertToHijri($request->created_at)->format('F o')
            ]);

            return redirect()->back()->with('success', 'Data presensi berhasil diedit!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data presensi gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            KehadiranPengajar::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Data kehadiran berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data kehadiran gagal dihapus!');
        }
    }
}
