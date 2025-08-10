<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Krs;
use App\Models\Semester;
use App\Models\KrsDetail;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    /**
     * Menampilkan daftar semua pengajuan KRS.
     * Admin bisa melihat semua KRS dari semua mahasiswa.
     */
    public function index(Request $request)
    {
        $semesters = Semester::orderBy('tahun_akademik', 'desc')->orderBy('nama_semester', 'desc')->get();
        $selectedSemesterId = $request->input('semester_id');
        $krsStatus = $request->input('status', 'all'); // Filter status: pending, approved, rejected, all

        $krsQuery = Krs::with(['mahasiswa', 'semester', 'disetujuiOleh.userable']); // Load relasi

        // Filter berdasarkan semester jika dipilih
        if ($selectedSemesterId) {
            $krsQuery->where('semester_id', $selectedSemesterId);
        }

        // Filter berdasarkan status jika dipilih
        if ($krsStatus !== 'all') {
            $krsQuery->where('status', $krsStatus);
        }

        $krsSubmissions = $krsQuery->orderBy('tanggal_pengajuan', 'desc')->paginate(10);

        // Hitung total SKS untuk setiap KRS di koleksi
        foreach ($krsSubmissions as $krs) {
            $krs->total_sks = $krs->details->sum(function ($detail) {
                return $detail->kelas->mataKuliah->sks;
            });
        }

        return view('admin.krs.index', compact('krsSubmissions', 'semesters', 'selectedSemesterId', 'krsStatus'));
    }

    // --- Metode untuk admin menambahkan/mengedit KRS secara langsung untuk mahasiswa ---
    // Ini akan menjadi fitur "admin membuat KRS atas nama mahasiswa"

    /**
     * Menampilkan form untuk membuat KRS baru untuk mahasiswa.
     */
    public function create(Request $request)
    {
        $mahasiswas = Mahasiswa::orderBy('nama_lengkap')->get();

        $semesters = Semester::where('is_active', true)->orderBy('tahun_akademik', 'desc')->orderBy('nama_semester', 'desc')->get();
        $kelasAvailable = collect(); // Akan diisi via AJAX atau setelah memilih semester/mahasiswa


        // Jika parameter mahasiswa_id dan semester_id ada, load kelas yang tersedia
        $selectedMahasiswaId = $request->mahasiswa_id;
        $selectedSemesterId = $request->semester_id;

        if ($selectedMahasiswaId && $selectedSemesterId) {
            // Ambil semua kelas yang tersedia untuk semester ini
            $kelasAvailable = Kelas::where('semester_id', $selectedSemesterId)
                                    ->with(['mataKuliah', 'dosen', 'room'])
                                    ->get()
                                    ->sortBy('day_of_week_order') // Asumsi Anda punya order ini atau sort manual
                                    ->sortBy('start_time');

            // Ambil kelas yang sudah diambil mahasiswa ini di semester ini (untuk menghindari duplikasi)
            $existingKrs = Krs::where('mahasiswa_id', $selectedMahasiswaId)
                              ->where('semester_id', $selectedSemesterId)
                              ->first();
            $existingKelasIds = $existingKrs ? $existingKrs->details->pluck('kelas_id')->toArray() : [];

            // Filter kelas yang sudah dipilih
            $kelasAvailable = $kelasAvailable->filter(function ($kelas) use ($existingKelasIds) {
                return !in_array($kelas->id, $existingKelasIds);
            });
        }


        return view('admin.krs.create', compact('mahasiswas', 'semesters', 'kelasAvailable', 'selectedMahasiswaId', 'selectedSemesterId'));
    }

    /**
     * Menyimpan KRS yang dibuat oleh admin atas nama mahasiswa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|uuid|exists:mahasiswas,id',
            'semester_id' => 'required|uuid|exists:semesters,id',
            'kelas_ids' => 'required|array',
            'kelas_ids.*' => 'uuid|exists:kelas,id',
        ]);

        DB::beginTransaction();
        try {
            // Cek apakah mahasiswa sudah memiliki KRS untuk semester ini
            $krs = Krs::firstOrNew([
                'mahasiswa_id' => $request->mahasiswa_id,
                'semester_id' => $request->semester_id,
            ]);

            // Jika KRS baru, set status pending dan tanggal pengajuan
            if (!$krs->exists) {
                $krs->status = 'pending'; // Admin membuat, jadi tetap pending untuk disetujui
                $krs->tanggal_pengajuan = now();
            }
            $krs->save();

            // Hapus detail KRS lama jika ada (untuk update/overwrite)
            $krs->details()->delete();

            // Tambahkan kelas yang dipilih ke KRS Details
            $details = [];
            foreach ($request->kelas_ids as $kelasId) {
                $details[] = new KrsDetail([
                    'krs_id' => $krs->id,
                    'kelas_id' => $kelasId,
                ]);
            }
            $krs->details()->saveMany($details);

            DB::commit();
            return redirect()->route('admin.krs.show', $krs->id)->with('success', 'KRS berhasil ' . ($krs->wasRecentlyCreated ? 'dibuat' : 'diperbarui') . ' untuk mahasiswa.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan KRS: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail dari satu pengajuan KRS tertentu.
     */
    public function show(Krs $kr)
    {
        $krs = $kr;
        // Load relasi yang diperlukan untuk detail KRS
        $krs->load(['mahasiswa', 'semester', 'disetujuiOleh.userable', 'details.kelas.mataKuliah', 'details.kelas.dosen', 'details.kelas.room']);

        // Hitung total SKS
        $totalSKS = $krs->details->sum(function ($detail) {
            return $detail->kelas->mataKuliah->sks;
        });

        return view('admin.krs.show', compact('krs', 'totalSKS'));
    }

    /**
     * Menyetujui pengajuan KRS.
     */
    public function approve(Request $request, Krs $kr)
    {
        $krs = $kr;
        if ($krs->status !== 'pending') {
            return redirect()->back()->with('error', 'KRS ini sudah tidak dalam status pending.');
        }

        DB::beginTransaction();
        try {
            $krs->update([
                'status' => 'approved',
                'tanggal_persetujuan' => now(),
                'disetujui_oleh' => Auth::id(), // ID user admin/dosen wali yang login
                'catatan_persetujuan' => $request->catatan_persetujuan,
            ]);

            // Tambahkan semua kelas dari KRS ke tabel kelas_mahasiswa
            foreach ($krs->details as $detail) {
                // Pastikan kelas_mahasiswa belum ada untuk menghindari duplikasi
                $krs->mahasiswa->kelas()->syncWithoutDetaching([
                    $detail->kelas_id => [
                        'semester_id' => $krs->semester_id, // Simpan semester_id di pivot table
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]);
            }

            DB::commit();
            return redirect()->route('admin.krs.index')->with('success', 'KRS berhasil disetujui dan kelas ditambahkan ke mahasiswa.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyetujui KRS: ' . $e->getMessage());
        }
    }

    /**
     * Menolak pengajuan KRS.
     */
    public function reject(Request $request, Krs $kr)
    {
        $krs = $kr;
        if ($krs->status !== 'pending') {
            return redirect()->back()->with('error', 'KRS ini sudah tidak dalam status pending.');
        }

        $request->validate([
            'catatan_persetujuan' => 'required|string|max:500', // Alasan penolakan wajib
        ]);

        DB::beginTransaction();
        try {
            $krs->update([
                'status' => 'rejected',
                'tanggal_persetujuan' => now(),
                'disetujui_oleh' => Auth::id(),
                'catatan_persetujuan' => $request->catatan_persetujuan,
            ]);

            // Jika ditolak, kelas yang diajukan tidak ditambahkan ke kelas_mahasiswa
            // Jika sudah terlanjur ada, Anda bisa menghapusnya di sini
            // Namun, karena persetujuan akan menambahkannya, penolakan hanya akan mencegah penambahan.

            DB::commit();
            return redirect()->route('admin.krs.index')->with('success', 'KRS berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menolak KRS: ' . $e->getMessage());
        }
    }


}
