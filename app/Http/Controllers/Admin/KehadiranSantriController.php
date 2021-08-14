<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KehadiranSantri;
use App\Models\Santri;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class KehadiranSantriController extends Controller
{
    private $title = "Kehadiran Santri";

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
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $bulan = $request->get('bulan');
            $santri_id = $request->get('santri_id');
            $keterangan = $request->get('keterangan');
            $hari = $request->get('hari');

            $data = KehadiranSantri::where('bulan', $bulan);

            if ($santri_id) {
                $data = $data->where('santri_id', $santri_id);
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
                    return '<a href="' . route('admin.kehadiran.santri.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.kehadiran.santri.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.kehadiran.santri.destroy', $row) . '">
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
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = $this->title;
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $santri = Santri::all();
        $bulan = KehadiranSantri::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        echo view('pages.admin.kehadiran_santri.index', compact('title', 'bulan', 'santri', 'hari'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        $santri = Santri::all();

        echo view('pages.admin.kehadiran_santri.create', compact('title', 'santri'));
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
            'santri_id' => 'required',
            'keterangan' => 'required',
            'nilai_adab' => Rule::requiredIf($request->keterangan == 'Hadir'),
        ]);

        try {
            KehadiranSantri::create([
                'created_at' => $request->created_at,
                'keterangan' => $request->keterangan,
                'santri_id' => $request->santri_id,
                'nilai_adab' => $request->nilai_adab,
                'bulan' => Hijri::convertToHijri($request->created_at)->format('F o')
            ]);

            return redirect()->route('admin.kehadiran.santri.index')->with('success', 'Data presensi berhasil ditambahkan!');
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
        $presensi = KehadiranSantri::findOrFail($id);
        $title = $this->title;

        echo view('pages.admin.kehadiran_santri.show', compact('title', 'presensi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $presensi = KehadiranSantri::findOrFail($id);
        $title = $this->title;
        $santri = Santri::all();

        echo view('pages.admin.kehadiran_santri.edit', compact('title', 'santri', 'presensi'));
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
            'nilai_adab' => Rule::requiredIf($request->keterangan == 'Hadir'),
        ]);

        try {
            $presensi = KehadiranSantri::findOrFail($id);
            $presensi->update([
                'created_at' => $request->created_at,
                'keterangan' => $request->keterangan,
                'nilai_adab' => $request->nilai_adab,
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
            KehadiranSantri::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Data kehadiran berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data kehadiran gagal dihapus!');
        }
    }
}
