<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keberangkatan extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'nomor_keberangkatan',
        'mobil_id'
    ];

    public function mobil(){
        return $this->belongsTo(Mobil::class);
    }

    public function segmentKeberangkatan(){
        return $this->hasMany(SegmentKeberangkatan::class);
    }

    public function classKeberangkatan(){
        return $this->hasMany(ClassKeberangkatan::class);
    }

    public function kursiKeberangkatan(){
        return $this->hasMany(KursiKeberangkatan::class);
    }

    public function transaksi(){
        return $this->hasMany(Transaksi::class);
    }

    public function generateSeats()
    {
        // Mendefinisikan layout kursi fisik standar untuk Avanza.
        // Ini adalah cetak biru fisik mobil (misalnya 7 kursi dengan layout 2-3-2).
        // Anda bisa menyesuaikan ini jika Avanza Anda memiliki 6 kursi (misal 2-2-2).
        $physicalSeatLayout = [
            1 => 2, // Baris 1: 2 kursi (misal: 1A, 1B)
            2 => 3, // Baris 2: 3 kursi (misal: 2A, 2B, 2C)
            3 => 2, // Baris 3: 2 kursi (misal: 3A, 3B)
        ];
        // Jika Avanza Anda selalu 6 kursi (misal 2-2-2), ubah menjadi:
        /*
        $physicalSeatLayout = [
            1 => 2, // Baris 1: 2 kursi
            2 => 2, // Baris 2: 2 kursi
            3 => 2, // Baris 3: 2 kursi
        ];
        */
        $totalPhysicalRows = count($physicalSeatLayout);
        $totalPhysicalSeats = array_sum($physicalSeatLayout); // Total kursi fisik yang tersedia

        // Ambil semua ClassKeberangkatan yang terkait dengan keberangkatan ini.
        // Filter hanya kelas yang memiliki total_kursi > 0 dan re-index koleksi.
        $classes = $this->classKeberangkatan->filter(function($class) {
            // PERBAIKAN: Menggunakan $class->total_kursi, bukan $class->total_seats
            return $class->total_kursi > 0;
        })->values();

        if ($classes->isEmpty()) {
            print("Tidak ada ClassKeberangkatan yang valid (total_kursi > 0) yang terkait dengan Keberangkatan ID: {$this->id}. Tidak ada kursi yang akan dibuat.");
            return false;
        }

        // Hitung total kursi yang diharapkan dari semua kelas yang dialokasikan
        $totalAllocatedSeats = $classes->sum('total_kursi'); // PERBAIKAN: Menggunakan sum('total_kursi')

        // Jika total kursi yang dialokasikan melebihi kapasitas fisik mobil, log peringatan
        if ($totalAllocatedSeats > $totalPhysicalSeats) {
            print("Total kursi yang dialokasikan ({$totalAllocatedSeats}) untuk Keberangkatan ID: {$this->id} melebihi kapasitas fisik mobil ({$totalPhysicalSeats}). Kursi akan dibatasi sesuai kapasitas fisik.");
            $totalAllocatedSeats = $totalPhysicalSeats; // Batasi alokasi ke kapasitas fisik
        }

        // Hapus semua kursi keberangkatan yang ada untuk keberangkatan ini.
        // Ini memastikan kita memulai dari awal setiap kali generateSeats dipanggil
        // dan menghindari masalah penonaktifan kursi yang kompleks.
        $this->kursiKeberangkatan()->delete();

        $currentClassIndex = 0;
        $seatsAssignedToCurrentClass = 0;
        $globalSeatCounter = 0; // Menghitung total kursi yang sudah dibuat

        // Loop melalui layout fisik mobil
        for ($row = 1; $row <= $totalPhysicalRows; $row++) {
            $seatsInCurrentPhysicalRow = $physicalSeatLayout[$row] ?? 0;

            for ($column = 1; $column <= $seatsInCurrentPhysicalRow; $column++) {
                // Hentikan jika sudah mencapai total kursi yang dialokasikan atau kapasitas fisik
                if ($globalSeatCounter >= $totalAllocatedSeats) {
                    break 2; // Keluar dari kedua loop (kolom dan baris)
                }

                // Pastikan ada kelas yang bisa dialokasikan
                if (!isset($classes[$currentClassIndex])) {
                    print("Terjadi kesalahan alokasi: Tidak cukup ClassKeberangkatan yang tersisa untuk mengalokasikan kursi fisik lebih lanjut untuk Keberangkatan ID: {$this->id}.");
                    break 2;
                }

                $currentClass = $classes[$currentClassIndex];
                $seatCode = $this->generateSeatCode($row, $column);

                // Buat kursi baru
                KursiKeberangkatan::create([
                    'keberangkatan_id' => $this->id,
                    'name'             => $seatCode,
                    'row'              => $row,
                    'column'           => $column,
                    'is_available'     => true,
                    'tipe_kelas'       => $currentClass->tipe_kelas,
                ]);

                $globalSeatCounter++;
                $seatsAssignedToCurrentClass++;

                // Jika kelas saat ini sudah mendapatkan semua kursinya, pindah ke kelas berikutnya
                // Pastikan total_kursi kelas > 0 untuk menghindari loop tak terbatas jika ada kelas dengan 0 kursi
                if ($currentClass->total_kursi > 0 && $seatsAssignedToCurrentClass >= $currentClass->total_kursi) {
                    $currentClassIndex++;
                    $seatsAssignedToCurrentClass = 0;
                }
            }
        }

        return true; // Mengembalikan true jika berhasil
    }

    /**
     * Metode ini tidak lagi digunakan karena layout kursi ditentukan secara statis
     * di generateSeats() berdasarkan physicalSeatLayout.
     */
    protected function getSeatsPerRow($tipeKelas)
    {
        // Metode ini tidak relevan lagi dengan logika baru
        return 0; // Mengembalikan 0 atau bisa dihapus sepenuhnya jika tidak ada penggunaan lain
    }

    // PERBAIKAN: Metode generateSeatCode yang hilang, ditambahkan kembali
    private function generateSeatCode($row, $column)
    {
        // Mengkonversi angka kolom menjadi huruf (1=A, 2=B, dst.)
        $columnLetter = chr(64 + $column);
        // Menggabungkan nomor baris dan huruf kolom
        return $row . $columnLetter; // Contoh: 1A, 1B, 2A, 2B, 2C, 3A, 3B
    }
}
