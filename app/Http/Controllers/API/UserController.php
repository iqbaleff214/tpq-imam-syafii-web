<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Pengajar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
            ], 'Terautentikasi');
        } catch (\Exception $exception) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $exception
            ], 'Autentikasi gagal!', 500);
        }
    }

    public function fetch(Request $request)
    {
        $user = null;
        switch ($request->user()->peran) {
            case 'Pengajar':
                $user = User::with(['pengajar'])->find($request->user()->id);
                break;
            case 'Santri':
                $user = User::with(['santri'])->find($request->user()->id);
                break;
            default:
                return ResponseFormatter::error(['message' => 'Gagal'], 'Gagal mengambil, 500');
        }
        return ResponseFormatter::success($user, 'Data profil user berhasil diambil');
    }

    public function editProfile(Request $request)
    {
        $data = $request->all();
        $profil = Auth::user()->peran == 'Pengajar' ? Auth::user()->pengajar : Auth::user()->santri;
        $profil->update($data);
        return ResponseFormatter::success($profil, 'hore!');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Berhasil logout');
    }
}
