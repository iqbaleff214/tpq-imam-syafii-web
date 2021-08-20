<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Icon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class FasilitasController extends Controller
{
    private $title = 'Fasilitas';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Fasilitas::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.fasilitas.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.fasilitas.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.fasilitas.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->editColumn('icon', function ($row) {
                    return '<h1 class="text-center"><i class="' . $row->icon . '"></i></h1>';
                })
                ->rawColumns(['action', 'icon'])
                ->make(true);
        }

        return view('pages.admin.fasilitas.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        $icon = Icon::all();
        return view('pages.admin.fasilitas.create', compact('title', 'icon'));
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
            'fasilitas' => 'required',
            'icon' => 'required',
        ]);

        try {
            Fasilitas::create([
                'fasilitas' => $request->fasilitas,
                'icon' => $request->icon,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('admin.fasilitas.index')->with('success', 'Data fasilitas berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data fasilitas gagal ditambahkan!');
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
        $fasilitas = Fasilitas::findOrFail($id);
        $title = $this->title;
        return view('pages.admin.fasilitas.show', compact('title', 'fasilitas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $title = $this->title;
        $icon = Icon::all();
        return view('pages.admin.fasilitas.edit', compact('title', 'icon', 'fasilitas'));
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
        $fasilitas = Fasilitas::findOrFail($id);
        $request->validate([
            'fasilitas' => 'required',
            'icon' => 'required',
        ]);

        try {
            $fasilitas->update([
                'fasilitas' => $request->fasilitas,
                'icon' => $request->icon,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->back()->with('success', 'Data fasilitas berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data fasilitas gagal diedit!');
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
            Fasilitas::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Data fasilitas berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data fasilitas gagal dihapus!');
        }
    }
}
