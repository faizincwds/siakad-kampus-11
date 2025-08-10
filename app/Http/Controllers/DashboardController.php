<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data ringkasan
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalMataKuliah = MataKuliah::count();
        // Asumsi: tabel mahasiswa memiliki kolom 'status' untuk menandai mahasiswa yang sudah lulus.
        // Anda mungkin perlu menyesuaikan query ini sesuai dengan struktur database Anda.
        $totalLulusan = Mahasiswa::where('status', 'Lulus')->count();
        $totalProdi = ProgramStudi::count();

        // Ambil semester aktif (jika ada)
        $activeSemester = Semester::where('is_active', true)->first();

        $totalKelasAktif = 0;
        $upcomingSchedules = collect(); // Koleksi kosong jika tidak ada semester aktif

        if ($activeSemester) {
            $totalKelasAktif = Kelas::where('semester_id', $activeSemester->id)->count();

            // Ambil jadwal kelas yang akan datang untuk semester aktif
            // Misalnya, jadwal untuk 7 hari ke depan dari hari ini
            $today = Carbon::today();
            $sevenDaysLater = Carbon::today()->addDays(7);
            // Peta untuk mengurutkan hari secara manual
            $dayOrderMap = [
                'Monday'    => 1,
                'Tuesday'   => 2,
                'Wednesday' => 3,
                'Thursday'  => 4,
                'Friday'    => 5,
                'Saturday'  => 6,
                'Sunday'    => 7,
            ];

            $upcomingSchedules = Kelas::where('semester_id', $activeSemester->id)
                                    ->whereIn('day_of_week', $this->getDaysOfWeekForPeriod($today, $sevenDaysLater))
                                    // ->orderBy('day_of_week_order') // Asumsi ada kolom ini atau kita bisa order manual
                                    ->orderBy('start_time')
                                    ->with(['mataKuliah', 'dosen', 'room', 'semester']) // Load relasi
                                    ->get()
                                    ->filter(function ($kelas) use ($today, $sevenDaysLater) {
                                        // Filter kelas yang harinya ada dalam rentang tanggal
                                        $dayOfWeekNum = $this->getDayOfWeekNumber($kelas->day_of_week);
                                        $classDate = $today->copy()->next($dayOfWeekNum); // Dapatkan tanggal terdekat untuk hari itu

                                        // Jika tanggal kelas sudah lewat hari ini, cek minggu depan
                                        if ($classDate->isBefore($today) && !$classDate->isSameDay($today)) {
                                            $classDate->addWeek();
                                        }

                                        return $classDate->between($today, $sevenDaysLater, true);
                                    })
                                    ->sortBy(function($kelas) use ($dayOrderMap,$today) {
                                        // Urutkan berdasarkan tanggal terdekat
                                        $dayOfWeekNum = $this->getDayOfWeekNumber($kelas->day_of_week);
                                        $classDate = $today->copy()->next($dayOfWeekNum);
                                        if ($classDate->isBefore($today) && !$classDate->isSameDay($today)) {
                                            $classDate->addWeek();
                                        }
                                        return $classDate->timestamp . '-' . ($dayOrderMap[$kelas->day_of_week] ?? 99) . '-' . $kelas->start_time->format('His');
                                    });
        }

        return view('admin.dashboard', compact('totalMahasiswa', 'totalDosen', 'totalMataKuliah', 'totalKelasAktif', 'activeSemester', 'upcomingSchedules', 'totalLulusan', 'totalProdi'));
    }

    /**
     * Helper untuk mendapatkan daftar hari dalam seminggu dalam rentang tanggal.
     * Digunakan untuk query awal.
     */
    private function getDaysOfWeekForPeriod(Carbon $start, Carbon $end): array
    {
        $days = [];
        $current = $start->copy();
        while ($current->lte($end)) {
            $days[] = $current->format('l'); // 'Monday', 'Tuesday', etc.
            $current->addDay();
        }
        return array_unique($days);
    }

    /**
     * Helper untuk mengkonversi nama hari ke angka (1=Senin, 7=Minggu).
     */
    private function getDayOfWeekNumber(string $dayName): int
    {
        return Carbon::parse($dayName)->dayOfWeekIso; // 1 (Monday) through 7 (Sunday)
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
