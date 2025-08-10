<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Menampilkan daftar semua ruangan.
     */
    public function index()
    {
        $rooms = Room::all(); // Ambil semua data ruangan
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Menampilkan form untuk membuat ruangan baru.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Menyimpan ruangan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:rooms,name',
            'code' => 'required|string|max:50|unique:rooms,code',
            'capacity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Buat ruangan baru
        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail ruangan spesifik.
     */
    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Menampilkan form untuk mengedit ruangan.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Memperbarui data ruangan di database.
     */
    public function update(Request $request, Room $room)
    {
        // Validasi input, abaikan nama dan kode saat ini milik ruangan yang sedang diedit
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'code' => 'required|string|max:50|unique:rooms,code,' . $room->id,
            'capacity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Perbarui data ruangan
        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil diperbarui!');
    }

    /**
     * Menghapus ruangan dari database.
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil dihapus!');
        } catch (Exception $e) {
            // Tangani jika ada relasi yang menghalangi penghapusan (misal: masih terhubung ke kelas/jadwal)
            return redirect()->back()->with('error', 'Ruangan tidak dapat dihapus karena masih digunakan dalam kelas/jadwal atau relasi lain.');
        }
    }
}
