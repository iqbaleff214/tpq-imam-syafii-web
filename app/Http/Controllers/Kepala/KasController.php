<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class KasController extends Controller
{
    private $title = 'Kas';
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
            $saldo = 0;
            return DataTables::of(Kas::orderBy('created_at'))
                ->addColumn('saldo', function($row) {
                    global $saldo;
                    $saldo += ($row->pemasukan - $row->pengeluaran);
                    return "Rp".number_format($saldo, 2, ',', '.');
                })
                ->addColumn('tanggal', function($row){
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('kepala.keuangan.kas.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>';
                })
                ->editColumn('pemasukan', function($row) {
                    return "Rp".number_format($row->pemasukan, 2, ',', '.');
                })
                ->editColumn('pengeluaran', function($row) {
                    return "Rp".number_format($row->pengeluaran, 2, ',', '.');
                })
                ->rawColumns(['saldo', 'action'])
                ->make(true);
        }
        $bulan = Kas::whereMonth('created_at', Carbon::now()->month)->get();
        $title = $this->title;
        $kas = Kas::all();

        $sekarang = [
            'pemasukan' => $bulan->sum('pemasukan'),
            'pengeluaran' => $bulan->sum('pengeluaran'),
        ];
        $total = [
            'pemasukan' => $kas->sum('pemasukan'),
            'pengeluaran' => $kas->sum('pengeluaran'),
            'latest' => Kas::latest()->first(),
            'oldest' => Kas::oldest()->first(),
        ];
        echo view('pages.kepala.kas.index', compact('sekarang', 'total', 'title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Kas $kas)
    {
        $title = $this->title;
        echo view('pages.kepala.kas.show', compact('kas', 'title'));
    }
}
