<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Honor;
use App\Models\KehadiranPengajar;
use App\Models\Pengajar;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class HonorController extends Controller
{
    private $title = "Honor";

    public function __construct()
    {
        parent::__construct();
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
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

        $title = $this->title;
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $pengajar = Pengajar::all();
        $bulan = Honor::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        echo view('pages.admin.honor.index', compact('title', 'bulan', 'pengajar', 'hari'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        $pengajar = Pengajar::all();
        $bulan = KehadiranPengajar::select('bulan')->groupBy('bulan')->get();

        echo view('pages.admin.honor.create', compact('title', 'pengajar', 'bulan'));
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
            'pengajar_id' => 'required',
            'bulan' => 'required',
            'jumlah' => 'required|numeric',
        ]);
        try {
            if (Honor::where('pengajar_id', $request->pengajar_id)->where('bulan', $request->bulan)->first()) {
                return redirect()->route('admin.keuangan.honor.index')->with('error', 'Data honor sudah dibayarkan!');
            }

            Honor::create([
                'bulan' => $request->bulan,
                'pengajar_id' => $request->pengajar_id,
                'jumlah' => $request->jumlah,
                'status' => 0,
            ]);
            return redirect()->route('admin.keuangan.honor.index')->with('success', 'Data honor berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data honor gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Honor $honor
     * @return Response
     */
    public function show(Honor $honor)
    {
        $title = $this->title;
        echo view('pages.admin.honor.show', compact('title', 'honor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Honor $honor
     * @return Response
     */
    public function edit(Honor $honor)
    {
        $title = $this->title;
        echo view('pages.admin.honor.edit', compact('title', 'honor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Honor $honor
     * @return RedirectResponse
     */
    public function update(Request $request, Honor $honor)
    {
        $request->validate([
            'jumlah' => 'required|numeric'
        ]);
        try {
            $honor->update([
                'jumlah' => $request->input('jumlah')
            ]);

            return redirect()->back()->with('success', 'Data honor berhasil diedit!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data honor gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Honor $honor
     * @return RedirectResponse
     */
    public function destroy(Honor $honor)
    {
        try {
            $honor->delete();
            return redirect()->back()->with('success', 'Data honor berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data honor gagal dihapus!');
        }
    }
}
