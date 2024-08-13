<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ambulan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AmbulansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::user()->id;
        $role = Auth::user()->role;
        if ($role == 'admin') {
            $data = Ambulan::leftJoin('users as u', 'u.id', '=', 'ambulan.id')
                ->select('ambulan.*', 'u.name', 'u.no_hp')
                ->get();
        } else {
            $data = Ambulan::leftJoin('users as u', 'u.id', '=', 'ambulan.id')
                ->select('ambulan.*', 'u.name', 'u.no_hp')
                ->where('ambulan.id', $id)
                ->get();
        }
        
        return view('admin.ambulan',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('', 'public'); 
            $gambar = $gambarPath;
        } else {
            $gambar = null;
        }

        if ($request->hasFile('surat_izin')) {
            $surat_izin = $request->file('surat_izin')->store('', 'public'); 
            $surat = $surat_izin;
        } else {
            $surat = null;
        }

        $fasilitas = $request->fasilitas;
        $lines = explode("\n", trim($fasilitas));
        $htmlList = '<ol>';
        foreach ($lines as $line) {
            $line = preg_replace('/^\d+\.\s*/', '', trim($line));
            if ($line !== '') {
                $htmlList .= '<li>' . htmlspecialchars($line) . '</li>';
            }
        }
        $htmlList .= '</ol>';
        
        $data = Ambulan::create([
            'id' => Auth::user()->id,
            'no_plat' => $request->no_plat,
            'biaya' => $request->biaya,
            'lokasi' => $request->lokasi,
            'milik' => $request->milik,
            'fasilitas' => $htmlList,
            'surat_izin' => $surat,
            'gambar' => $gambar

        ]);

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Sukses Memasukkan Data',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Ambulan::findOrFail($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->ambulan_id;
        $data = Ambulan::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data Driver tidak ditemukan',
            ]);
        }

        $fasilitas = $request->fasilitas;
        $lines = explode("\n", trim($fasilitas));
        $htmlList = '<ol>';
        foreach ($lines as $line) {
            $line = preg_replace('/^\d+\.\s*/', '', trim($line));
            if ($line !== '') {
                $htmlList .= '<li>' . htmlspecialchars($line) . '</li>';
            }
        }
        $htmlList .= '</ol>';
        $data->update([
            'id' => Auth::user()->id,
            'no_plat' => $request->no_plat,
            'biaya' => $request->biaya,
            'lokasi' => $request->lokasi,
            'milik' => $request->milik,
            'fasilitas' => $htmlList
        ]);
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('', 'public'); 
            $data->update([
                'gambar' => $gambarPath
            ]);
        } 
        if ($request->hasFile('surat_izin')) {
            $surat = $request->file('surat_izin')->store('', 'public'); 
            $data->update([
                'surat_izin' => $surat
            ]);
        } 

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Sukses Mengubah Data',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Mengubah data',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Ambulan::find($id);

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses Melakukan delete Data',
        ]);
    }


    public function detail($id)
    {
        $data=Ambulan::leftjoin('users as u','u.id','=','ambulan.id')
        ->select('ambulan.*','u.name','u.no_hp')
        ->where('ambulan.ambulan_id',$id)
        ->first();
        return view('landingPage.detail_ambulan',compact('data'));
    }
    public function getAddress($latitude, $longitude)
    {
        $apiKey = config('services.google_maps.key'); 
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
            'latlng' => "{$latitude},{$longitude}",
            'key' => $apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['results'][0])) {
                return $data['results'][0]['formatted_address'];
            }
        }

        return 'Address not found';
    }
    public function filterByLocation(Request $request)
    {
        $location = $request->input('location');
        list($latitude, $longitude) = explode(',', $location);

        $data = Ambulan::select('ambulan.*', DB::raw("
            (6371 * acos(cos(radians($latitude)) 
            * cos(radians(SUBSTRING_INDEX(lokasi, ',', 1))) 
            * cos(radians(SUBSTRING_INDEX(lokasi, ',', -1)) 
                - radians($longitude)) 
            + sin(radians($latitude)) 
            * sin(radians(SUBSTRING_INDEX(lokasi, ',', 1))))) as distance"))
            ->where('status', 'Diterima')
            ->orderBy('distance')
            ->get();

        return response()->json($data);
        ///testing
    }
}
