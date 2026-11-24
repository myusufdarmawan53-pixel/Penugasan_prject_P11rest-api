<?php

namespace App\Http\Controllers;

use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mahasiswa = Mahasiswa::all();
        return MahasiswaResource::collection($mahasiswa);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa',
            'nama' => 'required|string|max:100',
            'jk' => 'required|string|max:15',
            'tgl_lahir' => 'required|date',
            'jurusan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255'
        ]);
        $mahasiswa = Mahasiswa::create($request->all());
        return new MahasiswaResource($mahasiswa)
            ->additional([
                'success' => true,
                'message' => 'Data Mahasiswa Berhasil Ditambahkan'
            ]); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $mahasiswa = Mahasiswa::where('nim', $id)->orWhere('id', $id)->firstOrFail();
        return response()->json($mahasiswa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nama' => 'required|string|max:100',
            'jk' => 'required|string|max:15',
            'tgl_lahir' => 'required|date',
            'jurusan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255'
        ]);
        $mahasiswa = Mahasiswa::where('nim', $id)->orWhere('id', $id)->firstOrFail();
        $mahasiswa->update($request->all());
        return new MahasiswaResource($mahasiswa)
            ->additional([
                'success' => true,
                'message' => 'Data Mahasiswa Berhasil Diupdate'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $mahasiswa = Mahasiswa::where('nim', $id)->orWhere('id', $id)->firstOrFail();
        $mahasiswa->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa Berhasil Dihapus'
        ]);
    }
}

