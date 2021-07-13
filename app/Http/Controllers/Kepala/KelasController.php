<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\Pengajar;
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
                ->addColumn('pengajar', function ($row) {
                    return $row->pengajar->nama;
                })
                ->addColumn('kurikulum', function ($row) {
                    return $row->kurikulum->tingkat;
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('kepala.kelas.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('kepala.kelas.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('kepala.kelas.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2" onclick="return confirm(\'Yakin ingin menghapus ' . $row->nama_kelas . '?\')"> Hapus </button>
                            </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        echo view('pages.kepala.kelas.index');
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

        echo view('pages.kepala.kelas.create', compact('pengajar', 'kurikulum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Kelas $kelas
     * @return Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Kelas $kelas
     * @return Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Kelas $kelas
     * @return Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Kelas $kelas
     * @return Response
     */
    public function destroy(Kelas $kelas)
    {
        //
    }
}
