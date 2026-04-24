{{-- resources/views/exports/event_excel.blade.php (Diperbaiki dengan Logo di Atas Judul) --}}
@php
    /**
     * Format Excel disamakan dengan PDF (event_pdf.blade.php)
     * 1) Header
     * 2) Detail per Kelas (Hadiah 1..N)
     * 3) Pengeluaran Operasional
     * 4) Ringkasan Keuangan
     *
     * Catatan: semua angka DIKIRIM MENTAH (integer). Formatting (Rp, ribuan)
     * diatur oleh WithColumnFormatting pada kelas export.
     */

    $nint = fn($v) => (int)($v ?? 0);
    $classes = collect($classes ?? []);

    // Hitung max kolom hadiah (batasi 10)
    $maxPrizeCols = isset($maxPrizeCols)
        ? min(10, (int)$maxPrizeCols)
        : min(10, max(1, (int)($classes->map(fn($c)=>count($c['hadiah'] ?? []))->max() ?? 1)));

    // Ambil nominal hadiah juara ke-$idx
    $getPrize = function($c, $idx) {
        foreach (($c['hadiah'] ?? []) as $h) {
            if ((int)($h['juara'] ?? 0) === (int)$idx) {
                return (int)($h['nominal'] ?? 0);
            }
        }
        return 0;
    };

    // Totals (kelas)
    $totalGantang      = 0;
    $totalTicketCalc = 0;
    $totalPrizeCalc  = 0;
    $totalSisaTiket  = 0;
    $totalPiala      = 0;

    // Operasional
    $ops = collect($opsExpenses ?? []);
    $totalOps = (int) $ops->sum('jumlah');

    // Ringkasan
    $sumTicket = isset($totalTicket)
        ? (int)$totalTicket
        : (int)$classes->sum(function($c) {
            $harga = (int)($c['tiket'] ?? $c['harga_tiket'] ?? 0);
            $gant  = (int)($c['gantang'] ?? $c['jumlah_peserta'] ?? 0);
            return (int)($c['total_tiket'] ?? ($harga * $gant));
        });

    $sumPrize = isset($totalPrize) ? (int)$totalPrize : (int)$classes->sum('total_hadiah');
    $sumPiala = (int)$classes->sum(fn($c)=>(int)($c['piala'] ?? $c['jumlah_piala'] ?? 0));

    $saldoAkhirCalc = isset($saldoAkhir)
        ? (int)$saldoAkhir
        : ($sumTicket - ($sumPrize + $sumPiala + $totalOps));

    $tanggalCetak = \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y');

    // Hitung total kolom (1 No + 1 Nama Kelas + 3 Tiket/Gantang + $maxPrizeCols Hadiah + 6 Sisanya)
    // Penyesuaian: kolom "Sisa Piala" sudah dihapus sebelumnya.
    // Kolom yang ada sekarang: No, Nama Kelas, Harga Tiket, Jml Pengantang, Total Penjualan Tiket, Hadiah (N), Total Hadiah, Peng. Piala, Sisa Tiket (Profit), Lain-lain, Keterangan
    $totalCols = 1 + 1 + 1 + 1 + 1 + $maxPrizeCols + 1 + 1 + 1 + 1 + 1; // Total 11 + maxPrizeCols
@endphp

<table style="width:100%; border-collapse:collapse; font-family:Calibri, Arial; font-size:10pt;">
    {{-- HEADER --}}

    {{-- Row for Logo --}}
    

    {{-- Row for Report Title --}}
    <tr>
        <td colspan="{{ $totalCols }}" style="text-align:center; font-weight:bold; font-size:16pt; color:#1e3a8a;">
            LAPORAN KAS HARIAN GANTANGAN NEW SEMAR ARENA
        </td>
    </tr>

    {{-- Row for Date and Venue --}}
    <tr>
        <td colspan="{{ $totalCols }}" style="text-align:center; font-size:11pt; color:#475569;">
            {{ \Carbon\Carbon::parse(($event->tanggal ?? now()))->translatedFormat('l, d F Y') }}
            @if(!empty($event->venue))
                • **{{ $event->venue }}**
            @endif
        </td>
    </tr>

    <tr><td colspan="{{ $totalCols }}" style="height:15px;"></td></tr>

    {{-- DETAIL PER KELAS --}}
