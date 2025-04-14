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
            DB::beginTransaction();

            $existingJawaban = DB::table('jawaban_pesertas')
                ->where('siswa_id', $siswa)
                ->where('tes_id', $tes_id)
                ->where('soal_id', $soal_id)
                ->where('jawaban', $jawaban_id)
                ->first();

            if ($existingJawaban) {
                DB::rollBack();

                return response()->json([
                    'success' => true,
                    'message' => 'Jawaban sudah ada'
                ], 200);
            }

            $pilihanJawaban = DB::table('pilihan_jawabans')
                ->where('jawaban_id', $jawaban_id)
                ->where('soal_id', $soal_id)
                ->first();

            if (!$pilihanJawaban) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Jawaban yang diberikan tidak memiliki soal_id yang sesuai'
                ], 400);
            }

            DB::table('jawaban_pesertas')->insert([
                "siswa_id" => $siswa,
                "tes_id" => $tes_id,
                "soal_id" => $soal_id,
                "jawaban" => $jawaban_id
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil dikirim'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
