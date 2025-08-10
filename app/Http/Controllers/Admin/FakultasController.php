<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek apakah user memiliki izin tertentu (melalui perannya). Gate::allows() atau Gate::denies()
        if (!Gate::allows('permission', 'view fakultas')) {
            abort(403);
        }
        $fakultas = Fakultas::latest()->get();
        return view('admin.fakultas.index', compact('fakultas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fakultas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:fakultas,nama', // Menggunakan 'nama'
            'kode' => 'nullable|string|max:10|unique:fakultas,kode',   // Menggunakan 'kode'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Fakultas::create($request->all());

        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fakultas $fakulta)
    {
        // dd($fakulta);
        // Memuat relasi programStudis agar bisa ditampilkan di view
        $fakultas = $fakulta->load('programStudis'); // Ini memanggil metode programStudis() di model Fakultas

        return view('admin.fakultas.show', compact('fakultas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fakultas $fakulta)
    {
        $fakultas = $fakulta;
        return view('admin.fakultas.edit', compact('fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fakultas $fakulta)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:fakultas,nama,' . $fakulta->id, // Menggunakan 'nama'
            'kode' => 'nullable|string|max:10|unique:fakultas,kode,' . $fakulta->id,   // Menggunakan 'kode'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fakulta->update($request->all());

        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fakultas $fakulta)
    {
        // Perhatian: Jika ada Program Studi yang terhubung, ini akan menyebabkan error foreign key.
        // Anda mungkin perlu menambahkan onDelete('cascade') di migration ProgramStudi,
        // atau menangani penghapusan Program Studi terkait di sini.
        try {
            $fakulta->delete();
            return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil dihapus!');
        } catch (Exception $e) {
            // Log the error for debugging: \Log::error($e->getMessage());
            return redirect()->route('admin.fakultas.index')->with('error', 'Gagal menghapus fakultas karena masih ada program studi yang terkait. Harap hapus program studi terkait terlebih dahulu.');
        }
    }
}