<tr>
    <td colspan="{{ $totalCols }}" style="font-weight:bold; font-size:11pt; border-bottom:1px solid #e2e8f0; padding-bottom:3px; color:#1e3a8a;">
        RINCIAN KEUANGAN
    </td>
</tr>
<tr>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">No</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px;">Nama Kelas</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">Harga Tiket</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">Jml Pengantang</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">Total Penjualan Tiket</th>
    
    @for($i=1;$i<=$maxPrizeCols;$i++)
        <th style="border:1px solid #94a3b8; background:#64748b; color:#ffffff; padding:5px; text-align:center;">Hadiah {{ $i }}</th>
    @endfor

    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">Total Hadiah</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">Peng. Piala</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">Sisa Piala</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">Sisa Penjualan Tiket</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px;">Lain-lain</th>
    <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px;">Keterangan</th>
</tr>

@php
    $totalSisaPiala = 0;
@endphp

@forelse($classes as $idx=>$c)
    @php
        $nama       = (string)($c['nama'] ?? $c['nama_kelas'] ?? '');
        $tiket      = $nint($c['tiket'] ?? $c['harga_tiket'] ?? 0);
        $gantang    = $nint($c['gantang'] ?? $c['jumlah_peserta'] ?? 0);
        $totalTiket = $nint($c['total_tiket'] ?? ($tiket * $gantang));
        $totalHad   = $nint($c['total_hadiah'] ?? 0);
        $piala      = $nint($c['piala'] ?? $c['jumlah_piala'] ?? 0);
        $sisaPiala  = $nint($c['sisa_piala'] ?? 0);
        $sisaTiket  = $nint($c['sisa_tiket'] ?? max(0, $totalTiket - $totalHad - $piala));
        $lain       = $c['lain'] ?? '';
        $ket        = $c['keterangan'] ?? '';

        // akumulasi
        $totalGantang   += $gantang;
        $totalTicketCalc+= $totalTiket;
        $totalPrizeCalc += $totalHad;
        $totalPiala     += $piala;
        $totalSisaPiala += $sisaPiala;
        $totalSisaTiket += $sisaTiket;
    @endphp
    <tr>
        <td style="border:1px solid #e2e8f0; text-align:center;">{{ $idx+1 }}</td>
        <td style="border:1px solid #e2e8f0; padding-left:5px;">{{ $nama }}</td>
        <td style="border:1px solid #e2e8f0; text-align:right;">{{ $tiket }}</td>
        <td style="border:1px solid #e2e8f0; text-align:right;">{{ $gantang }}</td>
        <td style="border:1px solid #e2e8f0; text-align:right; background:#f0f9ff;">{{ $totalTiket }}</td>
        @for($i=1;$i<=$maxPrizeCols;$i++)
            @php $nom = $getPrize($c,$i); @endphp
            <td style="border:1px solid #e2e8f0; text-align:right; background:#f8fafc;">{{ $nom ?: '' }}</td>
        @endfor
        <td style="border:1px solid #e2e8f0; text-align:right; background:#fefce8;">{{ $totalHad }}</td>
        <td style="border:1px solid #e2e8f0; text-align:right;">{{ $piala }}</td>
        <td style="border:1px solid #e2e8f0; text-align:right;">{{ $sisaPiala }}</td>
        <td style="border:1px solid #e2e8f0; text-align:right; font-weight:bold; background:#e0f2f1;">{{ $sisaTiket }}</td>
        <td style="border:1px solid #e2e8f0; padding-left:5px;">{{ $lain }}</td>
        <td style="border:1px solid #e2e8f0; padding-left:5px;">{{ $ket }}</td>
    </tr>
@empty
    <tr>
        <td colspan="{{ $totalCols }}" style="text-align:center; border:1px solid #e2e8f0; padding:5px; font-style:italic;">Belum ada data kelas</td>
    </tr>
@endforelse

