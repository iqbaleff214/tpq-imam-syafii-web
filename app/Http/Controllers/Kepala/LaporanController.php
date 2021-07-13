<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanController extends Controller
{
    public function kas(Request $request)
    {
        if ($request->ajax()) {
            $saldo = 0;
            return DataTables::of(Kas::all())
                ->addIndexColumn()
                ->addColumn('saldo', function($row) use ($saldo) {
                    $saldo += ($row->pemasukan - $row->pengeluaran);
                    return "Rp".number_format($saldo, 2, ',', '.');
                })
                ->addColumn('tanggal', function($row){
                    return date('d/m/Y', strtotime($row->created_at));
                })
                ->editColumn('pemasukan', function($row) {
                    return "Rp".number_format($row->pemasukan, 2, ',', '.');
                })
                ->editColumn('pengeluaran', function($row) {
                    return "Rp".number_format($row->pengeluaran, 2, ',', '.');
                })
                ->rawColumns(['saldo'])
                ->make(true);
        }

        echo view('pages.kepala.laporan.kas');
    }

    public function honor(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Honor::all())
                ->addIndexColumn()
                ->addColumn('tanggal', function($row){
                    return date('d/m/Y', strtotime($row->created_at));
                })
                ->addColumn('pengajar', function($row){
                    return $row->pengajar->nama;
                })
                ->editColumn('jumlah', function($row) {
                    return "Rp".number_format($row->jumlah, 2, ',', '.');
                })
                ->rawColumns(['pengajar'])
                ->make(true);
        }

        echo view('pages.kepala.laporan.honor');
    }

    public function spp(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Honor::all())
                ->addIndexColumn()
                ->addColumn('tanggal', function($row){
                    return date('d/m/Y', strtotime($row->created_at));
                })
                ->addColumn('pengajar', function($row){
                    return $row->pengajar->nama;
                })
                ->editColumn('jumlah', function($row) {
                    return "Rp".number_format($row->jumlah, 2, ',', '.');
                })
                ->rawColumns(['pengajar'])
                ->make(true);
        }

        echo view('pages.kepala.laporan.honor');
    }

    public function inventaris(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Inventaris::all())
                ->addIndexColumn()
                ->addColumn('tanggal', function($row){
//                    return date('d/m/Y', strtotime($row->created_at));
                })
                ->addColumn('pengajar', function($row){
                    return $row->pengajar->nama;
                })
                ->editColumn('jumlah', function($row) {
                    return "Rp".number_format($row->jumlah, 2, ',', '.');
                })
                ->rawColumns(['pengajar'])
                ->make(true);
        }

        echo view('pages.kepala.laporan.honor');
    }
}
