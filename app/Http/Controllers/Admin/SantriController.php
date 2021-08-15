<?php

namespace App\Http\Controllers\Admin;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Controllers\Controller;
use App\Mail\PenerimaanMail;
use App\Models\Hafalan;
use App\Models\KehadiranSantri;
use App\Models\Kelas;
use App\Models\Pembelajaran;
use App\Models\Santri;
use App\Models\SantriWali;
use App\Models\SppOpsi;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SantriController extends Controller
{
    private $title = 'Santri';
    private $status = ['Aktif' => 'Aktif', 'Berhenti' => 'Berhenti', 'Lulus' => 'Lulus'];
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

            $kelas = $request->get('kelas_id');
            $data = Santri::whereIn('status', $this->status);

            if ($kelas) {
                $data = $data->where('kelas_id', $kelas);
            }

            return DataTables::of($data->get())
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
            'nis' => 'unique:santri,nis|nullable',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',

            'anak_ke' => 'nullable|numeric',
            'jumlah_saudara' => 'nullable|numeric',

            'username' => 'nullable|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',

            'nama_wali' => 'required',
            'no_telp' => 'required|max:15',
            'hubungan' => 'required',

            'no_telp_opsional' => ['max:15', Rule::requiredIf($request->nama_wali_opsional != '')],
            'hubungan_opsional' => Rule::requiredIf($request->nama_wali_opsional != ''),

            'foto' => 'image|max:2048',
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
                $no = Santri::withTrashed()->where('nis', 'like', '%' . $newNis . '%')->count() + 1;
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

            SantriWali::create([
                'nama_wali' => $request->nama_wali,
                'hubungan' => $request->hubungan,
                'no_telp' => $request->no_telp,
                'santri_id' => $santri->id
            ]);

            if ($request->nama_wali_opsional) {
                SantriWali::create([
                    'nama_wali' => $request->nama_wali_opsional,
                    'hubungan' => $request->hubungan_opsional,
                    'no_telp' => $request->no_telp_opsional,
                    'santri_id' => $santri->id
                ]);
            }

            return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil ditambahkan!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data santri gagal ditambahkan!');
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
        $bulan = KehadiranSantri::selectRaw('bulan')->where('santri_id', $santri->id)->orderByRaw('MAX(created_at)')->groupBy('bulan')->get();
        echo view('pages.admin.santri.show', ['title' => $this->title, 'santri' => $santri, 'bulan' => $bulan]);
    }

    public function show_hafalan(Request $request, Santri $santri)
    {
        if ($request->ajax()) {
            $bulan = $request->get('bulan');
            $chart = $request->get('chart');
            $data = Hafalan::where('bulan', $bulan)->where('santri_id', $santri->id);

            if ($chart) {
                if ($chart == 'doughnut') {
                    $data = $data->selectRaw('COUNT(keterangan) as data, keterangan as label')->groupBy('keterangan')->get();
                    return response()->json($data);
                }
            }
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('hari', function ($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function ($row) {
                    return \GeniusTS\HijriDate\Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('ayat', function ($row) {
                    if ($row->mulai == $row->selesai)
                        return $row->hafalan . ($row->mulai ? ': ' . $row->mulai : '');
                    else
                        return $row->hafalan . ': ' . $row->mulai . '-' . $row->selesai;
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->make(true);
        }
    }

    public function show_pembelajaran(Request $request, Santri $santri)
    {
        if ($request->ajax()) {
            $bulan = $request->get('bulan');
            $chart = $request->get('chart');
            $data = Pembelajaran::where('bulan', $bulan)->where('santri_id', $santri->id);

            if ($chart) {
                if ($chart == 'doughnut') {
                    $data = $data->selectRaw('COUNT(keterangan) as data, keterangan as label')->groupBy('keterangan')->get();
                    return response()->json($data);
                }
            }
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('hari', function ($row) {
                    return $row->created_at->isoFormat('dddd');
                })
                ->addColumn('hijriah', function ($row) {
                    return \GeniusTS\HijriDate\Hijri::convertToHijri($row->created_at)->format('d-m-Y');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y');
                })
                ->addColumn('ayat', function ($row) {
                    if ($row->mulai == $row->selesai)
                        return $row->bacaan . ': ' . $row->mulai;
                    else
                        return $row->bacaan . ': ' . $row->mulai . '-' . $row->selesai;
                })
                ->addColumn('santri', function ($row) {
                    return $row->santri->nama_lengkap;
                })
                ->make(true);
        }
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
            'nis' => ['required', Rule::unique('santri')->ignore($santri->id), 'size:7', 'alpha_num'],
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',

            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',

            'nama_wali' => 'required',
            'no_telp' => 'required|max:15',
            'hubungan' => 'required',

            'no_telp_opsional' => ['max:15', Rule::requiredIf($request->nama_wali_opsional != '')],
            'hubungan_opsional' => Rule::requiredIf($request->nama_wali_opsional != ''),

            'foto' => 'image|max:2048',
        ]);

        try {
            $foto = $santri->foto;
            if ($request->hasFile('foto')) {
                if ($foto) Storage::delete("public/$foto");
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $santri->update([
                'nis' => $request->nis,
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
                'kelas_id' => $request->status == 'Aktif' ? $request->kelas_id : null,
            ]);

            SantriWali::findOrFail($request->id_wali)->update([
                'nama_wali' => $request->nama_wali,
                'no_telp' => $request->no_telp,
                'hubungan' => $request->hubungan,
            ]);

            if (isset($request->id_wali_opsional)) {
                if ($request->nama_wali_opsional == '') {
                    SantriWali::findOrFail($request->id_wali_opsional)->delete();
                } else {
                    SantriWali::findOrFail($request->id_wali_opsional)->update([
                        'nama_wali' => $request->nama_wali_opsional,
                        'no_telp' => $request->no_telp_opsional,
                        'hubungan' => $request->hubungan_opsional,
                    ]);
                }
            } elseif ($request->nama_wali_opsional != '') {
                SantriWali::create([
                    'nama_wali' => $request->nama_wali_opsional,
                    'hubungan' => $request->hubungan_opsional,
                    'no_telp' => $request->no_telp_opsional,
                    'santri_id' => $santri->id
                ]);
            }

            return redirect()->back()->with('success', 'Data santri berhasil diedit!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data santri gagal diedit!');
        }
    }

    public function accept(Request $request, Santri $santri)
    {
        $pesan = $request->status == 'Aktif' ? 'diterima!' : 'ditolak!';
        try {
//            $santri->update(['status' => $request->status]);
            Mail::to(User::find($santri->user_id))->send(new PenerimaanMail($santri));
            return redirect()->back()->with('success', 'Santri berhasil ' . $pesan);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Santri gagal ' . $pesan);
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

            return redirect()->back()->with('success', 'Data santri berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Data santri gagal dihapus!');
        }
    }

    public function unlink(Santri $santri)
    {
        try {
            if ($santri->foto) Storage::delete("public/$santri->foto");
            $santri->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto santri berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Foto santri gagal dihapus!');
        }
    }
}
