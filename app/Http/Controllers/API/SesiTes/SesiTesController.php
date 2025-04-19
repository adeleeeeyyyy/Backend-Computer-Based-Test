<?php
// app/Http/Controllers/SesiTesController.php

namespace App\Http\Controllers\API\SesiTes;
use App\Http\Controllers\Controller;
use App\Models\SesiTes;
use App\Models\SiswaProfile;
use App\Models\Tes;
use Illuminate\Http\Request;

class SesiTesController extends Controller
{
    //r
    public function index()
    {
        $sesiTes = SesiTes::with(['siswa', 'tes', 'monitoringAktivitas'])->get();
        return response()->json($sesiTes);
    }

    //r id siswa
    public function show($id)
    {
        $sesi = SesiTes::with(['siswa', 'tes', 'monitoringAktivitas'])->findOrFail($id);
        return response()->json($sesi);
    }
    //create 
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa_profile,id',
            'tes_id' => 'required|exists:tes,id',
            'waktu_mulai' => 'nullable|date',
            'waktu_selesai' => 'nullable|date',
            'status' => 'nullable|string',
            'ip_address' => 'nullable|string|max:45',
            'browser' => 'nullable|string|max:100',
        ]);

        $sesi = SesiTes::create($request->all());

        return response()->json([
            'message' => 'Sesi tes berhasil dibuat',
            'data' => $sesi
        ], 201);
    }
   
    public function update(Request $request, $id)
    {
        $sesi = SesiTes::findOrFail($id);

        $sesi->update($request->only([
            'waktu_mulai',
            'waktu_selesai',
            'status',
            'ip_address',
            'browser',
        ]));

        return response()->json([
            'message' => 'Sesi tes berhasil diperbarui',
            'data' => $sesi
        ]);
    }
    
    //delete
    public function destroy($id)
    {
        $sesi = SesiTes::findOrFail($id);
        $sesi->delete();

        return response()->json([
            'message' => 'Sesi tes berhasil dihapus'
        ]);
    }
}
