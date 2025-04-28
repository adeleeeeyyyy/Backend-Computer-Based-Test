<?php


namespace App\Http\Controllers\API\MonitoringAktivitas;
use App\Models\MonitoringAktivitas;
use App\Models\SesiTes;
use App\Models\SiswaProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonitoringAktivitasController extends Controller
{
   
    public function index()
    {
        $data = MonitoringAktivitas::with('sesi')->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $item = MonitoringAktivitas::with('sesi')->findOrFail($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {



        $request->validate([
            'sesi_id' => 'required|exists:sesi_tes,id',
            'jenis_aktivitas' => 'required|string',
            'waktu' => 'required|date',
            'screenshot' => 'nullable|string|max:255',
        ]);
        

        $data = MonitoringAktivitas::create($request->all());
        //cek apakah insert berhasil atau tidak
        if ($data) {
            return response()->json([
                'message' => 'Aktivitas berhasil ditambahkan',
                'data' => $data
            ], 201);
        } else {
            return response()->json([
                'message' => 'Aktivitas gagal ditambahkan'
            ], 500);
        }
    }

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
    public function destroy($id)
    {
        $data = MonitoringAktivitas::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Aktivitas berhasil dihapus'
        ]);
    }
    public function logAktivitasSiswa($sesi_id)
    {
        $sesi = SesiTes::with(['siswa', 'monitoringAktivitas'])->findOrFail($sesi_id);
        return response()->json($sesi);
    }
}
        
