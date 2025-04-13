<?php

namespace App\Http\Controllers\API\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function sendJawabanPilihanGanda(Request $request, $tes_id, $soal_id, $jawaban_id) {
        $siswa = auth()->user()->siswa_profile_id;

        try {
            DB::transaction(function () use ($request, $siswa, $tes_id, $soal_id, $jawaban_id) {
                DB::table('jawaban_pesertas')->insert([
                    "siswa_id" => $siswa,
                    "tes_id" => $tes_id,
                    "soal_id" => $soal_id,
                    "jawaban" => $jawaban_id
                ]);
            });
            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil dikirim'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
