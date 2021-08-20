<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KehadiranSantri;
use App\Models\Santri;
use App\Models\Spp;
use Carbon\Carbon;
use Exception;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SppController extends Controller
{
    private $title = 'Pembayaran';

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
     * @throws Exception
     */
    public function index(Request $request)
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

        $title = $this->title;
        $bulan = Spp::selectRaw('bulan, MAX(created_at) as max, MIN(created_at) as min')->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();
        $santri = Santri::where('status', 'Aktif')->get();

        return view('pages.admin.spp.index', compact('title', 'bulan', 'santri'));
    }

    public function collect(): RedirectResponse
    {
        try {
            $santri = Santri::where('status', 'Aktif')->get();
            foreach ($santri as $item) {
                $item->spp()->create([
                    'bulan' => Date::today()->format('F o'),
                    'jumlah' => $item->sppOpsi->jumlah,
                    'status' => 0,
                    'keterangan' => 'SPP a.n. ' . $item->nama_lengkap . ' bulan ' . Date::today()->format('F o'),
                ]);
            }
            return redirect()->back()->with('success', 'Berhasil menagih SPP!');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        $santri = Santri::where('status', 'Aktif')->get();
        $bulan = KehadiranSantri::select('bulan')->groupBy('bulan')->get();

        return view('pages.admin.spp.create', compact('title', 'santri', 'bulan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'santri_id' => 'required',
            'bulan' => 'required',
            'jumlah' => 'required|numeric',
            'status' => 'required'
        ]);
        try {
            if (Spp::where('santri_id', $request->santri_id)->where('bulan', $request->bulan)->first()) {
                return redirect()->back()->with('error', 'SPP sudah dibayarkan/ditagih!');
            }

            Spp::create([
                'bulan' => $request->bulan,
                'santri_id' => $request->santri_id,
                'jumlah' => $request->jumlah,
                'status' => $request->status,
            ]);
            return redirect()->route('admin.spp.index')->with('success', 'Data spp berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data spp gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Spp $spp
     * @return void
     */
    public function show(Spp $spp)
    {
        $title = $this->title;

        return view('pages.admin.spp.show', compact('title', 'spp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Spp $spp
     * @return void
     */
    public function edit(Spp $spp)
    {
        $title = $this->title;
        $santri = Santri::where('status', 'Aktif')->get();
        $bulan = KehadiranSantri::select('bulan')->groupBy('bulan')->get();

        return view('pages.admin.spp.edit', compact('title', 'santri', 'bulan', 'spp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Spp $spp
     * @return RedirectResponse
     */
    public function update(Request $request, Spp $spp): RedirectResponse
    {
        $request->validate([
            'jumlah' => 'required|numeric',
        ]);
        try {
            $data = [
                'jumlah' => $request->jumlah,
            ];

            if ($request->status) {
                $data['status'] = $request->status;
            }

            $spp->update($data);
            return redirect()->back()->with('success', 'Data spp berhasil diedit!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data spp gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Spp $spp
     * @return RedirectResponse
     */
    public function destroy(Spp $spp): RedirectResponse
    {
        try {
            if ($spp->bukti) Storage::delete("public/$spp->bukti");
            $spp->update(['bukti' => null]);
            $spp->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus SPP!');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
