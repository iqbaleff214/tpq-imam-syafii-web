<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\KategoriGaleri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class GaleriController extends Controller
{
    private $title = "Galeri";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Galeri::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.galeri.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.galeri.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.galeri.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->addColumn('kategori', function ($row) {
                    return $row->kategori->kategori;
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->rawColumns(['action', 'kategori', 'tanggal'])
                ->make(true);
        }

        echo view('pages.admin.galeri.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!KategoriGaleri::count()) {
            return redirect()->route('admin.galeri.kategori.create')->with('info', 'Isi data kategori terlebih dahulu!');
        }

        echo view('pages.admin.galeri.create', ['title' => $this->title, 'kategori' => KategoriGaleri::all()]);
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
            'judul' => 'required',
            'kategori_galeri_id' => 'required',
            'foto' => 'required|image|max:2048'
        ]);

        try {
            $foto = null;

            if ($request->hasFile('foto')) {
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            Galeri::create([
                'judul' => $request->judul,
                'kategori_galeri_id' => $request->kategori_galeri_id,
                'keterangan' => $request->keterangan,
                'foto' => $foto,
            ]);

            return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data galeri gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Galeri $galeri
     * @return \Illuminate\Http\Response
     */
    public function show(Galeri $galeri)
    {
        echo view('pages.admin.galeri.show', ['title' => $this->title, 'galeri' => $galeri]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Galeri $galeri
     * @return \Illuminate\Http\Response
     */
    public function edit(Galeri $galeri)
    {
        echo view('pages.admin.galeri.edit', ['title' => $this->title, 'kategori' => KategoriGaleri::all(), 'galeri' => $galeri]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Galeri $galeri
     * @return RedirectResponse
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required',
            'kategori_galeri_id' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);

        try {
            $foto = $galeri->foto;

            if ($request->hasFile('foto')) {
                if ($foto) Storage::delete("public/$foto");
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $galeri->update([
                'judul' => $request->judul,
                'kategori_galeri_id' => $request->kategori_galeri_id,
                'keterangan' => $request->keterangan,
                'foto' => $foto,
            ]);

            return redirect()->back()->with('success', 'Data galeri berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data galeri gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Galeri $galeri
     * @return RedirectResponse
     */
    public function destroy(Galeri $galeri)
    {
        try {
            if ($galeri->foto) Storage::delete("public/$galeri->foto");
            $galeri->delete();

            return redirect()->back()->with('success', 'Data galeri berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Data galeri gagal dihapus!');
        }
    }
}
