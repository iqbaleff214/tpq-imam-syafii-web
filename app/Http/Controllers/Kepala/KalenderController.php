<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Kalender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class KalenderController extends Controller
{
    private $title = 'Kalender';

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Kalender::all())
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<form class="d-inline" method="POST" action="'.route('kepala.kalender.destroy', $row).'">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('mulai', function($row) {
                    return Carbon::parse($row->mulai)->format('d-m-Y');
                })
                ->editColumn('selesai', function($row) {
                    return Carbon::parse($row->selesai)->format('d-m-Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data = Kalender::all();
        $kalender = [];
        foreach ($data as $item) {
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $kalender[] = [
                'title' => $item->keterangan,
                'start' => $item->mulai,
                'end' => $item->selesai,
                'backgroundColor' => $color,
                'borderColor' => $color,
            ];
        }

        $kalender = json_encode($kalender);
        $title = $this->title;
        echo view('pages.kepala.kalender.index', compact('title', 'kalender'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'mulai' => 'required|date',
            'selesai' => [Rule::requiredIf(!$request->satu_hari), 'date']
        ]);

        try {
            Kalender::create([
                'keterangan' => $request->keterangan,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai ?: $request->mulai,
            ]);
            return redirect()->back()->with('success', 'Data kalender pendidikan berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data kalender pendidikan gagal ditambahkan!');
        }
    }

    public function destroy(Kalender $kalender)
    {
        try {
            $kalender->delete();
            return redirect()->back()->with('success', 'Data kalender pendidikan berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data kalender pendidikan gagal dihapus!');
        }
    }
}
