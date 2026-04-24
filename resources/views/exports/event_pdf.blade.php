{{-- resources/views/exports/event_pdf.blade.php (Final Version 6.2: Fix Sisa Piala Alignment) --}}
@php
    $fmt = fn ($n) => number_format((int) ($n ?? 0), 0, ',', '.');

    $eventDate = data_get($event, 'tanggal') ?? now();
    $venue     = trim((string) (data_get($event, 'venue')
        ?? data_get($event, 'lokasi')
        ?? data_get($event, 'tempat')
        ?? ''));

    $classes = collect($classes ?? []);

    $maxPrizeCols = isset($maxPrizeCols)
        ? min(6, (int) $maxPrizeCols)
        : min(6, max(1, (int) $classes->map(fn ($c) => count($c['hadiah'] ?? []))->max()));

    $getPrize = function ($c, $idx) {
        foreach (($c['hadiah'] ?? []) as $h) {
            if ((int) ($h['juara'] ?? 0) === (int) $idx) {
                return (int) ($h['nominal'] ?? 0);
            }
        }
        return 0;
    };

    $totalGantang = $totalTicketCalc = $totalPrizeCalc = $totalPiala = $totalSisaTiket = 0;
    $ops = collect($opsExpenses ?? []);
    $totalOps = (int) $ops->sum('jumlah');

    $sumTicket = isset($totalTicket)
        ? (int) $totalTicket
        : (int) $classes->sum(function ($c) {
            $harga = (int) ($c['tiket'] ?? $c['harga_tiket'] ?? 0);
            $gant  = (int) ($c['gantang'] ?? $c['jumlah_peserta'] ?? 0);
            return (int) ($c['total_tiket'] ?? ($harga * $gant));
        });

    $sumPrize = isset($totalPrize) ? (int) $totalPrize : (int) $classes->sum('total_hadiah');
    $sumPiala = (int) $classes->sum(fn ($c) => (int) ($c['piala'] ?? $c['jumlah_piala'] ?? 0));

    $saldoAkhirCalc = isset($saldoAkhir)
        ? (int) $saldoAkhir
        : ($sumTicket - ($sumPrize + $sumPiala + $totalOps));

    $tanggalCetak = \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y,');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Kas Harian • {{ \Carbon\Carbon::parse($eventDate)->locale('id')->translatedFormat('d F Y') }}</title>
<style>
@page { size: A4 landscape; margin: 6mm 8mm; }

body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 8.3px;
    color: #0f172a;
    margin: 0;
}

