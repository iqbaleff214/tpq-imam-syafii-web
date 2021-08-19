<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AkunPengajarMail;
use App\Models\KehadiranPengajar;
use App\Models\Pengajar;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PengajarController extends Controller
{
    private $title = 'Pengajar';

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
            return DataTables::of(Pengajar::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.pengajar.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.pengajar.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.pengajar.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->editColumn('jenis_kelamin', function ($row) {
                    return $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        echo view('pages.admin.pengajar.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        echo view('pages.admin.pengajar.create', ['title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
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
            'foto' => 'image|max:2048'
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

            $pengajar = Pengajar::create([
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

            Mail::to($akun)->send(new AkunPengajarMail($pengajar, ['password' => $request->password]));
            return redirect()->route('admin.pengajar.index')->with('success', 'Data pengajar berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data pengajar gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Pengajar $pengajar
     * @return Response
     */
    public function show(Pengajar $pengajar)
    {
        $title = $this->title;
        $bulan = KehadiranPengajar::selectRaw('bulan')->where('pengajar_id', $pengajar->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();
        echo view('pages.admin.pengajar.show', compact('pengajar', 'title', 'bulan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Pengajar $pengajar
     * @return Response
     */
    public function edit(Pengajar $pengajar)
    {
        $title = $this->title;
        echo view('pages.admin.pengajar.edit', compact('pengajar', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Pengajar $pengajar
     * @return Response
     */
    public function update(Request $request, Pengajar $pengajar)
    {
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required',
            'alamat' => 'required',
            'foto' => 'image|max:2048'
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

            return redirect()->back()->with('success', 'Data pengajar berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data pengajar gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pengajar $pengajar
     * @return Response
     */
    public function destroy(Pengajar $pengajar)
    {
        try {
            if ($pengajar->foto) Storage::delete("public/$pengajar->foto");
            $pengajar->update(['foto' => null]);
            User::find($pengajar->user_id)->delete();
            $pengajar->delete();

            return redirect()->back()->with('success', 'Data pengajar berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Data pengajar gagal dihapus!');
        }
    }

    public function unlink(Pengajar $pengajar)
    {
        try {
            if ($pengajar->foto) Storage::delete("public/$pengajar->foto");
            $pengajar->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto pengajar berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Foto pengajar gagal dihapus!');
        }
    }
}
