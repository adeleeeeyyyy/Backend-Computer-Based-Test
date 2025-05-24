<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminProfileResource;
use App\Http\Resources\GuruProfileResource;
use App\Http\Resources\SiswaProfileResource;
use App\Http\Resources\UserResource;
use App\Models\AdminProfile;
use App\Models\GuruProfile;
use App\Models\SiswaProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:50|unique:users',
        'email' => 'required|email|max:100|unique:users',
        'password' => 'required|string|min:6',
        'nama_lengkap' => 'required|string|max:100',
        'role' => 'required|string|in:siswa,guru,admin',
        'nis' => 'nullable|required_if:role,siswa|string|max:20|unique:siswa_profiles',
        'kelas' => 'nullable|required_if:role,siswa|string|max:20',
        'jurusan' => 'nullable|required_if:role,siswa|string|max:50',
        'nig' => 'nullable|required_if:role,guru|string|max:20|unique:guru_profiles',
        'mata_pelajaran' => 'nullable|required_if:role,guru|string|max:100',
    ]);

    DB::beginTransaction();
    try {
        // Buat user terlebih dahulu tanpa profile_id
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'role' => $request->role,
            'status' => 'aktif',
        ]);

        $profile = null;
        $profileId = match ($request->role) {
            'siswa' => 'siswa_id_' . uniqid(),
            'guru' => 'guru_id_' . uniqid(),
            'admin' => 'admin_id_' . uniqid(),
        };

        switch ($request->role) {
            case 'siswa':
                $profile = SiswaProfile::create([
                    'user_id' => $profileId,
                    'nis' => $request->nis,
                    'kelas' => $request->kelas,
                    'jurusan' => $request->jurusan,
                ]);
                $user->update(['siswa_profile_id' => $profileId]);
                break;

            case 'guru':
                $profile = GuruProfile::create([
                    'user_id' => $profileId,
                    'nig' => $request->nig,
                    'mata_pelajaran' => $request->mata_pelajaran,
                ]);
                $user->update(['guru_profile_id' => $profileId]);
                break;

            case 'admin':
                $profile = AdminProfile::create([
                    'user_id' => $profileId,
                ]);
                $user->update(['admin_profile_id' => $profileId]);
                break;

            default:
                $user->delete();
                throw ValidationException::withMessages([
                    'role' => 'Invalid role provided',
                ]);
        }

        DB::commit();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => new UserResource($user),
            'profile' => match ($request->role) {
                'siswa' => new SiswaProfileResource($profile),
                'guru' => new GuruProfileResource($profile),
                'admin' => new AdminProfileResource($profile),
            },
            'token' => $token,
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
    }
}

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json([
                'message' => 'account not found',
            ]);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'Invalid credentials',
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => new UserResource($request->user()),
        ]);
    }
}
