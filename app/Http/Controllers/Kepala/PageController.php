<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Kas;
use App\Models\Pengajar;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        $count = [
            'santri' => Santri::count(),
            'pengajar' => Pengajar::count(),
            'saldo' => Kas::sum('pemasukan') - Kas::sum('pengeluaran')
        ];

        $title = 'Dasbor';

        return view('pages.kepala.dashboard', compact('count', 'title'));
    }

    public function profil()
    {
        $title = 'Profil';
        return view('pages.kepala.pengaturan.profil', compact('title'));
    }

    public function akun()
    {
        return view('pages.kepala.pengaturan.akun', ['title' => 'Akun']);
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

            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Profil gagal diperbarui!');
        }
    }

    public function update_akun(Request $request)
    {
        $request->validate([
            'username' => ['required', Rule::unique('users')->ignore(Auth::user()->id)],
            'password_old' => 'required',
            'password' => 'nullable|confirmed',
        ]);
        try {

            if (!password_verify($request->input('password_old'), Auth::user()->getAuthPassword())) return redirect()->back()->with('error', 'Kata sandi salah!');

            $data = [
                'username' => $request->input('username'),
            ];

            if ($request->input('password')) $data['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);

            Auth::user()->update($data);
            return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Akun gagal diperbarui!');
        }
    }

    public function unlink()
    {
        try {
            $profil = Auth::user()->administrator;
            if ($profil->foto) Storage::delete("public/$profil->foto");
            $profil->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Foto profil gagal dihapus!');
        }
    }
}
