<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\KehadiranSantri;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SantriController extends Controller
{
    private $title = 'Santri';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $kelas = Auth::user()->pengajar->kelas ?? null;
        if (!$kelas) return redirect()->route('pengajar.dashboard');
        $santri = Santri::where('kelas_id', $kelas->id)->where('status', 'Aktif')->get();
        echo view('pages.pengajar.santri.index', compact('title', 'kelas', 'santri'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Santri $santri)
    {
        $title = $this->title;
        $bulan = KehadiranSantri::selectRaw('bulan')->where('santri_id', $santri->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        # Mengecek hari libur
        $libur = [Carbon::FRIDAY, Carbon::SATURDAY, Carbon::SUNDAY];
        $ngaji = !in_array(Carbon::today()->dayOfWeek, $libur);

        # Bacaan
        $bacaan = Materi::whereIn('jenis', ['QURAN', 'IQRO'])->get();

        echo view('pages.pengajar.santri.show', compact('title', 'santri', 'bulan', 'ngaji', 'bacaan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Http\Response
     */
    public function edit(Santri $santri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Santri $santri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Http\Response
     */
    public function destroy(Santri $santri)
    {
        //
    }
}
