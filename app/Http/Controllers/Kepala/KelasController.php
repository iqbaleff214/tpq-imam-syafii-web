<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPengajar;
use App\Models\KehadiranSantri;
use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\Pengajar;
use App\Models\Santri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class KelasController extends Controller
{
    private $title = 'Kelas';
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
            return DataTables::of(Kelas::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('kepala.kelas.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('kepala.kelas.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('kepala.kelas.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->addColumn('pengajar', function ($row) {
                    return $row->pengajar->nama;
                })
                ->addColumn('kurikulum', function ($row) {
                    return $row->kurikulum->tingkat;
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->count();
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = $this->title;
        return view('pages.kepala.kelas.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if (!Pengajar::count()) {
            return redirect()->route('kepala.pengajar.create')->with('info', 'Isi data pengajar terlebih dahulu!');
        }

        if (!Kurikulum::count()) {
            return redirect()->route('kepala.kurikulum.create')->with('info', 'Isi data kurikulum terlebih dahulu!');
        }

        if ($request->ajax()) {
            if ($request->type == 'jk') {
                return \response()->json(Pengajar::where('jenis_kelamin', $request->jenis_kelamin)->get());
            } else {
                return \response()->json(Pengajar::findOrFail($request->id));
            }
        }
        $pengajar = Pengajar::where('jenis_kelamin', 'L')->get();
        $kurikulum = Kurikulum::all();
        $title = $this->title;

        return view('pages.kepala.kelas.create', compact('pengajar', 'kurikulum', 'title'));
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
            'nama_kelas' => 'required',
            'jenis_kelas' => 'required',
            'pengajar_id' => 'required',
            'kurikulum_id' => 'required',
        ]);

        try {
            Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'kurikulum_id' => $request->kurikulum_id,
                'jenis_kelas' => $request->jenis_kelas,
                'pengajar_id' => $request->pengajar_id,
            ]);
            return redirect()->route('kepala.kelas.index')->with('success', 'Data kelas berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data kelas gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $chart = $request->get('chart');
            $bulan = $request->get('bulan');
            if ($chart) {
                $data = [];
                $santri = Santri::where('status', 'Aktif')->where('kelas_id', $id)->get();
                foreach ($santri as $item) {
                    $data['label'][] = $item->nama_panggilan;
                    $hadir = KehadiranSantri::where('santri_id', $item->id)->selectRaw("COUNT(CASE WHEN keterangan='Hadir' THEN 1 END) as hadir, COUNT(CASE WHEN keterangan='Izin' THEN 1 END) as izin, COUNT(CASE WHEN keterangan='Sakit' THEN 1 END) as sakit, COUNT(CASE WHEN keterangan='Absen' THEN 1 END) as absen");
                    if ($bulan) $hadir = $hadir->where('bulan', $bulan);
                    $data['data'][] = $hadir->first();
                }
                return response()->json($data);
            }
        }
        $kelas = Kelas::findOrFail($id);
        $title = $this->title;
        $bulan = KehadiranPengajar::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->where('pengajar_id', $kelas->pengajar_id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();
        return view('pages.kepala.kelas.show', compact('kelas', 'title', 'bulan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $pengajar = Pengajar::where('jenis_kelamin', $kelas->pengajar->jenis_kelamin)->get();
        $kurikulum = Kurikulum::all();
        $title = $this->title;
        return view('pages.kepala.kelas.edit', compact('kelas', 'pengajar', 'kurikulum', 'title'));
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
        $kelas = Kelas::findOrFail($id);
        $request->validate([
            'nama_kelas' => 'required',
            'pengajar_id' => 'required',
            'kurikulum_id' => 'required',
        ]);

        try {
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
                'kurikulum_id' => $request->kurikulum_id,
                'pengajar_id' => $request->pengajar_id,
            ]);

            return redirect()->back()->with('success', 'Data kelas berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data kelas gagal diedit!');
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
            Kelas::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Data kelas berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data kelas gagal dihapus!');
        }
    }
}
