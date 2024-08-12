<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ambulan;


class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=User::where('role','driver')->get();
        return view('admin.driver',compact('data'));
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
       $data = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'no_hp' => $request->no_hp,
            'password' => $request->password,
            'role' => 'driver'
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
        $data = User::findOrFail($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data Driver tidak ditemukan',
            ]);
        }
         $data->update([
            'name' => $request->name,
            'username' => $request->username,
            'no_hp' => $request->no_hp
        ]);

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
        $data = User::find($id);

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


    public function konfirmasi()
    {
        $data=Ambulan::leftjoin('users as u','u.id','=','ambulan.id')
        ->select('ambulan.*','u.*')
        ->get();
        return view('admin.konfirmasi_driver',compact('data'));
    }

    public function approval(Request $request)
    {
        $id = $request->ambulan_id;
        $data = Ambulan::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data Ambulan tidak ditemukan',
            ]);
        }
         $data->update([
            'status' => $request->status
        ]);

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
}
