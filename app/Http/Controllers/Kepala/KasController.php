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

            if ($request->get('chart')) {
                $data = [];
                $data['label'] = Kas::selectRaw('DATE_FORMAT(created_at, "%m/%y") as bulan')->orderByRaw('MAX(created_at)')->groupByRaw('DATE_FORMAT(created_at, "%m/%y")')->get();
                $data['data'] = [];

                foreach ($data['label'] as $item) {
                    $data['data'][] = Kas::selectRaw("SUM(pemasukan) as pemasukan, SUM(pengeluaran) as pengeluaran")->whereRaw("DATE_FORMAT(created_at, '%m/%y') = ?", [$item->bulan])->first();
                }
                return response()->json($data);
            }


            $data = Kas::orderBy('created_at', 'asc');
            $jenis = $request->get('jenis');
            $dari = $request->get('dari');
            $sampai = $request->get('sampai');

            if ($dari) {
                $dari = Carbon::createFromFormat('d/m/Y', $dari);
                $data = $data->whereDate('created_at', '>=', $dari);
            }
            if ($sampai) {
                $sampai = Carbon::createFromFormat('d/m/Y', $sampai);
                $data = $data->whereDate('created_at', '<=', $sampai);
            }

            if ($request->get('filter')) {
                $data = $data->selectRaw('SUM(pemasukan) as jml_pemasukan, SUM(pengeluaran) as jml_pengeluaran, DATE_FORMAT(MIN(created_at), "%d-%m-%Y") as min_date, DATE_FORMAT(MAX(created_at), "%d-%m-%Y") as max_date')->first();
                $data->jml_pemasukan = 'Rp' . number_format($data->jml_pemasukan, 2, ',', '.');
                $data->jml_pengeluaran = 'Rp' . number_format($data->jml_pengeluaran, 2, ',', '.');
                return response()->json($data);
            }

            if ($jenis) {
                $data = $data->where($jenis, '>', 0);
            }


            $saldo = 0;
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('saldo', function ($row) {
                    global $saldo;
                    $saldo += ($row->pemasukan - $row->pengeluaran);
                    return "Rp" . number_format($saldo, 2, ',', '.');
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.keuangan.kas.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.keuangan.kas.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.keuangan.kas.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->editColumn('pemasukan', function ($row) {
                    return "Rp" . number_format($row->pemasukan, 2, ',', '.');
                })
                ->editColumn('pengeluaran', function ($row) {
                    return "Rp" . number_format($row->pengeluaran, 2, ',', '.');
                })
                ->rawColumns(['saldo', 'action'])
                ->make(true);
        }

        $total = Kas::selectRaw('SUM(pemasukan) as jml_pemasukan, SUM(pengeluaran) as jml_pengeluaran, (SUM(pemasukan) - SUM(pengeluaran)) as jml_saldo, DATE_FORMAT(MIN(created_at), "%d-%m-%Y") as min_date, DATE_FORMAT(MAX(created_at), "%d-%m-%Y") as max_date')->first();
        $sekarang = Kas::selectRaw('SUM(pemasukan) as pemasukan, SUM(pengeluaran) as pengeluaran')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->first();
        $title = $this->title;
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
