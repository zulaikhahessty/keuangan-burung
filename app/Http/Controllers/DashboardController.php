<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\KelasLomba;   // ✅ perlu untuk menghitung total_piala
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // === RINGKASAN GLOBAL ===
        $totalEvents = Event::count();

        // Pemasukan: hanya dari penjualan tiket (kelas lomba)
        $totalTicket = (int) Event::sum('total_tiket');

        // Pengeluaran: hadiah + operasional + piala (jumlah_piala dari KelasLomba)
        $totalHadiah      = (int) Event::sum('total_hadiah');
        $totalOperasional = (int) Event::sum('total_operasional');
        $totalPiala       = (int) KelasLomba::sum('jumlah_piala');
        $totalOut         = $totalHadiah + $totalOperasional + $totalPiala;

        // Saldo akhir keseluruhan SEMARFIN
        $saldoAkhir = $totalTicket - $totalOut;

        // === DATA GRAFIK BULANAN ===
        $rows = Event::selectRaw('
                    YEAR(tanggal) as y,
                    MONTH(tanggal) as m,
                    SUM(total_tiket) as tin,
                    SUM(total_hadiah + total_operasional) as tout_event
                ')
                ->groupBy('y','m')
                ->orderBy('y')
                ->orderBy('m')
                ->get();

        // Ambil juga total piala per bulan dari KelasLomba (via join ke Event)
        $pialaRows = KelasLomba::join('events', 'kelas_lombas.event_id', '=', 'events.id')
            ->selectRaw('YEAR(events.tanggal) as y, MONTH(events.tanggal) as m, SUM(kelas_lombas.jumlah_piala) as sum_piala')
            ->groupBy('y','m')
            ->get()
            ->keyBy(fn($r) => sprintf('%04d-%02d', $r->y, $r->m));

        // Gabungkan pengeluaran piala ke data tout_event
        foreach ($rows as $r) {
            $key = sprintf('%04d-%02d', $r->y, $r->m);
            $r->tout = (int) $r->tout_event + (int) ($pialaRows[$key]->sum_piala ?? 0);
        }

        // === Format data untuk chart ===
        $chartMonths = $rows->map(fn($r) => sprintf('%02d-%04d', $r->m, $r->y));
        $chartIn     = $rows->pluck('tin');
        $chartOut    = $rows->pluck('tout');

        // === Kirim ke View ===
        return view('dashboard', compact(
            'totalEvents',
            'totalTicket',
            'totalOut',
            'saldoAkhir',
            'chartMonths',
            'chartIn',
            'chartOut'
        ));
    }
}
