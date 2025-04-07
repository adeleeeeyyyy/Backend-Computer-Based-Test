<?php

namespace App\Http\Controllers\API\Siswa;
use App\Http\Controllers\Controller;
use App\Models\SiswaProfile;

class SiswaController extends Controller
{
    public function index() {
        $siswa = SiswaProfile::with("user")->get();
        return response()->json([
            "status" => true,
            "message" => "Data Siswa Berhasil Diambil",
            "data" => $siswa
        ], 200);
    }

    public function show($id) {
        $siswa = SiswaProfile::with("user")->find($id);
        if ($siswa) {
            return response()->json([
                "status" => true,
                "message" => "Data Siswa Berhasil Diambil",
                "data" => $siswa
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Data Siswa Tidak Ditemukan",
            ], 404);
        }
    }
    public function store(Request $request) {
        $siswa = SiswaProfile::create($request->all());
        return response()->json([
            "status" => true,
            "message" => "Data Siswa Berhasil Ditambahkan",
            "data" => $siswa
        ], 201);
    }
    public function update(Request $request, $id) {
        $siswa = SiswaProfile::find($id);
        if ($siswa) {
            $siswa->update($request->all());
            return response()->json([
                "status" => true,
                "message" => "Data Siswa Berhasil Diupdate",
                "data" => $siswa
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Data Siswa Tidak Ditemukan",
            ], 404);
        }
    }
    public function destroy($id) {
        $siswa = SiswaProfile::find($id);
        if ($siswa) {
            $siswa->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Siswa Berhasil Dihapus",
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Data Siswa Tidak Ditemukan",
            ], 404);
        }
    }
}
// Compare this snippet from app/Models/SiswaProfile.php: