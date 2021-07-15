<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\Pengajar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class KelasController extends Controller
{
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
                    return '<a href="' . route('admin.kelas.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.kelas.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.kelas.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2" onclick="return confirm(\'Yakin ingin menghapus ' . $row->nama_kelas . '?\')"> Hapus </button>
                            </form>';
                })
                ->addColumn('pengajar', function ($row) {
                    return $row->pengajar->nama;
                })
                ->addColumn('kurikulum', function ($row) {
                    return $row->kurikulum->tingkat;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        echo view('pages.admin.kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == 'jk') {
                return \response()->json(Pengajar::where('jenis_kelamin', $request->jenis_kelamin)->get());
            } else {
                return \response()->json(Pengajar::find($request->id));
            }
        }
        $pengajar = Pengajar::where('jenis_kelamin', 'L')->get();
        $kurikulum = Kurikulum::all();

        echo view('pages.admin.kelas.create', compact('pengajar', 'kurikulum'));
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
            return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.kelas.index')->with('error', 'Data kelas gagal ditambahkan!');
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
        $kelas = Kelas::find($id);
        echo view('pages.admin.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $kelas = Kelas::find($id);
        $pengajar = Pengajar::where('jenis_kelamin', $kelas->pengajar->jenis_kelamin)->get();
        $kurikulum = Kurikulum::all();
        echo view('pages.admin.kelas.edit', compact('kelas', 'pengajar', 'kurikulum'));
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
        $kelas = Kelas::find($id);
        $request->validate([
            'nama_kelas' => 'required',
            'jenis_kelas' => 'required',
            'pengajar_id' => 'required',
            'kurikulum_id' => 'required',
        ]);

        try {
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
                'kurikulum_id' => $request->kurikulum_id,
                'jenis_kelas' => $request->jenis_kelas,
                'pengajar_id' => $request->pengajar_id,
            ]);

            return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->route('admin.kelas.index')->with('error', 'Data kelas gagal diedit!');
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
            Kelas::find($id)->delete();
            return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.kelas.index')->with('error', 'Data kelas gagal dihapus!');
        }
    }
}
