<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;

class DonasiController extends Controller
{
    private $title = 'Donasi';

    public function __construct()
    {
        parent::__construct();
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
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
                ->addColumn('action', function ($row) {
                    $col = '<a href="' . route('admin.keuangan.donasi.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.keuangan.donasi.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.keuangan.donasi.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                    if ($row->status == 0) {
                        $col .= '<form class="d-inline" method="POST" action="' . route('admin.keuangan.donasi.update', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <input type="hidden" name="status" value="1">
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

        $title = $this->title;
        $bulan = Donasi::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        $sekarang = Donasi::where('status', 1)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('jumlah');
        $total = Donasi::selectRaw('SUM(jumlah) as jumlah, DATE_FORMAT(MIN(created_at), "%d-%m-%Y") as min_date, DATE_FORMAT(MAX(created_at), "%d-%m-%Y") as max_date')->where('status', 1)->first();


        echo view('pages.admin.donasi.index', compact('title', 'bulan', 'total', 'sekarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;

        echo view('pages.admin.donasi.create', compact('title'));
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
            'nama' => 'required',
            'no_telp' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        try {
            Donasi::create([
                'nama' => $request->input('nama'),
                'no_telp' => $request->input('no_telp'),
                'jumlah' => $request->input('jumlah'),
                'keterangan' => $request->input('keterangan'),
                'bulan' => Hijri::convertToHijri(Carbon::today())->format('F o'),
                'status' => 1
            ]);
            return redirect()->route('admin.keuangan.donasi.index')->with('success', 'Data donasi berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data donasi gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Donasi $donasi
     * @return Response
     */
    public function show(Donasi $donasi)
    {
        $title = $this->title;
        echo view('pages.admin.donasi.show', compact('title', 'donasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Donasi $donasi
     * @return Response
     */
    public function edit(Donasi $donasi)
    {
        $title = $this->title;
        echo view('pages.admin.donasi.edit', compact('title', 'donasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Donasi $donasi
     * @return RedirectResponse
     */
    public function update(Request $request, Donasi $donasi)
    {
        $request->validate([
            'nama' => Rule::requiredIf($request->status == null),
            'no_telp' => Rule::requiredIf($request->status == null),
            'jumlah' => [Rule::requiredIf($request->status == null), 'numeric', 'nullable'],
        ]);

        try {
            if ($request->input('status')) {
                $donasi->update(['status' => 1]);
            } else {
                $donasi->update([
                    'nama' => $request->input('nama'),
                    'no_telp' => $request->input('no_telp'),
                    'keterangan' => $request->input('keterangan'),
                ]);
            }

            return redirect()->back()->with('success', 'Data donasi berhasil diedit!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data donasi gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Donasi $donasi
     * @return RedirectResponse
     */
    public function destroy(Donasi $donasi)
    {
        try {
            $donasi->delete();
            return redirect()->back()->with('success', 'Data donasi berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data donasi gagal dihapus!');
        }
    }
}
