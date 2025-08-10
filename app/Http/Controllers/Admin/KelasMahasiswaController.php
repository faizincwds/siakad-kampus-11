<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KelasMahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang terdaftar di kelas tertentu.
     */
    public function index(Kelas $kela)
    {
        $kelas = $kela;
        // Load relasi mahasiswa untuk kelas ini
        $kelas->load('mahasiswas');

        // Ambil semua mahasiswa yang BELUM terdaftar di kelas ini
        $enrolledMahasiswaIds = $kelas->mahasiswas->pluck('id')->toArray();
        $availableMahasiswa = Mahasiswa::whereNotIn('id', $enrolledMahasiswaIds)
                                      ->orderBy('nama_lengkap')
                                      ->get();
        // dd($availableMahasiswa);

        return view('admin.kelas.mahasiswa.index', compact('kelas', 'availableMahasiswa'));
    }

    /**
     * Menambahkan mahasiswa ke kelas.
     */
    public function store(Request $request, Kelas $kela)
    {
        $kelas = $kela;
        $request->validate([
            'mahasiswa_id' => [
                'required',
                'uuid',
                Rule::exists('mahasiswa', 'id'),
                // Pastikan mahasiswa belum terdaftar di kelas ini
                Rule::unique('kelas_mahasiswa')->where(function ($query) use ($kelas) {
                    return $query->where('kelas_id', $kelas->id);
                }),
            ],
        ], [
            'mahasiswa_id.unique' => 'Mahasiswa ini sudah terdaftar di kelas ini.',
        ]);

        DB::beginTransaction();
        try {
            $kelas->mahasiswas()->attach($request->mahasiswa_id, [
                'nilai_akhir' => null, // Nilai awal bisa null
                'status_kelas' => 'Sedang Berlangsung', // Status awal
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('admin.kelas.mahasiswa.index', $kelas->id)
                             ->with('success', 'Mahasiswa berhasil ditambahkan ke kelas.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan mahasiswa ke kelas: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus mahasiswa dari kelas.
     */
    public function destroy(Kelas $kela, Mahasiswa $mahasiswa)
    {
        $kelas = $kela;
        DB::beginTransaction();
        try {
            // Detach mahasiswa dari kelas
            $kelas->mahasiswas()->detach($mahasiswa->id);

            DB::commit();
            return redirect()->route('admin.kelas.mahasiswa.index', $kelas->id)
                             ->with('success', 'Mahasiswa berhasil dihapus dari kelas.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus mahasiswa dari kelas: ' . $e->getMessage());
        }
    }

    /**
     * Mengupdate nilai dan status mahasiswa di kelas.
     * Ini adalah metode opsional jika Anda ingin mengelola nilai langsung dari sini.
     */
    public function updateNilai(Request $request, Kelas $kela, Mahasiswa $mahasiswa)
    {
        // dd($request->nilai_akhir);

        $kelas = $kela;
        $request->validate([
            'nilai_akhir' => 'nullable|numeric|min:0|max:100',
            'status_kelas' => ['required', Rule::in(['Sedang Berlangsung', 'Lulus', 'Tidak Lulus', 'Mengulang'])],
        ]);


        DB::beginTransaction();
        try {
            $kelas->mahasiswas()->updateExistingPivot($mahasiswa->id, [
                'nilai_akhir' => $request->nilai_akhir,
                'status_kelas' => $request->status_kelas,
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('admin.kelas.mahasiswa.index', $kelas->id)
                             ->with('success', 'Nilai dan status mahasiswa berhasil diperbarui.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui nilai dan status: ' . $e->getMessage());
        }
    }
}
