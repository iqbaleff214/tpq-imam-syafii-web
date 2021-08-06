<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\Pembelajaran;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PembelajaranController extends Controller
{
    public function store(Request $request)
    {
        Date::setTranslation(new Indonesian());
        try {
            $data = [
                'santri_id' => $request->input('santri_id'),
                'nilai' => $request->input('nilai'),
                'keterangan' => $request->input('keterangan'),
                'bulan' => Date::today()->format('F o')
            ];

            Pembelajaran::create($data);

            return redirect()->back()->with('success', 'Berhasil mengisi catatan pembelajaran');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal melakukan catatan pembelajaran');
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
                    return \Alkoumi\LaravelHijriDate\Hijri::Date('d-m-Y', $row->created_at);
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
