<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class KontakController extends Controller
{
    private $title = 'Pesan';
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Kontak::all())
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.pesan.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <form class="d-inline" method="POST" action="' . route('admin.pesan.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->dibaca) {
                        return '<span class="badge badge-success">Sudah Dibaca</span>';
                    } else {
                        return '<span class="badge badge-primary">Belum Dibaca</span>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $title = $this->title;
        return view('pages.admin.kontak.index', compact('title'));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $kontak = Kontak::findOrFail($id);
        if ($kontak->dibaca == 0) $kontak->update(['dibaca' => 1]);
        $title = $this->title;
        return view('pages.admin.kontak.show', compact('title', 'kontak'));
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
            Kontak::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Pesan berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Pesan gagal dihapus!');
        }
    }
}
