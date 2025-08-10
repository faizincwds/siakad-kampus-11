<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kurikulum;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data kurikulum, urutkan berdasarkan tahun_mulai terbaru
        // Dengan relasi ProgramStudi untuk menampilkan nama Program Studi
        $kurikulums = Kurikulum::with('programStudi')->latest('tahun_mulai')->get();

        return view('admin.kurikulum.index', compact('kurikulums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil daftar Program Studi untuk dropdown
        $programStudis = ProgramStudi::orderBy('nama')->get();
        return view('admin.kurikulum.create', compact('programStudis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kurikulum' => 'required|string|max:100',
            'tahun_mulai' => 'required|string|digits:4',
            'tahun_selesai' => 'nullable|string|digits:4|after_or_equal:tahun_mulai',
            'deskripsi' => 'nullable|string',
            'program_studi_id' => 'required|uuid|exists:program_studi,id', // Validasi UUID dan keberadaan di tabel
            'is_aktif' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek keunikan kombinasi program_studi_id dan tahun_mulai
        $existingKurikulum = Kurikulum::where('program_studi_id', $request->program_studi_id)
                                      ->where('tahun_mulai', $request->tahun_mulai)
                                      ->first();

        if ($existingKurikulum) {
            return redirect()->back()->withErrors(['tahun_mulai' => 'Kurikulum untuk Program Studi ini dengan Tahun Mulai yang sama sudah ada.'])->withInput();
        }

        // Jika ada kurikulum lain yang aktif untuk prodi yang sama, non-aktifkan
        if ($request->boolean('is_aktif')) {
            Kurikulum::where('program_studi_id', $request->program_studi_id)
                     ->update(['is_aktif' => false]);
        }

        Kurikulum::create($request->all());

        return redirect()->route('admin.kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Kurikulum $kurikulum)
    {
        // Karena kita menggunakan UUID, Laravel akan otomatis menemukan model berdasarkan UUID di rute
        // Anda bisa memuat relasi jika diperlukan
        $kurikulum->load('programStudi'); // Memuat data Program Studi terkait
        return view('admin.kurikulum.show', compact('kurikulum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kurikulum $kurikulum)
    {
        $programStudis = ProgramStudi::orderBy('nama')->get();
        return view('admin.kurikulum.edit', compact('kurikulum', 'programStudis'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        $validator = Validator::make($request->all(), [
            'nama_kurikulum' => 'required|string|max:100',
            'tahun_mulai' => 'required|string|digits:4',
            'tahun_selesai' => 'nullable|string|digits:4|after_or_equal:tahun_mulai',
            'deskripsi' => 'nullable|string',
            'program_studi_id' => 'required|uuid|exists:program_studi,id',
            'is_aktif' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek keunikan kombinasi program_studi_id dan tahun_mulai, kecuali untuk kurikulum yang sedang diedit
        $existingKurikulum = Kurikulum::where('program_studi_id', $request->program_studi_id)
                                      ->where('tahun_mulai', $request->tahun_mulai)
                                      ->where('id', '!=', $kurikulum->id) // Abaikan kurikulum yang sedang diedit
                                      ->first();

        if ($existingKurikulum) {
            return redirect()->back()->withErrors(['tahun_mulai' => 'Kurikulum untuk Program Studi ini dengan Tahun Mulai yang sama sudah ada.'])->withInput();
        }

        // Jika kurikulum ini diatur aktif, non-aktifkan kurikulum lain yang aktif untuk prodi yang sama
        if ($request->boolean('is_aktif')) {
            Kurikulum::where('program_studi_id', $request->program_studi_id)
                     ->where('id', '!=', $kurikulum->id) // Jangan non-aktifkan diri sendiri
                     ->update(['is_aktif' => false]);
        }

        $kurikulum->update($request->all());

        return redirect()->route('admin.kurikulum.index')->with('success', 'Kurikulum berhasil diperbarui!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kurikulum $kurikulum)
    {
        // Anda bisa menambahkan logika cek di sini sebelum menghapus,
        // misal: apakah ada mata kuliah yang masih terhubung dengan kurikulum ini?
        // Namun, onDelete('restrict') di migrasi sudah membantu mencegah penghapusan jika ada FK.

        $kurikulum->delete();

        return redirect()->route('admin.kurikulum.index')->with('success', 'Kurikulum berhasil dihapus!');

    }
}
