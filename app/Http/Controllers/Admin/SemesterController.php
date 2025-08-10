<?php

namespace App\Http\Controllers\Admin;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesters = Semester::orderBy('tahun_akademik', 'desc')
                               ->orderByRaw("FIELD(jenis_semester, 'Ganjil', 'Genap', 'Pendek')") // Order berdasarkan jenis semester
                               ->get();
        return view('admin.semesters.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisSemesters = ['Ganjil', 'Genap', 'Pendek'];
        return view('admin.semesters.create', compact('jenisSemesters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string|max:20',
            'jenis_semester' => ['required', Rule::in(['Ganjil', 'Genap', 'Pendek'])],
            'nama_semester' => 'required|string|max:100|unique:semesters,nama_semester',
            'is_active' => 'boolean',
        ]);

        // Jika is_active diset true, nonaktifkan semester lain
        if (isset($validated['is_active']) && $validated['is_active']) {
            Semester::where('is_active', true)->update(['is_active' => false]);
        }

        $semester = Semester::create($validated);

        return redirect()->route('admin.semesters.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Semester $semester)
    {
        return view('admin.semesters.show', compact('semester'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semester $semester)
    {
        $jenisSemesters = ['Ganjil', 'Genap', 'Pendek'];
        return view('admin.semesters.edit', compact('semester', 'jenisSemesters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string|max:20',
            'jenis_semester' => ['required', Rule::in(['Ganjil', 'Genap', 'Pendek'])],
            'nama_semester' => ['required', 'string', 'max:100', Rule::unique('semesters', 'nama_semester')->ignore($semester->id)],
            'is_active' => 'boolean',
        ]);

        // Jika is_active diset true, nonaktifkan semester lain
        if (isset($validated['is_active']) && $validated['is_active']) {
            Semester::where('is_active', true)->where('id', '!=', $semester->id)->update(['is_active' => false]);
        }

        $semester->update($validated);

        return redirect()->route('admin.semesters.index')->with('success', 'Semester berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        if ($semester->is_active) {
            return redirect()->route('admin.semesters.index')->with('error', 'Tidak dapat menghapus semester aktif. Nonaktifkan terlebih dahulu.');
        }

        $semester->delete();
        return redirect()->route('admin.semesters.index')->with('success', 'Semester berhasil dihapus.');
    }

    /**
     * Set the specified semester as active and deactivate others.
     */
    public function setActive(Request $request, Semester $semester)
    {
        // Nonaktifkan semua semester lain
        Semester::where('is_active', true)->where('id', '!=', $semester->id)->update(['is_active' => false]);

        // Aktifkan semester yang dipilih
        $semester->is_active = true;
        $semester->save();

        return redirect()->route('admin.semesters.index')->with('success', 'Semester "' . $semester->nama_semester . '" berhasil diaktifkan.');
    }
}
