<?php

namespace App\Http\Controllers\API\Guru;

use App\Http\Controllers\Controller;
use App\Models\JawabanPeserta;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $jawabanPeserta = DB::table('jawaban_pesertas as jp')
            ->join('pilihan_jawabans as pj', 'jp.jawaban', '=', 'pj.jawaban_id')
            ->select('jp.soal_id', 'jp.jawaban', 'pj.is_benar')
            ->where('jp.siswa_id', $siswa_id)
            ->where('jp.tes_id', $tes_id)
            ->get();

            $totalBenar = DB::table('jawaban_pesertas as jp')
            ->join('pilihan_jawabans as pj', 'jp.jawaban', '=', 'pj.jawaban_id')
            ->where('jp.siswa_id', $siswa_id)
            ->where('jp.tes_id', $tes_id)
            ->where('pj.is_benar', true)
            ->count();


            
            return response()->json([
                'success' => true,
                'message' => 'Data jawaban berhasil diambil', 
                'soal' => $soal,
                'jawaban' => $jawabanPeserta
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
