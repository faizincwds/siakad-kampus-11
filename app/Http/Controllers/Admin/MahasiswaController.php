<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::with('programStudi')->latest()->get(); // Load relasi programStudi
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudis = ProgramStudi::orderBy('nama')->get(); // Ambil semua Program Studi
        return view('admin.mahasiswa.create', compact('programStudis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:mahasiswa,email',
            'program_studi_id' => 'required|uuid|exists:program_studi,id', // Required sesuai migration
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Mahasiswa::create($request->all());

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa) // Parameter otomatis di-bind oleh Laravel
    {
        $mahasiswa->load('programStudi'); // Load relasi programStudi
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa) // Parameter otomatis di-bind oleh Laravel
    {
        $programStudis = ProgramStudi::orderBy('nama')->get(); // Ambil semua Program Studi
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'programStudis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa) // Parameter otomatis di-bind oleh Laravel
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $mahasiswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,
            'program_studi_id' => 'required|uuid|exists:program_studi,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mahasiswa->update($request->all());

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa) // Parameter otomatis di-bind oleh Laravel
    {
        try {
            $mahasiswa->delete();
            return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa berhasil dihapus!');
        } catch (Exception $e) {
            // Log the error for debugging: \Log::error($e->getMessage());
            return redirect()->route('admin.mahasiswa.index')->with('error', 'Gagal menghapus mahasiswa. Mungkin ada data terkait yang harus dihapus terlebih dahulu.');
        }
    }
}
