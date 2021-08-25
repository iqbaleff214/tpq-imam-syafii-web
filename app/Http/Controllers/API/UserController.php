<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Pengajar;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiHelpers;

    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $credential = request(['username', 'password']);

            if (!Auth::attempt($credential)) {
                return ResponseFormatter::error([
                    'error' => 'Unauthorized'
                ], 'Gagal melakukan login!', 500);
            }

            $user = User::where('username', $request->username)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw \Exception('Invalid Credentials!');
            }

            if (in_array($user->peran, ['Kepala', 'Admin'])) {
                return ResponseFormatter::error([
                    'error' => 'Hak akses ditolak!'
                ], 'Gagal melakukan login!', 500);
            }

            $kelas = $this->isPengajar($user) ? $user->pengajar->kelas : $user->santri->kelas;
            if (!$kelas) {
                return ResponseFormatter::error([
                    'error' => 'Belum terdaftar pada kelas!'
                ], 'Gagal melakukan login!', 500);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Berhasil melakukan login');
        } catch (Exception $exception) {
            return ResponseFormatter::error(['error' => $exception], 'Gagal melakukan login!', 500);
        }
    }

    public function get(Request $request)
    {
        $user = $request->user();
        $profile = $this->isPengajar($user) ? 'pengajar' : 'santri';
        $user = User::with([$profile])->findOrFail($user->id);
        if ($user) {
            return ResponseFormatter::success($user, 'Berhasil mengambil data profil!');
        } else {
            return ResponseFormatter::error(null, 'Data profil tidak ditemukan!', 404);
        }
    }

    public function photo(Request $request)
    {
        $user = $request->user();
        $profile = $this->isPengajar($user) ? $user->pengajar : $user->santri;
        $data = $profile->foto;
        if ($data) {
            return ResponseFormatter::success(asset("storage/$data"), 'Berhasil mengambil foto profil!');
        } else {
            $data = $profile->jenis_kelamin == 'L' ? 'ikhwan.svg' : 'akhwat.svg';
            return ResponseFormatter::success(asset("images/$data"), 'Berhasil mengambil foto profil!');
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->post();
            $user = $request->user();
            $profile = $this->isPengajar($user) ? $user->pengajar : $user->santri;
            $profile->update($data);
            return ResponseFormatter::success($profile, 'Berhasil mengedit profil!');
        } catch (Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal mengedit profil!', 500);
        }
    }

    public function update_account(Request $request)
    {
        try {
            $data = $request->post();
            $profile = $request->user()->update($data);
            return ResponseFormatter::success($profile, 'Berhasil mengedit akun!');
        } catch (Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal mengedit akun!', 500);
        }
    }

    public function upload(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'foto' => 'required|image|max:2048'
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(['error' => $validator->errors()], 'Gagal upload foto profil!', 401);
            }

            $user = Auth::user();
            $profil = $this->isPengajar($user) ? $user->pengajar : $user->santri;
            $foto = $profil->foto;

            if ($request->hasFile('foto')) {
                if ($foto) Storage::delete("public/$foto");
                $foto = time() . '.' . $request->foto->extension();
                Storage::putFileAs('public', $request->file('foto'), $foto);
            }

            $profil->update(['foto' => $foto]);

            return ResponseFormatter::success(asset("storage/$foto"), 'Berhasil upload foto profil!');
        } catch (Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal upload foto profil!', 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $token = $request->user()->currentAccessToken()->delete();
            return ResponseFormatter::success($token, 'Berhasil melakukan logout!');
        } catch (Exception $e) {
            return ResponseFormatter::error(['error' => $e], 'Gagal melakukan logout!', 500);
        }
    }
}
