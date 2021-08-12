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
                    'message' => 'Unauthorized'
                ], 'Autentikasi gagal!', 500);
            }

            $user = User::where('username', $request->username)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw \Exception('Invalid Credentials!');
            }

            if (in_array($user->peran, ['Kepala', 'Admin'])) {
                return ResponseFormatter::error([
                    'message' => 'Something went wrong',
                    'error' => 'Hak akses ditolak!'
                ], 'Autentikasi gagal!', 500);
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
