<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class KurikulumController extends Controller
{
    private $title = 'Kelas';
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Kurikulum::all())
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<a href="'.route('admin.kurikulum.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>';
                })
                ->addColumn('jadwal', function($row) {
                    return $row->mulai . ' s.d. ' . $row->selesai;
                })
                ->rawColumns(['action', 'jadwal'])
                ->make(true);
        }
        echo view('pages.admin.kurikulum.index', ['title' => $this->title]);
    }

    /**
     * Display the specified resource.
     *
     * @param Kurikulum $kurikulum
     * @return Response
     */
    public function show(Kurikulum $kurikulum)
    {
        $title = $this->title;
        echo view('pages.admin.kurikulum.show', compact('kurikulum', 'title'));
    }
}
