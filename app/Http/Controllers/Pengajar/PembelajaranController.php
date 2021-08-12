<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\Pembelajaran;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PembelajaranController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'santri_id' => $request->input('santri_id'),
                'bacaan' => $request->input('bacaan'),
                'nilai' => $request->input('nilai'),
                'mulai' => $request->input('mulai'),
                'selesai' => $request->input('selesai') ?? $request->input('mulai'),
                'keterangan' => $request->input('keterangan'),
                'bulan' => Date::today()->format('F o'),
                'pengajar_id' => Auth::user()->pengajar->id,
            ];

            Pembelajaran::create($data);

            return redirect()->back()->with('success', 'Berhasil mengisi evaluasi pembelajaran');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal melakukan evaluasi pembelajaran');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $bulan = $request->get('bulan');
            $data = Pembelajaran::where('bulan', $bulan)->where('santri_id', $id);
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('hari', function ($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function ($row) {
                    return Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('ayat', function ($row) {
                    if ($row->mulai == $row->selesai)
                        return $row->bacaan . ': ' . $row->mulai;
                    else
                        return $row->bacaan . ': ' . $row->mulai . '-' . $row->selesai;
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->make(true);
        }
    }

}
