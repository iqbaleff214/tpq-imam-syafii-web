<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Pengumuman;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AdministratorController extends Controller
{
    private $title = 'Administrator';
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $admin = Administrator::where('jabatan', '!=', 'Kepala Sekolah')->get();
            return DataTables::of($admin)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('kepala.admin.show', $row).'" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="'.route('kepala.admin.edit', $row).'" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="'.route('kepala.admin.destroy', $row).'">
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

        return view('pages.kepala.administrator.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        return view('pages.kepala.administrator.create', compact('title'));
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
            'no_telp' => 'required|max:15',
            'alamat' => 'required',

            'username' => 'unique:users,username',
            'email' => 'required|email:dns|unique:users,email',
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
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'peran' => 'Admin',
            ]);

            Administrator::create([
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'jabatan' => $request->jabatan,
                'foto' => $foto,
                'user_id' => $akun->id,
            ]);
            return redirect()->route('kepala.admin.index')->with('success', 'Data administrator berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data administrator gagal ditambahkan!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Administrator $admin
     * @return Response
     */
    public function show(Request $request, Administrator $admin)
    {
        if ($request->ajax()) {
            $data = Pengumuman::where('admin_id', $admin->id);
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->editColumn('konten', function ($row) {
                    return Str::limit(strip_tags($row->konten), 155) . '...';
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = $this->title;
        return view('pages.kepala.administrator.show', compact('admin', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Administrator $admin
     * @return Response
     */
    public function edit(Administrator $admin)
    {
        $title = $this->title;
        return view('pages.kepala.administrator.edit', compact('admin', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Administrator $admin
     * @return RedirectResponse
     */
    public function update(Request $request, Administrator $admin)
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

            $foto = $admin->foto;
            if ($request->hasFile('foto')) {

                if ($foto) Storage::delete("public/$foto");

                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $admin->update([
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'jabatan' => $request->jabatan,
                'foto' => $foto,
            ]);

            return redirect()->back()->with('success', 'Data administrator berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data administrator gagal diedit!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Administrator $admin
     * @return RedirectResponse
     */
    public function destroy(Administrator $admin): RedirectResponse
    {
        try {
            if ($admin->foto) Storage::delete("public/$admin->foto");
            $admin->update(['foto' => null]);
            User::find($admin->user_id)->delete();
            $admin->delete();

            return redirect()->back()->with('success', 'Data administrator berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Data administrator gagal dihapus!');
        }
    }

    public function unlink(Administrator $administrator)
    {
        try {
            if ($administrator->foto) Storage::delete("public/$administrator->foto");

            $administrator->update(['foto' => null]);
            return redirect()->back()->with('success', 'Foto administrator berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Foto administrator gagal dihapus!');
        }
    }
}
