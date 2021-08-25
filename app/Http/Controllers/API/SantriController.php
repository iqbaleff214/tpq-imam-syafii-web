<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    use ApiHelpers;

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $q = $request->input('q');
        $nis = $request->input('nis');

        $kelas_id = $request->user()->pengajar->kelas->id;
        $data = Santri::where('kelas_id', $kelas_id)->where('status', 'Aktif')->with(['kehadiran', 'wali', 'latestBacaan', 'latestHafalan', 'latestKehadiran']);

        if ($id) {
            $data = $data->find($id);
            if ($data) {
                return ResponseFormatter::success($data, 'Data santri berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data santri tidak ditemukan!', 404);
            }
        }

        if ($nis) {
            $data = $data->where('nis', $nis)->with(['pembelajaran', 'hafalan', 'kehadiran'])->first();
            if ($data) {
                return ResponseFormatter::success($data, 'Data santri berhasil diambil!');
            } else {
                return ResponseFormatter::error(null, 'Data santri tidak ditemukan!', 404);
            }
        }

        if ($q) {
            $data = $data->where('nama_lengkap', 'like', "%{$q}%")->orWhere('nama_panggilan', 'like', "%{$q}%")->orWhere('nis', 'like', "%{$q}%");
        }

        if ($data->count()) {
            return ResponseFormatter::success($data->paginate($limit), 'Data santri berhasil diambil!');
        } else {
            return ResponseFormatter::error(null, 'Data santri tidak ditemukan!', 404);
        }
    }

}
