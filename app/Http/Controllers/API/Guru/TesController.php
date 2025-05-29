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
        try {
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

                return $tes;
            });
            return new TesResource(true, 'Berhasil membuat tes', $tes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateTes(Request $request, $tes_id) {
        try {
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

            $user = auth()->user()->guru_profile_id;
            $tes = Tes::where('tes_id', '=', $tes_id)->where('guru_id', '=', $user)->first();

            if (!$tes) {
                return new TesResource(false, 'Anda tidak memiliki akses untuk mengupdate tes ini', null);
            }
            
            $tes = DB::transaction(function() use($request, $tes) {
                $tes->update([
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
                return $tes;
            });
            return new TesResource(true, 'Tes berhasil diupdate', $tes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function showTes() {
        try {
            $user = auth()->user()->guru_profile_id;
            $tes = Tes::where('guru_id', '=', $user)->get();
            return new TesResource(true, 'Data tes berhasil diambil', $tes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function showTesById($tes_id) {    
        try {
            $tes = Tes::where('tes_id', '=', $tes_id)->first();
            return new TesResource(true, 'Data tes berhasil diambil', $tes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function setStatus(Request $request, $tes_id) {
        try {
            $request->validate([
                "status"=> "required|string",
            ]);
            $user = auth()->user()->guru_profile_id;
            $tes = Tes::where('tes_id', '=', $tes_id)->where('guru_id', '=', $user)->first();

            if (!$tes) {
                return new TesResource(false, 'Anda tidak memiliki akses untuk mengupdate status tes ini', null);
            }

            $tes = DB::transaction(function() use($request, $tes) {
                $tes->update([
                    "status" => $request->status,
                ]);
                return $tes;
            });
            return new TesResource(true, 'Status tes berhasil diupdate', $tes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function deleteTes($tes_id) {
        try {
            $user = auth()->user()->guru_profile_id;
            $tes = Tes::where('tes_id', '=', $tes_id)->where('guru_id', '=', $user)->first();

            if (!$tes) {
                return new TesResource(false, 'Anda tidak memiliki akses untuk menghapus tes ini', null);
            }

            $tes = DB::transaction(function() use($tes) {
                $tes->delete();
                return $tes;
            });
            return new TesResource(true, 'Tes berhasil dihapus', $tes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function deleteAllTes() {
        $tes = DB::transaction(function() {
            $tes = Tes::all();
            foreach ($tes as $t) {
                $t->delete();
            }
            return $tes;
        });
        return response()->json([
            'success' => true,
            'data' => $tes
        ]);
    }

}
