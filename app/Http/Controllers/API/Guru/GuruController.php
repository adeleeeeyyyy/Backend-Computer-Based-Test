<?php

namespace App\Http\Controllers\API\Guru;

use App\Http\Controllers\Controller;
use App\Models\JawabanPeserta;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function nilaiTesPilihanGanda($siswa_id, $tes_id) {
        try {
            $soal = Soal::where('tes_id', '=', $tes_id)->get();
            $jawaban = JawabanPeserta::where('siswa_id', '=', $siswa_id)->where('tes_id', '=', $tes_id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Data jawaban berhasil diambil',
                'soal' => $soal,
                'jawaban' => $jawaban
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data jawaban',
                'data' => $e->getMessage()
            ], 400);
        }
    }
}
