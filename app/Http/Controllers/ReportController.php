<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Daftar semua event: aksi = PDF/XLSX
    public function index(Request $r)
    {
        $q = trim((string) $r->query('q', ''));
        $events = Event::query()
            ->when($q !== '', fn($w) => $w->where('venue','like',"%$q%")
                                          ->orWhere('tanggal','like',"%$q%"))
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('reports', compact('events','q'));
    }

    // Ekspor laporan rinci “operasional” ala contoh PDF
    public function export(Event $event, Request $request)
    {
        $format      = $request->query('format','pdf'); // default pdf
        $orientation = $request->query('orientation','portrait');
        $maxPrize    = (int) $request->query('max_prize', 10); // kolom hadiah maksimum

        $event->load(['kelasLombas', 'pengeluarans']);

        // Normalisasi data kelas (tiket, peserta, hadiah1..10, piala, sisa_tiket)
        $classes = $event->kelasLombas->map(function($k) use ($maxPrize){
            // pastikan turunan sudah ada
            if (is_null($k->total_tiket) || is_null($k->total_hadiah) || is_null($k->laba_bersih)) {
                if (method_exists($k,'recomputeTotals')) $k->recomputeTotals();
                else {
                    $k->total_tiket = (int)$k->harga_tiket * (int)$k->jumlah_peserta;
                    $tot = 0; for($i=1;$i<=10;$i++) $tot += (int)($k->{"hadiah_$i"} ?? 0);
                    $k->total_hadiah = $tot;
                    $k->laba_bersih  = $k->total_tiket - $k->total_hadiah;
                }
            }
            $hadiah = [];
            for($i=1;$i<=min(10,$maxPrize);$i++){
                $hadiah[$i] = (int)($k->{"hadiah_$i"} ?? 0);
            }
            return [
                'nama'         => (string) $k->nama_kelas,
                'tiket'        => (int) $k->harga_tiket,
                'gantang'      => (int) $k->jumlah_peserta,
                'total_tiket'  => (int) $k->total_tiket,
                'hadiah'       => $hadiah,                 // array index 1..N
                'total_hadiah' => (int) $k->total_hadiah,
                'piala'        => (int) ($k->jumlah_piala ?? 0),
                'sisa_tiket'   => max(0, (int)$k->total_tiket - (int)$k->total_hadiah),
                'lain'         => null,
                'keterangan'   => null,
            ];
        });

        $ops = $event->pengeluarans->map(fn($p)=>['uraian'=>$p->uraian,'jumlah'=>(int)$p->jumlah]);
        $totalOps = (int) $ops->sum('jumlah');

        $totTiket  = (int) $classes->sum('total_tiket');
        $totHadiah = (int) $classes->sum('total_hadiah');
        $saldoAkhir= $totTiket - $totHadiah - $totalOps;

        $payload = [
            'event'      => $event,
            'classes'    => $classes,
            'ops'        => $ops,
            'totTiket'   => $totTiket,
            'totHadiah'  => $totHadiah,
            'totalOps'   => $totalOps,
            'saldoAkhir' => $saldoAkhir,
            'maxPrize'   => min(10, max(1, $classes->map(fn($c)=>count($c['hadiah']))->max() ?? 5)),
        ];

        if ($format === 'pdf') {
    // 🔹 Buat nama file dinamis dan rapi
    $eventName = \Illuminate\Support\Str::slug($event->venue ?: $event->nama_event ?? 'event', '_');
    $eventDate = \Carbon\Carbon::parse($event->tanggal)->format('d-m-Y');
    $fileName  = "Laporan_{$eventName}_{$eventDate}.pdf";

    $pdf = Pdf::loadView('exports.event_pdf_detailed', $payload)
              ->setPaper('a4', in_array($orientation, ['portrait','landscape']) ? $orientation : 'portrait');

    // 🔹 Unduh dengan nama file baru
    return $pdf->download($fileName);
}

        if ($format === 'xlsx') {
            // kalau kamu sudah punya EventExport lama, boleh buat export khusus ReportExport;
            // sementara ini arahkan ke export lama jika sudah mencakup kolom ini.
            return redirect()->route('events.export', ['event'=>$event->id, 'format'=>'xlsx']);
        }

        abort(404);
    }
}
