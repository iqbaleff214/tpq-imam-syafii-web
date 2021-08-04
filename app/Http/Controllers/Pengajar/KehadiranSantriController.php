<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\KehadiranSantri;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KehadiranSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        Date::setTranslation(new Indonesian());
        try {
            $data = [
                'santri_id' => $request->input('santri_id'),
                'nilai_adab' => $request->input('nilai_adab'),
                'keterangan' => $request->input('keterangan'),
                'bulan' => Date::today()->format('F o')
            ];

            KehadiranSantri::create($data);

            return redirect()->back()->with('success', 'Berhasil mengisi presensi');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal melakukan presensi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KehadiranSantri  $kehadiranSantri
     * @return \Illuminate\Http\Response
     */
    public function show(KehadiranSantri $kehadiranSantri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KehadiranSantri  $kehadiranSantri
     * @return \Illuminate\Http\Response
     */
    public function edit(KehadiranSantri $kehadiranSantri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\KehadiranSantri  $kehadiranSantri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KehadiranSantri $kehadiranSantri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KehadiranSantri  $kehadiranSantri
     * @return \Illuminate\Http\Response
     */
    public function destroy(KehadiranSantri $kehadiranSantri)
    {
        //
    }
}
