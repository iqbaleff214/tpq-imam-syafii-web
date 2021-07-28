<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Pengajar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PengajarController extends Controller
{
    private $title = 'Pengajar';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pengajar::all())
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('kepala.pengajar.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="'.route('kepala.pengajar.edit', $row).'" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="'.route('kepala.pengajar.destroy', $row).'">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->editColumn('jenis_kelamin', function($row) {
                    return $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = $this->title;

        echo view('pages.kepala.pengajar.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        echo view('pages.kepala.pengajar.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required',
            'alamat' => 'required',

            'username' => 'unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        try {

            $foto = null;
            if ($request->hasFile('foto')) {
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $akun = User::create([
                'username' => $request->username ?: $request->email,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'peran' => 'Pengajar',
            ]);

            Pengajar::create([
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'foto' => $foto,
                'user_id' => $akun->id,
            ]);

            return redirect()->route('kepala.pengajar.index')->with('success', 'Data pengajar berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->route('kepala.pengajar.index')->with('error', 'Data pengajar gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengajar  $pengajar
     * @return \Illuminate\Http\Response
     */
    public function show(Pengajar $pengajar)
    {
        $title = $this->title;
        echo view('pages.kepala.pengajar.show', compact('pengajar', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengajar  $pengajar
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengajar $pengajar)
    {
        $title = $this->title;
        echo view('pages.kepala.pengajar.edit', compact('pengajar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengajar  $pengajar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengajar $pengajar)
    {
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        try {

            $foto = $pengajar->foto;
            if ($request->hasFile('foto')) {

                if ($foto) Storage::delete("public/$foto");

                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $pengajar->update([
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'foto' => $foto,
            ]);

            return redirect()->route('kepala.pengajar.index')->with('success', 'Data pengajar berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->route('kepala.pengajar.index')->with('error', 'Data pengajar gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengajar  $pengajar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengajar $pengajar)
    {
        try {
            if ($pengajar->foto) Storage::delete("public/$pengajar->foto");
            $pengajar->update(['foto' => null]);
            User::find($pengajar->user_id)->delete();
            $pengajar->delete();

            return redirect()->route('kepala.pengajar.index')->with('success', 'Data pengajar berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->route('kepala.pengajar.index')->with('error', 'Data pengajar gagal dihapus!');
        }
    }
}
