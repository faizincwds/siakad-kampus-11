<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Kurikulum;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data mata kuliah dengan relasi ProgramStudi
        $mataKuliahs = MataKuliah::with('programStudi')->latest()->get();

        return view('admin.mata-kuliah.index', compact('mataKuliahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudis = ProgramStudi::orderBy('nama')->get();
        // Anda mungkin ingin menampilkan kurikulum aktif atau semua kurikulum
        // Untuk saat ini, kita ambil semua kurikulum.
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();

        return view('admin.mata-kuliah.create', compact('programStudis', 'kurikulums'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_mk' => 'required|string|max:20|unique:mata_kuliah,kode_mk',
            'nama_mk' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:9',
            'semester' => 'required|integer|min:1|max:14', // Asumsi semester max 14
            'jenis_mata_kuliah' => 'nullable|in:Wajib,Pilihan',
            'deskripsi' => 'nullable|string',
            'program_studi_id' => 'required|uuid|exists:program_studi,id',
            'kurikulum_ids' => 'nullable|array', // Array UUIDs untuk relasi many-to-many
            'kurikulum_ids.*' => 'uuid|exists:kurikulum,id', // Validasi setiap item dalam array
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mataKuliah = MataKuliah::create($request->except('kurikulum_ids'));

        // Attach kurikulum to mata kuliah (many-to-many)
        if ($request->has('kurikulum_ids')) {
            // Jika ada data tambahan di pivot (seperti semester_ditawarkan, status_mk)
            // Anda perlu loop atau menggunakan data yang lebih terstruktur dari form
            // Untuk saat ini, kita asumsikan hanya attachment sederhana tanpa pivot data spesifik
            $mataKuliah->kurikulum()->attach($request->input('kurikulum_ids'));
            // Jika Anda perlu data pivot, form harus mengirimkan array asosiatif:
            // $mataKuliah->kurikulum()->attach([
            //     'kurikulum_id_1' => ['semester_ditawarkan' => 'Ganjil', 'status_mk' => 'Wajib'],
            //     'kurikulum_id_2' => ['semester_ditawarkan' => 'Genap', 'status_mk' => 'Pilihan'],
            // ]);
        }

        return redirect()->route('admin.mata-kuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(MataKuliah $mataKuliah)
    {
        $mataKuliah->load('programStudi', 'kurikulum'); // Muat relasi
        return view('admin.mata-kuliah.show', compact('mataKuliah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataKuliah $mataKuliah)
    {
        $programStudis = ProgramStudi::orderBy('nama')->get();
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();
        // Ambil ID kurikulum yang sudah terhubung dengan mata kuliah ini
        $selectedKurikulumIds = $mataKuliah->kurikulum->pluck('id')->toArray();

        return view('admin.mata-kuliah.edit', compact('mataKuliah', 'programStudis', 'kurikulums', 'selectedKurikulumIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validator = Validator::make($request->all(), [
            'kode_mk' => 'required|string|max:20|unique:mata_kuliah,kode_mk,' . $mataKuliah->id, // Abaikan ID saat ini
            'nama_mk' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:9',
            'semester' => 'required|integer|min:1|max:14',
            'jenis_mata_kuliah' => 'nullable|in:Wajib,Pilihan',
            'deskripsi' => 'nullable|string',
            'program_studi_id' => 'required|uuid|exists:program_studi,id',
            'kurikulum_ids' => 'nullable|array',
            'kurikulum_ids.*' => 'uuid|exists:kurikulum,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mataKuliah->update($request->except('kurikulum_ids'));

        // Sync kurikulum (many-to-many), ini akan menambahkan/menghapus relasi sesuai input
        // Seperti di store, jika ada data pivot, Anda perlu array asosiatif
        $mataKuliah->kurikulum()->sync($request->input('kurikulum_ids', []));

        return redirect()->route('admin.mata-kuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $mataKuliah)
    {

        try {
            // Detach relasi pivot sebelum menghapus mata kuliah jika onDelete di pivot bukan cascade
            $mataKuliah->kurikulum()->detach();

            $mataKuliah->delete();

            return redirect()->route('admin.mata-kuliah.index')->with('success', 'Data Mata Kuliah berhasil dihapus!');
        } catch (Exception $e) {
            // Log the error for debugging: \Log::error($e->getMessage());
            return redirect()->route('admin.mata-kuliah.index')->with('error', 'Gagal menghapus mata kuliah. Mungkin ada data terkait yang harus dihapus terlebih dahulu.');
        }
    }
}
