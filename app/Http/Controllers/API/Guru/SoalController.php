<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tes;

class SoalController extends Controller
{
    public function createSoal(Request $request, $tes_id) {
        $request->validate([
            'jenis_soal' => 'required|string',
            'pertanyaan' => 'required|string',
            'file_gambar'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'poin' => 'required|integer',
        ]);

        $soal = DB::transaction(function () use ($tes_id, $request) {
            $user = auth()->user()->guru_profile_id;
            if ($user == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum login'
                ], 400);
            };

            $soal_id = uniqid('soal_');

            $file_gambar = $request->file('file_gambar')->store('gambar_soal', 'public');
            return Soal::create([
                'jenis_soal' => $request->jenis_soal,
                'pertanyaan' => $request->pertanyaan,
                'file_gambar' => $file_gambar,
                'poin' => $request->poin,
                'tes_id' => $tes_id,
                'soal_id' => $soal_id
            ]);
        });
        return response()->json([
            'success'=> true,
            'data' => $soal->only('pertanyaan', 'soal_id', 'jenis_soal', 'file_gambar', 'poin')
        ], 201);
    }

    public function showSoal($tes_id) {
        $soal = Soal::where('tes_id', '=', $tes_id)->get();
        return response()->json([
            'success' => true,
            'data' => $soal
        ], 200);
    }

    public function deleteAllSoal($tes_id) {
        $soals = Soal::where('tes_id', '=', $tes_id)->get();
        foreach ($soals as $soal) {
            $soal->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Semua soal sudah dihapus'
        ], 200);
    }

    public function deleteSoalById(Request $request, $soal_id) {
        $soal = Soal::where("soal_id", '=', $soal_id)->first();

        if (!$soal) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan atau tidak termasuk dalam tes ini'
            ], 404);
        }

        $soal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Soal sukse dihapus'
        ], 200);
    }

    public function updateSoal(Request $request, $soal_id) {
        $request->validate([
            'jenis_soal' => 'nullable|string',
            'pertanyaan' => 'nullable|string',
            'file_gambar'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'poin' => 'nullable|integer',
        ]);

        $soal = Soal::where('soal_id', '=', $soal_id)->first();

        if (!$soal) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan'
            ], 404);
        }

        // Update jika disediakan dalam permintaan
        if ($request->has('jenis_soal')) {
            $soal->jenis_soal = $request->jenis_soal;
        }

        if ($request->has('pertanyaan')) {
            $soal->pertanyaan = $request->pertanyaan;
        }

        if ($request->has('poin')) {
            $soal->poin = $request->poin;
        }

        // Menangani unggahan file jika gambar baru disediakan
        if ($request->hasFile('file_gambar')) {
            $file_gambar = $request->file('file_gambar')->store('gambar_soal', 'public');
            $soal->file_gambar = $file_gambar;
        }

        $soal->save();

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil diperbarui',
            'data' => $soal->only('pertanyaan', 'soal_id', 'jenis_soal', 'file_gambar', 'poin')
        ], 200);
    }

}
