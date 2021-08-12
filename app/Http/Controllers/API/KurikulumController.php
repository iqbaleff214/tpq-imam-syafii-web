<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $kelas = $request->input('kelas');
        $q = $request->input('q');

        $data = Kurikulum::with(['bahan', 'materi', 'metode']);

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                return ResponseFormatter::success($data, 'Data kurikulum berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data kurikulum tidak ditemukan!', 404);
            }
        }

        if ($kelas) {
            $user = $request->user();
            $kelas = $this->isPengajar($user) ? $user->pengajar->kelas : $user->santri->kelas;
            $data = $kelas->kurikulum()->with(['bahan', 'materi', 'metode'])->first();
            if ($data) {
                return ResponseFormatter::success($data, 'Data kurikulum berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data kurikulum tidak ditemukan!', 404);
            }
        }

        if ($q) {
            $data = $data->where('tingkat', 'like', "%{$q}%");
        }

        return ResponseFormatter::success(
            $data->paginate($limit),
            'Data kurikulum berhasil diambil!'
        );
    }
}
