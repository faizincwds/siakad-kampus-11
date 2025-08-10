<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosen = Dosen::with('programStudi')->latest()->get(); // Load relasi programStudi
        return view('admin.dosen.index', compact('dosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudis = ProgramStudi::orderBy('nama')->get(); // Ambil semua Program Studi
        return view('admin.dosen.create', compact('programStudis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nidn' => 'required|string|max:20|unique:dosen,nidn',
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P', // Sesuaikan dengan ENUM 'L' atau 'P'
            'alamat' => 'nullable|string|max:255', // Max 255 sesuai migration
            'nomor_telepon' => 'nullable|string|max:20', // Max 20 sesuai migration
            'email' => 'nullable|email|max:255|unique:dosen,email', // Email bisa nullable tapi unik
            'program_studi_id' => 'nullable|uuid|exists:program_studi,id', // Validasi foreign key
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Dosen::create($request->all());

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        $dosen->load('programStudi'); // Load relasi programStudi
        return view('admin.dosen.show', compact('dosen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        $programStudis = ProgramStudi::orderBy('nama')->get(); // Ambil semua Program Studi
        return view('admin.dosen.edit', compact('dosen', 'programStudis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $validator = Validator::make($request->all(), [
            'nidn' => 'required|string|max:20|unique:dosen,nidn,' . $dosen->id,
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:dosen,email,' . $dosen->id,
            'program_studi_id' => 'nullable|uuid|exists:program_studi,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dosen->update($request->all());

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        try {
            $dosen->delete();
            return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil dihapus!');
        } catch (Exception $e) {
            // Log the error for debugging: \Log::error($e->getMessage());
            return redirect()->route('admin.dosen.index')->with('error', 'Gagal menghapus dosen. Mungkin ada data terkait yang harus dihapus terlebih dahulu.');
        }
    }
}
