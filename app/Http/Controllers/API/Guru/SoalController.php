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
    }
}
