<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Spp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SppController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $bulan = $request->input('bulan');
        $status = $request->input('status');

        $santri_id = $request->user()->santri->id;
        $data = Spp::where('santri_id', $santri_id);

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                return ResponseFormatter::success($data, 'Data spp berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data spp tidak ditemukan!', 404);
            }
        }

        if ($bulan) {
            $data = $data->where('bulan', $bulan);
        }

        if ($status != null) {
            $data = $data->where('status', $status);
        }

        if ($data->count()) {
            return ResponseFormatter::success($data->paginate($limit), 'Data spp berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data spp tidak ditemukan!', 404);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if ($this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Santri',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data spp!', 500);
        }

        $validator = Validator::make($request->all(), [
            'bukti' => 'required|image|max:2048'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(['error' => $validator->errors()], 'Gagal upload bukti pembayaran!', 401);
        }

        try {
            $id = $request->id;
            if (!$id) {
                return ResponseFormatter::error(null, 'Spp belum dipilih!', 404);
            }
            $spp = Spp::where('status', 0)->findOrFail($id);
            if (!$spp) {
                return ResponseFormatter::error(null, 'Spp belum ditagih!', 404);
            }

            $bukti = null;

            if ($request->hasFile('bukti')) {
                if ($bukti) Storage::delete("public/$bukti");
                $bukti = time() . '.' . $request->bukti->extension();
                Storage::putFileAs('public', $request->file('bukti'), $bukti);
            }

            $spp->update([
                'bukti' => $bukti,
                'status' => 1,
            ]);

            return ResponseFormatter::success($spp, 'Berhasil menyelesaikan spp!');
        } catch (\Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal mengedit spp!', 500);
        }
    }

    public function month(Request $request)
    {
        $user = $request->user();
        if ($this->isPengajar($user)) {
            return ResponseFormatter::error([
                'message' => 'Hanya bisa diakses oleh Santri',
                'error' => 'Hak akses ditolak!'
            ], 'Gagal mengambil data spp!', 500);
        }

        $data = $user->santri->spp()->select('bulan')->groupBy('bulan');
        if ($data->count()) {
            return ResponseFormatter::success($data->get(), 'Data bulan spp berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data bulan spp tidak ditemukan!', 404);
        }
    }
}
