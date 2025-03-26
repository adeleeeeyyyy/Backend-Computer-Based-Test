<?php

namespace App\Http\Controllers\API\Guru;

use App\Http\Controllers\Controller;
use App\Models\Tes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TesController extends Controller
{
    public function createTes(Request $request) {
        $request->validate([
            "judul"=> "required|string",
            "deskripsi"=> "required|string",
            "durasi_menit"=> "required|integer",
            "tanggal_mulai"=> "required|date",
            "tanggal_selesai"=> "required|date",
            "batas_percobaan"=> "required|integer",
            "password_tes"=> "required|string",
            "kategori"=> "required|string",
        ]);

        $tes = null;

        try {
            DB::transaction(function() use($request, &$tes) {
                Tes::create($request->all() + [
                    "kode_tes" => uniqid(),
                    "guru_id" => $request->user()->user_id,
                ]);
            });

        } catch (\Exception $e) {
        
        }
    }
}
