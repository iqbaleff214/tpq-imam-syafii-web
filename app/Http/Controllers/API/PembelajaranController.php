<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Pembelajaran;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;

class PembelajaranController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $q = $request->input('q');
        $id = $request->input('id');
        $limit = $request->input('limit');
        $bulan = $request->input('bulan');
        $sekarang = $request->input('sekarang');
        $terakhir = $request->input('terakhir');
        $santri_id = $request->input('santri_id');
        $keterangan = $request->input('keterangan');

        if (!$santri_id) {
            return ResponseFormatter::error(null, 'Tidak ada santri yang dipilih!', 404);
        }

        $data = Pembelajaran::where('santri_id', $santri_id)->with(['bacaan']);

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                return ResponseFormatter::success($data, 'Data pembelajaran santri berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data pembelajaran santri tidak ditemukan!', 404);
            }
        }

        if ($sekarang) {
            $data = $data->whereDate('created_at', Carbon::today())->first();
            if ($data) {
                return ResponseFormatter::success($data, 'Data pembelajaran hari ini berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data pembelajaran hari ini tidak ditemukan!', 404);
            }
        }

        if ($terakhir) {
            $data = $data->orderBy('created_at', 'desc')->first();
            if ($data) {
                return ResponseFormatter::success($data, 'Data pembelajaran terakhir berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data pembelajaran terakhir tidak ditemukan!', 404);
            }
        }

//        if ($q) {
//            $data = $data->where('bacaan', 'like', "%{$q}%");
//        }

        if ($keterangan) {
            $data = $data->where('keterangan', $keterangan);
        }

        if ($bulan) {
            $data = $data->where('bulan', $bulan);
        }

        if ($data->count()) {
            return ResponseFormatter::success($data->paginate($limit), 'Data pembelajaran berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data pembelajaran tidak ditemukan!', 404);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Pengajar',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data pembelajaran!', 500);
        }
        try {
            $santri_id = $request->santri_id;
            if (!$santri_id) {
                return ResponseFormatter::error(null, 'Tidak ada santri yang dipilih!', 404);
            }

            $presensi = Pembelajaran::where('santri_id', $santri_id);
            if ($presensi->whereDate('created_at', Carbon::today())->count()) {
                return ResponseFormatter::error(null, 'Sudah mengisi pembelajaran!', 500);
            }

            if (!$request->keterangan) {
                return ResponseFormatter::error(null, 'Keterangan pembelajaran tidak diisi!', 500);
            }

            if (!$request->bacaan) {
                return ResponseFormatter::error(null, 'Materi pembelajaran tidak diisi!', 500);
            }

            if (!$request->mulai) {
                return ResponseFormatter::error(null, 'Halaman atau ayat tidak diisi!', 500);
            }

            Hijri::setDefaultAdjustment(-1);
            Date::setTranslation(new Indonesian());

            $data = Pembelajaran::create([
                'santri_id' => $santri_id,
                'pengajar_id' => $user->pengajar->id,
                'keterangan' => ucfirst(strtolower($request->keterangan)),
                'bulan' => Date::today()->format('F o'),
                'bacaan' => $request->bacaan,
                'nilai' => $request->nilai,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai ?? $request->mulai,
            ]);

            return ResponseFormatter::success($data, 'Berhasil mengisi pembelajaran!');
        } catch (\Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal mengisi pembelajaran!', 500);
        }
    }

    public function month(Request $request)
    {
        $santri_id = $request->input('santri_id');
        $data = Pembelajaran::select('bulan')->groupBy('bulan');
        if ($santri_id) {
            $data = $data->where('santri_id', $santri_id);
        }
        if ($data->count()) {
            return ResponseFormatter::success($data->get(), 'Data bulan pembelajaran santri berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data bulan pembelajaran santri tidak ditemukan!', 404);
        }
    }

    public function materials(Request $request)
    {
        $jenis = $request->input('jenis');

        $data = Materi::whereIn('jenis', ['QURAN', 'IQRO']);

        if ($jenis) {
            $data = $data->where('jenis', strtoupper($jenis));
        }

        if ($data->count()) {
            return ResponseFormatter::success($data->get(), 'Data materi pembelajaran santri berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data materi pembelajaran santri tidak ditemukan!', 404);
        }
    }
}
