<?php

namespace App\Http\Controllers\API\Guru;

use App\Http\Controllers\Controller;
use App\Models\Tes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TesResource;

class TesController extends Controller
{
    public function createTes(Request $request) {
        $request->validate([
            "judul"=> "required|string",
            "deskripsi"=> "required|string",
            "jam_mulai"=> "required|string",
            "durasi_menit"=> "required|integer",
            "tanggal_mulai"=> "required|date",
            "tanggal_selesai"=> "required|date",
            "batas_percobaan"=> "required|integer",
            "password_tes"=> "required|string",
            "semester"=> "required|integer",
            "jenis_ujian"=> "required|string",
            "kelas"=> "required|array",
            "kelas.*"=> "required|string",
            "mapel"=> "required|string",
        ]);

            $tes = null;
            DB::transaction(function() use($request, &$tes) {
                $user = auth()->user()->guru_profile_id;

                $int = mt_rand(100000, 999999);
                $kode_tes = "$request->jenis_ujian$request->semester-$request->mapel-". $int;
            
                $tes = Tes::create([
                    "tes_id" => uniqid("tes_"),
                    "kode_tes" => $kode_tes,
                    "guru_id" => $user,
                    "judul" => $request->judul,
                    "deskripsi" => $request->deskripsi,
                    "jam_mulai" => $request->jam_mulai,
                    "durasi_menit" => $request->durasi_menit,
                    "tanggal_mulai" => $request->tanggal_mulai,
                    "tanggal_selesai" => $request->tanggal_selesai,
                    "batas_percobaan" => $request->batas_percobaan,
                    "password_tes" => $request->password_tes,
                    "semester" => $request->semester,
                    "jenis_ujian" => $request->jenis_ujian,
                    "mapel" => $request->mapel,
                    "kelas" => $request->kelas, // Simpan sebagai JSON
                ]);
            });
            return response()->json([
                'success' => true,
                'data' => $tes
            ]);
    }

}
