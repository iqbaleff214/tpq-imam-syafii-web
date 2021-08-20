<?php

namespace App\Http\Controllers\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\Honor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HonorController extends Controller
{
    private $title = 'Honor';
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->get('status');
            $data = Honor::where('pengajar_id', Auth::user()->pengajar->id);
            if ($status != null) {
                $data = $data->where('status', $status);
            }
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($status) {
                    if ($status != null) {
                        return '<form class="d-inline" method="POST" action="' . route('pengajar.honor.update', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <button type="submit" class="btn bg-maroon btn-xs px-2 honor-confirm"> Konfirmasi </button>
                                </form>';
                    } else {
                        $button = '<a href="'.route('pengajar.honor.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>';
                        if ($row->status == 0) {
                            $button .= '<form class="d-inline" method="POST" action="' . route('pengajar.honor.update', $row) . '">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                            <button type="submit" class="btn bg-maroon btn-xs px-2 honor-confirm"> Konfirmasi </button>
                                        </form>';
                        }
                        return $button;
                    }
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->editColumn('jumlah', function($row) {
                    return "Rp".number_format($row->jumlah, 2, ',', '.');
                })
                ->editColumn('status', function($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success">Diterima</span>';
                    } else {
                        return '<span class="badge badge-danger">Menunggu</span>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $title = $this->title;
        return view('pages.pengajar.honor.index', compact('title'));
    }

    /**
     * Display the specified resource.
     *
     * @param Honor $honor
     * @return Response
     */
    public function show(Honor $honor)
    {
        $title = $this->title;
        return view('pages.pengajar.honor.show', compact('title', 'honor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Honor $honor
     * @return RedirectResponse
     */
    public function update(Request $request, Honor $honor)
    {
        try {
            $honor->update([
                'status' => 1
            ]);
            return redirect()->back()->with('success', 'Berhasil mengonfirmasi honor');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal mengonfirmasi honor');
        }
    }
}
