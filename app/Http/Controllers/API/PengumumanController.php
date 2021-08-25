<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $q = $request->input('q');

        $data = Pengumuman::with(['penulis'])->orderByDesc('created_at');

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                $data->increment('seen');
                return ResponseFormatter::success($data, 'Data pengumuman berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data pengumuman tidak ditemukan!', 404);
            }
        }

        if ($q) {
            $data = $data->where('judul', 'like', "%{$q}%");
        }

        if ($data->count()) {
            return ResponseFormatter::success($data->paginate($limit), 'Data pengumuman berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data pengumuman tidak ditemukan!', 404);
        }
    }
}
