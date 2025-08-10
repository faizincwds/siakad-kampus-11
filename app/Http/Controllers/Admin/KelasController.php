<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Room;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Menampilkan daftar semua kelas/jadwal.
     */
    public function index()
    {
        $activeSemester = Semester::where('is_active', true)->first();

        if ($activeSemester) {
            $kelas = Kelas::where('semester_id', $activeSemester->id)->with(['mataKuliah', 'dosen', 'room', 'semester'])->get();
        } else {
            $kelas = collect(); // Jika tidak ada semester aktif, tampilkan koleksi kosong
            session()->flash('warning', 'Tidak ada semester yang saat ini aktif. Harap aktifkan satu semester.');
        }

        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Menampilkan detail kelas/jadwal spesifik.
     */
    public function show(Kelas $kela)
    {
        // Eager load relasi untuk menampilkan detail lengkap
        $kelas = $kela->load(['mataKuliah', 'dosen', 'room', 'mahasiswas']); // Tambahkan 'mahasiswa' untuk melihat daftar mahasiswa di kelas ini
        return view('admin.kelas.show', compact('kelas'));
    }


    /**
     * Menghapus kelas/jadwal dari database.
     */
    public function destroy(Kelas $kela)
    {
        $kelas = $kela;
        try {
            $kelas->delete();
            return redirect()->route('admin.kelas.index')->with('success', 'Kelas/Jadwal berhasil dihapus!');
        } catch (Exception $e) {
            // Tangani jika ada relasi yang menghalangi penghapusan (misal: masih ada mahasiswa terdaftar)
            return redirect()->back()->with('error', 'Kelas/Jadwal tidak dapat dihapus karena masih memiliki mahasiswa terdaftar atau relasi lain.');
        }
    }


    /**
     * Menampilkan form untuk membuat kelas baru.
     */
    public function create()
    {
        $semesters = Semester::orderBy('tahun_akademik', 'desc')
                               ->orderByRaw("FIELD(jenis_semester, 'Ganjil', 'Genap', 'Pendek')")
                               ->get();
        $mataKuliahs = MataKuliah::orderBy('nama_mk')->get();
        $dosens = Dosen::orderBy('nama_lengkap')->get();
        $rooms = Room::orderBy('name')->get();

        return view('admin.kelas.create', compact('semesters', 'mataKuliahs', 'dosens', 'rooms'));
    }

    /**
     * Menyimpan kelas baru yang dibuat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'mata_kuliah_id' => 'required|uuid|exists:mata_kuliah,id',
            'dosen_id' => 'required|uuid|exists:dosen,id',
            'room_id' => 'required|uuid|exists:rooms,id',
            'day_of_week' => ['required', 'string', Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'semester_id' => 'required|uuid|exists:semesters,id',
        ]);

        // --- VALIDASI BENTROK JADWAL ---
        $conflicts = Kelas::checkConflicts(
            $validated['day_of_week'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['room_id'],
            $validated['dosen_id'],
            $validated['semester_id']
            // Tidak ada excludeKelasId karena ini kelas baru
        );

        if ($conflicts->isNotEmpty()) {
            $conflictMessages = [];
            foreach ($conflicts as $conflict) {
                if ($conflict->room_id === $validated['room_id']) {
                    $conflictMessages[] = "Ruangan <strong>{$conflict->room->name}</strong> bentrok dengan kelas <strong>'{$conflict->nama_kelas}'</strong> (<strong>{$conflict->mataKuliah->nama_mk}</strong>) yang diajar oleh <strong>{$conflict->dosen->nama_lengkap}</strong> pada <strong>{$conflict->day_name}</strong>, Pukul <strong>" . $conflict->start_time->format('H:i') . "-" . $conflict->end_time->format('H:i') . "</strong>.";
                }

                if ($conflict->dosen_id === $validated['dosen_id']) {
                    $conflictMessages[] = "Dosen <strong>{$conflict->dosen->nama_lengkap}</strong> bentrok dengan kelas <strong>'{$conflict->nama_kelas}'</strong> (<strong>{$conflict->mataKuliah->nama_mk}</strong>) yang diajarnya di ruangan <strong>{$conflict->room->name}</strong> pada <strong>{$conflict->day_name}</strong>, Pukul <strong>" . $conflict->start_time->format('H:i') . "-" . $conflict->end_time->format('H:i') . "</strong>.";
                }

            }
            return redirect()->back()->withErrors($conflictMessages)->withInput();
        }
        // --- AKHIR VALIDASI BENTROK JADWAL ---

        DB::beginTransaction();
        try {
            Kelas::create($validated);
            DB::commit();
            return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan kelas: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk mengedit kelas.
     */
    public function edit(Kelas $kela) // Pastikan parameter adalah $kela
    {
        $kelas = $kela;
        $semesters = Semester::orderBy('nama_semester')->get();
        $mataKuliahs = MataKuliah::orderBy('nama_mk')->get();
        $dosens = Dosen::orderBy('nama_lengkap')->get();
        $rooms = Room::orderBy('name')->get();

        return view('admin.kelas.edit', compact('kelas', 'semesters', 'mataKuliahs', 'dosens', 'rooms'));
    }

    /**
     * Mengupdate kelas yang dipilih.
     */
    public function update(Request $request, Kelas $kela) // Pastikan parameter adalah $kela
    {
        $kelas = $kela;
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'mata_kuliah_id' => 'required|uuid|exists:mata_kuliah,id',
            'dosen_id' => 'required|uuid|exists:dosen,id',
            'room_id' => 'required|uuid|exists:rooms,id',
            'day_of_week' => ['required', 'string', Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'semester_id' => 'required|uuid|exists:semesters,id',
        ]);

        // --- VALIDASI BENTROK JADWAL ---
        $conflicts = Kelas::checkConflicts(
            $validated['day_of_week'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['room_id'],
            $validated['dosen_id'],
            $validated['semester_id'],
            $kelas->id // Penting: Abaikan kelas yang sedang diedit
        );

        if ($conflicts->isNotEmpty()) {
            $conflictMessages = [];
            foreach ($conflicts as $conflict) {
                if ($conflict->room_id === $validated['room_id']) {
                    $conflictMessages[] = "Ruangan <strong>{$conflict->room->name}</strong> bentrok dengan kelas <strong>'{$conflict->nama_kelas}'</strong> (<strong>{$conflict->mataKuliah->nama_mk}</strong>) yang diajar oleh <strong>{$conflict->dosen->nama_lengkap}</strong> pada <strong>{$conflict->day_name}</strong>, Pukul <strong>" . $conflict->start_time->format('H:i') . "-" . $conflict->end_time->format('H:i') . "</strong>.";
                }

                if ($conflict->dosen_id === $validated['dosen_id']) {
                    $conflictMessages[] = "Dosen <strong>{$conflict->dosen->nama_lengkap}</strong> bentrok dengan kelas <strong>'{$conflict->nama_kelas}'</strong> (<strong>{$conflict->mataKuliah->nama_mk}</strong>) yang diajarnya di ruangan <strong>{$conflict->room->name}</strong> pada <strong>{$conflict->day_name}</strong>, Pukul <strong>" . $conflict->start_time->format('H:i') . "-" . $conflict->end_time->format('H:i') . "</strong>.";
                }
            }
            return redirect()->back()->withErrors($conflictMessages)->withInput();
        }
        // --- AKHIR VALIDASI BENTROK JADWAL ---

        DB::beginTransaction();
        try {
            $kelas->update($validated);
            DB::commit();
            return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui kelas: ' . $e->getMessage());
        }
    }
}
