<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\KurikulumBahan;
use App\Models\KurikulumMateri;
use App\Models\KurikulumMetode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class KurikulumController extends Controller
{
    private $title = 'Kurikulum';
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Kurikulum::all())
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<a href="'.route('kepala.kurikulum.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="'.route('kepala.kurikulum.edit', $row).'" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="'.route('kepala.kurikulum.destroy', $row).'">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->addColumn('jadwal', function($row) {
                    return $row->mulai . ' s.d. ' . $row->selesai;
                })
                ->rawColumns(['action', 'jadwal'])
                ->make(true);
        }
        $title = $this->title;
        echo view('pages.kepala.kurikulum.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        $days = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        echo view('pages.kepala.kurikulum.create', compact('days', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required',
            'target' => 'required',
            'catatan' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'bahan' => 'required',
        ]);

        try {
            $kurikulum = Kurikulum::create([
                'tingkat' => $request->tingkat,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai,
                'target' => $request->target,
                'keterangan' => $request->catatan,
            ]);

            foreach ($request->bahan as $bahan) {
                KurikulumBahan::create([
                    'bahan' => $bahan,
                    'kurikulum_id' => $kurikulum->id
                ]);
            }

            foreach ($request->materi as $materi) {
                KurikulumMateri::create([
                    'materi' => $materi,
                    'kurikulum_id' => $kurikulum->id
                ]);
            }

            foreach ($request->metode as $metode) {
                KurikulumMetode::create([
                    'metode' => $metode,
                    'kurikulum_id' => $kurikulum->id
                ]);
            }

            return redirect()->route('kepala.kurikulum.index')->with('success', 'Data kurikulum berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return Response
     */
    public function show(Kurikulum $kurikulum)
    {
        $title = $this->title;
        echo view('pages.kepala.kurikulum.show', compact('kurikulum', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return Response
     */
    public function edit(Kurikulum $kurikulum)
    {
        $title = $this->title;
        $days = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        echo view('pages.kepala.kurikulum.edit', compact('days', 'kurikulum', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        $request->validate([
            'tingkat' => 'required',
            'target' => 'required',
            'catatan' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
        ]);

        try {
            $kurikulum->update([
                'tingkat' => $request->tingkat,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai,
                'target' => $request->target,
                'keterangan' => $request->catatan,
            ]);

            return redirect()->back()->with('success', 'Data kurikulum berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data kurikulum gagal ditambahkan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Kurikulum $kurikulum)
    {
        try {
            $kurikulum->delete();
            return redirect()->back()->with('success', 'Data kurikulum berhasil dihapus!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data kurikulum gagal dihapus!');
        }
    }

    public function add(Request $request)
    {
        try {
            switch ($request->type) {
                case 'bahan':
                    $created = KurikulumBahan::create([
                        'bahan' => $request->data,
                        'kurikulum_id' => $request->id,
                    ]);
                    break;
                case 'materi':
                    $created = KurikulumMateri::create([
                        'materi' => $request->data,
                        'kurikulum_id' => $request->id,
                    ]);
                    break;
                case 'metode':
                    $created = KurikulumMetode::create([
                        'metode' => $request->data,
                        'kurikulum_id' => $request->id,
                    ]);
                    break;
                default:
                    return false;
            }
            return $created->id;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function mod(Request $request)
    {
        try {
            switch ($request->type) {
                case 'bahan':
                    KurikulumBahan::find($request->id)->update([
                        'bahan' => $request->data
                    ]);
                    break;
                case 'materi':
                    KurikulumMateri::find($request->id)->update([
                        'materi' => $request->data
                    ]);
                    break;
                case 'metode':
                    KurikulumMetode::find($request->id)->update([
                        'metode' => $request->data
                    ]);
                    break;
                default:
                    return false;
            }
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function delete(Request $request)
    {
        try {
            switch ($request->type) {
                case 'bahan':
                    KurikulumBahan::find($request->id)->delete();
                    break;
                case 'materi':
                    KurikulumMateri::find($request->id)->delete();
                    break;
                case 'metode':
                    KurikulumMetode::find($request->id)->delete();
                    break;
                default:
                    return false;
            }
            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }
}
