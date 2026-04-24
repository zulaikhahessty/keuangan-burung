<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings; // Ditambahkan

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing; // Ditambahkan

class EventExport implements FromView, ShouldAutoSize, WithColumnFormatting, WithDrawings // Ditambahkan WithDrawings
{
    public function __construct(private array $data)
    {
        // Pastikan maxPrizeCols ada & sinkron dengan view
        if (!isset($this->data['maxPrizeCols'])) {
            $classes = collect($this->data['classes'] ?? []);
            $this->data['maxPrizeCols'] = min(
                10,
                max(1, (int) $classes->map(fn($c) => count($c['hadiah'] ?? []))->max() ?? 1)
            );
        }
    }

    public function view(): View
    {
        return view('exports.event_excel', $this->data);
    }

    /**
     * Menyematkan logo sebagai Drawing object agar posisinya stabil di Excel.
     */
    public function drawings()
    {
        $drawing = new Drawing();
        
        // Asumsi logo ada di path ini
        $drawing->setPath(public_path('images/Logo Semar.png')); 
        
        // Atur ukuran yang sedikit lebih besar (90x90)
        $drawing->setHeight(70); 
        $drawing->setWidth(70);

        // UBAH KOORDINAT AWAL
        // Menggunakan E2 sebagai titik anchor (Kolom E, Baris 2).
        $drawing->setCoordinates('E2'); 
        
        // Atur offset (perpindahan piksel)
        // PERBAIKAN: Geser ke kanan (positif) dan ke atas (negatif)
        $drawing->setOffsetX(150); // Geser 15 piksel ke KANAN dari batas kiri E
        $drawing->setOffsetY(-25); // Geser 10 piksel ke ATAS dari batas atas E2

        return $drawing;
    }

    // Fungsi untuk format kolom Excel (misalnya untuk mata uang)
    public function columnFormats(): array
    {
        $maxPrize = (int) $this->data['maxPrizeCols'];

        // Indeks kolom (1-based)
        $colHarga       = 3;           // C
        $colGantang     = 4;           // D
        $colTotalTiket  = 5;           // E
        $colPrizeStart  = 6;           // F..
        $colPrizeEnd    = 5 + $maxPrize; // ..F+N-1
        $colTotalHadiah = $colPrizeEnd + 1;
        $colPiala       = $colPrizeEnd + 2;
        $colSisaPiala   = $colPrizeEnd + 3;
        $colSisaTiket   = $colPrizeEnd + 4;

        // ===== FORMAT ANGKA =====
        $FMT_RP     = '"Rp." #,##0';   // Format rupiah tanpa desimal
        $FMT_ORANG  = '#,##0" "'; // Format bilangan bulat dengan teks "orang"
        $FMT_PCS    = '#,##0" "';   // Format bilangan bulat dengan teks "pcs"

        $map = [];

        // Helper function untuk menetapkan format kolom
        $set = function (int $idx, string $fmt) use (&$map) {
            $col = Coordinate::stringFromColumnIndex($idx);
            $map[$col] = $fmt;
        };

        // ===== Kolom Uang =====
        $set($colHarga,       $FMT_RP);
        $set($colTotalTiket, $FMT_RP);
        for ($i = $colPrizeStart; $i <= $colPrizeEnd; $i++) {
            $set($i, $FMT_RP);
        }
        $set($colTotalHadiah, $FMT_RP);
        $set($colPiala,       $FMT_RP);
        $set($colSisaTiket,   $FMT_RP);

        // ===== Kolom Orang & Pcs =====
        $set($colGantang,     $FMT_ORANG); // jumlah peserta
        // Perhatian: Pastikan di view tidak ada lagi kolom Sisa Piala
        $set($colSisaPiala,   $FMT_PCS);   // jumlah piala sisa

        return $map;
    }
}