{{-- TOTAL PER KELAS --}}
<tr style="font-weight:bold; background:#e2e8f0;">
    <td colspan="3" style="border:1px solid #94a3b8; text-align:right; padding:5px; color:#1e3a8a;">SUBTOTAL</td>
    <td style="border:1px solid #94a3b8; text-align:right;">{{ $totalGantang }}</td>
    <td style="border:1px solid #94a3b8; text-align:right;">{{ $totalTicketCalc }}</td>
    @for($i=1;$i<=$maxPrizeCols;$i++)
        <td style="border:1px solid #94a3b8;"></td>
    @endfor
    <td style="border:1px solid #94a3b8; text-align:right;">{{ $totalPrizeCalc }}</td>
    <td style="border:1px solid #94a3b8; text-align:right;">{{ $totalPiala }}</td>
    <td style="border:1px solid #94a3b8; text-align:right;">{{ $totalSisaPiala }}</td>
    <td style="border:1px solid #94a3b8; text-align:right; color:#1e3a8a;">{{ $totalSisaTiket }}</td>
    <td style="border:1px solid #94a3b8;" colspan="2"></td>
</tr>


    <tr><td colspan="{{ $totalCols }}" style="height:15px;"></td></tr>

    {{-- PENGELUARAN OPERASIONAL --}}
    <tr>
        <td colspan="3" style="font-weight:bold; font-size:11pt; border-bottom:1px solid #e2e8f0; padding-bottom:3px; color:#1e3a8a;">
            PENGELUARAN OPERASIONAL
        </td>
    </tr>
    <tr>
        <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">No</th>
        <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px;">Uraian</th>
        <th style="border:1px solid #94a3b8; background:#334155; color:#ffffff; padding:5px; text-align:center;">Jumlah</th>
    </tr>
    @forelse($ops as $i=>$op)
        <tr>
            <td style="border:1px solid #e2e8f0; text-align:center;">{{ $i+1 }}</td>
            <td style="border:1px solid #e2e8f0; padding-left:5px;">{{ $op['nama'] ?? 'Pengeluaran' }}</td>
            <td style="border:1px solid #e2e8f0; text-align:right; background:#fef2f2;">{{ (int)($op['jumlah'] ?? 0) }}</td>
        </tr>
    @empty
        <tr><td colspan="3" style="border:1px solid #e2e8f0; text-align:center; padding:5px; font-style:italic;">Tidak ada data pengeluaran operasional</td></tr>
    @endforelse
    <tr style="font-weight:bold; background:#fef2f2;">
        <td></td>
        <td style="border:1px solid #94a3b8; text-align:right; padding:5px; color:#dc2626;">TOTAL OPERASIONAL</td>
        <td style="border:1px solid #94a3b8; text-align:right;">{{ $totalOps }}</td>
    </tr>

    <tr><td colspan="{{ $totalCols }}" style="height:15px;"></td></tr>

    {{-- RINGKASAN KEUANGAN --}}
    <tr>
        <td colspan="3" style="font-weight:bold; font-size:11pt; border-bottom:1px solid #e2e8f0; padding-bottom:3px; color:#1e3a8a;">
            RINGKASAN KEUANGAN
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border:1px solid #e2e8f0; padding:5px; background:#f0f9ff;">Total Pemasukan Bruto (Tiket)</td>
        <td style="border:1px solid #e2e8f0; text-align:right; font-weight:bold; background:#f0f9ff;">{{ $sumTicket }}</td>
    </tr>
    <tr>
        <td colspan="2" style="border:1px solid #e2e8f0; padding:5px; background:#fef2f2;">Total Pengeluaran (Hadiah + Piala + Operasional)</td>
        <td style="border:1px solid #e2e8f0; text-align:right; font-weight:bold; background:#fef2f2;">{{ $sumPrize + $sumPiala + $totalOps }}</td>
    </tr>
    <tr style="font-weight:bold; background:#dcfce7;">
        <td colspan="2" style="border:1px solid #065f46; padding:5px; color:#065f46;">SALDO AKHIR BERSIH</td>
        <td style="border:1px solid #065f46; text-align:right; color:#065f46;">{{ $saldoAkhirCalc }}</td>
    </tr>

    {{-- FOOTER CETAK --}}
    <tr>
        <td colspan="{{ $totalCols }}"
            style="font-size:9pt;color:#64748b;text-align:right;border-top:1px solid #94a3b8;padding-top:6px; font-style:italic;">
            Dicetak pada: {{ $tanggalCetak }}
        </td>
    </tr>
</table>