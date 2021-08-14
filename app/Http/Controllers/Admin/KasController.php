<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class KasController extends Controller
{
    private $title = 'Kas';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $saldo = 0;
            $data = Kas::orderBy('created_at', 'asc');
            $jenis = $request->get('jenis');
            $dari = $request->get('dari');
            $sampai = $request->get('sampai');

            if ($jenis) {
                $data = $data->where($jenis, '>', 0);
            }

            if ($dari) {
                $dari = Carbon::createFromFormat('d/m/Y', $dari);
                $data = $data->whereDate('created_at', '>=', $dari);
            }
            if ($sampai) {
                $sampai = Carbon::createFromFormat('d/m/Y', $sampai);
                $data = $data->whereDate('created_at', '<=', $sampai);
            }

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
        $bulan = Kas::whereMonth('created_at', Carbon::now()->month)->get();
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
        $title = $this->title;
        echo view('pages.admin.kas.index', compact('sekarang', 'total', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        echo view('pages.admin.kas.create', ['title' => $this->title]);
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
            'uraian' => 'required',
            'nominal' => 'numeric|required',
            'foto' => 'image|max:2048'
        ]);

        try {
            $foto = null;
            if ($request->hasFile('foto')) {
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $data = [
                'uraian' => $request->uraian,
                'keterangan' => $request->keterangan,
                'bukti' => $foto,
                strtolower($request->jenis) => $request->nominal,
            ];

            Kas::create($data);
            return redirect()->route('admin.keuangan.kas.index')->with('success', 'Data kas berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data kas gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Kas $kas
     * @return Response
     */
    public function show($id)
    {
        $kas = Kas::findOrFail($id);
        $title = $this->title;
        echo view('pages.admin.kas.show', compact('kas', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $kas = Kas::findOrFail($id);
        $title = $this->title;
        echo view('pages.admin.kas.edit', compact('kas', 'title'));
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
        $request->validate([
            'uraian' => 'required',
            'nominal' => 'numeric|required',
            'foto' => 'image|max:2048'
        ]);

        try {
            $kas = Kas::findOrFail($id);
            $foto = $kas->bukti;
            if ($request->hasFile('foto')) {

                if ($foto) Storage::delete("public/$foto");

                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $data = [
                'uraian' => $request->uraian,
                'keterangan' => $request->keterangan,
                'bukti' => $foto,
                $kas->pemasukan ? 'pemasukan' : 'pengeluaran' => $request->nominal
            ];

            $kas->update($data);

            return redirect()->back()->with('success', 'Data kas berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data kas gagal diedit!');
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
        $kas = Kas::findOrFail($id);
        try {
            if ($kas->bukti) Storage::delete("public/$kas->bukti");
            $kas->update(['bukti' => null]);
            $kas->delete();

            return redirect()->back()->with('success', 'Data kas berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Data kas gagal dihapus!');
        }
    }
    public function unlink($id)
    {
        try {
            $kas = Kas::findOrFail($id);
            if ($kas->bukti) Storage::delete("public/$kas->bukti");
            $kas->update(['bukti' => null]);

            return redirect()->back()->with('success', 'Bukti kas berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Bukti kas gagal dihapus!');
        }
    }
}
