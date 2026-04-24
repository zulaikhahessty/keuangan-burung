<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\KelasLomba;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class EventController extends Controller
{
    /** Halaman SEMARFIN Event: buat event + lihat daftar ringkas */
    public function index()
    {
        $events = Event::orderBy('tanggal', 'desc')->get();
        $saldoAwalDefault = 0; // tidak dipakai lagi, jaga-jaga untuk UI lama
        return view('events', compact('events', 'saldoAwalDefault'));
    }

    /** Simpan Event baru (saldo_awal dipaksa 0) */
    public function store(Request $r)
    {
        $data = $r->validate([
            'tanggal' => 'required|date|unique:events,tanggal',
            'venue'   => 'nullable|string|max:255',
        ]);

        Event::create([
            'tanggal'           => $data['tanggal'],
            'venue'             => $data['venue'] ?? null,
            'saldo_awal'        => 0,
            'total_tiket'       => 0,
            'total_hadiah'      => 0,
            'total_operasional' => 0,
            'saldo_akhir'       => 0,
        ]);

        return redirect()->route('events.index')->with('ok', 'Event berhasil ditambahkan.');
    }

    /** Halaman daftar untuk dikelola (menu “Kelola Event” di sidebar) */
    public function manageIndex(Request $r)
    {
        $q = trim((string) $r->query('q', ''));

        $events = Event::query()
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('venue', 'like', "%{$q}%")
                      ->orWhere('tanggal', 'like', "%{$q}%");
                });
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('events-manage-list', compact('events', 'q'));
    }


    /** Halaman kelola 1 event */
    public function manage(Event $event)
    {
        $event->load([
            'kelasLombas'  => fn ($q) => $q->orderBy('created_at', 'asc'),
            'pengeluarans' => fn ($q) => $q->latest(),
        ]);

        // PENTING: nama view -> resources/views/event-manage.blade.php
        return view('events-manage', compact('event'));
    }
    
    /** Hapus Event */
    public function destroy(Event $event)
    {
        // Hapus entri di kelas lomba dan pengeluaran secara eksplisit (lebih aman)
        $event->kelasLombas()->delete();
        $event->pengeluarans()->delete();

        $tanggal = Carbon::parse($event->tanggal)->translatedFormat('d F Y');
        $venue = $event->venue ? ' di '.$event->venue : '';
        
        $event->delete();

        return redirect()->route('events.index')
                         ->with('ok', "Event pada tanggal **{$tanggal}**{$venue} berhasil dihapus.");
    }

    /** Hitung ulang ringkasan event */
    public static function recomputeEvent(int $eventId): void
    {
        // Ambil total tiket, hadiah, dan piala dari semua kelas lomba
        $sumKelas = KelasLomba::where('event_id', $eventId)
            ->selectRaw('
                COALESCE(SUM(total_tiket), 0)   AS sum_tiket,
                COALESCE(SUM(total_hadiah), 0)  AS sum_hadiah,
                COALESCE(SUM(jumlah_piala), 0)  AS sum_piala
            ')
            ->first();

        // Ambil total pengeluaran operasional
        $sumOps = (int) Pengeluaran::where('event_id', $eventId)->sum('jumlah');

        // Jika event ditemukan, lakukan pembaruan
        if ($event = Event::find($eventId)) {
            $event->saldo_awal          = 0; // aturan baru: saldo awal selalu 0
            $event->total_tiket         = (int) $sumKelas->sum_tiket;
            $event->total_hadiah        = (int) $sumKelas->sum_hadiah;
            $event->total_operasional   = $sumOps;

            // total pengeluaran termasuk piala dari kelas lomba
            $totalPengeluaran = $event->total_hadiah + (int) $sumKelas->sum_piala + $event->total_operasional;
            $event->saldo_akhir = $event->total_tiket - $totalPengeluaran;

            $event->save();
        }
    }


    /** (Opsional) endpoint lama: sekarang selalu 0 */
    public function lastBalance(Request $r)
    {
        return response()->json(['saldo_awal' => 0]);
    }

    /** Export Excel/PDF (sudah diubah agar nama file kustom) */
    public function export(Event $event, Request $request)
    {
        $format      = $request->query('format', 'xlsx');
        $orientation = $request->query('orientation', 'portrait');
        $compact     = (bool) $request->query('compact', false);
        $maxPrizeReq = (int) $request->query('max_prize', 0);

        $event->load(['kelasLombas', 'pengeluarans']);

        // --- LOGIKA PEMBUATAN NAMA FILE KUSTOM ---
        // Format tanggal: YYYY-MM-DD
        $tanggal_format = Carbon::parse($event->tanggal)->format('Y-m-d');
        
        // Bersihkan venue (ganti spasi dengan strip, hapus karakter khusus)
        // Tambahkan strip di awal agar mudah disambung jika tidak kosong
        $venue = (string) $event->venue;
        $venue_clean = !empty($venue) 
            ? '-' . preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '-', $venue))
            : '';

        // Buat nama file kustom: Laporan-Event-YYYY-MM-DD-Venue
        $fileName = 'Laporan-Event-' . $tanggal_format . $venue_clean;
        // --- AKHIR LOGIKA PEMBUATAN NAMA FILE KUSTOM ---

        $classes = $event->kelasLombas->map(function ($k) {
            if (is_null($k->total_tiket) || is_null($k->total_hadiah) || is_null($k->laba_bersih)) {
                $k->recomputeTotals();
            }
            $hadiah = [];
            for ($i=1; $i<=10; $i++) {
                $val = (int) ($k->{"hadiah_{$i}"} ?? 0);
                if ($val > 0) $hadiah[] = ['juara' => $i, 'nominal' => $val];
            }
            $totalTiket  = (int) ($k->total_tiket ?? 0);
            $totalHadiah = (int) ($k->total_hadiah ?? 0);

            return [
                'nama'         => (string) ($k->nama_kelas ?? ''),
                'tiket'        => (int) ($k->harga_tiket ?? 0),
                'gantang'      => (int) ($k->jumlah_peserta ?? 0),
                'total_tiket'  => $totalTiket,
                'hadiah'       => $hadiah,
                'total_hadiah' => $totalHadiah,
                'piala'        => (int) ($k->jumlah_piala ?? 0),
                'sisa_piala'   => null,
                'sisa_tiket'   => max(0, $totalTiket - $totalHadiah),
                'lain'         => null,
                'keterangan'   => null,
            ];
        })->values();

        $maxPrizeCols = max(1, (int) ($classes->map(fn($c) => count($c['hadiah']))->max() ?? 1));
        if ($maxPrizeReq > 0) $maxPrizeCols = max(1, min($maxPrizeCols, $maxPrizeReq));
        $maxPrizeCols = min(10, $maxPrizeCols);

        $saldoAwal   = 0;
        $totalTicket = (int) $classes->sum('total_tiket');
        $totalPrize  = (int) $classes->sum('total_hadiah');
        $opsExpenses = $event->pengeluarans->map(fn($p) => ['nama'=>$p->uraian,'jumlah'=>(int)$p->jumlah])->values();
        $totalOps    = (int) $opsExpenses->sum('jumlah');
        $saldoAkhir  = (int) ($event->saldo_akhir ?? ($totalTicket - $totalPrize - $totalOps));

        $payload = [
            'event'          => $event,
            'saldoAwal'      => $saldoAwal,
            'totalTicket'    => $totalTicket,
            'totalPrize'     => $totalPrize,
            'opsExpenses'    => $opsExpenses,
            'totalOps'       => $totalOps,
            'saldoAkhir'     => $saldoAkhir,
            'classes'        => $classes,
            'maxPrizeCols'   => $maxPrizeCols,
            'meta'           => [
                'judul'          => 'Laporan Operasional Event',
                'tanggal_text'   => Carbon::parse($event->tanggal)->translatedFormat('l, d F Y'),
                'kategori'       => 'REGULER',
            ],
            'options' => ['compact' => $compact, 'orientation' => $orientation],
            'totalOut' => $totalOps,
        ];

        if ($format === 'xlsx') {
            // Menggunakan $fileName kustom
            return Excel::download(new EventExport($payload), "{$fileName}.xlsx");
        }

        if ($format === 'pdf') {
            $paperOrientation = in_array(strtolower($orientation), ['portrait','landscape'], true) ? strtolower($orientation) : 'portrait';
            $pdf = Pdf::loadView('exports.event_pdf', $payload)->setPaper('a4', $paperOrientation);
            // Menggunakan $fileName kustom
            return $pdf->download("{$fileName}.pdf");
        }

        abort(404);
    }
}
