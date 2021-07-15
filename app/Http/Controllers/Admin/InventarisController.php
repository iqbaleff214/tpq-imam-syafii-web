<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Inventaris::all())
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<a href="'.route('admin.inventaris.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="'.route('admin.inventaris.edit', $row).'" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="'.route('admin.inventaris.destroy', $row).'">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <button type="submit" class="btn btn-danger btn-xs px-2" onclick="return confirm(\'Yakin ingin menghapus '.$row->nama_barang.'?\')"> Hapus </button>
                            </form>';
                })
                ->addColumn('total', function($row) {
                    return $row->jumlah_baik + $row->jumlah_rusak;
                })
                ->rawColumns(['action', 'total'])
                ->make(true);
        }
        echo view('pages.admin.inventaris.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        echo view('pages.admin.inventaris.create');
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
            'kode_barang' => 'required|unique:inventaris,kode_barang',
            'nama_barang' => 'required',
            'satuan' => 'required',
            'jumlah_baik' => 'required|integer|min:0',
            'jumlah_rusak' => 'required|integer|min:0',
        ]);

        try {
            $foto = null;
            if ($request->hasFile('foto')) {
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $inventaris = Inventaris::create([
                'kode_barang'   => $request->kode_barang,
                'nama_barang'   => $request->nama_barang,
                'satuan'        => $request->satuan,
                'jumlah_baik'   => $request->jumlah_baik,
                'jumlah_rusak'  => $request->jumlah_rusak,
                'keterangan'    => $request->keterangan,
                'foto'          => $foto,
                'admin_id'      => Auth::user()->administrator->id,
            ]);

            return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->route('admin.inventaris.index')->with('error', 'Data inventaris gagal ditambahkan!');
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
        $inventaris = Inventaris::find($id);
        echo view('pages.admin.inventaris.show', compact('inventaris'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $inventaris = Inventaris::find($id);
        echo view('pages.admin.inventaris.edit', compact('inventaris'));
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
        $inventaris = Inventaris::find($id);
        $request->validate([
            'nama_barang'   => 'required',
            'satuan'        => 'required',
            'jumlah_baik'   => 'required|integer|min:0',
            'jumlah_rusak'  => 'required|integer|min:0',
        ]);

        try {
            $foto = $inventaris->foto;
            if ($request->hasFile('foto')) {
                if ($foto) Storage::delete("public/$foto");

                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $inventaris->update([
                'nama_barang'   => $request->nama_barang,
                'satuan'        => $request->satuan,
                'jumlah_baik'   => $request->jumlah_baik,
                'jumlah_rusak'  => $request->jumlah_rusak,
                'keterangan'    => $request->keterangan,
                'foto'          => $foto,
                'admin_id'      => Auth::user()->administrator->id,
            ]);

            return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->route('admin.inventaris.index')->with('error', 'Data inventaris gagal diedit!');
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
            $inventaris = Inventaris::find($id);
            if ($inventaris->foto) Storage::delete("public/$inventaris->foto");
            $inventaris->update(['foto' => null]);
            $inventaris->delete();

            return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->route('admin.inventaris.index')->with('error', 'Data inventaris gagal dihapus!');
        }
    }
}
