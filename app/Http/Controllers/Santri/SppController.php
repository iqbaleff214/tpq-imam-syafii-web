<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Spp;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SppController extends Controller
{
    private $title = 'SPP';

    /**
     * Display a listing of the resource.
     *
     * @return void
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->get('status');
            $data = Spp::where('santri_id', Auth::user()->santri->id);
            if ($status != null) {
                $data = $data->where('status', $status);
            }
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($status) {
                    if ($status != null) {
                        return '<a href="'.route('santri.spp.edit', $row).'" class="btn bg-maroon btn-xs px-2"> Konfirmasi </a>';
                    } else {
                        $button = '<a href="'.route('santri.spp.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>';
                        if ($row->status == 0) {
                            $button .= '<a href="'.route('santri.spp.edit', $row).'" class="btn bg-maroon btn-xs mx-2 px-2"> Konfirmasi </a>';
                        }
                        return $button;
                    }
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->editColumn('jumlah', function($row) {
                    return "Rp".number_format($row->jumlah, 2, ',', '.');
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
        return view('pages.santri.spp.index', compact('title'));
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

        return view('pages.santri.spp.show', compact('spp', 'title'));
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

        return view('pages.santri.spp.edit', compact('spp', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Spp $spp
     * @return RedirectResponse
     */
    public function update(Request $request, Spp $spp)
    {
        $request->validate([
            'jumlah' => 'required|numeric',
            'foto' => 'image|max:2048'
        ]);
        try {
            $foto = null;
            if ($request->hasFile('foto')) {
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }
            $spp->update([
                'status' => 1,
                'bukti' => $foto
            ]);
            return redirect()->route('santri.spp.index')->with('success', 'Berhasil mengonfirmasi spp');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal mengonfirmasi spp');
        }
    }
}
