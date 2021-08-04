<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SppOpsi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class SppOpsiController extends Controller
{
    private $title = 'Opsi SPP';

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
            return DataTables::of(SppOpsi::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.spp.opsi.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.spp.opsi.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.spp.opsi.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data" onclick="return confirm(\'Yakin ingin menghapus ' . $row->opsi . '?\')"> Hapus </button>
                            </form>';
                })
                ->editColumn('jumlah', function ($row) {
                    return 'Rp'.number_format($row->jumlah, 2, ',', '.').' per bulan';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        echo view('pages.admin.opsi_spp.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo view('pages.admin.opsi_spp.create', ['title' => $this->title]);
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
            'opsi' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        try {
            SppOpsi::create([
                'opsi' => $request->opsi,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('admin.spp.opsi.index')->with('success', 'Data opsi berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data opsi gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo view('pages.admin.opsi_spp.show', ['title' => $this->title, 'opsi' => SppOpsi::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo view('pages.admin.opsi_spp.edit', ['title' => $this->title, 'opsi' => SppOpsi::findOrFail($id)]);
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
            'opsi' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        try {
            SppOpsi::findOrFail($id)->update([
                'opsi' => $request->opsi,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->back()->with('success', 'Data opsi berhasil diedit!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data opsi gagal diedit!');
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
            SppOpsi::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Data opsi berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data opsi gagal dihapus!');
        }
    }
}
