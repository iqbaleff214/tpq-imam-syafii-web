<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriGaleri;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class KategoriGaleriController extends Controller
{
    private $title = 'Kategori Galeri';

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
            return DataTables::of(KategoriGaleri::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.galeri.kategori.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.galeri.kategori.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.galeri.kategori.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->addColumn('jumlah', function ($row) {
                    return count($row->galeri);
                })
                ->rawColumns(['action', 'jumlah'])
                ->make(true);
        }

        echo view('pages.admin.kategori_galeri.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        echo view('pages.admin.kategori_galeri.create', ['title' => $this->title]);
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
            'kategori' => 'required',
        ]);

        try {
            KategoriGaleri::create([
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('admin.galeri.kategori.index')->with('success', 'Data kategori berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->route('admin.galeri.kategori.index')->with('error', 'Data kategori gagal ditambahkan!');
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
        echo view('pages.admin.kategori_galeri.show', ['title' => $this->title, 'kategori' => KategoriGaleri::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        echo view('pages.admin.kategori_galeri.edit', ['title' => $this->title, 'kategori' => KategoriGaleri::findOrFail($id)]);
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
            'kategori' => 'required',
        ]);

        try {
            KategoriGaleri::findOrFail($id)->update([
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('admin.galeri.kategori.index')->with('success', 'Data kategori berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->route('admin.galeri.kategori.index')->with('error', 'Data kategori gagal diedit!');
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
            KategoriGaleri::findOrFail($id)->delete();
            return redirect()->route('admin.galeri.kategori.index')->with('success', 'Data kategori berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.galeri.kategori.index')->with('error', 'Data kategori gagal dihapus!');
        }
    }
}
