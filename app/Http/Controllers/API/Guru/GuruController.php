<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuruController extends Controller
{
    public function seeSiswa() {
        try {
            $siswa = User::select('id', 'username', 'email', 'role', 'status', 'siswa_profile_id')->where('role', '=', 'siswa')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diambil',
                'data' => $siswa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data siswa',
                'data' => $e->getMessage()
            ], 400);
        }
    }

    public function seeSiswaByClass($class) {
        try {
            $siswa = User::select('users.id', 'users.username', 'users.email', 'users.role', 'users.status', 'users.siswa_profile_id')
                ->join('siswa_profiles', 'users.siswa_profile_id', '=', 'siswa_profiles.user_id')
                ->where('users.role', '=', 'siswa')
                ->where('siswa_profiles.kelas', '=', $class)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diambil',
                'data' => $siswa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data siswa',
                'data' => $e->getMessage()
            ], 400);
        }
    }
}
