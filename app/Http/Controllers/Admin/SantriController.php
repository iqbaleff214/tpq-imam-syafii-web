<?php

namespace App\Http\Controllers\Admin;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\SantriWali;
use App\Models\SppOpsi;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SantriController extends Controller
{
    private $title = 'Santri';
    private $status = ['Aktif' => 'Aktif', 'Calon' => 'Calon Santri', 'Berhenti' => 'Berhenti', 'Lulus' => 'Lulus', 'Tanpa Keterangan' => 'Tanpa Keterangan'];
    private $hubungan = ['Ayah', 'Ibu', 'Kakak', 'Paman', 'Bibi', 'Sepupu', 'Kakak Ipar', 'Lainnya'];

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
            return DataTables::of(Santri::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.santri.show', $row) . '" class="btn btn-success btn-xs px-2"> Lihat </a>
                            <a href="' . route('admin.santri.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                            <form class="d-inline" method="POST" action="' . route('admin.santri.destroy', $row) . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                            </form>';
                })
                ->editColumn('jenis_kelamin', function ($row) {
                    return $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->addColumn('umur', function ($row) {
                    return Carbon::parse($row->tanggal_lahir)->age . ' tahun';
                })
                ->addColumn('kelas', function ($row) {
                    return $row->kelas ? $row->kelas->nama_kelas : 'Belum Masuk';
                })
                ->rawColumns(['action', 'kelas', 'umur'])
                ->make(true);
        }

        echo view('pages.admin.santri.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!SppOpsi::count()) return redirect()->route('admin.spp.opsi.create')->with('info', 'Isi data opsi spp terlebih dahulu!');

        echo view('pages.admin.santri.create', ['title' => $this->title, 'status' => $this->status, 'hubungan' => $this->hubungan, 'opsi' => SppOpsi::all(), 'kelas' => Kelas::all()]);
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
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',

            'username' => 'nullable|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        try {
            $nis = $request->nis;

            $nama_wali = $request->nama_wali;
            $hubungan = $request->hubungan;
            $no_telp = $request->no_telp;

            if (!$nis) {
                $newNis = $request->jenis_kelamin == 'L' ? 'I' : 'A';
                # $newNis .= '-';
                $newNis .= Hijri::Date('ym');
                $no = Santri::where('nis', 'like', '%' . $newNis . '%')->count() + 1;
                $nis = sprintf("$newNis%02d", $no);
            }

            $akun = User::create([
                'username' => $request->username ?: $nis,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'peran' => 'Santri',
            ]);

            $santri = [
                'nis' => $nis,
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan ?: $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'anak_ke' => $request->anak_ke ?: 1,
                'jumlah_saudara' => $request->jumlah_saudara ?: 1,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'foto' => null,
                'user_id' => $akun->id,
                'spp_opsi_id' => $request->spp_opsi_id,
                'kelas_id' => $request->kelas_id,
            ];

            if ($request->hasFile('foto')) {
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
                $santri['foto'] = $foto;
            }

            $santri = Santri::create($santri);

            for ($i = 0; $i < count($nama_wali); $i++) {
                SantriWali::create([
                    'nama_wali' => $nama_wali[$i],
                    'hubungan' => $hubungan[$i],
                    'no_telp' => $no_telp[$i],
                    'santri_id' => $santri->id
                ]);
            }

            return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->route('admin.santri.index')->with('error', 'Data santri gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Santri $santri
     * @return Response
     */
    public function show(Santri $santri)
    {
        echo view('pages.admin.santri.show', ['title' => $this->title, 'santri' => $santri]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Santri $santri
     * @return Response
     */
    public function edit(Santri $santri)
    {
        echo view('pages.admin.santri.edit', ['title' => $this->title, 'status' => $this->status, 'hubungan' => $this->hubungan, 'opsi' => SppOpsi::all(), 'kelas' => Kelas::all(), 'santri' => $santri]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Santri $santri
     * @return RedirectResponse
     */
    public function update(Request $request, Santri $santri)
    {

        $request->validate([
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|numeric',
            'jumlah_saudara' => 'required|numeric',
            'alamat' => 'required',
            'status' => 'required',
            'spp_opsi_id' => 'required',
        ]);

        try {

            $foto = $santri->foto;

            if ($request->hasFile('foto')) {
                if ($foto) Storage::delete("public/$foto");
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $santri->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan ?: $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'anak_ke' => $request->anak_ke ?: 1,
                'jumlah_saudara' => $request->jumlah_saudara ?: 1,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'foto' => $foto,
                'spp_opsi_id' => $request->spp_opsi_id,
                'kelas_id' => $request->kelas_id,
            ]);


            return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->route('admin.santri.index')->with('error', 'Data santri gagal diedit!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Santri $santri
     * @return RedirectResponse
     */
    public function destroy(Santri $santri)
    {
        try {
            if ($santri->foto) Storage::delete("public/$santri->foto");
            $santri->update(['foto' => null]);
            User::findOrFail($santri->user_id)->delete();
            $santri->delete();

            return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->route('admin.santri.index')->with('error', 'Data santri gagal dihapus!');
        }
    }

    public function wali(Request $request)
    {

    }
}