.header { text-align: center; margin-bottom: 10px; }
.title { font-size: 13px; font-weight: 800; color: #1e3a8a; }
.subtitle { font-size: 9px; color: #64748b; margin-top: 2px; }

.right { text-align: right; }
.center { text-align: center; }
.money { text-align: right; white-space: nowrap; font-variant-numeric: tabular-nums; padding-right: 2px; }
.wrap { word-break: break-word; }
.success { color: #047857; }
.danger { color: #b91c1c; }
.bold { font-weight: 700; }

table { border-collapse: collapse; width: 100%; table-layout: fixed; margin-bottom: 6px; }
th, td {
    padding: 3px 4px;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
    font-size: 8px;
    line-height: 1.2;
}
th {
    background: #1e3a8a;
    color: #fff;
    font-weight: 700;
    text-align: center;
}
tr:nth-child(even) td { background: #fafafa; }
tfoot td {
    background: #f1f5f9;
    font-weight: 700;
    border-top: 2px solid #64748b;
}

/* === Fix alignment widths === */
.detail-table th:nth-child(1) { width: 3%; }   /* No */
.detail-table th:nth-child(2) { width: 9%; }   /* Nama Kelas */
.detail-table th:nth-child(3) { width: 5%; }   /* Harga */
.detail-table th:nth-child(4) { width: 3%; }   /* Gantang */
.detail-table th:nth-child(5) { width: 6%; text-align:center;}   /* Total Tiket */
.detail-table th:nth-child(n+6):nth-child(-n+11) { width: 4.2%; } /* Hadiah 1–6 (dipersempit) */
.detail-table th:nth-child(12) { width: 6%; }  /* Total Hadiah */
.detail-table th:nth-child(13) { width: 6%; text-align:center; }  /* Piala (diperlebar dikit) */
.detail-table th:nth-child(14),
.detail-table td:nth-child(14) {
    width: 2.5%; text-align: center; white-space: nowrap;
}
.detail-table th:nth-child(15),
.detail-table td:nth-child(15) { width: 7%; }
.detail-table th:nth-child(16) { width: 4%; }
.detail-table th:nth-child(17) { width: 3%; }

.ops-table th:nth-child(1) { width: 10%; }
.ops-table th:nth-child(2) { width: 60%; text-align:left; }
.ops-table th:nth-child(3) { width: 30%; }

h3 {
    font-size: 10px;
    margin: 10px 0 4px 0;
    color: #1e3a8a;
    text-transform: uppercase;
    border-bottom: 1px solid #cbd5e1;
    padding-bottom: 2px;
}

.summary {
    width: 60%;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    border-radius: 4px;
    margin-top: 10px;
}
.summary td { padding: 6px 8px; }
.summary tr:nth-child(odd) td { background: #f1f5f9; }

.footer {
    text-align: right;
    font-size: 8px;
    color: #64748b;
    border-top: 1px solid #cbd5e1;
    margin-top: 8px;
    padding-top: 4px;
}
</style>
</head>

<body>
<div class="header">
    <div class="logo-container">
        <img src="{{ public_path('images/Logo Semar.png') }}" alt="Semar Arena Logo" class="logo">
    </div>
    <div class="title">
        <strong>LAPORAN KAS HARIAN GANTANGAN NEW SEMAR ARENA</strong>
    </div>
    <div class="subtitle">
        <b>Periode:</b> {{ \Carbon\Carbon::parse($eventDate)->locale('id')->translatedFormat('l, d F Y') }}
        @if($venue !== '') &bullet; <b>Lokasi:</b> {{ $venue }} @endif
        &bullet; Dicetak: {{ $tanggalCetak }}
    </div>
</div>

<style>
    /* Penempatan logo di atas judul dan di tengah */
    .logo-container {
        text-align: center;  /* Memastikan logo berada di tengah */
        margin-bottom: 5px;  /* Memberikan sedikit jarak antara logo dan judul */
    }

    .logo {
        max-width: 80px; /* Ukuran lebar logo */
        height: auto;    /* Menjaga rasio aspek gambar */
    }

    .title {
        font-size: 13px;
        font-weight: 800;
        color: #1e3a8a;
        text-align: center;  /* Menempatkan judul di tengah */
    }

    .subtitle {
        font-size: 9px;
        color: #64748b;
        text-align: center;  /* Menempatkan subtitle di tengah */
        margin-top: 2px;
    }
</style>


<h3>Detail Pemasukan & Pengeluaran per Kelas</h3>
<table class="detail-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kelas</th>
            <th class="right">Harga</th>
            <th class="right">Jumlah Pengantang</th>
            <th class="right">Total Penjualan Tiket</th>
            @for ($i = 1; $i <= $maxPrizeCols; $i++)
                <th class="right">Hadiah {{ $i }}</th>
            @endfor
            <th class="right">Total Hadiah</th>
            <th class="right">Piala</th>
            <th class="center">Sisa<br>Piala</th>
            <th class="right">Sisa Penjualan Tiket</th>
            <th>Lain</th>
            <th>Ket.</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($classes as $idx => $c)
            @php
                $nama = (string) ($c['nama'] ?? $c['nama_kelas'] ?? '');
                $tiket = (int) ($c['tiket'] ?? $c['harga_tiket'] ?? 0);
                $gant  = (int) ($c['gantang'] ?? $c['jumlah_peserta'] ?? 0);
                $totTiket = (int) ($c['total_tiket'] ?? ($tiket * $gant));
                $totHad = (int) ($c['total_hadiah'] ?? 0);
                $piala  = (int) ($c['piala'] ?? $c['jumlah_piala'] ?? 0);
                $sisaPiala = (int) ($c['sisa_piala'] ?? 0);
                $sisaTiket = (int) ($c['sisa_tiket'] ?? max(0, $totTiket - $totHad - $piala));
                $lain = $c['lain'] ?? '';
                $ket = $c['keterangan'] ?? '';
                $totalGantang += $gant;
                $totalTicketCalc += $totTiket;
                $totalPrizeCalc += $totHad;
                $totalPiala += $piala;
                $totalSisaTiket += $sisaTiket;
            @endphp
            <tr>
                <td class="center">{{ $idx + 1 }}</td>
                <td class="wrap">{{ $nama }}</td>
                <td class="money">Rp {{ $fmt($tiket) }}</td>
                <td class="money">{{ $fmt($gant) }}</td>
                <td class="money success">Rp {{ $fmt($totTiket) }}</td>
                @for ($i = 1; $i <= $maxPrizeCols; $i++)
                    @php $nom = $getPrize($c, $i); @endphp
                    <td class="money">@if($nom) Rp {{ $fmt($nom) }} @endif</td>
                @endfor
                <td class="money danger">Rp {{ $fmt($totHad) }}</td>
                <td class="money danger">Rp {{ $fmt($piala) }}</td>
                <td class="center">{{ $fmt($sisaPiala) }}</td>
                <td class="money">Rp {{ $fmt($sisaTiket) }}</td>
                <td class="wrap">{{ $lain }}</td>
                <td class="wrap">{{ $ket }}</td>
            </tr>
        @empty
            <tr><td colspan="{{ 11 + $maxPrizeCols }}" class="center">Belum ada kelas yang dicatat.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="right bold">TOTAL</td>
            <td></td>
            <td class="money">{{ $fmt($totalGantang) }}</td>
            <td class="money success">Rp {{ $fmt($totalTicketCalc) }}</td>
            @for ($i = 1; $i <= $maxPrizeCols; $i++) <td></td> @endfor
            <td class="money danger">Rp {{ $fmt($totalPrizeCalc) }}</td>
            <td class="money danger">Rp {{ $fmt($totalPiala) }}</td>
            <td></td>
            <td class="money">Rp {{ $fmt($totalSisaTiket) }}</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>

<h3>Pengeluaran Operasional</h3>
<table class="ops-table" style="width: 60%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Uraian</th>
            <th class="right">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ops as $j => $p)
            <tr>
                <td class="center">{{ $j + 1 }}</td>
                <td class="wrap">{{ $p['nama'] ?? 'Pengeluaran' }}</td>
                <td class="money danger">Rp {{ $fmt($p['jumlah'] ?? 0) }}</td>
            </tr>
        @empty
            <tr><td colspan="3" class="center">Belum ada pengeluaran operasional.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="right bold">Total Operasional</td>
            <td class="money danger">Rp {{ $fmt($totalOps) }}</td>
        </tr>
    </tfoot>
</table>

<h3>Ringkasan Keuangan</h3>
<table class="summary">
    <tr>
        <td>Total Pemasukan (Tiket)</td>
        <td class="money success">Rp {{ $fmt($sumTicket) }}</td>
    </tr>
    <tr>
        <td>Total Pengeluaran (Hadiah + Piala + Operasional)</td>
        <td class="money danger">Rp {{ $fmt($sumPrize + $sumPiala + $totalOps) }}</td>
    </tr>
    <tr>
        <td class="bold">Saldo Akhir Bersih</td>
        <td class="money bold" style="color:{{ $saldoAkhirCalc >= 0 ? '#047857' : '#b91c1c' }};">
            Rp {{ $fmt($saldoAkhirCalc) }}
        </td>
    </tr>
</table>

</body>
</html>
