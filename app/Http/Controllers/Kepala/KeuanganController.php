<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Honor;
use App\Models\Kas;
use App\Models\Pengajar;
use App\Models\Santri;
use App\Models\Spp;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KeuanganController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
    }

    public function kas(Request $request)
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
        $title = 'Kas';
        return view('pages.kepala.keuangan.kas', compact('sekarang', 'total', 'title'));
    }

    public function honor(Request $request)
    {
        if ($request->ajax()) {

            $bulan = $request->get('bulan');
            $pengajar_id = $request->get('pengajar_id');
            $status = $request->get('status');

            $data = Honor::whereNotNull('bulan');

            if ($bulan) {
                $data = $data->where('bulan', $bulan);
            }

            if ($pengajar_id) {
                $data = $data->where('pengajar_id', $pengajar_id);
            }

            if ($status) {
                $data = $data->where('status', $status);
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.keuangan.honor.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.keuangan.honor.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.keuangan.honor.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->editColumn('jumlah', function ($row) {
                    return "Rp" . number_format($row->jumlah, 2, ',', '.');
                })
                ->editColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success">Diterima</span>';
                    } else {
                        return '<span class="badge badge-danger">Menunggu</span>';
                    }
                })
                ->addColumn('pengajar', function ($row) {
                    return $row->pengajar->nama;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $title = 'Honor';
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $pengajar = Pengajar::all();
        $bulan = Honor::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        return view('pages.kepala.keuangan.honor', compact('title', 'bulan', 'pengajar', 'hari'));
    }

    public function donasi(Request $request)
    {
        if ($request->ajax()) {

            $bulan = $request->get('bulan');
            $status = $request->get('status');

            $data = Donasi::where('bulan', $bulan);

            if ($request->get('rekap')) {
                $data = $data->selectRaw('SUM(jumlah) as jumlah, DATE_FORMAT(MIN(created_at), "%d-%m-%Y") as min_date, DATE_FORMAT(MAX(created_at), "%d-%m-%Y") as max_date')->first();
                $data->jumlah = 'Rp'.number_format($data->jumlah, 2,',', '.');
//                $data = $data->first();
                return \response()->json($data);
            }

            if ($status != null) {
                $data = $data->where('status', $status);
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('hijriah', function ($row) {
                    return Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->editColumn('jumlah', function ($row) {
                    return "Rp" . number_format($row->jumlah, 2, ',', '.');
                })
                ->editColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success">Diterima</span>';
                    } else {
                        return '<span class="badge badge-danger">Menunggu</span>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $title = 'Donasi';
        $bulan = Donasi::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        $sekarang = Donasi::where('status', 1)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('jumlah');
        $total = Donasi::selectRaw('SUM(jumlah) as jumlah, DATE_FORMAT(MIN(created_at), "%d-%m-%Y") as min_date, DATE_FORMAT(MAX(created_at), "%d-%m-%Y") as max_date')->where('status', 1)->first();


        return view('pages.kepala.keuangan.donasi', compact('title', 'bulan', 'total', 'sekarang'));
    }

    public function spp(Request $request)
    {
        if ($request->ajax()) {

            $bulan = $request->get('bulan');
            $status = $request->get('status');
            $santri_id = $request->get('santri_id');

            $data = Spp::where('bulan', $bulan);

            if ($status != null) {
                $data = $data->where('status', $status);
            }
            if ($santri_id) {
                $data = $data->where('santri_id', $santri_id);
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $col = '<a href="' . route('admin.spp.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.spp.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.spp.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                    if ($row->status == 1) {
                        $col .= '<form class="d-inline" method="POST" action="' . route('admin.spp.update', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <input type="hidden" name="status" value="2">
                                    <input type="hidden" name="jumlah" value="' . $row->jumlah . '">
                                    <button type="submit" class="btn bg-maroon btn-xs px-2 mx-1 confirm-data"> Terima </button>
                                </form>';
                    }
                    return $col;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('hijriah', function ($row) {
                    return Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->editColumn('jumlah', function ($row) {
                    return "Rp" . number_format($row->jumlah, 2, ',', '.');
                })
                ->editColumn('status', function ($row) {
                    switch ($row->status) {
                        case 0:
                            return '<span class="badge badge-info">Ditagih</span>';
                        case 1:
                            return '<span class="badge badge-primary">Dibayar</span>';
                        case 2:
                            return '<span class="badge badge-success">Diterima</span>';
                    }
                    return false;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $title = 'SPP';
        $bulan = Spp::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();
        $santri = Santri::where('status', 'Aktif')->get();

        return view('pages.kepala.keuangan.spp', compact('title', 'bulan', 'santri'));
    }
}
