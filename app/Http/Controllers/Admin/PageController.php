<?php

namespace App\Http\Controllers\Admin;

use Alkoumi\LaravelHijriDate\Hijri;
use GeniusTS\HijriDate as TSHijri;
use App\Http\Controllers\Controller;
use App\Models\Kalender;
use App\Models\Kas;
use App\Models\Pengajar;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{

    public function index(Request $request)
    {
        $count = [
            'santri' => Santri::count(),
            'pengajar' => Pengajar::count(),
            'saldo' => Kas::sum('pemasukan') - Kas::sum('pengeluaran')
        ];
        $title = 'Dasbor';

        return view('pages.admin.dashboard', compact('count', 'title'));
    }

    public function profil()
    {
        return view('pages.admin.pengaturan.profil', ['title' => 'Profil']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        $admin = Auth::user()->administrator;

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
                'foto' => $foto,
            ]);

            return redirect()->route('admin.profil')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Throwable $e) {

            return redirect()->route('admin.profil')->with('error', 'Profil gagal diperbarui!');
        }
    }

    public function kalender()
    {

        $data = Kalender::all();
        $title = 'Kelender';
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
        echo view('pages.admin.kalender.index', compact('title', 'kalender'));
    }
}
