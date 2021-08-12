<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\KehadiranPengajar;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;

class KehadiranPengajarController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $user = $request->user();
        if (!$this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Pengajar',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data kehadiran!', 500);
        }

        $id = $request->input('id');
        $limit = $request->input('limit');
        $sekarang = $request->input('sekarang');
        $keterangan = $request->input('keterangan');
        $bulan = $request->input('bulan');

        $data = $user->pengajar->kehadiran();

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                return ResponseFormatter::success($data, 'Data kehadiran berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data kehadiran tidak ditemukan!', 404);
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
            return ResponseFormatter::success(
                $data->paginate($limit),
                'Data kehadiran berhasil diambil!'
            );
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

            $presensi = $user->pengajar->kehadiran();
            if ($presensi->whereDate('created_at', Carbon::today())->count()) {
                return ResponseFormatter::error(null, 'Sudah mengisi kehadiran!', 500);
            }

            if (!$request->keterangan) {
                return ResponseFormatter::error(null, 'Keterangan kehadiran tidak diisi!', 500);
            }

            Hijri::setDefaultAdjustment(-1);
            Date::setTranslation(new Indonesian());

            $data = KehadiranPengajar::create([
                'pengajar_id' => $user->pengajar->id,
                'keterangan' => ucfirst(strtolower($request->keterangan)),
                'bulan' => Date::today()->format('F o'),
                'datang' => strtolower($request->keterangan) == 'hadir' ? Carbon::now() : null,
            ]);

            return ResponseFormatter::success($data, 'Berhasil mengisi kehadiran!');
        } catch (\Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal mengisi kehadiran!', 500);
        }
    }

    public function update(Request $request)
    {
        $user = $request->user();
        if (!$this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Pengajar',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data kehadiran!', 500);
        }

        try {
            $presensi = $user->pengajar->kehadiran()->whereDate('created_at', Carbon::today())->firstOrFail();
            if (!$presensi) {
                return ResponseFormatter::error(null, 'Belum mengisi kehadiran!', 404);
            }

            if ($presensi->keterangan != 'Hadir') {
                return ResponseFormatter::error(null, 'Pengajar tidak hadir!', 500);
            }

            if ($presensi->pulang) {
                return ResponseFormatter::error(null, 'Pengajar telah pulang!', 500);
            }

            $presensi->update(['pulang' => Carbon::now(),]);

            return ResponseFormatter::success($presensi, 'Berhasil menyelesaikan kehadiran!');
        } catch (\Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal mengedit kehadiran!', 500);
        }
    }

    public function month(Request $request)
    {
        $user = $request->user();
        if (!$this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Pengajar',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data kehadiran!', 500);
        }

        $data = $user->pengajar->kehadiran()->select('bulan')->groupBy('bulan');
        if ($data->count()) {
            return ResponseFormatter::success($data->get(), 'Data bulan kehadiran berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data bulan kehadiran tidak ditemukan!', 404);
        }
    }
}
