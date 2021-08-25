<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Hafalan;
use App\Models\Materi;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;

class HafalanController extends Controller
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

        $data = Hafalan::where('santri_id', $santri_id)->with(['hafalan']);

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                return ResponseFormatter::success($data, 'Data hafalan santri berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data hafalan santri tidak ditemukan!', 404);
            }
        }

        if ($sekarang) {
            $data = $data->whereDate('created_at', Carbon::today())->first();
            if ($data) {
                return ResponseFormatter::success($data, 'Data hafalan hari ini berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data hafalan hari ini tidak ditemukan!', 404);
            }
        }

        if ($terakhir) {
            $data = $data->orderBy('created_at', 'desc')->first();
            if ($data) {
                return ResponseFormatter::success($data, 'Data hafalan terakhir berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data hafalan terakhir tidak ditemukan!', 404);
            }
        }

//        if ($q) {
//            $data = $data->where('hafalan', 'like', "%{$q}%");
//        }

        if ($keterangan) {
            $data = $data->where('keterangan', $keterangan);
        }

        if ($bulan) {
            $data = $data->where('bulan', $bulan);
        }

        if ($data->count()) {
            return ResponseFormatter::success($data->paginate($limit), 'Data hafalan berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data hafalan tidak ditemukan!', 404);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Pengajar',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data hafalan!', 500);
        }
        try {
            $santri_id = $request->santri_id;
            if (!$santri_id) {
                return ResponseFormatter::error(null, 'Tidak ada santri yang dipilih!', 404);
            }

            $presensi = Hafalan::where('santri_id', $santri_id);
            if ($presensi->whereDate('created_at', Carbon::today())->count()) {
                return ResponseFormatter::error(null, 'Sudah mengisi hafalan!', 500);
            }

            if (!$request->keterangan) {
                return ResponseFormatter::error(null, 'Keterangan hafalan tidak diisi!', 500);
            }

            if (!$request->materi_id) {
                return ResponseFormatter::error(null, 'Materi hafalan tidak diisi!', 500);
            }

            Hijri::setDefaultAdjustment(-1);
            Date::setTranslation(new Indonesian());

            $data = Hafalan::create([
                'santri_id' => $santri_id,
                'pengajar_id' => $user->pengajar->id,
                'keterangan' => ucfirst(strtolower($request->keterangan)),
                'bulan' => Date::today()->format('F o'),
                'materi_id' => $request->materi_id,
                'nilai' => $request->nilai,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai ?? $request->mulai,
            ]);

            return ResponseFormatter::success($data, 'Berhasil mengisi hafalan!');
        } catch (\Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal mengisi hafalan!', 500);
        }
    }

    public function month(Request $request)
    {
        $santri_id = $request->input('santri_id');
        $data = Hafalan::select('bulan')->groupBy('bulan');
        if ($santri_id) {
            $data = $data->where('santri_id', $santri_id);
        }
        if ($data->count()) {
            return ResponseFormatter::success($data->get(), 'Data bulan hafalan santri berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data bulan hafalan santri tidak ditemukan!', 404);
        }
    }

    public function materials(Request $request)
    {
        $jenis = $request->input('jenis');

        $data = Materi::where('jenis', '<>', 'IQRO');

        if ($jenis) {
            $data = $data->where('jenis', strtoupper($jenis));
        }

        if ($data->count()) {
            return ResponseFormatter::success($data->get(), 'Data materi hafalan santri berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data materi hafalan santri tidak ditemukan!', 404);
        }
    }
}
