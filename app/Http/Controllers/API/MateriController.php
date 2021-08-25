<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $q = $request->input('q');

        $data = Materi::orderBy('created_at', 'acs');

        if ($data->count()) {
            return ResponseFormatter::success($data->paginate($limit), 'Data materi berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data materi tidak ditemukan!', 404);
        }
    }
}
