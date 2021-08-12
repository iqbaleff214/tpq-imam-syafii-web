<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\KehadiranSantri;
use App\Models\Santri;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;

class KehadiranSantriController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $bulan = $request->input('bulan');
        $sekarang = $request->input('sekarang');
        $santri_id = $request->input('santri_id');
        $keterangan = $request->input('keterangan');

        if (!$santri_id) {
            return ResponseFormatter::error(null, 'Tidak ada santri yang dipilih!', 404);
        }

        $data = KehadiranSantri::where('santri_id', $santri_id);

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                return ResponseFormatter::success($data, 'Data kehadiran santri berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data kehadiran santri tidak ditemukan!', 404);
            }
        }

        if ($sekarang) {
            $data = $data->whereDate('created_at', Carbon::today())->first();
            if ($data) {
                return ResponseFormatter::success($data, 'Data kehadiran hari ini berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data kehadiran hari ini tidak ditemukan!', 404);
            }
        }

        if ($keterangan) {
            $data = $data->where('keterangan', $keterangan);
        }

        if ($bulan) {
            $data = $data->where('bulan', $bulan);
        }

        if ($data->count()) {
            return ResponseFormatter::success($data->paginate($limit), 'Data kehadiran berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data kehadiran tidak ditemukan!', 404);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Pengajar',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data kehadiran!', 500);
        }
        try {
            $santri_id = $request->santri_id;
            if (!$santri_id) {
                return ResponseFormatter::error(null, 'Tidak ada santri yang dipilih!', 404);
            }

            $presensi = KehadiranSantri::where('santri_id', $santri_id);
            if ($presensi->whereDate('created_at', Carbon::today())->count()) {
                return ResponseFormatter::error(null, 'Sudah mengisi kehadiran!', 500);
            }

            if (!$request->keterangan) {
                return ResponseFormatter::error(null, 'Keterangan kehadiran tidak diisi!', 500);
            }

            Hijri::setDefaultAdjustment(-1);
            Date::setTranslation(new Indonesian());

            $data = KehadiranSantri::create([
                'santri_id' => $santri_id,
                'keterangan' => ucfirst(strtolower($request->keterangan)),
                'catatan' => $request->catatan,
                'bulan' => Date::today()->format('F o'),
                'nilai_adab' => strtolower($request->keterangan) == 'hadir' ? $request->nilai_adab : null,
            ]);

            return ResponseFormatter::success($data, 'Berhasil mengisi kehadiran!');
        } catch (\Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal mengisi kehadiran!', 500);
        }
    }

    public function month(Request $request)
    {
        $santri_id = $request->input('santri_id');
        $data = KehadiranSantri::select('bulan')->groupBy('bulan');
        if ($santri_id) {
            $data = $data->where('santri_id', $santri_id);
        }
        if ($data->count()) {
            return ResponseFormatter::success($data->get(), 'Data bulan kehadiran santri berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data bulan kehadiran santri tidak ditemukan!', 404);
        }
    }
}
