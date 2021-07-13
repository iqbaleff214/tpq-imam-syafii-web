<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $tingkat = $request->input('tingkat');


        if ($id) {
            $kurikulum = Kurikulum::with(['bahan', 'materi', 'metode'])->find($id);

            if ($kurikulum) {
                return ResponseFormatter::success($kurikulum, 'Data kurikulum berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data kurikulum gagal diambil!', 404);
            }
        }

        $kurikulum = Kurikulum::with(['bahan', 'materi', 'metode']);

        if ($tingkat) {
            $kurikulum->where('tingkat', 'like', "%{$tingkat}%");
        }

        return ResponseFormatter::success(
            $kurikulum->paginate($limit),
            'Data kurikulum berhasil diambil!'
        );
    }
}
