<?php

namespace App\Http\Controllers\API\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JawabanController extends Controller
{
    public function createJawaban(Request $request, $soal_id) {
        $request->validate([
            "jawaban" => "required|array",
            "jawaban.*.teks_pilihan" => "required|string",
            "jawaban.*.is_benar"=> "required|boolean",
        ]);

        try {
            DB::transaction(function () use ($request, $soal_id) {
                foreach ($request->jawaban as $jawaban) {
                    $jawaban_id = uniqid('jawaban_');
                    DB::table('pilihan_jawabans')->insert([
                        'jawaban_id' => $jawaban_id,
                        'soal_id' => $soal_id,
                        'teks_pilihan' => $jawaban['teks_pilihan'],
                        'is_benar' => $jawaban['is_benar'],
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil ditambahkan',
                'data' => $request->jawaban
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateJawaban(Request $request, $jawaban_id) {
        $request->validate([
            "teks_pilihan" => "required|string",
            "is_benar" => "required|boolean",
        ]);

        try {
            DB::transaction(function () use ($request, $jawaban_id) {
                DB::table('pilihan_jawabans')->where('jawaban_id', $jawaban_id)->update([
                    'teks_pilihan' => $request->teks_pilihan,
                    'is_benar' => $request->is_benar,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil diperbarui',
                'data' => $request->only(['jawaban_id', 'teks_pilihan', 'is_benar'])
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function deleteJawaban(Request $request, $jawaban_id) {
        try {
            DB::transaction(function () use ($request, $jawaban_id) {
            DB::table('pilihan_jawabans')->where('jawaban_id', $jawaban_id)->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil dihapus'
            ], 200);            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);    
        }
    }
    

    public function seeAllJawabans($soal_id) {
        try {
            $jawabans = DB::table('pilihan_jawabans')->where('soal_id', $soal_id)->get();
            
            $jawabans = $jawabans->map(function ($jawaban) {
                return [
                    'jawaban_id' => $jawaban->jawaban_id,
                    'soal_id' => $jawaban->soal_id,
                    'teks_pilihan' => $jawaban->teks_pilihan,
                    'is_benar' => $jawaban->is_benar,
                ];
            })->toArray();
            
            return response()->json([
                'success' => true,
                'data' => $jawabans
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data jawaban'
            ], 400);
        }
    }
}
