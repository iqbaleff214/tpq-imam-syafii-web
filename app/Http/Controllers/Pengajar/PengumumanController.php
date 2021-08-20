<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PengumumanController extends Controller
{
    private $title = "Pengumuman";

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pengumuman::orderBy('id')->paginate(15);
            return response()->json($data);
        }
        $title = $this->title;
        return view('pages.pengajar.pengumuman.index', compact('title'));
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return Response
     */
    public function show($slug)
    {
        $pengumuman = Pengumuman::where('slug', $slug)->firstOrFail();
        $pengumuman->increment('seen');
        $title = $this->title;
        return view('pages.pengajar.pengumuman.show', compact('title', 'pengumuman'));
    }
}
