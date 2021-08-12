<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Honor;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Http\Request;

class HonorController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $user = $request->user();
        if (!$this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Pengajar',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data honor!', 500);
        }

        $id = $request->input('id');
        $limit = $request->input('limit');
        $sekarang = $request->input('sekarang');
        $status = $request->input('status');
        $bulan = $request->input('bulan');

        $data = $user->pengajar->honor();

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                return ResponseFormatter::success($data, 'Data honor berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data honor tidak ditemukan!', 404);
            }
        }

        if ($sekarang) {
            $data = $data->where('bulan', Date::today()->format('F o'))->first();
            if ($data) {
                return ResponseFormatter::success($data, 'Data honor bulan ini berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data honor bulan ini tidak ditemukan!', 404);
            }
        }

        if ($status != null) {
            $data = $data->where('status', $status);
        }

        if ($bulan) {
            $data = $data->where('bulan', $bulan);
        }

        if ($data->count()) {
            return ResponseFormatter::success(
                $data->paginate($limit),
                'Data honor berhasil diambil!'
            );
        } else {
            return ResponseFormatter::error(null, 'Data honor tidak ditemukan!', 404);
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
            $id = $request->id;
            if (!$id) {
                return ResponseFormatter::error(null, 'Honor belum dipilih!', 404);
            }

            $data = Honor::find($id);
            if (!$data) {
                return ResponseFormatter::error(null, 'Data honor tidak ditemukan!', 404);
            }

            if ($data->pengajar_id != $user->pengajar->id) {
                return ResponseFormatter::error(null, 'Hanya bisa mengonfirmasi honor sendiri!', 500);
            }

            if ($data->status == 1) {
                return ResponseFormatter::error(null, 'Pembayaran honor telah dikonfirmasi!', 500);
            }

            $data->update(['status' => 1]);

            return ResponseFormatter::success($data, 'Berhasil konfirmasi penerimaan honor!');
        } catch (\Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal konfirmasi penerimaan honor!', 500);
        }
    }
}
