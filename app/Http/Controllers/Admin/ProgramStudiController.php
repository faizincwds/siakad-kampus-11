<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan 'nama' untuk pengurutan
        $programStudis = ProgramStudi::with('fakultas')->latest()->get(); // Atau Anda bisa menggunakan ->orderBy('nama')

        return view('admin.program-studi.index', compact('programStudis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = Fakultas::orderBy('nama')->get(); // Pastikan nama kolom di model Fakultas sudah benar, misal 'nama'
        return view('admin.program-studi.create', compact('fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:program_studi,nama', // Ganti nama_prodi ke 'nama'
            'jenjang' => 'required|string|max:10',
            'kode' => 'nullable|string|max:10|unique:program_studi,kode',
            'fakultas_id' => 'required|uuid|exists:fakultas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProgramStudi::create($request->all());

        return redirect()->route('admin.program-studi.index')->with('success', 'Program Studi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramStudi $programStudi)
    {
        // dd($programStudi);
        $programStudi->load('fakultas');
        return view('admin.program-studi.show', compact('programStudi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramStudi $programStudi)
    {

        $fakultas = Fakultas::orderBy('nama')->get(); // Pastikan nama kolom di model Fakultas sudah benar
        return view('admin.program-studi.edit', compact('programStudi', 'fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramStudi $programStudi)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:program_studi,nama,' . $programStudi->id, // Ganti nama_prodi ke 'nama', abaikan ID saat ini
            'jenjang' => 'required|string|max:10',
            'kode' => 'nullable|string|max:10|unique:program_studi,kode,' . $programStudi->id,
            'fakultas_id' => 'required|uuid|exists:fakultas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $programStudi->update($request->all());

        return redirect()->route('admin.program-studi.index')->with('success', 'Program Studi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudi $programStudi)
    {
        // onDelete('cascade') di migrasi sudah menangani penghapusan Kurikulum dan Mata Kuliah terkait
        // Perhatian: Jika ada Mahasiswa yang terhubung, ini akan menyebabkan error foreign key.
        // Anda mungkin perlu menambahkan onDelete('cascade') di migration Mahasiswa,
        // atau menangani penghapusan Mahasiswa terkait di sini.
        try {
            $programStudi->delete();
            return redirect()->route('admin.program-studi.index')->with('success', 'Program Studi berhasil dihapus!');
        } catch (Exception $e) {
            // Log the error for debugging: \Log::error($e->getMessage());
            return redirect()->route('admin.program-studi.index')->with('error', 'Gagal menghapus program studi karena masih ada mahasiswa yang terkait. Harap hapus program studi pada mahasiswa terkait terlebih dahulu.');
        }
    }
}
