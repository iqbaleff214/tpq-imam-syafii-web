<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPengajar;
use App\Models\Pengajar;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class KehadiranPengajarController extends Controller
{
    private $title = "Kehadiran Pengajar";

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $bulan = $request->get('bulan');
            $pengajar_id = $request->get('pengajar_id');
            $keterangan = $request->get('keterangan');
            $hari = $request->get('hari');

            $data = KehadiranPengajar::where('bulan', $bulan);

            if ($pengajar_id) {
                $data = $data->where('pengajar_id', $pengajar_id);
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
                    return '<a href="'.route('admin.kehadiran.pengajar.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.kehadiran.pengajar.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.kehadiran.pengajar.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->addColumn('hari', function($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function($row) {
                    return \Alkoumi\LaravelHijriDate\Hijri::Date('d-m-Y', $row->created_at);
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->isoFormat('D-MM-Y');
                })
                ->addColumn('pengajar', function($row) {
                    return $row->pengajar->nama;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = $this->title;
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $pengajar = Pengajar::all();
        $bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        echo view('pages.admin.kehadiran_pengajar.index', compact('title', 'bulan', 'pengajar', 'hari'));
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

        echo view('pages.admin.kehadiran_pengajar.create', compact('title', 'pengajar'));
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
            return redirect()->route('admin.kehadiran.pengajar.index')->with('error', 'Data presensi gagal ditambahkan!');
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
        Date::setTranslation(new Indonesian());
        $presensi = KehadiranPengajar::findOrFail($id);
        $title = $this->title;

        echo view('pages.admin.kehadiran_pengajar.show', compact('title', 'presensi'));
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

        echo view('pages.admin.kehadiran_pengajar.edit', compact('title', 'pengajar', 'presensi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
            return redirect()->route('admin.kehadiran.pengajar.index')->with('success', 'Data kehadiran berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.kehadiran.pengajar.index')->with('error', 'Data kehadiran gagal dihapus!');
        }
    }
}
