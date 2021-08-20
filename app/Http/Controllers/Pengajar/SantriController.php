<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPengajar;
use App\Models\KehadiranSantri;
use App\Models\Materi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SantriController extends Controller
{
    private $title = 'Santri';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = $this->title;
        $kelas = Auth::user()->pengajar->kelas ?? null;
        if (!$kelas) return redirect()->route('pengajar.dashboard');
        $santri = Santri::where('kelas_id', $kelas->id)->where('status', 'Aktif')->get();
        return view('pages.pengajar.santri.index', compact('title', 'kelas', 'santri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Santri $santri
     * @return Response
     */
    public function show(Santri $santri)
    {
        $title = $this->title;
        $bulan = KehadiranSantri::selectRaw('bulan')->where('santri_id', $santri->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();

        # Mengecek hari libur
        $ngaji = KehadiranPengajar::where('pengajar_id', Auth::user()->pengajar->id)->whereDate('created_at', Carbon::today())->where('keterangan', 'Hadir')->count();

        # Bacaan
        $bacaan = Materi::whereIn('jenis', ['QURAN', 'IQRO'])->get();
        $hafalan = Materi::where('jenis', '!=', 'IQRO')->get();

        $hadir = $santri->kehadiran()->whereDate('created_at', \Carbon\Carbon::today())->first();
        $terisi = $hadir;
        if ($hadir) {
            $hadir = $hadir->keterangan == 'Hadir';
        }

        return view('pages.pengajar.santri.show', compact('title', 'santri', 'bulan', 'ngaji', 'bacaan', 'hafalan', 'hadir', 'terisi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Santri $santri
     * @return Response
     */
    public function edit(Santri $santri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Santri $santri
     * @return Response
     */
    public function update(Request $request, Santri $santri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Santri $santri
     * @return Response
     */
    public function destroy(Santri $santri)
    {
        //
    }
}
