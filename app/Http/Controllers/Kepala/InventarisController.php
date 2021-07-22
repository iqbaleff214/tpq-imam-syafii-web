<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InventarisController extends Controller
{
    private $title = 'Inventaris Barang';
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Inventaris::all())
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<a href="'.route('kepala.inventaris.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>';
                })
                ->addColumn('total', function($row) {
                    return $row->jumlah_baik + $row->jumlah_rusak;
                })
                ->rawColumns(['action', 'total'])
                ->make(true);
        }

        echo view('pages.kepala.inventaris.index', ['title' => $this->title]);
    }

    public function show(Inventaris $inventaris)
    {
//        $inventaris = Inventaris::find($id);
        $title = $this->title;
        echo view('pages.kepala.inventaris.show', compact('inventaris', 'title'));
    }
}
