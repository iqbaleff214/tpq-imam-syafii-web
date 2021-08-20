<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class LembagaController extends Controller
{
    private $title = 'Lembaga';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $profil = Lembaga::where('is_active', 1)->firstOrFail();

        return view('pages.admin.pengaturan.lembaga', compact('title', 'profil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Lembaga $lembaga
     * @return RedirectResponse
     */
    public function update(Request $request, Lembaga $lembaga)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'visi' => 'required',
            'foto' => 'image|max:2048',
        ]);

        try {
            $foto = $lembaga->foto;
            if ($request->hasFile('foto')) {

                if ($foto) Storage::delete("public/$foto");

                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $lembaga->update([
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'deskripsi' => $request->deskripsi,
                'alamat' => $request->alamat,
                'foto' => $foto,
                'visi' => $request->visi,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'whatsapp' => $request->whatsapp,
                'instagram' => $request->instagram,
            ]);

            return redirect()->back()->with('success', 'Data lembaga berhasil diperbarui!');
        } catch (\Throwable $e) {

            return redirect()->back()->with('error', 'Data lembaga gagal diperbarui!');
        }
    }

    public function registration(Request $request, Lembaga $lembaga)
    {
        $pesan = $request->input('is_pendaftaran') ? 'dibuka!' : 'ditutup!';
        try {
            $lembaga->update([ 'is_pendaftaran' => $request->input('is_pendaftaran') ]);
            return redirect()->back()->with('success', 'Pendaftaran berhasil ' . $pesan);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Pendaftaran berhasil ' . $pesan);
        }
    }

    public function unlink()
    {
        try {
            $profil = Lembaga::where('is_active', 1)->firstOrFail();
            if ($profil->foto) Storage::delete("public/$profil->foto");
            $profil->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto lembaga berhasil dihapus!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Foto lembaga gagal dihapus!');
        }
    }
}
