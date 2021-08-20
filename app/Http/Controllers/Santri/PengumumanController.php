<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

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
        return view('pages.santri.pengumuman.index', compact('title'));
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
        return view('pages.santri.pengumuman.show', compact('title', 'pengumuman'));
    }
}
