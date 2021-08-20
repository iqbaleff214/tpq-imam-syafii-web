<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PengumumanController extends Controller
{
    private $title = 'Pengumuman';

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
            return DataTables::of(Pengumuman::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.pengumuman.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.pengumuman.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.pengumuman.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->addColumn('penulis', function ($row) {
                    return $row->penulis->nama;
                })
                ->editColumn('konten', function ($row) {
                    return Str::limit(strip_tags($row->konten), 155) . '...';
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->rawColumns(['action', 'penulis', 'tanggal'])
                ->make(true);
        }

        return view('pages.admin.pengumuman.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.admin.pengumuman.create', ['title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'foto' => 'image|max:2048'
        ]);

        try {
            $foto = null;

            if ($request->hasFile('foto')) {
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            Pengumuman::create([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'konten' => $request->konten,
                'foto' => $foto,
                'admin_id' => Auth::user()->administrator->id
            ]);

            return redirect()->route('admin.pengumuman.index')->with('success', 'Data pengumuman berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data pengumuman gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Pengumuman $pengumuman
     * @return Response
     */
    public function show(Pengumuman $pengumuman)
    {
        $title = $this->title;
        return view('pages.admin.pengumuman.show', compact('pengumuman', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Pengumuman $pengumuman
     * @return Response
     */
    public function edit(Pengumuman $pengumuman)
    {
        $title = $this->title;
        return view('pages.admin.pengumuman.edit', compact('pengumuman', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Pengumuman $pengumuman
     * @return Response
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'foto' => 'image|max:2048'
        ]);

        try {
            $foto = $pengumuman->foto;

            if ($request->hasFile('foto')) {
                if ($foto) Storage::delete("public/$foto");
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $pengumuman->update([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'konten' => $request->konten,
                'foto' => $foto,
            ]);

            return redirect()->back()->with('success', 'Data pengumuman berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data pengumuman gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pengumuman $pengumuman
     * @return RedirectResponse
     */
    public function destroy(Pengumuman $pengumuman)
    {
        try {
            if ($pengumuman->foto) Storage::delete("public/$pengumuman->foto");
            $pengumuman->update(['foto' => null]);
            $pengumuman->delete();

            return redirect()->back()->with('success', 'Data pengumuman berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Data pengumuman gagal dihapus!');
        }
    }
}
