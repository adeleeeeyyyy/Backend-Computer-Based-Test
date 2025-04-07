<?php
// app/Http/Controllers/MonitoringAktivitasController.php

namespace App\Http\Controllers;

use App\Models\MonitoringAktivitas;
use Illuminate\Http\Request;

class MonitoringAktivitasController extends Controller
{
    // Menampilkan semua data monitoring
    public function index()
    {
        $data = MonitoringAktivitas::with('sesi')->get();
        return response()->json($data);
    }

    // Menampilkan monitoring berdasarkan ID
    public function show($id)
    {
        $item = MonitoringAktivitas::with('sesi')->findOrFail($id);
        return response()->json($item);
    }

    // Menyimpan data baru monitoring aktivitas
    public function store(Request $request)
    {
        $request->validate([
            'sesi_id' => 'required|exists:sesi_tes,id',
            'jenis_aktivitas' => 'required|string',
            'waktu' => 'required|date',
            'screenshot' => 'nullable|string|max:255',
        ]);

        $data = MonitoringAktivitas::create($request->all());

        return response()->json([
            'message' => 'Aktivitas berhasil ditambahkan',
            'data' => $data
        ], 201);
    }

    // Mengupdate data monitoring
    public function update(Request $request, $id)
    {
        $data = MonitoringAktivitas::findOrFail($id);

        $data->update($request->only([
            'jenis_aktivitas',
            'waktu',
            'screenshot',
        ]));

        return response()->json([
            'message' => 'Aktivitas berhasil diperbarui',
            'data' => $data
        ]);
    }

    // Menghapus data monitoring
    public function destroy($id)
    {
        $data = MonitoringAktivitas::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Aktivitas berhasil dihapus'
        ]);
    }
}
        
